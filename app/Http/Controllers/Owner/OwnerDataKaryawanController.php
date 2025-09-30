<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth; // Import Auth
use Carbon\Carbon; // Import Carbon

class OwnerDataKaryawanController extends Controller
{
    /**
     * Menampilkan halaman daftar karyawan dan mereset notifikasi.
     */
    public function index(Request $request)
    {
        // [LOGIKA DIPERBARUI]
        // 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $lastVisit = session('last_karyawan_check');

        // 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session(['last_karyawan_check' => now()]);

        $cabangs = Cabang::orderBy('nama_cabang')->get();
        // 3. Kirim waktu kunjungan terakhir ke view
        return view('owner.datakaryawan.index', compact('cabangs', 'lastVisit'));
    }

    /**
     * Menyimpan karyawan baru ke database. (Tidak diubah)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'usertype' => ['required', 'string', 'in:kasir,driver'],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['required', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'usertype' => $request->usertype,
            'cabang_id' => $request->cabang_id,
        ];

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
        }

        User::create($data);

        return redirect()->route('owner.datakaryawan.index')->with('success', 'Karyawan baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan data karyawan spesifik (via AJAX/Fetch). (Tidak diubah)
     */
    public function show(User $datakaryawan)
    {
        if (!in_array($datakaryawan->usertype, ['kasir', 'driver'])) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $datakaryawan->profile_photo_url = $datakaryawan->profile_photo ? asset('storage/' . $datakaryawan->profile_photo) : null;
        return response()->json($datakaryawan);
    }

    /**
     * Memperbarui data karyawan di database. (Tidak diubah)
     */
    public function update(Request $request, User $datakaryawan)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $datakaryawan->id],
            'usertype' => ['required', 'string', 'in:kasir,driver'],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['nullable', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $dataToUpdate = [
            'name' => $request->name,
            'usertype' => $request->usertype,
            'cabang_id' => $request->cabang_id,
        ];

        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
            $dataToUpdate['plain_password'] = $request->password;
        }

        if ($request->hasFile('profile_photo')) {
            if ($datakaryawan->profile_photo) {
                Storage::disk('public')->delete($datakaryawan->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $dataToUpdate['profile_photo'] = $path;
        }

        $datakaryawan->update($dataToUpdate);

        return redirect()->route('owner.datakaryawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Menghapus karyawan dari database. (Tidak diubah)
     */
    public function destroy(User $datakaryawan)
    {
        try {
            if (!in_array($datakaryawan->usertype, ['kasir', 'driver'])) {
                return back()->with('error', 'Gagal menghapus pengguna.');
            }
            if ($datakaryawan->profile_photo) {
                Storage::disk('public')->delete($datakaryawan->profile_photo);
            }
            $datakaryawan->delete();
            return redirect()->route('owner.datakaryawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus karyawan.');
        }
    }

    /**
     * Menyediakan data karyawan untuk DataTables dan menambahkan penanda "baru".
     */
    public function getKaryawanData(Request $request)
    {
        // [LOGIKA BARU] Ambil waktu kunjungan terakhir dari request AJAX
        $lastVisitInput = $request->input('last_visit');
        $lastVisitTime = $lastVisitInput ? Carbon::parse($lastVisitInput) : null;
        
        $query = User::with('cabang')->whereIn('usertype', ['kasir', 'driver']);

        if ($request->filled('cabang_id') && $request->cabang_id != 'semua') {
            $query->where('cabang_id', $request->cabang_id);
        }
        if ($request->filled('usertype') && $request->usertype != 'semua') {
            $query->where('usertype', $request->usertype);
        }

        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhere('usertype', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('cabang', function($cq) use ($searchValue) {
                      $cq->where('nama_cabang', 'like', '%' . $searchValue . '%');
                  });
            });
        }

        $recordsFiltered = $query->count();
        
        $karyawans = $query->skip($request->start)
                             ->take($request->length)
                             ->latest()
                             ->get();

        $data = [];
        foreach ($karyawans as $key => $karyawan) {
            // [LOGIKA BARU] Tentukan apakah karyawan ini "baru"
            $isNew = $lastVisitTime && Carbon::parse($karyawan->created_at)->isAfter($lastVisitTime);

            $data[] = [
                'no' => $request->start + $key + 1,
                'profile_photo' => $karyawan->profile_photo,
                'name' => $karyawan->name,
                'nama_cabang' => $karyawan->cabang->nama_cabang ?? 'Tidak Terkait',
                'usertype' => $karyawan->usertype,
                'plain_password' => $karyawan->plain_password,
                'id' => $karyawan->id,
                'is_new' => $isNew, // <-- Tambahkan penanda "baru" ke data JSON
            ];
        }
        
        $totalRecords = User::whereIn('usertype', ['kasir', 'driver'])->count();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
