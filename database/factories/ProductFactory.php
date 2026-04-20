<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $images = ['product1.jpg', 'product2.jpg', 'product3.jpg', 'product4.jpg'];


        return [
            'name'=> $this->faker->words(3,true)  , 
            'slug'=> $this->faker->unique()->slug()  , 
            'cat_id'=>\App\Models\Category::pluck('id')->random() , 
            'description'=>$this->faker->paragraph() , 
            'price'=>$this->faker->randomFloat(2,10,500) , 
            'stock_quantity'=>$this->faker->numberBetween(0,100) , 
            'image'=>$this->faker->randomElement($images) , 
            'is_active'=>$this->faker->randomElement([true , false]) , 
        ];
    }
}
