



<?php $__env->startSection('content'); ?>
<style>
    /* Custom Styling untuk Katalog */
    .filter-card {
        border-radius: 16px;
        position: sticky;
        top: 20px;
    }
    
    .category-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 12px;
        border-radius: 10px;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s ease;
        margin-bottom: 4px;
        font-size: 0.95rem;
    }

    .category-link:hover, .category-link.active {
        background-color: #f3f4f6;
        color: #0d6efd;
        font-weight: 600;
    }

    .price-input-group .form-control {
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        padding: 8px 12px;
    }

    .section-title {
        font-weight: 700;
        letter-spacing: -0.02em;
    }

    .btn-apply {
        border-radius: 10px;
        padding: 10px;
        font-weight: 600;
    }

    /* Menghilangkan panah di input number */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card filter-card border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-sliders2 me-2 text-primary"></i>
                        <h5 class="section-title mb-0">Filter Produk</h5>
                    </div>

                    <form action="<?php echo e(route('catalog.index')); ?>" method="GET">
                        <?php if(request('q')): ?> <input type="hidden" name="q" value="<?php echo e(request('q')); ?>"> <?php endif; ?>

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3">Kategori</label>
                            
                            
                            <a href="<?php echo e(route('catalog.index', request()->except('category'))); ?>" 
                               class="category-link <?php echo e(!request('category') ? 'active' : ''); ?>">
                                <span>Semua Produk</span>
                            </a>

                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="position-relative">
                                <input class="d-none" type="radio" name="category" value="<?php echo e($cat->slug); ?>" id="cat-<?php echo e($cat->id); ?>"
                                       <?php echo e(request('category') == $cat->slug ? 'checked' : ''); ?> onchange="this.form.submit()">
                                
                                <label for="cat-<?php echo e($cat->id); ?>" class="category-link cursor-pointer w-100 <?php echo e(request('category') == $cat->slug ? 'active' : ''); ?>">
                                    <span><?php echo e($cat->name); ?></span>
                                    <span class="badge rounded-pill bg-light text-muted fw-normal"><?php echo e($cat->products_count); ?></span>
                                </label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <hr class="opacity-10 my-4">

                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted mb-3">Rentang Harga</label>
                            <div class="price-input-group">
                                <div class="input-group mb-2 shadow-sm rounded-3">
                                    <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                                    <input type="number" name="min_price" class="form-control border-start-0 ps-0"
                                        placeholder="Minimum" value="<?php echo e(request('min_price')); ?>">
                                </div>
                                <div class="input-group mb-3 shadow-sm rounded-3">
                                    <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                                    <input type="number" name="max_price" class="form-control border-start-0 ps-0"
                                        placeholder="Maksimum" value="<?php echo e(request('max_price')); ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-apply shadow-sm">
                                Terapkan Filter
                            </button>
                            <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-link btn-sm text-decoration-none text-muted">
                                Reset Semua
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-9">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h4 class="section-title mb-1">
                        <?php if(request('q')): ?> Hasil pencarian "<?php echo e(request('q')); ?>" <?php else: ?> Koleksi Produk <?php endif; ?>
                    </h4>
                    <p class="text-muted small mb-0">Menampilkan <?php echo e($products->count()); ?> produk berkualitas</p>
                </div>

                
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small d-none d-sm-block text-nowrap">Urutkan:</span>
                    <form method="GET">
                        <?php $__currentLoopData = request()->except('sort'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <select name="sort" class="form-select border-0 shadow-sm fw-semibold text-dark" style="border-radius: 10px;" onchange="this.form.submit()">
                            <option value="newest" <?php echo e(request('sort')=='newest' ? 'selected' : ''); ?>>Terbaru</option>
                            <option value="price_asc" <?php echo e(request('sort')=='price_asc' ? 'selected' : ''); ?>>Harga: Terendah</option>
                            <option value="price_desc" <?php echo e(request('sort')=='price_desc' ? 'selected' : ''); ?>>Harga: Tertinggi</option>
                        </select>
                    </form>
                </div>
            </div>

            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-12 text-center py-5">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-4">
                        <i class="bi bi-search display-4 text-muted"></i>
                    </div>
                    <h5 class="fw-bold">Yah, produk tidak ditemukan...</h5>
                    <p class="text-muted mx-auto" style="max-width: 350px;">
                        Coba sesuaikan rentang harga atau pilih kategori lain untuk menemukan apa yang kamu cari.
                    </p>
                    <a href="<?php echo e(route('catalog.index')); ?>" class="btn btn-primary rounded-pill px-4 fw-bold">Lihat Semua Produk</a>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="mt-5 d-flex justify-content-center">
                <?php echo e($products->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/catalog/index.blade.php ENDPATH**/ ?>