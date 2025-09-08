<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth; // <-- Diperlukan untuk mengambil data user
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class KasirController extends Controller
{
    /**
     * Menampilkan data statistik dashboard yang sudah difilter per cabang.
     */
    public function index()
    {
        // 1. Dapatkan ID cabang dari kasir yang sedang login
        $cabangId = Auth::user()->cabang_id;

        // Keamanan: Jika kasir tidak terhubung ke cabang, logout
        if (!$cabangId) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda tidak terhubung ke cabang manapun.');
        }

        // 2. Ambil semua data statistik HANYA dari cabang ini
        $todayRevenue = BuatOrder::where('cabang_id', $cabangId)->whereDate('created_at', today())->sum('total_harga');
        $todayOrders = BuatOrder::where('cabang_id', $cabangId)->whereDate('created_at', today())->count();
        $monthOrders = BuatOrder::where('cabang_id', $cabangId)->whereMonth('created_at', now()->month)->count();
        $newCustomers = TambahPelanggan::where('cabang_id', $cabangId)->whereDate('created_at', today())->count();
        $totalServices = Layanan::where('cabang_id', $cabangId)->count();
        $totalOrders = BuatOrder::where('cabang_id', $cabangId)->count();
        $totalCustomers = TambahPelanggan::where('cabang_id', $cabangId)->count();
        $layanans = Layanan::where('cabang_id', $cabangId)->get();

        // 3. Kirim data yang sudah terfilter ke view
        return view('kasir.dashboard', compact(
            'todayRevenue', 'todayOrders', 'monthOrders', 'newCustomers',
            'totalServices', 'totalOrders', 'totalCustomers', 'layanans' 
        ));
    }

    /**
     * Mencetak riwayat order dengan validasi cabang.
     */
    public function cetakRiwayatOrder($orderId)
    {
        $order = BuatOrder::with('pelanggan')->findOrFail($orderId);

        // Keamanan: Pastikan kasir hanya bisa mencetak order dari cabangnya sendiri
        if ($order->cabang_id != Auth::user()->cabang_id) {
            abort(403, 'AKSES DITOLAK');
        }

        $layanan = json_decode($order->layanan, true);
        $pdf = PDF::loadView('kasir.pdf_riwayat_order', compact('order', 'layanan'));
        return $pdf->stream('riwayat-order-'.$order->id.'.pdf');
    }

    /**
     * Menyimpan pelanggan baru dan mengaitkannya dengan cabang si kasir.
     * Catatan: Idealnya fungsi ini berada di KasirPelangganController.
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

        // Menambahkan ID cabang kasir secara otomatis
        $validatedData['cabang_id'] = Auth::user()->cabang_id;

        TambahPelanggan::create($validatedData);

        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan!');
    }
}
