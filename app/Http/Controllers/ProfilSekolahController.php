<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    /**
     * Menampilkan data profil sekolah.
     * Alur: Route -> ProfilSekolahController@index -> Model ProfilSekolah -> View admin.profil
     */
    public function index()
    {
        // Mengambil data profil sekolah pertama
        $profilSekolah = ProfilSekolah::first();

        // Jika belum ada data, buat data awal default
        if (!$profilSekolah) {
            $profilSekolah = ProfilSekolah::create([
                'nama_sekolah'   => 'SMA INSTRUKTUR',
                'kepala_sekolah' => 'Kepala Sekolah',
                'npsn'           => '12345678',
                'alamat'         => 'Jl. Pendidikan No. 1',
                'kontak'         => '08123456789',
                'visi_misi'      => 'Visi dan Misi Sekolah',
                'tahun_berdiri'  => date('Y'),
                'deskripsi'      => 'Deskripsi profil sekolah.',
            ]);
        }

        return view('admin.profil', [
            'title'         => 'Profil Sekolah',
            'profilSekolah' => $profilSekolah,
        ]);
    }

    /**
     * Menampilkan form edit profil sekolah.
     */
    public function edit($id)
    {
        $profilSekolah = ProfilSekolah::findOrFail($id);

        return view('admin.profil-edit', [
            'title'         => 'Edit Profil Sekolah',
            'profilSekolah' => $profilSekolah,
        ]);
    }

    /**
     * Memperbarui data profil sekolah.
     */
    public function update(Request $request, $id)
    {
        $profilSekolah = ProfilSekolah::findOrFail($id);

        // 1. Validasi input form sederhana
        $validated = $request->validate([
            'nama_sekolah'   => 'required|string|max:40',
            'kepala_sekolah' => 'required|string|max:40',
            'npsn'           => 'required|string|max:10',
            'alamat'         => 'required|string',
            'kontak'         => 'required|string|max:15',
            'visi_misi'      => 'required|string',
            'tahun_berdiri'  => 'required|digits:4|integer',
            'deskripsi'      => 'nullable|string',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Upload Logo Baru jika diunggah
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada di storage
            if ($profilSekolah->logo && Storage::disk('public')->exists($profilSekolah->logo)) {
                Storage::disk('public')->delete($profilSekolah->logo);
            }
            $validated['logo'] = $request->file('logo')->store('profil', 'public');
        }

        // 3. Upload Foto Baru jika diunggah
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada di storage
            if ($profilSekolah->foto && Storage::disk('public')->exists($profilSekolah->foto)) {
                Storage::disk('public')->delete($profilSekolah->foto);
            }
            $validated['foto'] = $request->file('foto')->store('profil', 'public');
        }

        // 4. Update ke database
        $profilSekolah->update($validated);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.profil')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
