<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Tambahkan ini untuk manajemen cache

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan Eager Loading.
     * Tugas 1: Mencegah N+1 Query pada relasi User.
     */
    public function index()
    {
        // Optimasi: Memuat relasi user sekaligus (Eager Loading)
        $orders = Order::with(['user'])
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan.
     * Tugas 1: Mencegah N+1 pada item pesanan dan produk di dalamnya.
     */
    public function show(Order $order)
    {
        // Lazy Eager Loading untuk relasi bersarang (Nested)
        $order->load(['user', 'items.product']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // --- TUGAS 2: CACHE INVALIDATION (PENTING) ---
        // Jika status pesanan berubah, ada kemungkinan stok produk berubah 
        // atau status produk aktif berubah, maka kita hapus cache sidebar kategori.
        Cache::forget('catalog_categories');

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}