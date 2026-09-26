<?php

namespace App\Providers;

use App\Models\ProfilSekolah;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Membagikan data Profil Sekolah ke seluruh view secara global (Single Source of Truth).
        // Siswa SMK dapat memahami bahwa View::composer(*) membuat variabel $profilSekolah
        // otomatis tersedia di semua file Blade tanpa perlu query berulang di setiap controller/view.
        View::composer('*', function ($view) {
            static $profilSekolah = null;

            // Mengambil data profil sekolah dari database hanya 1 kali per request agar ringan dan efisien
            if ($profilSekolah === null) {
                try {
                    if (Schema::hasTable('profil_sekolah')) {
                        $profilSekolah = ProfilSekolah::first();
                    }
                } catch (\Exception $e) {
                    $profilSekolah = null;
                }
            }

            $view->with('profilSekolah', $profilSekolah);
        });
    }
}
