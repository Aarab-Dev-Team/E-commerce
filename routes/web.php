<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

//admin
use App\Http\Controllers\Admin\ProductController; 
use App\Http\Controllers\Admin\DashboardController ; 


use App\Http\Controllers\OrderController ; 

use App\Http\Controllers\Shop\CatalogController ; 
use App\Http\Controllers\Shop\CartController ; 
use App\Http\Controllers\Shop\CheckoutController ; 
use App\Http\Controllers\AddressController ;
use App\Http\Controllers\WishlistController ;



use App\Http\Controllers\HomeController ; 

Route::get('/', [HomeController::class , "index"])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/dashboard', fn() => view('profile.dashboard'))->name('profile.dashboard');
    Route::get('/profile/orders', [OrderController::class, 'index'])->name('profile.orders');
    // Route::get('/profile/addresses', fn() => view('profile.addresses'))->name('profile.addresses');

    Route::get('/profile/addresses', [AddressController::class, 'index'])->name('profile.addresses.index');
    Route::post('/profile/addresses', [AddressController::class, 'store'])->name('profile.addresses.store');
    Route::patch('/profile/addresses/{address}', [AddressController::class, 'update'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [AddressController::class, 'destroy'])->name('profile.addresses.destroy');

    // wishlist

    Route::get('/profile/wishlist', [WishlistController::class, 'index'])->name('profile.wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    
});


// Route::middleware(['auth' , "role:admin"])->prefix("admin")->group(function(){
//         Route::get('/products' ,ProductController::class.'@index' )->name('admin.products.index') ; 
//         Route::get('/products/create' , ProductController::class.'@create')->name('admin.products.create') ; 
//         Route::post('/products' , [ProductController::class , "store"])->name('admin.products.store') ; 

//         Route::get('/products/{id}/edit' , [ProductController::class , "edit"])->name('admin.products.edit') ; 
//         Route::put('/products/{product}' , [ProductController::class , "update"])->name('admin.products.update') ; 
//         Route::delete('/products/{product}' , [ProductController::class , "destroy"])->name('admin.products.destroy');

//         Route::get('/orders', [\App\Http\Controller\Admin\OrderController::class , "index"])->name('admin.orders.index') ; 
//         Route::patch('/orders/{order}/status' , [\App\Http\Controller\Admin\OrderController::class , "updateStatus"])->name('admin.orders.status');
// })
// ;


// Route::resource('shop',\App\Http\Controllers\ProductController::class) ; 




// Route::prefix('cart')->name('cart.')->group(function(){

//     Route::get('/'  , [CartController::class , "index"])->name('index');
//     Route::post('/{product}/add'  , [CartController::class , "add"])->name('add');
//     Route::patch('/{id}/update'  , [CartController::class , "update"])->name('update') ; 
//     Route::delete('/{id}/remove' , [CartController::class ,"remove"])->name('remove') ; 

// });

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

    
Route::middleware(['auth' , "role:customer"])->group(function(){
        
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/order/thank-you/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

        Route::get('/my-orders' , [OrderController::class , "index"])->name('orders.index')  ; 
        Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/my-orders', [OrderController::class, 'store'])->name('orders.store');
});

// Catalog : 

Route::get('/shop', [CatalogController::class, 'index'])->name('shop.catalog');

// product detail 
Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('shop.product');


// ====================================================================
// Employee and Admin
// =====================================================================

Route::middleware(['auth', "role:admin,employee"])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);

});



require __DIR__.'/auth.php';
