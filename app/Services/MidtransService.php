<?php
// app/Services/MidtransService.php

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
        // Load relasi jika belum ada untuk menghindari error null
        $order->load(['items', 'user']);

        if ($order->items->isEmpty()) {
            throw new Exception('Order tidak memiliki item.');
        }

        // 1. Transaction Details
        // Pastikan (int) untuk membuang desimal karena Midtrans IDR tidak mendukung sen
        $transactionDetails = [
            'order_id'     => $order->order_number,
            'gross_amount' => (int) $order->total_amount,
        ];

        // 2. Customer Details
        $customerDetails = [
            'first_name'       => $order->user->name,
            'email'            => $order->user->email,
            'phone'            => $order->shipping_phone ?? $order->user->phone ?? '',
            'billing_address'  => [
                'first_name' => $order->shipping_name,
                'phone'      => $order->shipping_phone,
                'address'    => $order->shipping_address,
            ],
            'shipping_address' => [
                'first_name' => $order->shipping_name,
                'phone'      => $order->shipping_phone,
                'address'    => $order->shipping_address,
            ],
        ];

        // 3. Item Details
        $itemDetails = [];
        $calculatedGrossAmount = 0;

        foreach ($order->items as $item) {
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

        // Tambahkan ongkir jika ada
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

        // --- VALIDASI ANTI ERROR 2603 ---
        // Jika total rincian tidak sama dengan total amount di header, 
        // Midtrans akan mengembalikan error. Kita paksa agar sinkron.
        if ($calculatedGrossAmount !== (int) $order->total_amount) {
            $transactionDetails['gross_amount'] = $calculatedGrossAmount;
        }

        // 4. Gabungkan parameter
        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
            'item_details'        => $itemDetails,
            // Opsional: Atur expiry agar tidak terlalu cepat expired
            'expiry' => [
                'unit' => 'minutes',
                'duration' => 60
            ],
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            logger()->error('Midtrans Snap Token Error: ' . $e->getMessage(), [
                'order_id' => $order->order_number,
                'params'   => $params
            ]);
            throw new Exception('Gagal membuat transaksi pembayaran: ' . $e->getMessage());
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