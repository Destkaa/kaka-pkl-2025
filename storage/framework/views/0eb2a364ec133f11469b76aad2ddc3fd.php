

<div class="card product-card h-100 border-0 shadow-sm">
    
    <div class="position-relative">
        <a href="<?php echo e(route('catalog.show', $product->slug)); ?>">
            <img src="<?php echo e($product->image_url); ?>" class="card-img-top" alt="<?php echo e($product->name); ?>"
                style="height: 200px; object-fit: cover;">
        </a>

        
        <?php if($product->has_discount): ?>
        <span class="badge-discount">
            -<?php echo e($product->discount_percentage); ?>%
        </span>
        <?php endif; ?>

        
        <?php if(auth()->guard()->check()): ?>
        <button type="button" onclick="toggleWishlist(<?php echo e($product->id); ?>)"
            class="btn btn-light btn-sm position-absolute top-0 end-0 m-2 rounded-circle wishlist-btn-<?php echo e($product->id); ?>">
            <i class="bi <?php echo e(auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart'); ?>"></i>
        </button>
        <?php endif; ?>
    </div>

    
    <div class="card-body d-flex flex-column">
        
        <small class="text-muted mb-1"><?php echo e($product->category->name); ?></small>

        
        <h6 class="card-title mb-2">
            <a href="<?php echo e(route('catalog.show', $product->slug)); ?>" class="text-decoration-none text-dark stretched-link">
                <?php echo e(Str::limit($product->name, 40)); ?>

            </a>
        </h6>

        
        <div class="mt-auto">
            <?php if($product->has_discount): ?>
            <small class="text-muted text-decoration-line-through">
                <?php echo e($product->formatted_original_price); ?>

            </small>
            <?php endif; ?>
            <div class="fw-bold text-primary">
                <?php echo e($product->formatted_price); ?>

            </div>
        </div>

        
        <?php if($product->stock <= 5 && $product->stock > 0): ?>
            <small class="text-warning mt-2">
                <i class="bi bi-exclamation-triangle"></i>
                Stok tinggal <?php echo e($product->stock); ?>

            </small>
            <?php elseif($product->stock == 0): ?>
            <small class="text-danger mt-2">
                <i class="bi bi-x-circle"></i> Stok Habis
            </small>
            <?php endif; ?>
    </div>

    
    <div class="card-footer bg-white border-0 pt-0">
        <form action="<?php echo e(route('cart.add')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary btn-sm w-100" <?php if($product->stock == 0): ?> disabled <?php endif; ?>>
                <i class="bi bi-cart-plus me-1"></i>
                <?php if($product->stock == 0): ?>
                Stok Habis
                <?php else: ?>
                Tambah Keranjang
                <?php endif; ?>
            </button>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/partials/product-card.blade.php ENDPATH**/ ?>