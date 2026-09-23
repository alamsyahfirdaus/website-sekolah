@extends('admin_app')

@section('title', $title)

@section('content')
    <div class="container">
        <div class="card card-primary card-outline mb-4">
                <form action="{{ route('profil.update', $profilSekolah->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="nama_sekolah" class="form-label">Nama Sekolah</label>
                            <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="{{ $profilSekolah->nama_sekolah }}" placeholder="Nama Sekolah" autocomplete="off" />
                        </div>
                        <div class="mb-3">
                            <label for="npsn" class="form-label">NPSN</label>
                            <input type="text" class="form-control" id="npsn" name="npsn" value="{{ $profilSekolah->npsn }}" placeholder="NPSN" autocomplete="off" />
                        </div>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="inputGroupFile02" />
                            <label class="input-group-text" for="inputGroupFile02">Upload</label>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
    </div>
@endsection
