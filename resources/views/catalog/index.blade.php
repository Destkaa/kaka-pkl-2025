{{-- ======================================== 
FILE: resources/views/catalog/index.blade.php 
STYLE: Modern Marketplace Style
======================================== --}}

@extends('layouts.app')

@section('content')
<style>
    /* Custom Styling untuk Katalog */
    .filter-card {
        border-radius: 16px;
        position: sticky;
        top: 20px;
    }
    
    .category-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        border-radius: 10px;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 4px;
        font-size: 0.95rem;
    }

    .category-link:hover, .category-link.active {
        background-color: #f3f4f6;
        color: #0d6efd;
        font-weight: 600;
    }

    .price-input-group .form-control {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 8px 12px;
    }

    .section-title {
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .btn-apply {
        border-radius: 10px;
        padding: 10px;
        font-weight: 600;
    }

    /* Menghilangkan panah di input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3">
            <div class="card filter-card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-sliders2 me-2 text-primary"></i>
                        <h5 class="section-title mb-0">Filter Produk</h5>
                    </div>

                    <form action="{{ route('catalog.index') }}" method="GET">
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                        {{-- Filter Kategori --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3">Kategori</label>
                            
                            {{-- Opsi Semua Kategori --}}
                            <a href="{{ route('catalog.index', request()->except('category')) }}" 
                               class="category-link {{ !request('category') ? 'active' : '' }}">
                                <span>Semua Produk</span>
                            </a>

                            @foreach($categories as $cat)
                            <div class="position-relative">
                                <input class="d-none" type="radio" name="category" value="{{ $cat->slug }}" id="cat-{{ $cat->id }}"
                                       {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()">
                                
                                <label for="cat-{{ $cat->id }}" class="category-link cursor-pointer w-100 {{ request('category') == $cat->slug ? 'active' : '' }}">
                                    <span>{{ $cat->name }}</span>
                                    <span class="badge rounded-pill bg-light text-muted fw-normal">{{ $cat->products_count }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <hr class="opacity-10 my-4">

                        {{-- Filter Harga --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3">Rentang Harga</label>
                            <div class="price-input-group">
                                <div class="input-group mb-2 shadow-sm rounded-3">
                                    <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                                    <input type="number" name="min_price" class="form-control border-start-0 ps-0"
                                        placeholder="Minimum" value="{{ request('min_price') }}">
                                </div>
                                <div class="input-group mb-3 shadow-sm rounded-3">
                                    <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                                    <input type="number" name="max_price" class="form-control border-start-0 ps-0"
                                        placeholder="Maksimum" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-apply shadow-sm">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('catalog.index') }}" class="btn btn-link btn-sm text-decoration-none text-muted">
                                Reset Semua
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            {{-- Header Katalog --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="section-title mb-1">
                        @if(request('q')) Hasil pencarian "{{ request('q') }}" @else Koleksi Produk @endif
                    </h4>
                    <p class="text-muted small mb-0">Menampilkan {{ $products->count() }} produk berkualitas</p>
                </div>

                {{-- Sorting Modern --}}
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small d-none d-sm-block text-nowrap">Urutkan:</span>
                    <form method="GET">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="form-select border-0 shadow-sm fw-semibold text-dark" style="border-radius: 10px;" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga: Terendah</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- Grid Produk --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($products as $product)
                <div class="col">
                    {{-- Di sini asumsikan x-product-card sudah Anda perbaiki stylenya --}}
                    <x-product-card :product="$product" />
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                        <i class="bi bi-search display-4 text-muted"></i>
                    </div>
                    <h5 class="fw-bold">Yah, produk tidak ditemukan...</h5>
                    <p class="text-muted mx-auto" style="max-width: 350px;">
                        Coba sesuaikan rentang harga atau pilih kategori lain untuk menemukan apa yang kamu cari.
                    </p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary rounded-pill px-4 fw-bold">Lihat Semua Produk</a>
                </div>
                @endforelse
            </div>

            {{-- Pagination Modern --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection