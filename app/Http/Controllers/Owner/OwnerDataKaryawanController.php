<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OwnerDataKaryawanController extends Controller
{
    /**
     * Menampilkan daftar karyawan (kasir & driver).
     */
    public function index(Request $request)
    {
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $selectedCabang = $request->input('cabang_id');
        $selectedRole = $request->input('usertype');

        $karyawanQuery = User::whereIn('usertype', ['kasir', 'driver'])->with('cabang');

        if ($selectedCabang && $selectedCabang !== 'semua') {
            $karyawanQuery->where('cabang_id', $selectedCabang);
        }
        if ($selectedRole && $selectedRole !== 'semua') {
            $karyawanQuery->where('usertype', $selectedRole);
        }

        $karyawans = $karyawanQuery->latest()->get()->groupBy('cabang.nama_cabang');

        return view('owner.datakaryawan.index', compact('karyawans', 'cabangs', 'selectedCabang', 'selectedRole'));
    }

    /**
     * Menyimpan karyawan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'usertype' => ['required', 'string', 'in:kasir,driver'],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'usertype' => $request->usertype,
            'cabang_id' => $request->cabang_id,
        ]);

        return redirect()->route('owner.datakaryawan.index')->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan data karyawan spesifik (via AJAX/Fetch).
     */
    public function show(User $datakaryawan)
    {
        if (!in_array($datakaryawan->usertype, ['kasir', 'driver'])) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($datakaryawan);
    }

    /**
     * Memperbarui data karyawan di database.
     */
    public function update(Request $request, User $datakaryawan)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $datakaryawan->id],
            'usertype' => ['required', 'string', 'in:kasir,driver'],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        $datakaryawan->update([
            'name' => $request->name,
            'usertype' => $request->usertype,
            'cabang_id' => $request->cabang_id,
        ]);

        if ($request->filled('password')) {
            $datakaryawan->update([
                'password' => Hash::make($request->password),
                'plain_password' => $request->password,
            ]);
        }

        return redirect()->route('owner.datakaryawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus karyawan dari database.
     */
    public function destroy(User $datakaryawan)
    {
        try {
            if (!in_array($datakaryawan->usertype, ['kasir', 'driver'])) {
                return back()->with('error', 'Gagal menghapus pengguna.');
            }
            $datakaryawan->delete();
            return redirect()->route('owner.datakaryawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus karyawan.');
        }
    }
}
