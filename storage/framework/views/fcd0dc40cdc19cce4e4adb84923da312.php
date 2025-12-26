



<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <h2 class="mb-4">
        <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
    </h2>

    <?php if($cart && $cart->items->count()): ?>
    <div class="row">
        
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50%">Produk</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="<?php echo e($item->product->image_url); ?>" class="rounded me-3" width="60"
                                            height="60" style="object-fit: cover;">
                                        <div>
                                            <a href="<?php echo e(route('catalog.show', $item->product->slug)); ?>"
                                                class="text-decoration-none text-dark fw-medium">
                                                <?php echo e(Str::limit($item->product->name, 40)); ?>

                                            </a>
                                            <div class="small text-muted">
                                                <?php echo e($item->product->category->name); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle">
                                    <?php echo e($item->product->formatted_price); ?>

                                </td>
                                <td class="text-center align-middle">
                                    <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST"
                                        class="d-inline-flex align-items-center">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="number" name="quantity" value="<?php echo e($item->quantity); ?>" min="1"
                                            max="<?php echo e($item->product->stock); ?>"
                                            class="form-control form-control-sm text-center" style="width: 70px;"
                                            onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="text-end align-middle fw-bold">
                                    Rp <?php echo e(number_format($item->subtotal ?? $item->total_price, 0, ',', '.')); ?>

                                </td>
                                <td class="align-middle">
                                    <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus item ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Belanja</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total Harga (<?php echo e($cart->items->sum('quantity')); ?> barang)</span>
                        <span>Rp <?php echo e(number_format($cart->items->sum(fn($item) => $item->subtotal), 0, ',', '.')); ?></span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="fw-bold">Total</span>
                        <span class="fw-bold text-primary fs-5">
                            Rp <?php echo e(number_format($cart->items->sum(fn($item) => $item->subtotal), 0, ',', '.')); ?>

                        </span>
                    </div>
                    <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary w-100 btn-lg">
                        <i class="bi bi-credit-card me-2"></i>Checkout
                    </a>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-1 text-muted"></i>
        <h4 class="mt-3">Keranjang Kosong</h4>
        <p class="text-muted">Belum ada produk di keranjang belanja kamu</p>
        <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary">
            <i class="bi bi-bag me-2"></i>Mulai Belanja
        </a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/cart/index.blade.php ENDPATH**/ ?>