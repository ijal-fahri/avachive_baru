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
                ->with('error_modal', 'tambah');
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
                ->with('error_modal', 'edit')
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
}

