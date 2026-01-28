<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchants = [
            [
                'slug' => 'gofood',
                'name' => 'GoFood',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Gofood_logo.svg/2560px-Gofood_logo.svg.png',
                'status' => 'inactive' // Start inactive, user must enable
            ],
            [
                'slug' => 'grabfood',
                'name' => 'GrabFood',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Grab_logo.svg/1200px-Grab_logo.svg.png',
                'status' => 'coming_soon'
            ],
            [
                'slug' => 'shopeefood',
                'name' => 'ShopeeFood',
                'logo_url' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/Shopee_logo.svg/2560px-Shopee_logo.svg.png',
                'status' => 'coming_soon'
            ],
        ];

        foreach ($merchants as $data) {
            \App\Models\Merchant::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
