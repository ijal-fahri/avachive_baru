<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider; // <-- DITAMBAHKAN
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();

        // --- LOGIKA PENTING UNTUK MULTI-CABANG ---
        if ($user->usertype === 'owner') {
            // Jika owner, biarkan session kosong dulu, akan diisi default di dashboard
            session()->forget('cabang_aktif_id');
        } else {
            // Jika bukan owner (kasir, driver), LANGSUNG KUNCI session ke cabang miliknya
            session(['cabang_aktif_id' => $user->cabang_id]);
        }
        // --- AKHIR LOGIKA PENTING ---

        // Arahkan ke dashboard yang sesuai
        if ($user->usertype === 'owner') {
            // KHUSUS OWNER: Arahkan ke route baru 'owner.dashboard'
            return redirect()->intended(route('owner.dashboard'));
        }
        if ($user->usertype === 'admin') {
            // KHUSUS ADMIN: Tetap ke route 'dashboard' atau ganti ke 'admin.dashboard'
            return redirect()->intended(route('dashboard'));
        }
        if ($user->usertype === 'kasir') {
            return redirect()->intended('/kasir/dashboard');
        }
        if ($user->usertype === 'driver') {
            return redirect()->intended('/driver/dashboard');
        }

        // Fallback jika tidak ada role yang cocok
        return redirect()->intended(RouteServiceProvider::HOME);
    } // <-- KURUNG TUTUP FUNCTION SEHARUSNYA DI SINI

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}