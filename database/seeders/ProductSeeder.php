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
        // 1. Ensure categories exist first
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::all();

        // 2. Words to make 50 different English names
        $brands = ['Ocean Blue', 'Sea King', 'Marine Catch', 'Fishery Choice', 'Deep Water', 'Golden Tuna', 'Atlantic Star'];
        $types = ['Solid White Tuna', 'Chunk Light Tuna', 'Premium Tuna Fillets', 'Skipjack Tuna', 'Yellowfin Tuna'];
        $liquids = ['in Extra Virgin Olive Oil', 'in Spring Water', 'in Sunflower Oil', 'in Salt Brine', 'with Tomato Sauce', 'with Lemon & Pepper', 'with Spicy Chili'];
        $materials = ['Metal Tin Can', 'Aluminum Can', 'Easy-Open Tin'];
        $origins = ['Morocco', 'Spain', 'Italy', 'Thailand', 'Japan', 'Portugal'];

        // 3. Pictures of ONLY metal cans and tins (High Quality)
        $canImages = [
            'https://m.media-amazon.com/images/I/51zZT6BOI4L._SX300_SY300_QL70_FMwebp_.jpg',
            'https://safecatch.com/wp-content/uploads/elite-wild-tuna-garlic-herb-pouch-front.png',
            'https://e-xportmorocco.com/storage/produits/1734341903.png',
            'https://naturalcatchtuna.com/cdn/shop/files/White_Albacore_Water_00005_536bc0aa-87a8-4df3-9ab2-52b544df7c5a@2x.jpg?v=1762268624',
            'https://www.centurypacific.com.ph/wp-content/uploads/2020/12/Premium-Red-Chunks-in-Water.png',
            'https://www.centurypacific.com.ph/wp-content/uploads/2020/11/CT_Afritada_155g-300x300-1.png' , 
            'https://www.centurypacific.com.ph/wp-content/uploads/2020/11/Century-Tuna-Chunks-in-Water-1705kg-TykeTN6ij4-1536x1536.jpg' , 
            'https://brunswick.ca/wp-content/uploads/2024/03/TUNA-Chunk-in-Water-1.88-Kg.png',
            "https://i5.walmartimages.com/seo/Tonnino-Premium-Yellowfin-Tuna-Fillet-in-Olive-Oil-6-7-oz-Jar-Wild-Caught_8897c750-4ea9-44ac-9f0b-e4e2576325da.2e33f79e7159679f6a54a8542dc6758c.jpeg?odnHeight=573&odnWidth=573&odnBg=FFFFFF" , 
            "https://www.marmara.de/Uploads/yeni%20%C3%BCr%C3%BCnler22/k/ton-baligi-sade.jpg" , 
            "https://sitecore-web-prod.simplot-cdn.com/-/media/project/sapl/brands/australia/johnwest/product/tuna/classic-tuna/jw-web-duplicate-036-transform.png?h=4080&iar=0&w=4080&rev=b04cf8ef108d434c9c2c99283a1db918" , 
            "https://sitecore-web-prod.simplot-cdn.com/-/media/project/sapl/brands/australia/johnwest/product/tuna/yellowfin-tuna/jw-npi-yellowfin-italian-style-oil-can-label-transform.png?h=4000&iar=0&w=4000&rev=587540ecc6d0485eb8c888b08bc33698" ,
            "https://sitecore-web-prod.simplot-cdn.com/-/media/project/sapl/brands/australia/johnwest/product/tuna/tuna-slices/09300462340401_c1l1_3d-transform.png?h=3550&iar=0&w=3550&rev=710baf208f6e4f15aa42bfaaf88be689",
        ];

        // 4. Loop exactly 50 times to create 50 products
        for ($i = 1; $i <= 50; $i++) {
            // Pick random words to make a unique product
            $brand = $brands[array_rand($brands)];
            $type = $types[array_rand($types)];
            $liquid = $liquids[array_rand($liquids)];
            
            $productName = "$brand - $type $liquid";
            $description = "High quality $type packed $liquid. Sourced directly from the best oceans and packed in a secure tin can. Perfect for your daily meals. Product ID number $i.";
            
            // Pick exactly 3 random pictures from the cans list
            $randomImageKeys = array_rand($canImages, 3);
            $productImages = [
                $canImages[$randomImageKeys[0]],
                $canImages[$randomImageKeys[1]],
                $canImages[$randomImageKeys[2]],
            ];

            $category = $categories->random();

            // Save to database
            Product::create([
                'name' => $productName,
                'slug' => Str::slug($productName) . '-' . $i, // Added -$i to make sure every URL is unique
                'description' => $description,
                'price' => rand(200, 999) / 100, // Random price between 2.00 and 9.99
                'stock_quantity' => rand(50, 500),
                'category_id' => $category->id,
                'origin' => $origins[array_rand($origins)],
                'color' => 'Silver / Metal',
                'material' => $materials[array_rand($materials)],
                'images' => $productImages,
                'is_active' => true,
            ]);
        }
    }
}
