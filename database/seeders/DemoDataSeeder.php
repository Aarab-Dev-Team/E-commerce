<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->error('No products found. Please seed products first.');
            return;
        }

        // 1. Create 10 Users
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => $faker->phoneNumber,
                'email_verified_at' => now(),
            ]);
            $users[] = $user;

            // 2. Create Address for each user
            Address::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'phone' => $user->phone,
                'type' => 'shipping',
                'address_line_1' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'postal_code' => $faker->postcode,
                'country' => $faker->country,
                'is_default' => true,
            ]);

            // 3. Create Cart and Cart Items for each user
            $cart = Cart::create([
                'user_id' => $user->id,
            ]);

            $randomProductsCount = rand(1, 4);
            if ($products->count() >= $randomProductsCount) {
                $randomProducts = $products->random($randomProductsCount);
                foreach ($randomProducts as $product) {
                    CartItem::create([
                        'cart_id' => $cart->id,
                        'product_id' => $product->id,
                        'quantity' => rand(1, 3),
                        'price_at_time' => $product->price,
                    ]);
                }
            }
        }

        // 4. Create 20 Random Orders
        for ($i = 0; $i < 20; $i++) {
            $user = $users[array_rand($users)];
            $address = Address::where('user_id', $user->id)->where('type', 'shipping')->first();
            
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => 0, // Will update after items
                'status' => $faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
                'shipping_address' => $address ? "{$address->address_line_1}, {$address->city}, {$address->state} {$address->postal_code}, {$address->country}" : $faker->address,
                'payment_method' => $faker->randomElement(['credit_card', 'paypal', 'cash_on_delivery']),
                'payment_status' => $faker->randomElement(['pending', 'paid', 'failed']),
                'notes' => $faker->sentence,
            ]);

            $total = 0;
            $itemsCount = rand(1, 5);
            if ($products->count() >= $itemsCount) {
                $randomProducts = $products->random($itemsCount);

                foreach ($randomProducts as $product) {
                    $qty = rand(1, 3);
                    $unitPrice = $product->price;
                    $subtotal = $qty * $unitPrice;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $qty,
                        'unit_price' => $unitPrice,
                        'total_price' => $subtotal,
                    ]);
                    
                    $total += $subtotal;
                }
            }

            $order->update(['total_amount' => $total]);
        }

        // 5. Create 20 Random Reviews
        for ($i = 0; $i < 20; $i++) {
            \App\Models\Review::create([
                'user_id' => $users[array_rand($users)]->id,
                'product_id' => $products->random()->id,
                'rating' => rand(3, 5),
                'comment' => $faker->paragraph,
                'is_approved' => true,
            ]);
        }

        $this->command->info('Demo data seeded successfully!');
    }
}
