<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('user')
            ->when($request->status, function($q, $status) {
                $q->where('status', $status);
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Validasi mencakup semua kemungkinan status di ENUM database
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,completed,cancelled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Logika Balikin Stok jika dibatalkan
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        // Siapkan data untuk update
        $dataUpdate = ['status' => $newStatus];

        // Jika diset selesai (completed atau delivered), otomatis payment jadi paid
        if (in_array($newStatus, ['completed', 'delivered'])) {
            $dataUpdate['payment_status'] = 'paid';
        }

        // Eksekusi update ke database
        $order->update($dataUpdate);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', "Status pesanan berhasil diperbarui menjadi " . strtoupper($newStatus));
    }
}