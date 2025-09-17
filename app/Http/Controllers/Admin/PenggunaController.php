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
                     
        // Ganti nama view jika nama file Anda berbeda, misal: 'admin.karyawan.index'
        return view('admin.pengguna.index', compact('users'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('datauser')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'tambah')
                ->with('error_modal_title', 'Gagal Menambah Karyawan')
                ->with('error_modal_action', route('pengguna.store'))
                ->with('error_modal_method', 'POST');
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

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:100', 'unique:users,name,' . $pengguna->id],
            'usertype' => 'required|in:kasir,driver',
            'password' => ['nullable', Rules\Password::defaults()],
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('datauser')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'edit')
                ->with('error_modal_title', 'Gagal Mengedit Karyawan')
                ->with('error_modal_action', route('pengguna.update', $pengguna->id))
                ->with('error_modal_method', 'PUT')
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


    // ====================================================================
    // [BARU] METHOD UNTUK MELAYANI AJAX DATATABLES
    // ====================================================================

    /**
     * Menyediakan data untuk DataTables dengan server-side processing.
     */
    public function getKaryawanData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;

        // Query dasar hanya untuk karyawan di cabang ini (bukan admin/owner)
        $query = User::where('cabang_id', $cabangId)
                     ->whereIn('usertype', ['kasir', 'driver']);

        // Filter berdasarkan role (dari tab filter)
        if ($request->filled('role')) {
            $query->where('usertype', $request->role);
        }

        // Filter berdasarkan pencarian DataTables
        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where('name', 'like', '%' . $searchValue . '%');
        }

        // Hitung total record sebelum paginasi
        $recordsFiltered = $query->count();
        
        // Ambil data sesuai paginasi dari DataTables
        $users = $query->skip($request->start)
                       ->take($request->length)
                       ->latest() // Urutkan berdasarkan yang terbaru
                       ->get();

        // Format data untuk respons JSON
        $data = [];
        foreach ($users as $key => $user) {
            $data[] = [
                'no' => $request->start + $key + 1,
                'name' => $user->name,
                'usertype' => $user->usertype,
                'plain_password' => $user->plain_password ?? 'Belum Diatur',
                'id' => $user->id, // Kirim ID untuk tombol aksi
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