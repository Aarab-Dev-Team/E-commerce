import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/homepage.css',
                'resources/css/product.css',
                "resources/css/cart.css", 
                'resources/css/profile-layout.css',  
                'resources/css/profile-edit.css', 
                "resources/css/checkout.css", 
                "resources/css/confirmation.css", 
                'resources/css/order-details.css',
                'resources/css/profile-orders.css',
                'resources/css/profile-addresses.css',
                'resources/js/profile-addresses.js',
                'resources/css/profile-wishlist.css',
                'resources/js/app.js'
                ],
            refresh: true,
        }),
    ],

    
});
