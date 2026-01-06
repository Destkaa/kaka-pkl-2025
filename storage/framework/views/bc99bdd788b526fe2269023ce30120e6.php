

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* 1. Global Soft UI Look */
    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    /* 2. Fix Icon & Stats (Anti-Gepeng) */
    .stats-icon-box {
        width: 56px;
        height: 56px;
        min-width: 56px;
        min-height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; /* Kunci agar tetap bulat sempurna */
        border-radius: 12px;
    }

    .stats-icon-box i {
        line-height: 1;
        font-size: 1.75rem;
    }

    /* 3. Produk Terlaris Image Fix */
    .top-product-img-wrapper {
        width: 100%;
        height: 110px;
        overflow: hidden;
        border-radius: 12px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        border: 1px solid #f1f5f9;
    }

    .top-product-img-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Anti gepeng */
        padding: 8px;
    }

    /* 4. Recent Orders Scrollbar */
    .recent-orders-list {
        max-height: 380px;
        overflow-y: auto;
    }
    
    .recent-orders-list::-webkit-scrollbar {
        width: 4px;
    }
    .recent-orders-list::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    /* 5. Chart Custom Height */
    .chart-container {
        position: relative;
        height: 320px;
        width: 100%;
    }

    .list-group-item {
        transition: background 0.2s;
        border-left: none;
        border-right: none;
    }
    .list-group-item:hover {
        background-color: #f8fafc;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid p-0">
    
    <div class="row g-4 mb-4">
        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-box bg-success bg-opacity-10 text-success me-3">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Pendapatan</p>
                            <h4 class="fw-bold mb-0">Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-box bg-warning bg-opacity-10 text-warning me-3">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Perlu Diproses</p>
                            <h4 class="fw-bold mb-0"><?php echo e($stats['pending_orders']); ?> <span class="text-muted fs-6 fw-normal">Order</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-box bg-danger bg-opacity-10 text-danger me-3">
                            <i class="bi bi-exclamation-octagon"></i>
                        </div>
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Stok Menipis</p>
                            <h4 class="fw-bold mb-0"><?php echo e($stats['low_stock']); ?> <span class="text-muted fs-6 fw-normal">Item</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon-box bg-primary bg-opacity-10 text-primary me-3">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Produk</p>
                            <h4 class="fw-bold mb-0"><?php echo e($stats['total_products']); ?> <span class="text-muted fs-6 fw-normal">SKU</span></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Tren Penjualan (7 Hari Terakhir)</h5>
                        <i class="bi bi-graph-up text-primary"></i>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold">Pesanan Terbaru</h5>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-sm btn-light rounded-pill px-3">Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush recent-orders-list">
                        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-bottom-0">
                                <div>
                                    <div class="fw-bold text-dark mb-0">#<?php echo e($order->order_number); ?></div>
                                    <small class="text-muted"><?php echo e($order->user->name); ?></small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary mb-1">Rp<?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></div>
                                    <?php
                                        $badgeClass = [
                                            'pending' => 'bg-warning',
                                            'processing' => 'bg-info',
                                            'shipped' => 'bg-primary',
                                            'delivered' => 'bg-success',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger'
                                        ][$order->status] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?> bg-opacity-10 text-<?php echo e(str_replace('bg-', '', $badgeClass)); ?> rounded-pill fw-normal" style="font-size: 0.65rem">
                                        <?php echo e(strtoupper($order->status)); ?>

                                    </span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="card-title mb-0 fw-bold">Produk Terlaris</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-3 col-lg-2 text-center">
                        <div class="p-3 rounded-4 transition hover-shadow h-100 bg-light bg-opacity-25 border border-white">
                            <div class="top-product-img-wrapper shadow-sm bg-white">
                                <img src="<?php echo e($product->image_url); ?>" alt="<?php echo e($product->name); ?>">
                            </div>
                            <h6 class="text-truncate fw-bold mb-1 text-dark" style="font-size: 0.85rem"><?php echo e($product->name); ?></h6>
                            <p class="text-primary fw-bold small mb-0"><?php echo e($product->sold); ?> <span class="text-muted fw-normal">terjual</span></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Gradient Background
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(13, 110, 253, 0.2)');
    gradient.addColorStop(1, 'rgba(13, 110, 253, 0)');

    const labels = <?php echo json_encode($revenueChart->pluck('date')); ?>;
    const data = <?php echo json_encode($revenueChart->pluck('total')); ?>;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan',
                data: data,
                borderColor: '#0d6efd',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                backgroundColor: gradient,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0d6efd',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5], drawBorder: false },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(value);
                        }
                    }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>