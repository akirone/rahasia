@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@push('styles')
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            width: 280px;
            background: linear-gradient(180deg, #2d3748 0%, #1a202c 100%);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.15rem;
        }

        .sidebar-brand i {
            font-size: 1.5rem;
        }

        .sidebar-menu {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1.5rem;
            color: #cbd5e0;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            font-weight: 500;
        }

        .menu-item i {
            font-size: 1.25rem;
            width: 24px;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .menu-item.active {
            background: rgba(102, 126, 234, 0.15);
            color: white;
            border-left: 3px solid #667eea;
        }

        /* Main Content */
        .admin-main {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .welcome-text {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.9375rem;
            color: #1a202c;
            font-weight: 500;
        }

        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.625rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            margin-left: 0.5rem;
        }

        .role-badge.admin {
            background-color: #ebf4ff;
            color: #3b82f6;
        }

        .role-badge.user {
            background-color: #f0fdf4;
            color: #22c55e;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #48bb78 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            position: relative;
        }

        .user-avatar::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #48bb78;
            border: 2px solid white;
            border-radius: 50%;
        }

        /* Dashboard Header with Gradient */
        .dashboard-header {
            background: linear-gradient(135deg, #38b2ac 0%, #319795 100%);
            padding: 3rem 2rem 8rem;
            margin-bottom: -4rem;
            color: white;
        }

        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }

        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            border: none;
            margin-bottom: 2rem;
        }

        .table-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: white;
        }

        .table-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
        }

        .content-area {
            padding: 0 2rem 2rem;
            flex: 1;
        }

        .badge-priority {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-medium {
            background-color: #fef3c7;
            color: #d97706;
        }

        .badge-high {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .badge-low {
            background-color: #d1fae5;
            color: #10b981;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table thead th {
            background: #f7fafc;
            color: #4a5568;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 2rem;
            border: none;
            text-align: left;
        }

        .custom-table tbody td {
            padding: 1.25rem 2rem;
            vertical-align: middle;
            border-top: 1px solid #e2e8f0;
            color: #2d3748;
        }

        .custom-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .btn-create {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 8px;
            color: #11998e;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-create:hover {
            background: #11998e;
            color: white;
            border-color: #11998e;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="sidebar-brand">
                    <i class="bi bi-grid-3x3-gap-fill"></i>
                    <span>Dashboard Admin</span>
                </a>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="menu-item">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('pengaduan.index') }}" class="menu-item active">
                    <i class="bi bi-briefcase"></i>
                    <span>Semua Pengaduan</span>
                </a>

                <a href="{{ route('kategori.index') }}" class="menu-item">
                    <i class="bi bi-folder"></i>
                    <span>Kelola Kategori</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <!-- Top Header -->
            <header class="top-header">
                <div class="user-profile">
                    <div class="welcome-text">
                        Selamat datang, {{ Auth::user()->name }}
                        <span class="role-badge {{ Auth::user()->isAdmin() ? 'admin' : 'user' }}">
                            {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                        </span>
                    </div>
                    <div class="dropdown">
                        <a href="#" class="user-avatar" data-bs-toggle="dropdown" style="text-decoration: none;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>

            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1 class="dashboard-title">{{ auth()->user()->isAdmin() ? 'Semua Pengaduan' : 'Pengaduan Saya' }}</h1>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Success Alert -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                        style="border-radius: 12px; border: none; margin-bottom: 1.5rem;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Filter Section -->
                <div class="table-card">
                    <div class="table-card-header">
                        <h2 class="table-card-title">Filter Pengaduan</h2>
                    </div>
                    <div class="card-body" style="padding: 24px;">
                        <form action="{{ route('pengaduan.index') }}" method="GET">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label"
                                        style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Status</label>
                                    <select name="status" class="form-select"
                                        style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                                        <option value="">Semua Status</option>
                                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>
                                            Menunggu
                                        </option>
                                        <option value="Proses" {{ request('status') == 'Proses' ? 'selected' : '' }}>Proses
                                        </option>
                                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>
                                            Selesai</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"
                                        style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Kategori</label>
                                    <select name="kategori_id" class="form-select"
                                        style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                                        <option value="">Semua Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}"
                                                {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if (auth()->user()->isAdmin())
                                    <div class="col-md-3">
                                        <label class="form-label"
                                            style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Filter
                                            Siswa</label>
                                        <input type="text" name="siswa" class="form-control"
                                            style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;"
                                            placeholder="Nama/NIS siswa..." value="{{ request('siswa') }}">
                                    </div>
                                @endif

                                <div class="col-md-3">
                                    <label class="form-label"
                                        style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Bulan</label>
                                    <input type="month" name="bulan" class="form-control"
                                        style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;"
                                        value="{{ request('bulan') }}">
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <div class="col-md-3">
                                    <label class="form-label"
                                        style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Dari
                                        Tanggal</label>
                                    <input type="date" name="dari_tanggal" class="form-control"
                                        style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;"
                                        value="{{ request('dari_tanggal') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label"
                                        style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Sampai
                                        Tanggal</label>
                                    <input type="date" name="sampai_tanggal" class="form-control"
                                        style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;"
                                        value="{{ request('sampai_tanggal') }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label"
                                        style="color: #4a5568; font-weight: 500; font-size: 14px; margin-bottom: 8px;">Pencarian</label>
                                    <input type="text" name="search" class="form-control"
                                        style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;"
                                        placeholder="Cari lokasi atau keterangan..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label d-block" style="margin-bottom: 8px;">&nbsp;</label>
                                    <button type="submit" class="btn-create w-100">
                                        <i class="bi bi-search"></i> Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Pengaduan Table -->
                <div class="table-card">
                    <div class="table-card-header">
                        <h2 class="table-card-title">
                            <i class="bi bi-list-ul"></i> Daftar Pengaduan
                        </h2>
                    </div>
                    <div class="table-card-body">
                        @if ($pengaduans->count() > 0)
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        @if (auth()->user()->isAdmin())
                                            <th>Siswa</th>
                                        @endif
                                        <th>Kategori</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduans as $pengaduan)
                                        <tr>
                                            <td>
                                                <small style="color: #4a5568; font-weight: 500;">
                                                    {{ $pengaduan->tanggal->format('d/m/Y') }}<br>
                                                    <span
                                                        style="color: #a0aec0; font-size: 11px;">{{ $pengaduan->tanggal->format('H:i') }}</span>
                                                </small>
                                            </td>
                                            @if (auth()->user()->isAdmin())
                                                <td>
                                                    <div>
                                                        <strong
                                                            style="color: #2d3748;">{{ $pengaduan->user->name }}</strong><br>
                                                        <small
                                                            style="color: #718096;">{{ $pengaduan->user->kelas }}</small>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                <span class="badge-priority badge-low">
                                                    <i class="bi bi-folder-fill"></i> {{ $pengaduan->kategori->nama }}
                                                </span>
                                            </td>
                                            <td style="color: #4a5568; font-weight: 500;">
                                                {{ Str::limit($pengaduan->lokasi, 30) }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusConfig = [
                                                        'Menunggu' => ['class' => 'badge-high', 'icon' => 'clock-fill'],
                                                        'Proses' => [
                                                            'class' => 'badge-medium',
                                                            'icon' => 'hourglass-split',
                                                        ],
                                                        'Selesai' => [
                                                            'class' => 'badge-low',
                                                            'icon' => 'check-circle-fill',
                                                        ],
                                                    ];
                                                    $config = $statusConfig[$pengaduan->status];
                                                @endphp
                                                <span class="badge-priority {{ $config['class'] }}">
                                                    <i class="bi bi-{{ $config['icon'] }}"></i> {{ $pengaduan->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if ($pengaduan->foto)
                                                    <i class="bi bi-image-fill"
                                                        style="color: #48bb78; font-size: 18px;"></i>
                                                @else
                                                    <i class="bi bi-dash-circle"
                                                        style="color: #cbd5e0; font-size: 18px;"></i>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('pengaduan.show', $pengaduan) }}"
                                                    class="btn btn-sm btn-info text-white"
                                                    style="border-radius: 6px; padding: 6px 12px;" title="Lihat Detail">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
                                                @if (!auth()->user()->isAdmin() && auth()->user()->id == $pengaduan->user_id)
                                                    <form action="{{ route('pengaduan.destroy', $pengaduan) }}"
                                                        method="POST" style="display: inline-block;"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            style="border-radius: 6px; padding: 6px 12px;" title="Hapus">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div style="padding: 20px; border-top: 1px solid #e2e8f0;">
                                {{ $pengaduans->links() }}
                            </div>
                        @else
                            <div style="text-align: center; padding: 60px 20px;">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: #cbd5e0;"></i>
                                <p style="color: #a0aec0; margin-top: 15px; font-size: 16px;">
                                    @if (request()->hasAny(['status', 'kategori_id', 'search']))
                                        Tidak ada pengaduan yang sesuai dengan filter
                                    @else
                                        Belum ada pengaduan
                                    @endif
                                </p>
                                @if (!auth()->user()->isAdmin())
                                    <button type="button" class="btn-create" style="margin-top: 15px;"
                                        data-bs-toggle="modal" data-bs-target="#createPengaduanModal">
                                        <i class="bi bi-plus-lg"></i> Buat Pengaduan Pertama
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Create Pengaduan Modal (User Only) -->
    @if (!auth()->user()->isAdmin())
        <div class="modal fade" id="createPengaduanModal" tabindex="-1" aria-labelledby="createPengaduanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content" style="border-radius: 16px; border: none;">
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title text-white" id="createPengaduanModalLabel">
                            <i class="bi bi-file-earmark-plus-fill"></i> Buat Pengaduan Baru
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 30px;">
                        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data"
                            id="formPengaduan">
                            @csrf

                            <div class="mb-4">
                                <label for="kategori_id" class="form-label" style="color: #4a5568; font-weight: 500;">
                                    Kategori Pengaduan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="kategori_id" name="kategori_id" required
                                    style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="lokasi" class="form-label" style="color: #4a5568; font-weight: 500;">
                                    Lokasi Kejadian <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                    placeholder="Contoh: Ruang Kelas XII RPL" required
                                    style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                                <small style="color: #718096;">Sebutkan lokasi spesifik kejadian</small>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label" style="color: #4a5568; font-weight: 500;">
                                    Keterangan Lengkap <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="5"
                                    placeholder="Jelaskan detail pengaduan Anda..." required
                                    style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;"></textarea>
                                <small style="color: #718096;">Berikan penjelasan sedetail mungkin</small>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label" style="color: #4a5568; font-weight: 500;">
                                    Foto Pendukung (Opsional)
                                </label>
                                <input type="file" class="form-control" id="foto" name="foto"
                                    accept="image/*"
                                    style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                                <small style="color: #718096;">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                            </div>

                            <div class="alert alert-info"
                                style="background: #e6fffa; border-left: 4px solid #11998e; border-radius: 8px;">
                                <i class="bi bi-info-circle-fill me-2" style="color: #11998e;"></i>
                                <strong>Catatan:</strong> Pengaduan Anda akan direview oleh admin. Status awal adalah
                                "Menunggu".
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    style="border-radius: 8px; padding: 10px 20px;">
                                    <i class="bi bi-x-circle"></i> Batal
                                </button>
                                <button type="submit" class="btn-create" style="padding: 10px 20px;">
                                    <i class="bi bi-send-fill"></i> Kirim Pengaduan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
