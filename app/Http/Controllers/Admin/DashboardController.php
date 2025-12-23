<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dashboard
        $stats = [
            // Total pendapatan dari pesanan selesai
            'total_revenue' => Order::where('status', 'completed')
                ->sum('total_amount'),

            // Total semua pesanan
            'total_orders' => Order::count(),

            // Pesanan pending
            'pending_orders' => Order::where('status', 'pending')->count(),

            // Produk dengan stok rendah (≤ 5)
            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ];

        // Pesanan terbaru (5 terakhir)
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
