<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function getSnapToken(Order $order, MidtransService $midtransService)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        try {
            $snapToken = $midtransService->createSnapToken($order);
            $order->update(['snap_token' => $snapToken]);
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Webhook untuk Midtrans (Otomatis ubah status)
     */
    public function handleNotification(Request $request, MidtransService $midtransService)
    {
        try {
            $notification = $midtransService->notification();
            $order = Order::where('order_number', $notification->order_id)->first();

            if (!$order) return response()->json(['message' => 'Order not found'], 404);

            $status = $notification->transaction_status;
            $type = $notification->payment_type;
            $fraud = $notification->fraud_status;

            if ($status == 'settlement' || $status == 'capture') {
                if ($fraud !== 'challenge') {
                    // PEMBAYARAN SUKSES
                    $order->update([
                        'payment_status' => 'paid',
                        'status'         => 'processing', // Otomatis masuk ke tahap proses
                        'payment_method' => $type
                    ]);
                }
            } elseif ($status == 'pending') {
                $order->update(['payment_status' => 'unpaid']);
            } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
                $order->update([
                    'payment_status' => 'failed',
                    'status'         => 'cancelled'
                ]);
            }

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }
}