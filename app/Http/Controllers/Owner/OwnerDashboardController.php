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
        // --- Data untuk Kartu Statistik ---
        $totalPendapatan = BuatOrder::sum('total_harga');
        $orderBulanIni = BuatOrder::whereMonth('created_at', Carbon::now()->month)->count();
        // PERBAIKAN: Menyesuaikan status order dalam proses
        $orderDalamProses = BuatOrder::whereIn('status', ['Diproses', 'Sudah Bisa Diambil'])->count();
        $pelangganBaru = TambahPelanggan::whereMonth('created_at', Carbon::now()->month)->count();

        // --- Data untuk Pipeline Order (DIPERBAIKI agar sesuai dengan status dari Kasir) ---
        $pipelineOrdersData = BuatOrder::with('pelanggan')
            ->whereIn('status', ['Diproses', 'Sudah Bisa Diambil', 'Selesai']) // Ambil semua order yang relevan
            ->latest()
            ->get();
        
        // Buat grup pipeline secara manual berdasarkan status dan metode pengambilan
        $pipelineOrders = collect([
            'Diproses' => $pipelineOrdersData->where('status', 'Diproses'),
            'Siap diambil' => $pipelineOrdersData->where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Ambil Sendiri'),
            'Siap diantar' => $pipelineOrdersData->where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Diantar'),
            'Selesai' => $pipelineOrdersData->where('status', 'Selesai'),
        ]);

        // --- Data untuk Grafik & Pelanggan Teratas ---
        $transaksiHarian = BuatOrder::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->pluck('count', 'date');

        $pelangganTeratas = BuatOrder::with('pelanggan')
            ->select('tambah_pelanggan_id', DB::raw('count(*) as total_orders'))
            ->whereNotNull('tambah_pelanggan_id') // Menghindari pelanggan null
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

