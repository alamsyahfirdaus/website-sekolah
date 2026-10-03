@extends('layouts.app')

@section('title', 'Siswa')

@section('content')
    <div class="card card-outline card-primary shadow-sm mb-4">
        {{-- Header card: judul di kiri, tombol tambah di kanan --}}
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title mb-0">
                    Daftar Siswa
                </h3>

                <a href="{{ route('admin.siswa.addEdit') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
                </a>
            </div>
        </div>

        <div class="card-body">
            <table id="tableSiswa" class="table table-bordered table-striped table-hover align-middle responsive nowrap"
                width="100%">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" data-priority="1" style="width: 40px;">No</th>
                        <th data-priority="3">NISN</th>
                        <th data-priority="1">Nama Siswa</th>
                        <th data-priority="2">Jenis Kelamin</th>
                        <th data-priority="4">Tahun Masuk</th>
                        <th class="text-center" data-priority="1" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="badge text-bg-light border font-monospace">{{ $item->nisn }}</span></td>
                            <td class="fw-semibold">{{ $item->nama_siswa }}</td>
                            <td>
                                @if ($item->jenis_kelamin == 'Laki-Laki')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        <i class="bi bi-gender-male me-1"></i> Laki-Laki
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                        <i class="bi bi-gender-female me-1"></i> Perempuan
                                    </span>
                                @endif
                            </td>
                            <td>{{ $item->tahun_masuk }}</td>
                            <td class="text-center">
                                <div class="btn-aksi-group" role="group">
                                    <a href="{{ route('admin.siswa.show', Crypt::encrypt($item->id)) }}"
                                        class="btn btn-info btn-sm text-white" title="Detail Siswa" aria-label="Detail">
                                        <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Detail</span>
                                    </a>
                                    <a href="{{ route('admin.siswa.addEdit', Crypt::encrypt($item->id)) }}"
                                        class="btn btn-warning btn-sm" title="Edit Siswa" aria-label="Edit">
                                        <i class="bi bi-pencil-square"></i> <span
                                            class="d-none d-md-inline ms-1">Edit</span>
                                    </a>
                                    <form action="{{ route('admin.siswa.delete', Crypt::encrypt($item->id)) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Siswa"
                                            aria-label="Hapus">
                                            <i class="bi bi-trash"></i> <span class="d-none d-md-inline ms-1">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- @push('scripts')
    <script>
        $(document).ready(function() {
            $('#tableSiswa').DataTable();
        });
    </script>
@endpush --}}
