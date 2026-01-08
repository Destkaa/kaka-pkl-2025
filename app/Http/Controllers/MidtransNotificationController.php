<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class MidtransNotificationController extends Controller
{
    public function handle(Request $request)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            $notification = new Notification();
            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;

            // Cari order berdasarkan number atau id
            $order = Order::where('number', $orderId)
                          ->orWhere('order_number', $orderId)
                          ->orWhere('id', $orderId)
                          ->first();

            if (!$order) {
                Log::error("Webhook: Order $orderId tidak ketemu!");
                return response()->json(['message' => 'Not Found'], 404);
            }

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $order->update(['payment_status' => 'paid', 'status' => 'processing']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error("Webhook Error: " . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}