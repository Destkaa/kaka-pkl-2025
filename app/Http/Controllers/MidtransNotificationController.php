<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Inisialisasi Konfigurasi (Sesuaikan dengan config Midtrans Anda)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notification = new Notification();
            
            // Ambil data dari Midtrans
            $transactionStatus = $notification->transaction_status;
            $paymentType = $notification->payment_type;
            $orderNumber = $notification->order_id;
            $fraudStatus = $notification->fraud_status;

            // Cari Order berdasarkan nomor order
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json(['message' => 'Order tidak ditemukan'], 404);
            }

            // 2. Logic Perubahan Status Berdasarkan Dokumentasi Midtrans
            // 
            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                // Status Settlement berarti pembayaran sukses (QRIS, Bank Transfer, Alfamart)
                $order->update(['payment_status' => 'paid', 'status' => 'processing']);
            } elseif ($transactionStatus == 'pending') {
                $order->update(['payment_status' => 'unpaid']);
            } elseif ($transactionStatus == 'deny') {
                $order->update(['payment_status' => 'failed']);
            } elseif ($transactionStatus == 'expire') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            } elseif ($transactionStatus == 'cancel') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification handled']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}