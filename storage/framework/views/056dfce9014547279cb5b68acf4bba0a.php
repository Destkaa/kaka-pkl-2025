

<p class="text-muted small">
    Upload foto profil kamu. Format yang didukung: JPG, PNG, WebP. Maksimal 2MB.
</p>

<form method="post" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('patch'); ?>

    <div class="d-flex align-items-center gap-4">
        
        <div class="position-relative">
            
            <img id="avatar-preview" 
                 class="rounded-circle object-fit-cover border" 
                 style="width: 100px; height: 100px;"
                 src="<?php echo e($user->avatar_url); ?>" 
                 alt="<?php echo e($user->name); ?>">

            
            <?php if($user->avatar && !str_starts_with($user->avatar, 'http')): ?>
            <button type="button"
                onclick="if(confirm('Hapus foto profil?')) document.getElementById('delete-avatar-form').submit()"
                class="btn btn-danger btn-sm rounded-circle position-absolute top-0 start-100 translate-middle p-1"
                style="width: 24px; height: 24px; line-height: 1;" 
                title="Hapus foto">
                &times;
            </button>
            <?php endif; ?>
        </div>

        
        <div class="flex-grow-1">
            <input type="file" 
                   name="avatar" 
                   id="avatar" 
                   accept="image/*" 
                   onchange="previewAvatar(event)"
                   class="form-control <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
            
            <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary">Simpan Foto</button>
    </div>
</form>


<form id="delete-avatar-form" action="<?php echo e(route('profile.avatar.destroy')); ?>" method="POST" class="d-none">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>

<script>
    /**
     * Fungsi untuk menampilkan preview foto secara instan 
     * sebelum file benar-benar di-upload ke server.
     */
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            // Validasi ukuran file di sisi client (Opsional, max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB.');
                event.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }
</script><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/profile/partials/update-avatar-form.blade.php ENDPATH**/ ?>