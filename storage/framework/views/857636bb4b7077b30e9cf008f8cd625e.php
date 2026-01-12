

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 text-center">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <div class="card-body">
                    
                    <div class="mb-4">
                        <div class="success-icon-circle shadow-sm mx-auto">
                            <i class="bi bi-check-lg text-white"></i>
                        </div>
                    </div>

                    <h1 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h1>
                    <p class="text-secondary mb-4">
                        Terima kasih, pembayaran untuk pesanan <span class="fw-bold text-dark">#<?php echo e($order->order_number); ?></span> telah kami terima.
                    </p>

                    <div class="bg-light rounded-4 p-3 mb-4 text-start">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Status Pesanan</span>
                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle rounded-pill px-3">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Metode Pembayaran</span>
                            <span class="text-dark small fw-medium">Konfirmasi Otomatis</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Total Pembayaran</span>
                            <span class="text-primary fw-bold">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-primary btn-lg px-4 rounded-pill fw-bold">
                            <i class="bi bi-box-seam me-2"></i>Pantau Pesanan
                        </a>
                        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">
                            Kembali Belanja
                        </a>
                    </div>
                </div>
            </div>

            <p class="mt-4 text-muted small">
                Butuh bantuan? <a href="#" class="text-decoration-none text-primary">Hubungi Customer Service Kami</a>
            </p>
        </div>
    </div>
</div>

<style>
    /* Styling khusus untuk ikon sukses */
    .success-icon-circle {
        width: 80px;
        height: 80px;
        background-color: #198754; /* Success Green */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .rounded-4 {
        border-radius: 1.25rem !important;
    }

    /* Animasi sederhana */
    @keyframes scaleIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .bg-info-subtle {
        background-color: #cff4fc !important;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/orders/success.blade.php ENDPATH**/ ?>