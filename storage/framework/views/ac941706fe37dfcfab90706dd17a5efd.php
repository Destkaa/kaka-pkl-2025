<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title'); ?> - Admin Panel</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        :root {
            --admin-sidebar: #0f172a;
            --admin-accent: #6366f1; /* Indigo */
            --admin-bg: #f8fafc;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--admin-bg);
            color: #1e293b;
        }
        
        /* Smooth Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Anti Blue Line / Focus */
        a, button, .btn, .nav-link { text-decoration: none !important; outline: none !important; box-shadow: none !important; }

        /* SIDEBAR UPGRADE */
        .sidebar {
            min-height: 100vh;
            background-color: var(--admin-sidebar);
            background-image: radial-gradient(circle at 0% 0%, rgba(99, 102, 241, 0.15) 0%, transparent 50%);
            position: sticky; top: 0; z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link {
            color: #94a3b8;
            padding: 12px 18px;
            border-radius: 12px;
            margin: 4px 16px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; align-items: center;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            transition: transform 0.2s;
        }

        .sidebar .nav-link:hover {
            color: #f1f5f9;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            background: var(--admin-accent);
            color: #fff;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        .sidebar .nav-link.active i { transform: scale(1.1); }

        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #475569;
            padding: 25px 30px 10px;
            text-transform: uppercase;
        }

        /* HEADER UPGRADE */
        header {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0 !important;
        }

        .btn-header-store {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }
        
        .btn-header-store:hover {
            background-color: #f1f5f9;
            color: var(--admin-accent);
            border-color: var(--admin-accent);
        }

        /* PROFILE SECTION */
        .profile-bottom {
            background: rgba(0,0,0,0.2);
            margin: 10px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        /* ALERT CUSTOM */
        .alert {
            border-radius: 16px;
            border: none;
            font-weight: 500;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="d-flex">
        
        <div class="sidebar d-flex flex-column" style="width: 280px;">
            <div class="p-4 mb-2">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-white text-decoration-none d-flex align-items-center">
                    <div class="bg-accent rounded-3 d-flex align-items-center justify-content-center me-3" 
                         style="width: 40px; height: 40px; background: var(--admin-accent);">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>
                    <span class="fs-5 fw-bold tracking-tight">GADGET<span class="text-secondary fw-light text-opacity-50">PRO</span></span>
                </a>
            </div>

            <nav class="flex-grow-1 overflow-auto">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                            <i class="bi bi-grid-1x2-fill me-3"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-section-title">Inventory</li>
                    <li class="nav-item">
                        <a href="<?php echo e(Route::has('admin.products.index') ? route('admin.products.index') : '#'); ?>" class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>">
                            <i class="bi bi-stack me-3"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo e(Route::has('admin.categories.index') ? route('admin.categories.index') : '#'); ?>" class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>">
                            <i class="bi bi-tags-fill me-3"></i> Kategori
                        </a>
                    </li>

                    <li class="nav-section-title">Sales</li>
                    <li class="nav-item">
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>">
                            <i class="bi bi-cart-check-fill me-3"></i> 
                            <span class="flex-grow-1">Pesanan</span>
                            <?php
                                try {
                                    $pendingCount = \App\Models\Order::where('status', 'pending')->count();
                                } catch (\Exception $e) { $pendingCount = 0; }
                            ?>
                            <?php if($pendingCount > 0): ?>
                                <span class="badge rounded-pill bg-danger" style="font-size: 0.7rem;"><?php echo e($pendingCount); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <li class="nav-section-title">User Control</li>
                    <li class="nav-item">
                        <a href="<?php echo e(Route::has('admin.users.index') ? route('admin.users.index') : '#'); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                            <i class="bi bi-person-badge-fill me-3"></i> Pengguna
                        </a>
                    </li>

                    <li class="nav-section-title">Analytics</li>
                    <li class="nav-item">
                        <a href="<?php echo e(Route::has('admin.reports.sales') ? route('admin.reports.sales') : '#'); ?>" class="nav-link <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>">
                            <i class="bi bi-pie-chart-fill me-3"></i> Laporan
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="profile-bottom p-3 mb-3 mt-auto">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-accent d-flex align-items-center justify-content-center me-3 fw-bold text-white shadow-sm" 
                         style="width: 38px; height: 38px; background: #475569; font-size: 0.8rem;">
                        <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="small fw-bold text-white text-truncate"><?php echo e(auth()->user()->name); ?></div>
                        <div class="text-muted" style="font-size: 0.65rem;">Administrator</div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="flex-grow-1">
            <header class="py-3 px-4 d-flex justify-content-between align-items-center sticky-top shadow-sm">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><?php echo $__env->yieldContent('page-title', 'Overview'); ?></h5>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="d-none d-lg-flex align-items-center text-muted me-2" style="font-size: 0.85rem;">
                        <i class="bi bi-calendar-event me-2"></i>
                        <?php echo e(now()->format('D, d M Y')); ?>

                    </div>
                    
                    <a href="/" target="_blank" class="btn btn-header-store rounded-pill px-3 shadow-sm">
                        <i class="bi bi-shop-window me-2"></i> Preview Store
                    </a>

                    <div class="vr mx-2 opacity-10" style="height: 25px;"></div>

                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="Logout">
                            <i class="bi bi-power fs-5"></i>
                        </button>
                    </form>
                </div>
            </header>

            <main class="p-4">
                
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4 p-3" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check2-circle fs-4 me-3"></i>
                            <div><?php echo e(session('success')); ?></div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/layouts/admin.blade.php ENDPATH**/ ?>