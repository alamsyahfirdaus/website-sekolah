<!doctype html>
<html lang="id">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SMA INSTRUKTUR | @yield('title', 'Admin Panel')</title>

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />

    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <!-- AdminLTE v4 CSS -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}" />

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header / Navbar -->
        <nav class="app-header navbar navbar-expand bg-body shadow-sm">
            <div class="container-fluid">
                <!-- Sidebar Toggle -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="Toggle sidebar">
                            <i class="bi bi-list fs-4"></i>
                        </a>
                    </li>
                </ul>

                <!-- User Dropdown & Logout -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="{{ asset('img/user2-160x160.jpg') }}" class="user-image rounded-circle shadow" alt="User Image" />
                            <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->name ?? 'Administrator' }} ({{ Auth::user()->role ?? 'Admin' }})</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end shadow">
                            <li class="user-header text-bg-primary">
                                <img src="{{ asset('img/user2-160x160.jpg') }}" class="rounded-circle shadow" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name ?? 'Administrator' }}
                                    <span class="badge bg-warning text-dark d-inline-block mt-1">{{ Auth::user()->role ?? 'Admin' }}</span>
                                    <small class="d-block mt-1">{{ Auth::user()->email ?? 'admin@sekolah.sch.id' }}</small>
                                </p>
                            </li>
                            <li class="user-footer d-flex justify-content-between">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Dashboard</a>
                                <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar Navigation -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="{{ route('admin.dashboard') }}" class="brand-link">
                    <img src="{{ asset('img/smk-ypc.png') }}" alt="Logo" class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">SMA INSTRUKTUR</span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2" aria-label="Main navigation">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false" id="navigation">
                        <!-- 1. Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- 2. Profil Sekolah -->
                        <li class="nav-item">
                            <a href="{{ route('admin.profil-sekolah') }}" class="nav-link {{ request()->routeIs('admin.profil-sekolah*') || request()->routeIs('admin.profil*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building"></i>
                                <p>Profil Sekolah</p>
                            </a>
                        </li>

                        <!-- 3. Kelola Guru (Hanya Admin) -->
                        @if(Auth::check() && strcasecmp(Auth::user()->role, 'admin') === 0)
                        <li class="nav-item">
                            <a href="{{ route('admin.guru.index') }}" class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>Kelola Guru</p>
                            </a>
                        </li>

                        <!-- 4. Kelola Siswa (Hanya Admin) -->
                        <li class="nav-item">
                            <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-people-fill"></i>
                                <p>Kelola Siswa</p>
                            </a>
                        </li>
                        @endif

                        <!-- 5. Kelola Berita (Admin & Operator) -->
                        <li class="nav-item">
                            <a href="{{ route('admin.berita.index') }}" class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-newspaper"></i>
                                <p>Kelola Berita</p>
                            </a>
                        </li>

                        <!-- 6. Kelola Ekstrakurikuler (Admin & Operator) -->
                        <li class="nav-item">
                            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="nav-link {{ request()->routeIs('admin.ekstrakurikuler.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-trophy-fill"></i>
                                <p>Kelola Ekstrakurikuler</p>
                            </a>
                        </li>

                        <!-- 7. Kelola Galeri (Admin & Operator) -->
                        <li class="nav-item">
                            <a href="{{ route('admin.galeri.index') }}" class="nav-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-images"></i>
                                <p>Kelola Galeri</p>
                            </a>
                        </li>

                        <!-- 8. Kelola User (Hanya Admin) -->
                        @if(Auth::check() && strcasecmp(Auth::user()->role, 'admin') === 0)
                        <li class="nav-item">
                            <a href="{{ route('admin.user.index') }}" class="nav-link {{ request()->routeIs('admin.user.*') || request()->routeIs('admin.users*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-gear"></i>
                                <p>Kelola User</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            <!-- Header Judul Halaman -->
            <div class="app-content-header py-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0 fs-4 fw-bold">@yield('title')</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Isi Konten & Alert Flash Messages -->
            <div class="app-content">
                <div class="container-fluid">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="bi bi-exclamation-octagon-fill me-2"></i>Terdapat kesalahan pengisian data:</strong>
                            <ul class="mb-0 mt-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer">
            <div class="float-end d-none d-sm-inline">Versi 1.0</div>
            <strong>Copyright &copy; {{ date('Y') }} SMA INSTRUKTUR.</strong> Media Pembelajaran Siswa SMK.
        </footer>
    </div>

    <!-- Scripts: OverlayScrollbars, Popper, Bootstrap 5, AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/adminlte.js') }}"></script>

    <!-- jQuery 3.7.1 (Dibutuhkan oleh DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables Core & Bootstrap 5 Integration -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
