@extends('layouts.app')

@section('content')
<style>
    /* Custom Styling untuk Katalog Gadget */
    .filter-card {
        border-radius: 16px;
        position: sticky;
        top: 20px;
        background: #ffffff;
    }
    
    .category-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px;
        border-radius: 12px;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 6px;
        font-size: 0.9rem;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .category-link:hover {
        background-color: #f3f4f6;
        color: #1a1a1a;
        transform: translateX(4px);
    }

    .category-link i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .category-link:hover i {
        transform: scale(1.2);
    }

    .category-link.active {
        background-color: #1a1a1a;
        color: #ffffff !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .category-link.active i {
        color: #ffffff !important;
        animation: pulse-icon 2s infinite;
    }

    @keyframes pulse-icon {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .category-link.active .badge {
        background-color: rgba(255,255,255,0.2) !important;
        color: #fff !important;
    }

    .section-title {
        font-weight: 800;
        letter-spacing: -0.02em;
        color: #111827;
    }

    .btn-apply {
        border-radius: 12px;
        padding: 12px;
        font-weight: 700;
        background-color: #1a1a1a;
        border: none;
        color: white;
        transition: all 0.2s;
    }

    .btn-apply:hover {
        background-color: #000;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* MODERN BLACK PAGINATION */
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px !important;
        margin: 0 4px;
        padding: 8px 16px;
        font-weight: 600;
        color: #4b5563;
        background-color: #f3f4f6;
    }

    .pagination .page-item.active .page-link {
        background-color: #1a1a1a !important;
        color: #ffffff !important;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        {{-- SIDEBAR FILTER --}}
        <div class="col-lg-3">
            <div class="card filter-card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-filter-right me-2 text-dark fs-4"></i>
                        <h5 class="section-title mb-0">Filter Gadget</h5>
                    </div>

                    <form action="{{ route('catalog.index') }}" method="GET">
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                        {{-- Kategori Gadget Section --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3" style="letter-spacing: 0.05em;">Eksplor Perangkat</label>
                            
                            {{-- Semua Produk --}}
                            <a href="{{ route('catalog.index', request()->except('category')) }}" 
                               class="category-link {{ !request('category') ? 'active' : '' }}">
                                <span><i class="bi bi-grid-fill me-2"></i> Semua Gadget</span>
                            </a>

                            @foreach($categories as $cat)
                            @php
                                $name = strtolower($cat->name);
                                $icon = 'bi-device-ssd'; // Default ikon
                                
                                // Logika Ikon Berdasarkan Nama (Lebih Spesifik)
                                if(str_contains($name, 'phone') || str_contains($name, 'hp') || str_contains($name, 'mobile')) $icon = 'bi-phone';
                                elseif(str_contains($name, 'iphone') || str_contains($name, 'apple')) $icon = 'bi-apple';
                                elseif(str_contains($name, 'android') || str_contains($name, 'samsung')) $icon = 'bi-android2';
                                elseif(str_contains($name, 'laptop') || str_contains($name, 'notebook') || str_contains($name, 'macbook')) $icon = 'bi-laptop';
                                elseif(str_contains($name, 'pc') || str_contains($name, 'komputer') || str_contains($name, 'desktop')) $icon = 'bi-display';
                                elseif(str_contains($name, 'audio') || str_contains($name, 'headset') || str_contains($name, 'earphone')) $icon = 'bi-headphones';
                                elseif(str_contains($name, 'watch') || str_contains($name, 'wearable')) $icon = 'bi-smartwatch';
                                elseif(str_contains($name, 'camera') || str_contains($name, 'kamera')) $icon = 'bi-camera-fill';
                                elseif(str_contains($name, 'tablet') || str_contains($name, 'ipad')) $icon = 'bi-tablet';
                                elseif(str_contains($name, 'acc') || str_contains($name, 'kabel') || str_contains($name, 'aksesoris')) $icon = 'bi-usb-c-fill';
                            @endphp

                            <div class="position-relative">
                                <input class="d-none" type="radio" name="category" value="{{ $cat->slug }}" id="cat-{{ $cat->id }}"
                                       {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()">
                                
                                <label for="cat-{{ $cat->id }}" class="category-link w-100 {{ request('category') == $cat->slug ? 'active' : '' }}">
                                    <span>
                                        <i class="bi {{ $icon }} me-2"></i> {{ $cat->name }}
                                    </span>
                                    <span class="badge rounded-pill bg-light text-muted fw-normal">
                                        {{ $cat->products_count ?? $cat->active_products_count }}
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-4 opacity-10">

                        {{-- Budget Section --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3" style="letter-spacing: 0.05em;">Range Budget (Rp)</label>
                            <div class="price-input-group">
                                <div class="input-group mb-2 shadow-sm rounded-3 overflow-hidden border">
                                    <span class="input-group-text bg-white border-0 text-muted small">Min</span>
                                    <input type="number" name="min_price" class="form-control border-0 ps-0"
                                        placeholder="0" value="{{ request('min_price') }}">
                                </div>
                                <div class="input-group mb-3 shadow-sm rounded-3 overflow-hidden border">
                                    <span class="input-group-text bg-white border-0 text-muted small">Max</span>
                                    <input type="number" name="max_price" class="form-control border-0 ps-0"
                                        placeholder="No limit" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-apply shadow-sm">
                                Filter Sekarang
                            </button>
                            <a href="{{ route('catalog.index') }}" class="btn btn-link btn-sm text-decoration-none text-muted fw-bold">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="section-title mb-1">
                        @if(request('q')) <i class="bi bi-search me-2"></i> Hasil: "{{ request('q') }}" @else Koleksi Gadget Terbaru @endif
                    </h4>
                    <p class="text-muted small mb-0">Menemukan {{ $products->total() }} unit gadget siap angkut</p>
                </div>

                {{-- Sort Dropdown --}}
                <div class="d-flex align-items-center gap-2">
                    <form method="GET" id="sortForm">
                        @foreach(request()->except('sort') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" class="form-select border-0 shadow-sm fw-bold text-dark rounded-3" style="cursor: pointer;" onchange="this.form.submit()">
                            <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                            <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga Termahal</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- List Produk --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                @forelse($products as $product)
                <div class="col">
                    <x-product-card :product="$product" />
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                        <i class="bi bi-cpu-fill display-4 text-muted"></i>
                    </div>
                    <h5 class="fw-bold">Waduh, barangnya nggak ada Lek...</h5>
                    <p class="text-muted">Coba ganti kata kunci atau cek filter budgetmu lagi.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">Lihat Semua Barang</a>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <small class="text-muted fw-medium">
                            Menampilkan <span class="text-dark">{{ $products->firstItem() }} - {{ $products->lastItem() }}</span> dari {{ $products->total() }} unit
                        </small>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center justify-content-md-end">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection