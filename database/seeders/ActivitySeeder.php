<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        // Truncate tables for fresh data
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Activity::truncate();
        \App\Models\Order::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $admin = User::first() ?? User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // 1. Create dummy Orders 
        // We use Carbon::now() to ensure we don't go into the future from "right now"
        // We will spread them out over the last 12 hours.
        
        for ($i = 0; $i < 15; $i++) {
            $total = rand(50000, 250000);
            
            // Random time within last 12 hours
            $timestamp = Carbon::now()->subMinutes(rand(10, 720)); // 10 mins to 12 hours ago
            
            Order::create([
                'user_id' => $admin->id,
                'order_number' => strtoupper(uniqid('ORD-')),
                'customer_name' => 'Customer ' . ($i + 1),
                'order_type' => 'dine_in',
                'status' => 'completed',
                'payment_status' => 'paid',
                'total' => $total,
                'subtotal' => $total,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);

            // Generate random items for the order
            $itemCount = rand(2, 5);
            $items = [];
            $productNames = [
                'Dimsum Ayam Original', 'Dimsum Udang', 'Dimsum Mozarella', 
                'Wonton Kuah', 'Es Teh Manis', 'Mie Dimsum', 'Lumpia Goreng'
            ];
            
            if (\App\Models\Product::count() > 0) {
                $dbProducts = \App\Models\Product::inRandomOrder()->take($itemCount)->pluck('name');
                if ($dbProducts->isNotEmpty()) {
                    $productNames = $dbProducts->toArray();
                }
            }

            for($j = 0; $j < $itemCount; $j++) {
                $items[] = [
                    'name' => $productNames[array_rand($productNames)],
                    'qty' => rand(1, 4),
                    'price' => rand(15000, 35000)
                ];
            }

            // Create activity for this order
            Activity::create([
                'user_id' => $admin->id,
                'action' => 'order_placed',
                'description' => "Order #ORD-" . date('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT) . " completed.",
                'properties' => [
                    'amount' => $total, 
                    'items_count' => $itemCount,
                    'items' => $items
                ],
                'created_at' => $timestamp, // Same as order
            ]);
        }

        // 2. Stock Adjustments / System Activities
        $actions = ['updated_stock', 'login', 'updated_product'];
        for ($i = 0; $i < 10; $i++) {
            $action = $actions[array_rand($actions)];
            $desc = match($action) {
                'updated_stock' => 'Stock adjusted for product manually.',
                'login' => 'User logged in to the system.',
                'updated_product' => 'Product price updated.',
            };

            Activity::create([
                'user_id' => $admin->id,
                'action' => $action,
                'description' => $desc,
                'created_at' => Carbon::now()->subMinutes(rand(10, 720)),
            ]);
        }
    }
}
