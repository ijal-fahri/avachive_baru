<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    /**
     * Menampilkan semua layanan HANYA dari cabang admin yang login.
     */
    public function index()
    {
        // Mengambil data layanan untuk halaman utama (opsional jika semua via AJAX)
        return view('admin.layanan.index');
    }

    /**
     * Menyimpan layanan baru dan OTOMATIS mengaitkannya dengan cabang admin.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'paket' => 'required|string',
            'kategori' => 'required|string|in:Kiloan,Satuan',
            'harga' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100', // Validasi untuk diskon
        ]);

        if ($validator->fails()) {
            return redirect()->route('produk.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'tambah');
        }

        Layanan::create([
            'nama' => $request->nama,
            'paket' => $request->paket,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'diskon' => $request->diskon ?? 0, // Simpan diskon, default 0 jika null
            'cabang_id' => Auth::user()->cabang_id,
        ]);

        return redirect()->route('produk.index')->with('success', 'Layanan berhasil ditambahkan.');
    }

    /**
     * Memperbarui layanan, memastikan admin hanya bisa mengubah layanan di cabangnya.
     */
    public function update(Request $request, Layanan $produk)
    {
        if ($produk->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'paket' => 'required|string',
            'kategori' => 'required|string|in:Kiloan,Satuan',
            'harga' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100', // Validasi untuk diskon
        ]);

        if ($validator->fails()) {
            return redirect()->route('produk.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'edit')
                ->with('error_id', $produk->id);
        }

        $produk->update([
            'nama' => $request->nama,
            'paket' => $request->paket,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'diskon' => $request->diskon ?? 0,
        ]);

        return redirect()->route('produk.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    /**
     * Menghapus layanan, memastikan admin hanya bisa menghapus layanan di cabangnya.
     */
    public function destroy(Layanan $produk)
    {
        if ($produk->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }
        
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Layanan berhasil dihapus.');
    }

    /**
     * Menyediakan data untuk DataTables dengan server-side processing.
     */
    public function getLayananData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;
        $query = Layanan::where('cabang_id', $cabangId);

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('nama', 'like', '%' . $searchValue . '%')
                  ->orWhere('paket', 'like', '%' . $searchValue . '%');
            });
        }

        $recordsFiltered = $query->count();
        $layanans = $query->skip($request->start)->take($request->length)->latest()->get();

        $data = [];
        foreach ($layanans as $key => $layanan) {
            // PERUBAHAN: Mengirim data harga dan diskon secara terpisah
            $data[] = [
                'no' => $request->start + $key + 1,
                'nama' => $layanan->nama,
                'paket' => $layanan->paket,
                'harga_asli' => $layanan->harga,
                'diskon' => $layanan->diskon,
                'json' => $layanan,
            ];
        }
        
        $totalRecords = Layanan::where('cabang_id', $cabangId)->count();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}