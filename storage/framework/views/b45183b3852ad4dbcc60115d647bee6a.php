



<?php $__env->startSection('title', 'Manajemen Pesanan'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Global Card & Table */
    .card-stats {
        border-radius: 16px;
        transition: transform 0.2s;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .card-stats:hover { transform: translateY(-5px); }
    
    /* Elegant Table Style */
    .table thead th {
        background-color: #f8f9fa;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
        border: none;
    }

    /* Soft Badge Styles */
    .badge-soft {
        padding: 6px 14px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 12px;
    }
    .bg-soft-warning { background-color: #fff9db; color: #f08c00; }
    .bg-soft-info    { background-color: #e7f5ff; color: #1c7ed6; }
    .bg-soft-success { background-color: #ebfbee; color: #37b24d; }
    .bg-soft-danger  { background-color: #fff5f5; color: #f03e3e; }

    /* Nav Pills Modern */
    .nav-pills .nav-link {
        color: #6c757d;
        font-weight: 600;
        border-radius: 10px;
        padding: 8px 20px;
    }
    .nav-pills .nav-link.active {
        background-color: #111;
        color: #fff;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    
    
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold text-dark mb-0">Pesanan</h3>
            <p class="text-muted mb-0">Kelola dan pantau pesanan pelanggan Anda.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-dark rounded-pill px-4 fw-bold">
                <i class="bi bi-download me-2"></i>Export Report
            </button>
        </div>
    </div>

    
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-stats shadow-sm border-0 p-3">
                <small class="text-muted fw-bold text-uppercase">Total Pesanan</small>
                <h3 class="fw-bold mb-0 mt-1"><?php echo e($orders->total()); ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stats shadow-sm border-0 p-3">
                <small class="text-muted fw-bold text-uppercase text-warning">Pending</small>
                <h3 class="fw-bold mb-0 mt-1"><?php echo e($orders->where('status', 'pending')->count()); ?></h3>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 px-4 border-0">
            <ul class="nav nav-pills gap-2">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(!request('status') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('status') == 'pending' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'pending'])); ?>">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('status') == 'processing' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'processing'])); ?>">Proses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(request('status') == 'completed' ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index', ['status' => 'completed'])); ?>">Selesai</a>
                </li>
            </ul>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No. Order</th>
                        <th>Pelanggan</th>
                        <th>Waktu Transaksi</th>
                        <th>Total Pembayaran</th>
                        <th class="text-center">Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#<?php echo e($order->order_number); ?></span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?php echo e($order->user->name); ?></div>
                                <small class="text-muted"><?php echo e($order->user->email); ?></small>
                            </td>
                            <td>
                                <div class="small fw-medium"><?php echo e($order->created_at->format('d M Y')); ?></div>
                                <div class="x-small text-muted"><?php echo e($order->created_at->format('H:i')); ?> WIB</div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                            </td>
                            <td class="text-center">
                                <?php if($order->status == 'pending'): ?>
                                    <span class="badge-soft bg-soft-warning">Pending</span>
                                <?php elseif($order->status == 'processing'): ?>
                                    <span class="badge-soft bg-soft-info">Proses</span>
                                <?php elseif($order->status == 'completed'): ?>
                                    <span class="badge-soft bg-soft-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge-soft bg-soft-danger">Batal</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-dark rounded-pill px-3 fw-bold shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-cart-x display-1 text-muted opacity-25"></i>
                                <p class="text-muted mt-3">Tidak ada data pesanan.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white py-3 px-4 border-0">
            <?php echo e($orders->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>