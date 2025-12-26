<?php $__env->startSection('title', 'Beranda'); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="bg-light py-5">
        <div class="container py-5">
            <div class="row align-items-center gy-4">

                <!-- Text -->
                <div class="col-lg-6">
                <span class="badge bg-warning text-dark mb-3 px-3 py-2">
                    🔥 Promo Spesial
                </span>

                <h1 class="display-5 fw-bold mb-3">
                    Belanja Online <span class="text-primary">Mudah</span> <br>
                    & <span class="text-success">Terpercaya</span>
                </h1>

                <p class="lead text-muted mb-4">
                    Temukan berbagai produk <b>berkualitas</b> dengan harga terbaik.
                    <span class="text-danger fw-semibold">Gratis ongkir</span> untuk pembelian pertama!
                </p>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary btn-lg shadow">
                    <i class="bi bi-bag-check me-2"></i> Mulai Belanja
                    </a>

                    <a href="#promo" class="btn btn-outline-secondary btn-lg">
                    <i class="bi bi-lightning-charge me-2"></i>Lihat Promo
                    </a>
                </div>

                <!-- Trust info -->
                <div class="d-flex gap-4 mt-4 text-muted small">
                    <div>
                    <i class="bi bi-shield-check text-success me-1"></i> Aman & Terpercaya
                    </div>
                    <div>
                    <i class="bi bi-truck text-primary me-1"></i> Pengiriman Cepat
                    </div>
                    <div>
                    <i class="bi bi-star-fill text-warning me-1"></i> Rating Tinggi
                    </div>
                </div>
                </div>

                <!-- Image -->
                <div class="col-lg-6 d-none d-lg-block text-center">
                <img src="<?php echo e(asset('images/hero-shopping.svg')); ?>"
                    alt="Shopping"
                    class="img-fluid floating"
                    style="max-height: 420px;">
                </div>

            </div>
        </div>

    </section>

    
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Kategori Populer</h2>
            <div class="row g-4">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="<?php echo e(route('catalog.index', ['category' => $category->slug])); ?>"
                           class="text-decoration-none">
                            <div class="card border-0 shadow-sm text-center h-100">
                                <div class="card-body">
                                    <img src="<?php echo e($category->image_url); ?>"
                                         alt="<?php echo e($category->name); ?>"
                                         class="rounded-circle mb-3"
                                         width="80" height="80"
                                         style="object-fit: cover;">
                                    <h6 class="card-title mb-0"><?php echo e($category->name); ?></h6>
                                    <small class="text-muted"><?php echo e($category->products_count); ?> produk</small>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="py-5 bg-light">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Produk Unggulan</h2>
                <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-outline-primary">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card bg-warning text-dark border-0" style="min-height: 200px;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3>Flash Sale!</h3>
                            <p>Diskon hingga 50% untuk produk pilihan</p>
                            <a href="#" class="btn btn-dark" style="width: fit-content;">
                                Lihat Promo
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-info text-white border-0" style="min-height: 200px;">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h3>Member Baru?</h3>
                            <p>Dapatkan voucher Rp 50.000 untuk pembelian pertama</p>
                            <a href="<?php echo e(route('register')); ?>" class="btn btn-light" style="width: fit-content;">
                                Daftar Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Produk Terbaru</h2>
            <div class="row g-4">
                <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<style>
  .floating {
    animation: float 4s ease-in-out infinite;
  }

  @keyframes float {
    0% { transform: translateY(0); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0); }
  }
</style>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/home.blade.php ENDPATH**/ ?>