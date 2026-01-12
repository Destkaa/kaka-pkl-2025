<?php $__env->startSection('title', 'GadgetPro - Solusi Teknologi Terdepan'); ?>

<?php $__env->startPush('styles'); ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --gadget-purple: #6366f1;
        --gadget-dark: #1a1625;
        --gadget-soft: #f5f3ff;
        --gadget-accent: #818cf8;
    }

    body {
        color: var(--gadget-dark);
        background-color: #ffffff;
    }

    /* HERO SECTION DENGAN GAMBAR SAMAR 
       Menggunakan overlay linear-gradient agar gambar di bawahnya terlihat pudar/samar
    */
    .hero-section {
        position: relative;
        background: 
            linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(245, 243, 255, 0.9) 100%),
            url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1600&auto=format&fit=crop'); 
        background-size: cover;
        background-position: center;
        background-attachment: fixed; /* Memberikan efek parallax halus saat scroll */
        border-bottom-left-radius: 60px;
        border-bottom-right-radius: 60px;
        overflow: hidden;
    }

    .hero-title {
        font-weight: 800;
        letter-spacing: -1.5px;
        line-height: 1.1;
    }

    .text-gadget-gradient {
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Kotak Logo tetap bersih agar kontras */
    .logo-hero-display {
        width: 320px;
        height: 380px;
        background: rgba(255, 255, 255, 0.8); /* Semi-transparan agar menyatu dengan background hero */
        backdrop-filter: blur(10px); /* Efek kaca */
        border-radius: 60px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 30px 60px rgba(99, 102, 241, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .icon-box-pro {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, var(--gadget-purple), #4f46e5);
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: white;
        font-size: 4.5rem;
        box-shadow: 0 15px 30px rgba(99, 102, 241, 0.3);
    }

    .btn-gadget-pro {
        background: var(--gadget-dark) !important;
        color: #ffffff !important;
        border-radius: 50px;
        padding: 14px 32px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-gadget-pro:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
    }

    /* Category Card Styles */
    .custom-card {
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }

    .custom-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(26, 22, 37, 0.1) !important;
        border-color: var(--gadget-purple);
    }

    .floating { animation: float 6s ease-in-out infinite; }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .section-padding { padding: 80px 0; }
    .btn-pill { border-radius: 50px; padding: 14px 32px; font-weight: 700; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    
    <section class="hero-section py-5 mb-5">
        <div class="container py-lg-5">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6">
                    <span class="badge mb-3 px-3 py-2 rounded-pill shadow-sm" style="background-color: white; color: var(--gadget-purple); border: 1px solid var(--gadget-soft);">
                        ⚡ GadgetPro Official Store
                    </span>
                    <h1 class="display-3 hero-title mb-4">
                        Upgrade Gaya Hidup <span class="text-gadget-gradient">Digitalmu</span><br>
                        Bersama <span>GadgetPro.</span>
                    </h1>
                    <p class="lead text-dark mb-5 fs-5 fw-medium">
                        Solusi gadget original dan bergaransi resmi. Kami memastikan teknologi terbaik sampai di tangan Anda dengan standar profesional.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-gadget-pro shadow-sm">
                            <i class="bi bi-rocket-takeoff-fill"></i> Mulai Belanja
                        </a>
                        <a href="#promo" class="btn btn-outline-dark btn-pill">Promo Hari Ini</a>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block text-center">
                    <div class="logo-hero-display mx-auto floating">
                        <div class="icon-box-pro">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <div class="fw-bold fs-2">
                            Gadget<span style="color: var(--gadget-purple)">Pro</span>
                        </div>
                        <div class="text-muted small mt-1" style="letter-spacing: 2px; text-transform: uppercase;">
                            Technology Solutions
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-padding pt-0">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Eksplorasi Koleksi</h2>
                <p class="text-muted">Pilih kategori teknologi yang Anda butuhkan</p>
            </div>
            
            <div class="row g-4 justify-content-center">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $name = strtolower($category->name);
                        $icon = 'bi-device-ssd';

                        if(str_contains($name, 'phone') || str_contains($name, 'hp')) $icon = 'bi-phone';
                        elseif(str_contains($name, 'iphone') || str_contains($name, 'apple')) $icon = 'bi-apple';
                        elseif(str_contains($name, 'android')) $icon = 'bi-android2';
                        elseif(str_contains($name, 'laptop') || str_contains($name, 'macbook')) $icon = 'bi-laptop';
                        elseif(str_contains($name, 'pc') || str_contains($name, 'desktop')) $icon = 'bi-display';
                        elseif(str_contains($name, 'audio') || str_contains($name, 'headset')) $icon = 'bi-headphones';
                        elseif(str_contains($name, 'watch')) $icon = 'bi-smartwatch';
                        elseif(str_contains($name, 'camera')) $icon = 'bi-camera-fill';
                        elseif(str_contains($name, 'tablet')) $icon = 'bi-tablet';
                        elseif(str_contains($name, 'game')) $icon = 'bi-controller';
                    ?>
                    
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="<?php echo e(route('catalog.index', ['category' => $category->slug])); ?>" class="text-decoration-none text-dark">
                            <div class="card custom-card text-center h-100 p-4 shadow-sm border-0">
                                <div class="mx-auto mb-3" style="width: 70px; height: 70px; background: var(--gadget-soft); border-radius: 18px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi <?php echo e($icon); ?>" style="font-size: 2rem; color: var(--gadget-purple);"></i>
                                </div>
                                <h6 class="fw-bold mb-1 text-truncate"><?php echo e($category->name); ?></h6>
                                <small class="text-muted small"><?php echo e($category->products_count ?? 0); ?> Produk</small>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    
    <section class="section-padding bg-light" id="promo">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-5 h-100 d-flex flex-column justify-content-center text-white" 
                         style="background-color: var(--gadget-dark); border-radius: 30px;">
                        <h3 class="fw-bold mb-2 text-warning">Flash Sale! ⚡</h3>
                        <p class="opacity-75 mb-4">Potongan harga hingga 30% untuk semua aksesoris GadgetPro.</p>
                        <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-warning btn-pill w-fit fw-bold text-dark text-decoration-none">Gunakan Promo</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-5 h-100 d-flex flex-column justify-content-center text-white" 
                         style="background: linear-gradient(45deg, var(--gadget-purple), #a855f7); border-radius: 30px;">
                        <h3 class="fw-bold mb-2">Member Rewards ✨</h3>
                        <p class="opacity-75 mb-4">Dapatkan poin belanja yang bisa ditukar dengan voucher fisik.</p>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-pill w-fit text-dark fw-bold text-decoration-none">Daftar Member</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section-padding">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h2 class="fw-bold mb-0">Rekomendasi Pro</h2>
                <a href="<?php echo e(route('catalog.index')); ?>" class="text-decoration-none fw-bold" style="color: var(--gadget-purple);">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-6 col-md-4 col-lg-3">
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
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/home.blade.php ENDPATH**/ ?>