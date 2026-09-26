@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-person-lines-fill me-1"></i> Detail Guru
                    </h3>
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($guru->foto && file_exists(public_path('storage/' . $guru->foto)))
                        <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_guru }}" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-secondary-subtle rounded-circle d-inline-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 120px; height: 120px;">
                            <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
                        </div>
                    @endif
                    <h4 class="mt-3 mb-0 fw-bold">{{ $guru->nama_guru }}</h4>
                    <span class="badge text-bg-primary fs-6 mt-1">{{ $guru->mapel }}</span>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%;" class="bg-body-tertiary">NIP</th>
                            <td>{{ $guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Mata Pelajaran</th>
                            <td>{{ $guru->mapel }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Ekstrakurikuler yang Dibina</th>
                            <td>
                                @if ($guru->ekstrakurikuler && $guru->ekstrakurikuler->count() > 0)
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($guru->ekstrakurikuler as $ekskul)
                                            <li><i class="bi bi-check2-circle text-success me-1"></i> <strong>{{ $ekskul->nama_ekskul }}</strong> ({{ $ekskul->jadwal_latihan }})</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Tidak membina ekstrakurikuler.</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Tanggal Ditambahkan</th>
                            <td>{{ $guru->created_at ? $guru->created_at->format('d F Y, H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <a href="{{ route('admin.guru.addEdit', Crypt::encrypt($guru->id)) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i> Edit Data Guru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
