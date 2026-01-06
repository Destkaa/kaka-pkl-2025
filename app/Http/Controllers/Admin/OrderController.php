<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan
     */
    public function index()
    {
        $orders = Order::with(['user'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan tunggal (INI YANG TADI HILANG)
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan (PATCH)
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        try {
            DB::beginTransaction();

            $order->status = $request->status;
            $order->save();

            // Clear cache jika diperlukan
            try {
                Cache::forget('catalog_categories');
            } catch (\Exception $e) {
                Log::warning("Cache clear failed: " . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.orders.show', $order->id)
                ->with('success', 'Status pesanan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("UPDATE ORDER FAILED: " . $e->getMessage());

            return redirect()->route('admin.orders.show', $order->id)
                ->with('error', 'Gagal memperbarui status.');
        }
    }
}