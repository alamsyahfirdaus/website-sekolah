@extends('layouts.app')

@section('title', isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card {{ isset($siswa) ? 'card-warning' : 'card-primary' }} card-outline shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi {{ isset($siswa) ? 'bi-pencil-square' : 'bi-person-plus' }} me-1"></i>
                    {{ isset($siswa) ? 'Form Edit Data Siswa' : 'Form Tambah Data Siswa Baru' }}
                </h5>
            </div>

            @if(isset($siswa))
                <form action="{{ route('admin.siswa.save', $siswa->id) }}" method="POST">
            @else
                <form action="{{ route('admin.siswa.save') }}" method="POST">
            @endif
            
                @csrf

                <div class="card-body">
                    <!-- NISN -->
                    <div class="mb-3">
                        <label for="nisn" class="form-label fw-semibold">NISN (10 Digit Angka) <span class="text-danger">*</span></label>
                        <input type="text" maxlength="10" class="form-control @error('nisn') is-invalid @enderror" id="nisn" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" placeholder="Contoh: 0071234567" required>
                        @error('nisn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Siswa -->
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label fw-semibold">Nama Lengkap Siswa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}" placeholder="Contoh: Muhammad Farhan" required>
                        @error('nama_siswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jk_l" value="Laki-Laki" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? 'Laki-Laki') == 'Laki-Laki' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="jk_l">
                                    <i class="bi bi-gender-male text-primary"></i> Laki-Laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jk_p" value="Perempuan" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'Perempuan' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="jk_p">
                                    <i class="bi bi-gender-female text-danger"></i> Perempuan
                                </label>
                            </div>
                        </div>
                        @error('jenis_kelamin')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tahun Masuk -->
                    <div class="mb-3">
                        <label for="tahun_masuk" class="form-label fw-semibold">Tahun Masuk / Angkatan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('tahun_masuk') is-invalid @enderror" id="tahun_masuk" name="tahun_masuk" value="{{ old('tahun_masuk', $siswa->tahun_masuk ?? date('Y')) }}" placeholder="Contoh: 2024" required>
                        @error('tahun_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn {{ isset($siswa) ? 'btn-warning' : 'btn-primary' }}">
                        <i class="bi bi-save me-1"></i> {{ isset($siswa) ? 'Simpan Perubahan' : 'Simpan Data Siswa' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
