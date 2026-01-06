

<?php $__env->startSection('title', 'Detail Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-12">

        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0 fw-bold text-info">
                <i class="bi bi-eye me-1"></i> Detail Produk
            </h2>
            <div class="d-flex gap-2">
                <a href="<?php echo e(route('admin.products.edit', $product)); ?>" class="btn btn-warning text-white">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
                <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row g-4">

            
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">

                        
                        <img src="<?php echo e(asset('storage/'.$product->primaryImage?->image_path)); ?>"
                            class="img-fluid rounded mb-3 w-100" style="object-fit:cover;max-height:320px">

                        
                        <div class="row g-2">
                            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-4">
                                <img src="<?php echo e(asset('storage/'.$image->image_path)); ?>" class="img-fluid rounded border"
                                    style="object-fit:cover;height:90px;width:100%">
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </div>
                </div>
            </div>

            
            <div class="col-lg-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-1">
                            <?php echo e($product->name); ?>

                        </h4>

                        <p class="text-muted mb-2">
                            <i class="bi bi-tags me-1"></i>
                            <?php echo e($product->category->name); ?>

                        </p>

                        
                        <h5 class="text-primary fw-bold mb-3">
                            Rp <?php echo e(number_format($product->discount_price, 0, ',', '.')); ?>

                            <?php if($product->discount_price): ?>
                            <span class="text-muted fs-6 text-decoration-line-through ms-2">
                                Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                            </span>
                            <?php endif; ?>
                        </h5>

                        
                        <div class="mb-3 d-flex gap-2">
                            <span class="badge bg-<?php echo e($product->is_active ? 'success' : 'secondary'); ?>">
                                <?php echo e($product->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>

                            <?php if($product->is_featured): ?>
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-star-fill me-1"></i> Unggulan
                            </span>
                            <?php endif; ?>
                        </div>

                        <hr>

                        
                        <p class="mb-4">
                            <?php echo $product->description ?: '-'; ?>

                        </p>

                        
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <strong>Stok</strong>
                                <div><?php echo e($product->stock); ?></div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <strong>Berat</strong>
                                <div><?php echo e($product->weight); ?> gram</div>
                            </div>

                            <div class="col-md-4 mb-2">
                                <strong>Dibuat</strong>
                                <div><?php echo e($product->created_at->format('d M Y')); ?></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views\admin\products\show.blade.php ENDPATH**/ ?>