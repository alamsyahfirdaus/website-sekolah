@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-1"></i> Detail Guru</h5>
                <a href="{{ route('admin.guru') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($guru->foto && file_exists(public_path('storage/' . $guru->foto)))
                        <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_guru }}" class="rounded-circle shadow" style="width: 130px; height: 130px; object-fit: cover;">
                    @else
                        <div class="bg-secondary-subtle rounded-circle d-inline-flex align-items-center justify-content-center text-secondary shadow-sm" style="width: 130px; height: 130px;">
                            <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <h4 class="mt-3 mb-0 fw-bold">{{ $guru->nama_guru }}</h4>
                    <span class="badge text-bg-primary fs-6 mt-1">{{ $guru->mapel }}</span>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 35%;" class="bg-body-tertiary">NIP</th>
                            <td>{{ $guru->nip ?? 'Tidak ada NIP' }}</td>
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

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data Guru
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
