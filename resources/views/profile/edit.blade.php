@extends('layouts.app')

@section('title', 'Edit Profil')

@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .profile-header {
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            color: white;
            padding: 2rem;
            border-radius: 10px 10px 0 0;
        }

        .info-card {
            background: #f8f9fc;
            border-left: 4px solid #10b981;
            padding: 1rem;
            border-radius: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4 mb-5">
        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error Messages --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="alert-heading">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi Kesalahan!
                </h6>
                <hr>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <!-- Form Edit Profile -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="profile-header">
                        <h4 class="mb-1">
                            <i class="bi bi-person-circle"></i> Edit Profil
                        </h4>
                        <small>Perbarui informasi akun Anda</small>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $user->name) }}"
                                    placeholder="Masukkan username" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3">
                                <i class="bi bi-shield-lock"></i> Ubah Password (Opsional)
                            </h6>
                            <p class="text-muted small mb-3">Kosongkan jika tidak ingin mengubah password</p>

                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    Password Baru
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Minimal 4 karakter">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">
                                    Konfirmasi Password Baru
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password baru">
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Info Account -->
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="bi bi-info-circle-fill text-primary"></i> Informasi Akun
                        </h6>
                        <div class="info-card mb-2">
                            <small class="text-muted d-block mb-1">Email</small>
                            <strong>{{ $user->email }}</strong>
                        </div>
                        <div class="info-card mb-2">
                            <small class="text-muted d-block mb-1">NIS/NISN</small>
                            <strong>{{ $user->nis }}</strong>
                        </div>
                        <div class="info-card mb-2">
                            <small class="text-muted d-block mb-1">Kelas</small>
                            <strong>{{ $user->kelas }}</strong>
                        </div>
                        <div class="info-card">
                            <small class="text-muted d-block mb-1">Terdaftar Sejak</small>
                            <strong>{{ $user->created_at->format('d F Y') }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="bi bi-lightbulb-fill text-warning"></i> Tips Keamanan
                        </h6>
                        <ul class="small mb-0 ps-3">
                            <li class="mb-2">Gunakan username yang mudah diingat</li>
                            <li class="mb-2">Gunakan password yang kuat dan unik</li>
                            <li class="mb-2">Jangan bagikan password kepada siapapun</li>
                            <li>Perbarui password secara berkala</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
