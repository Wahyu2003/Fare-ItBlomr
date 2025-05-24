<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>
        @if (auth()->user()->role === 'admin')
            Dashboard Admin
        @elseif (auth()->user()->role === 'guru')
            Dashboard Guru
        @else
            Dashboard
        @endif
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin-content.css') }}">
</head>
<body class="bodi">
    <!-- Dragbar (garis panjang di kiri) -->
    <div class="sidebar-dragbar d-md-none" id="sidebarDragbar">
        <div class="dragbar-line"></div>
    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-menu d-flex flex-column justify-content-between h-100">
            <ul class="nav flex-column p-3 pt-4">
                <div class="sidebar-logo mb-3">
                    <a href="#" class="navbar-brand fs-4 fw-bold text-primary">Utopia</a>
                </div>
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs(Auth::user()->role . '.dashboard') ? 'active' : '' }}"
                        href="{{ route(Auth::user()->role . '.dashboard') }}">
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
                @if (Auth::user()->role === 'admin')
                    <li class="nav-item mb-2">
                        <a class="nav-link {{ request()->routeIs('jadwal_bel.index') ? 'active' : '' }}"
                            href="{{ route('jadwal_bel.index') }}">
                            <i class="fas fa-bell me-2"></i> Bel
                        </a>
                    </li>
                @endif
                <li class="nav-item mb-2">
                    <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}">
                        <i class="fas fa-users me-2"></i> Daftar Wajah
                    </a>
                </li>
            </ul>
            <ul class="nav flex-column p-3 pb-4">
                <li class="nav-item mb-2">
                    <a href="{{ route('profile.edit') }}" class="profile-link d-flex align-items-center">
                        <div class="">
                            @if(Auth::user() && Auth::user()->foto && file_exists(public_path('storage/profile_images/' . Auth::user()->foto)))
                                <img src="{{ asset('storage/profile_images/' . Auth::user()->foto) }}"
                                    alt="Foto Profil" class="rounded-circle"
                                    style="width: 32px; height: 32px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                    style="width: 32px; height: 32px;">
                                    <i class="fas fa-user text-secondary" style="font-size: 1.3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <span class="username fw-semibold">{{ Auth::user()->nama ?? '' }}</span>
                        <i class="fas fa-caret-right caret ms-auto"></i>
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
    </div>
    <div class="overlay"></div>
    <!-- Main Content -->
    <div class="main-container">
        <div class="content">
            @yield('content')
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/admin-content.js') }}"></script>
    <script>
    // Sidebar gesture & dragbar
    let touchStartX = 0;
    let touchEndX = 0;

    // Swipe gesture
    document.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    document.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        // Swipe from left to right
        if (touchStartX < 50 && touchEndX - touchStartX > 60) {
            document.querySelector('.sidebar').classList.add('active');
            document.querySelector('.overlay').classList.add('active');
            document.querySelector('.main-container').classList.add('dimmed');
        }
        // Swipe from right to left (close)
        if (touchStartX > 200 && touchStartX - touchEndX > 60) {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.overlay').classList.remove('active');
            document.querySelector('.main-container').classList.remove('dimmed');
        }
    }, false);

    // Klik dragbar untuk buka sidebar
    document.getElementById('sidebarDragbar').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.add('active');
        document.querySelector('.overlay').classList.add('active');
        document.querySelector('.main-container').classList.add('dimmed');
    });

    // Klik overlay untuk tutup sidebar
    document.querySelector('.overlay').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.remove('active');
        document.querySelector('.overlay').classList.remove('active');
        document.querySelector('.main-container').classList.remove('dimmed');
    });
    // Tambahkan setelah event klik dragbar & overlay
    function hideDragbarOnSidebar(state) {
        const dragbar = document.getElementById('sidebarDragbar');
        if (state) {
            dragbar.style.display = 'none';
        } else {
            dragbar.style.display = 'flex';
        }
    }

    // Saat sidebar dibuka
    document.getElementById('sidebarDragbar').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.add('active');
        document.querySelector('.overlay').classList.add('active');
        document.querySelector('.main-container').classList.add('dimmed');
        hideDragbarOnSidebar(true);
    });

    // Saat sidebar ditutup
    document.querySelector('.overlay').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.remove('active');
        document.querySelector('.overlay').classList.remove('active');
        document.querySelector('.main-container').classList.remove('dimmed');
        hideDragbarOnSidebar(false);
    });
    </script>
</body>
</html>