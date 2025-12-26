

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        
        <a class="navbar-brand text-primary" href="<?php echo e(route('home')); ?>">
            <i class="bi bi-bag-heart-fill me-2"></i>
            TokoOnline
        </a>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        
        <div class="collapse navbar-collapse" id="navbarMain">
            
            <form class="d-flex mx-auto" style="max-width: 400px; width: 100%;" action="<?php echo e(route('catalog.index')); ?>"
                method="GET">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari produk..."
                        value="<?php echo e(request('q')); ?>">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            
            <ul class="navbar-nav ms-auto align-items-center">
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('catalog.index')); ?>">
                        <i class="bi bi-grid me-1"></i> Katalog
                    </a>
                </li>

                <?php if(auth()->guard()->check()): ?>
                
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?php echo e(route('wishlist.index')); ?>">
                        <i class="bi bi-heart"></i>
                        
                        <?php $wishlistCount = auth()->user()->wishlists()->count(); ?>
                        <span id="wishlist-count" 
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            style="font-size: 0.6rem; <?php echo e($wishlistCount > 0 ? '' : 'display: none;'); ?>">
                            <?php echo e($wishlistCount); ?>

                        </span>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a class="nav-link position-relative" href="<?php echo e(route('cart.index')); ?>">
                        <i class="bi bi-cart3"></i>
                        <?php
                        $cartCount = auth()->user()->cart?->items()->count() ?? 0;
                        ?>
                        <?php if($cartCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"
                            style="font-size: 0.6rem;">
                            <?php echo e($cartCount); ?>

                        </span>
                        <?php endif; ?>
                    </a>
                </li>

                
                <li class="nav-item dropdown ms-2">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        data-bs-toggle="dropdown">
                        <img src="<?php echo e(auth()->user()->avatar_url); ?>" class="rounded-circle me-2" width="32" height="32"
                            alt="<?php echo e(auth()->user()->name); ?>">
                        <span class="d-none d-lg-inline"><?php echo e(auth()->user()->name); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                <i class="bi bi-bag me-2"></i> Pesanan Saya
                            </a>
                        </li>
                        <?php if(auth()->user()->isAdmin()): ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-primary" href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="bi bi-speedometer2 me-2"></i> Admin Panel
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('login')); ?>">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary btn-sm ms-2" href="<?php echo e(route('register')); ?>">
                        Daftar
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/partials/navbar.blade.php ENDPATH**/ ?>