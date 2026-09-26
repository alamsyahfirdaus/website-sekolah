@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-images me-1"></i> Detail Dokumentasi Galeri</h5>
                <a href="{{ route('admin.galeri') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    @if ($galeri->kategori == 'Video' && $galeri->file && file_exists(public_path('storage/' . $galeri->file)))
                        <video controls class="w-100 rounded shadow-sm" style="max-height: 420px;">
                            <source src="{{ asset('storage/' . $galeri->file) }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video HTML5.
                        </video>
                    @elseif ($galeri->file && file_exists(public_path('storage/' . $galeri->file)))
                        <img src="{{ asset('storage/' . $galeri->file) }}" alt="{{ $galeri->judul }}" class="img-fluid rounded shadow-sm" style="max-height: 450px; width: 100%; object-fit: contain;">
                    @else
                        <div class="p-5 bg-light rounded text-muted">
                            <i class="bi bi-file-earmark-x fs-1 d-block mb-2"></i>
                            File media tidak ditemukan.
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">{{ $galeri->judul }}</h4>
                    <span class="badge {{ $galeri->kategori == 'Foto' ? 'text-bg-success' : 'text-bg-danger' }} fs-6">
                        <i class="bi {{ $galeri->kategori == 'Foto' ? 'bi-camera' : 'bi-camera-video' }} me-1"></i> {{ $galeri->kategori }}
                    </span>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%;" class="bg-body-tertiary">Tanggal Kegiatan</th>
                            <td>{{ date('d F Y', strtotime($galeri->tanggal)) }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Nama File</th>
                            <td><span class="badge text-bg-light border font-monospace">{{ $galeri->file }}</span></td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Keterangan</th>
                            <td style="white-space: pre-line;">{{ $galeri->keterangan ?? 'Tidak ada keterangan tambahan.' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('galeri.edit', $galeri->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit Galeri
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
