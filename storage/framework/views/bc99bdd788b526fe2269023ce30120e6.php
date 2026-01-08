

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* 1. Global Reset & Theme */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.9);
        --accent-color: #6366f1; /* Indigo */
    }

    .card {
        border: 1px solid rgba(226, 232, 240, 0.6);
        border-radius: 20px;
        background: var(--glass-bg);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .hover-up:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02) !important;
    }

    /* 2. Enhanced Stats Icons */
    .stats-icon-wrapper {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .stats-icon-wrapper i {
        font-size: 1.8rem;
        z-index: 2;
    }

    .stats-icon-wrapper::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0.15;
        background: currentColor;
    }

    /* 3. Product Cards Premium */
    .product-grid-item {
        background: #fff;
        border-radius: 18px;
        padding: 15px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .product-grid-item:hover {
        border-color: var(--accent-color);
        background: #f8fafc;
    }

    .top-product-img {
        width: 100%;
        height: 120px;
        object-fit: contain;
        filter: drop-shadow(0 5px 10px rgba(0,0,0,0.05));
    }

    /* 4. Order List Styling */
    .order-item {
        border-radius: 12px;
        margin-bottom: 8px;
        border: 1px solid transparent;
        transition: 0.2s;
    }

    .order-item:hover {
        background: #f1f5f9 !important;
        border-color: #e2e8f0;
    }

    /* 5. Chart Card Header */
    .chart-header {
        background: linear-gradient(to right, #ffffff, #f8fafc);
        border-bottom: 1px solid #f1f5f9;
        border-radius: 20px 20px 0 0 !important;
    }

    .bg-soft-indigo { background: #eef2ff; color: #6366f1; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Halo, <?php echo e(explode(' ', auth()->user()->name)[0]); ?>! 👋</h3>
            <p class="text-muted small">Inilah ringkasan toko kamu hari ini.</p>
        </div>
        
    </div>

    
    <div class="row g-4 mb-5">
        <?php
            $cards = [
                ['title' => 'Pendapatan', 'val' => 'Rp '.number_format($stats['total_revenue'], 0, ',', '.'), 'icon' => 'bi-currency-dollar', 'color' => '#10b981'],
                ['title' => 'Pesanan Baru', 'val' => $stats['pending_orders'], 'icon' => 'bi-bag-heart', 'color' => '#f59e0b'],
                ['title' => 'Stok Menipis', 'val' => $stats['low_stock'], 'icon' => 'bi-box-seam', 'color' => '#ef4444'],
                ['title' => 'Total Produk', 'val' => $stats['total_products'], 'icon' => 'bi-layers', 'color' => '#6366f1']
            ];
        ?>

        <?php $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 hover-up">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted fw-semibold small mb-2"><?php echo e($c['title']); ?></p>
                            <h3 class="fw-bold mb-0" style="color: #1e293b;"><?php echo e($c['val']); ?></h3>
                        </div>
                        <div class="stats-icon-wrapper" style="color: <?php echo e($c['color']); ?>">
                            <i class="bi <?php echo e($c['icon']); ?>"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="row g-4 mb-5">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header chart-header py-4 px-4 border-0">
                    <h5 class="fw-bold mb-0">Statistik Penjualan</h5>
                </div>
                <div class="card-body p-4">
                    <div style="height: 350px;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header py-4 px-4 bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Pesanan Terkini</h5>
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-decoration-none small fw-bold" style="color: var(--accent-color)">Lihat Semua</a>
                </div>
                <div class="card-body px-3 pt-0">
                    <div class="overflow-auto" style="max-height: 400px;">
                        <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex align-items-center p-3 order-item bg-light bg-opacity-50">
                            <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                <i class="bi bi-receipt text-muted"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-bold text-dark">#<?php echo e($order->order_number); ?></h6>
                                <small class="text-muted"><?php echo e($order->user->name); ?></small>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold text-dark small">Rp<?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></div>
                                
                                <?php
                                    $statusIndo = [
                                        'pending'    => ['label' => 'Menunggu', 'class' => 'bg-warning text-warning'],
                                        'processing' => ['label' => 'Diproses', 'class' => 'bg-primary text-primary'],
                                        'shipped'    => ['label' => 'Dikirim', 'class' => 'bg-info text-info'],
                                        'delivered'  => ['label' => 'Selesai', 'class' => 'bg-success text-success'],
                                        'cancelled'  => ['label' => 'Dibatalkan', 'class' => 'bg-danger text-danger'],
                                    ];
                                    $currentStatus = $statusIndo[$order->status] ?? ['label' => $order->status, 'class' => 'bg-secondary text-secondary'];
                                ?>

                                <span class="badge rounded-pill bg-opacity-10 <?php echo e($currentStatus['class']); ?>" style="font-size: 0.65rem;">
                                    <?php echo e($currentStatus['label']); ?>

                                </span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="card border-0 shadow-sm mb-5">
        <div class="card-header py-4 px-4 bg-white border-0">
            <h5 class="fw-bold mb-0">Produk Unggulan <span class="badge bg-soft-indigo ms-2" style="font-size: 0.7rem;">Terlaris</span></h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-4">
                <?php $__currentLoopData = $topProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="product-grid-item text-center">
                        <img src="<?php echo e($product->image_url); ?>" class="top-product-img mb-3" alt="<?php echo e($product->name); ?>">
                        <h6 class="text-truncate fw-bold mb-1 small"><?php echo e($product->name); ?></h6>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="badge rounded-pill px-2" style="font-size: 0.6rem; background: #6366f1;"><?php echo e($product->sold); ?> Terjual</span>
                        </div>
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
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(99, 102, 241, 0.25)');
    gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($revenueChart->pluck('date')); ?>,
            datasets: [{
                label: 'Pendapatan',
                data: <?php echo json_encode($revenueChart->pluck('total')); ?>,
                borderColor: '#6366f1',
                borderWidth: 4,
                tension: 0.45,
                fill: true,
                backgroundColor: gradient,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#6366f1',
                pointBorderWidth: 3,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            return 'Total: Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: {
                        font: { size: 11 },
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                },
                x: { grid: { display: false } }
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>