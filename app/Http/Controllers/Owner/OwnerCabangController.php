<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\BuatOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OwnerCabangController extends Controller
{
    /**
     * Menyimpan cabang baru ke database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|string|max:255|unique:cabangs,nama_cabang',
            'alamat' => 'required|string',
            'no_whatsapp' => 'nullable|string|max:20', // Validasi untuk WhatsApp
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal menambahkan cabang, periksa kembali isian Anda.');
        }

        Cabang::create($validator->validated());

        return redirect()->route('owner.laporan.index')->with('success', 'Cabang baru berhasil ditambahkan.');
    }

    /**
     * Mengambil data detail cabang untuk ditampilkan (AJAX).
     */
    public function show(Cabang $cabang)
    {
        return response()->json($cabang);
    }

    /**
     * Memperbarui data cabang di database.
     */
    public function update(Request $request, Cabang $cabang)
    {
        $validator = Validator::make($request->all(), [
            'nama_cabang' => 'required|string|max:255|unique:cabangs,nama_cabang,' . $cabang->id,
            'alamat' => 'required|string',
            'no_whatsapp' => 'nullable|string|max:20', // Validasi untuk WhatsApp
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Gagal memperbarui cabang.');
        }

        $cabang->update($validator->validated());

        return redirect()->route('owner.laporan.index')->with('success', 'Data cabang berhasil diperbarui.');
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
            return back()->with('error', 'Gagal menghapus cabang karena terjadi kesalahan teknis.');
        }
    }
}