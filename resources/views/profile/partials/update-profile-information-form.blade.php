{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}

<form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    {{-- Nama --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Lengkap</label>
        <input
            id="name"
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name) }}"
            required
            autocomplete="name"
        >

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            id="email"
            type="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email) }}"
            required
            autocomplete="email"
        >

        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Nomor Telepon --}}
    <div class="mb-3">
        <label for="phone" class="form-label">Nomor Telepon</label>
        <input
            id="phone"
            type="text"
            name="phone"
            class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $user->phone) }}"
            autocomplete="tel"
        >

        @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    {{-- Alamat --}}
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea
            id="address"
            name="address"
            class="form-control @error('address') is-invalid @enderror"
            rows="3"
        >{{ old('address', $user->address) }}</textarea>

        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">
        Simpan Perubahan
    </button>
</form>
