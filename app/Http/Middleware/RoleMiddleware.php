<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Memeriksa apakah user yang sedang login memiliki role yang diizinkan.
     * Sederhana dan mudah dipahami siswa SMK.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Pastikan user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // 2. Cek apakah role user saat ini sesuai dengan role yang dipersyaratkan
        // Gunakan strcasecmp agar toleran terhadap variasi huruf besar/kecil ('admin' / 'Admin')
        if (strcasecmp(auth()->user()->role, $role) !== 0) {
            // Jika role tidak sesuai, tolak akses dengan kode HTTP 403
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
