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
use Illuminate\Support\Facades\Crypt;
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

        // Verifikasi bahwa nama sekolah yang diperbarui otomatis muncul secara dinamis
        // pada title browser, sidebar brand, footer, halaman login, dan halaman publik
        $dashboardResponse = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $dashboardResponse->assertSee('SMK BISA HEBAT | Dashboard');
        $dashboardResponse->assertSee('SMK BISA HEBAT');

        // Pastikan logout terlebih dahulu agar route('login') tidak dialihkan oleh middleware guest
        auth()->logout();
        $loginResponse = $this->get(route('login'));
        $loginResponse->assertStatus(200);
        $loginResponse->assertSee('SMK BISA HEBAT');

        $publicResponse = $this->get(route('public.dashboard'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('SMK BISA HEBAT');
    }

    /**
     * 3. CRUD Guru (index, addEdit form, save baru, show, addEdit update, save update, delete).
     */
    public function test_guru_crud_operations()
    {
        Storage::fake('public');

        // Index
        $this->actingAs($this->admin)->get(route('admin.guru.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.guru.addEdit'))->assertStatus(200);

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
        $this->actingAs($this->admin)->get(route('admin.guru.show', Crypt::encrypt($guru->id)))
            ->assertStatus(200)
            ->assertSee('Guru Penguji, S.Pd.');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.guru.addEdit', Crypt::encrypt($guru->id)))->assertStatus(200);

        // Save Guru Update
        $responseUpdate = $this->actingAs($this->admin)->post(route('admin.guru.save', Crypt::encrypt($guru->id)), [
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
        $responseDelete = $this->actingAs($this->admin)->delete(route('admin.guru.delete', Crypt::encrypt($guru->id)));
        $responseDelete->assertRedirect(route('admin.guru.index'));
        $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
    }

    /**
     * 4. CRUD Siswa (index, addEdit form, save baru, show, addEdit update, save update, delete).
     */
    public function test_siswa_crud_operations()
    {
        // Index
        $this->actingAs($this->admin)->get(route('admin.siswa.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.siswa.addEdit'))->assertStatus(200);

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
        $this->actingAs($this->admin)->get(route('admin.siswa.show', Crypt::encrypt($siswa->id)))
            ->assertStatus(200)
            ->assertSee('Siswa Penguji');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.siswa.addEdit', Crypt::encrypt($siswa->id)))->assertStatus(200);

        // Save Siswa Update
        $this->actingAs($this->admin)->post(route('admin.siswa.save', Crypt::encrypt($siswa->id)), [
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
        $this->actingAs($this->admin)->delete(route('admin.siswa.delete', Crypt::encrypt($siswa->id)))
            ->assertRedirect(route('admin.siswa.index'));
        $this->assertDatabaseMissing('siswa', ['id' => $siswa->id]);
    }

    /**
     * 5. CRUD Berita (index, addEdit form, save baru, show, addEdit update, save update, delete).
     */
    public function test_berita_crud_operations()
    {
        Storage::fake('public');

        // Index
        $this->actingAs($this->admin)->get(route('admin.berita.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.berita.addEdit'))->assertStatus(200);

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
        $this->actingAs($this->admin)->get(route('admin.berita.show', Crypt::encrypt($berita->id)))
            ->assertStatus(200)
            ->assertSee('Judul Berita Uji Coba');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.berita.addEdit', Crypt::encrypt($berita->id)))->assertStatus(200);

        // Save Berita Update
        $this->actingAs($this->admin)->post(route('admin.berita.save', Crypt::encrypt($berita->id)), [
            'judul'   => 'Judul Berita Direvisi',
            'tanggal' => date('Y-m-d'),
            'isi'     => 'Konten berita yang telah direvisi.',
        ])->assertRedirect(route('admin.berita.index'));

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.berita.delete', Crypt::encrypt($berita->id)))
            ->assertRedirect(route('admin.berita.index'));
        $this->assertDatabaseMissing('berita', ['id' => $berita->id]);
    }

    /**
     * 6. CRUD Ekstrakurikuler (index, addEdit form, save baru, show, addEdit update, save update, delete).
     */
    public function test_ekstrakurikuler_crud_operations()
    {
        $guru = Guru::first();

        // Index
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.addEdit'))->assertStatus(200);

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
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.show', Crypt::encrypt($ekskul->id)))
            ->assertStatus(200)
            ->assertSee('Robotik & AI');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.addEdit', Crypt::encrypt($ekskul->id)))->assertStatus(200);

        // Save Ekskul Update
        $this->actingAs($this->admin)->post(route('admin.ekstrakurikuler.save', Crypt::encrypt($ekskul->id)), [
            'nama_ekskul'    => 'Robotik & IoT',
            'id_guru'        => $guru->id,
            'jadwal_latihan' => 'Sabtu, 14.00 - 16.00 WIB',
            'deskripsi'      => 'Pengembangan Internet of Things.',
        ])->assertRedirect(route('admin.ekstrakurikuler.index'));

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.ekstrakurikuler.delete', Crypt::encrypt($ekskul->id)))
            ->assertRedirect(route('admin.ekstrakurikuler.index'));
        $this->assertDatabaseMissing('ekstrakurikuler', ['id' => $ekskul->id]);
    }

    /**
     * 7. CRUD Galeri (index, addEdit form, save baru, show, addEdit update, save update, delete).
     */
    public function test_galeri_crud_operations()
    {
        Storage::fake('public');

        // Index
        $this->actingAs($this->admin)->get(route('admin.galeri.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.galeri.addEdit'))->assertStatus(200);

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
        $this->actingAs($this->admin)->get(route('admin.galeri.show', Crypt::encrypt($galeri->id)))
            ->assertStatus(200)
            ->assertSee('Dokumentasi Uji Coba');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.galeri.addEdit', Crypt::encrypt($galeri->id)))->assertStatus(200);

        // Save Galeri Update
        $this->actingAs($this->admin)->post(route('admin.galeri.save', Crypt::encrypt($galeri->id)), [
            'judul'      => 'Dokumentasi Uji Coba Update',
            'kategori'   => 'Foto',
            'tanggal'    => date('Y-m-d'),
            'keterangan' => 'Keterangan diperbarui.',
        ])->assertRedirect(route('admin.galeri.index'));

        // Hapus
        $this->actingAs($this->admin)->delete(route('admin.galeri.delete', Crypt::encrypt($galeri->id)))
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
        $this->get(route('admin.user.index'))->assertRedirect(route('login'));
    }

    /**
     * 9. CRUD User (index, addEdit form, save baru, show, addEdit update, save update, delete, proteksi hapus diri sendiri).
     */
    public function test_user_crud_operations()
    {
        // Index
        $this->actingAs($this->admin)->get(route('admin.user.index'))->assertStatus(200);

        // Form Tambah
        $this->actingAs($this->admin)->get(route('admin.user.addEdit'))->assertStatus(200);

        // Save User Baru
        $responseStore = $this->actingAs($this->admin)->post(route('admin.user.save'), [
            'name'     => 'Staff Tata Usaha',
            'username' => 'staf_tu',
            'email'    => 'staf@sekolah.sch.id',
            'role'     => 'Operator',
            'password' => 'secret123',
        ]);

        $responseStore->assertRedirect(route('admin.user.index'));
        $responseStore->assertSessionHas('success');

        $user = User::where('email', 'staf@sekolah.sch.id')->first();
        $this->assertNotNull($user);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('secret123', $user->password));

        // Detail
        $this->actingAs($this->admin)->get(route('admin.user.show', Crypt::encrypt($user->id)))
            ->assertStatus(200)
            ->assertSee('Staff Tata Usaha');

        // Form Edit
        $this->actingAs($this->admin)->get(route('admin.user.addEdit', Crypt::encrypt($user->id)))->assertStatus(200);

        // Save User Update (tanpa ganti password)
        $oldPasswordHash = $user->password;
        $responseUpdate = $this->actingAs($this->admin)->post(route('admin.user.save', Crypt::encrypt($user->id)), [
            'name'     => 'Staff Tata Usaha Update',
            'username' => 'staf_tu',
            'email'    => 'staf@sekolah.sch.id',
            'role'     => 'Operator',
            'password' => '', // kosongkan, password lama tidak boleh berubah
        ]);

        $responseUpdate->assertRedirect(route('admin.user.index'));
        $user->refresh();
        $this->assertEquals('Staff Tata Usaha Update', $user->name);
        $this->assertEquals($oldPasswordHash, $user->password);

        // Proteksi: Admin tidak boleh menghapus akun dirinya sendiri yang sedang login
        $responseSelfDelete = $this->actingAs($this->admin)->delete(route('admin.user.delete', Crypt::encrypt($this->admin->id)));
        $responseSelfDelete->assertRedirect(route('admin.user.index'));
        $responseSelfDelete->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);

        // Hapus user yang baru dibuat
        $responseDelete = $this->actingAs($this->admin)->delete(route('admin.user.delete', Crypt::encrypt($user->id)));
        $responseDelete->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * 10. Pembatasan Hak Akses Berdasarkan Role (Admin vs Operator).
     */
    public function test_role_access_control()
    {
        $operator = User::where('role', 'Operator')->first();

        // 1. Admin memiliki akses penuh (HTTP 200)
        $this->actingAs($this->admin)->get(route('admin.dashboard'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.profil-sekolah'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.guru.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.siswa.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.berita.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.ekstrakurikuler.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.galeri.index'))->assertStatus(200);
        $this->actingAs($this->admin)->get(route('admin.user.index'))->assertStatus(200);

        // 2. Operator BISA mengakses fitur operasional sekolah (HTTP 200)
        $this->actingAs($operator)->get(route('admin.dashboard'))->assertStatus(200);
        $this->actingAs($operator)->get(route('admin.profil-sekolah'))->assertStatus(200);
        $this->actingAs($operator)->get(route('admin.berita.index'))->assertStatus(200);
        $this->actingAs($operator)->get(route('admin.ekstrakurikuler.index'))->assertStatus(200);
        $this->actingAs($operator)->get(route('admin.galeri.index'))->assertStatus(200);

        // 3. Operator DITOLAK (HTTP 403) saat mencoba mengakses Guru, Siswa, dan User
        $this->actingAs($operator)->get(route('admin.guru.index'))->assertStatus(403);
        $this->actingAs($operator)->get(route('admin.siswa.index'))->assertStatus(403);
        $this->actingAs($operator)->get(route('admin.user.index'))->assertStatus(403);
    }

    /**
     * 11. Memastikan implementasi Responsive DataTables tersedia di seluruh tabel CRUD.
     */
    public function test_datatables_responsive_markup_on_all_crud_tables()
    {
        $routes = [
            'admin.guru.index'           => 'tableGuru',
            'admin.siswa.index'          => 'tableSiswa',
            'admin.berita.index'         => 'tableBerita',
            'admin.ekstrakurikuler.index'=> 'tableEkstrakurikuler',
            'admin.galeri.index'         => 'tableGaleri',
            'admin.user.index'           => 'tableUser',
        ];

        foreach ($routes as $routeName => $tableId) {
            $response = $this->actingAs($this->admin)->get(route($routeName));
            $response->assertStatus(200);

            // Memastikan CSS dan JS DataTables Responsive dimuat
            $response->assertSee('responsive.bootstrap5.min.css');
            $response->assertSee('dataTables.responsive.min.js');
            $response->assertSee('responsive.bootstrap5.min.js');

            // Memastikan atribut table responsive aktif
            $response->assertSee('id="' . $tableId . '"', false);
            $response->assertSee('responsive nowrap', false);
            $response->assertSee('data-priority="1"', false);

            // Memastikan tombol aksi responsif untuk mobile & desktop
            $response->assertSee('btn-aksi-group', false);
            $response->assertSee('d-none d-md-inline', false);

            // Memastikan konfigurasi JavaScript mengaktifkan responsive
            $response->assertSee('responsive: true', false);
            $response->assertSee('autoWidth: false', false);
        }
    }
}

