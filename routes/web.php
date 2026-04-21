<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

// ---------- PUBLIC ROUTES ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [CatalogController::class, 'index'])->name('shop.catalog');
Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('shop.product');

// Cart (works for guests and logged-in users)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// ---------- AUTHENTICATED ROUTES (ALL LOGGED-IN USERS) ----------
Route::middleware('auth')->group(function () {
    // Profile (basic for everyone)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Addresses (customers mainly, but admin/employee can have basic profile)
    Route::resource('profile/addresses', AddressController::class)->names([
        'index'   => 'profile.addresses.index',
        'store'   => 'profile.addresses.store',
        'update'  => 'profile.addresses.update',
        'destroy' => 'profile.addresses.destroy',
    ])->only(['index', 'store', 'update', 'destroy']);

    // Orders (customers view their own)
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Wishlist (customers only – add role check inside controller if needed)
    Route::get('/profile/wishlist', [WishlistController::class, 'index'])->name('profile.wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

// ---------- CUSTOMER SPECIFIC (already covered above) ----------

// ---------- EMPLOYEE + ADMIN (Shared Admin Panel) ----------
Route::middleware(['auth', 'role:admin,employee'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products (employees can create/edit but need approval – handle in controller logic)
    Route::resource('products', ProductController::class);

    // Orders (view and update status only)
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

// ---------- ADMIN ONLY ----------
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Categories
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);
    // Users
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});

// ---------- CHECKOUT (AUTHENTICATED CUSTOMERS) ----------
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/thank-you/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
});

require __DIR__.'/auth.php';