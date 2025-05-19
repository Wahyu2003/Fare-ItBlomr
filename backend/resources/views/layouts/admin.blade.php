<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin-content.css') }}">
    <style>
        /* Override tata letak navbar untuk mode desktop */
        @media (min-width: 770px) {
            .navbar-top {
                justify-content: space-between;
            }

            .search-container {
                width: 300px; /* Lebar search pada desktop */
                flex-grow: 0;
            }

            .icons-container {
                margin-left: auto; /* Pindahkan ikon ke kanan */
            }

            .navbar-toggler {
                display: none; /* Sembunyikan toggle button pada desktop */
            }
        }
    </style>
</head>
<body class="bodi">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <a href="#" class="navbar-brand">Utopia</a>
        </div>
        <ul class="nav flex-column p-3">
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('jadwalPelajaran.index') ? 'active' : '' }}" href="{{ route('jadwalPelajaran.index') }}">
                    <i class="fas fa-calendar-alt me-2"></i> Jadwal Pelajaran
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('detailPresensi.index') ? 'active' : '' }}" href="{{ route('detailPresensi.index') }}">
                    <i class="fas fa-user-check me-1"></i> Presensi
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('jadwal_bel.index') ? 'active' : '' }}" href="{{ route('jadwal_bel.index') }}">
                    <i class="fas fa-bell me-2"></i> Bel
                </a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <i class="fas fa-users me-2"></i> Daftar Wajah
                </a>
            </li>
            <li class="nav-item mb-2 logout">
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
    <div class="main-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
            <div class="container-fluid">
                <div class="navbar-top">
                    <div class="navbar-left">
                        <button class="navbar-toggler" type="button" onclick="toggleSidebarAndNavbar()" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="search-container">
                            <form class="d-flex">
                                <input class="form-control search-input me-2" type="search" placeholder="Cari...">
                            </form>
                        </div>
                    </div>
                    <div class="navbar-right icons-container">
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
    <script>
        function toggleSidebarAndNavbar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.overlay');
            const mainContainer = document.querySelector('.main-container');

            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            mainContainer.classList.toggle('dimmed');  // ini bagian baru

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
