

<?php $__env->startSection('title', 'Detail Pesanan #' . $order->order_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-link text-purple p-0 text-decoration-none fw-bold small">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pesanan
            </a>
            <h2 class="fw-bolder text-dark mb-0 mt-2" style="letter-spacing: -1px;">Order #<?php echo e($order->order_number); ?></h2>
            <span class="badge rounded-pill mt-2 px-3 py-2 
                <?php echo e($order->status == 'completed' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-purple-light text-purple')); ?>">
                <?php echo e(strtoupper($order->status)); ?>

            </span>
        </div>
        <div class="text-end">
            <p class="text-muted small mb-0">Tanggal Transaksi</p>
            <p class="fw-bold text-dark mb-0"><?php echo e($order->created_at->format('d M Y, H:i')); ?></p>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom-0">
                    <h6 class="mb-0 fw-bold text-dark">Item Pesanan</h6>
                </div>
                <div class="card-body px-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo e($item->product->image_url ?? asset('images/placeholder.jpg')); ?>" 
                                                 class="rounded-3 me-3 border" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark"><?php echo e($item->product->name); ?></div>
                                                <small class="text-muted">SKU: <?php echo e($item->product->sku ?? '-'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-medium"><?php echo e($item->quantity); ?></td>
                                    <td class="text-end text-muted">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                    <td class="text-end fw-bold text-purple">Rp <?php echo e(number_format($item->quantity * $item->price, 0, ',', '.')); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    
                    <div class="row justify-content-end mt-4">
                        <div class="col-md-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span class="fw-medium text-dark">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Biaya Pengiriman</span>
                                <span class="fw-medium text-success">Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-dark fs-5">Total Bayar</span>
                                <span class="fw-bolder text-purple fs-4" style="letter-spacing: -1px;">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4 text-center">
                <div class="card-body p-4">
                    <div class="avatar-placeholder-sm mx-auto mb-3">
                        <?php echo e(strtoupper(substr($order->user->name, 0, 1))); ?>

                    </div>
                    <h6 class="fw-bold text-dark mb-1"><?php echo e($order->user->name); ?></h6>
                    <p class="text-muted small mb-0"><?php echo e($order->user->email); ?></p>
                    <hr class="my-3">
                    <div class="text-start">
                        <p class="small text-muted mb-1"><i class="bi bi-geo-alt me-2"></i>Alamat Pengiriman:</p>
                        <p class="small fw-medium text-dark"><?php echo e($order->shipping_address ?? 'Alamat tidak tersedia'); ?></p>
                    </div>
                </div>
            </div>

            
            <div class="card border-0 shadow-sm rounded-4 bg-white">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Update Order Status</h6>
                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success border-0 small py-2 mb-3">
                            <i class="bi bi-check-circle-fill me-1"></i> <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('admin.orders.updateStatus', $order->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>

                        <div class="mb-3">
                            <label class="form-label x-small text-uppercase text-muted fw-bold">Select New Status</label>
                            <select name="status" class="form-select border-0 bg-light rounded-3 fw-medium">
                                <option value="pending" <?php echo e($order->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="processing" <?php echo e($order->status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                                <option value="shipped" <?php echo e($order->status == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                <option value="completed" <?php echo e($order->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                <option value="cancelled" <?php echo e($order->status == 'cancelled' ? 'selected' : ''); ?>>Cancelled</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-update-status w-100 rounded-pill fw-bold py-2 mt-2 shadow-sm">
                            <i class="bi bi-arrow-repeat me-1"></i> Update Order
                        </button>
                    </form>

                    <?php if($order->status == 'cancelled'): ?>
                        <div class="mt-3 p-2 rounded-3 bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger">
                            <p class="small mb-0 text-center"><i class="bi bi-exclamation-triangle-fill me-1"></i> Stock has been automatically restored.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    :root {
        --purple-main: #6f42c1;
        --purple-light: #f3e8ff;
        --emerald: #10b981; 
        --emerald-dark: #059669;
    }

    body { background-color: #f6f5f9; }

    .text-purple { color: var(--purple-main) !important; }
    .bg-purple-light { background-color: var(--purple-light); }
    
    .btn-update-status { 
        background-color: var(--emerald); 
        color: white; 
        border: none;
        transition: all 0.3s ease;
    }
    .btn-update-status:hover {
        background-color: var(--emerald-dark);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25) !important;
    }

    .avatar-placeholder-sm {
        width: 60px;
        height: 60px;
        background-color: var(--purple-light);
        color: var(--purple-main);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        border-radius: 50%;
        border: 2px solid #ddd6fe;
    }

    .x-small { font-size: 0.7rem; }
    
    .table thead th {
        background-color: transparent;
        border-bottom: 2px solid #ede9fe;
        font-size: 11px;
    }

    .form-select:focus {
        border-color: var(--emerald);
        box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.1);
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>