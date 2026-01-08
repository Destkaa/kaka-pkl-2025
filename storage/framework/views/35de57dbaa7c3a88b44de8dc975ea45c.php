

<?php $__env->startSection('content'); ?>
<div class="checkout-container py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('cart.index')); ?>" class="text-decoration-none text-muted">Keranjang</a></li>
                        <li class="breadcrumb-item active fw-bold text-primary" aria-current="page">Checkout</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark">Selesaikan Pesanan</h1>
            </div>
        </div>

        <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row g-4">
                
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="icon-shape bg-primary-light text-primary rounded-circle me-3">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <h5 class="mb-0 fw-bold">Detail Pengiriman</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label small fw-bold text-muted">NAMA PENERIMA</label>
                                    <input type="text" name="name" id="name" 
                                        class="form-control custom-input" 
                                        value="<?php echo e(auth()->user()->name); ?>" placeholder="Masukkan nama lengkap" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone" class="form-label small fw-bold text-muted">NOMOR TELEPON</label>
                                    <input type="tel" name="phone" id="phone" 
                                        class="form-control custom-input" placeholder="Contoh: 0812xxxx" required>
                                </div>

                                <div class="col-12">
                                    <label for="address" class="form-label small fw-bold text-muted">ALAMAT LENGKAP</label>
                                    <textarea name="address" id="address" rows="3" 
                                        class="form-control custom-input" placeholder="Nama jalan, nomor rumah, kec, kota..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 sticky-top" style="top: 2rem; z-index: 10;">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4 text-dark">Ringkasan Pesanan</h5>
                            
                            <div class="order-items-list mb-4">
                                <?php $calculatedTotal = 0; ?>
                                <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        // FIX: Gunakan display_price agar diskon ikut terhitung!
                                        $currentPrice = $item->product->display_price ?? 0;
                                        $itemSubtotal = $currentPrice * $item->quantity; 
                                        $calculatedTotal += $itemSubtotal;
                                    ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="product-img-mini rounded-3 me-3">
                                            
                                            <img src="<?php echo e($item->product->image_url); ?>" alt="" class="img-fluid rounded-3">
                                            <span class="qty-badge"><?php echo e($item->quantity); ?></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0 small fw-bold text-dark text-truncate" style="max-width: 150px;">
                                                <?php echo e($item->product->name); ?>

                                            </h6>
                                            <?php if($item->product->has_discount): ?>
                                                <small class="text-muted text-decoration-line-through">Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?></small><br>
                                                <small class="text-success fw-bold">Rp <?php echo e(number_format($currentPrice, 0, ',', '.')); ?></small>
                                            <?php else: ?>
                                                <small class="text-muted">Rp <?php echo e(number_format($currentPrice, 0, ',', '.')); ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-end">
                                            <span class="small fw-bold">Rp <?php echo e(number_format($itemSubtotal, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <div class="price-breakdown border-top pt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span class="text-dark fw-bold">Rp <?php echo e(number_format($calculatedTotal, 0, ',', '.')); ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Biaya Pengiriman</span>
                                    <span class="text-success fw-bold">Gratis</span>
                                </div>
                                <hr class="dashed my-3">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="h5 mb-0 fw-bold">Total Tagihan</span>
                                    <span class="h4 mb-0 fw-extrabold text-primary">Rp <?php echo e(number_format($calculatedTotal, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold shadow-primary border-0">
                                <i class="bi bi-lock-fill me-2"></i> Bayar Sekarang
                            </button>
                            
                            <p class="text-center mt-3 mb-0 small text-muted">
                                <i class="bi bi-shield-check me-1"></i> Pembayaran aman & terenkripsi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    body { background-color: #f8fbff; }
    .fw-extrabold { font-weight: 800; }
    .custom-input {
        padding: 0.75rem 1rem;
        border: 1.5px solid #eef2f7;
        border-radius: 12px;
        transition: all 0.3s ease;
        background-color: #fdfdfd;
    }
    .custom-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        background-color: #fff;
    }
    .icon-shape {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
    }
    .bg-primary-light { background-color: rgba(13, 110, 253, 0.1); }
    .product-img-mini {
        width: 54px; height: 54px;
        background-color: #fff;
        position: relative;
        border: 1px solid #eef2f7;
        display: flex; align-items: center; justify-content: center;
    }
    .product-img-mini img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .qty-badge {
        position: absolute; top: -8px; right: -8px;
        background-color: #0d6efd; color: white;
        font-size: 10px; padding: 2px 7px;
        border-radius: 50%; font-weight: bold;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .shadow-primary { box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2); }
    hr.dashed { border-top: 2px dashed #eef2f7; background: none; }
    .rounded-4 { border-radius: 1rem !important; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/checkout/index.blade.php ENDPATH**/ ?>