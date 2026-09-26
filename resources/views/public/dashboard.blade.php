<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $profilSekolah->nama_sekolah ?? 'Website Sekolah' }} | Selamat Datang</title>
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <!-- Navbar Sederhana -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ url('/') }}">
                @if ($profilSekolah && $profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo)))
                    <img src="{{ asset('storage/' . $profilSekolah->logo) }}" alt="Logo" style="height: 36px;">
                @else
                    <img src="{{ asset('img/smk-ypc.png') }}" alt="Logo" style="height: 36px;">
                @endif
                {{ $profilSekolah->nama_sekolah ?? 'Website Sekolah' }}
            </a>
            <div class="ms-auto">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-speedometer2 me-1"></i> Panel Admin
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" class="btn btn-light btn-sm fw-semibold">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login Admin
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="py-5 bg-white border-bottom shadow-sm text-center">
        <div class="container py-4">
            <h1 class="display-5 fw-bold text-dark mb-3">{{ $profilSekolah->nama_sekolah ?? 'Website Sekolah' }}</h1>
            <p class="lead text-muted col-lg-8 mx-auto mb-4">
                {{ $profilSekolah->deskripsi ?? 'Selamat datang di portal informasi resmi sekolah.' }}
            </p>
            <div class="d-flex justify-content-center gap-3">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-speedometer2 me-1"></i> Masuk ke Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" class="btn btn-primary px-4 py-2">
                        <i class="bi bi-lock-fill me-1"></i> Masuk Sebagai Administrator
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Info Sekolah Section -->
    @if ($profilSekolah)
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-primary fs-3 mb-2"><i class="bi bi-info-circle-fill"></i></div>
                        <h5 class="fw-bold">Tentang Sekolah</h5>
                        <p class="text-muted small mb-1"><strong>NPSN:</strong> {{ $profilSekolah->npsn }}</p>
                        <p class="text-muted small mb-1"><strong>Kepala Sekolah:</strong> {{ $profilSekolah->kepala_sekolah }}</p>
                        <p class="text-muted small mb-0"><strong>Tahun Berdiri:</strong> {{ $profilSekolah->tahun_berdiri }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-success fs-3 mb-2"><i class="bi bi-flag-fill"></i></div>
                        <h5 class="fw-bold">Visi & Misi</h5>
                        <p class="text-muted small mb-0" style="white-space: pre-line;">{{ Str::limit($profilSekolah->visi_misi, 180) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="text-danger fs-3 mb-2"><i class="bi bi-geo-alt-fill"></i></div>
                        <h5 class="fw-bold">Alamat & Kontak</h5>
                        <p class="text-muted small mb-1">{{ $profilSekolah->alamat }}</p>
                        <p class="text-muted small mb-0"><strong>Telp/WA:</strong> {{ $profilSekolah->kontak }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <footer class="py-4 bg-light text-center text-muted small border-top mt-5">
        &copy; {{ date('Y') }} {{ $profilSekolah->nama_sekolah ?? 'Website Sekolah' }}. Dikembangkan untuk Media Pembelajaran Siswa SMK.
    </footer>
</body>
</html>
