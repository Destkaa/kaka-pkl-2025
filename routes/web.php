<?php

// ================================================
// GADGET PRO - ROUTE DEFINITION
// ================================================

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Import Controllers Utama
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;

// Import Controller Khusus
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\Auth\GoogleController;

// Import Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// ================================================
// 1. ROUTE PUBLIK (Bisa diakses tanpa login)
// ================================================

// Home & Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog Produk & Detail
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalog', [CatalogController::class, 'index']); // Alias
Route::get('/product/{slug}', [CatalogController::class, 'show']); // Alias

// Google Authentication
Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

/**
 * PENTING: Midtrans Webhook (WAJIB PUBLIK & POST)
 * URL di Dashboard Midtrans: https://highhanded-pamula-rasorial.ngrok-free.dev/midtrans/callback
 */
Route::post('/midtrans/callback', [MidtransNotificationController::class, 'handle'])->name('midtrans.callback');


// ================================================
// 2. ROUTE CUSTOMER (Wajib Login)
// ================================================
Route::middleware('auth')->group(function () {
    
    // Redirect standard
    Route::get('/home', [HomeController::class, 'index']);

    // Keranjang Belanja (Cart)
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::patch('/{item}', [CartController::class, 'update'])->name('update');
        Route::delete('/{item}', [CartController::class, 'remove'])->name('remove');
    });

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Manajemen Pesanan User
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/success', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order}/pending', [OrderController::class, 'pending'])->name('orders.pending');

    // Halaman Pembayaran (Tampilan Snap Midtrans)
    Route::get('/orders/{order}/pay', [PaymentController::class, 'show'])->name('orders.pay');

    // Manajemen Profil
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::put('/profile', 'update'); 
        Route::delete('/profile', 'destroy')->name('profile.destroy');
        Route::delete('/profile/google/unlink', 'unlinkGoogle')->name('profile.google.unlink');
        Route::patch('/profile/avatar', 'updateAvatar')->name('profile.avatar.update');
        Route::delete('/profile/avatar', 'deleteAvatar')->name('profile.avatar.destroy');
        Route::put('/profile/password', 'updatePassword')->name('profile.password.update');
    });
});


// ================================================
// 3. ROUTE ADMIN (Wajib Login + Role Admin)
// ================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']); 

    // CRUD Produk & Kategori
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Manajemen Pesanan & Status (Admin)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Manajemen User & Laporan
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/export', [ReportController::class, 'exportSales'])->name('reports.export-sales');
});


// ================================================
// 4. AUTHENTICATION (Laravel UI)
// ================================================
Auth::routes();

// Custom Login Throttle
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('throttle:5,1');