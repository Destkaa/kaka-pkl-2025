@extends('layouts.app')

@section('content')
<style>
    /* Background & Container */
    body {
        background-color: #f8fafc;
    }

    /* Card Styling */
    .order-card {
        border-radius: 1.25rem;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    /* Table Header */
    .table thead th {
        background-color: #f1f5f9;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #64748b;
        padding: 1.25rem 1rem;
        border: none;
    }

    /* Table Body */
    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #fcfcfc;
    }

    /* Soft Badges */
    .badge-soft {
        padding: 0.5rem 0.85rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-block;
    }

    .badge-soft-warning { background-color: #fffbeb; color: #92400e; }
    .badge-soft-info { background-color: #f0f9ff; color: #075985; }
    .badge-soft-primary { background-color: #eef2ff; color: #3730a3; }
    .badge-soft-success { background-color: #f0fdf4; color: #166534; }
    .badge-soft-danger { background-color: #fef2f2; color: #991b1b; }

    /* Button Action */
    .btn-detail {
        border-radius: 0.75rem;
        padding: 0.4rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        border: 1px solid #e2e8f0;
        color: #1e293b;
    }

    .btn-detail:hover {
        background-color: #1e293b;
        color: #ffffff;
        border-color: #1e293b;
        transform: translateY(-1px);
    }

    /* Custom Pagination Styling */
    .pagination {
        margin-bottom: 0;
        gap: 6px;
    }

    .page-item .page-link {
        border-radius: 0.5rem !important;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 500;
        padding: 0.5rem 0.9rem;
    }

    .page-item.active .page-link {
        background-color: #1e293b;
        border-color: #1e293b;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1 text-dark">Daftar Pesanan Saya</h1>
            <p class="text-muted small mb-0">Lacak status dan riwayat pembelanjaan Anda</p>
        </div>
        <div class="d-none d-md-block">
             <i class="bi bi- bag-check fs-2 text-primary opacity-25"></i>
        </div>
    </div>

    <div class="card order-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">No. Order</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total Pembayaran</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="text-dark fw-medium">{{ $order->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-muted small">{{ $order->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending'    => 'badge-soft-warning',
                                        'processing' => 'badge-soft-info',
                                        'shipped'    => 'badge-soft-primary',
                                        'delivered'  => 'badge-soft-success',
                                        'cancelled'  => 'badge-soft-danger',
                                    ];
                                    $statusLabels = [
                                        'pending'    => 'Menunggu',
                                        'processing' => 'Diproses',
                                        'shipped'    => 'Dikirim',
                                        'delivered'  => 'Selesai',
                                        'cancelled'  => 'Batal',
                                    ];
                                    $class = $statusClasses[$order->status] ?? 'bg-secondary text-white';
                                    $label = $statusLabels[$order->status] ?? ucfirst($order->status);
                                @endphp
                                <span class="badge-soft {{ $class }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-detail">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-cart-x fs-1 opacity-25 d-block mb-3"></i>
                                    <span>Belum ada pesanan yang ditemukan.</span>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($orders->hasPages())
        <div class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

@endsection