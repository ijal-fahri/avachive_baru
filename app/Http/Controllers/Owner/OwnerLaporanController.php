<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use App\Models\Cabang;
use App\Models\TambahPelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OwnerLaporanController extends Controller
{
    public function index(Request $request)
    {
        // [LOGIKA NOTIFIKASI SIDEBAR]
        $lastOrderCheck = session('last_order_check');
        $activeOrderQuery = BuatOrder::whereIn('status', ['Baru', 'Diproses']);
        if ($lastOrderCheck) {
            $activeOrderQuery->where('created_at', '>', $lastOrderCheck);
        }
        $activeOrderNotificationCount = $activeOrderQuery->count();

        $lastCabangCheck = session('last_cabang_check');
        $completedOrderQuery = BuatOrder::where('status', 'Selesai');
        if ($lastCabangCheck) {
            $completedOrderQuery->where('updated_at', '>', $lastCabangCheck);
        }
        $completedOrderNotificationCount = $completedOrderQuery->count();
        
        $dashboardNotificationCount = $activeOrderNotificationCount + $completedOrderNotificationCount;

        $lastKaryawanCheck = session('last_karyawan_check');
        $karyawanQuery = User::whereIn('usertype', ['kasir', 'driver']);
        if ($lastKaryawanCheck) {
            $karyawanQuery->where('created_at', '>', $lastKaryawanCheck);
        }
        $karyawanNotificationCount = $karyawanQuery->count();
        
        // Reset notifikasi badge tabel dengan mencatat waktu SEKARANG.
        session(['last_cabang_check' => now()]);


        // --- PENGAMBILAN DATA & FILTER LAPORAN ---
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $selectedCabang = $request->input('cabang_id', 'semua');
        $selectedPeriode = $request->input('periode', 'bulan_ini');

        $ordersQuery = BuatOrder::with(['pelanggan', 'cabang']);

        if ($selectedCabang && $selectedCabang !== 'semua') {
            $ordersQuery->where('cabang_id', $selectedCabang);
        }

        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($selectedPeriode == '7_hari') {
            $startDate = now()->subDays(6)->startOfDay();
        } elseif ($selectedPeriode == 'bulan_ini') {
            $startDate = now()->startOfMonth();
        }
        
        $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        
        $filteredOrders = $ordersQuery->get();

        // Tambahkan penanda 'is_new' untuk badge di tabel
        $filteredOrders->transform(function ($order) use ($lastCabangCheck) {
            if ($lastCabangCheck && $order->status === 'Selesai') {
                $order->is_new = Carbon::parse($order->updated_at)->isAfter(Carbon::parse($lastCabangCheck));
            } else {
                $order->is_new = !$lastCabangCheck && $order->status === 'Selesai';
            }
            return $order;
        });

        // --- PENGOLAHAN DATA STATISTIK ---
        $totalPendapatan = $filteredOrders->sum('total_harga');
        $jumlahTransaksi = $filteredOrders->count();
        $orderSelesai = $filteredOrders->where('status', 'Selesai')->count();
        
        $pelangganBaruQuery = TambahPelanggan::whereBetween('created_at', [$startDate, $endDate]);
        if ($selectedCabang && $selectedCabang !== 'semua') {
            $pelangganBaruQuery->where('cabang_id', $selectedCabang);
        }
        $pelangganBaru = $pelangganBaruQuery->count();

        // [LOGIKA DIPERBARUI] Menentukan nama cabang dengan pemasukan tertinggi & terendah
        $pendapatanPerCabang = $filteredOrders
            ->where('cabang.nama_cabang', '!=', null)
            ->groupBy('cabang.nama_cabang')
            ->map(fn ($orders) => $orders->sum('total_harga'))
            ->sortDesc();

        $pemasukanTertinggi = $pendapatanPerCabang->keys()->first() ?? '-';
        $pemasukanTerendah = $pendapatanPerCabang->keys()->last() ?? '-';

        if ($pendapatanPerCabang->count() <= 1) {
            $pemasukanTerendah = '-';
        }

        // --- PENGOLAHAN DATA UNTUK GRAFIK ---
        $revenueTrend = [];
        $layananCounts = [];

        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $revenueTrend[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        foreach ($filteredOrders as $order) {
            $orderDate = Carbon::parse($order->created_at)->format('Y-m-d');
            if (isset($revenueTrend[$orderDate])) {
                $revenueTrend[$orderDate] += $order->total_harga;
            }

            $layananItems = json_decode($order->layanan, true);
            if (is_array($layananItems)) {
                foreach ($layananItems as $item) {
                    if (isset($item['nama'])) {
                        $namaLayanan = $item['nama'];
                        $kuantitas = $item['kuantitas'] ?? 1;
                        if (!isset($layananCounts[$namaLayanan])) {
                            $layananCounts[$namaLayanan] = 0;
                        }
                        $layananCounts[$namaLayanan] += $kuantitas;
                    }
                }
            }
        }
        
        arsort($layananCounts);
        $layananTerlaris = array_slice($layananCounts, 0, 5);
        $transaksiTerbaru = $filteredOrders->sortByDesc('created_at')->take(10);

        return view('owner.laporan.index', compact(
            'cabangs', 'selectedCabang', 'selectedPeriode', 'totalPendapatan', 'jumlahTransaksi', 'orderSelesai', 'pelangganBaru', 'pemasukanTertinggi', 'pemasukanTerendah', 'revenueTrend', 'layananTerlaris', 'transaksiTerbaru',
            // Kirim semua variabel notifikasi ke view
            'dashboardNotificationCount', 'activeOrderNotificationCount', 'completedOrderNotificationCount', 'karyawanNotificationCount'
        ));
    }
}