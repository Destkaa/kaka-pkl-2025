{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}

{{-- Form untuk kirim ulang verifikasi (Hanya muncul jika fitur verifikasi email aktif) --}}
@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endif

<form method="post" action="{{ route('profile.update') }}" class="mt-2">
    @csrf
    @method('patch')

    <div class="row g-3">
        {{-- Nama --}}
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label fw-semibold small text-uppercase tracking-wider">
                    <i class="bi bi-person me-1 text-primary"></i> Nama Lengkap
                </label>
                <input type="text" name="name" id="name" 
                    class="form-control form-control-lg border-light-subtle bg-light @error('name') is-invalid @enderror shadow-none"
                    style="font-size: 0.95rem;"
                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email --}}
        <div class="col-md-6">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold small text-uppercase tracking-wider">
                    <i class="bi bi-envelope me-1 text-primary"></i> Alamat Email
                </label>
                <input type="email" name="email" id="email" 
                    class="form-control form-control-lg border-light-subtle bg-light @error('email') is-invalid @enderror shadow-none"
                    style="font-size: 0.95rem;"
                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Email Verification Notice --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="col-12">
            <div class="alert alert-warning border-0 rounded-3 py-2 px-3 small d-flex align-items-center mb-4">
                <i class="bi bi-exclamation-circle me-2 fs-5"></i>
                <div>
                    Email kamu belum diverifikasi. 
                    <button form="send-verification" class="btn btn-link p-0 fw-bold text-decoration-none small align-baseline shadow-none">
                        Kirim ulang verifikasi
                    </button>
                </div>
            </div>
            @if (session('status') === 'verification-link-sent')
            <div class="text-success small fw-bold mb-3 ms-1">
                <i class="bi bi-check2-all me-1"></i> Link verifikasi baru telah dikirim!
            </div>
            @endif
        </div>
        @endif

        {{-- Phone --}}
        <div class="col-12">
            <div class="mb-3">
                <label for="phone" class="form-label fw-semibold small text-uppercase tracking-wider">
                    <i class="bi bi-telephone me-1 text-primary"></i> Nomor Telepon
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-light-subtle text-muted small px-3">+62</span>
                    <input type="tel" name="phone" id="phone" 
                        class="form-control form-control-lg border-light-subtle bg-light @error('phone') is-invalid @enderror shadow-none"
                        style="font-size: 0.95rem;"
                        value="{{ old('phone', $user->phone) }}" placeholder="8xxxxxxxxxx">
                </div>
                @error('phone')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Address --}}
        <div class="col-12">
            <div class="mb-4">
                <label for="address" class="form-label fw-semibold small text-uppercase tracking-wider">
                    <i class="bi bi-geo-alt me-1 text-primary"></i> Alamat Pengiriman
                </label>
                <textarea name="address" id="address" rows="3" 
                    class="form-control border-light-subtle bg-light @error('address') is-invalid @enderror shadow-none"
                    style="font-size: 0.95rem; resize: none;"
                    placeholder="Contoh: Jl. Merdeka No. 123, Kelurahan, Kecamatan, Kota...">{{ old('address', $user->address) }}</textarea>
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3 mt-2">
        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill shadow-sm">
            Simpan Perubahan
        </button>
        
        {{-- Flash message sukses (Versi Plain CSS/JS agar tidak eror) --}}
        @if (session('status') === 'profile-updated')
            <span id="status-message" class="text-success small fw-semibold animate__animated animate__fadeIn">
                <i class="bi bi-check-lg"></i> Berhasil disimpan
            </span>
            <script>
                setTimeout(() => {
                    document.getElementById('status-message').style.display = 'none';
                }, 3000);
            </script>
        @endif
    </div>
</form>

<style>
    .tracking-wider { letter-spacing: 0.05em; }
    .form-control:focus {
        background-color: #fff !important;
        border-color: var(--bs-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.1) !important;
    }
    .input-group-text {
        border-right: none;
    }
</style>