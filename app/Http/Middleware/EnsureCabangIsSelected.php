<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Cabang;

class EnsureCabangIsSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Logika ini hanya berjalan untuk 'owner'
        if ($user && $user->usertype === 'owner') {
            
            // Cek apakah session cabang aktif BELUM ada
            if (!session()->has('cabang_aktif_id')) {
                
                // Jika belum ada, ambil cabang pertama dari database
                $cabangPertama = Cabang::first();

                // Jika ada cabang di database, set sebagai cabang aktif
                if ($cabangPertama) {
                    session(['cabang_aktif_id' => $cabangPertama->id]);
                }
            }
        }

        // Lanjutkan ke halaman yang dituju
        return $next($request);
    }
}