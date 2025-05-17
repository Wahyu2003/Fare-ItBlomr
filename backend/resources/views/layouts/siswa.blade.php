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
    <div class="sidebar" id="sidebar">
        <!-- Logo -->
        <div class="sidebar-logo">
            <a href="#" class="navbar-brand">Utopia</a>
        </div>
        <!-- Menu -->
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

    <!-- Main Container -->
    <div class="main-container" id="main-container">
        <!-- Header -->
        <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" onclick="toggleSidebarAndNavbar()" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto w-100 align-items-center">
                        <li class="nav-item search-container flex-grow-1 me-3">
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
                                    <!-- <img src="{{ Auth::user()->foto ? asset('storage/profile_images/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->nama) . '&background=random' }}" 
                                        class="avatar" 
                                        alt="{{ Auth::user()->nama }}"> -->
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
        <div class="contents">
            @yield('contents')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Gunakan fungsi yang sama seperti di admin
        function toggleSidebarAndNavbar() {
            const sidebar = document.getElementById('sidebar');
            const navbarContent = document.getElementById('navbarContent');
            const mainContainer = document.getElementById('main-container');
            
            sidebar.classList.toggle('active');
            navbarContent.classList.toggle('show');
            mainContainer.classList.toggle('shifted');
            
            // Update aria-expanded
            const toggleButton = document.querySelector('.navbar-toggler');
            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
            toggleButton.setAttribute('aria-expanded', !isExpanded);
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const navbarContent = document.getElementById('navbarContent');
            const mainContainer = document.getElementById('main-container');
            const toggleButton = document.querySelector('.navbar-toggler');
            
            if (window.innerWidth <= 992) {
                if (!event.target.closest('#sidebar') && !event.target.closest('.navbar-toggler')) {
                    sidebar.classList.remove('active');
                    navbarContent.classList.remove('show');
                    mainContainer.classList.remove('shifted');
                    toggleButton.setAttribute('aria-expanded', 'false');
                }
            }
        });
    </script>
</body>
</html>