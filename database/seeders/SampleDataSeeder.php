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
            ['name' => 'Dimsum Original', 'icon' => 'fas fa-bowl-food', 'sort_order' => 1],
            ['name' => 'Dimsum Keju', 'icon' => 'fas fa-cheese', 'sort_order' => 2],
            ['name' => 'Dimsum Pedas', 'icon' => 'fas fa-pepper-hot', 'sort_order' => 3],
            ['name' => 'Dimsum Mentai', 'icon' => 'fas fa-fire', 'sort_order' => 4],
            ['name' => 'Wonton', 'icon' => 'fas fa-bowl-rice', 'sort_order' => 5],
            ['name' => 'Minuman', 'icon' => 'fas fa-mug-hot', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Create Products
        $products = [
            // Dimsum Original
            ['category' => 'Dimsum Original', 'name' => 'Dimsum Ayam Original', 'description' => 'Dimsum ayam dengan kulit tipis lembut, isian daging ayam juicy.', 'price' => 15000],
            ['category' => 'Dimsum Original', 'name' => 'Dimsum Udang', 'description' => 'Dimsum isian udang segar pilihan.', 'price' => 18000],
            ['category' => 'Dimsum Original', 'name' => 'Dimsum Ayam Jamur', 'description' => 'Dimsum ayam dengan campuran jamur yang lezat.', 'price' => 16000],
            ['category' => 'Dimsum Original', 'name' => 'Siomay Ikan', 'description' => 'Siomay dengan isian ikan tenggiri segar.', 'price' => 14000],
            
            // Dimsum Keju
            ['category' => 'Dimsum Keju', 'name' => 'Dimsum Keju Goreng', 'description' => 'Dimsum goreng dengan lelehan keju di dalamnya.', 'price' => 17000],
            ['category' => 'Dimsum Keju', 'name' => 'Dimsum Keju Mozarella', 'description' => 'Dimsum premium dengan keju mozarella stretchy.', 'price' => 20000],
            ['category' => 'Dimsum Keju', 'name' => 'Cheesy Dumpling', 'description' => 'Dumpling dengan saus keju special.', 'price' => 19000],
            
            // Dimsum Pedas
            ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 1', 'description' => 'Dimsum dengan level pedas ringan.', 'price' => 16000],
            ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 2', 'description' => 'Dimsum dengan level pedas sedang.', 'price' => 16000],
            ['category' => 'Dimsum Pedas', 'name' => 'Dimsum Level 3', 'description' => 'Dimsum dengan level pedas ekstrim!', 'price' => 17000],
            ['category' => 'Dimsum Pedas', 'name' => 'Spicy Wonton', 'description' => 'Wonton dengan saus pedas khas Sichuan.', 'price' => 18000],
            
            // Dimsum Mentai
            ['category' => 'Dimsum Mentai', 'name' => 'Dimsum Mentai Original', 'description' => 'Dimsum dengan topping saus mentai creamy.', 'price' => 22000],
            ['category' => 'Dimsum Mentai', 'name' => 'Dimsum Mentai Keju', 'description' => 'Dimsum mentai dengan extra topping keju leleh.', 'price' => 25000],
            ['category' => 'Dimsum Mentai', 'name' => 'Mentai Salmon Roll', 'description' => 'Roll dimsum dengan salmon dan saus mentai.', 'price' => 28000],
            
            // Wonton
            ['category' => 'Wonton', 'name' => 'Wonton Kuah', 'description' => 'Wonton dengan kuah kaldu ayam gurih.', 'price' => 15000],
            ['category' => 'Wonton', 'name' => 'Wonton Goreng (5pcs)', 'description' => 'Wonton goreng crispy, cocok untuk snacking.', 'price' => 12000],
            ['category' => 'Wonton', 'name' => 'Wonton Frozen (10pcs)', 'description' => 'Paket wonton frozen untuk dibawa pulang.', 'price' => 25000],
            
            // Minuman
            ['category' => 'Minuman', 'name' => 'Es Teh Manis', 'description' => 'Teh manis dingin segar.', 'price' => 5000],
            ['category' => 'Minuman', 'name' => 'Es Jeruk', 'description' => 'Jeruk peras segar dengan es.', 'price' => 8000],
            ['category' => 'Minuman', 'name' => 'Lemon Tea', 'description' => 'Teh lemon menyegarkan.', 'price' => 10000],
            ['category' => 'Minuman', 'name' => 'Air Mineral', 'description' => 'Air mineral kemasan.', 'price' => 4000],
        ];

        foreach ($products as $prod) {
            $category = Category::where('name', $prod['category'])->first();
            Product::create([
                'category_id' => $category->id,
                'name' => $prod['name'],
                'description' => $prod['description'],
                'price' => $prod['price'],
                'is_active' => true,
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
    }
}
