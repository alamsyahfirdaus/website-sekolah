@extends('app')

@section('title', $title)

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <a href="{{ route('ekstrakurikuler.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Ekstrakurikuler
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('admin.ekstrakurikuler') }}" method="GET" class="d-flex" style="max-width: 320px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari ekskul, pembina..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-search"></i>
            </button>
            @if (request('search'))
                <a href="{{ route('admin.ekstrakurikuler') }}" class="btn btn-outline-danger btn-sm" title="Reset">
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
                    <th style="width: 90px;" class="text-center">Gambar</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Guru Pembina</th>
                    <th>Jadwal Latihan</th>
                    <th style="width: 220px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ekskuls as $index => $ekskul)
                    <tr>
                        <td class="text-center">{{ $ekskuls->firstItem() + $index }}</td>
                        <td class="text-center">
                            @if ($ekskul->gambar && file_exists(public_path('storage/' . $ekskul->gambar)))
                                <img src="{{ asset('storage/' . $ekskul->gambar) }}" alt="{{ $ekskul->nama_ekskul }}" class="rounded shadow-sm" style="width: 60px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded d-inline-flex align-items-center justify-content-center text-secondary" style="width: 60px; height: 45px;">
                                    <i class="bi bi-trophy fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $ekskul->nama_ekskul }}</td>
                        <td>
                            <span class="badge text-bg-secondary">
                                <i class="bi bi-person-badge me-1"></i> {{ $ekskul->guru->nama_guru ?? 'Belum ditentukan' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">
                                <i class="bi bi-clock me-1"></i> {{ $ekskul->jadwal_latihan }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('ekstrakurikuler.show', $ekskul->id) }}" class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('ekstrakurikuler.edit', $ekskul->id) }}" class="btn btn-warning btn-sm" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('ekstrakurikuler.destroy', $ekskul->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?');">
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
                            Belum ada data ekstrakurikuler yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($ekskuls->hasPages())
        <div class="card-footer clearfix bg-body">
            {{ $ekskuls->links() }}
        </div>
    @endif
</div>
@endsection
