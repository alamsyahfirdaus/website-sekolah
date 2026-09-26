@extends('layouts.app')

@section('title', 'Profil Sekolah')

@section('content')
<div class="row">
    <!-- Kolom Kiri: Ringkasan & Preview Identitas -->
    <div class="col-lg-4 mb-4">
        <div class="card card-outline card-primary shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-info-circle me-1"></i> Identitas Sekolah</h5>
            </div>
            <div class="card-body text-center">
                @if ($profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo)))
                    <img src="{{ asset('storage/' . $profilSekolah->logo) }}" alt="Logo Sekolah" class="img-fluid rounded mb-3 shadow-sm p-2 bg-light" style="max-height: 120px; object-fit: contain;">
                @else
                    <img src="{{ asset('img/smk-ypc.png') }}" alt="Logo Sekolah" class="img-fluid rounded mb-3 shadow-sm p-2 bg-light" style="max-height: 120px; object-fit: contain;">
                @endif

                <h4 class="fw-bold mb-1">{{ $profilSekolah->nama_sekolah }}</h4>
                <p class="text-muted mb-3"><i class="bi bi-person-fill me-1"></i> {{ $profilSekolah->kepala_sekolah }}</p>

                <ul class="list-group list-group-flush text-start small">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary"><i class="bi bi-qr-code me-1"></i> NPSN:</span>
                        <span class="fw-semibold">{{ $profilSekolah->npsn }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary"><i class="bi bi-calendar-event me-1"></i> Tahun Berdiri:</span>
                        <span class="fw-semibold">{{ $profilSekolah->tahun_berdiri }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-secondary"><i class="bi bi-telephone-fill me-1"></i> Kontak:</span>
                        <span class="fw-semibold">{{ $profilSekolah->kontak }}</span>
                    </li>
                </ul>
            </div>
        </div>

        @if ($profilSekolah->foto && file_exists(public_path('storage/' . $profilSekolah->foto)))
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-body-tertiary">
                    <h6 class="card-title mb-0"><i class="bi bi-image me-1"></i> Gedung Sekolah</h6>
                </div>
                <div class="card-body p-2 text-center">
                    <img src="{{ asset('storage/' . $profilSekolah->foto) }}" alt="Gedung Sekolah" class="img-fluid rounded shadow-sm" style="max-height: 220px; width: 100%; object-fit: cover;">
                </div>
            </div>
        @endif
    </div>

    <!-- Kolom Kanan: Form Edit Profil Langsung -->
    <div class="col-lg-8">
        <div class="card card-outline card-secondary shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-1"></i> Form Pengaturan Profil Sekolah</h5>
            </div>

            <form action="{{ route('admin.profil-sekolah.save') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <!-- Nama Sekolah -->
                        <div class="col-md-6 mb-3">
                            <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" maxlength="40" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah', $profilSekolah->nama_sekolah) }}" required>
                            @error('nama_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Kepala Sekolah -->
                        <div class="col-md-6 mb-3">
                            <label for="kepala_sekolah" class="form-label fw-semibold">Nama Kepala Sekolah <span class="text-danger">*</span></label>
                            <input type="text" maxlength="40" class="form-control @error('kepala_sekolah') is-invalid @enderror" id="kepala_sekolah" name="kepala_sekolah" value="{{ old('kepala_sekolah', $profilSekolah->kepala_sekolah) }}" required>
                            @error('kepala_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- NPSN -->
                        <div class="col-md-4 mb-3">
                            <label for="npsn" class="form-label fw-semibold">NPSN <span class="text-danger">*</span></label>
                            <input type="text" maxlength="10" class="form-control @error('npsn') is-invalid @enderror" id="npsn" name="npsn" value="{{ old('npsn', $profilSekolah->npsn) }}" required>
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
                            <label for="kontak" class="form-label fw-semibold">No. Kontak / Telepon <span class="text-danger">*</span></label>
                            <input type="text" maxlength="15" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $profilSekolah->kontak) }}" required>
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span class="text-danger">*</span></label>
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
                        <!-- Upload Logo -->
                        <div class="col-md-6 mb-3">
                            <label for="logo" class="form-label fw-semibold">Ganti Logo Sekolah</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo" name="logo" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak diubah. Format JPG/PNG (Maks: 2MB).</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Upload Foto Gedung -->
                        <div class="col-md-6 mb-3">
                            <label for="foto" class="form-label fw-semibold">Ganti Foto Gedung Sekolah</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak diubah. Format JPG/PNG (Maks: 2MB).</small>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Profil Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
