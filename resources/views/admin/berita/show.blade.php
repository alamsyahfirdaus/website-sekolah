@extends('layouts.app')

@section('title', 'Detail Berita')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-newspaper me-1"></i> Detail Berita
                    </h3>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <h3 class="fw-bold text-dark mb-2">{{ $berita->judul }}</h3>
                <div class="d-flex flex-wrap gap-2 text-muted small mb-4 pb-2 border-bottom">
                    <span><i class="bi bi-calendar3 me-1"></i> {{ date('d F Y', strtotime($berita->tanggal)) }}</span>
                    <span>&bull;</span>
                    <span><i class="bi bi-person me-1"></i> Penulis: <strong>{{ $berita->user->name ?? 'Admin' }}</strong></span>
                </div>

                @if ($berita->gambar && file_exists(public_path('storage/' . $berita->gambar)))
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="img-fluid rounded shadow-sm" style="max-height: 380px; width: 100%; object-fit: cover;">
                    </div>
                @endif

                <div class="fs-6" style="white-space: pre-line; line-height: 1.8;">
                    {{ $berita->isi }}
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <a href="{{ route('admin.berita.addEdit', Crypt::encrypt($berita->id)) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Edit Berita
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
