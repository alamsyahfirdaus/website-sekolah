<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use App\Http\Requests\StoreProfilSekolahRequest;
use App\Http\Requests\UpdateProfilSekolahRequest;

class ProfilSekolahController extends Controller
{
    public function index()
    {
        $profilSekolah = ProfilSekolah::first();

        $data = [
            'title' => 'Profil Sekolah',
            'profilSekolah' => $profilSekolah
        ];

        return view('admin.profil', $data);
    }

    public function edit($id)
    {
        $profilSekolah = ProfilSekolah::findOrFail($id);

        $data = [
            'title'         => 'Edit Profil Sekolah',
            'profilSekolah' => $profilSekolah
        ];

        return view('admin.profil-edit', $data);
    }

    public function update(UpdateProfilSekolahRequest $request, $id)
    {
        echo "Update Profil Sekolah dengan ID: " . $id;

        // $profilSekolah = ProfilSekolah::findOrFail($id);

        // $validatedData = $request->validated();

        // if ($request->hasFile('logo')) {
        //     // Hapus logo lama jika ada
        //     if ($profilSekolah->logo && file_exists(public_path('storage/' . $profilSekolah->logo))) {
        //         unlink(public_path('storage/' . $profilSekolah->logo));
        //     }

        //     // Simpan logo baru
        //     $validatedData['logo'] = $request->file('logo')->store('logos', 'public');
        // }

        // $profilSekolah->update($validatedData);

        // return redirect()->route('admin.profil')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
