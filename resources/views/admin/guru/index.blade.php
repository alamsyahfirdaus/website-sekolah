@extends('layouts.app')

@section('title', 'Kelola Guru')

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Tenaga Pendidik / Guru</h5>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Guru
        </a>
    </div>

    <div class="card-body">
        <table id="tableGuru" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th style="width: 70px;" class="text-center">Foto</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Mata Pelajaran</th>
                    <th style="width: 200px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guru as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">
                            @if ($item->foto && file_exists(public_path('storage/' . $item->foto)))
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_guru }}" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-secondary-subtle rounded-circle d-inline-flex align-items-center justify-content-center text-secondary" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $item->nip ?? '-' }}</td>
                        <td class="fw-semibold">{{ $item->nama_guru }}</td>
                        <td><span class="badge text-bg-info">{{ $item->mapel }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('admin.guru.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.guru.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('admin.guru.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
        $('#tableGuru').DataTable({
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
