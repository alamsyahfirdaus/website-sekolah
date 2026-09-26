@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-person-badge-fill me-1"></i> Detail Data Siswa</h5>
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
                    </div>
                    <h4 class="mt-3 mb-0 fw-bold">{{ $siswa->nama_siswa }}</h4>
                    <span class="badge text-bg-secondary mt-1 font-monospace fs-6">NISN: {{ $siswa->nisn }}</span>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 35%;" class="bg-body-tertiary">NISN</th>
                            <td class="font-monospace fw-semibold">{{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Nama Lengkap</th>
                            <td>{{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Jenis Kelamin</th>
                            <td>
                                @if ($siswa->jenis_kelamin == 'Laki-Laki')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <i class="bi bi-gender-male me-1"></i> Laki-Laki
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        <i class="bi bi-gender-female me-1"></i> Perempuan
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Tahun Masuk / Angkatan</th>
                            <td>{{ $siswa->tahun_masuk }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Tanggal Terdaftar</th>
                            <td>{{ $siswa->created_at ? $siswa->created_at->format('d F Y, H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('admin.siswa.addEdit', $siswa->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data Siswa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
