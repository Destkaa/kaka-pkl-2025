



<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="row g-4 mb-4">
        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success rounded-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-wallet2 fs-3"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1 small">+12.5%</span>
                    </div>
                    <p class="text-muted mb-1 fw-medium small text-uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="fw-bold mb-0 text-dark">Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></h3>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-bag-check fs-3"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small">Orders</span>
                    </div>
                    <p class="text-muted mb-1 fw-medium small text-uppercase tracking-wider">Total Pesanan</p>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e(number_format($stats['total_orders'], 0, ',', '.')); ?></h3>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning rounded-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-2 py-1 small">Pending</span>
                    </div>
                    <p class="text-muted mb-1 fw-medium small text-uppercase tracking-wider">Perlu Diproses</p>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e($stats['pending_orders']); ?></h3>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card rounded-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-box-seam fs-3"></i>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1 small">Low Stock</span>
                    </div>
                    <p class="text-muted mb-1 fw-medium small text-uppercase tracking-wider">Stok Menipis</p>
                    <h3 class="fw-bold mb-0 text-dark"><?php echo e($stats['low_stock']); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-0">
                    <h5 class="fw-bold mb-0">Pesanan Terbaru</h5>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-light rounded-pill px-3 fw-semibold">
                        Semua <i class="bi bi-chevron-right small"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="text-muted small text-uppercase tracking-wider">
                                    <th class="ps-4 py-3 border-0">Order</th>
                                    <th class="py-3 border-0">Customer</th>
                                    <th class="py-3 border-0">Total</th>
                                    <th class="py-3 border-0 text-center">Status</th>
                                    <th class="pe-4 py-3 border-0 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">#<?php echo e($order->order_number); ?></td>
                                        <td>
                                            <div class="fw-medium text-dark"><?php echo e($order->user->name); ?></div>
                                            <div class="text-muted x-small"><?php echo e($order->created_at->format('d M Y')); ?></div>
                                        </td>
                                        <td class="fw-bold text-dark">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></td>
                                        <td class="text-center">
                                            
                                            <span class="badge-status status-<?php echo e($order->status_color); ?>">
                                                <?php echo e(ucfirst($order->status)); ?>

                                            </span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="<?php echo e(route('admin.orders.show', $order)); ?>" class="btn btn-sm btn-icon btn-light rounded-circle shadow-none">
                                                <i class="bi bi-eye text-muted"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted small">Belum ada pesanan masuk.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4 border-0">
                    <h5 class="fw-bold mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-grid gap-2">
                        <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary py-2 rounded-3 text-start px-3 shadow-none">
                            <i class="bi bi-plus-circle me-2"></i> Tambah Produk
                        </a>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="btn btn-outline-secondary py-2 rounded-3 text-start px-3 shadow-none border-light-subtle">
                            <i class="bi bi-folder2-open me-2"></i> Kelola Kategori
                        </a>
                        <a href="<?php echo e(route('admin.reports.sales')); ?>" class="btn btn-outline-secondary py-2 rounded-3 text-start px-3 shadow-none border-light-subtle">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Penjualan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    /* 1. Perbaikan Ikon Agar Simetris (Tidak Gepeng) */
    .stat-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
    }

    /* 2. Custom Badge Status (Warna Font Full & Background Soft) */
    .badge-status {
        display: inline-block;
        padding: 0.45em 1.2em;
        font-size: 0.75rem;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 50rem;
    }

    /* Varian Warna Status */
    .status-success { background-color: rgba(25, 135, 84, 0.15); color: #198754; } /* Hijau */
    .status-warning { background-color: rgba(255, 193, 7, 0.15); color: #997404; } /* Kuning Tua (Agar Terbaca) */
    .status-danger { background-color: rgba(220, 53, 69, 0.15); color: #dc3545; }  /* Merah */
    .status-primary { background-color: rgba(13, 110, 253, 0.15); color: #0d6efd; } /* Biru */
    .status-secondary { background-color: rgba(108, 117, 125, 0.15); color: #6c757d; } /* Abu */

    /* Styling Tambahan */
    .stat-card { transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.03) !important; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .tracking-wider { letter-spacing: 0.05em; }
    .x-small { font-size: 0.75rem; }
    .btn-icon { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; padding: 0; }
    .table thead th { background-color: #f8f9fa; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>