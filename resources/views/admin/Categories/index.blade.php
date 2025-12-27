{{-- ======================================== 
FILE: resources/views/admin/categories/index.blade.php 
FUNGSI: Manajemen kategori dengan Image Preview & UI Modern
======================================== --}}

@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@push('styles')
<style>
    /* ===== UI CONSISTENCY ===== */
    .bi::before { display: inline-block; vertical-align: middle; }
    
    .category-img-container {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
        border: 1px solid #eee;
    }

    /* Badge Status */
    .badge-status {
        display: inline-block;
        padding: 0.4em 1em;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 50rem;
    }
    .status-success { background-color: rgba(25, 135, 84, 0.12); color: #198754; }
    .status-secondary { background-color: rgba(108, 117, 125, 0.12); color: #6c757d; }
    .status-info { background-color: rgba(13, 202, 240, 0.12); color: #087990; }

    /* Preview Image Box */
    .img-preview-box {
        width: 100%;
        max-height: 200px;
        border-radius: 12px;
        overflow: hidden;
        display: none; /* Sembunyi jika tidak ada gambar */
        border: 2px dashed #ddd;
        margin-top: 10px;
        text-align: center;
    }
    .img-preview-box img {
        max-width: 100%;
        height: auto;
    }

    /* Modal Styling */
    .modal-content { border: none; border-radius: 1.25rem; overflow: hidden; }
    .btn-icon {
        width: 32px; height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 mb-4 overflow-hidden">
            {{-- Header --}}
            <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-0">
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-tags text-primary me-2"></i> Manajemen Kategori
                    </h5>
                    <p class="text-muted small mb-0">Atur pengelompokan produk toko Anda</p>
                </div>
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
                </button>
            </div>

            {{-- Table --}}
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small text-uppercase tracking-wider">
                            <tr>
                                <th class="ps-4 py-3 border-0">Informasi Kategori</th>
                                <th class="text-center py-3 border-0">Produk Terkait</th>
                                <th class="text-center py-3 border-0">Status</th>
                                <th class="text-end pe-4 py-3 border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="category-img-container rounded-3 overflow-hidden me-3">
                                            @if($category->image)
                                                <img src="{{ Storage::url($category->image) }}" class="img-fluid object-fit-cover" style="width:100%; height:100%;">
                                            @else
                                                <i class="bi bi-image text-muted fs-4"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                                            <small class="text-muted x-small">Slug: {{ $category->slug }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge-status status-info">
                                        {{ $category->products_count }} Item
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge-status {{ $category->is_active ? 'status-success' : 'status-secondary' }}">
                                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-icon btn-light rounded-circle edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal{{ $category->id }}">
                                            <i class="bi bi-pencil-square text-warning"></i>
                                        </button>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                              onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-light rounded-circle">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">Belum ada kategori.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($categories->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $categories->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content shadow-lg" action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Buat Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Nama Kategori</label>
                    <input type="text" name="name" class="form-control py-2 shadow-none" placeholder="Elektronik, Pakaian, dll." required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Gambar</label>
                    <input type="file" name="image" class="form-control shadow-none file-input-preview" data-preview="preview-create">
                    <div id="preview-create" class="img-preview-box">
                        <img src="" alt="Preview">
                    </div>
                </div>
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="createActive">
                    <label class="form-check-label fw-medium" for="createActive">Aktifkan Kategori</label>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content shadow-lg" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Nama Kategori</label>
                    <input type="text" name="name" class="form-control py-2 shadow-none" value="{{ $category->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Ganti Gambar</label>
                    <input type="file" name="image" class="form-control shadow-none file-input-preview" data-preview="preview-edit-{{ $category->id }}">
                    
                    {{-- Box Preview --}}
                    <div id="preview-edit-{{ $category->id }}" class="img-preview-box mt-2" style="{{ $category->image ? 'display:block;' : '' }}">
                        <img src="{{ $category->image ? Storage::url($category->image) : '' }}" alt="Preview">
                    </div>
                </div>
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} id="sw{{ $category->id }}">
                    <label class="form-check-label fw-medium" for="sw{{ $category->id }}">Kategori Aktif</label>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi Preview Gambar
        const fileInputs = document.querySelectorAll('.file-input-preview');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const previewId = this.getAttribute('data-preview');
                const previewBox = document.getElementById(previewId);
                const previewImg = previewBox.querySelector('img');
                
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewBox.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>
@endpush

@endsection