@extends('layouts.app')

@section('title', 'Guru')

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    {{-- Header card: judul di kiri, tombol tambah di kanan --}}
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h3 class="card-title mb-0">
                Daftar Guru
            </h3>

            <a href="{{ route('admin.guru.addEdit') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Guru
            </a>
        </div>
    </div>

    <div class="card-body">
        <table id="tableGuru" class="table table-bordered table-striped table-hover align-middle responsive nowrap" width="100%">
            <thead class="table-light">
                <tr>
                    <th class="text-center" data-priority="1" style="width: 40px;">No</th>
                    <th class="text-center" data-priority="2" style="width: 60px;">Foto</th>
                    <th data-priority="3">NIP</th>
                    <th data-priority="1">Nama Guru</th>
                    <th data-priority="2">Mata Pelajaran</th>
                    <th class="text-center" data-priority="1" style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guru as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if ($item->foto && file_exists(public_path('storage/' . $item->foto)))
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_guru }}" class="rounded-circle shadow-sm" style="width: 38px; height: 38px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded-circle d-inline-flex align-items-center justify-content-center text-secondary" style="width: 38px; height: 38px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->nip ?? '-' }}</td>
                        <td class="fw-semibold">{{ $item->nama_guru }}</td>
                        <td><span class="badge text-bg-info">{{ $item->mapel }}</span></td>
                        <td class="text-center">
                            <div class="btn-aksi-group" role="group">
                                <a href="{{ route('admin.guru.show', Crypt::encrypt($item->id)) }}" class="btn btn-info btn-sm text-white" title="Detail Guru" aria-label="Detail">
                                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline ms-1">Detail</span>
                                </a>
                                <a href="{{ route('admin.guru.addEdit', Crypt::encrypt($item->id)) }}" class="btn btn-warning btn-sm" title="Edit Guru" aria-label="Edit">
                                    <i class="bi bi-pencil-square"></i> <span class="d-none d-md-inline ms-1">Edit</span>
                                </a>
                                <form action="{{ route('admin.guru.delete', Crypt::encrypt($item->id)) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus Guru" aria-label="Hapus">
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
{{-- 
@push('scripts')
<script>
    $(document).ready(function () {
        $('#tableGuru').DataTable({
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
@endpush --}}
