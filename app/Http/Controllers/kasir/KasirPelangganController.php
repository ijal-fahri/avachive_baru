<?php

namespace App\Http\Controllers\kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TambahPelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class KasirPelangganController extends Controller
{
    public function index(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;

        // Pastikan relasi user di-load
        $query = TambahPelanggan::with('user')->where('cabang_id', $cabangId);

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('no_handphone', 'like', "%{$search}%")
                    ->orWhere('provinsi', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%")
                    ->orWhere('kecamatan', 'like', "%{$search}%")
                    ->orWhere('kodepos', 'like', "%{$search}%")
                    ->orWhere('detail_alamat', 'like', "%{$search}%");
            });
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'nama_asc':
                    $query->orderBy('nama', 'asc');
                    break;
                case 'nama_desc':
                    $query->orderBy('nama', 'desc');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $perPage = $request->input('perPage', 10);

        if ($perPage === 'all') {
            $pelanggans = $query->get();
            $pelanggans = new \Illuminate\Pagination\LengthAwarePaginator(
                $pelanggans,
                $pelanggans->count(),
                $pelanggans->count() > 0 ? $pelanggans->count() : 1,
                1,
                [
                    'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                    'pageName' => 'page',
                ]
            );
        } else {
            $pelanggans = $query->paginate($perPage)->withQueryString();
        }

        return view('kasir.pelanggan', compact('pelanggans', 'perPage'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'no_handphone' => 'required|max:20',
            'email' => 'required|email|unique:users,email', // Validasi tetap di sini
            'provinsi' => 'required|string',
            'provinsi_id' => 'required|string',
            'kota' => 'required|string',
            'kota_id' => 'required|string',
            'kecamatan' => 'required|string',
            'kecamatan_id' => 'required|string',
            'desa' => 'nullable|string',
            'desa_id' => 'nullable|string',
            'kodepos' => 'required',
            'detail_alamat' => 'required',
        ]);

        $validatedData['cabang_id'] = Auth::user()->cabang_id;

        // Buat user baru untuk pelanggan
        $password = '12345678'; // Default password
        $user = User::create([
            'name' => $validatedData['nama'],
            'email' => $validatedData['email'],
            'password' => bcrypt($password),
            'plain_password' => $password,
            'usertype' => 'pelanggan',
            'cabang_id' => $validatedData['cabang_id'],
        ]);

        // Tambahkan relasi user_id ke pelanggan
        $validatedData['user_id'] = $user->id;

        TambahPelanggan::create($validatedData);

        // Kirim email ke pelanggan
        Mail::to($user->email)->send(new \App\Mail\PelangganAccountMail($user, $password));

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan & info login dikirim ke email!');
    }

    public function edit(string $id)
    {
        $pelanggan = TambahPelanggan::with('user')
            ->where('id', $id)
            ->where('cabang_id', Auth::user()->cabang_id)
            ->firstOrFail();
        return response()->json($pelanggan);
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = TambahPelanggan::where('id', $id)
            ->where('cabang_id', Auth::user()->cabang_id)
            ->firstOrFail();

        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'no_handphone' => 'required|max:20',
            'provinsi' => 'required|string',
            'provinsi_id' => 'required|string',
            'kota' => 'required|string',
            'kota_id' => 'required|string',
            'kecamatan' => 'required|string',
            'kecamatan_id' => 'required|string',
            'desa' => 'nullable|string',
            'desa_id' => 'nullable|string',
            'kodepos' => 'required',
            'detail_alamat' => 'required',
        ]);
        
        $pelanggan->update($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diupdate!');
    }

   public function destroy(string $id)
    {
        // 2. Gunakan transaction untuk memastikan keduanya terhapus atau tidak sama sekali
        DB::transaction(function () use ($id) {
            $pelanggan = TambahPelanggan::with('user') // Eager load relasi user
                ->where('id', $id)
                ->where('cabang_id', Auth::user()->cabang_id)
                ->firstOrFail();
            
            // 3. Ambil data user yang berelasi SEBELUM pelanggan dihapus
            $user = $pelanggan->user;
            
            // 4. Hapus data pelanggan dari tabel 'tambah_pelanggans'
            $pelanggan->delete();
    
            // 5. JIKA ada user yang terhubung, hapus juga user tersebut
            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan & akun login berhasil dihapus!');
    }
}