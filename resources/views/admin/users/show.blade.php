@extends('layouts.admin')

@section('title', 'Detail Pengguna - ' . $user->name)

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- Breadcrumb & Back Button --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="btn btn-link text-dark p-0 text-decoration-none fw-bold small">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Pengguna
        </a>
    </nav>

    <div class="row g-4">
        {{-- SISI KIRI: RINGKASAN PROFIL --}}
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body text-center pt-5 pb-4">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="profile-avatar-lg">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle border w-100 h-100 object-fit-cover shadow-sm">
                            @else
                                <div class="avatar-placeholder-lg">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <span class="status-indicator {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}" title="{{ $user->is_active ? 'Online' : 'Offline' }}"></span>
                    </div>
                    
                    <h4 class="fw-bold text-dark mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-3">{{ $user->email }}</p>
                    
                    <div class="d-flex justify-content-center gap-2 mb-4">
                        @if($user->is_admin)
                            <span class="badge bg-dark rounded-pill px-3 py-2">
                                <i class="bi bi-shield-check me-1"></i> Administrator
                            </span>
                        @else
                            <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                <i class="bi bi-person me-1"></i> Standard User
                            </span>
                        @endif
                    </div>

                    <div class="row g-2 border-top pt-4">
                        <div class="col-6">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-dark w-100 rounded-pill fw-bold small py-2">
                                <i class="bi bi-pencil me-1"></i> Edit Akun
                            </a>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-pill fw-bold small py-2">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Kontak Cepat --}}
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3">Kontak & Lokasi</h6>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-telephone text-muted me-3"></i>
                        <span class="small fw-medium text-dark">{{ $user->phone ?? 'Tidak ada nomor' }}</span>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="bi bi-geo-alt text-muted me-3 mt-1"></i>
                        <span class="small fw-medium text-dark">{{ $user->address ?? 'Alamat belum diatur' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SISI KANAN: DETAIL DATA & STATISTIK --}}
        <div class="col-xl-8">
            {{-- Statistik Cepat --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-soft-dark me-3">
                                <i class="bi bi-bag-check text-dark fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Total Pesanan</small>
                                <h5 class="fw-bold mb-0 text-dark">{{ $user->orders_count ?? 0 }} Transaksi</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="d-flex align-items-center">
                            <div class="icon-box bg-soft-dark me-3">
                                <i class="bi bi-calendar3 text-dark fs-4"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Waktu Bergabung</small>
                                <h5 class="fw-bold mb-0 text-dark">{{ $user->created_at->format('d M Y') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel Detail Informasi --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Informasi Keamanan & Akun</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <tbody class="border-top-0">
                            <tr>
                                <td class="ps-4 py-3 text-muted small w-25">User ID</td>
                                <td class="fw-bold text-dark small">#USR-{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 text-muted small">Email Status</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-soft-success text-success border-0 px-3">Verified at {{ $user->email_verified_at->format('d/m/Y') }}</span>
                                    @else
                                        <span class="badge bg-soft-danger text-danger border-0 px-3">Not Verified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 text-muted small">Terakhir Update</td>
                                <td class="text-dark small">{{ $user->updated_at->format('d M Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td class="ps-4 py-3 text-muted small">IP Address Terakhir</td>
                                <td class="text-dark small fw-medium">{{ $user->last_login_ip ?? '127.0.0.1 (Local)' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Riwayat Login / Aktivitas (Optional placeholder) --}}
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="fw-bold text-dark mb-0">Aktivitas Terakhir</h6>
                </div>
                <div class="card-body p-4 text-center">
                    <i class="bi bi-clock-history display-6 text-muted opacity-25 mb-2 d-block"></i>
                    <p class="text-muted small mb-0">Fitur log aktivitas akan segera hadir.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* 1. Large Profile Avatar */
    .profile-avatar-lg {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    .avatar-placeholder-lg {
        width: 100%;
        height: 100%;
        background-color: #111;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 800;
        border-radius: 50%;
    }

    /* 2. Status Dot on Avatar */
    .status-indicator {
        position: absolute;
        bottom: 5px;
        right: 5px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 3px solid #fff;
    }

    /* 3. Icon Box Utilities */
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-soft-dark { background-color: #f1f5f9; }
    .bg-soft-success { background-color: #ecfdf5; }
    .bg-soft-danger { background-color: #fef2f2; }

    /* 4. Table Styling */
    .table td { border-color: #f1f5f9; }
    .table tr:last-child td { border-bottom: none; }

    /* 5. Custom Button */
    .btn-outline-dark:hover { background-color: #111; color: #fff; }
</style>
@endsection