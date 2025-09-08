<?php

namespace App\Http\Controllers\kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TambahPelanggan;
use Illuminate\Support\Facades\Auth; // <-- DITAMBAHKAN

class KasirPelangganController extends Controller
{
    /**
     * Menampilkan daftar pelanggan sesuai cabang kasir.
     */
    public function index(Request $request)
    {
        // Ambil ID cabang dari kasir yang sedang login
        $cabangId = Auth::user()->cabang_id;

        // DIUBAH: Mulai query dengan filter cabang terlebih dahulu
        $query = TambahPelanggan::where('cabang_id', $cabangId);

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

        // Convert ke LengthAwarePaginator biar tidak error di view
        $pelanggans = new \Illuminate\Pagination\LengthAwarePaginator(
            $pelanggans,
            $pelanggans->count(),
            $pelanggans->count() > 0 ? $pelanggans->count() : 1, // total per page = jumlah semua data
            1, // halaman saat ini
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

    /**
     * Menyimpan pelanggan baru ke database.
     */
    public function store(Request $request)
    {
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

        // DITAMBAHKAN: Sisipkan ID cabang kasir secara otomatis
        $validatedData['cabang_id'] = Auth::user()->cabang_id;

        TambahPelanggan::create($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }

    /**
     * Mengambil data pelanggan untuk form edit.
     */
    public function edit(string $id)
    {
        // DITAMBAHKAN: Pengecekan keamanan
        $pelanggan = TambahPelanggan::where('id', $id)
                                    ->where('cabang_id', Auth::user()->cabang_id)
                                    ->firstOrFail(); // Akan error jika pelanggan tidak ditemukan di cabang ini
        return response()->json($pelanggan);
    }

    /**
     * Memperbarui data pelanggan.
     */
    public function update(Request $request, string $id)
    {
        // DITAMBAHKAN: Pengecekan keamanan
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

    /**
     * Menghapus data pelanggan.
     */
    public function destroy(string $id)
    {
        // DITAMBAHKAN: Pengecekan keamanan
        $pelanggan = TambahPelanggan::where('id', $id)
                                    ->where('cabang_id', Auth::user()->cabang_id)
                                    ->firstOrFail();
        
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus!');
    }
}