{{-- resources/views/admin/reports/sales.blade.php --}}

@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Laporan Penjualan</h2>
            <p class="text-muted small mb-0">Pantau performa bisnis dan transaksi di sini.</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control border-0 bg-light py-2 rounded-3">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control border-0 bg-light py-2 rounded-3">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn bg-purple-accent text-white rounded-pill px-4 fw-bold shadow-sm h-100 py-2">
                        <i class="bi bi-funnel-fill me-2"></i> Filter Data
                    </button>
                    <a href="{{ route('admin.reports.export-sales', request()->all()) }}" class="btn btn-outline-success rounded-pill px-4 fw-bold shadow-sm h-100 py-2">
                        <i class="bi bi-file-earmark-excel-fill me-2"></i> Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-purple-accent text-white overflow-hidden position-relative">
                <div class="card-body p-4 position-relative z-1">
                    <div class="small text-uppercase fw-bold opacity-75">Total Pendapatan</div>
                    <div class="display-6 fw-bold my-1">
                         Rp {{ number_format($summary->total_revenue ?? 0, 0, ',', '.') }}
                    </div>
                    <small class="opacity-75"><i class="bi bi-clock-history me-1"></i> Periode Terpilih</small>
                </div>
                {{-- Dekorasi Icon Background --}}
                <i class="bi bi-wallet2 position-absolute end-0 bottom-0 opacity-25 me-n3 mb-n3" style="font-size: 8rem;"></i>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden position-relative">
                <div class="card-body p-4 position-relative z-1 border-start border-4 border-primary">
                    <div class="small text-uppercase fw-bold text-muted">Total Transaksi</div>
                    <div class="display-6 fw-bold text-dark my-1">
                        {{ number_format($summary->total_orders ?? 0) }} <span class="h4 text-muted fw-normal">Order</span>
                    </div>
                    <small class="text-success fw-medium"><i class="bi bi-check-circle-fill me-1"></i> Status Lunas</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- Sales By Category --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h6 class="fw-bold mb-0 text-dark">Performa Kategori</h6>
                </div>
                <div class="card-body p-4">
                    @forelse($byCategory as $cat)
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold text-dark small">{{ $cat->name }}</span>
                                <span class="fw-bold text-purple-accent small">Rp {{ number_format($cat->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="progress rounded-pill" style="height: 8px; background-color: #f1f5f9;">
                                @php
                                    $totalRevenue = $summary->total_revenue ?? 0;
                                    $percent = ($totalRevenue > 0) ? ($cat->total / $totalRevenue) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-purple-accent rounded-pill" role="progressbar"
                                     style="width: {{ $percent }}%">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <img src="https://illustrations.popsy.co/gray/empty-folder.svg" alt="no-data" style="width: 120px;" class="mb-3 opacity-50">
                            <p class="text-muted small">Belum ada data kategori.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Transactions Table --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                     <h6 class="fw-bold mb-0 text-dark">Rincian Transaksi Terakhir</h6>
                     <span class="badge bg-light text-dark rounded-pill">Paid Status</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0 py-3 small text-uppercase text-muted">Order</th>
                                    <th class="border-0 py-3 small text-uppercase text-muted">Customer</th>
                                    <th class="border-0 py-3 small text-uppercase text-muted">Waktu</th>
                                    <th class="text-end pe-4 border-0 py-3 small text-uppercase text-muted">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td class="ps-4">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="fw-bold text-decoration-none text-purple-accent">
                                                #{{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $order->user->name }}</div>
                                            <div class="small text-muted" style="font-size: 0.75rem;">{{ $order->user->email }}</div>
                                        </td>
                                        <td class="small text-muted">
                                            {{ $order->created_at->format('d M, H:i') }}
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="py-4">
                                                <i class="bi bi-inbox text-muted display-4 d-block mb-3"></i>
                                                <p class="text-muted">Tidak ada transaksi ditemukan pada periode ini.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($orders->hasPages())
                <div class="card-footer bg-transparent border-0 p-4">
                    {{ $orders->appends(request()->all())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-purple-accent {
        background-color: #8b5cf6 !important;
    }
    .text-purple-accent {
        color: #8b5cf6 !important;
    }
    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(139, 92, 246, 0.15);
        border-color: #8b5cf6;
    }
    .progress-bar {
        transition: width 1s ease-in-out;
    }
    /* Styling Tabel Agar Lebih Modern */
    .table thead th {
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .table tbody tr {
        transition: all 0.2s;
    }
    .table tbody tr:hover {
        background-color: #f8fafc;
        transform: scale(1.002);
    }
</style>
@endsection