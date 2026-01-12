<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // AMBIL DATA KATEGORI dengan Alias 'products_count'
        $categories = Category::query()
            ->active() 
            ->withCount(['activeProducts as products_count' => function ($q) {
                $q->where('is_active', true)
                  ->where('stock', '>', 0);
            }])
            ->having('products_count', '>', 0) 
            ->orderBy('name')
            ->take(6)
            ->get();

        // PRODUK UNGGULAN
        $featuredProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        // PRODUK TERBARU
        $latestProducts = Product::query()
            ->with(['category', 'primaryImage'])
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'latestProducts'));
    }
}