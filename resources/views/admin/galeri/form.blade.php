@extends('layouts.app')

@section('title', isset($galeri) ? 'Edit Galeri' : 'Tambah Galeri')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card {{ isset($galeri) ? 'card-warning' : 'card-primary' }} card-outline shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi {{ isset($galeri) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-1"></i>
                    {{ isset($galeri) ? 'Form Edit Dokumentasi Galeri' : 'Form Tambah Dokumentasi Galeri' }}
                </h5>
            </div>

            @if(isset($galeri))
                <form action="{{ route('admin.galeri.save', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @else
                <form action="{{ route('admin.galeri.save') }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="card-body">
                    <!-- Judul Galeri -->
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold">Judul Kegiatan / Dokumentasi <span class="text-danger">*</span></label>
                        <input type="text" maxlength="50" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul', $galeri->judul ?? '') }}" placeholder="Maksimal 50 karakter" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Kategori -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-semibold">Kategori Media <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="Foto" {{ old('kategori', $galeri->kategori ?? 'Foto') == 'Foto' ? 'selected' : '' }}>Foto (Gambar)</option>
                                <option value="Video" {{ old('kategori', $galeri->kategori ?? '') == 'Video' ? 'selected' : '' }}>Video</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Kegiatan -->
                        <div class="col-md-6 mb-3">
                            <label for="tanggal" class="form-label fw-semibold">Tanggal Dokumentasi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', isset($galeri) ? $galeri->tanggal : date('Y-m-d')) }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Upload File -->
                    <div class="mb-3">
                        <label for="file" class="form-label fw-semibold">
                            {{ isset($galeri) ? 'Ganti File Dokumentasi (Foto/Video)' : 'File Dokumentasi (Foto/Video)' }}
                            @if(!isset($galeri)) <span class="text-danger">*</span> @endif
                        </label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept="image/*,video/mp4" {{ !isset($galeri) ? 'required' : '' }}>
                        <small class="text-muted">Mendukung format: JPG, JPEG, PNG, MP4 (Maksimal: 10MB). {{ isset($galeri) ? 'Biarkan kosong jika tidak diubah.' : '' }}</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (isset($galeri) && $galeri->file && file_exists(public_path('storage/' . $galeri->file)))
                            <div class="mt-2">
                                <small class="text-secondary d-block">File saat ini:</small>
                                @if ($galeri->kategori == 'Video')
                                    <div class="badge text-bg-dark p-2 mt-1">
                                        <i class="bi bi-play-circle-fill me-1"></i> {{ $galeri->file }}
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $galeri->file) }}" alt="{{ $galeri->judul }}" class="rounded shadow-sm mt-1" style="height: 80px; object-fit: cover;">
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan / Deskripsi Dokumentasi</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3" placeholder="Tuliskan keterangan singkat kegiatan...">{{ old('keterangan', $galeri->keterangan ?? '') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn {{ isset($galeri) ? 'btn-warning' : 'btn-primary' }}">
                        <i class="bi bi-save me-1"></i> {{ isset($galeri) ? 'Simpan Perubahan' : 'Unggah Dokumentasi' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
