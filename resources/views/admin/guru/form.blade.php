@extends('layouts.app')

@section('title', isset($guru) ? 'Edit Guru' : 'Tambah Guru')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card {{ isset($guru) ? 'card-warning' : 'card-primary' }} card-outline shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi {{ isset($guru) ? 'bi-pencil-square' : 'bi-plus-circle' }} me-1"></i>
                    {{ isset($guru) ? 'Form Edit Data Guru' : 'Form Tambah Data Guru Baru' }}
                </h5>
            </div>

            @if(isset($guru))
                <form action="{{ route('admin.guru.save', $guru->id) }}" method="POST" enctype="multipart/form-data">
            @else
                <form action="{{ route('admin.guru.save') }}" method="POST" enctype="multipart/form-data">
            @endif
                @csrf

                <div class="card-body">
                    <!-- Nama Guru -->
                    <div class="mb-3">
                        <label for="nama_guru" class="form-label fw-semibold">Nama Lengkap Guru & Gelar <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" id="nama_guru" name="nama_guru" value="{{ old('nama_guru', $guru->nama_guru ?? '') }}" placeholder="Contoh: Ahmad Fauzi, S.Kom." required>
                        @error('nama_guru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIP -->
                    <div class="mb-3">
                        <label for="nip" class="form-label fw-semibold">NIP (Nomor Induk Pegawai)</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" value="{{ old('nip', $guru->nip ?? '') }}" placeholder="Contoh: 198501152010011 (Boleh kosong)">
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mata Pelajaran -->
                    <div class="mb-3">
                        <label for="mapel" class="form-label fw-semibold">Mata Pelajaran yang Diampu <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('mapel') is-invalid @enderror" id="mapel" name="mapel" value="{{ old('mapel', $guru->mapel ?? '') }}" placeholder="Contoh: Pemrograman Web / Informatika" required>
                        @error('mapel')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto Guru -->
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">Foto Guru</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG (Maks: 2MB). {{ isset($guru) ? 'Biarkan kosong jika tidak diubah.' : '' }}</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (isset($guru) && $guru->foto && file_exists(public_path('storage/' . $guru->foto)))
                            <div class="mt-2">
                                <small class="text-secondary d-block">Foto saat ini:</small>
                                <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_guru }}" class="rounded shadow-sm mt-1" style="height: 80px; width: 80px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn {{ isset($guru) ? 'btn-warning' : 'btn-primary' }}">
                        <i class="bi bi-save me-1"></i> {{ isset($guru) ? 'Simpan Perubahan' : 'Simpan Data Guru' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
