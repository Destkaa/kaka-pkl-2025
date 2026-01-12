@extends('layouts.admin')

@section('title', 'User Directory - GadgetPro')

@section('content')
<div class="container-fluid px-4 py-3">
    {{-- Header Section --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 mt-3">
        <div>
            <h2 class="fw-bolder text-dark mb-1" style="letter-spacing: -1px;">User Directory</h2>
            <p class="text-muted small mb-0">Total {{ $users->total() }} akun terdaftar dalam sistem.</p>
        </div>
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <button class="btn btn-outline-dark rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center">
                <i class="bi bi-download me-2"></i> Export
            </button>
            <button class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="bi bi-plus-lg me-2"></i> Create New User
            </button>
        </div>
    </div>

    {{-- Search & Filter Tools --}}
    <div class="row mb-4 g-3">
        <div class="col-md-8">
            <form action="{{ route('admin.users.index') }}" method="GET">
                <div class="input-group bg-white rounded-pill shadow-sm border px-3 py-1">
                    <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control bg-transparent border-0 ps-0" 
                        placeholder="Cari nama, email, atau peran..." value="{{ request('search') }}">
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <select class="form-select rounded-pill shadow-sm border-1 py-2 px-3 fw-medium">
                <option value="">Semua Peran Akses</option>
                <option value="1">Administrator</option>
                <option value="0">Standard User</option>
            </select>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="bg-light">
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
                                        @if($user->avatar)
                                            <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle object-fit-cover w-100 h-100 border shadow-sm">
                                        @else
                                            <div class="avatar-placeholder shadow-sm">
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
                                        <div class="dot bg-primary me-2 shadow-sm"></div>
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
                                        <i class="bi bi-three-dots-vertical text-dark"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                        <li><a class="dropdown-item py-2 small fw-medium" href="#"><i class="bi bi-pencil me-2 text-warning"></i> Edit Profile</a></li>
                                        <li><a class="dropdown-item py-2 small fw-medium" href="#"><i class="bi bi-shield-lock me-2 text-info"></i> Reset Password</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="#" method="POST" onsubmit="return confirm('Hapus akses pengguna ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 small text-danger fw-medium">
                                                    <i class="bi bi-trash3 me-2"></i> Remove Access
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-people display-1 text-muted opacity-25"></i>
                                    <p class="text-muted mt-3">Tidak ada member ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer & Pagination --}}
        <div class="card-footer bg-white py-4 px-4 border-0">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <small class="text-muted fw-medium">
                        Showing <span class="text-dark">{{ $users->firstItem() ?? 0 }}</span> to <span class="text-dark">{{ $users->lastItem() ?? 0 }}</span> of <span class="text-dark">{{ $users->total() }}</span> members
                    </small>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-center justify-content-md-end">
                        {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Create User Modal --}}
<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header px-4 py-3 border-bottom-0">
                <h5 class="modal-title fw-bold text-dark">Add New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="Contoh: John Doe" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role Akses</label>
                        <select name="is_admin" class="form-select rounded-3">
                            <option value="0">Standard User</option>
                            <option value="1">Administrator</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" required>
                        <small class="text-muted">Password minimal 8 karakter.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 mt-n2">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4 fw-bold shadow">Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Global Styling */
    body { background-color: #f8fafc; }
    .card { border-radius: 16px !important; }
    
    /* Input & Search Styling */
    .input-group:focus-within {
        border-color: #0f172a !important;
        box-shadow: 0 0 0 4px rgba(15, 23, 42, 0.05) !important;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none !important;
        border-color: #cbd5e1;
    }

    /* Modern Avatar */
    .modern-avatar {
        width: 44px;
        height: 44px;
        position: relative;
    }
    .avatar-placeholder {
        width: 100%; height: 100%;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700; border-radius: 50%;
        border: 2px solid #fff;
    }

    /* Status Badges */
    .badge-dot-status {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 5px 14px;
        border-radius: 8px;
    }
    .badge-dot-status.active { background-color: #dcfce7; color: #166534; }
    .badge-dot-status.inactive { background-color: #fee2e2; color: #991b1b; }

    /* Table Typography */
    .table thead th {
        letter-spacing: 0.03em;
        font-size: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
        background-color: #fbfcfd;
    }
    .x-small { font-size: 0.72rem; }
    .dot { width: 10px; height: 10px; border-radius: 50%; }
    .bg-light-dark { background-color: #94a3b8; }

    /* Action Minimalist */
    .btn-action-minimal {
        background: transparent; border: none;
        color: #64748b; padding: 6px 10px;
        transition: 0.2s; border-radius: 8px;
    }
    .btn-action-minimal:hover { background-color: #f1f5f9; color: #000; }

    /* Custom Pagination */
    .pagination { gap: 5px; }
    .pagination .page-link {
        border: none; border-radius: 8px !important;
        padding: 8px 14px; font-weight: 600;
        color: #475569; background-color: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .pagination .page-item.active .page-link {
        background-color: #0f172a !important;
        color: #fff !important;
    }

    /* Dropdown Styling */
    .dropdown-menu { min-width: 180px; padding: 8px; }
    .dropdown-item { border-radius: 6px; }
    .dropdown-item:hover { background-color: #f8fafc; }
</style>
@endsection