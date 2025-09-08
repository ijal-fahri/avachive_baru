<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil owner.
     */
    public function index()
    {
        return view('owner.profile.index');
    }

    /**
     * Memperbarui password owner.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Validasi input (tanpa current_password)
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Jika validasi gagal, kembali dengan error dan sinyal untuk membuka modal
        if ($validator->fails()) {
            return redirect()->route('owner.profile')
                ->withErrors($validator)
                ->with('error_modal', 'password');
        }

        // Update password jika validasi berhasil
        $user->update([
            'password' => Hash::make($request->password),
            'plain_password' => $request->password, // Update juga plain_password jika Anda menggunakannya
        ]);

        return redirect()->route('owner.profile')->with('success', 'Password berhasil diperbarui!');
    }
}

