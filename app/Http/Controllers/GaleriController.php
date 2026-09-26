<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Menampilkan daftar dokumentasi galeri sekolah.
     * Pencarian dan pagination ditangani oleh DataTables di sisi client.
     */
    public function index()
    {
        $galeri = Galeri::latest('tanggal')->get();

        return view('admin.galeri.index', compact('galeri'));
    }

    /**
     * Menampilkan form tambah media galeri baru.
     */
    public function create()
    {
        return view('admin.galeri.form');
    }

    /**
     * Menampilkan form edit media galeri.
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.form', compact('galeri'));
    }

    /**
     * Menyimpan data galeri (gabungan Tambah dan Ubah).
     */
    public function save(Request $request, $id = null)
    {
        // 1. Validasi input
        $rules = [
            'judul'      => 'required|max:50',
            'kategori'   => 'required|in:Foto,Video',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable',
            'file'       => $id ? 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240' : 'required|file|mimes:jpeg,png,jpg,mp4|max:10240',
        ];

        $messages = [
            'judul.required'    => 'Judul dokumentasi wajib diisi.',
            'judul.max'         => 'Judul maksimal 50 karakter.',
            'kategori.required' => 'Pilih kategori (Foto/Video).',
            'tanggal.required'  => 'Tanggal dokumentasi wajib diisi.',
            'file.required'     => 'File foto atau video wajib diunggah.',
            'file.mimes'        => 'Format file yang didukung: JPG, PNG, atau MP4.',
            'file.max'          => 'Ukuran file maksimal 10MB.',
        ];

        $request->validate($rules, $messages);

        // 2. Tentukan model (Tambah atau Ubah)
        if ($id) {
            $galeri = Galeri::findOrFail($id);
        } else {
            $galeri = new Galeri();
        }

        // 3. Masukkan data ke model
        $galeri->judul      = $request->judul;
        $galeri->kategori   = $request->kategori;
        $galeri->tanggal    = $request->tanggal;
        $galeri->keterangan = $request->keterangan;

        // 4. Upload file jika disertakan
        if ($request->hasFile('file')) {
            if ($galeri->file && Storage::disk('public')->exists($galeri->file)) {
                Storage::disk('public')->delete($galeri->file);
            }
            $galeri->file = $request->file('file')->store('galeri', 'public');
        }

        // 5. Simpan ke database
        $galeri->save();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', $id ? 'Dokumentasi galeri berhasil diperbarui.' : 'Dokumentasi galeri berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail media galeri.
     */
    public function show($id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Menghapus media galeri beserta filenya.
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->file && Storage::disk('public')->exists($galeri->file)) {
            Storage::disk('public')->delete($galeri->file);
        }

        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Dokumentasi galeri berhasil dihapus.');
    }
}
