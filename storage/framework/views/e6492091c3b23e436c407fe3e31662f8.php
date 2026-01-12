

<?php $__env->startSection('title', 'Edit Produk - GadgetPro'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-3">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1 fw-bold text-dark">Edit Produk</h2>
            <p class="text-muted small mb-0">Kelola rincian produk, stok, dan manajemen galeri foto.</p>
        </div>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-light border shadow-sm px-3 rounded-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="<?php echo e(route('admin.products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            
            <div class="col-xl-8 col-lg-7">
                
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom rounded-top-4">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-info-circle-fill me-2 text-primary"></i>Informasi Umum
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Produk</label>
                            <input type="text" name="name" class="form-control form-control-lg <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('name', $product->name)); ?>" placeholder="Contoh: MacBook Pro M3" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold">Deskripsi Lengkap</label>
                            <textarea name="description" id="editor" rows="12"
                                class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('description', $product->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom rounded-top-4">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-images me-2 text-primary"></i>Galeri Foto Produk
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <label class="form-label fw-bold mb-3 text-muted">Foto Saat Ini (Hover untuk aksi)</label>
                        <div class="row g-3 mb-4">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-md-4 col-xl-3">
                                <div class="image-preview-wrapper position-relative rounded-3 overflow-hidden border <?php echo e($image->is_primary ? 'border-primary border-2' : ''); ?>">
                                    <img src="<?php echo e(asset('storage/'.$image->image_path)); ?>" class="img-fluid d-block mx-auto" style="height: 160px; object-fit: cover; width: 100%;">
                                    
                                    <div class="image-actions p-2">
                                        <div class="form-check mb-1">
                                            <input class="form-check-input" type="radio" name="primary_image" id="primary_<?php echo e($image->id); ?>"
                                                value="<?php echo e($image->id); ?>" <?php echo e($image->is_primary ? 'checked' : ''); ?>>
                                            <label class="form-check-label text-white small cursor-pointer" for="primary_<?php echo e($image->id); ?>">Utama</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input bg-danger border-danger" type="checkbox" name="delete_images[]" id="del_<?php echo e($image->id); ?>"
                                                value="<?php echo e($image->id); ?>">
                                            <label class="form-check-label text-white small cursor-pointer" for="del_<?php echo e($image->id); ?>">Hapus</label>
                                        </div>
                                    </div>
                                    <?php if($image->is_primary): ?>
                                        <span class="badge bg-primary position-absolute top-0 start-0 m-2 shadow-sm">Utama</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="upload-zone border-dashed rounded-4 p-5 text-center bg-light">
                            <i class="bi bi-cloud-arrow-up-fill fs-1 text-primary mb-2"></i>
                            <h6 class="fw-bold">Tambah Foto Baru</h6>
                            <p class="text-muted small">Tarik foto ke sini atau klik tombol di bawah</p>
                            <input type="file" name="images[]" class="form-control" multiple>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-xl-4 col-lg-5">
                
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom rounded-top-4">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-gear-fill me-2 text-primary"></i>Pengaturan</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="category_id" class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-3" required>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $product->category_id) == $category->id ? 'selected' : ''); ?>>
                                    <?php echo e($category->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="space-y-3 p-3 bg-light rounded-3">
                            <div class="form-check form-switch d-flex justify-content-between align-items-center mb-3 p-0">
                                <label class="form-check-label fw-bold text-dark m-0">Produk Aktif</label>
                                <input class="form-check-input ms-0" type="checkbox" name="is_active" value="1" 
                                    <?php echo e(old('is_active', $product->is_active) ? 'checked' : ''); ?> role="switch">
                            </div>
                            <div class="form-check form-switch d-flex justify-content-between align-items-center p-0">
                                <label class="form-check-label fw-bold text-dark m-0">Produk Unggulan</label>
                                <input class="form-check-input ms-0" type="checkbox" name="is_featured" value="1" 
                                    <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?> role="switch">
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card shadow-sm border-0 mb-4 rounded-4">
                    <div class="card-header bg-white py-3 border-bottom rounded-top-4">
                        <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-wallet2 me-2 text-primary"></i>Inventaris & Harga</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">Harga Normal</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">Rp</span>
                                <input type="number" name="price" class="form-control border-start-0 ps-0 <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('price', $product->price)); ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted">Harga Diskon (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-success">Rp</span>
                                <input type="number" name="discount_price" class="form-control border-start-0 ps-0 <?php $__errorArgs = ['discount_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('discount_price', $product->discount_price)); ?>">
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label fw-bold small text-muted">Stok Barang</label>
                                <input type="number" name="stock" class="form-control rounded-3" value="<?php echo e(old('stock', $product->stock)); ?>" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold small text-muted">Berat (gram)</label>
                                <input type="number" name="weight" class="form-control rounded-3" value="<?php echo e(old('weight', $product->weight)); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="card shadow-sm border-0 bg-transparent mb-5 mt-2">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-update-premium py-3 shadow border-0">
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="bi bi-cloud-check-fill fs-5 me-2"></i>
                                <span class="fw-bolder text-uppercase tracking-wider">Simpan Perubahan</span>
                            </div>
                        </button>
                        <button type="reset" class="btn btn-light py-2 rounded-3 text-muted small fw-bold border mt-1">
                            Batalkan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Global Card styling */
    .card { transition: transform 0.2s ease; }
    .border-dashed { border: 2px dashed #0d6efd44 !important; }
    .bg-light { background-color: #f8fafc !important; }
    
    /* Input Styling */
    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.6rem 1rem;
        background-color: #fcfdfe;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        background-color: #fff;
    }

    /* Image Preview Action Effect */
    .image-preview-wrapper { background: #eee; }
    .image-preview-wrapper .image-actions {
        position: absolute;
        bottom: -100%;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 10;
    }
    .image-preview-wrapper:hover .image-actions {
        bottom: 0;
    }

    /* Premium Button Style */
    .btn-update-premium {
        background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%);
        color: white;
        border-radius: 14px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    .btn-update-premium:hover {
        background: linear-gradient(135deg, #0043a8 0%, #0d6efd 100%);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(13, 110, 253, 0.35) !important;
    }
    .btn-update-premium::after {
        content: "";
        position: absolute;
        top: -50%; left: -50%;
        width: 200%; height: 200%;
        background: rgba(255, 255, 255, 0.15);
        transform: rotate(45deg);
        transition: 0.7s;
        pointer-events: none;
    }
    .btn-update-premium:hover::after { left: 120%; }

    /* Switch Customization */
    .form-switch .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .tracking-wider { letter-spacing: 1.2px; }
    .cursor-pointer { cursor: pointer; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.tiny.cloud/1/ctgoj8efdfr1i2jqusoi0hyy1luhjn7lk7r8rnmmhe2f6r35/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 450,
        menubar: false,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_style: 'body { font-family:Inter,Helvetica,Arial,sans-serif; font-size:15px; color: #334155; }',
        skin: 'oxide',
        promotion: false,
        branding: false
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>