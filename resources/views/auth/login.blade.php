{{-- ================================================
FILE: resources/views/auth/login.blade.php
FUNGSI: Halaman Login Gadget Pro (Premium Black Google Button)
================================================ --}}

@extends('layouts.app')

@section('content')
<style>
    /* VARIABEL KHUSUS LOGIN (SINKRON DENGAN GLOBAL) */
    :root {
        --login-card-bg: #ffffff;
        --login-text-muted: #64748b;
        --login-input-bg: #f8fafc;
        --login-brand-text: #1e293b;
        --google-btn-bg: #000000;
        --google-btn-text: #ffffff;
    }

    [data-bs-theme="dark"] {
        --login-card-bg: #1e293b;
        --login-text-muted: #94a3b8;
        --login-input-bg: #334155;
        --login-brand-text: #f8fafc;
        --google-btn-bg: #f8fafc;
        --google-btn-text: #000000;
    }

    .rounded-4 { border-radius: 1.25rem !important; }
    
    .login-card {
        background-color: var(--login-card-bg) !important;
        animation: slideUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid var(--border-color) !important;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-input {
        background-color: var(--login-input-bg) !important;
        color: var(--text-main) !important;
        border: 2px solid transparent !important;
        transition: 0.3s;
    }

    .login-input:focus {
        background-color: var(--login-card-bg) !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.1) !important;
    }

    .invalid-feedback {
        color: #ff4b5c !important;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .brand-text-login {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--login-brand-text) !important;
        text-decoration: none;
    }

    .btn-gadget-pro {
        background-color: #6366f1 !important;
        color: white !important;
        border: none;
        transition: 0.3s;
    }

    .btn-gadget-pro:hover {
        background-color: #4f46e5 !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(99, 102, 241, 0.3);
    }

    .btn-google-pro {
        background-color: var(--google-btn-bg) !important;
        color: var(--google-btn-text) !important;
        border: none !important;
        transition: all 0.3s ease;
    }

    .btn-google-pro:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .or-divider {
        background-color: var(--login-card-bg) !important;
        color: var(--login-text-muted);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center align-items-center" style="min-height: 85vh;">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden login-card">
                
                <div class="card-header bg-transparent border-0 pt-5 pb-4 text-center">
                    <div class="mb-2">
                        <a href="{{ url('/') }}" class="brand-text-login d-flex align-items-center justify-content-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-2" 
                                 style="width: 40px; height: 40px; background: #6366f1; color: white;">
                                <i class="bi bi-lightning-charge-fill"></i>
                            </div>
                            GADGET<span style="color: #6366f1;">PRO</span>
                        </a>
                    </div>
                    <p class="small px-4 mt-2" style="color: var(--login-text-muted);">Masuk untuk akses penuh belanja premium.</p>
                </div>

                <div class="card-body px-4 px-lg-5 pb-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase" style="color: var(--login-text-muted);">Email</label>
                            <input type="email" name="email" 
                                class="form-control form-control-lg rounded-3 login-input @error('email') is-invalid @enderror shadow-none" 
                                value="{{ old('email') }}" required autofocus placeholder="email@contoh.com">
                            
                            @error('email')
                                <span class="invalid-feedback d-block mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label fw-bold small text-uppercase" style="color: var(--login-text-muted);">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small fw-bold" href="{{ route('password.request') }}" style="color: #6366f1;">Lupa?</a>
                                @endif
                            </div>
                            <input type="password" name="password" 
                                class="form-control form-control-lg rounded-3 login-input @error('password') is-invalid @enderror shadow-none" 
                                required placeholder="••••••••">
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label small" for="remember" style="color: var(--login-text-muted);">Ingat saya</label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-gadget-pro btn-lg fw-bold rounded-pill py-3">
                                Sign In
                            </button>
                        </div>

                        <div class="position-relative text-center my-4">
                            <hr style="color: var(--border-color); opacity: 1;">
                            <span class="position-absolute top-50 start-50 translate-middle px-3 small or-divider">atau</span>
                        </div>

                        <div class="d-grid">
                            <a href="{{ route('auth.google') }}" class="btn btn-google-pro rounded-pill py-2 d-flex align-items-center justify-content-center fw-bold shadow-none">
                                <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" class="me-2" alt="Google">
                                Google Account
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer border-0 py-4 text-center" style="background: var(--dropdown-info);">
                    <p class="mb-0 small" style="color: var(--login-text-muted);">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none ms-1" style="color: #6366f1;">Daftar Sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection