<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="card h-100 border-0 shadow-sm product-card custom-hover">
    
    <div class="position-relative overflow-hidden bg-light img-container" style="padding-top: 100%;">
        <a href="<?php echo e(route('catalog.show', $product->slug)); ?>">
            <img src="<?php echo e($product->image_url); ?>"
                class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover img-zoom" 
                alt="<?php echo e($product->name); ?>">
        </a>

        
        <?php if($product->has_discount): ?>
        <span class="position-absolute top-0 start-0 m-3 badge badge-sale shadow-sm">
            <i class="bi bi-tag-fill me-1"></i> -<?php echo e($product->discount_percentage); ?>%
        </span>
        <?php endif; ?>

        
        <button onclick="toggleWishlist(<?php echo e($product->id); ?>)"
            class="wishlist-btn-<?php echo e($product->id); ?> btn btn-wishlist shadow-sm position-absolute top-0 end-0 m-3">
            <i class="bi <?php echo e(Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart'); ?> fs-5"></i>
        </button>
    </div>

    
    <div class="card-body d-flex flex-column p-4">
        <small class="category-text mb-1 text-uppercase"><?php echo e($product->category->name); ?></small>
        <h6 class="product-title mb-3">
            <a href="<?php echo e(route('catalog.show', $product->slug)); ?>" class="text-decoration-none text-dark stretched-link">
                <?php echo e(Str::limit($product->name, 45)); ?>

            </a>
        </h6>

        <div class="mt-auto">
            <?php if($product->has_discount): ?>
                <div class="price-current"><?php echo e($product->formatted_price); ?></div>
                <div class="price-old"><?php echo e($product->formatted_original_price); ?></div>
            <?php else: ?>
                <div class="price-current"><?php echo e($product->formatted_price); ?></div>
            <?php endif; ?>
        </div>

        
        <div class="mt-3">
            <?php if($product->stock <= 5 && $product->stock > 0): ?>
                <div class="stock-badge stock-low">⚡ Sisa <?php echo e($product->stock); ?> lagi!</div>
            <?php elseif($product->stock == 0): ?>
                <div class="stock-badge stock-out">Habis Terjual</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="card-footer bg-transparent border-0 p-4 pt-0">
        <form action="<?php echo e(route('cart.add')); ?>" method="POST" class="position-relative" style="z-index: 3;">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-add-cart w-100 fw-bold" 
                <?php if($product->stock == 0): ?> disabled <?php endif; ?>>
                <?php if($product->stock == 0): ?>
                    STOK HABIS
                <?php else: ?>
                    <i class="bi bi-cart-plus me-2"></i> TAMBAH
                <?php endif; ?>
            </button>
        </form>
    </div>
</div>

<style>
    /* 1. Card Core */
    .product-card {
        border-radius: 24px !important;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        background: #ffffff;
    }

    .custom-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
    }

    /* 2. Gambar & Zoom */
    .img-container {
        border-radius: 24px 24px 0 0;
    }

    .img-zoom {
        transition: transform 0.5s ease;
    }

    .custom-hover:hover .img-zoom {
        transform: scale(1.08);
    }

    /* 3. Typography */
    .category-text {
        font-size: 0.65rem;
        color: #94a3b8;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .product-title a {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1625 !important;
        line-height: 1.4;
    }

    .price-current {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1a1625;
    }

    .price-old {
        font-size: 0.85rem;
        color: #94a3b8;
        text-decoration: line-through;
    }

    /* 4. TOMBOL TAMBAH KERANJANG (Hitam & Aksen Ungu) */
    .btn-add-cart {
        background: #1a1625 !important; /* Hitam Dasar */
        color: #ffffff !important;
        border: 1px solid rgba(99, 102, 241, 0.2) !important; /* Aksen Ungu */
        padding: 12px;
        border-radius: 14px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-add-cart i {
        color: #818cf8; /* Ikon Ungu */
    }

    .btn-add-cart:hover:not(:disabled) {
        background: #2d263f !important;
        border-color: #6366f1 !important;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.2) !important;
        transform: translateY(-2px);
    }

    .btn-add-cart:hover i {
        color: #ffffff;
    }

    /* 5. Wishlist & Badges */
    .btn-wishlist {
        background: white !important;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        transition: 0.2s;
    }

    .btn-wishlist:hover { transform: scale(1.1); }

    .badge-sale {
        background: #ef4444;
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 700;
    }

    .stock-badge {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 8px;
        display: inline-block;
    }
    .stock-low { background: #fff1f2; color: #e11d48; }
    .stock-out { background: #f1f5f9; color: #64748b; }
</style><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/components/product-card.blade.php ENDPATH**/ ?>