@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container-fluid px-4">
    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 mt-3">
        <div>
            <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">User Directory</h2>
            <p class="text-muted small mb-0">Total {{ $users->total() }} akun terdaftar dalam sistem.</p>
        </div>
        <button class="btn btn-dark rounded-3 px-4 py-2 fw-semibold shadow-sm mt-3 mt-md-0 d-flex align-items-center">
            <i class="bi bi-plus-lg me-2"></i> Create New User
        </button>
    </div>

    {{-- Main Table Card --}}
    <div class="card border-0 shadow-sm rounded-4">
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
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="modern-avatar me-3">
                                        {{-- Jika user punya foto profil, tampilkan. Jika tidak, inisial --}}
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle object-fit-cover w-100 h-100">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $user->name }}</div>
                                        <div class="text-muted x-small">Joined {{ $user->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary fw-medium">{{ $user->email }}</span>
                            </td>
                            <td>
                                @if($user->is_admin)
                                    <div class="d-flex align-items-center">
                                        <div class="dot bg-primary me-2"></div>
                                        <span class="small fw-bold text-dark">Administrator</span>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center">
                                        <div class="dot bg-light-dark me-2"></div>
                                        <span class="small text-muted">Standard User</span>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge-dot-status {{ $user->is_active ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ? 'Online' : 'Offline' }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-action-minimal" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                                        <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-pencil me-2 text-warning"></i> Edit Profile</a></li>
                                        <li><a class="dropdown-item py-2 small" href="#"><i class="bi bi-shield-lock me-2 text-info"></i> Reset Password</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item py-2 small text-danger" href="#"><i class="bi bi-trash3 me-2"></i> Remove Access</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/gray/fogg-order-completed.svg" style="width: 150px;" class="mb-3">
                                <p class="text-muted">No members found in the directory.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Minimal Pagination --}}
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
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
    tr { transition: background-color 0.2s ease; }
    tr:hover { background-color: #fafafa !important; }
    .x-small { font-size: 0.7rem; }

    /* 7. Dropdown Styling */
    .dropdown-item:active { background-color: #0f172a; }
</style>
@endsection