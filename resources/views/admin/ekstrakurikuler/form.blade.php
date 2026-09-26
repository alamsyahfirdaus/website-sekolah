@extends('layouts.app')

@section('title', isset($ekstrakurikuler) ? 'Edit Ekstrakurikuler' : 'Tambah Ekstrakurikuler')

@section('content')
<div class="row">
    {{-- Form dibuat full width (col-12) agar leluasa dan rapi --}}
    <div class="col-12">
        <div class="card {{ isset($ekstrakurikuler) ? 'card-warning' : 'card-primary' }} card-outline shadow-sm mb-4">
            {{-- Header card: judul form di sebelah kiri --}}
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="bi {{ isset($ekstrakurikuler) ? 'bi-pencil-square' : 'bi-plus-lg' }} me-1"></i>
                    {{ isset($ekstrakurikuler) ? 'Form Edit Data Ekstrakurikuler' : 'Form Tambah Ekstrakurikuler Baru' }}
                </h3>
            </div>

            <form action="{{ route('admin.ekstrakurikuler.save', isset($ekstrakurikuler) ? Crypt::encrypt($ekstrakurikuler->id) : null) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <!-- Nama Ekskul -->
                    <div class="mb-3">
                        <label for="nama_ekskul" class="form-label fw-semibold">Nama Ekstrakurikuler <span class="text-danger">*</span></label>
                        <input type="text" maxlength="40" class="form-control @error('nama_ekskul') is-invalid @enderror" id="nama_ekskul" name="nama_ekskul" value="{{ old('nama_ekskul', $ekstrakurikuler->nama_ekskul ?? '') }}" placeholder="Contoh: Pramuka, Futsal, Paskibra" required>
                        @error('nama_ekskul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Guru Pembina -->
                    <div class="mb-3">
                        <label for="id_guru" class="form-label fw-semibold">Guru Pembina <span class="text-danger">*</span></label>
                        <select class="form-select @error('id_guru') is-invalid @enderror" id="id_guru" name="id_guru" required>
                            <option value="">-- Pilih Guru Pembina --</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id }}" {{ old('id_guru', $ekstrakurikuler->id_guru ?? '') == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama_guru }} ({{ $g->mapel }})
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
                        <input type="text" maxlength="40" class="form-control @error('jadwal_latihan') is-invalid @enderror" id="jadwal_latihan" name="jadwal_latihan" value="{{ old('jadwal_latihan', $ekstrakurikuler->jadwal_latihan ?? '') }}" placeholder="Contoh: Jumat, 15.00 - 17.00 WIB" required>
                        @error('jadwal_latihan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label fw-semibold">Deskripsi Kegiatan</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan tujuan dan aktivitas kegiatan ekskul ini...">{{ old('deskripsi', $ekstrakurikuler->deskripsi ?? '') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto / Gambar -->
                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold">{{ isset($ekstrakurikuler) ? 'Ganti Gambar Kegiatan' : 'Foto / Gambar Kegiatan' }}</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG (Maks: 2MB). {{ isset($ekstrakurikuler) ? 'Biarkan kosong jika tidak diubah.' : '' }}</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if (isset($ekstrakurikuler) && $ekstrakurikuler->gambar && file_exists(public_path('storage/' . $ekstrakurikuler->gambar)))
                            <div class="mt-2">
                                <small class="text-secondary d-block">Gambar saat ini:</small>
                                <img src="{{ asset('storage/' . $ekstrakurikuler->gambar) }}" alt="{{ $ekstrakurikuler->nama_ekskul }}" class="rounded shadow-sm mt-1" style="height: 80px; object-fit: cover;">
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer card: tombol kembali di kiri, tombol simpan di kanan --}}
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn {{ isset($ekstrakurikuler) ? 'btn-warning' : 'btn-primary' }}">
                            <i class="bi bi-save me-1"></i> {{ isset($ekstrakurikuler) ? 'Simpan Perubahan' : 'Simpan Data Ekskul' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
