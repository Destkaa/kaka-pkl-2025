<?php

namespace App\Services;

use App\Models\Order;
use Exception;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function createSnapToken(Order $order): string
    {
        // Load relasi agar data item dan user tersedia
        $order->load(['items', 'user']);

        if ($order->items->isEmpty()) {
            throw new Exception('Order tidak memiliki item.');
        }

        // 1. Customer Details
        $customerDetails = [
            'first_name'       => $order->user->name,
            'email'            => $order->user->email,
            'phone'            => $order->shipping_phone ?? $order->user->phone ?? '',
            'shipping_address' => [
                'first_name' => $order->shipping_name,
                'phone'      => $order->shipping_phone,
                'address'    => $order->shipping_address,
            ],
        ];

        // 2. Item Details & Calculation
        $itemDetails = [];
        $calculatedGrossAmount = 0;

        foreach ($order->items as $item) {
            /**
             * PERBAIKAN: 
             * Ambil harga dari tabel order_items. 
             * Pastikan saat checkout, kamu sudah menyimpan harga DISKON ke kolom ini.
             */
            $price = (int) $item->price; 
            $qty = (int) $item->quantity;
            $subtotal = $price * $qty;

            $itemDetails[] = [
                'id'       => (string) $item->product_id,
                'price'    => $price,
                'quantity' => $qty,
                'name'     => substr($item->product_name, 0, 50),
            ];
            $calculatedGrossAmount += $subtotal;
        }

        // Tambahkan Biaya Pengiriman (Ongkir)
        if ($order->shipping_cost > 0) {
            $shippingCost = (int) $order->shipping_cost;
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => $shippingCost,
                'quantity' => 1,
                'name'     => 'Biaya Pengiriman',
            ];
            $calculatedGrossAmount += $shippingCost;
        }

        /**
         * LOGIKA TAMBAHAN: Potongan Diskon Global (Kupon/Promo)
         * Jika ada diskon di level total order, tambahkan sebagai harga minus.
         */
        if (isset($order->discount_amount) && $order->discount_amount > 0) {
            $discount = (int) $order->discount_amount;
            $itemDetails[] = [
                'id'       => 'DISCOUNT',
                'price'    => -$discount, // Harga negatif untuk mengurangi total
                'quantity' => 1,
                'name'     => 'Potongan Diskon',
            ];
            $calculatedGrossAmount -= $discount;
        }

        // 3. Transaction Details
        // Kita gunakan $calculatedGrossAmount agar sinkron dengan rincian item
        $transactionDetails = [
            'order_id'     => $order->order_number,
            'gross_amount' => $calculatedGrossAmount,
        ];

        // 4. Parameter Gabungan
        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
            'item_details'        => $itemDetails,
            'expiry' => [
                'unit'     => 'minutes',
                'duration' => 60
            ],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            logger()->error('Midtrans Snap Error: ' . $e->getMessage(), [
                'order_id' => $order->order_number,
                'params'   => $params
            ]);
            throw new Exception('Gagal membuat transaksi: ' . $e->getMessage());
        }
    }

    public function checkStatus(string $orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (Exception $e) {
            throw new Exception('Gagal mengecek status: ' . $e->getMessage());
        }
    }

    public function cancelTransaction(string $orderId)
    {
        try {
            return Transaction::cancel($orderId);
        } catch (Exception $e) {
            throw new Exception('Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }
}