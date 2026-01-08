{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama dengan UI Premium (Deep Purple & Gadget Style)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* 1. Typography & Colors */
    :root {
        --soft-blue: #f8fafc;
        --deep-purple-black: #1a1625; /* Hitam Keunguan Pekat */
        --accent-purple: #6366f1;     /* Ungu Terang untuk Aksen */
        --muted-text: #64748b;
    }

    body {
        color: var(--deep-purple-black);
        background-color: #ffffff;
    }

    /* 2. Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #fdfdff 0%, #f5f3ff 100%);
        border-bottom-left-radius: 60px;
        border-bottom-right-radius: 60px;
    }

    .hero-title {
        font-weight: 800;
        letter-spacing: -1.5px;
        line-height: 1.1;
        color: var(--deep-purple-black);
    }

    .text-purple-gadget {
        color: var(--accent-purple);
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* 3. Card Styling */
    .custom-card {
        border: 1px solid rgba(0,0,0,0.03);
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: #ffffff;
    }

    .custom-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(26, 22, 37, 0.1) !important;
    }

    /* 4. Category Icons */
    .category-img-wrapper {
        display: inline-block;
        padding: 12px;
        background: #f3f0ff;
        border-radius: 20px;
        margin-bottom: 15px;
    }

    /* 5. Promo Banners */
    .promo-banner {
        border-radius: 30px;
        overflow: hidden;
        border: none;
    }

    .bg-deep-purple {
        background-color: var(--deep-purple-black) !important;
    }

    /* 6. Animations */
    .floating {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-25px); }
    }

    /* 7. Buttons */
    .btn-pill { 
        border-radius: 50px; 
        padding: 14px 32px; 
        font-weight: 700; 
        transition: all 0.3s;
    }
    
    .btn-deep-purple {
        background-color: var(--deep-purple-black);
        color: white;
        border: none;
    }

    .btn-deep-purple:hover {
        background-color: #2d263f;
        color: white;
        box-shadow: 0 10px 20px rgba(26, 22, 37, 0.2);
    }

    .section-padding { padding: 90px 0; }
</style>
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section py-5 mb-5">
        <div class="container py-lg-5">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <span class="badge mb-3 px-3 py-2 rounded-pill shadow-sm" 
                          style="background-color: #f3f0ff; color: var(--accent-purple); border: 1px solid #e0d7ff;">
                        ⚡ Tech Deals of the Day
                    </span>

                    <h1 class="display-3 hero-title mb-4">
                        Belanja Online <span class="text-purple-gadget">Mudah</span><br>
                        & <span class="fw-black">Terpercaya.</span>
                    </h1>

                    <p class="lead text-muted mb-5 fs-5">
                        Dapatkan akses eksklusif ke gadget generasi terbaru dengan jaminan keaslian 100% dan pengiriman secepat kilat.
                    </p>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('catalog.index') }}" class="btn btn-deep-purple btn-pill shadow-sm">
                             Mulai Belanja
                        </a>
                        <a href="#promo" class="btn btn-outline-dark btn-pill">
                             Lihat Promo
                        </a>
                    </div>

                    <div class="row mt-5 g-4">
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-check text-primary fs-4 me-2"></i>
                                <span class="fw-bold small">Original Gurantee</span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-lightning-charge-fill text-warning fs-4 me-2"></i>
                                <span class="fw-bold small">Fast Delivery</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block text-center">
                    {{-- Ganti source gambar ini dengan aset gadget milikmu --}}
                    <img src="{{ asset('images/hero-shopping.svg') }}" 
                         alt="Shopping" 
                         class="img-fluid floating"
                         style="max-height: 500px;">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori Populer --}}
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold display-6">Cari Kategori</h2>
                <p class="text-muted">Temukan perangkat yang sesuai dengan kebutuhan produktivitasmu</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none text-dark">
                            <div class="card custom-card text-center h-100 p-4">
                                <div class="card-body p-0">
                                    <div class="category-img-wrapper">
                                        <img src="{{ $category->image_url }}" 
                                             alt="{{ $category->name }}" 
                                             class="rounded-circle"
                                             width="60" height="60" 
                                             style="object-fit: cover;">
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                                    <small class="text-muted">{{ $category->products_count }} Unit</small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promo Banner --}}
    <section class="section-padding bg-light" id="promo">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="promo-banner bg-deep-purple p-5 shadow-lg h-100 d-flex flex-column justify-content-center text-white">
                        <h3 class="fw-bold mb-2 text-warning">Flash Sale! ⚡</h3>
                        <p class="opacity-75 mb-4">Potongan harga gila-gilaan untuk seri Laptop Gaming minggu ini.</p>
                        <a href="#" class="btn btn-light btn-pill w-fit text-dark fw-bold">Ambil Diskon</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="promo-banner p-5 shadow-sm h-100 d-flex flex-column justify-content-center" 
                         style="background: linear-gradient(45deg, #6366f1, #a855f7); color: white;">
                        <h3 class="fw-bold mb-2">Member Rewards ✨</h3>
                        <p class="opacity-75 mb-4">Kumpulkan poin setiap transaksi dan tukarkan dengan aksesoris keren.</p>
                        <a href="{{ route('register') }}" class="btn btn-light btn-pill w-fit text-dark fw-bold">Gabung Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Produk Unggulan --}}
    <section class="section-padding">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5">
                <div>
                    <h2 class="fw-bold mb-0">Rekomendasi Utama</h2>
                    <p class="text-muted mb-0">Dipilih khusus berdasarkan rating tertinggi bulan ini.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="btn btn-link text-decoration-none fw-bold p-0" style="color: var(--accent-purple);">
                    Lihat Katalog <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <x-product-card :product="$product" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection