<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use App\Models\User; // <-- DITAMBAHKAN
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- DITAMBAHKAN
use Carbon\Carbon;

class OwnerCabangController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255|unique:cabangs',
            'alamat' => 'nullable|string',
        ]);

        Cabang::create($validatedData);

        return redirect()->route('owner.laporan.index')->with('success', 'Cabang baru berhasil ditambahkan!');
    }

    public function show(Cabang $cabang)
    {
        // Fungsi ini tetap sama
        return response()->json($cabang);
    }

    public function update(Request $request, Cabang $cabang)
    {
        $validatedData = $request->validate([
            'nama_cabang' => 'required|string|max:255|unique:cabangs,nama_cabang,' . $cabang->id,
            'alamat' => 'nullable|string',
        ]);

        $cabang->update($validatedData);

        // Menggunakan response JSON agar lebih konsisten dengan alur modal
        return redirect()->route('owner.laporan.index')->with('success', 'Data cabang berhasil diperbarui!');
    }

    /**
     * Menghapus cabang beserta semua data terkaitnya.
     */
    public function destroy(Cabang $cabang)
    {
        try {
            // Memulai transaksi database untuk memastikan semua operasi berhasil
            DB::transaction(function () use ($cabang) {
                // 1. Hapus semua order yang terhubung ke cabang ini
                BuatOrder::where('cabang_id', $cabang->id)->delete();
                
                // 2. Hapus semua pengguna (admin/karyawan) yang terhubung ke cabang ini
                User::where('cabang_id', $cabang->id)->delete();

                // 3. Setelah semua data terkait dihapus, baru hapus cabangnya
                $cabang->delete();
            });

            return redirect()->route('owner.laporan.index')->with('success', 'Cabang dan semua data terkait berhasil dihapus.');

        } catch (\Exception $e) {
            // Jika terjadi error selama proses, kirim pesan gagal
            return back()->with('error', 'Gagal menghapus cabang karena terjadi kesalahan.');
        }
    }
}
