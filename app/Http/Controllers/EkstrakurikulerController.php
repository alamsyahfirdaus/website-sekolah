<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class EkstrakurikulerController extends Controller
{
    /**
     * Menampilkan daftar semua ekstrakurikuler.
     */
    public function index()
    {
        $ekstrakurikuler = Ekstrakurikuler::with('guru')->latest()->get();

        return view('admin.ekstrakurikuler.index', compact('ekstrakurikuler'));
    }

    /**
     * Menampilkan form tambah atau ubah ekstrakurikuler.
     */
    public function addEdit($id = null)
    {
        try {
            $ekstrakurikuler = $id
                ? Ekstrakurikuler::findOrFail(Crypt::decrypt($id))
                : null;

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ekstrakurikuler.index')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        $guru = Guru::orderBy('nama_guru', 'asc')->get();

        return view('admin.ekstrakurikuler.form', compact('ekstrakurikuler', 'guru'));
    }

    /**
     * Menyimpan data baru atau perubahan ekstrakurikuler.
     */
    public function save(Request $request, $id = null)
    {
        // Jika ada ID, berarti sedang mengubah data.
        if ($id) {
            try {
                $id = Crypt::decrypt($id);
                $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);

            } catch (\Exception $e) {
                return redirect()
                    ->route('admin.ekstrakurikuler.index')
                    ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
            }

        } else {
            // Jika tidak ada ID, berarti menambah data baru.
            $ekstrakurikuler = new Ekstrakurikuler();
        }

        // Validasi input
        $request->validate([
            'nama_ekskul'    => 'required|string|max:40',
            'id_guru'        => 'required|exists:guru,id',
            'jadwal_latihan' => 'required|string|max:40',
            'deskripsi'      => 'nullable|string',
            'gambar'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_ekskul.required'    => 'Nama ekstrakurikuler wajib diisi.',
            'nama_ekskul.max'         => 'Nama ekstrakurikuler maksimal 40 karakter.',
            'id_guru.required'        => 'Guru pembina wajib dipilih.',
            'id_guru.exists'          => 'Guru pembina yang dipilih tidak valid.',
            'jadwal_latihan.required' => 'Jadwal latihan wajib diisi.',
            'jadwal_latihan.max'      => 'Jadwal latihan maksimal 40 karakter.',
            'gambar.image'            => 'File harus berupa gambar (JPG, PNG).',
            'gambar.max'              => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Masukkan data ke model
        $ekstrakurikuler->nama_ekskul    = $request->nama_ekskul;
        $ekstrakurikuler->id_guru        = $request->id_guru;
        $ekstrakurikuler->jadwal_latihan = $request->jadwal_latihan;
        $ekstrakurikuler->deskripsi      = $request->deskripsi;

        // Upload gambar jika disertakan
        if ($request->hasFile('gambar')) {
            if ($ekstrakurikuler->gambar && Storage::disk('public')->exists($ekstrakurikuler->gambar)) {
                Storage::disk('public')->delete($ekstrakurikuler->gambar);
            }
            $ekstrakurikuler->gambar = $request->file('gambar')->store('ekstrakurikuler', 'public');
        }

        // Simpan ke database
        $ekstrakurikuler->save();

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with(
                'success',
                $id
                    ? 'Data ekstrakurikuler berhasil diperbarui.'
                    : 'Data ekstrakurikuler berhasil disimpan.'
            );
    }

    /**
     * Menampilkan detail informasi ekstrakurikuler.
     */
    public function show($id)
    {
        try {
            $ekstrakurikuler = Ekstrakurikuler::with('guru')->findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ekstrakurikuler.index')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        return view('admin.ekstrakurikuler.show', compact('ekstrakurikuler'));
    }

    /**
     * Menghapus ekstrakurikuler dan file gambarnya.
     */
    public function destroy($id)
    {
        try {
            $ekstrakurikuler = Ekstrakurikuler::findOrFail(Crypt::decrypt($id));

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.ekstrakurikuler.index')
                ->with('error', 'Data ekstrakurikuler tidak ditemukan.');
        }

        if ($ekstrakurikuler->gambar && Storage::disk('public')->exists($ekstrakurikuler->gambar)) {
            Storage::disk('public')->delete($ekstrakurikuler->gambar);
        }

        $ekstrakurikuler->delete();

        return redirect()
            ->route('admin.ekstrakurikuler.index')
            ->with('success', 'Data ekstrakurikuler berhasil dihapus.');
    }
}
