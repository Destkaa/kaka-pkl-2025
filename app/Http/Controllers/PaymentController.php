<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Mengambil Snap Token untuk order ini (API Endpoint).
     */
    public function getSnapToken(Order $order, MidtransService $midtransService)
    {
        // 1. Authorization: Pastikan user adalah pemilik order
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // 2. Cek apakah order sudah dibayar
        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Pesanan sudah dibayar.'], 400);
        }

        try {
            // 3. Generate Snap Token dari Midtrans
            $snapToken = $midtransService->createSnapToken($order);

            // 4. Simpan token ke database untuk referensi
            $order->update(['snap_token' => $snapToken]);

            // 5. Kirim token ke frontend
            return response()->json(['token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Halaman sukses setelah pembayaran (Redirect dari Midtrans).
     * Sesuai dengan error: Method App\Http\Controllers\PaymentController::success does not exist.
     */
    public function success(Order $order)
    {
        // Pastikan hanya pemilik order yang bisa melihat halaman ini
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Jika status di DB masih pending, kita bisa beri pesan "Sedang Diproses"
        // Tapi jika sudah diproses oleh Webhook/Queue, tampilkan "Sukses"
        return view('orders.success', compact('order'));
    }
}