<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap.min.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">{{ $profilSekolah->nama_sekolah }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @php
                        $menu = [
                            'public.dashboard' => 'Beranda',
                            'public.profile' => 'Profil Sekolah',
                            'public.guru' => 'Guru',
                            'public.siswa' => 'Siswa',
                            'public.ekstrakurikuler' => 'Ekstrakurikuler',
                            'public.berita' => 'Berita',
                            'public.galeri' => 'Galeri',
                        ]
                    @endphp

                    @foreach ($menu as $route => $label)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs($route) ? 'active' : '' }}"
                                href="{{ route($route) }}">{{ $label }}</a>
                        </li>
                    @endforeach

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                  {{--   <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li> --}}
                </ul>
                {{-- <a class="btn btn-outline-success" href="{{ route('login') }}">Login</a> --}}
                {{-- <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form> --}}
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        @yield('content')
    </div>

    {{-- <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1"
                    aria-label="Bootstrap">
                    <svg class="bi" width="30" height="24" aria-hidden="true">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2025 Company, Inc</span>
            </div>
        </footer>
    </div> --}}
    <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
