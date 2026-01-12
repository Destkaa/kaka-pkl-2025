@extends('layouts.admin')

@section('title', 'Detail Pengguna - ' . $user->name)

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- Breadcrumb & Back Button --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted">User Directory</a></li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">Member Profile</li>
        </ol>
        <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none text-dark p-0 fw-bold small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </nav>

    <div class="row g-4">
        {{-- KOLOM KIRI: Profile Card --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 text-center p-4 mb-4 position-relative overflow-hidden">
                {{-- Decorative Background --}}
                <div class="position-absolute top-0 start-0 w-100" style="height: 100px; background: linear-gradient(135deg, #0f172a 0%, #334155 100%); z-index: 0;"></div>
                
                <div class="card-body position-relative" style="z-index: 1;">
                    <div class="mb-3 mt-4">
                        <div class="profile-avatar-container mx-auto">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle border border-4 border-white shadow-sm object-fit-cover" width="120" height="120">
                            @else
                                <div class="avatar-placeholder-lg shadow-sm">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="status-indicator {{ $user->is_active ? 'bg-success' : 'bg-danger' }} border border-3 border-white"></span>
                        </div>
                    </div>

                    <h4 class="fw-bolder text-dark mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($user->is_admin)
                            <span class="badge bg-dark rounded-pill px-3 py-2 fw-bold shadow-sm">
                                <i class="bi bi-shield-check me-1 text-primary"></i> Administrator
                            </span>
                        @else
                            <span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-bold shadow-sm">
                                <i class="bi bi-person me-1 text-muted"></i> Standard User
                            </span>
                        @endif
                    </div>

                    <hr class="opacity-50">

                    <div class="row text-start g-3 mt-2">
                        <div class="col-6">
                            <label class="text-muted x-small text-uppercase fw-bold">Terdaftar Pada</label>
                            <p class="small fw-bold mb-0 text-dark">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="col-6">
                            <label class="text-muted x-small text-uppercase fw-bold">Terakhir Login</label>
                            <p class="small fw-bold mb-0 text-dark">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-grid gap-2">
                <a href="#" class="btn btn-dark py-3 rounded-4 fw-bold shadow-sm">
                    <i class="bi bi-pencil-square me-2"></i> Edit Profil Pengguna
                </a>
                <button class="btn btn-outline-danger py-3 rounded-4 fw-bold border-2">
                    <i class="bi bi-person-x me-2"></i> Nonaktifkan Akun
                </button>
            </div>
        </div>

        {{-- KOLOM KANAN: Details & Activity --}}
        <div class="col-xl-8 col-lg-7">
            {{-- Account Information Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-bottom rounded-top-4">
                    <h6 class="fw-bold mb-0 text-dark"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Informasi Akun Lengkap</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Full Name</label>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark border-start border-3 border-primary">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Email Address</label>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark border-start border-3 border-primary">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Phone Number</label>
                            <div class="p-3 bg-light rounded-3 fw-medium text-dark border-start border-3 border-secondary">{{ $user->phone ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Verified Status</label>
                            <div>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold border border-success-subtle">
                                        <i class="bi bi-patch-check-fill me-1"></i> Verified on {{ $user->email_verified_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis px-3 py-2 rounded-pill fw-bold border border-warning-subtle">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Unverified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- User Stats/Activity Placeholder --}}
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                                <i class="bi bi-cart-check fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="small mb-1 opacity-75 fw-bold">Total Order</h6>
                                <h4 class="fw-bolder mb-0">12</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                                <i class="bi bi-wallet2 fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="small mb-1 opacity-75 fw-bold">Total Spend</h6>
                                <h4 class="fw-bolder mb-0">Rp 4.2M</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 bg-info text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                                <i class="bi bi-chat-left-dots fs-4"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="small mb-1 opacity-75 fw-bold">Reviews</h6>
                                <h4 class="fw-bolder mb-0">8</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8fafc; }
    
    /* Avatar Large */
    .profile-avatar-container {
        width: 120px;
        height: 120px;
        position: relative;
    }
    .avatar-placeholder-lg {
        width: 120px; height: 120px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        color: #1e293b;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 3rem; border-radius: 50%;
        border: 4px solid #fff;
    }
    
    /* Online/Offline Status Dot */
    .status-indicator {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }

    /* Text Helper */
    .x-small { font-size: 0.65rem; letter-spacing: 0.05em; }
    .rounded-4 { border-radius: 1.25rem !important; }
    
    /* Custom Badge Colors */
    .bg-success-subtle { background-color: #f0fdf4 !important; }
    .bg-warning-subtle { background-color: #fffbeb !important; }

    /* Breadcrumb Transition */
    .breadcrumb-item + .breadcrumb-item::before { color: #cbd5e1; }
    .breadcrumb a:hover { color: #000 !important; }
</style>
@endsection