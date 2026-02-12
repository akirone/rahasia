@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    <style>
        body {
            background: linear-gradient(135deg, #064e3b 0%, #047857 25%, #059669 50%, #10b981 75%, #6ee7b7 100%);
            min-height: 100vh;
        }

        .card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95) !important;
        }

        .text-gradient {
            background: linear-gradient(135deg, #047857, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(4, 120, 87, 0.4);
            color: white;
        }

        .input-group-text {
            background: linear-gradient(135deg, #047857, #10b981);
            color: white;
            border: none;
        }

        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }

        .text-primary {
            color: #059669 !important;
        }

        .link-gradient {
            background: linear-gradient(135deg, #047857, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
        }

        .link-gradient:hover {
            background: linear-gradient(135deg, #065f46, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-megaphone text-gradient" style="font-size: 4rem;"></i>
                            <h3 class="fw-bold mt-3 text-gradient">Login</h3>
                            <p class="text-muted">Aplikasi Pengaduan Sekolah</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Masukkan email" required autofocus>
                                </div>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-gradient w-100 py-2 mb-3">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </button>
                        </form>

                        {{-- <div class="text-center mt-3">
                            <p class="text-muted mb-0">Belum punya akun? <a href="{{ route('register') }}"
                                    class="link-gradient text-decoration-none">Daftar sekarang</a></p>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
