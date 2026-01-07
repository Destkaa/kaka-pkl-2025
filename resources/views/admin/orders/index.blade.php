@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@push('styles')
<style>
    /* Global Card & Table */
    .card-stats {
        border-radius: 16px;
        transition: transform 0.2s;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .card-stats:hover { transform: translateY(-5px); }
    
    /* Elegant Table Style */
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
        border: none;
    }

    /* Soft Badge Styles with Icons */
    .badge-soft {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .bg-soft-warning { background-color: #fff9db; color: #f08c00; }
    .bg-soft-info    { background-color: #e7f5ff; color: #1c7ed6; }
    .bg-soft-success { background-color: #ebfbee; color: #37b24d; }
    .bg-soft-danger  { background-color: #fff5f5; color: #f03e3e; }
    .bg-soft-secondary { background-color: #f1f3f5; color: #495057; }

    /* Nav Pills Modern */
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 20px;
    }
    .nav-pills .nav-link.active {
        background-color: #111;
        color: #fff;
    }

    /* Pagination (Same as yours) */
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px !important;
        padding: 8px 16px;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
    }
    .pagination .page-item.active .page-link {
        background-color: #111 !important;
        color: #fff !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    
    {{-- HEADER --}}
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold text-dark mb-0">Pesanan</h3>
            <p class="text-muted mb-0">Kelola dan pantau pesanan pelanggan Anda.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.reports.export-sales') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold">
                <i class="bi bi-download me-2"></i>Export Report
            </a>
        </div>
    </div>

    {{-- QUICK STATS WITH ICONS --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-stats shadow-sm border-0 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-bold text-uppercase">Total Pesanan</small>
                        <h3 class="fw-bold mb-0 mt-1">{{ $orders->total() }}</h3>
                    </div>
                    <div class="bg-light p-2 rounded-3 text-dark">
                        <i class="bi bi-cart-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm border-0 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-bold text-uppercase text-warning">Pending</small>
                        <h3 class="fw-bold mb-0 mt-1">{{ \App\Models\Order::where('status', 'pending')->count() }}</h3>
                    </div>
                    <div class="bg-soft-warning p-2 rounded-3">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm border-0 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-bold text-uppercase text-info">Proses</small>
                        <h3 class="fw-bold mb-0 mt-1">{{ \App\Models\Order::where('status', 'processing')->count() }}</h3>
                    </div>
                    <div class="bg-soft-info p-2 rounded-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm border-0 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted fw-bold text-uppercase text-success">Selesai</small>
                        <h3 class="fw-bold mb-0 mt-1">{{ \App\Models\Order::where('status', 'completed')->count() }}</h3>
                    </div>
                    <div class="bg-soft-success p-2 rounded-3">
                        <i class="bi bi-check-circle-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN TABLE CARD --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 px-4 border-0">
            <ul class="nav nav-pills gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'processing' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Proses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'shipped' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'shipped']) }}">Dikirim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'completed']) }}">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">Batal</a>
                </li>
            </ul>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No. Order</th>
                        <th>Pelanggan</th>
                        <th>Waktu Transaksi</th>
                        <th>Total</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $order->order_number ?? $order->id }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->user->name }}</div>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>
                                <div class="small fw-medium">{{ $order->created_at->format('d M Y') }}</div>
                                <div class="small text-muted">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-center">
                                @switch($order->status)
                                    @case('pending') 
                                        <span class="badge-soft bg-soft-warning"><i class="bi bi-clock"></i> Pending</span> 
                                        @break
                                    @case('processing') 
                                        <span class="badge-soft bg-soft-info"><i class="bi bi-gear-fill"></i> Proses</span> 
                                        @break
                                    @case('shipped') 
                                        <span class="badge-soft bg-soft-info"><i class="bi bi-truck"></i> Dikirim</span> 
                                        @break
                                    @case('completed') 
                                        <span class="badge-soft bg-soft-success"><i class="bi bi-check-all"></i> Selesai</span> 
                                        @break
                                    @case('cancelled') 
                                        <span class="badge-soft bg-soft-danger"><i class="bi bi-x-circle"></i> Batal</span> 
                                        @break
                                    @default 
                                        <span class="badge-soft bg-soft-secondary">{{ $order->status }}</span>
                                @endswitch
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold shadow-sm">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                                    <p class="text-muted mt-3">Tidak ada data pesanan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white py-4 px-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <small class="text-muted fw-medium">
                        Menampilkan <span class="text-dark">{{ $orders->firstItem() ?? 0 }}</span> - <span class="text-dark">{{ $orders->lastItem() ?? 0 }}</span> dari <span class="text-dark">{{ $orders->total() }}</span> pesanan
                    </small>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection