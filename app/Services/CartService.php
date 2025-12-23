<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Ambil atau buat cart (User / Guest)
     */
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ]);
        }

        return Cart::firstOrCreate([
            'session_id' => Session::getId(),
        ]);
    }

    /**
     * Tambah produk ke cart
     */
    public function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = $this->getCart();

        // 🔥 Harga final (diskon > normal)
        $finalPrice = $product->discount_price ?? $product->price;

        $existingItem = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if ($newQuantity > $product->stock) {
                throw new \Exception("Stok tidak mencukupi. Maksimal: {$product->stock}");
            }

            // ✅ FIX subtotal 0 (ISI price JIKA MASIH NULL)
            $existingItem->update([
                'quantity' => $newQuantity,
                'price'    => $existingItem->price ?? $finalPrice,
            ]);
        } else {
            if ($quantity > $product->stock) {
                throw new \Exception("Stok tidak mencukupi.");
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $finalPrice, // 🔥 SIMPAN HARGA
            ]);
        }

        $cart->touch();
    }

    /**
     * Update quantity
     */
    public function updateQuantity(int $itemId, int $quantity): void
    {
        $item = CartItem::findOrFail($itemId);
        $product = $item->product;

        $this->verifyCartOwnership($item->cart);

        if ($quantity > $product->stock) {
            throw new \Exception("Stok tidak mencukupi. Tersisa: {$product->stock}");
        }

        if ($quantity <= 0) {
            $item->delete();
            return;
        }

        $item->update([
            'quantity' => $quantity,
        ]);
    }

    /**
     * Hapus item
     */
    public function removeItem(int $itemId): void
    {
        $item = CartItem::findOrFail($itemId);

        $this->verifyCartOwnership($item->cart);

        $item->delete();
    }

    /**
     * Merge cart guest ke user
     */
    public function mergeCartOnLogin(): void
    {
        $guestCart = Cart::where('session_id', Session::getId())
            ->with('items')
            ->first();

        if (!$guestCart) {
            return;
        }

        $userCart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        foreach ($guestCart->items as $guestItem) {
            $userItem = $userCart->items()
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($userItem) {
                $userItem->increment('quantity', $guestItem->quantity);
                $guestItem->delete();
            } else {
                $guestItem->update([
                    'cart_id' => $userCart->id,
                ]);
            }
        }

        $guestCart->delete();
    }

    /**
     * Security helper
     */
    private function verifyCartOwnership(Cart $cart): void
    {
        if ($cart->id !== $this->getCart()->id) {
            abort(403, 'Akses ditolak. Ini bukan keranjang Anda.');
        }
    }
}
