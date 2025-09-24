<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => 'madu'],
            ['name' => 'Madu', 'is_active' => true]
        );
    }
}
