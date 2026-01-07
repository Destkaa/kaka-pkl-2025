@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* ===== MODERN SOFT UI ===== */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    /* Header styling yang elegan */
    .card-header-elegant {
        background-color: #ffffff;
        border-bottom: 1px solid #f0f0f0;
        padding: 1.25rem 1.5rem;
    }

    /* Table styling */
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
        background-color: #e5f6fd;
        color: #03a9f4;
        border: none;
    }
    .badge-soft-success {
        background-color: #e6fcf5;
        color: #08d192;
        border: none;
    }
    .badge-soft-secondary {
        background-color: #f1f3f5;
        color: #495057;
        border: none;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .modal-header {
        border-bottom: 1px solid #f0f0f0;
        padding: 1.5rem;
    }
    .modal-footer {
        border-top: 1px solid #f0f0f0;
        background-color: #f8f9fa;
        padding: 1rem 1.5rem;
    }

    /* Form control refinement */
    .form-control, .form-check-input {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #dee2e6;
    }
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
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
            {{-- CARD HEADER --}}
            <div class="card-header-elegant d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Daftar Kategori</h5>
                    <p class="text-muted small mb-0">Kelola dan organisir kategori produk Anda</p>
                </div>
                <button class="btn btn-primary btn-sm px-3 py-2 fw-semibold rounded-3" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>

            {{-- TABLE --}}
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
                                        <button class="btn btn-sm btn-light border" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $category->id }}" title="Edit">
                                            <i class="bi bi-pencil text-primary"></i>
                                        </button>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border" title="Hapus">
                                                <i class="bi bi-trash text-danger"></i>
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

{{-- ================= EDIT MODAL ================= --}}
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="modal-header bg-white">
                <h5 class="modal-title fw-bold text-dark">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">Gambar Kategori</label>
                    <input type="file" name="image" class="form-control">
                    <small class="text-muted mt-1 d-block">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                </div>

                <div class="form-check form-switch p-3 bg-light rounded-3">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="is_active" id="editActive{{ $category->id }}" value="1" {{ $category->is_active ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="editActive{{ $category->id }}">Kategori Aktif</label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- ================= CREATE MODAL ================= --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-header bg-white">
                <h5 class="modal-title fw-bold text-dark">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Elektronik, Pakaian, dll" required>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold text-uppercase text-muted">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="form-check form-switch p-3 bg-light rounded-3">
                    <input class="form-check-input ms-0 me-2" type="checkbox" name="is_active" id="createActive" value="1" checked>
                    <label class="form-check-label fw-semibold" for="createActive">Langsung Aktifkan Kategori</label>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>
@endsection