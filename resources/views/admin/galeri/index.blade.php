@extends('layouts.app')

@section('title', 'Kelola Galeri')

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Dokumentasi Galeri Sekolah</h5>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Galeri
        </a>
    </div>

    <div class="card-body">
        <table id="tableGaleri" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th style="width: 90px;" class="text-center">Media</th>
                    <th>Judul Dokumentasi</th>
                    <th style="width: 110px;" class="text-center">Kategori</th>
                    <th style="width: 130px;">Tanggal</th>
                    <th style="width: 200px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($galeri as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if ($item->kategori == 'Video')
                                <div class="bg-dark text-white rounded d-inline-flex align-items-center justify-content-center" style="width: 65px; height: 45px;">
                                    <i class="bi bi-play-circle-fill fs-5 text-danger"></i>
                                </div>
                            @elseif ($item->file && file_exists(public_path('storage/' . $item->file)))
                                <img src="{{ asset('storage/' . $item->file) }}" alt="{{ $item->judul }}" class="rounded shadow-sm" style="width: 65px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded d-inline-flex align-items-center justify-content-center text-secondary" style="width: 65px; height: 45px;">
                                    <i class="bi bi-image fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $item->judul }}</div>
                            @if ($item->keterangan)
                                <small class="text-muted">{{ Str::limit($item->keterangan, 60) }}</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $item->kategori == 'Foto' ? 'text-bg-success' : 'text-bg-danger' }}">
                                <i class="bi {{ $item->kategori == 'Foto' ? 'bi-camera' : 'bi-camera-video' }} me-1"></i> {{ $item->kategori }}
                            </span>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">
                                <i class="bi bi-calendar3 me-1"></i> {{ date('d M Y', strtotime($item->tanggal)) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.galeri.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.galeri.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus galeri ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
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
        $('#tableGaleri').DataTable({
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
