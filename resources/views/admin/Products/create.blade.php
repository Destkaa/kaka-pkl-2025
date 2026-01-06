{{-- resources/views/admin/products/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1 fw-bold text-dark">Tambah Produk Baru</h2>
                <p class="text-muted small mb-0">Lengkapi formulir di bawah untuk menambahkan produk ke katalog toko.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light border-0 shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                {{-- Kiri: Informasi Utama --}}
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm custom-card mb-4">
                        <div class="card-body p-4">
                            <h6 class="section-title mb-4">Informasi Produk</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="name" class="form-control custom-input @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Contoh: Kemeja Flanel Slim Fit" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Deskripsi Produk</label>
                                <textarea name="description" id="editor"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <h6 class="section-title mb-4 mt-5">Harga & Stok</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Harga Jual (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" name="price" class="form-control custom-input border-start-0 @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}" min="1000" placeholder="0" required>
                                    </div>
                                    @error('price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Harga Diskon (Opsional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0 text-muted">Rp</span>
                                        <input type="number" name="discount_price" class="form-control custom-input border-start-0 @error('discount_price') is-invalid @enderror"
                                            value="{{ old('discount_price') }}" min="0" placeholder="0">
                                    </div>
                                    @error('discount_price') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control custom-input @error('stock') is-invalid @enderror"
                                        value="{{ old('stock') }}" min="0" placeholder="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Berat (gram)</label>
                                    <input type="number" name="weight" class="form-control custom-input @error('weight') is-invalid @enderror"
                                        value="{{ old('weight') }}" min="1" placeholder="500" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Organisasi & Media --}}
                <div class="col-md-4">
                    {{-- Card Kategori --}}
                    <div class="card border-0 shadow-sm custom-card mb-4">
                        <div class="card-body p-4">
                            <h6 class="section-title mb-3">Organisasi</h6>
                            <div class="mb-0">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select custom-input @error('category_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori...</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Card Upload --}}
                    <div class="card border-0 shadow-sm custom-card mb-4">
                        <div class="card-body p-4">
                            <h6 class="section-title mb-3">Media Produk</h6>
                            <div class="upload-area text-center p-3 border border-dashed rounded-3 mb-2">
                                <i class="bi bi-cloud-arrow-up fs-2 text-primary"></i>
                                <input type="file" name="images[]" class="form-control mt-2 @error('images') is-invalid @enderror" multiple>
                            </div>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i> Maks 10 gambar (JPG, PNG, WEBP)
                            </small>
                            @error('images') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Card Status --}}
                    <div class="card border-0 shadow-sm custom-card mb-4">
                        <div class="card-body p-4">
                            <h6 class="section-title mb-3">Pengaturan</h6>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input custom-switch" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium ms-2">Tampilkan di Toko</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input custom-switch featured" type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium ms-2">Produk Unggulan</label>
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm py-3 fw-bold rounded-4">
                            <i class="bi bi-save me-2"></i> Simpan Produk
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Custom Styling */
    .custom-card {
        border-radius: 20px !important;
    }

    .section-title {
        color: #1e3a5f;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }

    .section-title::before {
        content: "";
        width: 4px;
        height: 18px;
        background: #845ef7; /* Ungu senada footer */
        margin-right: 10px;
        border-radius: 10px;
    }

    .form-label {
        font-weight: 600;
        color: #4b5563;
        font-size: 0.9rem;
    }

    .custom-input {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 15px;
        transition: all 0.2s;
    }

    .custom-input:focus {
        border-color: #845ef7;
        box-shadow: 0 0 0 4px rgba(132, 94, 247, 0.1);
    }

    /* Input Group Styling */
    .input-group-text {
        border-radius: 12px 0 0 12px !important;
        border-color: #e5e7eb;
        color: #6b7280;
    }

    /* Toggle Switch Styling */
    .custom-switch {
        width: 3rem !important;
        height: 1.5rem !important;
        cursor: pointer;
    }

    .custom-switch:checked {
        background-color: #845ef7 !important;
        border-color: #845ef7 !important;
    }

    .featured:checked {
        background-color: #ff9f43 !important;
        border-color: #ff9f43 !important;
    }

    /* Dashed Upload Area */
    .upload-area {
        border: 2px dashed #d1d5db !important;
        background: #f9fafb;
        transition: all 0.2s;
    }

    .upload-area:hover {
        border-color: #845ef7 !important;
        background: #f3f0ff;
    }

    /* Button Premium */
    .btn-primary {
        background: linear-gradient(135deg, #845ef7 0%, #5f3dc4 100%);
        border: none;
        transition: transform 0.2s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(132, 94, 247, 0.3) !important;
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/ctgoj8efdfr1i2jqusoi0hyy1luhjn7lk7r8rnmmhe2f6r35/tinymce/8/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 350,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:14px }',
        border_radius: '12px'
    });
</script>
@endpush