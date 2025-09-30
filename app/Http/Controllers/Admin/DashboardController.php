<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use App\Models\Layanan;
use App\Models\TambahPelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dan menandai data order yang baru.
     */
    public function index()
    {
        $cabangId = Auth::user()->cabang_id;

        if (!$cabangId) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda tidak terhubung ke cabang manapun.');
        }

        // [LOGIKA BARU] 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $sessionKey = 'last_dashboard_check_admin_' . $cabangId;
        $lastVisit = session($sessionKey);

        // [LOGIKA RESET NOTIFIKASI] 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session([$sessionKey => now()]);

        // --- Semua logika pengambilan data Anda di bawah ini tetap sama ---
        $pendapatan_tahun_ini = BuatOrder::where('cabang_id', $cabangId)->whereYear('created_at', now()->year)->sum('total_harga');
        $pendapatan_bulan_ini = BuatOrder::where('cabang_id', $cabangId)->whereMonth('created_at', now()->month)->sum('total_harga');
        $total_order_tahun_ini = BuatOrder::where('cabang_id', $cabangId)->whereYear('created_at', now()->year)->count();
        $total_order_bulan_ini = BuatOrder::where('cabang_id', $cabangId)->whereMonth('created_at', now()->month)->count();
        $jumlah_pelanggan = TambahPelanggan::where('cabang_id', $cabangId)->count();
        $jumlah_layanan = Layanan::where('cabang_id', $cabangId)->count();
        $order_selesai = BuatOrder::where('cabang_id', $cabangId)->where('status', 'Selesai')->count();
        $jumlah_karyawan = User::where('cabang_id', $cabangId)->whereIn('usertype', ['kasir', 'driver'])->count();

        // [LOGIKA BARU] 3. Tambahkan penanda 'is_new' pada pesanan hari ini
        $pesanan_hari_ini = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->get()
            ->map(function ($order) use ($lastVisit) {
                // Tandai sebagai 'baru' jika diupdate setelah kunjungan terakhir, atau jika ini kunjungan pertama
                if ($lastVisit) {
                    $order->is_new = Carbon::parse($order->updated_at)->isAfter(Carbon::parse($lastVisit));
                } else {
                    $order->is_new = true; // Anggap semua baru jika belum pernah berkunjung
                }
                return $order;
            });

        // Data chart (tidak diubah)
        $chartData = BuatOrder::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->where('cabang_id', $cabangId)
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')->orderBy('bulan')
            ->pluck('jumlah', 'bulan')->all();

        $chart_labels = [];
        $chart_data = [];
        for ($i = 1; $i <= 12; $i++) {
            $chart_labels[] = Carbon::create()->month($i)->format('F');
            $chart_data[] = $chartData[$i] ?? 0;
        }
        
        // Layanan favorit (tidak diubah)
        $layananFavorit = BuatOrder::where('cabang_id', $cabangId)
            ->whereNotNull('layanan')
            ->get('layanan')
            ->flatMap(function($order) {
                return json_decode($order->layanan, true) ?? [];
            })
            ->pluck('nama')
            ->countBy()
            ->sortDesc()
            ->keys()
            ->first() ?? 'Belum ada';

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'pendapatan_tahun_ini',
            'pendapatan_bulan_ini',
            'total_order_tahun_ini',
            'total_order_bulan_ini',
            'jumlah_pelanggan',
            'jumlah_layanan',
            'order_selesai',
            'jumlah_karyawan',
            'pesanan_hari_ini',
            'chart_labels',
            'chart_data',
            'layananFavorit'
        ));
    }
}

