<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan untuk admin.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user')
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
     * Update status pesanan & Logika Restock Otomatis
     */
    public function updateStatus(Request $request, Order $order)
    {
        // 1. Validasi: Tambahkan 'completed' agar tidak error 422
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,completed'
        ]);

        try {
            // 2. Gunakan Database Transaction agar data sinkron
            DB::transaction(function () use ($request, $order) {
                $oldStatus = $order->status;
                $newStatus = $request->status;

                // LOGIKA RESTOCK: Jika dibatalkan, kembalikan stok produk
                if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                    foreach ($order->items as $item) {
                        if ($item->product) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }
                }

                // 3. Update status di database
                $order->update(['status' => $newStatus]);
            });

            $statusName = ucfirst($request->status);
            return back()->with('success', "Pesanan #{$order->id} berhasil diupdate ke status: $statusName");

        } catch (\Exception $e) {
            // Jika ada error (misal database mati), balikkan pesan error
            return back()->with('error', "Gagal memperbarui status: " . $e->getMessage());
        }
    }
}