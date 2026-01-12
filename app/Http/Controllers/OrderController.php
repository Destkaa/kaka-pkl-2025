<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Transaction;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan (Mengatasi error BadMethodCallException)
     */
    public function index()
    {
        // Mengambil order milik user yang login, diurutkan dari yang terbaru
        $orders = auth()->user()->orders()
            ->latest()
            ->paginate(10); // Sesuai dengan $orders->links() di Blade Anda

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan (Halaman show)
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        // Eager load items dan product agar tidak terjadi N+1 query
        $order->load(['items.product']);

        return view('orders.show', compact('order'));
    }

    /**
     * Halaman Sukses & Auto-Update Status
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Konfigurasi Midtrans untuk pengecekan status manual (Pull)
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            $status = Transaction::status($order->order_number);

            // Jika status lunas di Midtrans, pastikan database lokal ikut update
            if (in_array($status->transaction_status, ['settlement', 'capture'])) {
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'processing'
                ]);
            }
        } catch (\Exception $e) {
            // Jika koneksi gagal, biarkan saja (Webhook akan handle)
        }

        return view('orders.success', compact('order'));
    }

    /**
     * Halaman Pending
     */
    public function pending(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('orders.pending', compact('order'));
    }
}