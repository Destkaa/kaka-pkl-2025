<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Wajib untuk Tugas 2

class CatalogController extends Controller
{
    /**
     * Menampilkan halaman katalog produk dengan Cache & Eager Loading.
     */
    public function index(Request $request)
    {
        // --- TUGAS 1: EAGER LOADING (Optimasi N+1) ---
        // Kita me-load 'category' dan 'primaryImage' sekaligus agar query lebih hemat.
        $query = Product::query()
            ->with(['category', 'primaryImage']) 
            ->active()
            ->inStock();

        // Filter Pencarian
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            'name_desc'  => $query->orderBy('name', 'desc'),
            default      => $query->latest(),
        };

        // Pagination (Dinamis, tidak di-cache)
        $products = $query->paginate(12)->withQueryString();

        // --- TUGAS 2: IMPLEMENTASI CACHE (Sidebar) ---
        // Menyimpan data kategori di Cache selama 24 jam untuk mengurangi beban DB.
        $categories = Cache::remember('catalog_categories', now()->addDay(), function () {
            return Category::query()
                ->active()
                ->withCount(['activeProducts'])
                ->having('active_products_count', '>', 0)
                ->orderBy('name')
                ->get();
        });

        return view('catalog.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan halaman detail produk.
     */
    public function show(string $slug)
    {
        // Eager Loading relasi images untuk galeri
        $product = Product::query()
            ->with(['category', 'images']) 
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Produk Terkait dengan Eager Loading
        $relatedProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->take(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}