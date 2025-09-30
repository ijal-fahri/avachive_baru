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
use Carbon\Carbon;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar karyawan dan mereset notifikasi.
     */
    public function index()
    {
        $cabangId = Auth::user()->cabang_id;
        $sessionKey = 'last_karyawan_check_admin_' . $cabangId;

        // 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $lastVisit = session($sessionKey);

        // 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session([$sessionKey => now()]);
        
        // 3. Kirim waktu kunjungan terakhir ke view.
        return view('admin.pengguna.index', compact('lastVisit'));
    }

    /**
     * Menyimpan karyawan baru ke cabang admin yang sedang login.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:users,name'],
            'password' => ['required', Rules\Password::defaults()],
            'usertype' => ['required', 'in:kasir,driver'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'usertype' => $request->usertype,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            // [PERBAIKAN] Karyawan baru otomatis masuk ke cabang si admin
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
        if ($pengguna->cabang_id != Auth::user()->cabang_id || !in_array($pengguna->usertype, ['kasir', 'driver'])) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $pengguna->profile_photo_url = $pengguna->profile_photo ? asset('storage/' . $pengguna->profile_photo) : null;
        return response()->json($pengguna);
    }

    /**
     * Memperbarui data karyawan di cabang admin.
     */
    public function update(Request $request, User $pengguna)
    {
        if ($pengguna->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:users,name,' . $pengguna->id],
            'usertype' => 'required|in:kasir,driver',
            'password' => ['nullable', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
        
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
     * Menghapus karyawan dari database.
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
     * Menyediakan data untuk DataTables dan menambahkan penanda "baru".
     */
    public function getKaryawanData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;
        $lastVisitInput = $request->input('last_visit');
        $lastVisitTime = $lastVisitInput ? Carbon::parse($lastVisitInput) : null;

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
            $isNew = $lastVisitTime && Carbon::parse($user->created_at)->isAfter($lastVisitTime);

            $data[] = [
                'no' => $request->start + $key + 1,
                'profile_photo' => $user->profile_photo,
                'name' => $user->name,
                'usertype' => $user->usertype,
                'plain_password' => $user->plain_password ?? 'Belum Diatur',
                'id' => $user->id,
                'is_new' => $isNew,
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

