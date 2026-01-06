<?php

// ================================================
// FUNGSI: Definisi semua route website
// ================================================

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MidtransNotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// ================================================
// ROUTE PUBLIK (Bisa diakses siapa saja)
// ================================================

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Katalog Produk
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/products/{slug}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalog', [CatalogController::class, 'index']); 
Route::get('/product/{slug}', [CatalogController::class, 'show']); 

// Google Auth
Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirect')->name('auth.google');
    Route::get('/auth/google/callback', 'callback')->name('auth.google.callback');
});

// Midtrans Webhook (Public)
Route::post('/midtrans/callback', [MidtransNotificationController::class, 'handle']);


// ================================================
// HALAMAN YANG BUTUH LOGIN (Customer)
// ================================================
Route::middleware('auth')->group(function () {
    // Redirect standard Laravel
    Route::get('/home', [HomeController::class, 'index']);

    // Keranjang Belanja
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Pesanan Saya
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profil & Password
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile', [ProfileController::class, 'update']); // Support untuk form PUT
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/google/unlink', [ProfileController::class, 'unlinkGoogle'])->name('profile.google.unlink');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.destroy');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Payment Routes
    Route::get('/orders/{order}/pay', [PaymentController::class, 'show'])->name('orders.pay');
    Route::get('/orders/{order}/success', [PaymentController::class, 'success'])->name('orders.success');
    Route::get('/orders/{order}/pending', [PaymentController::class, 'pending'])->name('orders.pending');
});


// ================================================
// HALAMAN ADMIN (Butuh Login + Role Admin)
// ================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']); 

    // Produk & Kategori CRUD
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Manajemen Pesanan
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    
    // Sesuai kode asli Anda menggunakan PATCH
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Manajemen Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Laporan Penjualan
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/export', [ReportController::class, 'exportSales'])->name('reports.export-sales');
});


// ================================================
// AUTH ROUTES (Laravel UI)
// ================================================
Auth::routes();

// Batasi login throttle
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('throttle:5,1');