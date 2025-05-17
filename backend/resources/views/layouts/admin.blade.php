<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- CSS Kustom -->
    <link rel="stylesheet" href="{{ asset('css/admin-content.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .profile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 8px 12px;
            border-radius: 50px;
        }
        .profile-link:hover {
            background-color: rgba(13, 110, 253, 0.1);
        }
        .profile-link .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }
        .profile-link .username {
            font-weight: 500;
            color: #212529;
        }
        .profile-link:hover .username {
            color: #0d6efd;
        }
        .profile-link .caret {
            transition: transform 0.3s ease;
        }
        .profile-link:hover .caret {
            transform: translateX(3px);
        }
    </style>
</head>
<body class="bodi">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="#" class="navbar-brand">Utopia</a>
        </div>
        <!-- Menu -->
        <ul class="nav flex-column p-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('jadwalPelajaran.index') ? 'active' : '' }}" href="{{ route('jadwalPelajaran.index') }}">
                    <i class="fas fa-calendar-alt me-2"></i> Jadwal Pelajaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('detailPresensi.index') ? 'active' : '' }}" href="{{ route('detailPresensi.index') }}">
                    <i class="fas fa-user-check me-1"></i> Presensi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('jadwal_bel.index') ? 'active' : '' }}" href="{{ route('jadwal_bel.index') }}">
                    <i class="fas fa-bell me-2"></i> Bel
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <i class="fas fa-users me-2"></i> Daftar Wajah
                </a>
            </li>
            <li class="nav-item logout">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto w-100">
                        <li class="nav-item search-container">
                            <form class="d-flex w-100">
                                <input class="form-control search-input" type="search" placeholder="Cari...">
                            </form>
                        </li>
                        <li class="nav-item icons-container">
                            <div class="d-flex align-items-center gap-3">
                                <a class="nav-link position-relative" href="#">
                                    <i class="fas fa-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"></span>
                                </a>
                                <a class="nav-link position-relative" href="#">
                                    <i class="fas fa-envelope"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary"></span>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="profile-link">
                                    <span class="username">{{ Auth::user()->nama }}</span>
                                    <i class="fas fa-caret-right caret"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin-content.js') }}"></script>
</body>
</html>