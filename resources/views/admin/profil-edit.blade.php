@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-1"></i> Form Edit Profil Sekolah</h5>
            </div>

            <form action="{{ route('profil.update', $profilSekolah->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="row">
                        <!-- Nama Sekolah -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $profilSekolah->nama_sekolah) }}" required>
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kepala Sekolah -->
                        <div class="col-md-6 mb-3">
                            <label for="kepala_sekolah" class="form-label fw-semibold">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kepala_sekolah') is-invalid @enderror" id="kepala_sekolah" name="kepala_sekolah" value="{{ old('kepala_sekolah', $profilSekolah->kepala_sekolah) }}" required>
                            @error('kepala_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- NPSN -->
                        <div class="col-md-4 mb-3">
                            <label for="npsn" class="form-label fw-semibold">NPSN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('npsn') is-invalid @enderror" id="npsn" name="npsn" value="{{ old('npsn', $profilSekolah->npsn) }}" required>
                            @error('npsn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun Berdiri -->
                        <div class="col-md-4 mb-3">
                            <label for="tahun_berdiri" class="form-label fw-semibold">Tahun Berdiri <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('tahun_berdiri') is-invalid @enderror" id="tahun_berdiri" name="tahun_berdiri" value="{{ old('tahun_berdiri', $profilSekolah->tahun_berdiri) }}" required>
                            @error('tahun_berdiri')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kontak -->
                        <div class="col-md-4 mb-3">
                            <label for="kontak" class="form-label fw-semibold">Nomor Telepon / Kontak <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $profilSekolah->kontak) }}" required>
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat Sekolah <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="2" required>{{ old('alamat', $profilSekolah->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Visi & Misi -->
                    <div class="mb-3">
                        <label for="visi_misi" class="form-label fw-semibold">Visi & Misi Sekolah <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('visi_misi') is-invalid @enderror" id="visi_misi" name="visi_misi" rows="4" required>{{ old('visi_misi', $profilSekolah->visi_misi) }}</textarea>
                        @error('visi_misi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi / Sambutan -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi / Sambutan Sekolah</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $profilSekolah->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Logo Sekolah -->
                        <div class="col-md-6 mb-3">
                            <label for="logo" class="form-label fw-semibold">Upload Logo Sekolah</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks: 2MB). Biarkan kosong jika tidak diubah.</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo)))
                                <div class="mt-2">
                                    <small class="d-block text-secondary">Logo Saat Ini:</small>
                                    <img src="{{ asset('storage/' . $profilSekolah->logo) }}" alt="Logo Saat Ini" class="img-thumbnail" style="max-height: 80px;">
                                </div>
                            @endif
                        </div>

                        <!-- Foto Gedung -->
                        <div class="col-md-6 mb-3">
                            <label for="foto" class="form-label fw-semibold">Upload Foto Gedung Sekolah</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks: 2MB). Biarkan kosong jika tidak diubah.</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($profilSekolah->foto && file_exists(public_path('storage/' . $profilSekolah->foto)))
                                <div class="mt-2">
                                    <small class="d-block text-secondary">Foto Gedung Saat Ini:</small>
                                    <img src="{{ asset('storage/' . $profilSekolah->foto) }}" alt="Foto Gedung Saat Ini" class="img-thumbnail" style="max-height: 80px;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.profil') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
