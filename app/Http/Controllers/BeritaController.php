<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar berita sekolah.
     * Fitur pencarian dan pagination ditangani oleh DataTables.
     */
    public function index()
    {
        $berita = Berita::with('user')->latest('tanggal')->get();

        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Menampilkan form untuk menulis berita baru.
     */
    public function create()
    {
        return view('admin.berita.form');
    }

    /**
     * Menampilkan form untuk mengedit berita.
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        return view('admin.berita.form', compact('berita'));
    }

    /**
     * Menyimpan data berita (gabungan Tambah dan Ubah).
     */
    public function save(Request $request, $id = null)
    {
        // 1. Validasi input
        $request->validate([
            'judul'   => 'required|max:50',
            'isi'     => 'required',
            'tanggal' => 'required|date',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required'   => 'Judul berita wajib diisi.',
            'judul.max'        => 'Judul maksimal 50 karakter.',
            'isi.required'     => 'Isi berita wajib diisi.',
            'tanggal.required' => 'Tanggal publikasi wajib diisi.',
            'gambar.image'     => 'Gambar harus berupa file gambar (JPG, PNG).',
            'gambar.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Tentukan model (Tambah atau Ubah)
        if ($id) {
            $berita = Berita::findOrFail($id);
        } else {
            $berita = new Berita();
            $berita->id_user = Auth::id() ?? User::value('id');
        }

        // 3. Masukkan data ke model
        $berita->judul   = $request->judul;
        $berita->isi     = $request->isi;
        $berita->tanggal = $request->tanggal;

        // 4. Upload gambar jika disertakan
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $berita->gambar = $request->file('gambar')->store('berita', 'public');
        }

        // 5. Simpan ke database
        $berita->save();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', $id ? 'Berita berhasil diperbarui.' : 'Berita berhasil disimpan.');
    }

    /**
     * Menampilkan detail isi berita.
     */
    public function show($id)
    {
        $berita = Berita::with('user')->findOrFail($id);

        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Menghapus berita dan gambarnya dari database.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }
}
