<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\ProfilSekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCrudTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('role', 'Admin')->first() ?? User::first();
    }

    /**
     * 1. Dashboard dapat dibuka dan menampilkan ringkasan data.
     */
    public function test_dashboard_can_be_viewed()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Total Guru');
        $response->assertSee('Total Siswa');
    }

    /**
     * 2. Profil sekolah dapat ditampilkan dan disimpan (Metode save tunggal).
     */
    public function test_profil_sekolah_can_be_viewed_and_saved()
    {
        $profil = ProfilSekolah::first();

        // Tampil form profil
        $response = $this->actingAs($this->admin)->get(route('admin.profil-sekolah'));
        $response->assertStatus(200);
        $response->assertSee($profil->nama_sekolah);

        // Simpan perubahan profil
        $responseSave = $this->actingAs($this->admin)->post(route('admin.profil-sekolah.save'), [
            'nama_sekolah'   => 'SMK BISA HEBAT',
            'kepala_sekolah' => 'Dr. Budi Santoso, M.Pd.',
            'npsn'           => '20210890',
            'alamat'         => 'Jl. Pendidikan Baru No. 100',
            'kontak'         => '081234567899',
            'visi_misi'      => 'Visi dan Misi Terkini',
            'tahun_berdiri'  => 2005,
            'deskripsi'      => 'Deskripsi sekolah yang diperbarui.',
        ]);

        $responseSave->assertRedirect(route('admin.profil-sekolah'));
        $responseSave->assertSessionHas('success');

        $this->assertDatabaseHas('profil_sekolah', [
            'id'           => $profil->id,
            'nama_sekolah' => 'SMK BISA HEBAT',
        ]);
    }

    /**
     * 3. CRUD Guru (index, create form, save baru, show, edit form, save update, delete).
     */
    public function test_guru_crud_operations()
    {
        Storage::fake('public');

        // Index
        $this->actingAs($this->admin)->get(route('admin.guru.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.guru.create'))->assertStatus(200);

        // Save Guru Baru
        $foto = UploadedFile::fake()->image('guru_test.jpg');
        $responseStore = $this->actingAs($this->admin)->post(route('admin.guru.save'), [
            'nama_guru' => 'Guru Penguji, S.Pd.',
            'nip'       => '199901012022011',
            'mapel'     => 'Teknik Komputer Jaringan',
            'foto'      => $foto,
        ]);

        $responseStore->assertRedirect(route('admin.guru.index'));
        $responseStore->assertSessionHas('success');

        $guru = Guru::where('nip', '199901012022011')->first();
        $this->assertNotNull($guru);

        // Detail
        $this->actingAs($this->admin)->get(route('admin.guru.show', $guru->id))
            ->assertStatus(200)
            ->assertSee('Guru Penguji, S.Pd.');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.guru.edit', $guru->id))->assertStatus(200);

        // Save Guru Update
        $responseUpdate = $this->actingAs($this->admin)->post(route('admin.guru.save', $guru->id), [
            'nama_guru' => 'Guru Penguji Update, M.Pd.',
            'nip'       => '199901012022011',
            'mapel'     => 'Pemrograman Web',
        ]);

        $responseUpdate->assertRedirect(route('admin.guru.index'));
        $this->assertDatabaseHas('guru', [
            'id'        => $guru->id,
            'nama_guru' => 'Guru Penguji Update, M.Pd.',
        ]);

        // Hapus
        $responseDelete = $this->actingAs($this->admin)->delete(route('admin.guru.delete', $guru->id));
        $responseDelete->assertRedirect(route('admin.guru.index'));
        $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
    }

    /**
     * 4. CRUD Siswa (index, create form, save baru, show, edit form, save update, delete).
     */
    public function test_siswa_crud_operations()
    {
        // Index
        $this->actingAs($this->admin)->get(route('admin.siswa.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.siswa.create'))->assertStatus(200);

        // Save Siswa Baru
        $responseStore = $this->actingAs($this->admin)->post(route('admin.siswa.save'), [
            'nisn'          => '9998887771',
            'nama_siswa'    => 'Siswa Penguji',
            'jenis_kelamin' => 'Laki-Laki',
            'tahun_masuk'   => 2024,
        ]);

        $responseStore->assertRedirect(route('admin.siswa.index'));
        $siswa = Siswa::where('nisn', '9998887771')->first();
        $this->assertNotNull($siswa);

        // Show
        $this->actingAs($this->admin)->get(route('admin.siswa.show', $siswa->id))
            ->assertStatus(200)
            ->assertSee('Siswa Penguji');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.siswa.edit', $siswa->id))->assertStatus(200);

        // Save Siswa Update
        $this->actingAs($this->admin)->post(route('admin.siswa.save', $siswa->id), [
            'nisn'          => '9998887771',
            'nama_siswa'    => 'Siswa Penguji Berubah',
            'jenis_kelamin' => 'Laki-Laki',
            'tahun_masuk'   => 2024,
        ])->assertRedirect(route('admin.siswa.index'));

        $this->assertDatabaseHas('siswa', [
            'id'         => $siswa->id,
            'nama_siswa' => 'Siswa Penguji Berubah',
        ]);

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.siswa.delete', $siswa->id))
            ->assertRedirect(route('admin.siswa.index'));
        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }

    /**
     * 5. CRUD Berita (index, create form, save baru, show, edit form, save update, delete).
     */
    public function test_berita_crud_operations()
    {
        Storage::fake('public');

        // Index
        $this->actingAs($this->admin)->get(route('admin.berita.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.berita.create'))->assertStatus(200);

        // Save Berita Baru
        $responseStore = $this->actingAs($this->admin)->post(route('admin.berita.save'), [
            'judul'   => 'Judul Berita Uji Coba',
            'tanggal' => date('Y-m-d'),
            'isi'     => 'Ini adalah konten berita untuk pengujian sistem otomatis.',
            'gambar'  => UploadedFile::fake()->image('berita_cover.jpg'),
        ]);

        $responseStore->assertRedirect(route('admin.berita.index'));
        $berita = Berita::where('judul', 'Judul Berita Uji Coba')->first();
        $this->assertNotNull($berita);

        // Show
        $this->actingAs($this->admin)->get(route('admin.berita.show', $berita->id))
            ->assertStatus(200)
            ->assertSee('Judul Berita Uji Coba');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.berita.edit', $berita->id))->assertStatus(200);

        // Save Berita Update
        $this->actingAs($this->admin)->post(route('admin.berita.save', $berita->id), [
            'judul'   => 'Judul Berita Direvisi',
            'tanggal' => date('Y-m-d'),
            'isi'     => 'Konten berita yang telah direvisi.',
        ])->assertRedirect(route('admin.berita.index'));

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.berita.delete', $berita->id))
            ->assertRedirect(route('admin.berita.index'));
        $this->assertDatabaseMissing('berita', ['id' => $berita->id]);
    }

    /**
     * 6. CRUD Ekstrakurikuler (index, create form, save baru, show, edit form, save update, delete).
     */
    public function test_ekstrakurikuler_crud_operations()
    {
        $guru = Guru::first();

        // Index
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.create'))->assertStatus(200);

        // Save Ekskul Baru
        $responseStore = $this->actingAs($this->admin)->post(route('admin.ekstrakurikuler.save'), [
            'nama_ekskul'    => 'Robotik & AI',
            'id_guru'        => $guru->id,
            'jadwal_latihan' => 'Sabtu, 13.00 - 15.00 WIB',
            'deskripsi'      => 'Pengembangan robotik cerdas berbasis Arduino.',
        ]);

        $responseStore->assertRedirect(route('admin.ekstrakurikuler.index'));
        $ekskul = Ekstrakurikuler::where('nama_ekskul', 'Robotik & AI')->first();
        $this->assertNotNull($ekskul);

        // Show
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.show', $ekskul->id))
            ->assertStatus(200)
            ->assertSee('Robotik & AI');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.edit', $ekskul->id))->assertStatus(200);

        // Save Ekskul Update
        $this->actingAs($this->admin)->post(route('admin.ekstrakurikuler.save', $ekskul->id), [
            'nama_ekskul'    => 'Robotik & IoT',
            'id_guru'        => $guru->id,
            'jadwal_latihan' => 'Sabtu, 14.00 - 16.00 WIB',
            'deskripsi'      => 'Pengembangan Internet of Things.',
        ])->assertRedirect(route('admin.ekstrakurikuler.index'));

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.ekstrakurikuler.delete', $ekskul->id))
            ->assertRedirect(route('admin.ekstrakurikuler.index'));
        $this->assertDatabaseMissing('ekstrakurikuler', ['id' => $ekskul->id]);
    }

    /**
     * 7. CRUD Galeri (index, create form, save baru, show, edit form, save update, delete).
     */
    public function test_galeri_crud_operations()
    {
        Storage::fake('public');

        // Index
        $this->actingAs($this->admin)->get(route('admin.galeri.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.galeri.create'))->assertStatus(200);

        // Save Galeri Baru
        $responseStore = $this->actingAs($this->admin)->post(route('admin.galeri.save'), [
            'judul'      => 'Dokumentasi Uji Coba',
            'kategori'   => 'Foto',
            'tanggal'    => date('Y-m-d'),
            'keterangan' => 'Foto kegiatan belajar di lab komputer.',
            'file'       => UploadedFile::fake()->image('dokumentasi.jpg'),
        ]);

        $responseStore->assertRedirect(route('admin.galeri.index'));
        $galeri = Galeri::where('judul', 'Dokumentasi Uji Coba')->first();
        $this->assertNotNull($galeri);

        // Show
        $this->actingAs($this->admin)->get(route('admin.galeri.show', $galeri->id))
            ->assertStatus(200)
            ->assertSee('Dokumentasi Uji Coba');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.galeri.edit', $galeri->id))->assertStatus(200);

        // Save Galeri Update
        $this->actingAs($this->admin)->post(route('admin.galeri.save', $galeri->id), [
            'judul'      => 'Dokumentasi Uji Coba Update',
            'kategori'   => 'Foto',
            'tanggal'    => date('Y-m-d'),
            'keterangan' => 'Keterangan diperbarui.',
        ])->assertRedirect(route('admin.galeri.index'));

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.galeri.delete', $galeri->id))
            ->assertRedirect(route('admin.galeri.index'));
        $this->assertDatabaseMissing('galeri', ['id' => $galeri->id]);
    }

    /**
     * 8. Middleware Autentikasi melindungi semua route admin.
     */
    public function test_unauthenticated_user_redirected_to_login()
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.guru.index'))->assertRedirect(route('login'));
        $this->get(route('admin.siswa.index'))->assertRedirect(route('login'));
        $this->get(route('admin.berita.index'))->assertRedirect(route('login'));
        $this->get(route('admin.ekstrakurikuler.index'))->assertRedirect(route('login'));
        $this->get(route('admin.galeri.index'))->assertRedirect(route('login'));
        $this->get(route('admin.profil-sekolah'))->assertRedirect(route('login'));
    }
}
