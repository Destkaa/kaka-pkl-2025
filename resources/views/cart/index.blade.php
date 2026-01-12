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
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; 
    }
    .cart-img-container img {
        max-width: 100%; max-height: 100%; object-fit: contain;
    }
    .card { border-radius: 16px; border: none; }
    .header-icon-box {
        width: 64px; height: 64px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 16px;
    }
    .qty-control {
        background: #f8fafc; border-radius: 12px; padding: 4px;
        display: inline-flex; align-items: center; justify-content: space-between;
        border: 1px solid #e2e8f0; width: 110px;
    }
    .qty-btn {
        width: 30px; height: 30px; border-radius: 8px !important;
        background: white; border: none; display: flex; align-items: center; justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05); transition: all 0.2s;
    }
    .qty-btn:hover { background: #1a1a1a; color: white; }
    .qty-input { width: 35px; border: none; background: transparent; text-align: center; font-weight: bold; }
    .btn-checkout {
        background-color: #1a1a1a; color: white; border: none; border-radius: 12px;
        padding: 16px; font-weight: 700; transition: all 0.3s; text-decoration: none;
    }
    .btn-checkout:hover { background-color: #000; color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
    .btn-continue {
        border-radius: 12px; padding: 10px 24px; font-weight: 600;
        border: 2px solid #e2e8f0; color: #4b5563; text-decoration: none; display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <div class="header-icon-box bg-dark text-white shadow-sm me-3">
            <i class="bi bi-cart3 fs-3"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0">Keranjang Belanja</h2>
            <p class="text-muted mb-0">Periksa kembali gadget pilihanmu sebelum checkout.</p>
        </div>
    </div>

    @if($cart && $cart->items->count())
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0 text-uppercase small fw-bold text-muted">Produk</th>
                                    <th class="text-center py-3 border-0 text-uppercase small fw-bold text-muted">Jumlah</th>
                                    <th class="text-end py-3 border-0 text-uppercase small fw-bold text-muted">Subtotal</th>
                                    <th class="py-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $grandTotal = 0; @endphp
                                @foreach($cart->items as $item)
                                    @php 
                                        // MENGGUNAKAN ACCESSOR DARI MODEL ANDA
                                        $currentPrice = (float) $item->product->display_price;
                                        $itemSubtotal = $currentPrice * $item->quantity;
                                        $grandTotal += $itemSubtotal;
                                    @endphp
                                    <tr>
                                        <td class="ps-4 py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="cart-img-container me-3">
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                                </div>
                                                <div class="min-w-0">
                                                    <a href="{{ route('catalog.show', $item->product->slug) }}" 
                                                       class="text-decoration-none text-dark fw-bold mb-1 d-block text-truncate" style="max-width: 220px;">
                                                        {{ $item->product->name }}
                                                    </a>
                                                    <div class="d-flex flex-column">
                                                        @if($item->product->has_discount)
                                                            <small class="text-muted text-decoration-line-through">
                                                                {{ $item->product->formatted_original_price }}
                                                            </small>
                                                            <span class="text-danger fw-bold small">
                                                                {{ $item->product->formatted_price }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted small">{{ $item->product->formatted_price }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST" id="update-form-{{ $item->id }}">
                                                @csrf @method('PATCH')
                                                <div class="qty-control mx-auto">
                                                    <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, -1)"><i class="bi bi-dash-lg"></i></button>
                                                    <input type="number" name="quantity" id="qty-{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="qty-input" readonly>
                                                    <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, 1)"><i class="bi bi-plus-lg"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                        <td class="text-end fw-bold text-dark">
                                            Rp {{ number_format($itemSubtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center pe-4">
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link text-muted p-0" onclick="return confirm('Hapus item?')"><i class="bi bi-x-lg"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <a href="{{ route('catalog.index') }}" class="btn btn-continue"><i class="bi bi-arrow-left me-2"></i>Kembali Belanja</a>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Unit</span>
                        <span class="fw-bold">{{ $cart->items->sum('quantity') }} Item</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-4 opacity-10">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h6 mb-0 fw-bold">Total</span>
                        <span class="h4 mb-0 fw-bold text-dark">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-checkout w-100 d-flex justify-content-center align-items-center">
                        LANJUT KE CHECKOUT <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card shadow-sm py-5 text-center border-0">
        <div class="card-body py-5">
            <div class="bg-light d-inline-block p-4 rounded-circle mb-4"><i class="bi bi-cart-x display-4 text-muted"></i></div>
            <h3 class="fw-bold">Keranjangmu Kosong</h3>
            <a href="{{ route('catalog.index') }}" class="btn btn-checkout px-5 mt-3">Mulai Belanja</a>
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
        let newVal = parseInt(input.value) + change;
        if (newVal >= 1 && newVal <= parseInt(input.max)) {
            input.value = newVal;
            form.submit();
        }
    }
</script>
@endpush