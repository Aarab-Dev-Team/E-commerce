<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category  ;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $categories = [
            ['name' => 'Ceramics', 'description' => 'Handcrafted ceramic pieces'],
            ['name' => 'Glassware', 'description' => 'Minimalist glass objects'],
            ['name' => 'Wood & Stone', 'description' => 'Natural material pieces'],
            ['name' => 'Soft Goods', 'description' => 'Textiles and linens'],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
            ]);
        }
    }
}
