

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="fw-bold text-dark">Keamanan Akun</h5>
            <p class="text-muted small">Perbarui kata sandi Anda secara berkala untuk menjaga keamanan data pribadi.</p>
        </div>

        <form method="post" action="<?php echo e(route('profile.password.change')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('put'); ?>

            
            <div class="mb-3">
                <label for="current_password" class="form-label small fw-bold text-uppercase tracking-wider text-secondary">Password Saat Ini</label>
                <div class="input-group modern-input-group">
                    <input type="password" name="current_password" id="current_password"
                        class="form-control border-end-0 <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        autocomplete="current-password" placeholder="Masukkan password lama">
                    <button class="btn btn-outline-light border-start-0 text-muted toggle-password" type="button" data-target="current_password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger extra-small mt-1 fw-medium"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <hr class="my-4 opacity-10">

            
            <div class="mb-3">
                <label for="password" class="form-label small fw-bold text-uppercase tracking-wider text-secondary">Password Baru</label>
                <div class="input-group modern-input-group">
                    <input type="password" name="password" id="password"
                        class="form-control border-end-0 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        autocomplete="new-password" placeholder="Minimal 8 karakter">
                    <button class="btn btn-outline-light border-start-0 text-muted toggle-password" type="button" data-target="password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger extra-small mt-1 fw-medium"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="mb-4">
                <label for="password_confirmation" class="form-label small fw-bold text-uppercase tracking-wider text-secondary">Konfirmasi Password</label>
                <div class="input-group modern-input-group">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control border-end-0 <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        autocomplete="new-password" placeholder="Ulangi password baru">
                    <button class="btn btn-outline-light border-start-0 text-muted toggle-password" type="button" data-target="password_confirmation">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="text-danger extra-small mt-1 fw-medium"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-bold transition-all">
                    Simpan Perubahan
                </button>

                <?php if(session('status') === 'password-updated'): ?>
                    <span class="text-success small fw-medium">
                        <i class="bi bi-check-circle-fill me-1"></i> Berhasil diperbarui
                    </span>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05em; }
    .extra-small { font-size: 0.75rem; }

    .modern-input-group .form-control {
        border-color: #e2e8f0;
        font-size: 0.95rem;
        padding: 0.7rem 1rem;
        background-color: #f8fafc;
    }

    .modern-input-group .btn-outline-light {
        border-color: #e2e8f0;
        background-color: #f8fafc;
        padding-left: 15px;
        padding-right: 15px;
        display: flex;
        align-items: center;
    }

    .modern-input-group .bi {
        font-size: 1.2rem;
    }

    /* Fokus State */
    .modern-input-group .form-control:focus {
        box-shadow: none;
        border-color: #0d6efd;
        background-color: #fff;
    }

    .modern-input-group:focus-within .btn-outline-light {
        border-color: #0d6efd;
        background-color: #fff;
        color: #0d6efd !important;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #0d6efd;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.toggle-password');
        toggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    // Ganti ke ikon mata tertutup (bi-eye-slash)
                    icon.classList.replace('bi-eye', 'bi-eye-slash');
                } else {
                    input.type = 'password';
                    // Ganti kembali ke ikon mata terbuka (bi-eye)
                    icon.classList.replace('bi-eye-slash', 'bi-eye');
                }
            });
        });
    });
</script><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/profile/partials/update-password-form.blade.php ENDPATH**/ ?>