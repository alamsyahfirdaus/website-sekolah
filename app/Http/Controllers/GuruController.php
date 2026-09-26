<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar semua data guru.
     * Pencarian, pengurutan, dan pagination ditangani langsung oleh DataTables.
     */
    public function index()
    {
        // Mengambil semua data guru terbaru tanpa filter search di controller
        $guru = Guru::latest()->get();

        return view('admin.guru.index', compact('guru'));
    }

    /**
     * Menampilkan form untuk menambah guru baru.
     */
    public function create()
    {
        return view('admin.guru.form');
    }

    /**
     * Menampilkan form untuk mengedit guru yang sudah ada.
     */
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('admin.guru.form', compact('guru'));
    }

    /**
     * Menyimpan data guru (gabungan Tambah dan Ubah).
     * Jika $id ada -> Edit
     * Jika $id kosong -> Tambah
     */
    public function save(Request $request, $id = null)
    {
        // 1. Validasi input sederhana
        $request->validate([
            'nama_guru' => 'required',
            'mapel'     => 'required',
            'nip'       => 'nullable|unique:guru,nip,' . ($id ?? 'NULL') . ',id',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'mapel.required'     => 'Mata pelajaran wajib diisi.',
            'nip.unique'         => 'NIP sudah terdaftar.',
            'foto.image'         => 'Foto harus berupa file gambar (JPG, PNG).',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        // 2. Tentukan model (Tambah atau Ubah)
        if ($id) {
            $guru = Guru::findOrFail($id);
        } else {
            $guru = new Guru();
        }

        // 3. Masukkan data dari form ke model
        $guru->nama_guru = $request->nama_guru;
        $guru->nip       = $request->nip;
        $guru->mapel     = $request->mapel;

        // 4. Upload foto jika disertakan
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $guru->foto = $request->file('foto')->store('guru', 'public');
        }

        // 5. Simpan ke database
        $guru->save();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', $id ? 'Data guru berhasil diperbarui.' : 'Data guru berhasil disimpan.');
    }

    /**
     * Menampilkan detail informasi seorang guru.
     */
    public function show($id)
    {
        $guru = Guru::with('ekstrakurikuler')->findOrFail($id);

        return view('admin.guru.show', compact('guru'));
    }

    /**
     * Menghapus data guru dari database.
     */
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()
            ->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
