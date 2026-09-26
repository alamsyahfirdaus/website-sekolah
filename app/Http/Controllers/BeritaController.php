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
     * Menampilkan daftar berita dengan pencarian dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query model Berita dengan relasi user (penulis)
        $query = Berita::with('user');

        // 2. Pencarian berdasarkan judul atau isi
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('isi', 'like', "%{$keyword}%");
            });
        }

        // 3. Ambil data berita terbaru dengan pagination
        $beritas = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('admin.berita.index', [
            'title'   => 'Kelola Berita',
            'beritas' => $beritas,
            'search'  => $request->search,
        ]);
    }

    /**
     * Menampilkan form tambah berita baru.
     */
    public function create()
    {
        return view('admin.berita.create', [
            'title' => 'Tambah Berita',
        ]);
    }

    /**
     * Menyimpan berita baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'judul'   => 'required|string|max:50',
            'isi'     => 'required|string',
            'tanggal' => 'required|date',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required'   => 'Judul berita wajib diisi.',
            'judul.max'        => 'Judul maksimal 50 karakter.',
            'isi.required'     => 'Isi berita wajib diisi.',
            'tanggal.required' => 'Tanggal publikasi wajib diisi.',
            'gambar.image'     => 'File gambar harus berupa file gambar (JPG, JPEG, PNG).',
            'gambar.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Tentukan penulis berita (user yang sedang login atau user pertama)
        $validated['id_user'] = Auth::id() ?? User::value('id');

        // 3. Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // 4. Simpan ke database
        Berita::create($validated);

        // 5. Redirect dengan notifikasi sukses
        return redirect()->route('admin.berita')->with('success', 'Berita berhasil dipublikasikan.');
    }

    /**
     * Menampilkan detail isi berita.
     */
    public function show($id)
    {
        $berita = Berita::with('user')->findOrFail($id);

        return view('admin.berita.show', [
            'title'  => 'Detail Berita',
            'berita' => $berita,
        ]);
    }

    /**
     * Menampilkan form edit berita.
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);

        return view('admin.berita.edit', [
            'title'  => 'Edit Berita',
            'berita' => $berita,
        ]);
    }

    /**
     * Memperbarui berita di database.
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        // 1. Validasi input
        $validated = $request->validate([
            'judul'   => 'required|string|max:50',
            'isi'     => 'required|string',
            'tanggal' => 'required|date',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'judul.required'   => 'Judul berita wajib diisi.',
            'judul.max'        => 'Judul maksimal 50 karakter.',
            'isi.required'     => 'Isi berita wajib diisi.',
            'tanggal.required' => 'Tanggal publikasi wajib diisi.',
            'gambar.image'     => 'File gambar harus berupa gambar (JPG, JPEG, PNG).',
            'gambar.max'       => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Jika ada upload gambar baru, ganti gambar lama
        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        // 3. Update database
        $berita->update($validated);

        // 4. Redirect kembali dengan notifikasi sukses
        return redirect()->route('admin.berita')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dan gambarnya.
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        // Hapus record dari database
        $berita->delete();

        return redirect()->route('admin.berita')->with('success', 'Berita berhasil dihapus.');
    }
}
