{{-- ================================================
FILE: resources/views/wishlist/index.blade.php
FUNGSI: Halaman daftar keinginan (Wishlist) Modern
================================================ --}}

@extends('layouts.app')

@section('title', 'Wishlist Saya')

@push('styles')
<style>
    /* Styling Header */
    .header-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0f3; /* Soft red/pink */
        color: #ff4d6d;
        border-radius: 18px;
        box-shadow: 0 10px 15px -3px rgba(255, 77, 109, 0.1);
    }

    /* Card Hover Effect */
    .wishlist-grid .col {
        transition: transform 0.3s ease;
    }
    .wishlist-grid .col:hover {
        transform: translateY(-5px);
    }

    /* Empty State Styling */
    .empty-wishlist-card {
        border: 2px dashed #e2e8f0;
        background: #f8fafc;
        border-radius: 24px;
        padding: 5rem 1rem;
    }

    .heart-float {
        animation: float 3s ease-in-out infinite;
        display: inline-block;
        color: #ff4d6d;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    
    {{-- Notifikasi Bootstrap (Muncul jika ada session success/error) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 15px;">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 15px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="d-flex align-items-center mb-5">
        <div class="header-icon me-3">
            <i class="bi bi-heart-fill fs-3"></i>
        </div>
        <div>
            <h1 class="h3 fw-bold mb-0">Wishlist Saya</h1>
            <p class="text-muted mb-0">Daftar produk yang Anda simpan untuk dibeli nanti</p>
        </div>
    </div>

    @if($products->count())
        {{-- Product Grid --}}
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 wishlist-grid">
            @foreach($products as $product)
                <div class="col">
                    {{-- Menggunakan component product-card yang sudah ada --}}
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="empty-wishlist-card text-center shadow-sm">
            <div class="mb-4">
                <div class="heart-float">
                    <i class="bi bi-heart-fill" style="font-size: 5rem; opacity: 0.2;"></i>
                </div>
            </div>
            <h3 class="fw-bold text-dark">Wishlist Anda Kosong</h3>
            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                Belum ada produk impian yang disimpan. Jelajahi katalog kami dan temukan barang favoritmu!
            </p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-search me-2"></i>Mulai Cari Produk
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Notifikasi SweetAlert jika berhasil
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                borderRadius: '15px'
            });
        @endif

        // Notifikasi SweetAlert jika gagal
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ff4d6d'
            });
        @endif
    });
</script>
@endpush