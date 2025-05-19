<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/siswa-content.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bodi">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="#" class="navbar-brand">Utopia</a>
        </div>
        <ul class="nav flex-column p-3">
            <li class="nav-item m-1">
                <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item m-1">
                <a class="nav-link {{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}" href="{{ route('siswa.jadwal') }}">
                    <i class="fas fa-calendar-alt me-2"></i> Jadwal Pelajaran
                </a>
            </li>
            <li class="nav-item logout m-1">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="overlay"></div>

    <!-- Main Container -->
    <div class="main-container" id="main-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
            <div class="container-fluid">
                <div class="navbar-top">
                    <button class="navbar-toggler" type="button" onclick="toggleSidebarAndNavbar()" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="icons-container">
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
                            <i class="fas fa-caret-right caret mt-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="contents">
            @yield('contents')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebarAndNavbar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.overlay');
            const mainContainer = document.getElementById('main-container');

            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            mainContainer.classList.toggle('dimmed');

            const toggleButton = document.querySelector('.navbar-toggler');
            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
            toggleButton.setAttribute('aria-expanded', !isExpanded);
        }

        document.querySelector('.overlay').addEventListener('click', () => {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');
            const mainContainer = document.querySelector('.main-container');
            const toggleButton = document.querySelector('.navbar-toggler');

            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            mainContainer.classList.remove('dimmed');  // hapus kelas dimmed

            toggleButton.setAttribute('aria-expanded', 'false');
        });
    </script>
</body>
</html>
