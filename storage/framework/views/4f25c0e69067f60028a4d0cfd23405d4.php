

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
    <div class="container">
        
        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="<?php echo e(route('home')); ?>">
            <i class="bi bi-bag-heart-fill fs-3 me-2"></i>
            <span style="letter-spacing: -0.5px;">TokoOnline</span>
        </a>

        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navbarMain">
            
            
            <form class="d-flex mx-auto mt-3 mt-lg-0 mb-3 mb-lg-0 position-relative" style="max-width: 450px; width: 100%;" action="<?php echo e(route('catalog.index')); ?>" method="GET">
                <div class="input-group search-group shadow-sm rounded-pill overflow-hidden border">
                    <span class="input-group-text bg-light border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="q" 
                        class="form-control bg-light border-0 py-2 shadow-none" 
                        placeholder="Cari produk ..." 
                        value="<?php echo e(request('q')); ?>">
                </div>
            </form>

            
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item">
                    <a class="nav-link fw-medium mx-lg-2 d-flex align-items-center link-katalog" href="<?php echo e(route('catalog.index')); ?>">
                        <i class="bi bi-grid-fill me-2 fs-5"></i>
                        <span>Katalog</span>
                    </a>
                </li>

                <?php if(auth()->guard()->check()): ?>
                
                <li class="nav-item">
                    <a class="nav-link position-relative px-2 mx-lg-1" href="<?php echo e(route('wishlist.index')); ?>" title="Wishlist">
                        <i class="bi bi-heart fs-5 text-dark"></i>
                        <?php $wishlistCount = auth()->user()->wishlists()->count(); ?>
                        <span id="wishlist-count" 
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.65rem; padding: 0.35em 0.5em; <?php echo e($wishlistCount > 0 ? '' : 'display: none;'); ?>">
                            <?php echo e($wishlistCount); ?>

                        </span>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link position-relative px-2 mx-lg-1" href="<?php echo e(route('cart.index')); ?>" title="Keranjang">
                        <i class="bi bi-cart3 fs-5 text-dark"></i>
                        <?php $cartCount = auth()->user()->cart?->items()->count() ?? 0; ?>
                        <?php if($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                            style="font-size: 0.65rem; padding: 0.35em 0.5em;">
                            <?php echo e($cartCount); ?>

                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                
                <li class="nav-item dropdown ms-lg-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center bg-light rounded-pill px-3 py-1 mt-2 mt-lg-0" href="#" id="userDropdown" data-bs-toggle="dropdown">
                        <img src="<?php echo e(auth()->user()->avatar_url); ?>" class="rounded-circle me-2 border border-2 border-white" width="30" height="30" alt="User">
                        <span class="small fw-bold text-dark"><?php echo e(explode(' ', auth()->user()->name)[0]); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                        <li><a class="dropdown-item py-2" href="<?php echo e(route('profile.edit')); ?>"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                        <li><a class="dropdown-item py-2" href="<?php echo e(route('orders.index')); ?>"><i class="bi bi-bag me-2"></i> Pesanan Saya</a></li>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-primary py-2 fw-bold" href="<?php echo e(route('admin.dashboard')); ?>"><i class="bi bi-speedometer2 me-2"></i> Admin Panel</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i> Keluar</button>
                            </form>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                
                <li class="nav-item">
                    <a class="nav-link text-dark fw-medium px-3" href="<?php echo e(route('login')); ?>">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary rounded-pill px-4 btn-sm fw-bold shadow-sm" href="<?php echo e(route('register')); ?>">Daftar</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Transisi Halus untuk Pencarian */
    .search-group { transition: all 0.3s ease; }
    .search-group:focus-within {
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0.25rem 0.5rem rgba(var(--bs-primary-rgb), 0.15) !important;
    }
    .search-group .form-control:focus { background-color: #fff !important; }
    .search-group:focus-within .input-group-text { background-color: #fff !important; color: var(--bs-primary) !important; }

    /* Katalog Icon Style */
    .link-katalog i {
        color: #adb5bd; /* Warna abu-abu default */
        transition: all 0.2s ease;
    }
    .link-katalog:hover i {
        color: var(--bs-primary);
        transform: rotate(90deg); /* Efek putar sedikit saat hover */
    }

    .navbar-nav .nav-link { color: #555; transition: color 0.2s; }
    .navbar-nav .nav-link:hover { color: var(--bs-primary); }
    .dropdown-item:active { background-color: var(--bs-primary); }
</style><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/partials/navbar.blade.php ENDPATH**/ ?>