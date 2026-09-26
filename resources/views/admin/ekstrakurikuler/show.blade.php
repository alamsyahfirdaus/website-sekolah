@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-trophy-fill me-1"></i> Detail Ekstrakurikuler</h5>
                <a href="{{ route('admin.ekstrakurikuler') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                @if ($ekskul->gambar && file_exists(public_path('storage/' . $ekskul->gambar)))
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="{{ $ekskul->nama_ekskul }}" class="img-fluid rounded shadow-sm" style="max-height: 280px; width: 100%; object-fit: cover;">
                    </div>
                @endif

                <div class="text-center mb-3">
                    <h3 class="fw-bold text-dark mb-1">{{ $ekskul->nama_ekskul }}</h3>
                    <span class="badge text-bg-primary fs-6">
                        <i class="bi bi-clock me-1"></i> {{ $ekskul->jadwal_latihan }}
                    </span>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 35%;" class="bg-body-tertiary">Nama Ekstrakurikuler</th>
                            <td class="fw-semibold">{{ $ekskul->nama_ekskul }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Guru Pembina</th>
                            <td>
                                @if ($ekskul->guru)
                                    <strong>{{ $ekskul->guru->nama_guru }}</strong>
                                    <span class="text-muted small">({{ $ekskul->guru->mapel }})</span>
                                @else
                                    <span class="text-muted">Belum ditentukan</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Jadwal Pertemuan</th>
                            <td>{{ $ekskul->jadwal_latihan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Deskripsi Kegiatan</th>
                            <td style="white-space: pre-line;">{{ $ekskul->deskripsi ?? 'Belum ada deskripsi kegiatan.' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('ekstrakurikuler.edit', $ekskul->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data Ekskul
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
