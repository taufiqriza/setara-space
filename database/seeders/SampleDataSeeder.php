<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Dimsum Original', 'icon' => 'fas fa-bowl-food', 'color' => 'golden', 'sort_order' => 1],
            ['name' => 'Dimsum Keju', 'icon' => 'fas fa-cheese', 'color' => 'amber', 'sort_order' => 2],
            ['name' => 'Dimsum Pedas', 'icon' => 'fas fa-pepper-hot', 'color' => 'red', 'sort_order' => 3],
            ['name' => 'Dimsum Mentai', 'icon' => 'fas fa-fire', 'color' => 'orange', 'sort_order' => 4],
            ['name' => 'Wonton', 'icon' => 'fas fa-bowl-rice', 'color' => 'space', 'sort_order' => 5],
            ['name' => 'Hidangan Lain', 'icon' => 'fas fa-utensils', 'color' => 'yellow', 'sort_order' => 6],
            ['name' => 'Paket', 'icon' => 'fas fa-box-open', 'color' => 'space', 'sort_order' => 7],
            ['name' => 'Minuman', 'icon' => 'fas fa-mug-hot', 'color' => 'blue', 'sort_order' => 8],
        ];

        foreach ($categories as $cat) {
            $cat['slug'] = \Illuminate\Support\Str::slug($cat['name']);
            Category::create($cat);
        }

        // Get all images from storage/app/public/products
        $productImages = [];
        $files = glob(storage_path('app/public/products/*'));
        foreach ($files as $file) {
            $productImages[] = 'products/' . basename($file);
        }

        // Create Products
        $products = [
            // Dimsum Original
            ['category' => 'Dimsum Original', 'name' => 'Dimsum Ayam Original', 'description' => 'Dimsum ayam dengan kulit tipis lembut, isian daging ayam juicy.', 'price' => 15000, 'is_favorite' => true],
            ['category' => 'Dimsum Original', 'name' => 'Dimsum Udang', 'description' => 'Dimsum isian udang segar pilihan.', 'price' => 18000, 'is_favorite' => false],
            ['category' => 'Dimsum Original', 'name' => 'Dimsum Ayam Jamur', 'description' => 'Dimsum ayam dengan campuran jamur yang lezat.', 'price' => 16000, 'is_favorite' => false],
            ['category' => 'Dimsum Original', 'name' => 'Siomay Ikan', 'description' => 'Siomay dengan isian ikan tenggiri segar.', 'price' => 14000, 'is_favorite' => false],
            
            // Dimsum Keju
            ['category' => 'Dimsum Keju', 'name' => 'Dimsum Keju Goreng', 'description' => 'Dimsum goreng dengan lelehan keju di dalamnya.', 'price' => 17000, 'is_favorite' => true],
            ['category' => 'Dimsum Keju', 'name' => 'Dimsum Keju Mozarella', 'description' => 'Dimsum premium dengan keju mozarella stretchy.', 'price' => 20000, 'is_favorite' => false],
            ['category' => 'Dimsum Keju', 'name' => 'Cheesy Dumpling', 'description' => 'Dumpling dengan saus keju special.', 'price' => 19000, 'is_favorite' => false],
            
            // Dimsum Pedas
            ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Pedas', 'description' => 'Dimsum dengan level pedas yang nendang!', 'price' => 16000, 'is_favorite' => true],
            ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 2', 'description' => 'Dimsum dengan level pedas sedang.', 'price' => 16000, 'is_favorite' => false],
            ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 3', 'description' => 'Dimsum dengan level pedas ekstrim!', 'price' => 17000, 'is_favorite' => false],
            ['category' => 'Dimsum Pedas', 'name' => 'Spicy Wonton', 'description' => 'Wonton dengan saus pedas khas Sichuan.', 'price' => 18000, 'is_favorite' => false],
            
            // Dimsum Mentai
            ['category' => 'Dimsum Mentai', 'name' => 'Dimsum Mentai Original', 'description' => 'Dimsum dengan topping saus mentai creamy.', 'price' => 22000, 'is_favorite' => true],
            ['category' => 'Dimsum Mentai', 'name' => 'Dimsum Mentai Keju', 'description' => 'Dimsum mentai dengan extra topping keju leleh.', 'price' => 25000, 'is_favorite' => false],
            ['category' => 'Dimsum Mentai', 'name' => 'Mentai Salmon Roll', 'description' => 'Roll dimsum dengan salmon dan saus mentai.', 'price' => 28000, 'is_favorite' => false],
            
            // Wonton
            ['category' => 'Wonton', 'name' => 'Wonton Kuah', 'description' => 'Wonton dengan kuah kaldu ayam gurih.', 'price' => 15000, 'is_favorite' => false],
            ['category' => 'Wonton', 'name' => 'Wonton Goreng (5pcs)', 'description' => 'Wonton goreng crispy, cocok untuk snacking.', 'price' => 12000, 'is_favorite' => false],
            ['category' => 'Wonton', 'name' => 'Wonton Frozen (10pcs)', 'description' => 'Paket wonton frozen untuk dibawa pulang.', 'price' => 25000, 'is_favorite' => false],

            // Hidangan Lain
            ['category' => 'Hidangan Lain', 'name' => 'Mie Dimsum', 'description' => 'Mie kuah dengan topping dimsum dan chili oil.', 'price' => 18000, 'is_favorite' => false],
            ['category' => 'Hidangan Lain', 'name' => 'Lumpia Goreng', 'description' => 'Lumpia crispy dengan isian sayur dan daging.', 'price' => 12000, 'is_favorite' => false],
            
            // Paket
            ['category' => 'Paket', 'name' => 'Paket Komplit', 'description' => 'Paket lengkap berbagai varian dimsum favorit!', 'price' => 45000, 'is_favorite' => false],
            
            // Minuman
            ['category' => 'Minuman', 'name' => 'Es Teh Manis', 'description' => 'Teh manis dingin segar.', 'price' => 5000, 'is_favorite' => false],
            ['category' => 'Minuman', 'name' => 'Es Jeruk', 'description' => 'Jeruk peras segar dengan es.', 'price' => 8000, 'is_favorite' => false],
            ['category' => 'Minuman', 'name' => 'Lemon Tea', 'description' => 'Teh lemon menyegarkan.', 'price' => 10000, 'is_favorite' => false],
            ['category' => 'Minuman', 'name' => 'Air Mineral', 'description' => 'Air mineral kemasan.', 'price' => 4000, 'is_favorite' => false],
        ];

        foreach ($products as $index => $prod) {
            $category = Category::where('name', $prod['category'])->first();
            
            // Assign random image from available images if not Minuman
            $image = null;
            if ($prod['category'] !== 'Minuman' && !empty($productImages)) {
                // Use predictable image assignment based on index to keep it consistent across seeds
                $imageIndex = $index % count($productImages);
                $image = $productImages[$imageIndex];
            }

            Product::create([
                'category_id' => $category->id,
                'name' => $prod['name'],
                'slug' => \Illuminate\Support\Str::slug($prod['name']),
                'description' => $prod['description'],
                'price' => $prod['price'],
                'image' => $image,
                'is_active' => true,
                'is_favorite' => $prod['is_favorite'] ?? false,
            ]);
        }

        // Create Tables
        for ($i = 1; $i <= 10; $i++) {
            Table::create([
                'name' => 'Table ' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'capacity' => $i <= 4 ? 2 : ($i <= 8 ? 4 : 6),
                'status' => 'available',
                'is_active' => true,
            ]);
        }

        // --- Create Dummy Data for Analytics Demo ---
        
        $admin = \App\Models\User::first() ?? \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // 1. Create dummy Orders (Today)
        $today = \Carbon\Carbon::today();
        for ($i = 0; $i < 15; $i++) {
            $total = rand(50000, 250000);
            \App\Models\Order::create([
                'user_id' => $admin->id,
                'order_number' => 'ORD-' . date('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'customer_name' => 'Customer ' . ($i + 1),
                'order_type' => 'dine_in',
                'status' => 'completed',
                'payment_status' => 'paid',
                'total' => $total,
                'subtotal' => $total,
                'created_at' => $today->copy()->addHours(rand(9, 20)),
                'updated_at' => $today->copy()->addHours(rand(20, 22)),
            ]);

            // Create activity for this order
            \App\Models\Activity::create([
                'user_id' => $admin->id,
                'action' => 'order_placed',
                'description' => "Order #ORD-" . date('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT) . " completed.",
                'properties' => ['amount' => $total, 'items_count' => rand(2, 5)],
                'created_at' => $today->copy()->addHours(rand(9, 20)),
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

            \App\Models\Activity::create([
                'user_id' => $admin->id,
                'action' => $action,
                'description' => $desc,
                'created_at' => $today->copy()->addHours(rand(8, 18)),
            ]);
        }
    }
}
