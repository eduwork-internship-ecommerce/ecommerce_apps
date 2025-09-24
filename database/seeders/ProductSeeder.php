<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Madu Hutan Asli 250ml',
                'slug' => Str::slug('Madu Hutan Asli 250ml'),
                'description' => 'Madu hutan murni, kaya nutrisi dan tanpa campuran.',
                'category_id' => 1, // pastikan category_id=1 ada (misalnya kategori Madu)
                'brand' => 'Madu Asli',
                'image_url' => 'https://via.placeholder.com/300x300.png?text=Madu+Hutan+250ml',
                'is_active' => true,
            ],
            [
                'name' => 'Madu Kelengkeng 500ml',
                'slug' => Str::slug('Madu Kelengkeng 500ml'),
                'description' => 'Madu murni dari bunga kelengkeng, rasa manis khas.',
                'category_id' => 1,
                'brand' => 'Madu Asli',
                'image_url' => 'https://via.placeholder.com/300x300.png?text=Madu+Kelengkeng+500ml',
                'is_active' => true,
            ],
            [
                'name' => 'Madu Multiflora 1L',
                'slug' => Str::slug('Madu Multiflora 1L'),
                'description' => 'Madu dari berbagai jenis bunga, cocok untuk kesehatan harian.',
                'category_id' => 1,
                'brand' => 'Madu Asli',
                'image_url' => 'https://via.placeholder.com/300x300.png?text=Madu+Multiflora+1L',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product
            );
        }
    }
}
