<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Services\Integration\IntegrationManager;
use App\Services\Integration\DTO\StandardOrderDTO;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MerchantOrder;
use App\Models\IntegrationLog;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $manager;

    public function __construct(IntegrationManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(Request $request, $slug)
    {
        $payload = $request->getContent();
        
        // 1. Identify Provider
        $merchant = Merchant::where('slug', $slug)->firstOrFail();
        
        // Find FIRST enabled integration for this merchant (Assuming single outlet for now per merchant slug logic)
        // In multi-outlet scenario, we should look at the payload to find store_id/outlet_id
        $integration = $merchant->integrations()->where('is_enabled', true)->first();
        
        if (!$integration) {
            return response()->json(['message' => 'Integration disabled'], 404);
        }

        // 2. Logging Inbound
        IntegrationLog::create([
            'integration_id' => $integration->id,
            'type' => 'inbound',
            'endpoint' => $request->url(),
            'request_payload' => $payload,
            'ip_address' => $request->ip()
        ]);

        // 3. Verify Signature
        $provider = $this->manager->make($integration);
        if (!$provider->verifyWebhook($request)) {
             Log::warning("Integration Signature Failed: {$slug}");
             return response()->json(['message' => 'Invalid Signature'], 401);
        }

        // 4. Parse Order
        try {
            $data = json_decode($payload, true);
            
            // GoFood Cancellation
            if (isset($data['status']) && $data['status'] === 'cancelled') {
                 $this->handleCancellation($integration, $data);
                 return response()->json(['message' => 'Cancellation processed']);
            }
            
            // Standard New Order
            $dtoData = $provider->parseOrder($data);
            $dto = StandardOrderDTO::fromArray($dtoData);

        } catch (\Exception $e) {
            Log::error("Integration Parse Error: " . $e->getMessage());
            return response()->json(['message' => 'Parse Error'], 400);
        }

        // 5. Idempotency Check
        if (MerchantOrder::where('external_order_id', $dto->external_id)->exists()) {
            return response()->json(['message' => 'Already processed']);
        }

        // 6. Create Internal Order
        \DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => 'INT-' . substr($dto->external_id, -6) . '-' . time(),
                'status' => 'pending', // Pending kitchen
                'payment_status' => 'paid', // Already paid to Platform
                'payment_method' => $dto->payment_method,
                'subtotal' => $dto->total_amount, // Simplified
                'tax' => 0,
                'discount' => 0,
                'total' => $dto->total_amount,
                'notes' => "Integrated from {$merchant->name}. " . $dto->notes
            ]);

            foreach ($dto->items as $item) {
                // Try to find product by SKU (external_id) or Name Fuzzy
                $product = null;
                if ($item['sku']) {
                    $product = Product::where('sku', $item['sku'])->first();
                }
                
                // Fallback: This is risky but needed if SKU not mapped
                if (!$product) {
                     $product = Product::where('name', 'LIKE', $item['name'])->first();
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product ? $product->id : null, // Null if generic
                    'product_name' => $item['name'], // Always keep original name
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'cost_price' => $product ? $product->cost_price : 0,
                    'subtotal' => $item['qty'] * $item['price'],
                    'notes' => $item['notes']
                ]);
            }
            
            // 7. Link Merchant Order
            MerchantOrder::create([
                'order_id' => $order->id,
                'integration_id' => $integration->id,
                'external_order_id' => $dto->external_id,
                'booking_id' => $dto->booking_id,
                'driver_name' => $dto->driver_name,
                'driver_phone' => $dto->driver_phone,
                'driver_plate' => $dto->driver_plate,
                'raw_payload' => $data
            ]);

            \DB::commit();

            // 8. Auto-Accept Logic (Phase 3 Prep)
            if ($integration->auto_accept) {
                // Dispatch Job to Accept Order in Background
                // UpdateMerchantOrderStatus::dispatch($order, 'accept');
                $provider->updateOrderStatus($dto->external_id, 'accept');
                $order->update(['status' => 'processing']);
            }
            
            // Fire Livewire Event for Notifications
            \App\Events\OrderReceived::dispatch($order);

            return response()->json(['message' => 'Order created']);

        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error("Integration Global Error: " . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    protected function handleCancellation($integration, $data)
    {
        $externalId = $data['order_no'] ?? $data['booking_id'];
        $merchantOrder = MerchantOrder::where('external_order_id', $externalId)
            ->where('integration_id', $integration->id)
            ->first();

        if ($merchantOrder) {
            $merchantOrder->order->update(['status' => 'cancelled']);
        }
    }
}
