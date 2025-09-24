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
                'price' => 65000,
                'image_url' => 'https://picsum.photos/200/300?random=3',
                'is_active' => true,
            ],
            [
                'name' => 'Madu Kelengkeng 500ml',
                'slug' => Str::slug('Madu Kelengkeng 500ml'),
                'description' => 'Madu murni dari bunga kelengkeng, rasa manis khas.',
                'category_id' => 1,
                'brand' => 'Madu Asli',
                'image_url' => 'https://picsum.photos/200/300?random=2',
                'price' => 65000,
                'is_active' => true,
            ],
            [
                'name' => 'Madu Multiflora 1L',
                'slug' => Str::slug('Madu Multiflora 1L'),
                'description' => 'Madu dari berbagai jenis bunga, cocok untuk kesehatan harian.',
                'category_id' => 1,
                'brand' => 'Madu Asli',
                'image_url' => 'https://picsum.photos/200/300?random=1',
                'price' => 65000,
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
