<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder(User $user, array $shippingData): Order
    {
        // 1. Ambil Keranjang dengan Eager Loading
        $cart = $user->cart()->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception("Keranjang belanja kosong.");
        }

        return DB::transaction(function () use ($user, $cart, $shippingData) {
            $totalAmount = 0;
            $itemsToProcess = [];

            // A. VALIDASI STOK & HITUNG HARGA
            foreach ($cart->items as $item) {
                $product = $item->product;

                if ($item->quantity > $product->stock) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi.");
                }

                // Logika: Gunakan harga diskon jika > 0, jika tidak gunakan harga normal
                $originalPrice = (float) $product->price;
                $discountPrice = (float) $product->discount_price;
                $finalPrice = ($discountPrice > 0) ? $discountPrice : $originalPrice;

                $itemsToProcess[] = [
                    'product_id'   => $item->product_id,
                    'product_name' => $product->name,
                    'price'        => $finalPrice,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $finalPrice * $item->quantity,
                ];

                $totalAmount += ($finalPrice * $item->quantity);
            }

            // B. BUAT HEADER ORDER
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => 'GPRO-' . date('YmdHis') . '-' . strtoupper(Str::random(5)),
                'status'           => 'pending',
                'payment_status'   => 'unpaid',
                'shipping_name'    => $shippingData['name'],
                'shipping_address' => $shippingData['address'],
                'shipping_phone'   => $shippingData['phone'],
                'total_amount'     => $totalAmount,
            ]);

            // C. SIMPAN ITEMS & POTONG STOK
            foreach ($itemsToProcess as $itemData) {
                $order->items()->create($itemData);
                Product::where('id', $itemData['product_id'])->decrement('stock', $itemData['quantity']);
            }

            // D. MIDTRANS SNAP TOKEN
            $order->load(['user', 'items']);
            try {
                $midtransService = new \App\Services\MidtransService();
                $snapToken = $midtransService->createSnapToken($order);
                $order->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
                Log::error("Midtrans Error: " . $e->getMessage());
            }

            // E. BERSIHKAN KERANJANG
            $cart->items()->delete();

            return $order;
        });
    }
}