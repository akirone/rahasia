@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar-gradient {
            background: linear-gradient(135deg, #38b2ac 0%, #319795 100%);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-gradient .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .navbar-gradient .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }

        .navbar-gradient .nav-link:hover {
            color: white !important;
        }

        .navbar-gradient .nav-link.active {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }

        .navbar-gradient .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.8);
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navbar-gradient .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: white;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .progress-bar-custom {
            height: 8px;
            border-radius: 10px;
            overflow: hidden;
            background-color: #e9ecef;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .feedback-count {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            background: #e3f2fd;
            color: #1976d2;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-timeline {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .timeline-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .btn-create-float {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #38b2ac 0%, #319795 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(56, 178, 172, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .btn-create-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 16px rgba(56, 178, 172, 0.6);
        }
    </style>
@endpush

@section('content')
    <!-- Navbar with Gradient -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-gradient">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-shield-check"></i> Sistem Pengaduan Sekolah
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <span class="nav-link" style="color: rgba(255, 255, 255, 0.9);">
                            Selamat datang, {{ Auth::user()->name }}
                        </span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-nav').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form id="logout-form-nav" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <div class="container py-4">
        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-bold mb-1">Dashboard Siswa</h2>
                <p class="text-muted mb-0">Pantau status dan progres pengaduan Anda</p>
            </div>
            <button type="button" class="btn btn-primary d-none d-md-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#createPengaduanModal">
                <i class="bi bi-plus-circle"></i> Buat Pengaduan Baru
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <!-- Total Pengaduan -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Total Pengaduan</p>
                                <h3 class="fw-bold mb-0">{{ $totalPengaduan }}</h3>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="bi bi-megaphone text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menunggu -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Menunggu</p>
                                <h3 class="fw-bold mb-0">{{ $menunggu }}</h3>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="bi bi-clock-history text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Proses -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Proses</p>
                                <h3 class="fw-bold mb-0">{{ $proses }}</h3>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="bi bi-arrow-repeat text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1">Selesai</p>
                                <h3 class="fw-bold mb-0">{{ $selesai }}</h3>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Pengaduan -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">Pengaduan Saya Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($recentPengaduan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4 py-3">Lokasi</th>
                                            <th class="py-3">Kategori</th>
                                            <th class="py-3">Status & Progres</th>
                                            <th class="py-3" style="width: 100px;">Feedback</th>
                                            <th class="py-3">Tanggal</th>
                                            <th class="py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentPengaduan as $pengaduan)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div class="text-truncate" style="max-width: 300px;">
                                                        {{ $pengaduan->lokasi }}
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <span
                                                        class="badge bg-secondary">{{ $pengaduan->kategori->nama }}</span>
                                                </td>
                                                <td class="py-3">
                                                    <div class="status-timeline mb-2">
                                                        @if ($pengaduan->status === 'Menunggu')
                                                            <span class="timeline-dot bg-warning"></span>
                                                            <span class="badge bg-warning text-dark">
                                                                <i class="bi bi-clock"></i> Menunggu
                                                            </span>
                                                        @elseif($pengaduan->status === 'Proses')
                                                            <span class="timeline-dot bg-info"></span>
                                                            <span class="badge bg-info">
                                                                <i class="bi bi-arrow-repeat"></i> Proses
                                                            </span>
                                                        @else
                                                            <span class="timeline-dot bg-success"></span>
                                                            <span class="badge bg-success">
                                                                <i class="bi bi-check-circle"></i> Selesai
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="progress-bar-custom">
                                                        <div class="progress-bar-fill"
                                                            style="width: {{ $pengaduan->status === 'Selesai' ? '100%' : ($pengaduan->status === 'Proses' ? '60%' : '20%') }};
                                                                   background: {{ $pengaduan->status === 'Selesai' ? '#10b981' : ($pengaduan->status === 'Proses' ? '#3b82f6' : '#f59e0b') }};">
                                                        </div>
                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.7rem;">
                                                        {{ $pengaduan->status === 'Selesai' ? '100%' : ($pengaduan->status === 'Proses' ? '60%' : '20%') }}
                                                        selesai
                                                    </small>
                                                </td>
                                                <td class="py-3 text-center">
                                                    @if ($pengaduan->feedback->count() > 0)
                                                        <span class="feedback-count">
                                                            <i class="bi bi-chat-left-text-fill"></i>
                                                            {{ $pengaduan->feedback->count() }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted" style="font-size: 0.875rem;">-</span>
                                                    @endif
                                                </td>
                                                <td class="py-3">
                                                    <small>{{ $pengaduan->created_at->format('d M Y') }}</small>
                                                </td>
                                                <td class="py-3">
                                                    <div class="d-flex gap-1">
                                                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        @if ($pengaduan->status === 'Menunggu')
                                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editPengaduanModal{{ $pengaduan->id }}">
                                                                <i class="bi bi-pencil"></i>
                                                            </button>
                                                            <form action="{{ route('pengaduan.destroy', $pengaduan) }}"
                                                                method="POST" style="display: inline-block;"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-outline-danger">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Edit Modal for each pengaduan -->
                                            @if ($pengaduan->status === 'Menunggu')
                                                <div class="modal fade" id="editPengaduanModal{{ $pengaduan->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Pengaduan</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('pengaduan.update', $pengaduan) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="kategori_id_{{ $pengaduan->id }}"
                                                                            class="form-label">Kategori Pengaduan <span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="form-select"
                                                                            id="kategori_id_{{ $pengaduan->id }}"
                                                                            name="kategori_id" required>
                                                                            <option value="">Pilih Kategori</option>
                                                                            @foreach ($kategoris as $kategori)
                                                                                <option value="{{ $kategori->id }}"
                                                                                    {{ $pengaduan->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                                                    {{ $kategori->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="lokasi_{{ $pengaduan->id }}"
                                                                            class="form-label">Lokasi Kejadian <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_{{ $pengaduan->id }}"
                                                                            name="lokasi"
                                                                            placeholder="Contoh: Ruang Kelas XII RPL"
                                                                            required value="{{ $pengaduan->lokasi }}">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="keterangan_{{ $pengaduan->id }}"
                                                                            class="form-label">Keterangan Lengkap <span
                                                                                class="text-danger">*</span></label>
                                                                        <textarea class="form-control" id="keterangan_{{ $pengaduan->id }}" name="keterangan" rows="5"
                                                                            placeholder="Jelaskan detail pengaduan Anda..." required>{{ $pengaduan->keterangan }}</textarea>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="foto_{{ $pengaduan->id }}"
                                                                            class="form-label">Foto Pendukung
                                                                            (Opsional)
                                                                        </label>
                                                                        @if ($pengaduan->foto)
                                                                            <div class="mb-2">
                                                                                <small class="text-muted">Foto saat ini:
                                                                                    {{ basename($pengaduan->foto) }}</small>
                                                                            </div>
                                                                        @endif
                                                                        <input type="file" class="form-control"
                                                                            id="foto_{{ $pengaduan->id }}" name="foto"
                                                                            accept="image/*">
                                                                        <small class="text-muted">Format: JPG, JPEG, PNG.
                                                                            Maksimal 2MB</small>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan
                                                                        Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-3">Anda belum memiliki pengaduan</p>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createPengaduanModal">
                                    <i class="bi bi-plus-circle"></i> Buat Pengaduan Pertama
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Pengaduan Modal -->
    <div class="modal fade" id="createPengaduanModal" tabindex="-1" aria-labelledby="createPengaduanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #38b2ac 0%, #319795 100%);">
                    <h5 class="modal-title text-white" id="createPengaduanModalLabel">
                        <i class="bi bi-file-earmark-plus-fill"></i> Buat Pengaduan Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">Kategori Pengaduan <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi Kejadian <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                placeholder="Contoh: Ruang Kelas XII RPL" required>
                            <small class="text-muted">Sebutkan lokasi spesifik kejadian</small>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan Lengkap <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="5"
                                placeholder="Jelaskan detail pengaduan Anda..." required></textarea>
                            <small class="text-muted">Berikan penjelasan sedetail mungkin</small>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Pendukung (Opsional)</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 4MB</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <strong>Catatan:</strong> Pengaduan Anda akan direview oleh admin. Status awal adalah
                            "Menunggu".
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send-fill"></i> Kirim Pengaduan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
