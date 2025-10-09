<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data kategori yang akan dimasukkan (sesuai gambar)
        $categories = [
            // Kolom 1 | Kolom 2 | Kolom 3 (asumsi is_active)
            ['name' => 'Madu', 'slug' => 'madu', 'is_active' => 1],
            ['name' => 'Snack', 'slug' => 'snack', 'is_active' => 1],
            ['name' => 'Kosmetik', 'slug' => 'cosmetic', 'is_active' => 1],
            ['name' => 'Minuman', 'slug' => 'minuman', 'is_active' => 1],
            ['name' => 'Parcel', 'slug' => 'parcel', 'is_active' => 0], // Catatan: is_active 0
            ['name' => 'Hampers', 'slug' => 'hampers', 'is_active' => 1],
            ['name' => 'Paket Sehat Keluarga', 'slug' => 'paket-sehat-keluarga', 'is_active' => 0], // Catatan: is_active 0
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                // Kunci pencarian: slug
                ['slug' => $categoryData['slug']], 
                // Data yang akan di-update/dimasukkan
                [
                    'name' => $categoryData['name'], 
                    'is_active' => $categoryData['is_active']
                ]
            );
        }
        
        // Pilihan lain: Hanya untuk satu item pertama (seperti kode Anda sebelumnya)
        /*
        Category::updateOrCreate(
            ['slug' => 'madu'],
            ['name' => 'Madu', 'is_active' => true]
        );
        */
    }
}
