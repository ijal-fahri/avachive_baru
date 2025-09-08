<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use App\Models\Cabang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OwnerLaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua cabang untuk filter
        $semuaCabang = Cabang::all();

        // 2. Tentukan periode tanggal berdasarkan filter
        $periode = $request->input('periode', 'bulan_ini');
        $endDate = Carbon::now()->endOfDay();
        // Set default start date, will be overridden by match
        $startDate = Carbon::now()->startOfMonth(); 

        // Menggunakan 'match' untuk kode yang lebih bersih
        $startDate = match ($periode) {
            'hari_ini' => Carbon::now()->startOfDay(),
            '7_hari' => Carbon::now()->subDays(6)->startOfDay(),
            default => Carbon::now()->startOfMonth(),
        };

        // 3. Query dasar dengan Eager Loading untuk efisiensi
        // Mengambil relasi 'pelanggan' dan 'cabang' sekali saja untuk menghindari N+1 query problem
        $orderQuery = BuatOrder::with(['pelanggan', 'cabang'])
                        ->whereBetween('created_at', [$startDate, $endDate]);

        $pelangganQuery = TambahPelanggan::query()
                            ->whereBetween('created_at', [$startDate, $endDate]);

        // 4. Terapkan filter cabang jika dipilih
        $cabangId = $request->input('cabang_id');
        if ($cabangId && $cabangId !== 'semua') {
            $orderQuery->where('cabang_id', $cabangId);
            $pelangganQuery->where('cabang_id', $cabangId);
        }

        // --- 5. EKSEKUSI & KALKULASI DATA ---
        $semuaOrder = $orderQuery->get(); // Eksekusi query sekali dan gunakan hasilnya

        $totalPendapatan = $semuaOrder->sum('total_harga');
        $jumlahTransaksi = $semuaOrder->count();
        $orderSelesai = $semuaOrder->where('status', 'Selesai')->count();
        $pelangganBaru = $pelangganQuery->count();

        // OPTIMASI: Menghitung Pemasukan Tertinggi/Terendah per CABANG, bukan per transaksi
        // Ini lebih sesuai dengan tampilan di Blade-mu
        $pendapatanPerCabang = $semuaOrder->groupBy('cabang.nama_cabang')
                                         ->map(fn($orders) => $orders->sum('total_harga'))
                                         ->sortDesc();

        $pemasukanTertinggi = $pendapatanPerCabang->keys()->first() ?? '-';
        $pemasukanTerendah = $pendapatanPerCabang->keys()->last() ?? '-';
        // Jika hanya ada 1 cabang, pemasukan terendah akan sama dengan tertinggi
        if ($pendapatanPerCabang->count() <= 1) {
            $pemasukanTerendah = '-';
        }


        // 6. Data untuk Grafik Pendapatan
        $revenueTrend = $semuaOrder
            ->groupBy(fn($order) => Carbon::parse($order->created_at)->format('Y-m-d'))
            ->map(fn($group) => $group->sum('total_harga'))
            ->sortKeys();
            
        // 7. Data untuk Grafik Layanan Terlaris (logika tetap sama, sudah cukup baik)
        $layananCounts = [];
        foreach ($semuaOrder as $order) {
            $services = json_decode($order->layanan, true) ?? [];
            foreach ($services as $service) {
                $nama = $service['nama'] ?? 'N/A';
                $kuantitas = is_numeric($service['kuantitas'] ?? 0) ? $service['kuantitas'] : 0;
                $layananCounts[$nama] = ($layananCounts[$nama] ?? 0) + $kuantitas;
            }
        }
        arsort($layananCounts);
        $layananTerlaris = array_slice($layananCounts, 0, 5, true);

        // 8. Data untuk Tabel Transaksi Terbaru (menggunakan data yang sudah di-fetch)
        $transaksiTerbaru = $semuaOrder->sortByDesc('created_at')->take(10);

        return view('owner.laporan.index', [
            'cabangs' => $semuaCabang,
            'selectedCabang' => $cabangId,
            'selectedPeriode' => $periode, // <-- Kirim ini ke view untuk set default value di dropdown
            'totalPendapatan' => $totalPendapatan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'orderSelesai' => $orderSelesai,
            'pelangganBaru' => $pelangganBaru,
            'pemasukanTertinggi' => $pemasukanTertinggi,
            'pemasukanTerendah' => $pemasukanTerendah,
            'revenueTrend' => $revenueTrend,
            'layananTerlaris' => $layananTerlaris,
            'transaksiTerbaru' => $transaksiTerbaru,
        ]);
    }
}
