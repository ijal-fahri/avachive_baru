<?php

namespace App\Http\Controllers\driver;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Diperlukan untuk mengambil data user

class DriverRiwayatController extends Controller
{
    /**
     * Menampilkan riwayat pengantaran yang sudah difilter per cabang.
     */
    public function index()
    {
        // 1. Dapatkan ID cabang dari driver yang sedang login
        $cabangId = Auth::user()->cabang_id;

        // Keamanan: Jika driver tidak terhubung ke cabang, logout
        if (!$cabangId) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda tidak terhubung ke cabang manapun.');
        }

        // 2. Ambil riwayat order HANYA dari cabang ini
        $orders = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId) // <-- FILTER KUNCI DI SINI
            ->where('metode_pengambilan', 'Diantar')
            ->where('status', 'Selesai')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('driver.riwayat', compact('orders'));
    }
}

