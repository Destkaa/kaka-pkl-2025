{{-- ======================================== 
FILE: resources/views/auth/login.blade.php 
FUNGSI: Halaman form login modern
======================================== --}}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-md-5">
            {{-- Card Utama --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                {{-- Header dengan Gradien Halus atau Warna Solid --}}
                <div class="card-header bg-white border-0 pt-5 pb-4 text-center">
                    <div class="mb-3">
                        <i class="bi bi-bag-heart-fill text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Selamat Datang Kembali!</h3>
                    <p class="text-muted small">Silakan masuk ke akun Anda untuk melanjutkan belanja.</p>
                </div>

                <div class="card-body px-4 px-lg-5 pb-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold small text-uppercase tracking-wider text-muted">
                                <i class="bi bi-envelope me-1"></i> Alamat Email
                            </label>
                            <input id="email" type="email" 
                                class="form-control form-control-lg bg-light border-light-subtle rounded-3 @error('email') is-invalid @enderror shadow-none" 
                                name="email" value="{{ old('email') }}" 
                                required autocomplete="email" autofocus placeholder="nama@email.com"
                                style="font-size: 0.95rem;">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label for="password" class="form-label fw-semibold small text-uppercase tracking-wider text-muted">
                                    <i class="bi bi-lock me-1"></i> Password
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-medium" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" 
                                class="form-control form-control-lg bg-light border-light-subtle rounded-3 @error('password') is-invalid @enderror shadow-none" 
                                name="password" required autocomplete="current-password" placeholder="••••••••"
                                style="font-size: 0.95rem;">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Remember Me --}}
                        <div class="mb-4 form-check">
                            <input class="form-check-input shadow-none" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label small text-muted" for="remember">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        {{-- Tombol Login --}}
                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-pill shadow-sm py-3" style="font-size: 1rem;">
                                Masuk Sekarang
                            </button>
                        </div>

                        {{-- Pembatas Social Login --}}
                        <div class="position-relative text-center my-4">
                            <hr class="text-muted opacity-25">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">atau masuk dengan</span>
                        </div>

                        {{-- Google Login --}}
                        <div class="d-grid gap-2">
                            <a href="{{ route('auth.google') }}" class="btn btn-outline-light border text-dark fw-medium rounded-pill py-2 shadow-none d-flex align-items-center justify-content-center">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" class="me-2" alt="Google Logo" />
                                Google
                            </a>
                        </div>
                    </form>
                </div>

                {{-- Footer Register --}}
                <div class="card-footer bg-light border-0 py-4 text-center">
                    <p class="mb-0 small text-muted">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none ms-1">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
            
            {{-- Link Kembali ke Home --}}
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="text-muted text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.05em; }
    .rounded-4 { border-radius: 1.25rem !important; }
    
    /* Efek Fokus Input */
    .form-control:focus {
        background-color: #fff !important;
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.1) !important;
    }

    /* Styling Button Outline */
    .btn-outline-light:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    /* Animasi sederhana saat halaman dimuat */
    .card {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection