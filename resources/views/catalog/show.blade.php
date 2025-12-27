@extends('layouts.app')

@section('title', $product->name)

@push('styles')
<style>
    /* 1. Image Fix (Anti-Gepeng) */
    .main-image-container {
        width: 100%;
        aspect-ratio: 1 / 1; /* Memastikan frame selalu kotak sempurna */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border-radius: 24px;
        border: 1px solid #f1f5f9;
    }

    #main-image {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Gambar tidak akan terpotong atau gepeng */
        padding: 20px;
        transition: transform 0.5s ease;
    }

    .thumb-img {
        width: 80px;
        height: 80px;
        aspect-ratio: 1 / 1;
        object-fit: cover; /* Thumbnail penuh dan rapi */
        border-radius: 12px;
        transition: all 0.2s ease;
        cursor: pointer;
        border: 2px solid transparent;
        flex-shrink: 0;
    }
    
    .thumb-img:hover, .thumb-img.active { 
        border-color: var(--bs-primary); 
        transform: translateY(-3px); 
    }

    /* 2. Soft UI Elements */
    .qty-input-group {
        background: #f1f5f9;
        border-radius: 50px;
        padding: 6px;
        display: inline-flex;
        align-items: center;
        border: 1px solid #e2e8f0;
    }

    .qty-btn {
        width: 38px;
        height: 38px;
        border-radius: 50% !important;
        background: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }

    .qty-btn:hover { background: var(--bs-primary); color: white; }

    .dot-status {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .spec-item {
        background: #f8fafc;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #f1f5f9;
        height: 100%;
    }

    .btn-pill { border-radius: 50px; padding: 12px 24px; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb bg-light px-4 py-2 rounded-pill shadow-sm d-inline-flex mb-0">
            <li class="breadcrumb-item small"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item small"><a href="{{ route('catalog.index') }}" class="text-decoration-none">Katalog</a></li>
            <li class="breadcrumb-item active small fw-bold text-truncate" style="max-width: 200px;">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        {{-- Kolom Kiri: Gambar --}}
        <div class="col-lg-6">
            <div class="position-relative mb-4">
                <div class="main-image-container shadow-sm">
                    <img src="{{ $product->image_url }}" id="main-image" alt="{{ $product->name }}">
                </div>
                
                @if($product->has_discount)
                <span class="badge bg-danger position-absolute top-0 start-0 m-4 px-3 py-2 rounded-pill shadow fs-6">
                    Hemat {{ $product->discount_percentage }}%
                </span>
                @endif
            </div>

            {{-- Thumbnail Gallery --}}
            @if($product->images->count() > 0)
            <div class="d-flex gap-3 overflow-auto pb-2 px-1">
                <img src="{{ $product->image_url }}" class="thumb-img active shadow-sm" onclick="changeMainImage(this)">
                @foreach($product->images as $image)
                <img src="{{ asset('storage/' . $image->image_path) }}" class="thumb-img shadow-sm" onclick="changeMainImage(this)">
                @endforeach
            </div>
            @endif
        </div>

        {{-- Kolom Kanan: Detail --}}
        <div class="col-lg-6">
            <div class="ps-lg-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold text-uppercase small">
                        {{ $product->category->name }}
                    </span>
                    @auth
                    <button class="btn btn-white shadow-sm rounded-circle p-2" onclick="toggleWishlist({{ $product->id }})" style="width: 40px; height: 40px;">
                        <i class="bi {{ auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart' }} fs-5"></i>
                    </button>
                    @endauth
                </div>

                <h1 class="fw-bold mb-3">{{ $product->name }}</h1>

                <div class="d-flex align-items-baseline gap-3 mb-4">
                    <h2 class="text-primary fw-bold mb-0">{{ $product->formatted_price }}</h2>
                    @if($product->has_discount)
                        <span class="text-muted text-decoration-line-through fs-5">{{ $product->formatted_original_price }}</span>
                    @endif
                </div>

                {{-- Status Stok --}}
                <div class="mb-4">
                    @if($product->stock > 0)
                        <div class="d-inline-flex align-items-center bg-success-subtle text-success px-3 py-2 rounded-pill small fw-bold">
                            <span class="dot-status bg-success me-2"></span> Stok Tersedia ({{ $product->stock }} unit)
                        </div>
                    @else
                        <div class="d-inline-flex align-items-center bg-danger-subtle text-danger px-3 py-2 rounded-pill small fw-bold">
                            <span class="dot-status bg-danger me-2"></span> Stok Habis
                        </div>
                    @endif
                </div>

                <hr class="my-4 opacity-25">

                {{-- Add to Cart Form --}}
                <form action="{{ route('cart.add') }}" method="POST" class="mb-5">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="row g-4 align-items-end">
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Jumlah</label>
                            <div class="qty-input-group w-100 justify-content-between">
                                <button type="button" class="qty-btn" onclick="decrementQty()">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                       max="{{ $product->stock }}" class="form-control border-0 bg-transparent text-center fw-bold fs-5" readonly>
                                <button type="button" class="qty-btn" onclick="incrementQty()">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <button type="submit" class="btn btn-primary btn-lg btn-pill w-100 shadow-lg" 
                                    @if($product->stock == 0) disabled @endif>
                                <i class="bi bi-cart-plus me-2"></i> Tambah Keranjang
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Tab Deskripsi & Spesifikasi --}}
                <ul class="nav nav-tabs border-0 mb-4 gap-4" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active fw-bold border-0 bg-transparent px-0 py-2" data-bs-toggle="tab" data-bs-target="#desc">Deskripsi</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link fw-bold border-0 bg-transparent text-muted px-0 py-2" data-bs-toggle="tab" data-bs-target="#spec">Info Produk</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="desc">
                        <div class="text-muted" style="line-height: 1.8;">
                            {!! $product->description !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="spec">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="spec-item">
                                    <small class="text-muted d-block">Berat</small>
                                    <span class="fw-bold">{{ $product->weight }} gram</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="spec-item">
                                    <small class="text-muted d-block">SKU</small>
                                    <span class="fw-bold">PRD-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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