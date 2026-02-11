<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Pengaduan') }} - @yield('title')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --primary-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            padding: 20px 0;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 0 20px 30px;
            font-size: 24px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu-header {
            padding: 20px 20px 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
        }

        .sidebar-menu-item {
            margin: 5px 15px;
        }

        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .sidebar-menu-link:hover,
        .sidebar-menu-link.active {
            background: var(--sidebar-hover);
            color: white;
        }

        .sidebar-menu-link i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Top Header */
        .top-header {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 10px 15px;
            width: 350px;
            font-size: 14px;
        }

        .search-box input:focus {
            outline: none;
            border-color: #11998e;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            font-size: 20px;
            color: #666;
            cursor: pointer;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f44336;
            color: white;
            font-size: 10px;
            padding: 2px 5px;
            border-radius: 10px;
        }

        .user-profile {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            position: relative;
        }

        .user-avatar::after {
            content: '';
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #4caf50;
            border: 2px solid white;
            border-radius: 50%;
        }

        /* User Profile & Dropdown */
        .user-profile {
            position: relative;
        }

        .user-dropdown {
            min-width: 240px !important;
            padding: 12px 0 !important;
            border: none !important;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
            border-radius: 12px !important;
            margin-top: 8px !important;
        }

        .user-dropdown-header {
            padding: 15px 20px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 8px;
        }

        .user-dropdown-name {
            font-weight: 600;
            color: #2d3748;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .user-dropdown-email {
            font-size: 12px;
            color: #718096;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px !important;
            color: #4a5568;
            font-size: 14px;
        }

        .user-dropdown-item:hover {
            background: #f7fafc !important;
            color: #2d3748;
        }

        .user-dropdown-item i {
            font-size: 16px;
            width: 20px;
        }

        .user-dropdown-item.logout {
            color: #e53e3e !important;
        }

        .user-dropdown-item.logout:hover {
            background: #fff5f5 !important;
            color: #c53030 !important;
        }

        /* Content Area */
        .content-area {
            background: var(--primary-gradient);
            padding: 40px 30px;
            min-height: calc(100vh - 70px);
        }

        .content-header {
            margin-bottom: 30px;
        }

        .content-title {
            font-size: 32px;
            font-weight: 600;
            color: white;
            margin-bottom: 5px;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            flex-shrink: 0;
        }

        .stat-icon.purple {
            background: rgba(102, 126, 234, 0.15);
            color: #667eea;
        }

        .stat-icon.blue {
            background: rgba(66, 153, 225, 0.15);
            color: #4299e1;
        }

        .stat-icon.pink {
            background: rgba(237, 100, 166, 0.15);
            color: #ed64a6;
        }

        .stat-icon.green {
            background: rgba(72, 187, 120, 0.15);
            color: #48bb78;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 5px;
        }

        .stat-sublabel {
            font-size: 12px;
            color: #a0aec0;
        }

        /* Table Card */
        .table-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table-card-header {
            padding: 25px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-card-title {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
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

        .table-card-body {
            padding: 0;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table thead th {
            padding: 15px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
            color: #718096;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
        }

        .custom-table tbody td {
            padding: 20px;
            border-bottom: 1px solid #f7fafc;
        }

        .custom-table tbody tr:hover {
            background: #f7fafc;
        }

        .project-name {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .project-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .project-title {
            font-weight: 600;
            color: #2d3748;
        }

        .badge-priority {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .badge-high {
            background: #fed7d7;
            color: #c53030;
        }

        .badge-medium {
            background: #feebc8;
            color: #c05621;
        }

        .badge-low {
            background: #c6f6d5;
            color: #22543d;
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
        }

        .member-avatar:first-child {
            margin-left: 0;
        }

        .member-more {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e2e8f0;
            border: 2px solid white;
            margin-left: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 600;
            color: #4a5568;
        }

        .progress-bar-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .progress-bar-wrapper {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #11998e 0%, #38ef7d 100%);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .progress-text {
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
            min-width: 40px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .search-box input {
                width: 200px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-ui-checks-grid"></i> {{ auth()->user()->isAdmin() ? 'Admin Dashboard' : 'Dashboard Siswa' }}
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-menu-item">
                <a href="{{ route('dashboard') }}"
                    class="sidebar-menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
        </ul>

        @if (auth()->user()->isAdmin())
            <div class="sidebar-menu-header">Management</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('pengaduan.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pengaduan.*') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-data"></i>
                        <span>Semua Pengaduan</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('kategori.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="bi bi-folder"></i>
                        <span>Kelola Kategori</span>
                    </a>
                </li>
            </ul>
        @else
            <div class="sidebar-menu-header">Pengaduan</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('pengaduan.create') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pengaduan.create') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle"></i>
                        <span>Buat Pengaduan</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('pengaduan.index') }}"
                        class="sidebar-menu-link {{ request()->routeIs('pengaduan.index') || request()->routeIs('pengaduan.show') ? 'active' : '' }}">
                        <i class="bi bi-list-ul"></i>
                        <span>Pengaduan Saya</span>
                    </a>
                </li>
            </ul>
        @endif
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <div class="top-header">
            <div class="header-left">
                <div class="search-box">
                    <input type="text" placeholder="Search">
                </div>
            </div>
            <div class="header-right">
                <div class="dropdown">
                    <div class="user-profile" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end user-dropdown">
                        <div class="user-dropdown-header">
                            <div class="user-dropdown-name">{{ auth()->user()->name }}</div>
                            <div class="user-dropdown-email">{{ auth()->user()->email }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item user-dropdown-item logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    @stack('scripts')
</body>

</html>
