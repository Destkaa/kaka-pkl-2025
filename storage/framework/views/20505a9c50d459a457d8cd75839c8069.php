<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$classes = [
    'pending' => 'badge bg-warning text-dark',
    'processing' => 'badge bg-primary',
    'completed' => 'badge bg-success',
    'cancelled' => 'badge bg-danger',
];
$class = $classes[$status] ?? 'badge bg-secondary';
?>

<span class="<?php echo e($class); ?>">
    <?php echo e(ucfirst($status)); ?>

</span><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views\Components\order-status-badge.blade.php ENDPATH**/ ?>