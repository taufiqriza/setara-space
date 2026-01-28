<?php

namespace App\Services\Integration\Providers;

use App\Services\Integration\Contracts\FoodDeliveryProviderInterface;
use App\Models\MerchantCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class GoFoodProvider implements FoodDeliveryProviderInterface
{
    protected $credential;
    protected $baseUrl = 'https://site-api.gofood.co.id'; // Adjust based on environment (Sandbox/Prod)
    // For GoBiz API, some endpoints are different. 
    // GoFood Partner API Base: https://api.gobiz.co.id typically or via Gateway.
    // Auth Endpoint: https://accounts.go-jek.com/oauth2/token

    public function __construct(MerchantCredential $credential)
    {
        $this->credential = $credential;
    }

    public function getSlug(): string
    {
        return 'gofood';
    }

    public function authenticate(): bool
    {
        try {
            $clientId = $this->credential->client_id;
            // client_secret is encrypted accessor
            $clientSecret = $this->credential->client_secret; 
            
            $response = Http::asForm()
                ->withBasicAuth($clientId, $clientSecret)
                ->post('https://accounts.go-jek.com/oauth2/token', [
                    'grant_type' => 'client_credentials'
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->credential->update([
                    'access_token' => $data['access_token'],
                    'token_expiry' => now()->addSeconds($data['expires_in'] - 60) // Buffer 60s
                ]);
                return true;
            }
            
            Log::error('GoFood Auth Failed', ['body' => $response->body()]);
            return false;

        } catch (\Exception $e) {
            Log::error('GoFood Auth Exception: ' . $e->getMessage());
            return false;
        }
    }

    public function verifyWebhook(Request $request): bool
    {
        // GoFood sends X-Go-Signature
        // HMAC-SHA256(relay_secret, raw_body_content)
        
        $signature = $request->header('X-Go-Signature');
        if (!$signature) return false;

        $payload = $request->getContent();
        // Encrypted Relay Secret
        $secret = $this->credential->relay_secret;

        $calculated = hash_hmac('sha256', $payload, $secret);

        return hash_equals($calculated, $signature);
    }

    public function parseOrder(array $payload): array
    {
        // GoFood payload structure usually contains:
        // order_no, booking_id, customer: {name, ...}, driver: {name, ...}, cart: {items: [...]}
        // This logic maps that specific structure to our Standard DTO format.
        
        $items = [];
        if (isset($payload['cart']['items'])) {
            foreach ($payload['cart']['items'] as $item) {
                $items[] = [
                    'sku' => $item['external_id'] ?? null, // Use SKU mapping if available
                    'name' => $item['name'],
                    'qty' => $item['quantity'],
                    'price' => $item['price'],
                    'notes' => $item['notes'] ?? ''
                ];
            }
        }
        
        // Return array compatible with DTO validation
        return [
            'external_id' => $payload['order_no'] ?? $payload['booking_id'], // Order No is usually the key
            'booking_id' => $payload['booking_id'] ?? $payload['order_no'],
            'customer_name' => $payload['customer']['name'] ?? 'Guest',
            'driver_name' => $payload['driver']['name'] ?? 'GoJek Driver',
            'driver_phone' => $payload['driver']['phone_number'] ?? null,
            'driver_plate' => $payload['driver']['vehicle_number'] ?? null,
            'total_amount' => $payload['payment']['total_amount'] ?? 0,
            'items' => $items,
            'notes' => $payload['notes'] ?? null,
            'payment_method' => 'gofood'
        ];
    }

    /**
     * Update order status on GoBiz Platform
     * Actions: confirm, ready, completed, cancel
     */
    public function updateOrderStatus(string $externalOrderId, string $action, ?string $reason = null): bool
    {
        if (!$this->authenticate()) return false;
        
        // Map internal action to GoFood Endpoint
        $endpointMap = [
            'accept' => "/v1/orders/{$externalOrderId}/confirm",
            'ready' => "/v1/orders/{$externalOrderId}/ready",
            // 'reject' => "/v1/orders/{$externalOrderId}/cancel", // Usually requires reason
        ];
        
        if (!isset($endpointMap[$action])) {
            Log::warning("GoFood Action [$action] not supported or mapped.");
            return false;
        }

        $url = $this->baseUrl . $endpointMap[$action];
        $token = Crypt::decryptString($this->credential->access_token);

        $response = Http::withToken($token)->put($url);
        
        return $response->successful();
    }

    public function updateProduct(string $externalProductId, float $price, bool $isAvailable): bool
    {
        // Example implementation for updating price/availability
        // PUT /v1/products/{id}
        if (!$this->authenticate()) return false;

        $url = $this->baseUrl . "/v1/products/{$externalProductId}";
        $token = Crypt::decryptString($this->credential->access_token);

        $response = Http::withToken($token)->put($url, [
            'price' => $price,
            'is_available' => $isAvailable
        ]);
        
        return $response->successful();
    }
}
