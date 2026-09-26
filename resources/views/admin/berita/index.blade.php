@extends('layouts.app')

@section('title', 'Kelola Berita')

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    {{-- Header card: judul di kiri, tombol tambah di kanan --}}
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="card-title mb-0">
                Daftar Berita
            </h3>

            <a href="{{ route('admin.berita.addEdit') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Berita
            </a>
        </div>
    </div>

    <div class="card-body">
        <table id="tableBerita" class="table table-bordered table-striped table-hover align-middle responsive nowrap" width="100%">
            <thead class="table-light">
                <tr>
                    <th class="text-center" data-priority="1" style="width: 40px;">No</th>
                    <th class="text-center" data-priority="2" style="width: 75px;">Gambar</th>
                    <th data-priority="1">Judul Berita</th>
                    <th data-priority="3">Tanggal</th>
                    <th data-priority="4">Penulis</th>
                    <th class="text-center" data-priority="1" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($berita as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if ($item->gambar && file_exists(public_path('storage/' . $item->gambar)))
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="rounded shadow-sm" style="width: 60px; height: 42px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded d-inline-flex align-items-center justify-content-center text-secondary" style="width: 60px; height: 42px;">
                                    <i class="bi bi-image fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $item->judul }}</div>
                            <small class="text-muted d-none d-lg-block">{{ Str::limit(strip_tags($item->isi), 60) }}</small>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">
                                <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y', strtotime($item->tanggal)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary border">
                                <i class="bi bi-person me-1"></i> {{ $item->user->name ?? 'Admin' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-aksi-group" role="group">
                                <a href="{{ route('admin.berita.show', Crypt::encrypt($item->id)) }}" class="btn btn-info btn-sm text-white" title="Detail Berita" aria-label="Detail">
                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Detail</span>
                                </a>
                                <a href="{{ route('admin.berita.addEdit', Crypt::encrypt($item->id)) }}" class="btn btn-warning btn-sm" title="Edit Berita" aria-label="Edit">
                                    <i class="bi bi-pencil-square"></i> <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <form action="{{ route('admin.berita.delete', Crypt::encrypt($item->id)) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Berita" aria-label="Hapus">
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

@push('scripts')
<script>
    $(document).ready(function () {
        $('#tableBerita').DataTable({
            responsive: true,
            autoWidth: false,
            language: {
                search: "Cari Data:",
                lengthMenu: "Tampilkan _MENU_ baris",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data yang ditampilkan",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Selanjutnya"
                }
            }
        });
    });
</script>
@endpush
