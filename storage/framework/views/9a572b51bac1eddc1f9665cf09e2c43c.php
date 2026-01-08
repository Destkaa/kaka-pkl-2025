

<?php $__env->startSection('title', 'Manajemen Pengguna'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 mt-3">
        <div>
            <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">User Directory</h2>
            <p class="text-muted small mb-0">Total <?php echo e($users->total()); ?> akun terdaftar dalam sistem.</p>
        </div>
        <button class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm mt-3 mt-md-0 d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> Create New User
        </button>
    </div>

    
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-4 text-muted small fw-bold text-uppercase">Member</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase">Email Address</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase">Access Role</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase text-center">Status</th>
                            <th class="pe-4 py-4 text-end text-muted small fw-bold text-uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="modern-avatar me-3">
                                        <?php if($user->avatar): ?>
                                            <img src="<?php echo e(Storage::url($user->avatar)); ?>" class="rounded-circle object-fit-cover w-100 h-100 border">
                                        <?php else: ?>
                                            <div class="avatar-placeholder">
                                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0"><?php echo e($user->name); ?></div>
                                        <div class="text-muted x-small">Joined <?php echo e($user->created_at->diffForHumans()); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary fw-medium"><?php echo e($user->email); ?></span>
                            </td>
                            <td>
                                <?php if($user->is_admin): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="dot bg-primary me-2 shadow-sm"></div>
                                        <span class="small fw-bold text-dark">Administrator</span>
                                    </div>
                                <?php else: ?>
                                    <div class="d-flex align-items-center">
                                        <div class="dot bg-light-dark me-2"></div>
                                        <span class="small text-muted">Standard User</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge-dot-status <?php echo e($user->is_active ? 'active' : 'inactive'); ?>">
                                    <?php echo e($user->is_active ? 'Online' : 'Offline'); ?>

                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-action-minimal" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                        <li><a class="dropdown-item py-2 small fw-medium" href="#"><i class="bi bi-pencil me-2 text-warning"></i> Edit Profile</a></li>
                                        <li><a class="dropdown-item py-2 small fw-medium" href="#"><i class="bi bi-shield-lock me-2 text-info"></i> Reset Password</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 small text-danger fw-medium" href="#"><i class="bi bi-trash3 me-2"></i> Remove Access</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-people display-1 text-muted opacity-25"></i>
                                    <p class="text-muted mt-3">No members found in the directory.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        
        <div class="card-footer bg-white py-4 px-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <small class="text-muted fw-medium">
                        Showing <span class="text-dark"><?php echo e($users->firstItem() ?? 0); ?></span> to <span class="text-dark"><?php echo e($users->lastItem() ?? 0); ?></span> of <span class="text-dark"><?php echo e($users->total()); ?></span> members
                    </small>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        <?php echo e($users->appends(request()->query())->links('pagination::bootstrap-5')); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* 1. Global & Card Refinement */
    body { background-color: #f8fafc; }
    .card { border: 1px solid rgba(0,0,0,.05) !important; }
    
    /* 2. Modern Avatar */
    .modern-avatar {
        width: 40px;
        height: 40px;
        position: relative;
    }
    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background-color: #f1f5f9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        border-radius: 50%;
        border: 1px solid #e2e8f0;
    }

    /* 3. Role Dot Indicator */
    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    .bg-light-dark { background-color: #cbd5e1; }

    /* 4. Action Button Minimalist */
    .btn-action-minimal {
        background: transparent;
        border: none;
        color: #94a3b8;
        padding: 5px 10px;
        transition: all 0.2s;
    }
    .btn-action-minimal:hover {
        color: #0f172a;
        background-color: #f1f5f9;
        border-radius: 8px;
    }

    /* 5. Badge Dot Status */
    .badge-dot-status {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
    }
    .badge-dot-status.active { background-color: #ecfdf5; color: #059669; }
    .badge-dot-status.inactive { background-color: #fef2f2; color: #dc2626; }

    /* 6. Typography & Table */
    .table thead th {
        background-color: #fff;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #f1f5f9;
    }
    tr:hover { background-color: #fafafa !important; }
    .x-small { font-size: 0.7rem; }

    /* 7. CUSTOM MODERN PAGINATION (MATCHING PREVIOUS PAGES) */
    .pagination {
        display: flex;
        gap: 6px;
        margin-bottom: 0;
    }
    .pagination .page-item .page-link {
        border: none;
        border-radius: 10px !important;
        padding: 8px 16px;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
        font-size: 0.875rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .pagination .page-item.active .page-link {
        background-color: #111 !important; /* Warna Hitam */
        color: #fff !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .pagination .page-item:not(.active):hover .page-link {
        background-color: #e9ecef;
        color: #111;
        transform: translateY(-2px);
    }
    .pagination .page-item.disabled .page-link {
        background-color: transparent;
        color: #ced4da;
    }

    /* 8. Dropdown Styling */
    .dropdown-item:active { background-color: #0f172a; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\gadget-murah\resources\views/admin/users/index.blade.php ENDPATH**/ ?>