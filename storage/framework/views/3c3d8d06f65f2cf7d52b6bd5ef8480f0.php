

<?php $__env->startSection('title', 'Daftar Pesanan - GadgetPro'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* 1. Colors & Theme */
    :root {
        --gp-purple: #6366f1;
        --gp-dark-soft: #2d3748; /* Navy gelap yang lebih lembut, tidak hitam pekat */
        --gp-soft-bg: #f8fafc;
        --gp-border: rgba(99, 102, 241, 0.1);
    }

    body {
        background-color: var(--gp-soft-bg);
    }

    /* 2. Card Styling */
    .order-card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        background: #ffffff;
        overflow: hidden;
    }

    /* 3. TABLE HEADER - ELEGAN TAPI TIDAK TERLALU GELAP */
    .table thead th {
        background-color: #475569 !important; /* Warna Slate (Abu-abu kebiruan tua) */
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #ffffff !important;
        padding: 1.1rem 1rem;
        border: none;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: #f1f5f9;
    }

    /* 4. Badges */
    .badge-soft {
        padding: 0.5rem 0.8rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-soft-warning { background-color: #fffbeb; color: #92400e; }
    .badge-soft-info { background-color: #f0f9ff; color: #075985; }
    .badge-soft-primary { background-color: #eef2ff; color: #3730a3; }
    .badge-soft-success { background-color: #f0fdf4; color: #166534; }
    .badge-soft-danger { background-color: #fef2f2; color: #991b1b; }

    /* 5. Button Action */
    .btn-detail {
        border-radius: 10px;
        padding: 0.45rem 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        background: white;
    }

    .btn-detail:hover {
        background-color: #1e293b;
        color: #ffffff !important;
        transform: translateY(-1px);
    }
</style>

<div class="container py-5">
    
    <div class="mb-4">
        <h1 class="h3 fw-bold mb-1 text-dark">Riwayat Transaksi</h1>
        <p class="text-muted small mb-0">Lacak status dan riwayat pembelanjaan Anda</p>
    </div>

    
    <div class="card order-card">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No. Order</th>
                        <th>Tanggal Belanja</th>
                        <th>Status</th>
                        <th>Total Bayar</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold text-dark">#<?php echo e($order->order_number); ?></span>
                        </td>
                        <td>
                            <div class="text-dark fw-medium mb-0"><?php echo e($order->created_at->translatedFormat('d M Y')); ?></div>
                            <div class="text-muted small"><?php echo e($order->created_at->format('H:i')); ?> WIB</div>
                        </td>
                        <td>
                            <?php
                                $statusConfig = [
                                    'pending'    => ['class' => 'badge-soft-warning', 'label' => 'Menunggu', 'icon' => 'bi-wallet2'],
                                    'processing' => ['class' => 'badge-soft-info',    'label' => 'Diproses', 'icon' => 'bi-gear'],
                                    'shipped'    => ['class' => 'badge-soft-primary', 'label' => 'Dikirim',  'icon' => 'bi-truck'],
                                    'delivered'  => ['class' => 'badge-soft-success', 'label' => 'Selesai',  'icon' => 'bi-check2-all'],
                                    'cancelled'  => ['class' => 'badge-soft-danger',  'label' => 'Batal',    'icon' => 'bi-x-circle'],
                                ];
                                $config = $statusConfig[$order->status] ?? ['class' => 'bg-secondary text-white', 'label' => ucfirst($order->status), 'icon' => 'bi-info-circle'];
                            ?>
                            <span class="badge-soft <?php echo e($config['class']); ?>">
                                <i class="bi <?php echo e($config['icon']); ?>"></i> <?php echo e($config['label']); ?>

                            </span>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">
                                Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?>

                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-detail shadow-sm">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="bi bi-cart-x fs-1 opacity-25 d-block mb-2"></i>
                                <span>Belum ada pesanan yang ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($orders->hasPages()): ?>
        <div class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
            <?php echo e($orders->links('pagination::bootstrap-5')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/orders/index.blade.php ENDPATH**/ ?>