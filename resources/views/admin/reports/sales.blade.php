{{-- resources/views/admin/reports/sales.blade.php --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@push('styles')
<style>
    /* 1. Page Background & Typography */
    .content-wrapper { background-color: #f8fafc; }
    .page-heading { color: #1e293b; font-weight: 800; letter-spacing: -0.5px; }

    /* 2. Soft UI Card Styling */
    .card {
        border: none;
        border-radius: 16px;
        transition: all 0.3s ease;
    }
    .card-header {
        border-bottom: 1px solid #f1f5f9;
        font-weight: 700;
        color: #334155;
    }

    /* 3. Stats Card Enhancements */
    .stat-card {
        overflow: hidden;
        position: relative;
    }
    .stat-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.05;
        transform: rotate(-15deg);
    }

    /* 4. Progress Bar Customization */
    .progress {
        background-color: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-bar {
        border-radius: 10px;
        background: linear-gradient(45deg, #3b82f6, #60a5fa);
    }

    /* 5. Modern Filter Bar */
    .filter-section {
        background: #ffffff;
        border-radius: 20px;
        padding: 25px;
    }
    .form-label {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 8px;
    }
    .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
    }
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
    }

    /* 6. Elegant Table */
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        color: #64748b;
        border-top: none;
        padding: 15px;
    }
    .table tbody td {
        padding: 18px 15px;
        vertical-align: middle;
    }
    .order-link {
        color: #3b82f6;
        transition: color 0.2s;
    }
    .order-link:hover { color: #1d4ed8; }

</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-heading mb-1">Laporan Penjualan</h2>
            <p class="text-muted small mb-0">Pantau performa bisnis dan analisis data transaksi Anda</p>
        </div>
        <div class="d-none d-sm-block">
            <span class="badge bg-white text-dark shadow-sm py-2 px-3 rounded-pill border">
                <i class="bi bi-calendar3 me-2 text-primary"></i> 
                {{ \Carbon\Carbon::parse($dateFrom)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('d M Y') }}
            </span>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm mb-5 border-0 filter-section">
        <form method="GET" class="row align-items-end g-3">
            <div class="col-md-3">
                <label class="form-label">Rentang Mulai</label>
                <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Rentang Selesai</label>
                <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
            </div>
            <div class="col-md-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-funnel-fill me-2"></i>Terapkan Filter
                </button>
                <a href="{{ route('admin.reports.export-sales', request()->all()) }}" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                    <i class="bi bi-file-earmark-excel-fill me-2"></i>Export Excel
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-xl-4">
            <div class="card stat-card shadow-sm border-start border-success border-4 h-100">
                <div class="card-body p-4">
                    <div class="text-muted small text-uppercase fw-bold mb-1">Pendapatan Bersih</div>
                    <div class="h2 fw-bold text-dark mb-1">
                         Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="text-success small fw-bold">
                        <i class="bi bi-graph-up-arrow me-1"></i> Total omzet periode ini
                    </div>
                    <i class="bi bi-currency-dollar stat-icon-bg"></i>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-4">
            <div class="card stat-card shadow-sm border-start border-primary border-4 h-100">
                <div class="card-body p-4">
                    <div class="text-muted small text-uppercase fw-bold mb-1">Volume Penjualan</div>
                    <div class="h2 fw-bold text-dark mb-1">
                        {{ number_format($summary->total_orders ?? 0) }}
                    </div>
                    <div class="text-primary small fw-bold">
                        <i class="bi bi-cart-check me-1"></i> Pesanan berhasil dibayar
                    </div>
                    <i class="bi bi-bag-check stat-icon-bg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Category Breakdown --}}
        <div class="col-lg-5 col-xl-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart-fill me-2 text-info"></i>Penjualan per Kategori</h6>
                </div>
                <div class="card-body p-4">
                    @forelse($byCategory as $cat)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-bold text-secondary" style="font-size: 0.9rem;">{{ $cat->name }}</span>
                                <span class="fw-bold text-dark">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                @php 
                                    $percentage = ($summary->total_revenue > 0) ? ($cat->total / $summary->total_revenue) * 100 : 0;
                                @endphp
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%"></div>
                            </div>
                            <small class="text-muted mt-1 d-block">{{ number_format($percentage, 1) }}% dari total pendapatan</small>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted display-4"></i>
                            <p class="text-muted mt-2">Data tidak tersedia</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="col-lg-7 col-xl-8">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-list-stars me-2 text-warning"></i>Rincian Transaksi Terbaru</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Informasi Customer</th>
                                <th class="text-center">Waktu Transaksi</th>
                                <th class="text-end">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order) }}" class="order-link fw-bold">
                                            #{{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                        <div class="small text-muted" style="font-size: 0.75rem;">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark fw-normal border px-3 py-2 rounded-pill">
                                            {{ $order->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <span class="fw-bold text-dark">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/empty-folder.svg" alt="Empty" style="width: 150px;" class="mb-3">
                                        <p class="text-muted fw-bold">Ops! Tidak ada data transaksi ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-center">
                        {{ $orders->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection