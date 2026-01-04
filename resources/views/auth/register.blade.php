{{-- ================================================
FILE: resources/views/auth/register.blade.php
FUNGSI: Halaman Registrasi User (Soft UI Modern - Anti Gepeng)
================================================ --}}

@extends('layouts.app')

@section('title', 'Daftar Akun')

@push('styles')
<style>
    body {
        background-color: #f8fafc;
    }
    .auth-card {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    /* FIX ANTI GEPENG UNTUK ICON */
    .icon-box {
        width: 68px;
        height: 68px;
        background: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        flex-shrink: 0;
    }
    .auth-header {
        background: white;
        border-bottom: 1px solid #f1f5f9;
        padding: 2.5rem 2rem 1.5rem;
        text-align: center;
    }
    .auth-body {
        padding: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
    }
    .form-control {
        border-radius: 12px;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        background-color: #fcfdfe;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
        background-color: white;
    }
    .btn-auth {
        padding: 0.8rem;
        border-radius: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }
    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
    .auth-footer {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card card">
                <div class="auth-header">
                    {{-- Container Icon yang dipastikan bulat sempurna --}}
                    <div class="icon-box shadow-sm">
                        <i class="bi bi-person-plus-fill fs-2"></i>
                    </div>
                    <h3 class="fw-bold text-dark">Daftar Akun</h3>
                    <p class="text-muted">Lengkapi data untuk mulai berbelanja</p>
                </div>

                <div class="auth-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus 
                                   placeholder="Masukkan nama lengkap">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Alamat Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" 
                                   placeholder="contoh@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="new-password" 
                                   placeholder="Minimal 8 karakter">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Konfirmasi Password</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                   name="password_confirmation" required autocomplete="new-password" 
                                   placeholder="Ulangi password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-auth shadow-sm">
                                Daftar Sekarang <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>

                    <div class="auth-footer">
                        <span class="text-muted">Sudah punya akun?</span> 
                        <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Masuk</a>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="/" class="text-muted text-decoration-none small hover-link">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection