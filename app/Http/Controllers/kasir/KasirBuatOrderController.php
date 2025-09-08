<?php

namespace App\Http\Controllers\kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TambahPelanggan;
use App\Models\Layanan;
use App\Models\BuatOrder;
use Illuminate\Support\Facades\Auth;

class KasirBuatOrderController extends Controller
{
    /**
     * Menampilkan halaman pembuatan order.
     */
    public function index()
    {
        // Ambil ID cabang dari kasir yang sedang login
        $cabangId = Auth::user()->cabang_id;

        // Ambil pelanggan dan layanan HANYA dari cabang tersebut
        $pelanggans = TambahPelanggan::where('cabang_id', $cabangId)->get();
        $layanans = Layanan::where('cabang_id', $cabangId)->get(); 
        
        return view('kasir.buat_order', compact('pelanggans', 'layanans'));
    }

    /**
     * Menyimpan order baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tambah_pelanggan_id' => 'required|exists:tambah_pelanggans,id',
            'layanan' => 'required|json',
            'metode_pembayaran' => 'required|string',
            'waktu_pembayaran' => 'required|string',
            'metode_pengambilan' => 'required|string',
            'total_harga' => 'required|numeric',
            'dp_amount' => 'nullable|numeric|lte:total_harga',
            'remaining_amount' => 'nullable|numeric',
            'uang_diberikan' => 'nullable|numeric',
            'kembalian' => 'nullable|numeric',
        ]);

        // Siapkan data untuk disimpan
        $orderData = [
            'tambah_pelanggan_id' => $validatedData['tambah_pelanggan_id'],
            'layanan' => $validatedData['layanan'],
            'metode_pembayaran' => $validatedData['metode_pembayaran'],
            'waktu_pembayaran' => $validatedData['waktu_pembayaran'],
            'metode_pengambilan' => $validatedData['metode_pengambilan'],
            'total_harga' => $validatedData['total_harga'],
            'dp_dibayar' => $request->input('dp_amount', 0),
            'sisa_harga' => $request->input('remaining_amount', $validatedData['total_harga']),
            'uang_diberikan' => $request->input('uang_diberikan', 0),
            'kembalian' => $request->input('kembalian', 0),
            'cabang_id' => Auth::user()->cabang_id, // Tambahkan cabang_id
            'status' => 'Diproses', // Status default
        ];

        // Simpan data order baru
        BuatOrder::create($orderData);

        return response()->json([
            'success' => true,
            'message' => 'Order berhasil disimpan'
        ]);
    }

    public function bayar(Request $request, $id)
    {
        $order = BuatOrder::findOrFail($id);
        $order->sisa_harga = 0;
        $order->metode_pembayaran = $request->metode_pembayaran;
        $order->save();

        return response()->json(['success' => true]);
    }
}