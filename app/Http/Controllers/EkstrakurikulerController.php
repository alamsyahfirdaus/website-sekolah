<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    /**
     * Menampilkan daftar ekstrakurikuler beserta data guru pembinanya.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query dengan eager loading relasi guru
        $query = Ekstrakurikuler::with('guru');

        // 2. Pencarian berdasarkan nama ekskul, jadwal, atau nama pembina
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_ekskul', 'like', "%{$keyword}%")
                  ->orWhere('jadwal_latihan', 'like', "%{$keyword}%")
                  ->orWhereHas('guru', function ($guruQuery) use ($keyword) {
                      $guruQuery->where('nama_guru', 'like', "%{$keyword}%");
                  });
            });
        }

        // 3. Ambil data dengan pagination
        $ekskuls = $query->latest()->paginate(10)->withQueryString();

        return view('admin.ekstrakurikuler.index', [
            'title'   => 'Kelola Ekstrakurikuler',
            'ekskuls' => $ekskuls,
            'search'  => $request->search,
        ]);
    }

    /**
     * Menampilkan form tambah ekstrakurikuler baru.
     */
    public function create()
    {
        // Ambil daftar guru untuk pilihan pembina
        $gurus = Guru::orderBy('nama_guru', 'asc')->get();

        return view('admin.ekstrakurikuler.create', [
            'title' => 'Tambah Ekstrakurikuler',
            'gurus' => $gurus,
        ]);
    }

    /**
     * Menyimpan data ekstrakurikuler baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_ekskul'    => 'required|string|max:40',
            'id_guru'        => 'required|exists:guru,id',
            'jadwal_latihan' => 'required|string|max:40',
            'deskripsi'      => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_ekskul.required'    => 'Nama ekstrakurikuler wajib diisi.',
            'id_guru.required'        => 'Pilih guru pembina.',
            'id_guru.exists'          => 'Guru pembina yang dipilih tidak valid.',
            'jadwal_latihan.required' => 'Jadwal latihan wajib diisi.',
            'gambar.image'            => 'File gambar harus berupa file gambar (JPG, JPEG, PNG).',
            'gambar.max'              => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        // 3. Simpan ke database
        Ekstrakurikuler::create($validated);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('admin.ekstrakurikuler')->with('success', 'Data ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi satu ekstrakurikuler.
     */
    public function show($id)
    {
        $ekskul = Ekstrakurikuler::with('guru')->findOrFail($id);

        return view('admin.ekstrakurikuler.show', [
            'title'  => 'Detail Ekstrakurikuler',
            'ekskul' => $ekskul,
        ]);
    }

    /**
     * Menampilkan form edit ekstrakurikuler.
     */
    public function edit($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);
        $gurus = Guru::orderBy('nama_guru', 'asc')->get();

        return view('admin.ekstrakurikuler.edit', [
            'title'  => 'Edit Ekstrakurikuler',
            'ekskul' => $ekskul,
            'gurus'  => $gurus,
        ]);
    }

    /**
     * Memperbarui data ekstrakurikuler di database.
     */
    public function update(Request $request, $id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        // 1. Validasi input
        $validated = $request->validate([
            'nama_ekskul'    => 'required|string|max:40',
            'id_guru'        => 'required|exists:guru,id',
            'jadwal_latihan' => 'required|string|max:40',
            'deskripsi'      => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_ekskul.required'    => 'Nama ekstrakurikuler wajib diisi.',
            'id_guru.required'        => 'Pilih guru pembina.',
            'id_guru.exists'          => 'Guru pembina yang dipilih tidak valid.',
            'jadwal_latihan.required' => 'Jadwal latihan wajib diisi.',
            'gambar.image'            => 'File gambar harus berupa file gambar (JPG, JPEG, PNG).',
            'gambar.max'              => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Jika ada unggahan gambar baru, hapus gambar lama dan simpan yang baru
        if ($request->hasFile('gambar')) {
            if ($ekskul->gambar && Storage::disk('public')->exists($ekskul->gambar)) {
                Storage::disk('public')->delete($ekskul->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        // 3. Update database
        $ekskul->update($validated);

        // 4. Redirect kembali dengan notifikasi sukses
        return redirect()->route('admin.ekstrakurikuler')->with('success', 'Data ekstrakurikuler berhasil diperbarui.');
    }

    /**
     * Menghapus ekstrakurikuler beserta gambarnya.
     */
    public function destroy($id)
    {
        $ekskul = Ekstrakurikuler::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($ekskul->gambar && Storage::disk('public')->exists($ekskul->gambar)) {
            Storage::disk('public')->delete($ekskul->gambar);
        }

        // Hapus data dari database
        $ekskul->delete();

        return redirect()->route('admin.ekstrakurikuler')->with('success', 'Data ekstrakurikuler berhasil dihapus.');
    }
}
