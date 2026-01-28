<?php

namespace App\Services\Integration\Contracts;

use Illuminate\Http\Request;

interface FoodDeliveryProviderInterface
{
    /**
     * Get the provider unique slug (e.g. gofood)
     */
    public function getSlug(): string;

    /**
     * Authenticate with the provider API using credentials
     * Returns true on success, false on failure
     */
    public function authenticate(): bool;

    /**
     * Verify the incoming webhook signature
     */
    public function verifyWebhook(Request $request): bool;

    /**
     * Parse the incoming raw order payload into a standardized format
     * Returns a DTO or array
     */
    public function parseOrder(array $payload): array;

    /**
     * Update order status on the provider platform
     * (accept, reject, ready, etc)
     */
    public function updateOrderStatus(string $externalOrderId, string $action, ?string $reason = null): bool;

    /**
     * Sync local product menu/status/price to provider
     */
    public function updateProduct(string $externalProductId, float $price, bool $isAvailable): bool;
}
