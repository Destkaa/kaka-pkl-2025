



<?php $__env->startSection('title', $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('catalog.index')); ?>">Katalog</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo e(route('catalog.index', ['category' => $product->category->slug])); ?>">
                    <?php echo e($product->category->name); ?>

                </a>
            </li>
            <li class="breadcrumb-item active"><?php echo e(Str::limit($product->name, 30)); ?></li>
        </ol>
    </nav>

    <div class="row">
        
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm">
                
                <div class="position-relative">
                    <img src="<?php echo e($product->image_url); ?>" id="main-image" class="card-img-top" alt="<?php echo e($product->name); ?>"
                        style="height: 400px; object-fit: contain; background: #f8f9fa;">

                    <?php if($product->has_discount): ?>
                    <span class="badge bg-danger position-absolute top-0 start-0 m-3 fs-6">
                        -<?php echo e($product->discount_percentage); ?>%
                    </span>
                    <?php endif; ?>
                </div>

                
                <?php if($product->images->count() > 1): ?>
                <div class="card-body">
                    <div class="d-flex gap-2 overflow-auto">
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/' . $image->image_path)); ?>" class="rounded border cursor-pointer"
                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                            onclick="document.getElementById('main-image').src = this.src">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    
                    <a href="<?php echo e(route('catalog.index', ['category' => $product->category->slug])); ?>"
                        class="badge bg-light text-dark text-decoration-none mb-2">
                        <?php echo e($product->category->name); ?>

                    </a>

                    
                    <h2 class="mb-3"><?php echo e($product->name); ?></h2>

                    
                    <div class="mb-4">
                        <?php if($product->has_discount): ?>
                        <div class="text-muted text-decoration-line-through">
                            <?php echo e($product->formatted_original_price); ?>

                        </div>
                        <?php endif; ?>
                        <div class="h3 text-primary fw-bold mb-0">
                            <?php echo e($product->formatted_price); ?>

                        </div>
                    </div>

                    
                    <div class="mb-4">
                        <?php if($product->stock > 10): ?>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle me-1"></i> Stok Tersedia
                        </span>
                        <?php elseif($product->stock > 0): ?>
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-exclamation-triangle me-1"></i> Stok Tinggal <?php echo e($product->stock); ?>

                        </span>
                        <?php else: ?>
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle me-1"></i> Stok Habis
                        </span>
                        <?php endif; ?>
                    </div>

                    
                    <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="mb-4">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                        <div class="row g-3 align-items-end">
                            <div class="col-auto">
                                <label class="form-label">Jumlah</label>
                                <div class="input-group" style="width: 140px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="decrementQty()">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1"
                                        max="<?php echo e($product->stock); ?>" class="form-control text-center">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="incrementQty()">+</button>
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg w-100" <?php if($product->stock == 0): ?>
                                    disabled <?php endif; ?>>
                                    <i class="bi bi-cart-plus me-2"></i>
                                    Tambah ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    
                    <?php if(auth()->guard()->check()): ?>
                    <button type="button" onclick="toggleWishlist(<?php echo e($product->id); ?>)"
                        class="btn btn-outline-danger mb-4 wishlist-btn-<?php echo e($product->id); ?>">
                        <i
                            class="bi <?php echo e(auth()->user()->hasInWishlist($product) ? 'bi-heart-fill' : 'bi-heart'); ?> me-2"></i>
                        <?php echo e(auth()->user()->hasInWishlist($product) ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist'); ?>

                    </button>
                    <?php endif; ?>

                    <hr>

                    
                    <div class="mb-3">
                        <h6>Deskripsi</h6>
                        <p class="text-muted"><?php echo $product->description; ?></p>
                    </div>

                    <div class="row text-muted small">
                        <div class="col-6 mb-2">
                            <i class="bi bi-box me-2"></i> Berat: <?php echo e($product->weight); ?> gram
                        </div>
                        <div class="col-6 mb-2">
                            <i class="bi bi-tag me-2"></i> SKU: PROD-<?php echo e($product->id); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function incrementQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        if (parseInt(input.value) < max) {
            input.value = parseInt(input.value) + 1;
        }
    }
    function decrementQty() {
        const input = document.getElementById('quantity');
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/catalog/show.blade.php ENDPATH**/ ?>