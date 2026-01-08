{{-- ================================================
FILE: resources/views/cart/index.blade.php
FUNGSI: Halaman keranjang belanja dengan Logika Harga Diskon
================================================ --}}

@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@push('styles')
<style>
    .cart-img-container {
        width: 80px;
        height: 80px;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; 
    }
    .cart-img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .card { border-radius: 20px; border: none; }
    .header-icon-box {
        width: 64px; height: 64px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%;
    }
    .qty-control {
        background: #f1f5f9;
        border-radius: 50px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
        width: 110px;
    }
    .qty-btn {
        width: 32px; height: 32px;
        border-radius: 50% !important;
        background: white; border: none;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }
    .qty-btn:hover { background: var(--bs-primary); color: white; }
    .qty-input {
        width: 35px; border: none; background: transparent;
        text-align: center; font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    {{-- Header --}}
    <div class="d-flex align-items-center mb-5">
        <div class="header-icon-box bg-primary bg-opacity-10 text-primary shadow-sm me-3">
            <i class="bi bi-cart3 fs-3"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0">Keranjang Belanja</h2>
            <p class="text-muted mb-0">Periksa kembali belanjaan Anda sebelum checkout.</p>
        </div>
    </div>

    @if($cart && $cart->items->count())
    <div class="row g-4">
        {{-- List Item --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">PRODUK</th>
                                    <th class="text-center py-3 border-0">JUMLAH</th>
                                    <th class="text-end py-3 border-0">SUBTOTAL</th>
                                    <th class="py-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($cart->items as $item)
                                    @php 
                                        // AMBIL HARGA DISKON JIKA ADA (Logika di Model Product)
                                        $currentPrice = $item->product->display_price ?? 0;
                                        $itemSubtotal = $currentPrice * $item->quantity;
                                        $grandTotal += $itemSubtotal;
                                    @endphp
                                    <tr>
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="cart-img-container me-3 shadow-sm">
                                                    <img src="{{ $item->product?->image_url ?? asset('images/placeholder.png') }}" 
                                                         alt="{{ $item->product?->name }}">
                                                </div>
                                                <div class="min-w-0">
                                                    @if($item->product)
                                                        <a href="{{ route('catalog.show', $item->product->slug) }}" 
                                                           class="text-decoration-none text-dark fw-bold mb-1 d-block text-truncate" style="max-width: 220px;">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        <div class="d-flex align-items-center gap-2">
                                                            @if($item->product->has_discount)
                                                                <span class="text-muted small text-decoration-line-through">
                                                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                                </span>
                                                                <span class="text-success fw-bold small">
                                                                    Rp {{ number_format($currentPrice, 0, ',', '.') }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted small">Rp {{ number_format($currentPrice, 0, ',', '.') }}</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-danger fw-bold small">Produk Tidak Tersedia</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="text-center">
                                            @if($item->product)
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" id="update-form-{{ $item->id }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="qty-control shadow-sm mx-auto">
                                                    <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, -1)">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" name="quantity" id="qty-{{ $item->id }}" 
                                                           value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock ?? 999 }}"
                                                           class="qty-input" readonly>
                                                    <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, 1)">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            @endif
                                        </td>

                                        <td class="text-end fw-bold text-dark">
                                            Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                        </td>

                                        <td class="text-center pe-4">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger border shadow-sm" 
                                                        onclick="return confirm('Hapus item ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
            </a>
        </div>

        {{-- Ringkasan --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Unit</span>
                        <span class="fw-bold">{{ $cart->items->sum('quantity') }} Item</span>
                    </div>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h6 mb-0 fw-bold">Total Harga</span>
                        <span class="h4 mb-0 fw-bold text-primary">
                            Rp {{ number_format($grandTotal, 0, ',', '.') }}
                        </span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg w-100 rounded-pill shadow py-3 fw-bold">
                        Lanjut ke Checkout <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card shadow-sm border-0 py-5 text-center">
        <div class="card-body py-5">
            <i class="bi bi-cart-x display-1 text-muted mb-4"></i>
            <h3 class="fw-bold">Keranjangmu Kosong</h3>
            <p class="text-muted mb-4">Sepertinya Anda belum memilih produk apa pun.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                Cari Produk Sekarang
            </a>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function updateQty(itemId, change) {
        const input = document.getElementById('qty-' + itemId);
        const form = document.getElementById('update-form-' + itemId);
        if(!input || !form) return;

        let currentVal = parseInt(input.value);
        let maxVal = parseInt(input.max) || 999;
        let newVal = currentVal + change;

        if (newVal >= 1 && newVal <= maxVal) {
            input.value = newVal;
            form.style.opacity = '0.5';
            form.submit();
        }
    }
</script>
@endpush