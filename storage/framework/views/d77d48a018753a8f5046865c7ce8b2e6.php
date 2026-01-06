



<?php $__env->startSection('title', 'Wishlist Saya'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Styling Header */
    .header-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff0f3; /* Soft red/pink */
        color: #ff4d6d;
        border-radius: 18px;
        box-shadow: 0 10px 15px -3px rgba(255, 77, 109, 0.1);
    }

    /* Card Hover Effect */
    .wishlist-grid .col {
        transition: transform 0.3s ease;
    }
    .wishlist-grid .col:hover {
        transform: translateY(-5px);
    }

    /* Empty State Styling */
    .empty-wishlist-card {
        border: 2px dashed #e2e8f0;
        background: #f8fafc;
        border-radius: 24px;
        padding: 5rem 1rem;
    }

    .heart-float {
        animation: float 3s ease-in-out infinite;
        display: inline-block;
        color: #ff4d6d;
    }

    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    
    
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 15px;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 border-0 shadow-sm" role="alert" style="border-radius: 15px;">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    
    <div class="d-flex align-items-center mb-5">
        <div class="header-icon me-3">
            <i class="bi bi-heart-fill fs-3"></i>
        </div>
        <div>
            <h1 class="h3 fw-bold mb-0">Wishlist Saya</h1>
            <p class="text-muted mb-0">Daftar produk yang Anda simpan untuk dibeli nanti</p>
        </div>
    </div>

    <?php if($products->count()): ?>
        
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4 wishlist-grid">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col">
                    
                    <?php if (isset($component)) { $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $attributes = $__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__attributesOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a)): ?>
<?php $component = $__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a; ?>
<?php unset($__componentOriginal3fd2897c1d6a149cdb97b41db9ff827a); ?>
<?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="d-flex justify-content-center mt-5">
            <?php echo e($products->links()); ?>

        </div>
    <?php else: ?>
        
        <div class="empty-wishlist-card text-center shadow-sm">
            <div class="mb-4">
                <div class="heart-float">
                    <i class="bi bi-heart-fill" style="font-size: 5rem; opacity: 0.2;"></i>
                </div>
            </div>
            <h3 class="fw-bold text-dark">Wishlist Anda Kosong</h3>
            <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                Belum ada produk impian yang disimpan. Jelajahi katalog kami dan temukan barang favoritmu!
            </p>
            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                <i class="bi bi-search me-2"></i>Mulai Cari Produk
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Notifikasi SweetAlert jika berhasil
        <?php if(session('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "<?php echo e(session('success')); ?>",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                borderRadius: '15px'
            });
        <?php endif; ?>

        // Notifikasi SweetAlert jika gagal
        <?php if(session('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "<?php echo e(session('error')); ?>",
                confirmButtonColor: '#ff4d6d'
            });
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views\Wishlist\index.blade.php ENDPATH**/ ?>