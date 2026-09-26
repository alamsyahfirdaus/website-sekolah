@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="card card-outline card-primary shadow-sm mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0">Daftar Pengguna Sistem</h5>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus me-1"></i> Tambah User
        </a>
    </div>

    <div class="card-body">
        <table id="tableUser" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;" class="text-center">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th style="width: 130px;" class="text-center">Role</th>
                    <th style="width: 200px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-semibold">{{ $item->name }}</div>
                            <small class="text-muted">Username: {{ $item->username ?? '-' }}</small>
                        </td>
                        <td>{{ $item->email }}</td>
                        <td class="text-center">
                            @if (strcasecmp($item->role, 'admin') === 0)
                                <span class="badge bg-primary">
                                    <i class="bi bi-shield-check me-1"></i> Admin
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="bi bi-person me-1"></i> Operator
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.user.show', $item->id) }}" class="btn btn-info btn-sm text-white" title="Detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                            <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            @if ($item->id !== auth()->id())
                                <form action="{{ route('admin.user.delete', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled title="Akun yang sedang login tidak dapat dihapus">
                                    <i class="bi bi-lock"></i>
                                </button>
                            @endif
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
        $('#tableUser').DataTable({
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
