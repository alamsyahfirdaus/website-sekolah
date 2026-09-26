@extends('app')

@section('title', $title)

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <a href="{{ route('guru.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Guru
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('admin.guru') }}" method="GET" class="d-flex" style="max-width: 320px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari nama, NIP, mapel..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-search"></i>
            </button>
            @if (request('search'))
                <a href="{{ route('admin.guru') }}" class="btn btn-outline-danger btn-sm" title="Reset">
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
                    <th style="width: 80px;" class="text-center">Foto</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th style="width: 220px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($gurus as $index => $guru)
                    <tr>
                        <td class="text-center">{{ $gurus->firstItem() + $index }}</td>
                        <td class="text-center">
                            @if ($guru->foto && file_exists(public_path('storage/' . $guru->foto)))
                                <img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama_guru }}" class="rounded-circle shadow-sm" style="width: 45px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded-circle d-inline-flex align-items-center justify-content-center text-secondary" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $guru->nip ?? '-' }}</td>
                        <td class="fw-semibold">{{ $guru->nama_guru }}</td>
                        <td><span class="badge text-bg-info">{{ $guru->mapel }}</span></td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('guru.show', $guru->id) }}" class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('guru.destroy', $guru->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data guru ini?');">
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
                            Belum ada data guru yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($gurus->hasPages())
        <div class="card-footer clearfix bg-body">
            {{ $gurus->links() }}
        </div>
    @endif
</div>
@endsection
