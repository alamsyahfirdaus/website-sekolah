@extends('layouts.app')

@section('title', 'Kelola Ekstrakurikuler')

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Ekstrakurikuler Sekolah</h5>
        <a href="{{ route('admin.ekstrakurikuler.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Ekstrakurikuler
        </a>
    </div>

    <div class="card-body">
        <table id="tableEkstrakurikuler" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th style="width: 80px;" class="text-center">Gambar</th>
                    <th>Nama Ekstrakurikuler</th>
                    <th>Guru Pembina</th>
                    <th>Jadwal Latihan</th>
                    <th style="width: 200px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ekstrakurikuler as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if ($item->gambar && file_exists(public_path('storage/' . $item->gambar)))
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_ekskul }}" class="rounded shadow-sm" style="width: 60px; height: 45px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded d-inline-flex align-items-center justify-content-center text-secondary" style="width: 60px; height: 45px;">
                                    <i class="bi bi-trophy fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $item->nama_ekskul }}</td>
                        <td>
                            <span class="badge text-bg-secondary">
                                <i class="bi bi-person-badge me-1"></i> {{ $item->guru->nama_guru ?? 'Belum ditentukan' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">
                                <i class="bi bi-clock me-1"></i> {{ $item->jadwal_latihan }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.ekstrakurikuler.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.ekstrakurikuler.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.ekstrakurikuler.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini?')">
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
        $('#tableEkstrakurikuler').DataTable({
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
