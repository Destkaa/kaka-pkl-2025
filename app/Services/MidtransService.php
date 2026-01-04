<?php
// app/Services/MidtransService.php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification; // Pastikan ini di-import
use Exception;

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
        if ($order->items->isEmpty()) {
            throw new Exception('Order tidak memiliki item.');
        }

        $transactionDetails = [
            'order_id'     => $order->order_number,
            'gross_amount' => (int) $order->total_amount,
        ];

        $customerDetails = [
            'first_name' => $order->user->name,
            'email'      => $order->user->email,
            'phone'      => $order->shipping_phone ?? $order->user->phone ?? '',
            'billing_address' => [
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

        $itemDetails = $order->items->map(function ($item) {
            return [
                'id'       => (string) $item->product_id,
                'price'    => (int) $item->price,
                'quantity' => (int) $item->quantity,
                'name'     => substr($item->product_name, 0, 50),
            ];
        })->toArray();

        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => (int) $order->shipping_cost,
                'quantity' => 1,
                'name'     => 'Biaya Pengiriman',
            ];
        }

        $params = [
            'transaction_details' => $transactionDetails,
            'customer_details'    => $customerDetails,
            'item_details'        => $itemDetails,
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $e) {
            logger()->error('Midtrans Snap Token Error', [
                'order_id' => $order->order_number,
                'error'    => $e->getMessage(),
            ]);
            throw new Exception('Gagal membuat transaksi pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * FIKS: Menambahkan Method Notification untuk Webhook
     */
    public function notification()
    {
        return new Notification();
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