@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="mb-4">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="fw-bold mt-2">Edit User: {{ $user->name }}</h2>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-md-4 text-center">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <div class="mb-3">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" id="preview" class="rounded-circle object-fit-cover" style="width:150px; height:150px; border: 5px solid #f8fafc;">
                        @else
                            <div id="placeholder" class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width:150px; height:150px; font-size: 3rem;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <input type="file" name="avatar" class="form-control form-control-sm" onchange="previewImage(this)">
                </div>
            </div>

            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Role</label>
                            <select name="is_admin" class="form-select">
                                <option value="0" {{ !$user->is_admin ? 'selected' : '' }}>User</option>
                                <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Password Baru (Opsional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4 px-4 py-2 fw-bold">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection