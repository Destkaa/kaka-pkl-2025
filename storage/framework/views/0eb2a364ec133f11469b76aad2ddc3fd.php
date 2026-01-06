

<div class="card product-card h-100 border-0 shadow-sm transition-hover">
    
    <div class="position-relative overflow-hidden" style="border-radius: 20px 20px 0 0;">
        <a href="<?php echo e(route('catalog.show', $product->slug)); ?>">
            <img src="<?php echo e($product->image_url); ?>" class="card-img-top img-zoom" alt="<?php echo e($product->name); ?>"
                style="height: 220px; object-fit: cover;">
        </a>

        
        <?php if($product->has_discount): ?>
        <span class="badge bg-danger position-absolute top-0 start-0 m-3 px-3 py-2 rounded-pill shadow-sm fw-bold" style="z-index: 2;">
            <i class="bi bi-tag-fill me-1"></i> -<?php echo e($product->discount_percentage); ?>%
        </span>
        <?php endif; ?>

        
        <?php if(auth()->guard()->check()): ?>
        <button type="button" onclick="toggleWishlist(<?php echo e($product->id); ?>)"
            class="btn btn-white shadow-sm position-absolute top-0 end-0 m-3 rounded-circle d-flex align-items-center justify-content-center p-0"
            style="width: 35px; height: 35px; z-index: 2;">
            <i class="bi <?php echo e(auth()->user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart'); ?> fs-6"></i>
        </button>
        <?php endif; ?>
    </div>

    
    <div class="card-body d-flex flex-column p-4">
        
        <div class="mb-2 text-uppercase tracking-wider small text-muted fw-semibold">
            <?php echo e($product->category->name); ?>

        </div>

        
        <h6 class="card-title mb-3 fs-6 lh-base">
            <a href="<?php echo e(route('catalog.show', $product->slug)); ?>" class="text-decoration-none text-dark fw-bold stretched-link">
                <?php echo e(Str::limit($product->name, 45)); ?>

            </a>
        </h6>

        
        <div class="mt-auto">
            <?php if($product->has_discount): ?>
            <div class="d-flex align-items-center gap-2 mb-1">
                <small class="text-muted text-decoration-line-through">
                    <?php echo e($product->formatted_original_price); ?>

                </small>
            </div>
            <?php endif; ?>
            <div class="fs-5 fw-black text-primary">
                <?php echo e($product->formatted_price); ?>

            </div>
        </div>

        
        <div class="mt-3">
            <?php if($product->stock <= 5 && $product->stock > 0): ?>
                <div class="p-2 rounded-3 bg-warning-subtle text-warning-emphasis small border border-warning-subtle">
                    <i class="bi bi-fire me-1"></i> Sisa <?php echo e($product->stock); ?> lagi!
                </div>
            <?php elseif($product->stock == 0): ?>
                <div class="p-2 rounded-3 bg-secondary-subtle text-secondary small border border-secondary-subtle">
                    <i class="bi bi-slash-circle me-1"></i> Habis
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card-footer bg-white border-0 p-4 pt-0">
        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="position-relative" style="z-index: 3;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-primary btn-pill w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2" 
                <?php if($product->stock == 0): ?> disabled <?php endif; ?>>
                <?php if($product->stock == 0): ?>
                    Sudah Terjual
                <?php else: ?>
                    <i class="bi bi-cart-plus fs-5"></i> Tambah
                <?php endif; ?>
            </button>
        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/partials/product-card.blade.php ENDPATH**/ ?>