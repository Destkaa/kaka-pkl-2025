<?php
// app/Http/Controllers/WishlistController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Menampilkan halaman wishlist user
     */
    public function index()
    {
        $products = auth()->user()
            ->wishlistProducts() // ✅ PAKAI belongsToMany
            ->with(['category', 'primaryImage'])
            ->latest('wishlists.created_at')
            ->paginate(12);

        return view('wishlist.index', compact('products'));
    }

    /**
     * Toggle wishlist (AJAX)
     */
    public function toggle(Product $product)
    {
        $user = auth()->user();

        // Cek apakah produk sudah ada di wishlist
        $exists = $user->wishlists()
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            // ❌ HAPUS dari wishlist
            $user->wishlistProducts()->detach($product->id);

            $added  = false;
            $message = 'Produk dihapus dari wishlist.';
        } else {
            // ✅ TAMBAH ke wishlist
            $user->wishlistProducts()->attach($product->id);

            $added  = true;
            $message = 'Produk ditambahkan ke wishlist!';
        }

        return response()->json([
            'status'  => 'success',
            'added'   => $added,
            'message' => $message,
            'count'   => $user->wishlistProducts()->count(),
        ]);
    }
}
