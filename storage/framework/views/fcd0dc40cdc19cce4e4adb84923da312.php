



<?php $__env->startSection('title', 'Keranjang Belanja'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* 1. Perbaikan Gambar Produk (Anti-Gepeng) */
    .cart-img-container {
        width: 80px;
        height: 80px;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        border-radius: 12px;
        background: #ffffff;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; /* Mencegah gambar menyusut */
    }

    .cart-img-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* 2. Styling Soft UI */
    .card {
        border-radius: 20px;
        border: none;
    }

    /* FIX ICON GEPENG: Pastikan width & height sama dan gunakan flex-shrink-0 */
    .header-icon-box {
        width: 64px;
        height: 64px;
        min-width: 64px; /* Kunci agar tetap bulat */
        min-height: 64px; /* Kunci agar tetap bulat */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; /* Mencegah gepeng saat text di sampingnya panjang */
        border-radius: 50%;
    }

    .qty-control {
        background: #f1f5f9;
        border-radius: 50px;
        padding: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e2e8f0;
        width: 110px;
    }

    .qty-btn {
        width: 32px;
        height: 32px;
        min-width: 32px;
        min-height: 32px;
        border-radius: 50% !important;
        background: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .qty-btn:hover { background: var(--bs-primary); color: white; }

    .qty-input {
        width: 35px;
        border: none;
        background: transparent;
        text-align: center;
        font-weight: bold;
        padding: 0;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    
    <div class="d-flex align-items-center mb-5">
        
        <div class="header-icon-box bg-primary bg-opacity-10 text-primary shadow-sm me-3">
            <i class="bi bi-cart3 fs-3"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0">Keranjang Belanja</h2>
            <p class="text-muted mb-0">Periksa kembali pesanan Anda sebelum melakukan pembayaran</p>
        </div>
    </div>

    <?php if($cart && $cart->items->count()): ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 border-0">PRODUK</th>
                                    <th class="text-center py-3 border-0">JUMLAH</th>
                                    <th class="text-end py-3 border-0">SUBTOTAL</th>
                                    <th class="py-3 border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="cart-img-container me-3 shadow-sm">
                                                <img src="<?php echo e($item->product?->image_url ?? asset('images/placeholder.png')); ?>" 
                                                     alt="<?php echo e($item->product?->name ?? 'Produk'); ?>">
                                            </div>
                                            <div class="min-w-0">
                                                <?php if($item->product): ?>
                                                    <a href="<?php echo e(route('catalog.show', $item->product->slug)); ?>" 
                                                       class="text-decoration-none text-dark fw-bold mb-1 d-block text-truncate" style="max-width: 200px;">
                                                        <?php echo e($item->product->name); ?>

                                                    </a>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-primary-subtle text-primary fw-normal small">
                                                            <?php echo e($item->product->category?->name ?? 'Uncategorized'); ?>

                                                        </span>
                                                        <span class="text-muted small">@ Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?></span>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-danger fw-bold">Produk Tidak Tersedia</span>
                                                    <p class="text-muted small mb-0">Silakan hapus item ini</p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if($item->product): ?>
                                        <form action="<?php echo e(route('cart.update', $item->id)); ?>" method="POST" id="update-form-<?php echo e($item->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <div class="qty-control shadow-sm mx-auto">
                                                <button type="button" class="qty-btn" onclick="updateQty(<?php echo e($item->id); ?>, -1)">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" name="quantity" id="qty-<?php echo e($item->id); ?>" 
                                                       value="<?php echo e($item->quantity); ?>" min="1" max="<?php echo e($item->product->stock ?? 1); ?>"
                                                       class="qty-input" readonly>
                                                <button type="button" class="qty-btn" onclick="updateQty(<?php echo e($item->id); ?>, 1)">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-end fw-bold text-dark">
                                        Rp <?php echo e(number_format($item->subtotal ?? (($item->product->price ?? 0) * $item->quantity), 0, ',', '.')); ?>

                                    </td>

                                    <td class="text-center pe-4">
                                        <form action="<?php echo e(route('cart.remove', $item->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-light btn-sm rounded-circle text-danger shadow-sm border" 
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
            
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-medium">
                <i class="bi bi-arrow-left me-2"></i>Tambah Produk Lainnya
            </a>
        </div>

        
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 110px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Total Barang</span>
                        <span class="fw-bold"><?php echo e($cart->items->sum('quantity')); ?> unit</span>
                    </div>

                    <hr class="my-4 opacity-25">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="h6 mb-0 fw-bold">Total Tagihan</span>
                        <span class="h4 mb-0 fw-bold text-primary">
                            Rp <?php echo e(number_format($cart->items->sum(fn($item) => $item->subtotal ?? (($item->product->price ?? 0) * $item->quantity)), 0, ',', '.')); ?>

                        </span>
                    </div>

                    <a href="<?php echo e(route('checkout.index')); ?>" class="btn btn-primary btn-lg w-100 rounded-pill shadow-lg mb-3 py-3 fw-bold">
                        Checkout Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="card shadow-sm border-0 py-5">
        <div class="card-body text-center py-5">
            <div class="header-icon-box bg-light d-inline-flex mb-4">
                <i class="bi bi-cart-x display-1 text-muted"></i>
            </div>
            <h3 class="fw-bold">Wah, keranjangmu masih kosong!</h3>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
                <i class="bi bi-search me-2"></i>Jelajahi Katalog
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function updateQty(itemId, change) {
        const input = document.getElementById('qty-' + itemId);
        const form = document.getElementById('update-form-' + itemId);
        if(!input || !form) return;

        let currentVal = parseInt(input.value);
        let maxVal = parseInt(input.max);
        let newVal = currentVal + change;

        if (newVal >= 1 && newVal <= maxVal) {
            input.value = newVal;
            form.style.opacity = '0.5';
            form.submit();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/cart/index.blade.php ENDPATH**/ ?>