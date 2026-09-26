@extends('layouts.app')

@section('title', '403 Akses Ditolak')

@section('content')
<div class="row justify-content-center my-5">
    <div class="col-md-8 text-center">
        <div class="card card-outline card-warning shadow-sm py-4">
            <div class="card-body">
                <h1 class="display-1 fw-bold text-warning mb-2">403</h1>
                <h3 class="fw-bold mb-3">
                    <i class="bi bi-shield-lock-fill text-warning me-2"></i> Akses Ditolak
                </h3>
                <p class="text-secondary fs-6 mb-4">
                    {{ $exception->getMessage() ?: 'Anda tidak memiliki izin (hak akses) untuk membuka halaman ini.' }}
                </p>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-4">
                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
