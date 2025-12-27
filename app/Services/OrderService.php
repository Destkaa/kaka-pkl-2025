<?php
// app/Services/OrderService.php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Membuat Order baru dari Keranjang belanja.
     */
    public function createOrder(User $user, array $shippingData): Order
    {
        // 1. Ambil Keranjang User
        $cart = $user->cart;

        if (! $cart || $cart->items->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        return DB::transaction(function () use ($user, $cart, $shippingData) {
            // A. VALIDASI STOK & HITUNG TOTAL
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }
                
                // --- PERBAIKAN DI SINI ---
                // Gunakan discount_price jika ada, jika tidak gunakan price asli
                $priceToCharge = $item->product->discount_price > 0 
                                 ? $item->product->discount_price 
                                 : $item->product->price;

                $totalAmount += $priceToCharge * $item->quantity;
            }

            // B. BUAT HEADER ORDER
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'ORD-' . strtoupper(Str::random(10)),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_name'    => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone'   => $shippingData['phone'],
                'total_amount'     => $totalAmount,
            ]);

            // C. PINDAHKAN ITEMS
            foreach ($cart->items as $item) {
                // --- PERBAIKAN DI SINI ---
                $currentPrice = $item->product->discount_price > 0 
                                ? $item->product->discount_price 
                                : $item->product->price;

                $order->items()->create([
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $currentPrice, // Sekarang tidak akan NULL
                    'quantity'     => $item->quantity,
                    'subtotal'     => $currentPrice * $item->quantity,
                ]);

                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            // D. Load relasi & Generate Snap Token
            $order->load('user');
            $midtransService = new \App\Services\MidtransService();
            try {
                $snapToken = $midtransService->createSnapToken($order);
                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Log error jika perlu: \Log::error($e->getMessage());
            }

            // E. BERSIHKAN KERANJANG
            $cart->items()->delete();

            return $order;
        });
    }
}