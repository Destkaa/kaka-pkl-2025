



<h1><?php echo e($title); ?></h1>


<?php echo $htmlContent; ?>




<?php if($user->isAdmin()): ?>
    <p>Selamat datang, Admin!</p>
<?php elseif($user->isCustomer()): ?>
    <p>Selamat datang, <?php echo e($user->name); ?>!</p>
<?php else: ?>
    <p>Silakan login terlebih dahulu.</p>
<?php endif; ?>


<?php if(auth()->guard()->check()): ?>
    
    <p>Halo, <?php echo e(auth()->user()->name); ?></p>
<?php endif; ?>

<?php if(auth()->guard()->guest()): ?>
    
    <a href="<?php echo e(route('login')); ?>">Login</a>
<?php endif; ?>



<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="product-card">
        <h3><?php echo e($product->name); ?></h3>
        <p><?php echo e($product->formatted_price); ?></p>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div><?php echo e($product->name); ?></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p>Tidak ada produk.</p>
<?php endif; ?>



<?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('partials.product-card', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>



<form method="POST" action="<?php echo e(route('products.store')); ?>">
    <?php echo csrf_field(); ?>
    
</form>



<form method="POST" action="<?php echo e(route('products.update', $product)); ?>">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    
</form><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views\contoh.blade.php ENDPATH**/ ?>