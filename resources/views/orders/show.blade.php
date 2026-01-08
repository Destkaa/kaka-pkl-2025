@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <nav aria-label="breadcrumb" class="mb-4">
                <a href="{{ route('orders.index') }}" class="btn btn-link link-dark p-0 text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pesanan
                </a>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-4 px-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-md-start text-center">
                            <span class="text-uppercase text-muted small fw-bold">Detail Transaksi</span>
                            <h1 class="h3 mb-1 fw-bold">#{{ $order->order_number }}</h1>
                            <p class="text-secondary small mb-0">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <div class="col-md-6 text-md-end text-center mt-3 mt-md-0">
                            <span class="badge rounded-pill px-4 py-2 border {{ $order->status == 'pending' ? 'bg-warning-subtle text-warning border-warning' : 'bg-success-subtle text-success border-success' }}">
                                {{ strtoupper($order->status == 'pending' ? 'Menunggu Pembayaran' : $order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="p-4">
                        <h3 class="h6 fw-bold text-uppercase mb-4 border-start border-primary border-4 ps-2">Item Pesanan</h3>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end">Harga Satuan</th>
                                        <th class="text-end pe-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <span class="fw-bold d-block">{{ $item->product_name }}</span>
                                            <small class="text-muted">ID: {{ $item->product_id }}</small>
                                        </td>
                                        <td class="text-center fw-medium">{{ $item->quantity }}</td>
                                        <td class="text-end">
                                            @php
                                                $hargaNormal = (float) $item->product->price;
                                                $hargaBeli = (float) $item->price;
                                            @endphp
                                            @if($hargaBeli < $hargaNormal)
                                                <div class="small text-muted text-decoration-line-through">Rp {{ number_format($hargaNormal, 0, ',', '.') }}</div>
                                                <div class="text-success fw-bold">Rp {{ number_format($hargaBeli, 0, ',', '.') }}</div>
                                            @else
                                                <div class="fw-medium">Rp {{ number_format($hargaBeli, 0, ',', '.') }}</div>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold pe-3">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row g-0 border-top mt-2">
                        <div class="col-md-7 p-4 bg-light border-end">
                            <h6 class="fw-bold text-uppercase mb-3 small">Alamat Pengiriman</h6>
                            <div class="bg-white p-3 rounded shadow-sm border border-light">
                                <p class="mb-1 fw-bold text-dark">{{ $order->shipping_name }}</p>
                                <p class="mb-1 small text-secondary">{{ $order->shipping_phone }}</p>
                                <p class="mb-0 small text-muted">{{ $order->shipping_address }}</p>
                            </div>
                        </div>
                        <div class="col-md-5 p-4">
                            @php
                                $subtotalNormal = $order->items->sum(fn($i) => $i->product->price * $i->quantity);
                                $totalBayar = $order->total_amount;
                                $hemat = $subtotalNormal - $totalBayar;
                            @endphp
                            <div class="d-flex justify-content-between mb-2 small text-secondary">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotalNormal, 0, ',', '.') }}</span>
                            </div>
                            @if($hemat > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-success fw-bold small">Hemat Belanja</span>
                                <span class="text-success fw-bold">-Rp {{ number_format($hemat, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Bayar</span>
                                <span class="h4 fw-bold text-primary mb-0">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($order->status === 'pending' && $order->snap_token)
                <div class="card-footer bg-white p-4 text-center border-top-0">
                    <button id="pay-button" class="btn btn-primary btn-lg px-5 rounded-pill shadow fw-bold">Bayar Sekarang</button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .rounded-4 { border-radius: 1rem !important; }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
</style>

@if($order->snap_token)
@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const payButton = document.getElementById('pay-button');
    payButton.onclick = function() {
        window.snap.pay('{{ $order->snap_token }}', {
            onSuccess: function(result) { window.location.href = "{{ route('orders.index') }}"; },
            onPending: function(result) { location.reload(); },
            onError: function(result) { alert("Gagal!"); }
        });
    };
</script>
@endpush
@endif
@endsection