<?php

namespace App\Http\Controllers;

use App\Models\ProfilSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSekolahController extends Controller
{
    /**
     * Menampilkan form edit profil sekolah.
     * Profil Sekolah bukan CRUD biasa (hanya ada 1 record).
     */
    public function index()
    {
        $profilSekolah = ProfilSekolah::first();

        // Jika belum ada data profil di database, buat data awal default
        if (!$profilSekolah) {
            $profilSekolah = ProfilSekolah::create([
                'nama_sekolah'   => 'Nama Sekolah',
                'kepala_sekolah' => 'Kepala Sekolah',
                'npsn'           => '12345678',
                'alamat'         => 'Jl. Pendidikan No. 1',
                'kontak'         => '08123456789',
                'visi_misi'      => "Visi:\nMenjadi sekolah unggulan yang berkarakter dan berdaya saing global.\n\nMisi:\n1. Menyelenggarakan pendidikan berkualitas.\n2. Mengembangkan potensi siswa secara optimal.",
                'tahun_berdiri'  => date('Y'),
                'deskripsi'      => 'Deskripsi singkat profil sekolah dan sambutan kepala sekolah.',
            ]);
        }

        return view('admin.profil-sekolah.index', compact('profilSekolah'));
    }

    /**
     * Menyimpan perubahan profil sekolah.
     */
    public function save(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_sekolah'   => 'required|max:40',
            'kepala_sekolah' => 'required|max:40',
            'npsn'           => 'required|max:10',
            'alamat'         => 'required',
            'kontak'         => 'required|max:15',
            'visi_misi'      => 'required',
            'tahun_berdiri'  => 'required|digits:4|integer',
            'deskripsi'      => 'nullable',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_sekolah.required'   => 'Nama sekolah wajib diisi.',
            'nama_sekolah.max'        => 'Nama sekolah maksimal 40 karakter.',
            'kepala_sekolah.required' => 'Nama kepala sekolah wajib diisi.',
            'kepala_sekolah.max'      => 'Nama kepala sekolah maksimal 40 karakter.',
            'npsn.required'           => 'NPSN wajib diisi.',
            'npsn.max'                => 'NPSN maksimal 10 karakter.',
            'alamat.required'         => 'Alamat sekolah wajib diisi.',
            'kontak.required'         => 'Nomor kontak telepon wajib diisi.',
            'kontak.max'              => 'Kontak maksimal 15 karakter.',
            'visi_misi.required'      => 'Visi dan misi wajib diisi.',
            'tahun_berdiri.required'  => 'Tahun berdiri wajib diisi.',
            'tahun_berdiri.digits'    => 'Tahun berdiri harus 4 digit angka.',
            'logo.image'              => 'Logo harus berupa file gambar (JPG, PNG).',
            'foto.image'              => 'Foto gedung harus berupa file gambar (JPG, PNG).',
        ]);

        // 2. Ambil data atau buat instance baru
        $profilSekolah = ProfilSekolah::first();
        if (!$profilSekolah) {
            $profilSekolah = new ProfilSekolah();
        }

        // 3. Masukkan data
        $profilSekolah->nama_sekolah   = $request->nama_sekolah;
        $profilSekolah->kepala_sekolah = $request->kepala_sekolah;
        $profilSekolah->npsn           = $request->npsn;
        $profilSekolah->alamat         = $request->alamat;
        $profilSekolah->kontak         = $request->kontak;
        $profilSekolah->visi_misi      = $request->visi_misi;
        $profilSekolah->tahun_berdiri  = $request->tahun_berdiri;
        $profilSekolah->deskripsi      = $request->deskripsi;

        // 4. Upload logo jika disertakan
        if ($request->hasFile('logo')) {
            if ($profilSekolah->logo && Storage::disk('public')->exists($profilSekolah->logo)) {
                Storage::disk('public')->delete($profilSekolah->logo);
            }
            $profilSekolah->logo = $request->file('logo')->store('profil', 'public');
        }

        // 5. Upload foto gedung jika disertakan
        if ($request->hasFile('foto')) {
            if ($profilSekolah->foto && Storage::disk('public')->exists($profilSekolah->foto)) {
                Storage::disk('public')->delete($profilSekolah->foto);
            }
            $profilSekolah->foto = $request->file('foto')->store('profil', 'public');
        }

        // 6. Simpan ke database
        $profilSekolah->save();

        return redirect()
            ->route('admin.profil-sekolah')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
