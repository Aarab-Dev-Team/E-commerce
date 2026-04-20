<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category ; 
use App\Models\Product ; 

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        // Ensure categories exist first
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::all();
        
        $products = [
            [
        'name' => 'Minimal Glass Carafe',
        'description' => 'Hand-blown glass carafe with a clean silhouette. Designed for both functionality and visual clarity on the table.',
        'price' => 85.00,
        'origin' => 'Copenhagen',
        'material' => 'Glass',
        'color' => 'Clear',
    ],
    [
        'name' => 'Wooden Serving Tray',
        'description' => 'Crafted from solid oak, this tray highlights natural grain patterns and a smooth, durable finish.',
        'price' => 120.00,
        'origin' => 'Local Studio',
        'material' => 'Oak Wood',
        'color' => 'Natural Brown',
    ],
    [
        'name' => 'Stone Tea Set',
        'description' => 'A refined tea set carved from natural stone, offering a tactile and grounded tea experience.',
        'price' => 210.00,
        'origin' => 'Kyoto',
        'material' => 'Stone',
        'color' => 'Muted Grey',
    ],
    [
        'name' => 'Linen Table Runner',
        'description' => 'Soft linen runner with subtle texture, ideal for adding warmth and simplicity to dining settings.',
        'price' => 60.00,
        'origin' => 'Copenhagen',
        'material' => 'Linen',
        'color' => 'Off White',
    ],
    [
        'name' => 'Clay Dinner Plate',
        'description' => 'Hand-shaped clay plate with a slightly irregular edge, celebrating imperfection and craftsmanship.',
        'price' => 40.00,
        'origin' => 'Local Studio',
        'material' => 'Clay',
        'color' => 'Earth Brown',
    ],
    [
        'name' => 'Glass Pendant Light',
        'description' => 'Elegant hanging light with a translucent glass shade, diffusing soft ambient light.',
        'price' => 175.00,
        'origin' => 'Copenhagen',
        'material' => 'Glass',
        'color' => 'Smoked Grey',
    ],
    [
        'name' => 'Carved Stone Bowl',
        'description' => 'Heavy stone bowl carved by hand, perfect as a centerpiece or functional serving piece.',
        'price' => 95.00,
        'origin' => 'Kyoto',
        'material' => 'Stone',
        'color' => 'Dark Ash',
    ],
    [
        'name' => 'Wool Cushion Cover',
        'description' => 'Soft woven wool cover with a minimalist pattern, bringing comfort and texture to interiors.',
        'price' => 70.00,
        'origin' => 'Local Studio',
        'material' => 'Wool',
        'color' => 'Muted Beige',
    ],
        ];

        foreach ($products as $productData) {
            $category = $categories->random();
            
            $images = $this->generateMockImages($productData['name']);
            
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock_quantity' => rand(5, 50),
                'category_id' => $category->id,
                'origin' => $productData['origin'],
                'color' => $productData['color'],
                'material' => $productData['material'],
                'images' => $images,
                'is_active' => true,
            ]);
        }
    }

    /**
     * Generate mock image URLs for a product.
     * Returns a JSON array of image URLs.
     */
    private function generateMockImages(string $productName): array
    {
        // Use specific Picsum image IDs based on product name hash to keep consistency
        $hash = crc32($productName);
        
        // Generate 3 images: main, detail, context
        $imageIds = [
            abs($hash) % 1000,              // Main image
            (abs($hash) + 100) % 1000,      // Detail shot
            (abs($hash) + 200) % 1000,      // Context shot
        ];
        
        $images = [];
        foreach ($imageIds as $id) {
            // Using Picsum with specific ID for consistent images
            // Dimensions: 600x800 (portrait) suitable for product cards
            $images[] = "https://picsum.photos/id/{$id}/600/800";
        }
        
        return $images;
    }
}
