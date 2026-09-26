@extends('app')

@section('title', $title)

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <a href="{{ route('berita.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Berita
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('admin.berita') }}" method="GET" class="d-flex" style="max-width: 320px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari judul berita..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-search"></i>
            </button>
            @if (request('search'))
                <a href="{{ route('admin.berita') }}" class="btn btn-outline-danger btn-sm" title="Reset">
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
                    <th style="width: 100px;" class="text-center">Gambar</th>
                    <th>Judul Berita</th>
                    <th>Tanggal</th>
                    <th>Penulis</th>
                    <th style="width: 220px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($beritas as $index => $berita)
                    <tr>
                        <td class="text-center">{{ $beritas->firstItem() + $index }}</td>
                        <td class="text-center">
                            @if ($berita->gambar && file_exists(public_path('storage/' . $berita->gambar)))
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="rounded shadow-sm" style="width: 65px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded d-inline-flex align-items-center justify-content-center text-secondary" style="width: 65px; height: 45px;">
                                    <i class="bi bi-image fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $berita->judul }}</div>
                            <small class="text-muted">{{ Str::limit(strip_tags($berita->isi), 60) }}</small>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">
                                <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y', strtotime($berita->tanggal)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary border">
                                <i class="bi bi-person me-1"></i> {{ $berita->user->name ?? 'Admin' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('berita.show', $berita->id) }}" class="btn btn-info btn-sm text-white" title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-warning btn-sm" title="Edit Berita">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Berita">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">
                            <i class="bi bi-newspaper fs-1 d-block mb-2"></i>
                            Belum ada berita yang dipublikasikan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($beritas->hasPages())
        <div class="card-footer clearfix bg-body">
            {{ $beritas->links() }}
        </div>
    @endif
</div>
@endsection
