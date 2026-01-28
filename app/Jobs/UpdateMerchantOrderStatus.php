<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;
use App\Models\MerchantOrder;
use App\Models\IntegrationLog;
use App\Services\Integration\IntegrationManager;
use Illuminate\Support\Facades\Log;

class UpdateMerchantOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     * Hostinger might fail outgoing requests temporarily, so retry is good.
     */
    public $tries = 3;

    public function __construct(
        public Order $order,
        public string $action // accept, ready, reject
    ) {}

    public function handle(IntegrationManager $manager): void
    {
        // 1. Check if this is a Merchant Order
        $merchantOrder = MerchantOrder::with('integration.merchant', 'integration.credential')
            ->where('order_id', $this->order->id)
            ->first();

        if (!$merchantOrder) {
            // Not a merchant order, ignore
            return;
        }

        $integration = $merchantOrder->integration;
        
        try {
            // 2. Get Provider
            $provider = $manager->make($integration);
            
            // 3. Call API
            $success = $provider->updateOrderStatus(
                $merchantOrder->external_order_id, 
                $this->action
            );

            // 4. Log Result
            IntegrationLog::create([
                'integration_id' => $integration->id,
                'type' => 'outbound',
                'endpoint' => "UpdateStatus: {$this->action}",
                'status_code' => $success ? 200 : 500,
                'request_payload' => json_encode(['action' => $this->action, 'order_id' => $merchantOrder->external_order_id]),
                'error_message' => $success ? null : 'Failed to update status on platform'
            ]);

            if (!$success) {
                throw new \Exception("Platform returned error.");
            }

        } catch (\Exception $e) {
            Log::error("Failed to update merchant order status: " . $e->getMessage());
            $this->fail($e);
        }
    }
}
