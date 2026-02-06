<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Alat')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #1e1e2d;
            --sidebar-color: #9899ac;
            --sidebar-active-bg: #2b2b40;
            --sidebar-active-color: #ffffff;
            --primary-color: #4f46e5;
            --bg-body: #f5f8fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            overflow-x: hidden;
        }

        /* Wrapper Layout */
        #wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Sidebar Styling */
        #sidebar-wrapper {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: #fff;
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-heading {
            padding: 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .list-group-item {
            padding: 0.85rem 1.5rem;
            background-color: transparent;
            color: var(--sidebar-color);
            border: none;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .list-group-item:hover {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
        }

        /* Active State Logic (bisa disesuaikan dengan Route) */
        .list-group-item.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-color);
            border-left: 4px solid var(--primary-color);
        }

        .list-group-item i {
            font-size: 1.1rem;
        }

        .sidebar-subheading {
            padding: 1rem 1.5rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #5d5f75;
            font-weight: 700;
        }

        /* Page Content Wrapper */
        #page-content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            width: calc(100% - var(--sidebar-width));
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        /* Top Navbar Styling */
        .top-navbar {
            background: #fff;
            padding: 1rem 2rem;
            box-shadow: 0 2px 15px rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .content-container {
            padding: 2rem;
            flex: 1;
        }

        /* Cards & Components */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            background: #fff;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: var(--primary-color);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
            border: none;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }

            #page-content-wrapper {
                margin-left: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: 0;
            }
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>

    @stack('styles')
</head>
<body>

    <div class="d-flex" id="wrapper">

        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-primary">
                <i class="bi bi-tools text-white"></i> <span style="color: #fff;">Inventaris<span class="text-primary">Alat</span></span>
            </div>

            <div class="list-group list-group-flush mt-3">
                <div class="sidebar-subheading">Menu Utama</div>

                <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>

                @if(auth()->user()->role === 'user')
                    <div class="sidebar-subheading">Peminjaman</div>
                    <a href="{{ route('peminjaman.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i> Riwayat Saya
                    </a>
                @endif

                @if(auth()->user()->role === 'admin')
                    <div class="sidebar-subheading">Administrator</div>
                    <a href="{{ route('admin.alat.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i> Kelola Alat
                    </a>
                    <a href="{{ route('admin.peminjaman.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-check"></i> Data Peminjaman
                    </a>
                @endif

                <div class="mt-auto mb-4">
                    <div class="sidebar-subheading">Akun</div>
                     <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit" class="list-group-item list-group-item-action text-danger" style="width: 100%; text-align: left;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div id="page-content-wrapper">

            <nav class="top-navbar">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light border-0 shadow-sm me-3" id="menu-toggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <h5 class="m-0 fw-bold text-secondary">@yield('page-title', 'Dashboard')</h5>
                </div>

                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="d-none d-md-block fw-medium">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><h6 class="dropdown-header">Login sebagai {{ ucfirst(auth()->user()->role) }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <div class="content-container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                            <div>{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <footer class="text-center py-4 text-muted small mt-auto">
                &copy; {{ date('Y') }} Sistem Peminjaman Alat. All rights reserved.
            </footer>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>

    @stack('scripts')
</body>
</html>
