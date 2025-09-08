<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar karyawan (kasir & driver) HANYA dari cabang admin.
     */
    public function index()
    {
        $cabangId = Auth::user()->cabang_id;
        $users = User::where('cabang_id', $cabangId)
                     ->whereIn('usertype', ['kasir', 'driver'])
                     ->latest()
                     ->get();
                     
        return view('admin.pengguna.index', compact('users'));
    }

    /**
     * Menyimpan karyawan baru dan OTOMATIS mengaitkannya dengan cabang admin.
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Aturan 'confirmed' dihapus dari validasi password
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()], // 'confirmed' dihapus
            'usertype' => ['required', 'in:kasir,driver'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('datauser')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'tambah');
        }

        User::create([
            'name' => $request->name,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'cabang_id' => Auth::user()->cabang_id,
        ]);

        return redirect()->route('datauser')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Memperbarui data karyawan, memastikan hanya bisa di cabang admin.
     */
    public function update(Request $request, User $pengguna)
    {
        if ($pengguna->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }

        // PERBAIKAN: Aturan 'confirmed' dihapus dari validasi password
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100', 'unique:users,name,' . $pengguna->id],
            'usertype' => 'required|in:kasir,driver',
            'password' => ['nullable', Rules\Password::defaults()], // 'confirmed' dihapus
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('datauser')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'edit')
                ->with('error_id', $pengguna->id);
        }

        $data = [
            'name' => $request->name,
            'usertype' => $request->usertype,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['plain_password'] = $request->password;
        }

        $pengguna->update($data);

        return redirect()->route('datauser')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus karyawan, memastikan hanya bisa di cabang admin.
     */
    public function destroy(User $pengguna)
    {
        if ($pengguna->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $pengguna->delete();
        return redirect()->route('datauser')->with('success', 'Karyawan berhasil dihapus.');
    }
}

