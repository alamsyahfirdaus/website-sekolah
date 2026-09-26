@extends('app')

@section('title', $title)

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <a href="{{ route('galeri.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Galeri
        </a>

        <!-- Form Pencarian -->
        <form action="{{ route('admin.galeri') }}" method="GET" class="d-flex" style="max-width: 320px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari judul, kategori..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary btn-sm me-1">
                <i class="bi bi-search"></i>
            </button>
            @if (request('search'))
                <a href="{{ route('admin.galeri') }}" class="btn btn-outline-danger btn-sm" title="Reset">
                    <i class="bi bi-x-circle"></i>
                </a>
            @endif
        </form>
    </div>

    <div class="card-body">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @forelse ($galeris as $galeri)
                <div class="col">
                    <div class="card h-100 shadow-sm border">
                        <!-- Preview Media (Foto atau Video) -->
                        <div class="position-relative bg-light text-center" style="height: 180px; overflow: hidden;">
                            @if ($galeri->kategori == 'Video')
                                <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-dark text-white p-3">
                                    <i class="bi bi-play-circle-fill fs-1 text-danger mb-1"></i>
                                    <small class="text-truncate" style="max-width: 90%;">{{ $galeri->file }}</small>
                                </div>
                            @elseif ($galeri->file && file_exists(public_path('storage/' . $galeri->file)))
                                <img src="{{ asset('storage/' . $galeri->file) }}" alt="{{ $galeri->judul }}" class="w-100 h-100" style="object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100 text-secondary">
                                    <i class="bi bi-image fs-1"></i>
                                </div>
                            @endif

                            <span class="position-absolute top-0 start-0 m-2 badge {{ $galeri->kategori == 'Foto' ? 'text-bg-success' : 'text-bg-danger' }}">
                                <i class="bi {{ $galeri->kategori == 'Foto' ? 'bi-camera' : 'bi-camera-video' }} me-1"></i> {{ $galeri->kategori }}
                            </span>
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <h6 class="card-title fw-bold text-truncate mb-1" title="{{ $galeri->judul }}">{{ $galeri->judul }}</h6>
                            <p class="card-text text-muted small mb-2">
                                <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y', strtotime($galeri->tanggal)) }}
                            </p>
                            @if ($galeri->keterangan)
                                <p class="card-text text-secondary small text-truncate mb-3">{{ $galeri->keterangan }}</p>
                            @endif

                            <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                <a href="{{ route('galeri.show', $galeri->id) }}" class="btn btn-outline-info btn-sm" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('galeri.edit', $galeri->id) }}" class="btn btn-outline-warning btn-sm" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('galeri.destroy', $galeri->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-images fs-1 d-block mb-2"></i>
                    Belum ada dokumentasi galeri yang ditambahkan.
                </div>
            @endforelse
        </div>
    </div>

    @if ($galeris->hasPages())
        <div class="card-footer clearfix bg-body">
            {{ $galeris->links() }}
        </div>
    @endif
</div>
@endsection
