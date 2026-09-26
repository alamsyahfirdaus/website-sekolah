@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Sambutan Dashboard -->
<div class="alert alert-light border shadow-sm d-flex align-items-center mb-4">
    <div class="fs-1 text-primary me-3">
        <i class="bi bi-mortarboard-fill"></i>
    </div>
    <div>
        <h5 class="alert-heading fw-bold mb-1">Selamat Datang di Panel Administrasi Website Sekolah!</h5>
        <p class="mb-0 text-secondary">
            Kelola seluruh informasi sekolah, tenaga pendidik, siswa, kegiatan, berita, dan galeri dengan mudah melalui antarmuka AdminLTE.
        </p>
    </div>
</div>

<!-- Baris Statistik Small Box AdminLTE -->
<div class="row">
    <!-- Box Guru -->
    <div class="col-xl-4 col-md-6 col-sm-6 mb-3">
        <div class="small-box text-bg-primary shadow-sm rounded-3">
            <div class="inner p-3">
                <h3 class="fw-bold">{{ $totalGuru }}</h3>
                <p class="fs-6 mb-0">Total Guru</p>
            </div>
            <i class="small-box-icon bi bi-person-badge"></i>
            <a href="{{ route('admin.guru.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover py-2 d-block text-center border-top border-white-50">
                Kelola Guru <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Box Siswa -->
    <div class="col-xl-4 col-md-6 col-sm-6 mb-3">
        <div class="small-box text-bg-success shadow-sm rounded-3">
            <div class="inner p-3">
                <h3 class="fw-bold">{{ $totalSiswa }}</h3>
                <p class="fs-6 mb-0">Total Siswa</p>
            </div>
            <i class="small-box-icon bi bi-people-fill"></i>
            <a href="{{ route('admin.siswa.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover py-2 d-block text-center border-top border-white-50">
                Kelola Siswa <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Box Berita -->
    <div class="col-xl-4 col-md-6 col-sm-6 mb-3">
        <div class="small-box text-bg-info text-white shadow-sm rounded-3">
            <div class="inner p-3">
                <h3 class="fw-bold">{{ $totalBerita }}</h3>
                <p class="fs-6 mb-0">Total Berita</p>
            </div>
            <i class="small-box-icon bi bi-newspaper"></i>
            <a href="{{ route('admin.berita.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover py-2 d-block text-center border-top border-white-50">
                Kelola Berita <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Box Ekstrakurikuler -->
    <div class="col-xl-6 col-md-6 col-sm-6 mb-3">
        <div class="small-box text-bg-warning shadow-sm rounded-3">
            <div class="inner p-3">
                <h3 class="fw-bold">{{ $totalEkstrakurikuler }}</h3>
                <p class="fs-6 mb-0">Total Ekstrakurikuler</p>
            </div>
            <i class="small-box-icon bi bi-trophy-fill"></i>
            <a href="{{ route('admin.ekstrakurikuler.index') }}" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover py-2 d-block text-center border-top border-dark-subtle">
                Kelola Ekstrakurikuler <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

    <!-- Box Galeri -->
    <div class="col-xl-6 col-md-6 col-sm-6 mb-3">
        <div class="small-box text-bg-danger shadow-sm rounded-3">
            <div class="inner p-3">
                <h3 class="fw-bold">{{ $totalGaleri }}</h3>
                <p class="fs-6 mb-0">Total Dokumentasi Galeri</p>
            </div>
            <i class="small-box-icon bi bi-images"></i>
            <a href="{{ route('admin.galeri.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover py-2 d-block text-center border-top border-white-50">
                Kelola Galeri <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Ringkasan Profil Sekolah -->
    <div class="col-lg-5 mb-4">
        <div class="card card-outline card-primary shadow-sm h-100">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-building me-1"></i> Profil Sekolah Singkat</h5>
            </div>
            <div class="card-body">
                @if ($profilSekolah)
                    <div class="d-flex align-items-center mb-3">
                        @if ($profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo)))
                            <img src="{{ asset('storage/' . $profilSekolah->logo) }}" alt="Logo" class="rounded shadow-sm me-3" style="max-height: 60px;">
                        @else
                            <img src="{{ asset('img/smk-ypc.png') }}" alt="Logo" class="rounded shadow-sm me-3" style="max-height: 60px;">
                        @endif
                        <div>
                            <h5 class="fw-bold mb-0">{{ $profilSekolah->nama_sekolah }}</h5>
                            <small class="text-muted">NPSN: {{ $profilSekolah->npsn }}</small>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush small mb-3">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Kepala Sekolah:</span>
                            <span class="fw-semibold">{{ $profilSekolah->kepala_sekolah }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Kontak:</span>
                            <span class="fw-semibold">{{ $profilSekolah->kontak }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span class="text-muted">Tahun Berdiri:</span>
                            <span class="fw-semibold">{{ $profilSekolah->tahun_berdiri }}</span>
                        </li>
                    </ul>
                    <a href="{{ route('admin.profil-sekolah') }}" class="btn btn-outline-primary btn-sm w-100">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profil Sekolah
                    </a>
                @else
                    <p class="text-muted mb-0">Data profil sekolah belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Berita Terbaru -->
    <div class="col-lg-7 mb-4">
        <div class="card card-outline card-info shadow-sm h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-newspaper me-1"></i> Berita & Artikel Terbaru</h5>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse ($beritaTerbaru as $b)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('admin.berita.show', $b->id) }}" class="fw-semibold text-decoration-none text-dark d-block">
                                    {{ $b->judul }}
                                </a>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y', strtotime($b->tanggal)) }} &bull;
                                    <i class="bi bi-person me-1"></i> {{ $b->user->name ?? 'Admin' }}
                                </small>
                            </div>
                            <a href="{{ route('admin.berita.show', $b->id) }}" class="btn btn-sm btn-light border">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            Belum ada berita yang dipublikasikan.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
