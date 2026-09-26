@extends('app')

@section('title', $title)

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-warning card-outline shadow-sm mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="bi bi-pencil-square me-1"></i> Form Edit Ekstrakurikuler</h5>
            </div>

            <form action="{{ route('ekstrakurikuler.update', $ekskul->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <!-- Nama Ekskul -->
                    <div class="mb-3">
                        <label for="nama_ekskul" class="form-label fw-semibold">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                        <input type="text" maxlength="40" class="form-control @error('nama_ekskul') is-invalid @enderror" id="nama_ekskul" name="nama_ekskul" value="{{ old('nama_ekskul', $ekskul->nama_ekskul) }}" required>
                        @error('nama_ekskul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Guru Pembina -->
                    <div class="mb-3">
                        <label for="id_guru" class="form-label fw-semibold">Guru Pembina <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_guru') is-invalid @enderror" id="id_guru" name="id_guru" required>
                            <option value="">-- Pilih Guru Pembina --</option>
                            @foreach ($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ old('id_guru', $ekskul->id_guru) == $guru->id ? 'selected' : '' }}>
                                    {{ $guru->nama_guru }} ({{ $guru->mapel }})
                                </option>
                            @endforeach
                        </select>
                        @error('id_guru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jadwal Latihan -->
                    <div class="mb-3">
                        <label for="jadwal_latihan" class="form-label fw-semibold">Jadwal Latihan / Pertemuan <span class="text-danger">*</span></label>
                        <input type="text" maxlength="40" class="form-control @error('jadwal_latihan') is-invalid @enderror" id="jadwal_latihan" name="jadwal_latihan" value="{{ old('jadwal_latihan', $ekskul->jadwal_latihan) }}" required>
                        @error('jadwal_latihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Kegiatan</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $ekskul->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto / Gambar -->
                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold">Ganti Gambar Kegiatan</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($ekskul->gambar && file_exists(public_path('storage/' . $ekskul->gambar)))
                            <div class="mt-2">
                                <small class="text-secondary d-block">Gambar saat ini:</small>
                                <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="{{ $ekskul->nama_ekskul }}" class="rounded shadow-sm mt-1" style="height: 80px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('admin.ekstrakurikuler') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
