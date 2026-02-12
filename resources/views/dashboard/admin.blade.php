@extends('layouts.app')

@section('title', 'Dashboard Admin')

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

        .menu-section-title {
            padding: 0 1.5rem;
            margin-bottom: 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
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

        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: none;
            height: 100%;
        }

        .stats-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
        }

        .stats-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1;
            color: #1a202c;
        }

        .stats-label {
            color: #4a5568;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stats-sublabel {
            color: #a0aec0;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .icon-blue {
            background: linear-gradient(135deg, #ebf4ff 0%, #dbeafe 100%);
            color: #3b82f6;
        }

        .icon-blue-list {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #2563eb;
        }

        .icon-pink {
            background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
            color: #ec4899;
        }

        .icon-green {
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            color: #10b981;
        }

        .table-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            border: none;
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

        .modern-table {
            margin: 0;
        }

        .modern-table thead th {
            background: #f7fafc;
            color: #4a5568;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 2rem;
            border: none;
        }

        .modern-table tbody td {
            padding: 1.25rem 2rem;
            vertical-align: middle;
            border-top: 1px solid #e2e8f0;
            color: #2d3748;
        }

        /* Compact table styling */
        .modern-table.table-compact thead th {
            padding: 0.875rem 1rem;
        }

        .modern-table.table-compact tbody td {
            padding: 1rem 1rem;
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-warning {
            background-color: #fef5e7;
            color: #d69e2e;
        }

        .status-info {
            background-color: #ebf8ff;
            color: #3182ce;
        }

        .status-success {
            background-color: #f0fff4;
            color: #38a169;
        }

        .project-avatar-group {
            display: flex;
            margin-left: -8px;
        }

        .project-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
        }

        .progress-bar-custom {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
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

        .project-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .project-title {
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 0.25rem;
        }

        .project-subtitle {
            font-size: 0.875rem;
            color: #64748b;
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

        .member-avatars {
            display: flex;
            align-items: center;
        }

        .member-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: -8px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .member-avatar:first-child {
            margin-left: 0;
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
                <a href="{{ route('dashboard') }}" class="menu-item active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('pengaduan.index') }}" class="menu-item">
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
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-gear"></i> Edit Profile
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
                <h1 class="dashboard-title">Proyek</h1>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                        style="border-radius: 12px; border: none; margin-bottom: 1.5rem;">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Statistics Cards -->
                <div class="row g-4 mb-4">
                    <!-- Projects Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="stats-card">
                            <div class="stats-icon icon-blue">
                                <i class="bi bi-briefcase"></i>
                            </div>
                            <div class="stats-number">{{ $totalPengaduan }}</div>
                            <div class="stats-label">Proyek</div>
                            <div class="stats-sublabel">{{ $selesai }} Selesai</div>
                        </div>
                    </div>

                    <!-- Active Task Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="stats-card">
                            <div class="stats-icon icon-blue-list">
                                <i class="bi bi-list-task"></i>
                            </div>
                            <div class="stats-number">{{ $menunggu + $proses }}</div>
                            <div class="stats-label">Tugas Aktif</div>
                            <div class="stats-sublabel">{{ $proses }} Sedang Proses</div>
                        </div>
                    </div>

                    <!-- Teams Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="stats-card">
                            <div class="stats-icon icon-pink">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="stats-number">{{ $totalUser }}</div>
                            <div class="stats-label">Anggota</div>
                            <div class="stats-sublabel">{{ $totalKategori }} Kategori Pengaduan</div>
                        </div>
                    </div>

                    <!-- Productivity Card -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="stats-card">
                            <div class="stats-icon icon-green">
                                <i class="bi bi-speedometer2"></i>
                            </div>
                            <div class="stats-number">
                                {{ $totalPengaduan > 0 ? number_format(($selesai / $totalPengaduan) * 100, 0) : 0 }}%
                            </div>
                            <div class="stats-label">Produktivitas</div>
                            <div class="stats-sublabel">{{ $menunggu }} Tugas Selesai</div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Akun Table -->
                <div class="table-card mb-4">
                    <div class="table-card-header d-flex justify-content-between align-items-center">
                        <h2 class="table-card-title">List Akun Terdaftar</h2>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#importUserModal"
                                style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                                <i class="bi bi-file-earmark-arrow-up me-2"></i>Import Excel
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahUserModal"
                                style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                                <i class="bi bi-plus-circle me-2"></i>Tambah User
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="modern-table table-compact table mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">NO</th>
                                    <th style="width: 20%;">NAMA</th>
                                    <th style="width: 130px;">NISN</th>
                                    <th style="width: 22%;">EMAIL</th>
                                    <th style="width: 120px;">ROLE</th>
                                    <th style="width: 140px;">PENGADUAN</th>
                                    <th style="width: 110px;">TERDAFTAR</th>
                                    <th style="width: 120px;">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $index => $userItem)
                                    <tr>
                                        <td>
                                            <span
                                                style="font-weight: 600; color: #64748b;">{{ $users->firstItem() + $index }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="member-avatar"
                                                    style="background: {{ ['#3b82f6', '#8b5cf6', '#ec4899', '#10b981', '#f59e0b'][rand(0, 4)] }}; width: 36px; height: 36px; font-size: 0.875rem;">
                                                    {{ strtoupper(substr($userItem->name, 0, 1)) }}
                                                </div>
                                                <div style="overflow: hidden;">
                                                    <div class="project-title"
                                                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $userItem->name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                style="color: #64748b; font-weight: 500;">{{ $userItem->nis ?? '-' }}</span>
                                        </td>
                                        <td>
                                            <span
                                                style="color: #64748b; font-size: 0.875rem; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $userItem->email }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($userItem->isAdmin())
                                                <span class="role-badge admin">
                                                    <i class="bi bi-shield-check"></i> Admin
                                                </span>
                                            @else
                                                <span class="role-badge user">
                                                    <i class="bi bi-person"></i> User
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($userItem->isAdmin())
                                                <span style="color: #a0aec0; font-size: 0.875rem; font-weight: 500;">
                                                    -
                                                </span>
                                            @else
                                                <span class="badge bg-primary"
                                                    style="font-size: 0.875rem; padding: 0.5rem 0.75rem;">
                                                    {{ $userItem->pengaduans_count }} Pengaduan
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="color: #64748b; font-size: 0.875rem;">
                                                {{ $userItem->created_at->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                @if (!$userItem->isAdmin())
                                                    <button type="button" class="btn btn-sm btn-warning"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUserModal{{ $userItem->id }}"
                                                        style="border-radius: 6px; padding: 0.375rem 0.75rem; font-weight: 600;">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <form action="{{ route('user.destroy', $userItem->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            style="border-radius: 6px; padding: 0.375rem 0.75rem; font-weight: 600;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-muted" style="font-size: 0.875rem;">-</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="bi bi-people" style="font-size: 3rem; color: #cbd5e0;"></i>
                                            <p class="text-muted mt-3 mb-0">Belum ada akun terdaftar</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="d-flex justify-content-between align-items-center px-4 py-3"
                            style="border-top: 1px solid #e2e8f0;">
                            <div class="text-muted" style="font-size: 0.875rem;">
                                Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari
                                {{ $users->total() }} data
                            </div>
                            <div>
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Active Projects Table -->
                <div class="table-card">
                    <div class="table-card-header">
                        <h2 class="table-card-title">Proyek Aktif</h2>
                    </div>
                    <div class="table-responsive">
                        <table class="modern-table table mb-0">
                            <thead>
                                <tr>
                                    <th>NAMA PROYEK</th>
                                    <th>LOKASI PROYEK</th>
                                    <th>PRIORITAS</th>
                                    <th>ANGGOTA</th>
                                    <th>PROGRES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentPengaduan->take(8) as $pengaduan)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="project-icon icon-blue">
                                                    <i
                                                        class="bi bi-{{ $pengaduan->kategori->nama == 'Fasilitas' ? 'building' : ($pengaduan->kategori->nama == 'Kebersihan' ? 'trash' : 'exclamation-triangle') }}"></i>
                                                </div>
                                                <div>
                                                    <div class="project-title">
                                                        {{ Str::limit($pengaduan->lokasi, 35) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="project-subtitle">
                                                {{ Str::limit($pengaduan->keterangan, 40) }}
                                            </div>
                                        </td>
                                        <td>
                                            @if ($pengaduan->status === 'Menunggu')
                                                <span class="badge-priority badge-high">Tinggi</span>
                                            @else
                                                <span class="badge-priority badge-medium">Sedang</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="member-avatars">
                                                @php
                                                    $colors = ['#3b82f6', '#8b5cf6', '#ec4899', '#10b981'];
                                                    $nameInitial = strtoupper(substr($pengaduan->user->name, 0, 1));
                                                @endphp
                                                <div class="member-avatar"
                                                    style="background: {{ $colors[array_rand($colors)] }}">
                                                    {{ $nameInitial }}
                                                </div>
                                                @if ($pengaduan->feedback->count() > 0)
                                                    <div class="member-avatar"
                                                        style="background: {{ $colors[array_rand($colors)] }}">
                                                        {{ strtoupper(substr($pengaduan->feedback->first()->user->name ?? 'A', 0, 1)) }}
                                                    </div>
                                                @endif
                                                @if ($pengaduan->feedback->count() > 1)
                                                    <div class="member-avatar member-avatar-more">
                                                        +{{ $pengaduan->feedback->count() - 1 }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="progress-text">
                                                    {{ $pengaduan->status === 'Selesai' ? '100' : ($pengaduan->status === 'Proses' ? '50' : '15') }}%
                                                </span>
                                                <div class="progress-bar-container" style="flex: 1;">
                                                    <div class="progress-bar-fill"
                                                        style="width: {{ $pengaduan->status === 'Selesai' ? '100%' : ($pengaduan->status === 'Proses' ? '50%' : '15%') }};
                                                               background: {{ $pengaduan->status === 'Selesai' ? '#10b981' : ($pengaduan->status === 'Proses' ? '#3b82f6' : '#8b5cf6') }};">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="bi bi-inbox" style="font-size: 3rem; color: #cbd5e0;"></i>
                                            <p class="text-muted mt-3 mb-0">Tidak ada proyek aktif</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 1.5rem;">
                    <h5 class="modal-title" id="tambahUserModalLabel" style="font-weight: 700; color: #1a202c;">
                        <i class="bi bi-person-plus-fill me-2" style="color: #3b82f6;"></i>Tambah User Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 1.5rem;">
                        <div class="mb-3">
                            <label for="name" class="form-label"
                                style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required
                                style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nis" class="form-label"
                                style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">NISN</label>
                            <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis"
                                name="nis" value="{{ old('nis') }}" required
                                style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                placeholder="Masukkan NISN">
                            @error('nis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" required
                                style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                placeholder="contoh@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"
                                style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required
                                style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label"
                                style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required
                                style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                placeholder="Ulangi password">
                        </div>
                        <input type="hidden" name="role" value="user">
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary"
                            style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                            <i class="bi bi-check-circle me-2"></i>Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import User -->
    <div class="modal fade" id="importUserModal" tabindex="-1" aria-labelledby="importUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
                <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 1.5rem; border: none;">
                        <h5 class="modal-title" id="importUserModalLabel" style="color: white; font-weight: 700;">
                            <i class="bi bi-file-earmark-arrow-up-fill me-2" style="color: white;"></i>Import Data Siswa
                            dari Excel
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 1.5rem;">
                        <div class="alert alert-info" style="border-radius: 8px;">
                            <h6 class="mb-2"><i class="bi bi-info-circle me-2"></i>Format Excel:</h6>
                            <ul class="mb-2 small">
                                <li>Kolom: <strong>Name</strong>, <strong>Email</strong>, <strong>NIS</strong>,
                                    <strong>Kelas</strong>, <strong>Password</strong>
                                </li>
                                <li>Row pertama adalah header</li>
                                <li>Jika kolom Password kosong, default: <code>12345678</code></li>
                            </ul>
                            <a href="{{ asset('template/template_import_siswa.csv') }}" class="btn btn-sm btn-primary"
                                download>
                                <i class="bi bi-download me-1"></i>Download Template
                            </a>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label"
                                style="font-weight: 600; color: #334155; font-size: 0.875rem;">
                                File Excel <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="file" class="form-control" id="file" name="file"
                                accept=".xlsx,.xls,.csv" required
                                style="border-radius: 8px; border: 2px solid #e2e8f0; padding: 0.75rem;">
                            <small class="text-muted">Format: .xlsx, .xls, .csv (Max: 2MB)</small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success"
                            style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                            <i class="bi bi-upload me-2"></i>Import Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User (loop for each user) -->
    @foreach ($users as $userItem)
        @if (!$userItem->isAdmin())
            <div class="modal fade" id="editUserModal{{ $userItem->id }}" tabindex="-1"
                aria-labelledby="editUserModalLabel{{ $userItem->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px; border: none;">
                        <div class="modal-header" style="border-bottom: 1px solid #e2e8f0; padding: 1.5rem;">
                            <h5 class="modal-title" id="editUserModalLabel{{ $userItem->id }}"
                                style="font-weight: 700; color: #1a202c;">
                                <i class="bi bi-pencil-square me-2" style="color: #f59e0b;"></i>Edit User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('user.update', $userItem->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body" style="padding: 1.5rem;">
                                <div class="mb-3">
                                    <label for="edit_name{{ $userItem->id }}" class="form-label"
                                        style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="edit_name{{ $userItem->id }}"
                                        name="name" value="{{ $userItem->name }}" required
                                        style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_nis{{ $userItem->id }}" class="form-label"
                                        style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">NISN</label>
                                    <input type="text" class="form-control" id="edit_nis{{ $userItem->id }}"
                                        name="nis" value="{{ $userItem->nis }}" required
                                        style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_email{{ $userItem->id }}" class="form-label"
                                        style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Email</label>
                                    <input type="email" class="form-control" id="edit_email{{ $userItem->id }}"
                                        name="email" value="{{ $userItem->email }}" required
                                        style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password{{ $userItem->id }}" class="form-label"
                                        style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Password Baru
                                        <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                                    <input type="password" class="form-control" id="edit_password{{ $userItem->id }}"
                                        name="password"
                                        style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                        placeholder="Minimal 8 karakter">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_password_confirmation{{ $userItem->id }}" class="form-label"
                                        style="font-weight: 600; color: #2d3748; font-size: 0.875rem;">Konfirmasi
                                        Password</label>
                                    <input type="password" class="form-control"
                                        id="edit_password_confirmation{{ $userItem->id }}" name="password_confirmation"
                                        style="border-radius: 8px; padding: 0.75rem; border: 1px solid #e2e8f0;"
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 1rem 1.5rem;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600;">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 8px; padding: 0.625rem 1.25rem; font-weight: 600; color: white;">
                                    <i class="bi bi-check-circle me-2"></i>Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection

@push('scripts')
    <script>
        // Auto open modal if there are validation errors
        @if ($errors->any())
            var tambahUserModal = new bootstrap.Modal(document.getElementById('tambahUserModal'));
            tambahUserModal.show();
        @endif
    </script>
@endpush
