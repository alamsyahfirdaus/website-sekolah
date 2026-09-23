@extends('admin_app')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body text-center">
                @if ($profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo)))
                    <img src="{{ asset('storage/' . $profilSekolah->logo) }}" alt="Logo Sekolah" class="img-fluid mb-3" style="max-width: 150px;">
                @else
                    <img src="{{ asset('img/smk-ypc.png') }}" alt="Logo Sekolah" class="img-fluid mb-3" style="max-width: 150px;">
                @endif
                <ul class="list-group list-group-flush text-start small">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Nama Sekolah</span>
                        <span class="fw-semibold">{{ $profilSekolah->nama_sekolah }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">Kepala Sekolah</span>
                        <span class="fw-semibold">{{ $profilSekolah->kepala_sekolah }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary">NPSN</span>
                        <span class="fw-semibold">{{ $profilSekolah->npsn }}</span>
                    </li>
                </ul>
                <a href="{{ route('profil.edit', $profilSekolah->id) }}" class="btn btn-primary w-100 mt-3">
                    <i class="bi bi-pencil-square me-1" aria-hidden="true"></i>
                    Edit Profil Sekolah
                </a>
            </div>
        </div>
    </div>
@endsection
