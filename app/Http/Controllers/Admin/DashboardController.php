<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue' => Order::whereIn('status', ['processing', 'completed'])
                                    ->where('payment_status', 'paid')
                                    ->sum('total_amount'),

            'total_orders' => Order::count(),

            // PERBAIKAN DI SINI:
            // "Pending Orders" bagi admin adalah pesanan yang SUDAH DIBAYAR (paid) 
            // tapi status pengirimannya masih 'processing' (baru masuk)
            'pending_orders' => Order::where('status', 'processing')
                                     ->where('payment_status', 'paid')
                                     ->count(),

            'total_products' => Product::count(),

            'total_customers' => User::where('role', 'customer')->count(),

            'low_stock' => Product::where('stock', '<=', 5)->count(),
        ];

        // 2. Data Tabel Pesanan Terbaru
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // 3. Produk Terlaris (Hitung berdasarkan yang sudah lunas)
        $topProducts = Product::withCount(['orderItems as sold' => function ($q) {
                $q->select(DB::raw('SUM(quantity)'))
                  ->whereHas('order', function($query) {
                      $query->where('payment_status', 'paid');
                  });
            }])
            ->having('sold', '>', 0)
            ->orderByDesc('sold')
            ->take(5)
            ->get();

        // 4. Data Grafik Pendapatan (7 Hari Terakhir)
        $revenueData = Order::select([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            ])
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $revenueChart = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayData = $revenueData->get($date);

            $revenueChart->push([
                'date' => now()->subDays($i)->format('d M'),
                'total' => $dayData ? $dayData->total : 0
            ]);
        }

        return view('admin.dashboard', compact('stats', 'recentOrders', 'topProducts', 'revenueChart'));
    }
}