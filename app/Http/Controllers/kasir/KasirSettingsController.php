<?php

namespace App\Http\Controllers\kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class KasirSettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan profil
     */
    public function index()
    {
        $user = Auth::user(); // ambil user yang login
        return view('kasir.pengaturan', compact('user'));
    }

    /**
     * Update profil user
     */
    public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|string|min:6|confirmed',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user->name = $request->name;

    // update password jika diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
        $user->plain_password = $request->password;
    }

    // update foto profil jika ada
    if ($request->hasFile('profile_photo')) {
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/profile_photos'), $filename);

        // hapus foto lama jika ada
        if ($user->profile_photo && file_exists(public_path('uploads/profile_photos/' . $user->profile_photo))) {
            unlink(public_path('uploads/profile_photos/' . $user->profile_photo));
        }

        $user->profile_photo = $filename;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
}

}
