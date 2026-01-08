{{-- resources/views/catalog/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    /* 1. Image Fix & Container */
    .main-image-container {
        width: 100%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 16px; /* Samakan dengan katalog */
        border: 1px solid #f1f5f9;
    }

    #main-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 30px;
        transition: transform 0.5s ease;
    }

    .thumb-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 2px solid transparent;
        flex-shrink: 0;
    }
    
    .thumb-img:hover, .thumb-img.active { 
        border-color: #1a1a1a; /* Warna Hitam */
        transform: translateY(-2px); 
    }

    /* 2. TOMBOL JUMLAH MODERN */
    .qty-input-group {
        background: #f8fafc;
        border-radius: 12px; /* Tidak oval */
        padding: 4px;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
        width: 130px;
        justify-content: space-between;
    }

    .qty-btn {
        width: 32px !important;
        height: 32px !important;
        border-radius: 8px !important; /* Kotak tumpul */
        background: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
        color: #1a1a1a;
    }

    .qty-btn:hover { 
        background: #1a1a1a; 
        color: white; 
    }

    #quantity {
        width: 40px;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: 700;
        outline: none;
    }

    /* 3. Tombol Utama Hitam */
    .btn-dark-modern {
        background-color: #1a1a1a;
        color: white;
        border-radius: 12px;
        padding: 14px 28px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
    }

    .btn-dark-modern:hover {
        background-color: #000;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        color: white;
    }

    .btn-dark-modern:disabled {
        background-color: #94a3b8;
        transform: none;
    }

    /* Tabs Styling */
    .nav-tabs .nav-link {
        color: #64748b;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 10px 20px;
    }

    .nav-tabs .nav-link.active {
        color: #1a1a1a;
        border-bottom: 2px solid #1a1a1a;
        font-weight: 700;
    }

    .spec-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 15px;
        border: 1px solid #f1f5f9;
    }

    .dot-status {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item small"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Home</a></li>
            <li class="breadcrumb-item small"><a href="{{ route('catalog.index') }}" class="text-decoration-none text-muted">Katalog</a></li>
            <li class="breadcrumb-item active small fw-bold text-dark">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Kolom Kiri: Gambar --}}
        <div class="col-lg-6">
            <div class="position-relative mb-4">
                <div class="main-image-container shadow-sm border">
                    <img src="{{ $product->image_url }}" id="main-image" alt="{{ $product->name }}">
                </div>
                
                @if($product->has_discount)
                <span class="badge bg-danger position-absolute top-0 start-0 m-4 px-3 py-2 rounded-3 shadow-sm fs-6 fw-bold">
                    -{{ $product->discount_percentage }}%
                </span>
                @endif
            </div>

            {{-- Thumbnail Gallery --}}
            @if($product->images->count() > 0)
            <div class="d-flex gap-3 overflow-auto pb-2">
                <img src="{{ $product->image_url }}" class="thumb-img active border shadow-sm" onclick="changeMainImage(this)">
                @foreach($product->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" class="thumb-img border shadow-sm" onclick="changeMainImage(this)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Kolom Kanan: Detail --}}
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <div class="mb-2">
                    <span class="text-uppercase fw-bold text-muted small" style="letter-spacing: 0.1em;">
                        {{ $product->category->name }}
                    </span>
                </div>

                <h1 class="fw-bold mb-3 text-dark" style="letter-spacing: -0.02em;">{{ $product->name }}</h1>

                <div class="d-flex align-items-center gap-3 mb-4">
                    <h2 class="fw-extrabold mb-0" style="color: #1a1a1a;">{{ $product->formatted_price }}</h2>
                    @if($product->has_discount)
                        <span class="text-muted text-decoration-line-through fs-5">{{ $product->formatted_original_price }}</span>
                    @endif
                </div>

                {{-- Status Stok --}}
                <div class="mb-4">
                    @if($product->stock > 0)
                        <div class="d-inline-flex align-items-center px-0 small fw-bold text-success">
                            <span class="dot-status bg-success me-2"></span> Stok Tersedia ({{ $product->stock }} unit)
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center px-0 small fw-bold text-danger">
                            <span class="dot-status bg-danger me-2"></span> Stok Habis
                        </div>
                    @endif
                </div>

                <hr class="my-4 opacity-10">

                {{-- Form Add to Cart --}}
                <form action="{{ route('cart.add') }}" method="POST" class="mb-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="row g-3 align-items-end">
                        <div class="col-auto">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Jumlah</label>
                            <div class="qty-input-group d-flex">
                                <button type="button" class="qty-btn" onclick="decrementQty()">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                       max="{{ $product->stock }}" readonly>
                                <button type="button" class="qty-btn" onclick="incrementQty()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-dark-modern w-100 shadow-sm" 
                                    @if($product->stock == 0) disabled @endif>
                                <i class="bi bi-bag-plus me-2"></i> MASUKKAN KERANJANG
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Tabs Detail --}}
                <ul class="nav nav-tabs border-0 mb-4" id="productTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button">Deskripsi</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="spec-tab" data-bs-toggle="tab" data-bs-target="#spec" type="button">Informasi</button>
                    </li>
                </ul>

                <div class="tab-content pt-2">
                    <div class="tab-pane fade show active" id="desc">
                        <div class="text-muted" style="line-height: 1.8; font-size: 0.95rem;">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="spec">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="spec-item">
                                    <small class="text-muted d-block text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 0.05em;">Berat Produk</small>
                                    <span class="fw-bold text-dark">{{ $product->weight }} gram</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="spec-item">
                                    <small class="text-muted d-block text-uppercase mb-1" style="font-size: 0.7rem; letter-spacing: 0.05em;">Kode Produk</small>
                                    <span class="fw-bold text-dark">PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Tab --}}

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function changeMainImage(el) {
        document.getElementById('main-image').src = el.src;
        document.querySelectorAll('.thumb-img').forEach(img => img.classList.remove('active'));
        el.classList.add('active');
    }

    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    
    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
@endpush