<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Premium Fillets',       'description' => 'High-quality tuna fillets packed in olive oil or water'],
            ['name' => 'Light & Chunk Tuna',    'description' => 'Everyday chunk and light tuna varieties'],
            ['name' => 'Flavored & Specialty',  'description' => 'Tuna with tomato, lemon, chili, and other bold flavors'],
            ['name' => 'Bulk & Value Packs',    'description' => 'Large-format and economy canned tuna options'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name'        => $cat['name'],
                    'slug'        => Str::slug($cat['name']),
                    'description' => $cat['description'],
                ]
            );
        }
    }
}
