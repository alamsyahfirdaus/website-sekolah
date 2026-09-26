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
     * 1. Dashboard dapat dibuka dan menampilkan data.
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
     * 2 & 3. Profil sekolah dapat ditampilkan dan diedit.
     */
    public function test_profil_sekolah_can_be_viewed_and_updated()
    {
        $profil = ProfilSekolah::first();

        // Tampil
        $response = $this->actingAs($this->admin)->get(route('admin.profil'));
        $response->assertStatus(200);
        $response->assertSee($profil->nama_sekolah);

        // Edit form
        $responseEdit = $this->actingAs($this->admin)->get(route('profil.edit', $profil->id));
        $responseEdit->assertStatus(200);

        // Update
        $responseUpdate = $this->actingAs($this->admin)->put(route('profil.update', $profil->id), [
            'nama_sekolah'   => 'SMK BISA HEBAT',
            'kepala_sekolah' => 'Dr. Budi Santoso, M.Pd.',
            'npsn'           => '20210890',
            'alamat'         => 'Jl. Pendidikan Baru No. 100',
            'kontak'         => '081234567899',
            'visi_misi'      => 'Visi dan Misi Terkini',
            'tahun_berdiri'  => 2005,
            'deskripsi'      => 'Deskripsi sekolah yang diperbarui.',
        ]);

        $responseUpdate->assertRedirect(route('admin.profil'));
        $responseUpdate->assertSessionHas('success');

        $this->assertDatabaseHas('profil_sekolah', [
            'id'           => $profil->id,
            'nama_sekolah' => 'SMK BISA HEBAT',
        ]);
    }

    /**
     * 4 - 7. CRUD Guru.
     */
    public function test_guru_crud_operations()
    {
        Storage::fake('public');

        // Create form
        $this->actingAs($this->admin)->get(route('guru.create'))->assertStatus(200);

        // Store
        $foto = UploadedFile::fake()->image('guru_test.jpg');
        $responseStore = $this->actingAs($this->admin)->post(route('guru.store'), [
            'nama_guru' => 'Guru Penguji, S.Pd.',
            'nip'       => '199901012022011',
            'mapel'     => 'Teknik Komputer Jaringan',
            'foto'      => $foto,
        ]);

        $responseStore->assertRedirect(route('admin.guru'));
        $responseStore->assertSessionHas('success');

        $guru = Guru::where('nip', '199901012022011')->first();
        $this->assertNotNull($guru);

        // Detail (Show)
        $this->actingAs($this->admin)->get(route('guru.show', $guru->id))
            ->assertStatus(200)
            ->assertSee('Guru Penguji, S.Pd.');

        // Edit form
        $this->actingAs($this->admin)->get(route('guru.edit', $guru->id))->assertStatus(200);

        // Update
        $responseUpdate = $this->actingAs($this->admin)->put(route('guru.update', $guru->id), [
            'nama_guru' => 'Guru Penguji Update, M.Pd.',
            'nip'       => '199901012022011',
            'mapel'     => 'Pemrograman Web',
        ]);

        $responseUpdate->assertRedirect(route('admin.guru'));
        $this->assertDatabaseHas('guru', [
            'id'        => $guru->id,
            'nama_guru' => 'Guru Penguji Update, M.Pd.',
        ]);

        // Destroy
        $responseDelete = $this->actingAs($this->admin)->delete(route('guru.destroy', $guru->id));
        $responseDelete->assertRedirect(route('admin.guru'));
        $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
    }

    /**
     * 8 - 11. CRUD Siswa.
     */
    public function test_siswa_crud_operations()
    {
        // Create form
        $this->actingAs($this->admin)->get(route('siswa.create'))->assertStatus(200);

        // Store
        $responseStore = $this->actingAs($this->admin)->post(route('siswa.store'), [
            'nisn'          => '9998887771',
            'nama_siswa'    => 'Siswa Penguji',
            'jenis_kelamin' => 'Laki-Laki',
            'tahun_masuk'   => 2024,
        ]);

        $responseStore->assertRedirect(route('admin.siswa'));
        $siswa = Siswa::where('nisn', '9998887771')->first();
        $this->assertNotNull($siswa);

        // Show
        $this->actingAs($this->admin)->get(route('siswa.show', $siswa->id))
            ->assertStatus(200)
            ->assertSee('Siswa Penguji');

        // Edit
        $this->actingAs($this->admin)->get(route('siswa.edit', $siswa->id))->assertStatus(200);

        // Update
        $this->actingAs($this->admin)->put(route('siswa.update', $siswa->id), [
            'nisn'          => '9998887771',
            'nama_siswa'    => 'Siswa Penguji Berubah',
            'jenis_kelamin' => 'Laki-Laki',
            'tahun_masuk'   => 2024,
        ])->assertRedirect(route('admin.siswa'));

        $this->assertDatabaseHas('siswa', [
            'id'         => $siswa->id,
            'nama_siswa' => 'Siswa Penguji Berubah',
        ]);

        // Destroy
        $this->actingAs($this->admin)->delete(route('siswa.destroy', $siswa->id))
            ->assertRedirect(route('admin.siswa'));
        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }

    /**
     * 12 - 15. CRUD Berita.
     */
    public function test_berita_crud_operations()
    {
        Storage::fake('public');

        // Store
        $responseStore = $this->actingAs($this->admin)->post(route('berita.store'), [
            'judul'   => 'Judul Berita Uji Coba',
            'tanggal' => date('Y-m-d'),
            'isi'     => 'Ini adalah konten berita untuk pengujian sistem otomatis.',
            'gambar'  => UploadedFile::fake()->image('berita_cover.jpg'),
        ]);

        $responseStore->assertRedirect(route('admin.berita'));
        $berita = Berita::where('judul', 'Judul Berita Uji Coba')->first();
        $this->assertNotNull($berita);

        // Show
        $this->actingAs($this->admin)->get(route('berita.show', $berita->id))
            ->assertStatus(200)
            ->assertSee('Judul Berita Uji Coba');

        // Edit
        $this->actingAs($this->admin)->get(route('berita.edit', $berita->id))->assertStatus(200);

        // Update
        $this->actingAs($this->admin)->put(route('berita.update', $berita->id), [
            'judul'   => 'Judul Berita Direvisi',
            'tanggal' => date('Y-m-d'),
            'isi'     => 'Konten berita yang telah direvisi.',
        ])->assertRedirect(route('admin.berita'));

        // Destroy
        $this->actingAs($this->admin)->delete(route('berita.destroy', $berita->id))
            ->assertRedirect(route('admin.berita'));
        $this->assertDatabaseMissing('berita', ['id' => $berita->id]);
    }

    /**
     * 16 - 19. CRUD Ekstrakurikuler.
     */
    public function test_ekstrakurikuler_crud_operations()
    {
        $guru = Guru::first();

        // Store
        $responseStore = $this->actingAs($this->admin)->post(route('ekstrakurikuler.store'), [
            'nama_ekskul'    => 'Robotik & AI',
            'id_guru'        => $guru->id,
            'jadwal_latihan' => 'Sabtu, 13.00 - 15.00 WIB',
            'deskripsi'      => 'Pengembangan robotik cerdas berbasis Arduino.',
        ]);

        $responseStore->assertRedirect(route('admin.ekstrakurikuler'));
        $ekskul = Ekstrakurikuler::where('nama_ekskul', 'Robotik & AI')->first();
        $this->assertNotNull($ekskul);

        // Show
        $this->actingAs($this->admin)->get(route('ekstrakurikuler.show', $ekskul->id))
            ->assertStatus(200)
            ->assertSee('Robotik & AI');

        // Update
        $this->actingAs($this->admin)->put(route('ekstrakurikuler.update', $ekskul->id), [
            'nama_ekskul'    => 'Robotik & IoT',
            'id_guru'        => $guru->id,
            'jadwal_latihan' => 'Sabtu, 14.00 - 16.00 WIB',
            'deskripsi'      => 'Pengembangan Internet of Things.',
        ])->assertRedirect(route('admin.ekstrakurikuler'));

        // Destroy
        $this->actingAs($this->admin)->delete(route('ekstrakurikuler.destroy', $ekskul->id))
            ->assertRedirect(route('admin.ekstrakurikuler'));
        $this->assertDatabaseMissing('ekstrakurikuler', ['id' => $ekskul->id]);
    }

    /**
     * 20 - 23. CRUD Galeri.
     */
    public function test_galeri_crud_operations()
    {
        Storage::fake('public');

        // Store
        $responseStore = $this->actingAs($this->admin)->post(route('galeri.store'), [
            'judul'      => 'Dokumentasi Uji Coba',
            'kategori'   => 'Foto',
            'tanggal'    => date('Y-m-d'),
            'keterangan' => 'Foto kegiatan belajar di lab komputer.',
            'file'       => UploadedFile::fake()->image('dokumentasi.jpg'),
        ]);

        $responseStore->assertRedirect(route('admin.galeri'));
        $galeri = Galeri::where('judul', 'Dokumentasi Uji Coba')->first();
        $this->assertNotNull($galeri);

        // Show
        $this->actingAs($this->admin)->get(route('galeri.show', $galeri->id))
            ->assertStatus(200)
            ->assertSee('Dokumentasi Uji Coba');

        // Update
        $this->actingAs($this->admin)->put(route('galeri.update', $galeri->id), [
            'judul'      => 'Dokumentasi Uji Coba Update',
            'kategori'   => 'Foto',
            'tanggal'    => date('Y-m-d'),
            'keterangan' => 'Keterangan diperbarui.',
        ])->assertRedirect(route('admin.galeri'));

        // Destroy
        $this->actingAs($this->admin)->delete(route('galeri.destroy', $galeri->id))
            ->assertRedirect(route('admin.galeri'));
        $this->assertDatabaseMissing('galeri', ['id' => $galeri->id]);
    }

    /**
     * 28. Fitur Pencarian.
     */
    public function test_search_feature_on_modules()
    {
        $this->actingAs($this->admin)
            ->get(route('admin.guru', ['search' => 'Ahmad']))
            ->assertStatus(200)
            ->assertSee('Ahmad');

        $this->actingAs($this->admin)
            ->get(route('admin.siswa', ['search' => 'Farhan']))
            ->assertStatus(200)
            ->assertSee('Farhan');
    }
}
