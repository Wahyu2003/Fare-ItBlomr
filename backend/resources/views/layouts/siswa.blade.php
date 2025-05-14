<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS Kustom untuk Siswa -->
    <link rel="stylesheet" href="{{ asset('css/siswa-content.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bodi">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="#" class="navbar-brand">Utopia</a>
        </div>
        <!-- Menu -->
        <ul class="nav flex-column p-3">
            <li class="nav-item m-1">
                <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            </li>
            <li class="nav-item logout m-1">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Container (Header + Content) -->
    <div class="main-container" id="main-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item icons-container">
                            <div class="d-flex align-items-center">
                                <a class="nav-link me-3" href="#"><i class="fas fa-bell"></i></a>
                                <a class="nav-link me-3" href="#"><i class="fas fa-message"></i></a>
                                <div class="d-flex align-items-center">
                                    <div class="border-profil">
                                        <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('images/default.jpg') }}" class="profil" alt="Profil">
                                    </div>
                                    <span class="username">{{ Auth::user()->username }}</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="contents">
            @yield('contents')
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS Kustom untuk Siswa -->
    <script src="{{ asset('js/siswa-content.js') }}"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContainer = document.getElementById('main-container');
            sidebar.classList.toggle('active');
            mainContainer.classList.toggle('shifted');
        }
    </script>
</body>
</html>
