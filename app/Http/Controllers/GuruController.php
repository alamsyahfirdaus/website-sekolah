<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar semua data guru.
     */
    public function index()
    {
        $guru = Guru::latest()->get();

        return view('admin.guru.index', compact('guru'));
    }

    /**
     * Menampilkan form tambah atau ubah data guru.
     */
    public function addEdit($id = null)
    {
        try {
            $guru = $id
                ? Guru::findOrFail(Crypt::decrypt($id))
                : null;

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        return view('admin.guru.form', compact('guru'));
    }

    /**
     * Menyimpan data baru atau perubahan data guru.
     */
    public function save(Request $request, $id = null)
    {
        // Jika ada ID, berarti sedang mengubah data.
        if ($id) {
            try {
                $id = Crypt::decrypt($id);
                $guru = Guru::findOrFail($id);

            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.guru.index')
                    ->with('error', 'Data guru tidak ditemukan.');
            }

        } else {
            // Jika tidak ada ID, berarti menambah data baru.
            $guru = new Guru();
        }

        // Validasi input
        $request->validate([
            'nama_guru' => 'required|string|max:40',
            'mapel'     => 'required|string|max:40',
            'nip'       => 'nullable|unique:guru,nip,' . ($id ?? 'NULL') . ',id',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'mapel.required'     => 'Mata pelajaran wajib diisi.',
            'nip.unique'         => 'NIP sudah terdaftar pada guru lain.',
            'foto.image'         => 'Foto harus berupa file gambar (JPG, PNG).',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        // Masukkan data form ke model
        $guru->nama_guru = $request->nama_guru;
        $guru->nip       = $request->nip;
        $guru->mapel     = $request->mapel;

        // Upload foto jika disertakan
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $guru->foto = $request->file('foto')->store('guru', 'public');
        }

        // Simpan data ke database
        $guru->save();

        return redirect()
            ->route('admin.guru.index')
            ->with(
                'success',
                $id
                    ? 'Data guru berhasil diperbarui.'
                    : 'Data guru berhasil disimpan.'
            );
    }

    /**
     * Menampilkan detail informasi guru.
     */
    public function show($id)
    {
        try {
            $guru = Guru::with('ekstrakurikuler')->findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Menghapus data guru dari database.
     */
    public function destroy($id)
    {
        try {
            $guru = Guru::findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
