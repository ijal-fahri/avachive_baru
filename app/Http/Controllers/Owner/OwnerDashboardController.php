<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerDashboardController extends Controller
{
    public function index()
    {
        // [LOGIKA BARU] 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $lastVisit = session('last_dashboard_check');

        // [LOGIKA RESET] 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session(['last_dashboard_check' => now()]);

        // --- Sisa kode untuk menampilkan data di Dashboard ---
        $totalPendapatan = BuatOrder::sum('total_harga');
        $orderBulanIni = BuatOrder::whereMonth('created_at', Carbon::now()->month)->count();
        $orderDalamProses = BuatOrder::whereIn('status', ['Diproses', 'Sudah Bisa Diambil'])->count();
        $pelangganBaru = TambahPelanggan::whereMonth('created_at', Carbon::now()->month)->count();

        // [LOGIKA BARU] 3. Tambahkan penanda 'is_new' pada data pipeline
        $pipelineOrdersData = BuatOrder::with('pelanggan')
            ->whereIn('status', ['Diproses', 'Sudah Bisa Diambil', 'Selesai'])
            ->latest()
            ->get()
            ->map(function ($order) use ($lastVisit) {
                // Tandai sebagai 'baru' jika diupdate setelah kunjungan terakhir
                if ($lastVisit) {
                    $order->is_new = Carbon::parse($order->updated_at)->isAfter(Carbon::parse($lastVisit));
                } else {
                    // Jika ini kunjungan pertama (setelah session hilang), anggap semua baru
                    $order->is_new = true;
                }
                return $order;
            });
        
        $pipelineOrders = collect([
            'Diproses' => $pipelineOrdersData->where('status', 'Diproses'),
            'Siap diambil' => $pipelineOrdersData->where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Ambil Sendiri'),
            'Siap diantar' => $pipelineOrdersData->where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Diantar'),
            'Selesai' => $pipelineOrdersData->where('status', 'Selesai'),
        ]);

        $transaksiHarian = BuatOrder::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date');

        $pelangganTeratas = BuatOrder::with('pelanggan')
            ->select('tambah_pelanggan_id', DB::raw('count(*) as total_orders'))
            ->whereNotNull('tambah_pelanggan_id')
            ->groupBy('tambah_pelanggan_id')
            ->orderByDesc('total_orders')
            ->take(3)
            ->get();
        
        return view('owner.dashboard.index', compact(
            'totalPendapatan',
            'orderBulanIni',
            'orderDalamProses',
            'pelangganBaru',
            'pipelineOrders',
            'transaksiHarian',
            'pelangganTeratas'
        ));
    }
}
