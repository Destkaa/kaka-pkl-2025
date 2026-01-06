

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-link link-dark p-0 text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pesanan
                </a>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                
                
                <div class="card-header bg-white border-bottom py-4 px-4">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3 mb-md-0 text-center text-md-start">
                            <span class="text-uppercase text-muted small fw-bold tracking-wider">Detail Transaksi</span>
                            <h1 class="h3 mb-1 fw-bold text-dark">#<?php echo e($order->order_number); ?></h1>
                            <p class="text-secondary small mb-0">
                                <i class="bi bi-calendar3 me-1"></i> <?php echo e($order->created_at->format('d M Y')); ?> 
                                <span class="mx-1">•</span> 
                                <i class="bi bi-clock me-1"></i> <?php echo e($order->created_at->format('H:i')); ?> WIB
                            </p>
                        </div>

                        <div class="col-md-6 text-center text-md-end">
                            <?php
                                $statusStyles = [
                                    'pending'    => 'bg-warning-subtle text-warning-emphasis border-warning',
                                    'processing' => 'bg-info-subtle text-info-emphasis border-info',
                                    'shipped'    => 'bg-primary-subtle text-primary-emphasis border-primary',
                                    'delivered'  => 'bg-success-subtle text-success-emphasis border-success',
                                    'cancelled'  => 'bg-danger-subtle text-danger-emphasis border-danger'
                                ][$order->status] ?? 'bg-secondary-subtle text-secondary-emphasis';
                            ?>
                            <span class="badge rounded-pill border px-4 py-2 fs-6 fw-semibold <?php echo e($statusStyles); ?>">
                                <?php echo e(ucfirst($order->status == 'pending' ? 'Menunggu Pembayaran' : $order->status)); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    
                    <div class="p-4">
                        <h3 class="h6 fw-bold text-uppercase text-secondary mb-4 border-start border-primary border-4 ps-2">Produk yang Dipesan</h3>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-0 ps-3">Produk</th>
                                        <th class="border-0 text-center">Qty</th>
                                        <th class="border-0 text-end">Harga Satuan</th>
                                        <th class="border-0 text-end pe-3">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-3 py-3">
                                            <span class="fw-semibold text-dark d-block"><?php echo e($item->product_name); ?></span>
                                            <span class="text-muted small">ID Produk: <?php echo e($item->product_id); ?></span>
                                        </td>
                                        <td class="text-center fw-medium"><?php echo e($item->quantity); ?></td>
                                        <td class="text-end text-secondary">
                                            Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?>

                                        </td>
                                        <td class="text-end fw-bold text-dark pe-3">
                                            Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    
                    <div class="row g-0 border-top">
                        <div class="col-md-7 p-4 bg-light border-end">
                            <h3 class="h6 fw-bold text-uppercase text-secondary mb-3">Informasi Pengiriman</h3>
                            <div class="bg-white p-3 rounded-3 border border-light shadow-sm">
                                <p class="mb-1 fw-bold text-dark"><i class="bi bi-person me-2"></i><?php echo e($order->shipping_name); ?></p>
                                <p class="mb-2 text-primary small fw-semibold"><i class="bi bi-telephone me-2"></i><?php echo e($order->shipping_phone); ?></p>
                                <hr class="my-2 opacity-50">
                                <p class="mb-0 text-secondary small">
                                    <i class="bi bi-geo-alt me-2"></i><?php echo e($order->shipping_address); ?>

                                </p>
                            </div>
                        </div>

                        <div class="col-md-5 p-4">
                            <h3 class="h6 fw-bold text-uppercase text-secondary mb-3 text-md-end">Ringkasan Pembayaran</h3>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Subtotal Produk</span>
                                <span class="text-dark">Rp <?php echo e(number_format($order->items->sum('subtotal'), 0, ',', '.')); ?></span>
                            </div>
                            <?php if($order->shipping_cost > 0): ?>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary small">Ongkos Kirim</span>
                                <span class="text-dark">Rp <?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></span>
                            </div>
                            <?php endif; ?>
                            <hr class="my-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark">Total Bayar</span>
                                <span class="h4 fw-bold text-primary mb-0">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                
                <?php if($order->status === 'pending' && $order->snap_token): ?>
                <div class="card-footer bg-white border-top-0 p-4 text-center">
                    <div class="alert alert-info border-0 rounded-4 py-3 mb-4 small text-start">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Menunggu Pembayaran:</strong> Selesaikan transaksi Anda melalui tombol di bawah. Jangan menutup halaman ini saat proses pembayaran sedang berlangsung.
                            </div>
                        </div>
                    </div>
                    <button id="pay-button" class="btn btn-primary btn-lg px-5 rounded-pill shadow fw-bold">
                        <i class="bi bi-credit-card me-2"></i> Bayar Sekarang
                    </button>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styling */
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .bg-info-subtle { background-color: #cff4fc; }
    .bg-primary-subtle { background-color: #cfe2ff; }
    .tracking-wider { letter-spacing: 0.1em; }
    .rounded-4 { border-radius: 1rem !important; }
</style>


<?php if($order->snap_token): ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(config('midtrans.snap_url')); ?>" data-client-key="<?php echo e(config('midtrans.client_key')); ?>"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');

        if (payButton) {
            payButton.addEventListener('click', function () {
                payButton.disabled = true;
                payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';

                window.snap.pay('<?php echo e($order->snap_token); ?>', {
                    onSuccess: function (result) {
                        window.location.href = '<?php echo e(route("orders.success", $order)); ?>';
                    },
                    onPending: function (result) {
                        window.location.href = '<?php echo e(route("orders.pending", $order)); ?>';
                    },
                    onError: function (result) {
                        alert('Pembayaran gagal! Silakan coba lagi.');
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="bi bi-credit-card me-2"></i> Bayar Sekarang';
                    },
                    onClose: function () {
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="bi bi-credit-card me-2"></i> Bayar Sekarang';
                    }
                });
            });
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/orders/show.blade.php ENDPATH**/ ?>