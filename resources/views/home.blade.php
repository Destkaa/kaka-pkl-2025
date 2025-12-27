{{-- ================================================
     FILE: resources/views/home.blade.php
     FUNGSI: Halaman utama dengan UI yang lebih nyaman (Soft UI)
     ================================================ --}}

@extends('layouts.app')

@section('title', 'Beranda')

@push('styles')
<style>
    /* 1. Typography & Colors */
    :root {
        --soft-blue: #f0f7ff;
        --deep-dark: #1e293b;
        --muted-text: #64748b;
    }

    body {
        color: var(--deep-dark);
        background-color: #ffffff;
    }

    /* 2. Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom-left-radius: 50px;
        border-bottom-right-radius: 50px;
    }

    .hero-title {
        font-weight: 800;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    /* 3. Card Styling */
    .custom-card {
        border: none;
        border-radius: 20px;
        transition: all 0.3s ease;
        background: #ffffff;
    }

    .custom-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
    }

    /* 4. Category Icons */
    .category-img-wrapper {
        display: inline-block;
        padding: 8px;
        background: var(--soft-blue);
        border-radius: 50%;
        margin-bottom: 15px;
    }

    .category-img-wrapper img {
        transition: transform 0.3s ease;
    }

    .custom-card:hover .category-img-wrapper img {
        transform: scale(1.1);
    }

    /* 5. Promo Banners */
    .promo-banner {
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .promo-banner::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.05);
        z-index: -1;
    }

    /* 6. Animations */
    .floating {
        animation: float 5s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    /* 7. Utilities */
    .section-padding { padding: 80px 0; }
    .btn-pill { border-radius: 50px; padding: 12px 30px; font-weight: 600; }
</style>
@endpush

@section('content')
    {{-- Hero Section --}}
    <section class="hero-section py-5 mb-5">
        <div class="container py-lg-5">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-bold">
                        ⚡ Promo Spesial Hari Ini
                    </span>

                    <h1 class="display-4 hero-title mb-4">
                        Belanja Online <span class="text-primary">Mudah</span><br>
                        & <span class="text-success">Terpercaya</span>
                    </h1>

                    <p class="lead text-muted mb-5">
                        Temukan berbagai produk pilihan dengan kualitas terjamin. 
                        Nikmati pengalaman belanja yang lebih simpel dan aman.
                    </p>

                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-pill shadow-sm">
                             Mulai Belanja
                        </a>
                        <a href="#promo" class="btn btn-outline-dark btn-pill">
                             Lihat Promo
                        </a>
                    </div>

                    <div class="row mt-5 g-3">
                        <div class="col-auto">
                            <small class="text-muted"><i class="bi bi-check-circle-fill text-success me-2"></i>Aman</small>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted"><i class="bi bi-truck text-primary me-2"></i>Cepat</small>
                        </div>
                        <div class="col-auto">
                            <small class="text-muted"><i class="bi bi-star-fill text-warning me-2"></i>Terbaik</small>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('images/hero-shopping.svg') }}" 
                         alt="Shopping" 
                         class="img-fluid floating"
                         style="max-height: 450px;">
                </div>
            </div>
        </div>
    </section>

    {{-- Kategori Populer --}}
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kategori Populer</h2>
                <p class="text-muted">Cari produk berdasarkan kategori favorit Anda</p>
            </div>
            
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none text-dark">
                            <div class="card custom-card shadow-sm text-center h-100 p-3">
                                <div class="card-body p-0">
                                    <div class="category-img-wrapper">
                                        <img src="{{ $category->image_url }}" 
                                             alt="{{ $category->name }}" 
                                             class="rounded-circle"
                                             width="70" height="70" 
                                             style="object-fit: cover;">
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                                    <span class="badge bg-light text-muted fw-normal">{{ $category->products_count }} Produk</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Promo Banner Duo --}}
    <section class="section-padding bg-soft-light" id="promo">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="promo-banner bg-warning p-5 shadow-sm h-100 d-flex flex-column justify-content-center">
                        <h3 class="fw-bold mb-2">Flash Sale! ⚡</h3>
                        <p class="mb-4">Dapatkan diskon melimpah hingga 50% untuk semua item bertanda khusus.</p>
                        <a href="#" class="btn btn-dark btn-pill w-fit">Lihat Promo</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="promo-banner bg-info text-white p-5 shadow-sm h-100 d-flex flex-column justify-content-center">
                        <h3 class="fw-bold mb-2">Member Baru? ✨</h3>
                        <p class="mb-4">Klaim voucher belanja perdana senilai Rp 50.000 sekarang juga!</p>
                        <a href="{{ route('register') }}" class="btn btn-light btn-pill w-fit">Daftar Akun</a>
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
                    <h2 class="fw-bold mb-0">Produk Unggulan</h2>
                    <p class="text-muted mb-0">Kualitas terbaik pilihan pelanggan kami.</p>
                </div>
                <a href="{{ route('catalog.index') }}" class="btn btn-link text-decoration-none fw-bold">
                    Lihat Semua <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        @include('partials.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection