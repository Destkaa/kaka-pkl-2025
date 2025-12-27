

<?php $__env->startSection('title', 'Detail Pesanan #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-8">
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Item Pesanan</h5>
            </div>
            <div class="card-body">
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex mb-3">
                        <img src="<?php echo e($item->product->image_url); ?>" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold"><?php echo e($item->product->name); ?></h6>
                            <small class="text-muted"><?php echo e($item->quantity); ?> x Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></small>
                        </div>
                        <div class="fw-bold">
                            Rp <?php echo e(number_format($item->quantity * $item->price, 0, ',', '.')); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <hr>
                <div class="d-flex justify-content-between fs-5 fw-bold">
                    <span>Total Pembayaran</span>
                    <span class="text-primary">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Info Customer</h5>
            </div>
            <div class="card-body">
                <p class="mb-1 fw-bold"><?php echo e($order->user->name); ?></p>
                <p class="mb-1 text-muted"><?php echo e($order->user->email); ?></p>
            </div>
        </div>

        
        <div class="card shadow-sm border-0 bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Update Status Order</h6>
                <form action="<?php echo e(route('admin.orders.update-status', $order)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <div class="mb-3">
                        <label class="form-label small text-muted">Status Saat Ini: <strong><?php echo e(ucfirst($order->status)); ?></strong></label>
                        <select name="status" class="form-select">
                            <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Processing (Sedang Dikemas)</option>
                            <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>Completed (Selesai/Dikirim)</option>
                            <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled (Batalkan & Restock)</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Update Status
                    </button>
                </form>

                <?php if($order->status == 'cancelled'): ?>
                    <div class="alert alert-danger mt-3 mb-0 small">
                        <i class="bi bi-info-circle"></i> Pesanan ini telah dibatalkan. Stok produk telah dikembalikan otomatis.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>