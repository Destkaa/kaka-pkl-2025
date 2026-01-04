

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Daftar Pesanan Saya</h1>
            <p class="text-muted small mb-0">Pantau status dan riwayat belanja Anda di sini.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3">No. Order</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Status Pesanan</th>
                            <th class="py-3">Total Tagihan</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#<?php echo e($order->order_number); ?></span>
                            </td>
                            <td class="text-secondary small">
                                <?php echo e($order->created_at->format('d M Y')); ?><br>
                                <span class="text-muted"><?php echo e($order->created_at->format('H:i')); ?> WIB</span>
                            </td>
                            <td>
                                <?php
                                    // Pemetaan warna berdasarkan status database
                                    $statusClass = [
                                        'pending'    => 'bg-warning-subtle text-warning-emphasis border-warning',
                                        'processing' => 'bg-info-subtle text-info-emphasis border-info',
                                        'shipped'    => 'bg-primary-subtle text-primary-emphasis border-primary',
                                        'delivered'  => 'bg-secondary-subtle text-secondary-emphasis border-secondary',
                                        'completed'  => 'bg-success-subtle text-success-emphasis border-success',
                                        'cancelled'  => 'bg-danger-subtle text-danger-emphasis border-danger'
                                    ][$order->status] ?? 'bg-secondary-subtle text-secondary-emphasis';

                                    // Pemetaan label bahasa Indonesia
                                    $statusLabel = [
                                        'pending'    => 'Menunggu Pembayaran',
                                        'processing' => 'Sedang Diproses',
                                        'shipped'    => 'Dalam Pengiriman',
                                        'delivered'  => 'Tiba di Tujuan',
                                        'completed'  => 'Pesanan Selesai',
                                        'cancelled'  => 'Dibatalkan'
                                    ][$order->status] ?? ucfirst($order->status);
                                ?>
                                <span class="badge border px-3 py-2 fw-semibold <?php echo e($statusClass); ?>" style="font-size: 0.75rem; border-radius: 8px;">
                                    <?php echo e($statusLabel); ?>

                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                                <?php if($order->payment_status === 'paid'): ?>
                                    <div class="text-success" style="font-size: 0.7rem;"><i class="bi bi-patch-check-fill"></i> Terbayar</div>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-sm btn-white border shadow-sm px-3 hover-primary rounded-pill">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>

                                    
                                    <?php if($order->status === 'pending' && $order->payment_status === 'unpaid'): ?>
                                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
                                            <i class="bi bi-wallet2 me-1"></i> Bayar
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="80" class="mb-3 opacity-25" alt="Empty">
                                <p class="text-muted mb-0">Belum ada riwayat pesanan.</p>
                                <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-sm btn-primary mt-3 rounded-pill px-4">Mulai Belanja</a>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php if($orders->hasPages()): ?>
        <div class="card-footer bg-white border-top-0 py-3">
            <div class="d-flex justify-content-center">
                <?php echo e($orders->links()); ?>

            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
    /* Styling interaksi */
    .table-hover tbody tr:hover {
        background-color: #fcfdfe;
        transition: 0.2s;
    }
    .hover-primary:hover {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }
    .btn-white {
        background-color: white;
        color: #475569;
    }
    /* Warna Subtitle Bootstrap (Fallback jika CSS tidak ter-load) */
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
    .bg-primary-subtle { background-color: #cfe2ff !important; }
    .bg-secondary-subtle { background-color: #e2e3e5 !important; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/orders/index.blade.php ENDPATH**/ ?>