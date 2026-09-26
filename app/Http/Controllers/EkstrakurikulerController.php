<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    /**
     * Menampilkan daftar ekstrakurikuler sekolah.
     * Pencarian dan pagination ditangani oleh DataTables di sisi client.
     */
    public function index()
    {
        $ekstrakurikuler = Ekstrakurikuler::with('guru')->latest()->get();

        return view('admin.ekstrakurikuler.index', compact('ekstrakurikuler'));
    }

    /**
     * Menampilkan form tambah ekstrakurikuler baru.
     */
    public function create()
    {
        $guru = Guru::orderBy('nama_guru', 'asc')->get();

        return view('admin.ekstrakurikuler.form', compact('guru'));
    }

    /**
     * Menampilkan form edit ekstrakurikuler.
     */
    public function edit($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $guru = Guru::orderBy('nama_guru', 'asc')->get();

        return view('admin.ekstrakurikuler.form', compact('ekstrakurikuler', 'guru'));
    }

    /**
     * Menyimpan data ekstrakurikuler (gabungan Tambah dan Ubah).
     */
    public function save(Request $request, $id = null)
    {
        // 1. Validasi input
        $request->validate([
            'nama_ekskul'    => 'required|max:40',
            'id_guru'        => 'required|exists:guru,id',
            'jadwal_latihan' => 'required|max:40',
            'deskripsi'      => 'nullable',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_ekskul.required'    => 'Nama ekstrakurikuler wajib diisi.',
            'nama_ekskul.max'         => 'Nama ekstrakurikuler maksimal 40 karakter.',
            'id_guru.required'        => 'Guru pembina wajib dipilih.',
            'id_guru.exists'          => 'Guru pembina yang dipilih tidak terdaftar.',
            'jadwal_latihan.required' => 'Jadwal latihan wajib diisi.',
            'jadwal_latihan.max'      => 'Jadwal latihan maksimal 40 karakter.',
            'gambar.image'            => 'File harus berupa gambar (JPG, PNG).',
            'gambar.max'              => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Tentukan model (Tambah atau Ubah)
        if ($id) {
            $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        } else {
            $ekstrakurikuler = new Ekstrakurikuler();
        }

        // 3. Masukkan data ke model
        $ekstrakurikuler->nama_ekskul    = $request->nama_ekskul;
        $ekstrakurikuler->id_guru        = $request->id_guru;
        $ekstrakurikuler->jadwal_latihan = $request->jadwal_latihan;
        $ekstrakurikuler->deskripsi      = $request->deskripsi;

        // 4. Upload gambar jika disertakan
        if ($request->hasFile('gambar')) {
            if ($ekstrakurikuler->gambar && Storage::disk('public')->exists($ekstrakurikuler->gambar)) {
                Storage::disk('public')->delete($ekstrakurikuler->gambar);
            }
            $ekstrakurikuler->gambar = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        // 5. Simpan ke database
        $ekstrakurikuler->save();

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with('success', $id ? 'Data ekstrakurikuler berhasil diperbarui.' : 'Data ekstrakurikuler berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail informasi satu ekstrakurikuler.
     */
    public function show($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::with('guru')->findOrFail($id);

        return view('admin.ekstrakurikuler.show', compact('ekstrakurikuler'));
    }

    /**
     * Menghapus data ekstrakurikuler dan file gambarnya.
     */
    public function destroy($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);

        if ($ekstrakurikuler->gambar && Storage::disk('public')->exists($ekstrakurikuler->gambar)) {
            Storage::disk('public')->delete($ekstrakurikuler->gambar);
        }

        $ekstrakurikuler->delete();

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with('success', 'Data ekstrakurikuler berhasil dihapus.');
    }
}
