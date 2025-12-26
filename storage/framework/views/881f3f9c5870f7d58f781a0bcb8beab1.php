

<p class="text-muted small">
    Setelah akun dihapus, semua data dan resource akan hilang permanen. Silahkan unduh data penting sebelum menghapus.
</p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    Hapus Akun
</button>

<!-- Modal -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="<?php echo e(route('profile.destroy')); ?>" class="modal-content">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>

            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Apakah kamu yakin ingin menghapus akun ini?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">
                    Setelah akun dihapus, semua data akan hilang permanen. Masukkan password untuk konfirmasi.
                </p>

                <div class="mb-3">
                    <label for="password" class="form-label visually-hidden">Password</label>
                    <input type="password" name="password" id="password"
                        class="form-control <?php $__errorArgs = ['password', 'userDeletion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Masukkan password kamu" required>
                    <?php $__errorArgs = ['password', 'userDeletion'];
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger">Hapus Akun</button>
            </div>
        </form>
    </div>
</div>

<?php if($errors->userDeletion->isNotEmpty()): ?>
<script type="module">
    // Auto open modal if validation fails
        // Pastikan script ini berjalan setelah bootstrap dimuat (vite)
        const myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        myModal.show();
</script>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/profile/partials/delete-user-form.blade.php ENDPATH**/ ?>