@extends('app')

@section('title', $title)

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <a href="{{ route('siswa.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Tambah Siswa
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('admin.siswa') }}" method="GET" class="d-flex" style="max-width: 320px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari nama, NISN, angkatan..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-search"></i>
            </button>
            @if (request('search'))
                <a href="{{ route('admin.siswa') }}" class="btn btn-outline-danger btn-sm" title="Reset">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Jenis Kelamin</th>
                    <th>Tahun Masuk</th>
                    <th style="width: 220px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($siswas as $index => $siswa)
                    <tr>
                        <td class="text-center">{{ $siswas->firstItem() + $index }}</td>
                        <td><span class="badge text-bg-light border font-monospace">{{ $siswa->nisn }}</span></td>
                        <td class="fw-semibold">{{ $siswa->nama_siswa }}</td>
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
                        <td>{{ $siswa->tahun_masuk }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Data">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Belum ada data siswa yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($siswas->hasPages())
        <div class="card-footer clearfix bg-body">
            {{ $siswas->links() }}
        </div>
    @endif
</div>
@endsection
