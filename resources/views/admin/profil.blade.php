@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-4 col-md-5">
        <!-- Card Logo & Info Singkat -->
        <div class="card card-primary card-outline mb-4">
            <div class="card-body text-center">
                @if ($profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo)))
                    <img src="{{ asset('storage/' . $profilSekolah->logo) }}" alt="Logo Sekolah" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 140px; object-fit: contain;">
                @else
                    <img src="{{ asset('img/smk-ypc.png') }}" alt="Logo Sekolah" class="img-fluid rounded mb-3 shadow-sm" style="max-height: 140px; object-fit: contain;">
                @endif
                <h4 class="fw-bold mb-1">{{ $profilSekolah->nama_sekolah }}</h4>
                <p class="text-muted mb-3"><i class="bi bi-person-fill me-1"></i> Kepala Sekolah: {{ $profilSekolah->kepala_sekolah }}</p>

                <ul class="list-group list-group-flush text-start small mb-3">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary"><i class="bi bi-qr-code me-1"></i> NPSN</span>
                        <span class="fw-semibold">{{ $profilSekolah->npsn }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary"><i class="bi bi-calendar-event me-1"></i> Tahun Berdiri</span>
                        <span class="fw-semibold">{{ $profilSekolah->tahun_berdiri }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary"><i class="bi bi-telephone-fill me-1"></i> Kontak</span>
                        <span class="fw-semibold">{{ $profilSekolah->kontak }}</span>
                    </li>
                </ul>

                <a href="{{ route('profil.edit', $profilSekolah->id) }}" class="btn btn-primary w-100">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil Sekolah
                </a>
            </div>
        </div>

        @if ($profilSekolah->foto && file_exists(public_path('storage/' . $profilSekolah->foto)))
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-body-tertiary">
                    <h6 class="card-title mb-0"><i class="bi bi-image me-1"></i> Foto Gedung Sekolah</h6>
                </div>
                <div class="card-body p-2 text-center">
                    <img src="{{ asset('storage/' . $profilSekolah->foto) }}" alt="Foto Gedung" class="img-fluid rounded shadow-sm">
                </div>
            </div>
        @endif
    </div>

    <div class="col-lg-8 col-md-7">
        <!-- Card Detail Profil Lengkap -->
        <div class="card card-outline card-secondary mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-info-circle me-1"></i> Informasi Lengkap Sekolah</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="fw-bold text-secondary d-block"><i class="bi bi-geo-alt-fill me-1 text-danger"></i> Alamat Sekolah</label>
                    <p class="mb-0 bg-light p-2 rounded border">{{ $profilSekolah->alamat }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-secondary d-block"><i class="bi bi-flag-fill me-1 text-primary"></i> Visi & Misi</label>
                    <div class="bg-light p-3 rounded border" style="white-space: pre-line;">{{ $profilSekolah->visi_misi }}</div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-secondary d-block"><i class="bi bi-card-text me-1 text-success"></i> Deskripsi / Sambutan Sekolah</label>
                    <p class="bg-light p-3 rounded border mb-0" style="white-space: pre-line;">{{ $profilSekolah->deskripsi ?? 'Belum ada deskripsi profil sekolah.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
