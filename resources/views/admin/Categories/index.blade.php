@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* ===== MODERN SOFT UI ===== */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header-elegant {
        background-color: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.25rem 1.5rem;
    }

    .table thead th {
        background-color: #f8f9fa;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
        color: #6c757d;
        border-top: none;
        padding: 1rem 0.75rem;
    }
    
    .table tbody tr:hover {
        background-color: #fcfcfc;
    }

    /* Soft Badges */
    .badge-soft-info {
        background-color: #e5f6fd; color: #03a9f4; border: none;
    }
    .badge-soft-success {
        background-color: #e6fcf5; color: #08d192; border: none;
    }
    .badge-soft-secondary {
        background-color: #f1f3f5; color: #495057; border: none;
    }

    /* Tombol Tambah Kategori (Hitam & Bulat) */
    .btn-add-category {
        background-color: #1a1a1a;
        color: #ffffff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-add-category:hover {
        background-color: #000000;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Styling Tombol Aksi (Lebih Besar & Nyaman) */
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
    }
    .btn-action i {
        font-size: 1.1rem;
    }
    .btn-action-edit:hover {
        background-color: #ebf4ff;
        border-color: #bee3f8;
        color: #3182ce;
        transform: scale(1.05);
    }
    .btn-action-delete:hover {
        background-color: #fff5f5;
        border-color: #fed7d7;
        color: #e53e3e;
        transform: scale(1.05);
    }

    .category-img-wrapper {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- FLASH MESSAGE --}}
        @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header-elegant d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Daftar Kategori</h5>
                    <p class="text-muted small mb-0">Kelola dan organisir kategori produk Anda</p>
                </div>
                <button class="btn btn-add-category rounded-pill px-4 py-2 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Kategori</th>
                                <th class="text-center">Total Produk</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        @if($category->image)
                                            <img src="{{ Storage::url($category->image) }}" class="category-img-wrapper me-3 border shadow-sm">
                                        @else
                                            <div class="category-img-wrapper bg-light d-flex align-items-center justify-content-center me-3 border">
                                                <i class="bi bi-image text-muted fs-5"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                                            <div class="text-muted small">/{{ $category->slug }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <span class="badge badge-soft-info px-3 py-2 rounded-pill fw-semibold">
                                        {{ $category->products_count }} Produk
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($category->is_active)
                                        <span class="badge badge-soft-success px-3 py-2 rounded-pill">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 6px; vertical-align: middle;"></i> Aktif
                                        </span>
                                    @else
                                        <span class="badge badge-soft-secondary px-3 py-2 rounded-pill">
                                            <i class="bi bi-circle-fill me-1" style="font-size: 6px; vertical-align: middle;"></i> Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Tombol Edit yang Diperbesar --}}
                                        <button class="btn-action btn-action-edit shadow-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $category->id }}" title="Edit">
                                            <i class="bi bi-pencil-square text-primary"></i>
                                        </button>

                                        {{-- Tombol Hapus yang Diperbesar --}}
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus kategori ini?')" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete shadow-sm" title="Hapus">
                                                <i class="bi bi-trash3-fill text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="opacity-25 mb-3">
                                    <p class="text-muted mb-0">Belum ada kategori tersedia.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>
@endsection