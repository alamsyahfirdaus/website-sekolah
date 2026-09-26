<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Menampilkan daftar galeri dengan tampilan grid/card, pencarian, dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query model Galeri
        $query = Galeri::query();

        // 2. Filter pencarian berdasarkan judul, kategori, atau keterangan
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('kategori', 'like', "%{$keyword}%")
                  ->orWhere('keterangan', 'like', "%{$keyword}%");
            });
        }

        // 3. Ambil data dengan pagination 8 item per halaman (cocok untuk grid 4 kolom)
        $galeris = $query->latest('tanggal')->paginate(8)->withQueryString();

        return view('admin.galeri.index', [
            'title'   => 'Kelola Galeri',
            'galeris' => $galeris,
            'search'  => $request->search,
        ]);
    }

    /**
     * Menampilkan form untuk menambah item galeri baru.
     */
    public function create()
    {
        return view('admin.galeri.create', [
            'title' => 'Tambah Galeri',
        ]);
    }

    /**
     * Menyimpan item galeri baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'judul'      => 'required|string|max:50',
            'kategori'   => 'required|in:Foto,Video',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
            'file'       => 'required|file|mimes:jpeg,png,jpg,mp4|max:10240',
        ], [
            'judul.required'    => 'Judul dokumentasi wajib diisi.',
            'judul.max'         => 'Judul maksimal 50 karakter.',
            'kategori.required' => 'Pilih kategori (Foto/Video).',
            'tanggal.required'  => 'Tanggal dokumentasi wajib diisi.',
            'file.required'     => 'File foto atau video wajib diunggah.',
            'file.mimes'        => 'Format file yang didukung: JPG, PNG, atau MP4.',
            'file.max'          => 'Ukuran file maksimal 10MB.',
        ]);

        // 2. Upload file ke storage publik
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('galeri', 'public');
        }

        // 3. Simpan data ke database
        Galeri::create($validated);

        // 4. Redirect dengan notifikasi sukses
        return redirect()->route('admin.galeri')->with('success', 'Dokumentasi galeri berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail media galeri.
     */
    public function show($id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.show', [
            'title'  => 'Detail Galeri',
            'galeri' => $galeri,
        ]);
    }

    /**
     * Menampilkan form edit galeri.
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);

        return view('admin.galeri.edit', [
            'title'  => 'Edit Galeri',
            'galeri' => $galeri,
        ]);
    }

    /**
     * Memperbarui data galeri di database.
     */
    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        // 1. Validasi input
        $validated = $request->validate([
            'judul'      => 'required|string|max:50',
            'kategori'   => 'required|in:Foto,Video',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
            'file'       => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240',
        ], [
            'judul.required'    => 'Judul dokumentasi wajib diisi.',
            'judul.max'         => 'Judul maksimal 50 karakter.',
            'kategori.required' => 'Pilih kategori (Foto/Video).',
            'tanggal.required'  => 'Tanggal dokumentasi wajib diisi.',
            'file.mimes'        => 'Format file yang didukung: JPG, PNG, atau MP4.',
            'file.max'          => 'Ukuran file maksimal 10MB.',
        ]);

        // 2. Jika ada upload file baru, ganti file lama
        if ($request->hasFile('file')) {
            if ($galeri->file && Storage::disk('public')->exists($galeri->file)) {
                Storage::disk('public')->delete($galeri->file);
            }
            $validated['file'] = $request->file('file')->store('galeri', 'public');
        }

        // 3. Update database
        $galeri->update($validated);

        // 4. Redirect kembali dengan notifikasi sukses
        return redirect()->route('admin.galeri')->with('success', 'Dokumentasi galeri berhasil diperbarui.');
    }

    /**
     * Menghapus item galeri dan filenya.
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus file fisik dari storage
        if ($galeri->file && Storage::disk('public')->exists($galeri->file)) {
            Storage::disk('public')->delete($galeri->file);
        }

        // Hapus record dari database
        $galeri->delete();

        return redirect()->route('admin.galeri')->with('success', 'Dokumentasi galeri berhasil dihapus.');
    }
}
