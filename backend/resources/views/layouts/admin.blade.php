<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS Kustom untuk Konten -->
    <link rel="stylesheet" href="{{ asset('css/admin-content.css') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('jadwalPelajaran.index') ? 'active' : '' }}" href="{{ route('jadwalPelajaran.index') }}"><i class="fas fa-calendar-alt me-2"></i> Jadwal Pelajaran</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('detailPresensi.index') ? 'active' : '' }}" href="{{ route('detailPresensi.index') }}"><i class="fas fa-user-check me-2"></i> Presensi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('jadwal_bel.index') ? 'active' : '' }}" href="{{ route('jadwal_bel.index') }}"><i class="fas fa-bell me-2"></i> Bel</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}"><i class="fas fa-users me-2"></i> Daftar Wajah</a>
            </li>
        </ul>
    </div>

    <!-- Main Container (Header + Content) -->
    <div class="main-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto w-100">
                        <!-- Kolom Pencarian (75%) -->
                        <li class="nav-item search-container">
                            <form class="d-flex w-100">
                                <input class="form-control search-input" type="search" placeholder="Cari..." aria-label="Cari">
                            </form>
                        </li>
                        <!-- Notifikasi, Pesan, dan Profil (25%) -->
                        <li class="nav-item icons-container">
                            <div class="d-flex align-items-center">
                                <a class="nav-link me-3" href="#"><i class="fas fa-bell"></i></a>
                                <a class="nav-link me-3" href="#"><i class="fas fa-message"></i></a>
                                <div class="d-flex align-items-center">
                                    <div class="profile-pic-wrapper border-profil">
                                        <img src="{{ asset('images/cindy.jpg') }}" class="profile-pic rounded-circle profil" alt="Profil">
                                    </div>
                                    <span class="text-black username">Niken Hildawati</span>
                                </div>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script><!-- JS Kustom untuk Konten -->
    <script src="{{ asset('js/admin-content.js') }}"></script>
</body>
</html>
