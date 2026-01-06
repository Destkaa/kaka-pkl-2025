<?php
// ================================================
// FILE: app/Http/Controllers/HomeController.php
// FUNGSI: Menangani halaman utama website dengan Query Efficiency
// ================================================

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda.
     * * Optimasi Tugas 3:
     * - Menggunakan select() untuk mengambil kolom yang diperlukan saja.
     * - Membatasi jumlah data dengan take().
     * - Eager loading relasi untuk mencegah N+1.
     */
    public function index()
    {
        // ================================================
        // 1. DATA KATEGORI (Optimasi: Select kolom & Cache)
        // ================================================
        $categories = Category::query()
            ->select(['id', 'name', 'slug', 'image']) // Hanya ambil yang tampil di UI
            ->active()
            ->withCount(['activeProducts' => function ($q) {
                $q->where('is_active', true)
                  ->where('stock', '>', 0);
            }])
            ->having('active_products_count', '>', 0)
            ->orderBy('name')
            ->take(6)
            ->get();

        // ================================================
        // 2. PRODUK UNGGULAN (FEATURED)
        // Optimasi: Select kolom agar tidak load 'description' yang berat
        // ================================================
        $featuredProducts = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'discount_price', 'category_id', 'stock'])
            ->with(['category:id,name', 'primaryImage']) // Eager load kolom tertentu dari relasi
            ->active()
            ->inStock()
            ->featured()
            ->latest()
            ->take(8)
            ->get();

        // ================================================
        // 3. PRODUK TERBARU
        // Optimasi: Membatasi resource memory dengan select()
        // ================================================
        $latestProducts = Product::query()
            ->select(['id', 'name', 'slug', 'price', 'discount_price', 'category_id', 'stock'])
            ->with(['category:id,name', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        // ================================================
        // 4. KIRIM DATA KE VIEW
        // ================================================
        return view('home', compact(
            'categories',
            'featuredProducts',
            'latestProducts'
        ));
    }
}