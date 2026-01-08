@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold text-dark mb-1">Daftar Produk</h2>
        <p class="text-muted small mb-0">Kelola stok, harga, dan informasi produk Anda.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-dark rounded-pill px-4 shadow-sm fw-bold">
        <i class="bi bi-plus-lg me-2"></i> Tambah Produk
    </a>
</div>

{{-- Filter Card --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <div class="input-group border rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 shadow-none py-2" 
                        placeholder="Cari nama produk..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select border rounded-3 py-2 shadow-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-dark w-100 rounded-3 py-2 fw-semibold">
                    <i class="bi bi-filter me-2"></i> Terapkan Filter
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Table Card --}}
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr class="text-muted small text-uppercase tracking-wider">
                    <th class="ps-4 py-3 border-0">Produk</th>
                    <th class="py-3 border-0">Kategori</th>
                    <th class="py-3 border-0">Harga</th>
                    <th class="py-3 border-0 text-center">Stok</th>
                    <th class="py-3 border-0 text-center">Status</th>
                    <th class="pe-4 py-3 border-0 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="product-img-container me-3 rounded-3 overflow-hidden border">
                                <img src="{{ $product->primaryImage?->image_url ?? asset('img/no-image.png') }}" 
                                    alt="{{ $product->name }}" class="img-fluid">
                            </div>
                            <div>
                                <h6 class="text-dark fw-bold mb-0">{{ $product->name }}</h6>
                                <span class="text-muted x-small">ID: PRD-{{ $product->id }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-dark fw-medium">{{ $product->category->name }}</span>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </td>
                    <td class="text-center">
                        @if($product->stock <= 5)
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i>{{ $product->stock }}</span>
                        @else
                            <span class="text-dark">{{ $product->stock }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($product->is_active)
                            <span class="badge-status status-success">Aktif</span>
                        @else
                            <span class="badge-status status-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            {{-- Button Detail --}}
                            <a href="{{ route('admin.products.show', $product) }}" class="btn-action btn-action-view" title="Detail">
                                <i class="bi bi-eye"></i>
                            </a>
                            {{-- Button Edit --}}
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn-action btn-action-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            {{-- Button Hapus --}}
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-action-delete" title="Hapus">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="py-3">
                            <i class="bi bi-box-seam display-4 text-muted mb-3 d-block"></i>
                            <p class="text-muted">Data produk tidak ditemukan.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-dark rounded-pill px-3">Tambah Produk Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FOOTER DENGAN PAGINATION --}}
    <div class="card-footer bg-white py-4 px-4 border-0">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <small class="text-muted fw-medium">
                    Menampilkan <span class="text-dark">{{ $products->firstItem() ?? 0 }}</span> sampai <span class="text-dark">{{ $products->lastItem() ?? 0 }}</span> dari <span class="text-dark">{{ $products->total() }}</span> produk
                </small>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* 1. Gambar Produk */
    .product-img-container {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
    }

    /* 2. Badge Status */
    .badge-status {
        display: inline-block;
        padding: 0.4em 1em;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 50rem;
    }
    .status-success { background-color: rgba(25, 135, 84, 0.12); color: #198754; }
    .status-secondary { background-color: rgba(108, 117, 125, 0.12); color: #6c757d; }

    /* 3. TOMBOL AKSI MODERN (LEBIH BESAR & BULAT) */
    .btn-action {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        border: 1px solid #edf2f7;
        background-color: #ffffff;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .btn-action i {
        font-size: 1.1rem;
    }
    .btn-action-view:hover {
        background-color: #f0f9ff;
        border-color: #bae6fd;
        color: #0284c7;
        transform: scale(1.08);
    }
    .btn-action-edit:hover {
        background-color: #fffbeb;
        border-color: #fef3c7;
        color: #d97706;
        transform: scale(1.08);
    }
    .btn-action-delete:hover {
        background-color: #fef2f2;
        border-color: #fee2e2;
        color: #dc2626;
        transform: scale(1.08);
    }

    /* 4. MODERN PAGINATION */
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px !important;
        margin: 0 3px;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
    }
    .pagination .page-item.active .page-link {
        background-color: #1a1a1a !important;
        color: #fff !important;
    }

    /* Utility */
    .rounded-4 { border-radius: 1rem !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .x-small { font-size: 0.7rem; }
    .table thead th { background-color: #f8f9fa; font-weight: 600; }
</style>
@endsection