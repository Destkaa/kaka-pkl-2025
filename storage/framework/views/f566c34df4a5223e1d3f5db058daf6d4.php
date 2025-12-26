

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Filter Produk</div>
                <div class="card-body">
                    <form action="<?php echo e(route('catalog.index')); ?>" method="GET">
                        <?php if(request('q')): ?> <input type="hidden" name="q" value="<?php echo e(request('q')); ?>"> <?php endif; ?>

                        
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Kategori</h6>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" value="<?php echo e($cat->slug); ?>" <?php echo e(request('category')==$cat->slug ? 'checked' : ''); ?>

                                onchange="this.form.submit()">
                                <label class="form-check-label"><?php echo e($cat->name); ?> <small class="text-muted">(<?php echo e($cat->products_count); ?>)</small></label>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        
                        <div class="mb-3">
                            <h6 class="fw-bold mb-2">Rentang Harga</h6>
                            <div class="d-flex gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm"
                                    placeholder="Min" value="<?php echo e(request('min_price')); ?>">
                                <input type="number" name="max_price" class="form-control form-control-sm"
                                    placeholder="Max" value="<?php echo e(request('max_price')); ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-sm">Terapkan Filter</button>
                        <a href="<?php echo e(route('catalog.index')); ?>"
                            class="btn btn-outline-secondary w-100 btn-sm mt-2">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Katalog Produk</h4>
                
                <form method="GET" class="d-inline-block">
                    <?php $__currentLoopData = request()->except('sort'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="newest" <?php echo e(request('sort')=='newest' ? 'selected' : ''); ?>>Terbaru</option>
                        <option value="price_asc" <?php echo e(request('sort')=='price_asc' ? 'selected' : ''); ?>>Harga Terendah
                        </option>
                        <option value="price_desc" <?php echo e(request('sort')=='price_desc' ? 'selected' : ''); ?>>Harga Tertinggi
                        </option>
                    </select>
                </form>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
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
                    <img src="<?php echo e(asset('images/empty-state.svg')); ?>" width="150" class="mb-3 opacity-50">
                    <h5>Produk tidak ditemukan</h5>
                    <p class="text-muted">Coba kurangi filter atau gunakan kata kunci lain.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="mt-4">
                <?php echo e($products->links('pagination::bootstrap-5')); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/catalog/index.blade.php ENDPATH**/ ?>