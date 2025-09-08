<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    // Mengambil detail satu cabang untuk ditampilkan di modal
    public function show(Cabang $cabang)
    {
        return response()->json($cabang);
    }

    // Menyimpan cabang baru
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255|unique:cabangs',
            'alamat' => 'nullable|string',
        ]);

        $cabang = Cabang::create($validatedData);
        session(['cabang_aktif_id' => $cabang->id]); // Set cabang baru sebagai yang aktif

        return redirect()->route('dashboard')->with('success', 'Cabang baru berhasil ditambahkan!');
    }
    
    // Memperbarui data cabang
    public function update(Request $request, Cabang $cabang)
    {
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255|unique:cabangs,nama_cabang,' . $cabang->id,
            'alamat' => 'nullable|string',
        ]);

        $cabang->update($validatedData);
        return redirect()->route('dashboard')->with('success', 'Data cabang berhasil diperbarui!');
    }

    // Menghapus cabang
    public function destroy(Cabang $cabang)
{
    // Cek jika cabang yang dihapus adalah yang sedang aktif
    if(session('cabang_aktif_id') == $cabang->id) {
        // Hapus session agar sistem memilih default cabang lain
        session()->forget('cabang_aktif_id');
    }
    
    // Hapus cabang dari database
    $cabang->delete();

    return redirect()->route('dashboard')->with('success', 'Cabang berhasil dihapus.');
}
}