



<?php $__env->startSection('title', 'Daftar Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 fw-bold text-dark mb-1">Daftar Produk</h2>
        <p class="text-muted small mb-0">Kelola stok, harga, dan informasi produk Anda.</p>
    </div>
    <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
        <i class="bi bi-plus-lg me-2"></i> Tambah Produk
    </a>
</div>


<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <div class="input-group border rounded-3 overflow-hidden">
                    <span class="input-group-text bg-white border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 shadow-none py-2" 
                        placeholder="Cari nama produk..." value="<?php echo e(request('search')); ?>">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select border rounded-3 py-2 shadow-none">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="product-img-container me-3 rounded-3 overflow-hidden border">
                                <img src="<?php echo e($product->primaryImage?->image_url ?? asset('img/no-image.png')); ?>" 
                                    alt="<?php echo e($product->name); ?>" class="img-fluid">
                            </div>
                            <div>
                                <h6 class="text-dark fw-bold mb-0"><?php echo e($product->name); ?></h6>
                                <span class="text-muted x-small">ID: PRD-<?php echo e($product->id); ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-dark fw-medium"><?php echo e($product->category->name); ?></span>
                    </td>
                    <td>
                        <span class="fw-bold text-dark">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></span>
                    </td>
                    <td class="text-center">
                        <?php if($product->stock <= 5): ?>
                            <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo e($product->stock); ?></span>
                        <?php else: ?>
                            <span class="text-dark"><?php echo e($product->stock); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($product->is_active): ?>
                            <span class="badge-status status-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge-status status-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?php echo e(route('admin.products.show', $product)); ?>" class="btn btn-icon btn-light rounded-circle" title="Detail">
                                <i class="bi bi-eye text-primary"></i>
                            </a>
                            <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-icon btn-light rounded-circle" title="Edit">
                                <i class="bi bi-pencil-square text-warning"></i>
                            </a>
                            
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="py-3">
                            <i class="bi bi-box-seam display-4 text-muted mb-3 d-block"></i>
                            <p class="text-muted">Data produk tidak ditemukan.</p>
                            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-sm btn-primary rounded-pill">Tambah Produk Pertama</a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    <?php echo e($products->links('pagination::bootstrap-5')); ?>

</div>

<style>
    /* 1. Gambar Produk Agar Tetap Simetris & Proporsional */
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

    /* 2. Badge Status (Warna Font Full & Background Soft) */
    .badge-status {
        display: inline-block;
        padding: 0.4em 1em;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 50rem;
    }
    .status-success { background-color: rgba(25, 135, 84, 0.12); color: #198754; }
    .status-secondary { background-color: rgba(108, 117, 125, 0.12); color: #6c757d; }

    /* 3. Aksi Buttons */
    .btn-icon {
        width: 35px;
        height: 35px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.2s;
    }
    .btn-icon:hover {
        background-color: #e9ecef;
        transform: scale(1.1);
    }

    /* 4. Utility */
    .rounded-4 { border-radius: 1rem !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .x-small { font-size: 0.7rem; }
    .table thead th { background-color: #f8f9fa; font-weight: 600; }
    
    /* Pagination Styling agar bulat */
    .pagination { --bs-pagination-border-radius: 50rem; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/products/index.blade.php ENDPATH**/ ?>