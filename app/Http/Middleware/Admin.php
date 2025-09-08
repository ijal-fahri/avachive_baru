<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek dulu apakah user sudah login DAN rolenya adalah 'admin'.
        if (Auth::check() && Auth::user()->usertype === 'admin') {
            // 2. Jika benar, izinkan akses ke halaman selanjutnya.
            return $next($request);
        }

        // 3. Jika user belum login atau rolenya bukan admin, tolak akses.
        abort(403, 'AKSES DITOLAK. HALAMAN INI KHUSUS UNTUK ADMIN.');
    }
}