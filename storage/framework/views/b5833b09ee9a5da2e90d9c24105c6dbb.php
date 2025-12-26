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

<div class="card h-100 border-0 shadow-sm product-card">
    
    <div class="position-relative overflow-hidden bg-light" style="padding-top: 100%;">
        <img src="<?php echo e($product->image_url); ?>"
            class="card-img-top position-absolute top-0 start-0 w-100 h-100 object-fit-cover">

        <?php if($product->has_discount): ?>
        <span class="position-absolute top-0 start-0 m-2 badge bg-danger">
            -<?php echo e($product->discount_percentage); ?>%
        </span>
        <?php endif; ?>
    </div>

    
    <div class="card-body d-flex flex-column">
        <small class="text-muted mb-1"><?php echo e($product->category->name); ?></small>
        <h6 class="card-title mb-2">
            <a href="<?php echo e(route('catalog.show', $product->slug)); ?>" class="text-decoration-none text-dark stretched-link">
                <?php echo e($product->name); ?>

            </a>
        </h6>

        <div class="mt-auto">
            <?php if($product->has_discount): ?>
            <p class="fw-bold text-danger mb-0"><?php echo e($product->formatted_price); ?></p>
            <small class="text-decoration-line-through text-muted"><?php echo e($product->formatted_original_price); ?></small>
            <?php else: ?>
            <p class="fw-bold text-primary mb-0"><?php echo e($product->formatted_price); ?></p>
            <?php endif; ?>
            <button onclick="toggleWishlist(<?php echo e($product->id); ?>)"
                class="wishlist-btn-<?php echo e($product->id); ?> btn btn-light btn-sm rounded-circle p-2 transition">
                <i
                    class="bi <?php echo e(Auth::check() && Auth::user()->hasInWishlist($product) ? 'bi-heart-fill text-danger' : 'bi-heart text-secondary'); ?> fs-5"></i>
            </button>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/components/product-card.blade.php ENDPATH**/ ?>