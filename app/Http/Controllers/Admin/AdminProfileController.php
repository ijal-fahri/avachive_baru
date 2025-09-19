<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Menampilkan halaman profil admin.
     */
    public function index()
    {
        // Mengarahkan ke view baru di dalam folder admin/profile
        return view('admin.profile.index');
    }

    /**
     * Memperbarui data profil admin.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('admin.profile.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'edit');
        }

        $dataToUpdate = ['name' => $request->name];

        // Proses upload foto profil jika ada file baru
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada, kecuali itu foto default
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            // Simpan foto baru dan dapatkan path-nya
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $dataToUpdate['profile_photo'] = $path;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
            $dataToUpdate['plain_password'] = $request->password;
        }

        $user->update($dataToUpdate);

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}