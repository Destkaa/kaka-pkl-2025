

<?php $__env->startSection('content'); ?>
<div class="container py-5 text-center">
    <h1 class="h3 mb-4 text-warning fw-bold">Pembayaran Pending</h1>
    <p class="mb-4">Status pembayaran pesanan Anda masih menunggu. Silakan selesaikan pembayaran sesuai instruksi yang diberikan.</p>
    <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary">Lihat Detail Pesanan</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/orders/pending.blade.php ENDPATH**/ ?>