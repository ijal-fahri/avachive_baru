<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class KasirController extends Controller
{
    /**
     * Menampilkan data statistik dashboard yang sudah difilter per cabang.
     */
    public function index()
    {
        $cabangId = Auth::user()->cabang_id;

        // Keamanan: Jika kasir tidak terhubung ke cabang, logout
        if (!$cabangId) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda tidak terhubung ke cabang manapun.');
        }

        // --- Notifikasi layanan baru di dashboard kasir ---
        $dashboardServiceSessionKey = 'last_dashboard_service_check_kasir_' . $cabangId;
        $now = now();

        // Ambil waktu terakhir dashboard dibuka dari session
        $lastCheck = session($dashboardServiceSessionKey);

        if ($lastCheck) {
            // Hitung layanan baru sejak terakhir dashboard dibuka
            $dashboardNewServiceCount = Layanan::where('cabang_id', $cabangId)
                ->where('created_at', '>', $lastCheck)
                ->count();
        } else {
            // Jika belum pernah buka dashboard, hitung semua layanan
            $dashboardNewServiceCount = Layanan::where('cabang_id', $cabangId)->count();
        }

        // JANGAN update session di sini!

        // Statistik dashboard
        $todayRevenue = BuatOrder::where('cabang_id', $cabangId)->whereDate('created_at', today())->sum('total_harga');
        $todayOrders = BuatOrder::where('cabang_id', $cabangId)->whereDate('created_at', today())->count();
        $monthOrders = BuatOrder::where('cabang_id', $cabangId)->whereMonth('created_at', now()->month)->count();
        $newCustomers = TambahPelanggan::where('cabang_id', $cabangId)->whereDate('created_at', today())->count();
        $totalServices = Layanan::where('cabang_id', $cabangId)->count();
        $totalOrders = BuatOrder::where('cabang_id', $cabangId)->count();
        $totalCustomers = TambahPelanggan::where('cabang_id', $cabangId)->count();
        $layanans = Layanan::where('cabang_id', $cabangId)->get();

        return view('kasir.dashboard', compact(
            'todayRevenue', 'todayOrders', 'monthOrders', 'newCustomers',
            'totalServices', 'totalOrders', 'totalCustomers', 'layanans',
            'dashboardNewServiceCount', // <-- untuk notifikasi badge
            'lastCheck' // <-- untuk filter layanan baru di modal
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

    // HAPUS FUNGSI DI BAWAH INI
    /*
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
    */

    /**
     * Menandai bahwa layanan baru telah dilihat oleh kasir.
     */
    public function layananBaruSeen(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;
        $dashboardServiceSessionKey = 'last_dashboard_service_check_kasir_' . $cabangId;
        session([$dashboardServiceSessionKey => now()]);
        return response()->json(['success' => true]);
    }
}