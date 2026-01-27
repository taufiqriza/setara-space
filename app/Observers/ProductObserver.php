<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'product_created',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
            'description' => "Product '{$product->name}' added to inventory.",
            'properties' => [
                'name' => $product->name,
                'price' => $product->price,
                'category' => $product->category->name ?? 'Uncategorized',
            ],
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // Only log if meaningful changes happen
        $changes = [];
        if ($product->wasChanged('price')) {
            $changes['old_price'] = $product->getOriginal('price');
            $changes['new_price'] = $product->price;
        }
        if ($product->wasChanged('is_active')) {
            $changes['status'] = $product->is_active ? 'Active' : 'Inactive';
        }
        if ($product->wasChanged('name')) {
             $changes['name'] = "Renamed from " . $product->getOriginal('name');
        }

        if (count($changes) > 0) {
            Activity::create([
                'user_id' => Auth::id(),
                'action' => 'product_updated',
                'subject_type' => Product::class,
                'subject_id' => $product->id,
                'description' => "Product '{$product->name}' updated.",
                'properties' => $changes,
                'ip_address' => request()->ip(),
            ]);
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Activity::create([
            'user_id' => Auth::id(),
            'action' => 'product_deleted',
            'subject_type' => Product::class,
            'subject_id' => $product->id,
            'description' => "Product '{$product->name}' removed from inventory.",
            'properties' => [
                'name' => $product->name,
            ],
            'ip_address' => request()->ip(),
        ]);
    }
}
