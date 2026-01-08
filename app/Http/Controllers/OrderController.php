<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService; // Tambahkan ini
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan milik user yang sedang login.
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->with(['items.product']) 
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan dengan fitur SYNC OTOMATIS.
     */
    public function show(Order $order, MidtransService $midtransService) // Inject MidtransService
    {
        // 1. Security Check
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // 2. FITUR SAKTI: Sinkronisasi Status Otomatis
        // Jika status di DB kita masih belum bayar (unpaid/pending)
        if ($order->payment_status !== 'paid') {
            try {
                // Tanya langsung ke Midtrans pakai Order Number
                $status = $midtransService->checkStatus($order->order_number);
                
                // Jika menurut Midtrans sudah bayar, update DB kita sekarang juga!
                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing'
                    ]);
                } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                    $order->update([
                        'payment_status' => 'failed',
                        'status' => 'cancelled'
                    ]);
                }
            } catch (\Exception $e) {
                // Jika error (misal transaksi belum dibuat di Midtrans), diamkan saja.
                logger()->info("Sync status gagal untuk order: " . $order->order_number);
            }
        }

        // 3. Load relasi untuk tampilan detail
        $order->load(['items.product', 'items.product.primaryImage']);

        return view('orders.show', compact('order'));
    }

    /**
     * Halaman sukses
     */
    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('orders.success', compact('order'));
    }

    /**
     * Halaman pending
     */
    public function pending(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('orders.pending', compact('order'));
    }
}