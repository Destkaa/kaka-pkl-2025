



<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Profil Saya</h2>

            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            
            <div class="card mb-4">
                <div class="card-header bg-white fw-bold">Foto Profil</div>
                <div class="card-body">
                    <?php echo $__env->make('profile.partials.update-avatar-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-white fw-bold">Informasi Profil</div>
                <div class="card-body">
                    <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-white fw-bold">Update Password</div>
                <div class="card-body">
                    <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            
            <div class="card mb-4">
                <div class="card-header bg-white fw-bold">Akun Terhubung</div>
                <div class="card-body">
                    <?php echo $__env->make('profile.partials.connected-accounts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

            
            <div class="card border-danger">
                <div class="card-header bg-danger text-white fw-bold">Hapus Akun</div>
                <div class="card-body">
                    <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/profile/edit.blade.php ENDPATH**/ ?>