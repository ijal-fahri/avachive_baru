<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar karyawan (kasir & driver) HANYA dari cabang admin.
     */
    public function index()
    {
        return view('admin.pengguna.index');
    }

    /**
     * Menyimpan karyawan baru dan OTOMATIS mengaitkannya dengan cabang admin.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100', 'unique:users,name'],
            'password' => ['required', Rules\Password::defaults()],
            'usertype' => ['required', 'in:kasir,driver'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('datauser')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'tambah');
        }

        $data = [
            'name' => $request->name,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'cabang_id' => Auth::user()->cabang_id,
        ];

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
        }

        User::create($data);

        return redirect()->route('datauser')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Menampilkan data karyawan spesifik (untuk modal edit).
     */
    public function show(User $pengguna)
    {
        // Pastikan admin hanya bisa melihat karyawan di cabangnya sendiri
        if ($pengguna->cabang_id != Auth::user()->cabang_id || !in_array($pengguna->usertype, ['kasir', 'driver'])) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $pengguna->profile_photo_url = $pengguna->profile_photo ? asset('storage/' . $pengguna->profile_photo) : null;
        return response()->json($pengguna);
    }


    /**
     * Memperbarui data karyawan, memastikan hanya bisa di cabang admin.
     */
    public function update(Request $request, User $pengguna)
    {
        if ($pengguna->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100', 'unique:users,name,' . $pengguna->id],
            'usertype' => 'required|in:kasir,driver',
            'password' => ['nullable', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
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

        if ($request->hasFile('profile_photo')) {
            if ($pengguna->profile_photo) {
                Storage::disk('public')->delete($pengguna->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
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

        if ($pengguna->profile_photo) {
            Storage::disk('public')->delete($pengguna->profile_photo);
        }

        $pengguna->delete();
        return redirect()->route('datauser')->with('success', 'Karyawan berhasil dihapus.');
    }

    /**
     * Menyediakan data untuk DataTables dengan server-side processing.
     */
    public function getKaryawanData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;

        $query = User::where('cabang_id', $cabangId)
                       ->whereIn('usertype', ['kasir', 'driver']);

        if ($request->filled('role')) {
            $query->where('usertype', $request->role);
        }

        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where('name', 'like', '%' . $searchValue . '%');
        }

        $recordsFiltered = $query->count();
        
        $users = $query->skip($request->start)
                        ->take($request->length)
                        ->latest()
                        ->get();

        $data = [];
        foreach ($users as $key => $user) {
            $data[] = [
                'no' => $request->start + $key + 1,
                'profile_photo' => $user->profile_photo,
                'name' => $user->name,
                'usertype' => $user->usertype,
                'plain_password' => $user->plain_password ?? 'Belum Diatur',
                'id' => $user->id,
            ];
        }
        
        $totalRecords = User::where('cabang_id', $cabangId)->whereIn('usertype', ['kasir', 'driver'])->count();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}