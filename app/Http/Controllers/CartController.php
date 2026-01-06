<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Menampilkan halaman keranjang belanja.
     * Perbaikan: Memastikan kolom kunci relasi (id & product_id) selalu ada.
     */
    public function index()
    {
        $cart = $this->cartService->getCart();

        // Eager Loading dengan pengaman kolom
        $cart->load(['items.product' => function($query) {
            // id: wajib agar relasi ke CartItem tersambung
            $query->select(['id', 'name', 'slug', 'price', 'stock'])
                  ->with(['primaryImage' => function($q) {
                      // id & product_id: wajib agar gambar nempel ke produk
                      $q->select(['id', 'product_id', 'image_path']);
                  }]);
        }]);

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        try {
            // Ambil kolom minimalis untuk pengecekan
            $product = Product::select(['id', 'name', 'price', 'stock', 'is_active'])
                ->findOrFail($request->product_id);
                
            $this->cartService->addProduct($product, $request->quantity);

            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $itemId)
    {
        $request->validate(['quantity' => 'required|integer|min:0']);

        try {
            $this->cartService->updateQuantity($itemId, $request->quantity);
            return back()->with('success', 'Keranjang diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove($itemId)
    {
        try {
            $this->cartService->removeItem($itemId);
            return back()->with('success', 'Item dihapus dari keranjang.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}