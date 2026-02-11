@extends('layouts.app')

@section('title', 'Kelola Kategori')

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
            padding: 2.5rem 2rem 7rem;
            margin-bottom: -3.5rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        .table-card-body {
            background: white;
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

        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
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

        .custom-table thead th.text-center {
            text-align: center;
        }

        .custom-table tbody td {
            padding: 1.25rem 2rem;
            vertical-align: middle;
            border-top: 1px solid #e2e8f0;
            color: #2d3748;
        }

        .custom-table tbody td.text-center {
            text-align: center;
        }

        .custom-table tbody tr:hover {
            background-color: #f7fafc;
            transition: background-color 0.2s ease;
        }

        .project-name {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .project-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: transform 0.2s ease;
        }

        .custom-table tbody tr:hover .project-icon {
            transform: scale(1.05);
        }

        .project-title {
            font-weight: 600;
            color: #2d3748;
            font-size: 15px;
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
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
        }

        .modal-content {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

                <a href="{{ route('pengaduan.index') }}" class="menu-item">
                    <i class="bi bi-briefcase"></i>
                    <span>Semua Pengaduan</span>
                </a>

                <a href="{{ route('kategori.index') }}" class="menu-item active">
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
                        <span class="role-badge admin">Admin</span>
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
                <h1 class="dashboard-title">Kelola Kategori</h1>
                <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </button>
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

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"
                        style="border-radius: 12px; border: none; margin-bottom: 1.5rem;">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Kategori Table -->
                <div class="table-card">
                    <div class="table-card-header">
                        <h2 class="table-card-title">
                            <i class="bi bi-list-ul"></i> Daftar Kategori
                        </h2>
                    </div>
                    <div class="table-card-body">
                        @if ($kategoris->count() > 0)
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th width="8%">#</th>
                                        <th>Nama Kategori</th>
                                        <th width="18%" class="text-center">Jumlah Pengaduan</th>
                                        <th width="18%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kategoris as $index => $kategori)
                                        @php
                                            $colors = [
                                                ['bg' => '#e8f5e9', 'text' => '#388e3c'],
                                                ['bg' => '#e3f2fd', 'text' => '#1976d2'],
                                                ['bg' => '#fff3e0', 'text' => '#f57c00'],
                                                ['bg' => '#f3e5f5', 'text' => '#7b1fa2'],
                                                ['bg' => '#ffebee', 'text' => '#c62828'],
                                                ['bg' => '#e0f2f1', 'text' => '#00796b'],
                                            ];
                                            $colorIndex = $index % count($colors);
                                            $color = $colors[$colorIndex];
                                        @endphp
                                        <tr>
                                            <td><strong style="color: #718096;">{{ $index + 1 }}</strong></td>
                                            <td>
                                                <div class="project-name">
                                                    <div class="project-icon"
                                                        style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                                        <i class="bi bi-folder-fill"></i>
                                                    </div>
                                                    <div>
                                                        <div class="project-title">{{ $kategori->nama }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if ($kategori->pengaduan_count > 0)
                                                    <span class="badge-priority badge-info">
                                                        <i class="bi bi-file-earmark-text-fill"></i>
                                                        {{ $kategori->pengaduan_count }}
                                                    </span>
                                                @else
                                                    <span class="badge-priority badge-low">
                                                        <i class="bi bi-dash-circle"></i> Kosong
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    style="border-radius: 6px; padding: 6px 12px; margin-right: 4px;"
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $kategori->id }}"
                                                    title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                @if ($kategori->pengaduan_count > 0)
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        style="border-radius: 6px; padding: 6px 12px;"
                                                        title="Tidak dapat dihapus (masih ada pengaduan)" disabled>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @else
                                                    <form action="{{ route('kategori.destroy', $kategori) }}"
                                                        method="POST" style="display: inline-block;"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori &quot;{{ $kategori->nama }}&quot;?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            style="border-radius: 6px; padding: 6px 12px;" title="Hapus">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Edit Modal for Each Category -->
                                        <div class="modal fade" id="editModal{{ $kategori->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content" style="border-radius: 16px; border: none;">
                                                    <form action="{{ route('kategori.update', $kategori) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header"
                                                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 16px 16px 0 0;">
                                                            <h5 class="modal-title text-white">
                                                                <i class="bi bi-pencil-fill"></i> Edit Kategori
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body" style="padding: 30px;">
                                                            <div class="mb-3">
                                                                <label class="form-label"
                                                                    style="color: #4a5568; font-weight: 500;">
                                                                    Nama Kategori <span class="text-danger">*</span>
                                                                </label>
                                                                <input type="text" class="form-control" name="nama"
                                                                    value="{{ $kategori->nama }}" required
                                                                    style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal"
                                                                style="border-radius: 8px; padding: 10px 20px;">
                                                                <i class="bi bi-x-circle"></i> Batal
                                                            </button>
                                                            <button type="submit" class="btn btn-warning"
                                                                style="border-radius: 8px; padding: 10px 20px;">
                                                                <i class="bi bi-save"></i> Update
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div style="text-align: center; padding: 60px 20px;">
                                <i class="bi bi-folder-x" style="font-size: 3rem; color: #cbd5e0;"></i>
                                <p style="color: #a0aec0; margin-top: 15px; font-size: 16px;">Belum ada kategori</p>
                                <button type="button" class="btn-create" style="margin-top: 15px;"
                                    data-bs-toggle="modal" data-bs-target="#addModal">
                                    <i class="bi bi-plus-lg"></i> Tambah Kategori Pertama
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none;">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title text-white" id="addModalLabel">
                            <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 30px;">
                        <div class="mb-3">
                            <label for="nama" class="form-label" style="color: #4a5568; font-weight: 500;">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                name="nama" value="{{ old('nama') }}" placeholder="Contoh: Fasilitas Rusak"
                                required style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px 15px;">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border-radius: 8px; padding: 10px 20px;">
                            <i class="bi bi-x-circle"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary" style="border-radius: 8px; padding: 10px 20px;">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
