<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar semua data guru.
     * Fitur: Pencarian sederhana dan pagination 10 data per halaman.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query model Guru
        $query = Guru::query();

        // 2. Filter pencarian berdasarkan nama, NIP, atau mata pelajaran
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_guru', 'like', "%{$keyword}%")
                  ->orWhere('nip', 'like', "%{$keyword}%")
                  ->orWhere('mapel', 'like', "%{$keyword}%");
            });
        }

        // 3. Ambil data dengan pagination 10 item per halaman
        $gurus = $query->latest()->paginate(10)->withQueryString();

        return view('admin.guru.index', [
            'title' => 'Kelola Guru',
            'gurus' => $gurus,
            'search' => $request->search,
        ]);
    }

    /**
     * Menampilkan form untuk menambah data guru baru.
     */
    public function create()
    {
        return view('admin.guru.create', [
            'title' => 'Tambah Guru',
        ]);
    }

    /**
     * Menyimpan data guru baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:40',
            'nip'       => 'nullable|string|max:15|unique:guru,nip',
            'mapel'     => 'required|string|max:40',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'mapel.required'     => 'Mata pelajaran wajib diisi.',
            'nip.unique'         => 'NIP sudah terdaftar dalam sistem.',
            'foto.image'         => 'File foto harus berupa gambar (JPG, JPEG, PNG).',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        // 2. Upload file foto jika disertakan
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        }

        // 3. Simpan ke database melalui Model
        Guru::create($validated);

        // 4. Redirect ke index dengan notifikasi sukses
        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi satu orang guru.
     */
    public function show($id)
    {
        // Ambil data guru beserta relasi ekstrakurikuler yang dibina
        $guru = Guru::with('ekstrakurikuler')->findOrFail($id);

        return view('admin.guru.show', [
            'title' => 'Detail Guru',
            'guru'  => $guru,
        ]);
    }

    /**
     * Menampilkan form edit untuk data guru yang dipilih.
     */
    public function edit($id)
    {
        $guru = Guru::findOrFail($id);

        return view('admin.guru.edit', [
            'title' => 'Edit Guru',
            'guru'  => $guru,
        ]);
    }

    /**
     * Memperbarui data guru di database.
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        // 1. Validasi input
        $validated = $request->validate([
            'nama_guru' => 'required|string|max:40',
            'nip'       => 'nullable|string|max:15|unique:guru,nip,' . $guru->id,
            'mapel'     => 'required|string|max:40',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_guru.required' => 'Nama guru wajib diisi.',
            'mapel.required'     => 'Mata pelajaran wajib diisi.',
            'nip.unique'         => 'NIP sudah terdaftar pada guru lain.',
            'foto.image'         => 'File foto harus berupa gambar (JPG, JPEG, PNG).',
            'foto.max'           => 'Ukuran foto maksimal 2MB.',
        ]);

        // 2. Jika ada upload foto baru, hapus foto lama dan simpan foto baru
        if ($request->hasFile('foto')) {
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }
            $validated['foto'] = $request->file('foto')->store('guru', 'public');
        }

        // 3. Update data ke database
        $guru->update($validated);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Menghapus data guru dari database beserta filenya.
     */
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        // Hapus file foto dari storage jika ada
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        // Hapus data dari database
        $guru->delete();

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil dihapus.');
    }
}
