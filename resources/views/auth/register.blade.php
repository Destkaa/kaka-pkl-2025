{{-- ================================================
FILE: resources/views/auth/register.blade.php
FUNGSI: Halaman Registrasi User (Gadget Pro Style - Dark Mode Ready)
================================================ --}}

@extends('layouts.app')

@section('title', 'Daftar Akun Pro')

@section('content')
<style>
    /* VARIABEL KHUSUS REGISTER (SINKRON DENGAN GLOBAL) */
    :root {
        --auth-card-bg: #ffffff;
        --auth-text-muted: #64748b;
        --auth-input-bg: #f8fafc;
        --auth-brand-text: #1e293b;
    }

    [data-bs-theme="dark"] {
        --auth-card-bg: #1e293b;
        --auth-text-muted: #94a3b8;
        --auth-input-bg: #334155;
        --auth-brand-text: #f8fafc;
    }

    /* Card & Animations */
    .auth-card {
        background-color: var(--auth-card-bg) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 28px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        animation: slideUp 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Logo Brand Style (Sesuai Navbar) */
    .brand-text-auth {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--auth-brand-text) !important;
        text-decoration: none;
    }

    .auth-header {
        background: transparent;
        padding: 3rem 2rem 1.5rem;
        text-align: center;
    }

    .auth-body {
        padding: 0 2.5rem 2.5rem;
    }

    /* Input Styling */
    .form-label {
        font-weight: 700;
        color: var(--auth-text-muted);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .auth-input {
        background-color: var(--auth-input-bg) !important;
        color: var(--text-main) !important;
        border: 2px solid transparent !important;
        border-radius: 12px;
        padding: 0.8rem 1.2rem;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .auth-input:focus {
        background-color: var(--auth-card-bg) !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
    }

    /* Error Handling */
    .invalid-feedback {
        color: #ff4b5c !important;
        font-weight: 600;
        font-size: 0.8rem;
    }

    /* Button Style */
    .btn-auth-pro {
        padding: 1rem;
        border-radius: 50px;
        font-weight: 700;
        background-color: #6366f1 !important;
        color: white !important;
        border: none;
        transition: all 0.3s;
    }

    .btn-auth-pro:hover {
        background-color: #4f46e5 !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }

    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card card">
                <div class="auth-header">
                    {{-- Logo Identik Navbar --}}
                    <div class="mb-3 d-flex align-items-center justify-content-center">
                        <a href="{{ url('/') }}" class="brand-text-auth d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-2" 
                                 style="width: 38px; height: 38px; background: #6366f1; color: white;">
                                <i class="bi bi-lightning-charge-fill fs-5"></i>
                            </div>
                            GADGET<span style="color: #6366f1;">PRO</span>
                        </a>
                    </div>
                    <h4 class="fw-bold mb-1" style="color: var(--text-main);">Buat Akun Pro</h4>
                    <p class="small" style="color: var(--auth-text-muted);">Gabung sekarang dan nikmati fitur eksklusif</p>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control auth-input @error('name') is-invalid @enderror shadow-none" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input id="email" type="email" class="form-control auth-input @error('email') is-invalid @enderror shadow-none" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" 
                                   placeholder="nama@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control auth-input @error('password') is-invalid @enderror shadow-none" 
                                   name="password" required autocomplete="new-password" 
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            <input id="password-confirm" type="password" class="form-control auth-input shadow-none" 
                                   name="password_confirmation" required autocomplete="new-password" 
                                   placeholder="Ulangi password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-auth-pro shadow-sm">
                                Daftar Akun <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>

                    <div class="auth-footer">
                        <span style="color: var(--auth-text-muted);">Sudah punya akun?</span> 
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none ms-1" style="color: #6366f1;">
                            Masuk Sekarang
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="/" class="text-decoration-none small opacity-75" style="color: var(--auth-text-muted);">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection