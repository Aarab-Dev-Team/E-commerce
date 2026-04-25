<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Admin Controllers
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;

// Front Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\CouponController as ShopCouponController;
use App\Http\Controllers\OrderController; // Customer Orders
use App\Http\Controllers\ProductController; // Product detail
use App\Http\Controllers\AddressController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [CatalogController::class, 'index'])->name('shop.catalog');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('shop.product');
Route::get('/about', function () {
    return view('about');
})->name('about');

// Cart (accessible to guests and customers)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    // Coupon
    Route::post('/coupon/apply', [ShopCouponController::class, 'apply'])->name('coupon.apply');
    Route::delete('/coupon/remove', [ShopCouponController::class, 'remove'])->name('coupon.remove');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (All Roles)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Basic profile for all authenticated users (no extra tabs)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Redirect /dashboard to appropriate home based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin' || $user->role === 'employee') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('shop.catalog');
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Customer Routes (role:customer)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/thank-you/{order}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

    // Customer Orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/my-orders', [OrderController::class, 'store'])->name('orders.store');

    // Addresses (Profile tab)
    Route::prefix('profile/addresses')->name('profile.addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::patch('/{address}', [AddressController::class, 'update'])->name('update');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
    });

    // Wishlist (Profile tab)
    Route::prefix('profile/wishlist')->name('profile.wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/toggle/{product}', [WishlistController::class, 'toggle'])->name('toggle');
        Route::delete('/{product}', [WishlistController::class, 'destroy'])->name('destroy');
    });

    // Additional profile tabs for customer only (Orders already covered)
    Route::get('/profile/orders', [OrderController::class, 'index'])->name('profile.orders');

    // Reviews — only customers can add/edit/delete reviews
    Route::post('/product/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin & Employee Routes (Admin Panel)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,employee'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products (employee can manage, but publish requires admin approval - handled in controller logic)
    Route::resource('products', AdminProductController::class);

    // Orders (view & update status — both roles; delete admin-only via controller guard)
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Approvals — both roles can VIEW the queue; approve/reject guarded in controller
    Route::prefix('approvals')->name('approvals.')->group(function () {
        Route::get('/', [ApprovalController::class, 'index'])->name('index');
        Route::get('/{product}', [ApprovalController::class, 'show'])->name('show');
        Route::post('/{product}/approve', [ApprovalController::class, 'approve'])->name('approve');
        Route::post('/{product}/reject', [ApprovalController::class, 'reject'])->name('reject');
    });

    // Review replies — admin & employee can reply to customer reviews
    Route::post('reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

    // Categories (admin only)
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);

    // Users & Settings (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
        // Coupons
        Route::get('coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
        Route::post('coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::patch('coupons/{coupon}', [AdminCouponController::class, 'update'])->name('coupons.update');
        Route::delete('coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');
    });
});

require __DIR__.'/auth.php';