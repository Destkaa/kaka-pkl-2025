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
        // 1. Ambil Keranjang User dengan Eager Loading agar data produk pasti terbaca
        $cart = $user->cart;

        if (! $cart || $cart->items->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        // ==================== DATABASE TRANSACTION START ====================
        return DB::transaction(function () use ($user, $cart, $shippingData) {
            
            // A. VALIDASI STOK & HITUNG TOTAL
            $totalAmount = 0;
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }

                // FIX: Gunakan discount_price jika ada, jika tidak gunakan price reguler
                $activePrice = $item->product->discount_price > 0 
                               ? $item->product->discount_price 
                               : $item->product->price;

                $totalAmount += $activePrice * $item->quantity;
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
                // FIX: Samakan logika penentuan harga dengan di atas agar tidak NULL
                $activePrice = $item->product->discount_price > 0 
                               ? $item->product->discount_price 
                               : $item->product->price;

                $order->items()->create([
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $activePrice, // Sekarang tidak akan NULL
                    'quantity'     => $item->quantity,
                    'subtotal'     => $activePrice * $item->quantity, // Sekarang tidak akan 0
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // D. Pastikan relasi user di-load sebelum generate Snap Token
            $order->load('user');
            $midtransService = new \App\Services\MidtransService();
            try {
                $snapToken = $midtransService->createSnapToken($order);
                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                // Jika gagal, biarkan snap_token tetap null
            }

            // E. BERSIHKAN KERANJANG
            $cart->items()->delete();
            // $cart->delete(); // opsional

            return $order;
        });
        // ==================== DATABASE TRANSACTION END ====================
    }
}