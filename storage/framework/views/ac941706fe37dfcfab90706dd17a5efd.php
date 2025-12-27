

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?> - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f172a 100%);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 12px;
            transition: all 0.2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: #fff;
        }
        .sidebar .nav-link i {
            width: 24px;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-light">
    <div class="d-flex">
        
        <div class="sidebar d-flex flex-column" style="width: 260px;">
            
            <div class="p-3 border-bottom border-secondary">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-white text-decoration-none d-flex align-items-center">
                    <i class="bi bi-shop fs-4 me-2"></i>
                    <span class="fs-5 fw-bold">Admin Panel</span>
                </a>
            </div>

            
            <nav class="flex-grow-1 py-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>"
                           class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.products.index')); ?>"
                           class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                            <i class="bi bi-box-seam me-2"></i> Produk
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.categories.index')); ?>"
                           class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                            <i class="bi bi-folder me-2"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.orders.index')); ?>"
                           class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                            <i class="bi bi-receipt me-2"></i> Pesanan
                            
                            
            <div class="p-3 border-top border-secondary">
                <div class="d-flex align-items-center text-white">
                    <img src="<?php echo e(auth()->user()->avatar_url); ?>"
                         class="rounded-circle me-2" width="36" height="36">
                    <div class="flex-grow-1">
                        <div class="small fw-medium"><?php echo e(auth()->user()->name); ?></div>
                        <div class="small text-muted">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="flex-grow-1">
            
            <header class="bg-white shadow-sm py-3 px-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h4>
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary btn-sm me-2" target="_blank">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Lihat Toko
                    </a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            
            <div class="px-4 pt-3">
                <?php echo $__env->make('partials.flash-messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            
            <main class="p-4">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/layouts/admin.blade.php ENDPATH**/ ?>