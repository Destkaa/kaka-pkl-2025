<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     * Dilengkapi filter by status.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user') // N+1 prevention
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Detail order untuk admin.
     */
    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, Order $order)
    {
        // FIKS: Menambahkan semua opsi status yang ada di database agar tidak error saat validasi
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Jika status tidak berubah, tidak perlu memproses stok
        if ($oldStatus === $newStatus) {
            return back()->with('info', "Status sudah $newStatus");
        }

        // ============================================================
        // LOGIKA RESTOCK (PENTING!)
        // ============================================================
        
        // KASUS 1: Order DIBATALKAN (Kembalikan stok ke gudang)
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // KASUS 2: Order AKTIF KEMBALI (Jika sebelumnya cancelled, potong stok lagi)
        // Ini untuk mencegah stok double jika admin salah membatalkan lalu mengaktifkan lagi
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                // Cek jika stok cukup sebelum mengaktifkan kembali
                if ($item->product->stock < $item->quantity) {
                    return back()->with('error', "Gagal mengaktifkan order. Stok {$item->product->name} tidak mencukupi.");
                }
                $item->product->decrement('stock', $item->quantity);
            }
        }

        // Update status di database
        $order->update(['status' => $newStatus]);

        return back()->with('success', "Status pesanan #{$order->order_number} diperbarui menjadi $newStatus");
    }
}