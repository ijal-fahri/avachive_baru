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
        $cabangId = Auth::user()->cabang_id;
        $layanans = Layanan::where('cabang_id', $cabangId)->latest()->get(); 
        return view('admin.layanan.index', compact('layanans'));
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('produk.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'tambah')
                ->with('error_modal_title', 'Gagal Menambah Layanan')
                ->with('error_modal_action', route('produk.store'))
                ->with('error_modal_method', 'POST');
        }

        Layanan::create([
            'nama' => $request->nama,
            'paket' => $request->paket,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'cabang_id' => Auth::user()->cabang_id, // Otomatis terisi
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
        ]);

        if ($validator->fails()) {
            return redirect()->route('produk.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'edit')
                ->with('error_modal_title', 'Gagal Mengedit Layanan')
                ->with('error_modal_action', route('produk.update', $produk->id))
                ->with('error_modal_method', 'PUT')
                ->with('error_id', $produk->id);
        }

        $produk->update($request->all());

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


    // ====================================================================
    // [BARU] METHOD UNTUK MELAYANI AJAX DATATABLES
    // ====================================================================

    /**
     * Menyediakan data untuk DataTables dengan server-side processing.
     */
    public function getLayananData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;

        // Query dasar hanya untuk layanan di cabang ini
        $query = Layanan::where('cabang_id', $cabangId);

        // Filter berdasarkan kategori (dari tab filter)
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan pencarian DataTables
        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('nama', 'like', '%' . $searchValue . '%')
                  ->orWhere('paket', 'like', '%' . $searchValue . '%');
            });
        }

        // Hitung total record sebelum paginasi
        $recordsFiltered = $query->count();
        
        // Ambil data sesuai paginasi dari DataTables
        $layanans = $query->skip($request->start)
                          ->take($request->length)
                          ->latest()
                          ->get();

        // Format data untuk respons JSON
        $data = [];
        foreach ($layanans as $key => $layanan) {
            $hargaFormatted = 'Rp ' . number_format($layanan->harga, 0, ',', '.') . ' / ' . ($layanan->kategori == 'Kiloan' ? 'Kg' : 'Pcs');
            $data[] = [
                'no' => $request->start + $key + 1,
                'nama' => $layanan->nama,
                'paket' => $layanan->paket,
                'harga' => $hargaFormatted,
                'json' => $layanan, // Kirim data mentah untuk modal edit
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