{{-- resources/views/admin/reports/sales.blade.php --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
    /* Custom Dashboard Styling */
    .report-card {
        transition: all 0.3s ease;
        border-radius: 15px;
        border: none;
    }
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }
    .table-container {
        border-radius: 15px;
        overflow: hidden;
    }
    .table thead th {
        background-color: #f8f9fc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #4e73df;
        padding: 15px;
    }
    .progress {
        height: 8px !important;
        border-radius: 10px;
        background-color: #eaecf4;
    }
    .progress-bar {
        background: linear-gradient(90deg, #4e73df, #224abe);
    }
    .filter-section {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
    }
    .badge-paid {
        background-color: rgba(28, 200, 138, 0.1);
        color: #1cc88a;
        padding: 5px 12px;
        border-radius: 8px;
        font-weight: 600;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-0 text-gray-800 fw-bold">Laporan Penjualan</h2>
            <p class="text-muted small mb-0">Pantau performa bisnis dan transaksi harian Anda.</p>
        </div>
        <div class="text-muted small">
            <i class="bi bi-calendar3 me-1"></i> Periode: <strong>{{ $dateFrom }}</strong> s/d <strong>{{ $dateTo }}</strong>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 filter-section">
        <form method="GET" class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted text-uppercase">Dari Tanggal</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control shadow-none">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold small text-muted text-uppercase">Sampai Tanggal</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control shadow-none">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 shadow-sm">
                    <i class="bi bi-funnel me-1"></i> Filter
                </button>
                <a href="{{ route('admin.reports.export-sales', request()->all()) }}" class="btn btn-success px-4 shadow-sm">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
                </a>
            </div>
        </form>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-sm h-100 report-card border-start border-4 border-success">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-success text-white me-3 shadow-sm">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Total Pendapatan</div>
                        <div class="h3 fw-bold text-dark mb-0">Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-sm h-100 report-card border-start border-4 border-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="stat-icon bg-primary text-white me-3 shadow-sm">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase fw-bold">Total Transaksi</div>
                        <div class="h3 fw-bold text-dark mb-0">{{ number_format($summary->total_orders ?? 0) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100 table-container">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title mb-0 fw-bold">Performa Kategori</h5>
                </div>
                <div class="card-body">
                    @forelse($byCategory as $cat)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold text-dark small">{{ $cat->name }}</span>
                                <span class="text-primary small">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ ($cat->total / ($summary->total_revenue ?: 1)) * 100 }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">Data kategori tidak tersedia</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100 table-container">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Rincian Transaksi Terkini</h5>
                    <span class="badge badge-paid">Paid Only</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th class="text-end">Total Ammount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-primary text-decoration-none">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark small">{{ $order->user->name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="small text-muted">
                                        {{ $order->created_at->format('d M Y') }}<br>
                                        <span class="text-gray-400" style="font-size: 0.7rem;">{{ $order->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    <td class="text-end pe-3 fw-bold text-dark">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-inbox fs-2 text-gray-300 d-block mb-2"></i>
                                        <p class="text-muted">Tidak ada data penjualan pada periode ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white py-3 border-0">
                    <div class="d-flex justify-content-center">
                        {{ $orders->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection