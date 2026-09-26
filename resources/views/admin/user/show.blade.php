@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-outline card-info shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><i class="bi bi-person-lines-fill me-1"></i> Detail Data Pengguna</h5>
                <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary-subtle text-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
                    </div>
                    <h4 class="mt-3 mb-0 fw-bold">{{ $user->name }}</h4>
                    <span class="badge {{ strcasecmp($user->role, 'admin') === 0 ? 'bg-primary' : 'bg-secondary' }} fs-6 mt-1">
                        {{ $user->role }}
                    </span>
                </div>

                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 35%;" class="bg-body-tertiary">Nama Lengkap</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Username</th>
                            <td><code>{{ $user->username ?? '-' }}</code></td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Alamat Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Role / Hak Akses</th>
                            <td>
                                @if (strcasecmp($user->role, 'admin') === 0)
                                    <span class="badge bg-primary">Admin (Akses Penuh Seluruh Sistem)</span>
                                @else
                                    <span class="badge bg-secondary">Operator (Akses Operasional Sekolah)</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-body-tertiary">Tanggal Terdaftar</th>
                            <td>{{ $user->created_at ? $user->created_at->format('d F Y, H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data User
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
