@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Sidebar Navigasi --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px; z-index: 10;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block profile-avatar-wrapper">
                            <img src="{{ auth()->user()->avatar_url }}" 
                                 class="rounded-circle border border-4 border-white shadow-sm object-fit-cover" 
                                 width="110" height="110" alt="Avatar">
                            {{-- Indikator Online atau Badge jika perlu --}}
                            <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2" title="Online"></span>
                        </div>
                        <h5 class="fw-bold mt-3 mb-1 text-dark">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="nav flex-column nav-pills custom-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active mb-2 text-start p-3 rounded-3" id="tab-profile" data-bs-toggle="pill" data-bs-target="#profile-info" type="button" role="tab">
                            <i class="bi bi-person-circle me-2"></i> Informasi Profil
                        </button>
                        <button class="nav-link mb-2 text-start p-3 rounded-3" id="tab-password" data-bs-toggle="pill" data-bs-target="#password-security" type="button" role="tab">
                            <i class="bi bi-shield-lock me-2"></i> Keamanan Password
                        </button>
                        <button class="nav-link mb-2 text-start p-3 rounded-3" id="tab-connected" data-bs-toggle="pill" data-bs-target="#connected-acc" type="button" role="tab">
                            <i class="bi bi-link-45deg me-2"></i> Akun Terhubung
                        </button>
                        <hr class="text-muted opacity-25">
                        <button class="nav-link text-danger text-start p-3 rounded-3" id="tab-danger" data-bs-toggle="pill" data-bs-target="#danger-zone" type="button" role="tab">
                            <i class="bi bi-exclamation-triangle me-2"></i> Zona Bahaya
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Konten Utama --}}
        <div class="col-lg-8">
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i> 
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="tab-content mt-1" id="v-pills-tabContent">
                {{-- Tab 1: Informasi Profil --}}
                <div class="tab-pane fade show active" id="profile-info" role="tabpanel" aria-labelledby="tab-profile">
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
                            <h5 class="fw-bold mb-0">Informasi Profil</h5>
                            <p class="text-muted small mb-0">Perbarui data diri dan foto profil Anda untuk pengalaman yang lebih personal.</p>
                        </div>
                        <div class="card-body px-4 pb-4">
                            <div class="mb-5 pb-4 border-bottom">
                                @include('profile.partials.update-avatar-form')
                            </div>
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Tab 2: Keamanan --}}
                <div class="tab-pane fade" id="password-security" role="tabpanel" aria-labelledby="tab-password">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
                            <h5 class="fw-bold mb-0">Update Password</h5>
                            <p class="text-muted small mb-0">Kami menyarankan Anda menggunakan password yang unik dan sulit ditebak.</p>
                        </div>
                        <div class="card-body px-4 pb-4">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Tab 3: Akun Terhubung --}}
                <div class="tab-pane fade" id="connected-acc" role="tabpanel" aria-labelledby="tab-connected">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
                            <h5 class="fw-bold mb-0">Akun Terhubung</h5>
                            <p class="text-muted small mb-0">Masuk lebih cepat dengan menghubungkan akun pihak ketiga.</p>
                        </div>
                        <div class="card-body px-4 pb-4">
                            @include('profile.partials.connected-accounts')
                        </div>
                    </div>
                </div>

                {{-- Tab 4: Hapus Akun --}}
                <div class="tab-pane fade" id="danger-zone" role="tabpanel" aria-labelledby="tab-danger">
                    <div class="card border-0 shadow-sm rounded-4 mb-4 border-start border-danger border-4">
                        <div class="card-header bg-white py-3 px-4 border-bottom-0 pt-4">
                            <h5 class="fw-bold text-danger mb-0">Hapus Akun</h5>
                            <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan. Mohon pertimbangkan kembali.</p>
                        </div>
                        <div class="card-body px-4 pb-4">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling Nav Pills */
    .custom-pills .nav-link {
        color: #6c757d;
        font-weight: 500;
        transition: all 0.25s ease-in-out;
        border: 1px solid transparent;
        background: transparent;
    }
    .custom-pills .nav-link:hover {
        background-color: #f8f9fa;
        color: var(--bs-primary);
        transform: translateX(5px);
    }
    .custom-pills .nav-link.active {
        background-color: #eef2ff !important;
        color: var(--bs-primary) !important;
        font-weight: 600;
        box-shadow: inset 4px 0 0 var(--bs-primary);
    }
    .custom-pills .nav-link.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545;
    }
    .custom-pills .nav-link.text-danger.active {
        background-color: #fff5f5 !important;
        color: #dc3545 !important;
        box-shadow: inset 4px 0 0 #dc3545;
    }

    /* Avatar Hover Effect */
    .profile-avatar-wrapper img {
        transition: transform 0.3s ease;
    }
    .profile-avatar-wrapper:hover img {
        transform: scale(1.05);
    }

    .rounded-4 { border-radius: 1rem !important; }
    .object-fit-cover { object-fit: cover; }
</style>

@push('scripts')
<script>
    // Script untuk mengingat tab terakhir yang dibuka setelah refresh halaman
    document.addEventListener('DOMContentLoaded', function() {
        let activeTab = localStorage.getItem('activeProfileTab');
        if (activeTab) {
            let tabEl = document.querySelector(`button[data-bs-target="${activeTab}"]`);
            if (tabEl) {
                bootstrap.Tab.getOrCreateInstance(tabEl).show();
            }
        }

        const tabButtons = document.querySelectorAll('button[data-bs-toggle="pill"]');
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', (event) => {
                localStorage.setItem('activeProfileTab', event.target.getAttribute('data-bs-target'));
            });
        });
    });
</script>
@endpush

@endsection