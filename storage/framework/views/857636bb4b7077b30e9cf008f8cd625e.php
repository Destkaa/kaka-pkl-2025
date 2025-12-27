

<?php $__env->startSection('content'); ?>
<div class="container py-5 text-center">
    <h1 class="h3 mb-4 text-success fw-bold">Pembayaran Berhasil!</h1>
    <p class="mb-4">Terima kasih, pesanan Anda telah berhasil dibayar dan akan segera diproses.</p>
    <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary">Lihat Detail Pesanan</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/orders/success.blade.php ENDPATH**/ ?>