@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-primary card-outline shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-person-plus me-1"></i> Form Tambah Guru Baru</h5>
            </div>

            <form action="{{ route('guru.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <!-- Nama Guru -->
                    <div class="mb-3">
                        <label for="nama_guru" class="form-label fw-semibold">Nama Lengkap Guru & Gelar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru') }}" placeholder="Contoh: Ahmad Fauzi, S.Kom." required>
                        @error('nama_guru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div class="mb-3">
                        <label for="nip" class="form-label fw-semibold">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip') }}" placeholder="Contoh: 198501152010011 (Boleh dikosongkan)">
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mata Pelajaran -->
                    <div class="mb-3">
                        <label for="mapel" class="form-label fw-semibold">Mata Pelajaran yang Diampu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mapel') is-invalid @enderror" id="mapel" name="mapel" value="{{ old('mapel') }}" placeholder="Contoh: Pemrograman Web / Informatika" required>
                        @error('mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto Guru -->
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">Foto Guru</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format yang didukung: JPG, JPEG, PNG (Maksimal: 2MB).</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.guru') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Data Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
