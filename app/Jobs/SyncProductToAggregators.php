<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Product;
use App\Models\MerchantIntegration;
use App\Services\Integration\IntegrationManager;
use Illuminate\Support\Facades\Log;

class SyncProductToAggregators implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2; // Don't retry too much for catalog sync

    public function __construct(
        public Product $product
    ) {}

    public function handle(IntegrationManager $manager): void
    {
        // 1. Get all active integrations
        // In real world, we likely map Product ID to External ID via a pivot table
        // For now, assuming SKU matches External ID or just trying to sync to all
        $integrations = MerchantIntegration::where('is_enabled', true)->get();

        foreach ($integrations as $integration) {
            try {
                $provider = $manager->make($integration);
                
                // Assuming SKU is the link. If product has no SKU, we can't sync easily.
                if (empty($this->product->sku)) continue;

                // 2. Call Update API
                $provider->updateProduct(
                    $this->product->sku, 
                    $this->product->price,
                    $this->product->is_active ?? true
                );

            } catch (\Exception $e) {
                // Just log, don't fail the whole job so other integrations continue
                Log::error("Failed sync product [{$this->product->sku}] to [{$integration->merchant->name}]: " . $e->getMessage());
            }
        }
    }
}
