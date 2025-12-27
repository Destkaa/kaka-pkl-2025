
<?php $__env->startSection('content'); ?>

<div class="container max-w-7xl mx-auto px-4 py-8">
    <h1 class="h2 mb-5 fw-bold">Checkout</h1>

    <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="row g-5">
            <!-- Form Informasi Pengiriman -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h5 card-title mb-4">Informasi Pengiriman</h2>

                        <div class="row g-4">
                            <div class="col-12">
                                <label for="name" class="form-label">Nama Penerima</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="<?php echo e(auth()->user()->name); ?>" required>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <textarea name="address" id="address" rows="4" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 1.5rem;">
                    <div class="card-body">
                        <h2 class="h5 card-title mb-4">Ringkasan Pesanan</h2>

                        <div class="mb-4" style="max-height: 300px; overflow-y: auto;">
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between mb-2 small text-muted">
                                <span><?php echo e($item->product->name); ?> × <?php echo e($item->quantity); ?></span>
                                <span class="fw-medium text-dark">Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between mb-4">
                            <span class="h6 mb-0">Total</span>
                            <span class="h6 mb-0 fw-bold">Rp <?php echo e(number_format($cart->items->sum('subtotal'), 0, ',',
                                '.')); ?></span>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/checkout/index.blade.php ENDPATH**/ ?>