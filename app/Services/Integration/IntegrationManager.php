<?php

namespace App\Services\Integration;

use App\Services\Integration\Contracts\FoodDeliveryProviderInterface;
use App\Services\Integration\Providers\GoFoodProvider;
use App\Models\MerchantIntegration;
use InvalidArgumentException;

class IntegrationManager
{
    /**
     * Get a provider instance by Merchant slug or Integration ID
     */
    public function getProvider(string|int $identifier): ?FoodDeliveryProviderInterface
    {
        $integration = null;

        if (is_numeric($identifier)) {
            $integration = MerchantIntegration::with(['merchant', 'credential'])->find($identifier);
        } else {
            // Find logic by slug if needed, but usually we handle by Integration ID context
            // For webhook, we might identify by URL param or header
        }

        if (!$integration || !$integration->credential) {
            return null;
        }

        $slug = $integration->merchant->slug;

        return match ($slug) {
            'gofood' => new GoFoodProvider($integration->credential),
            // 'grabfood' => new GrabFoodProvider($integration->credential),
            default => throw new InvalidArgumentException("Provider [{$slug}] not supported."),
        };
    }
    
    /**
     * Get provider by exact Integration Model to save query
     */
    public function make(MerchantIntegration $integration): FoodDeliveryProviderInterface
    {
        if (!$integration->relationLoaded('merchant') || !$integration->relationLoaded('credential')) {
            $integration->load(['merchant', 'credential']);
        }
        
        $slug = $integration->merchant->slug;
        
        return match ($slug) {
            'gofood' => new GoFoodProvider($integration->credential),
            default => throw new InvalidArgumentException("Provider [{$slug}] not supported."),
        };
    }
}
