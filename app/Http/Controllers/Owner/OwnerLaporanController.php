<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use App\Models\Cabang;
use App\Models\TambahPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OwnerLaporanController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. PENGAMBILAN DATA & FILTER ---
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $selectedCabang = $request->input('cabang_id', 'semua');
        $selectedPeriode = $request->input('periode', 'bulan_ini');

        // Query dasar untuk order dengan relasi yang dibutuhkan
        $ordersQuery = BuatOrder::with(['pelanggan', 'cabang']);

        // Filter berdasarkan cabang
        if ($selectedCabang && $selectedCabang !== 'semua') {
            $ordersQuery->where('cabang_id', $selectedCabang);
        }

        // Filter berdasarkan periode waktu
        $startDate = now()->startOfDay();
        $endDate = now()->endOfDay();

        if ($selectedPeriode == '7_hari') {
            $startDate = now()->subDays(6)->startOfDay();
        } elseif ($selectedPeriode == 'bulan_ini') {
            $startDate = now()->startOfMonth();
        }
        
        $ordersQuery->whereBetween('created_at', [$startDate, $endDate]);
        
        // Ambil semua order yang sudah difilter
        $filteredOrders = $ordersQuery->get();

        // --- 2. PENGOLAHAN DATA STATISTIK ---
        $totalPendapatan = $filteredOrders->sum('total_harga');
        $jumlahTransaksi = $filteredOrders->count();
        $orderSelesai = $filteredOrders->where('status', 'Selesai')->count();
        
        // Statistik pelanggan baru berdasarkan filter
        $pelangganBaruQuery = TambahPelanggan::whereBetween('created_at', [$startDate, $endDate]);
        if ($selectedCabang && $selectedCabang !== 'semua') {
            $pelangganBaruQuery->where('cabang_id', $selectedCabang);
        }
        $pelangganBaru = $pelangganBaruQuery->count();

        // Statistik pemasukan tertinggi & terendah
        $pemasukanTertinggi = $filteredOrders->max('total_harga') ?? 0;
        $pemasukanTerendah = $filteredOrders->min('total_harga') ?? 0;


        // --- 3. PENGOLAHAN DATA UNTUK GRAFIK (BAGIAN PENTING) ---
        
        // Inisialisasi data untuk grafik
        $revenueTrend = [];
        $layananCounts = [];

        // Inisialisasi tren pendapatan dengan nilai 0 untuk setiap hari dalam periode
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $revenueTrend[$currentDate->format('Y-m-d')] = 0;
            $currentDate->addDay();
        }

        // Loop melalui setiap order untuk mengisi data grafik
        foreach ($filteredOrders as $order) {
            // Mengisi data tren pendapatan
            $orderDate = Carbon::parse($order->created_at)->format('Y-m-d');
            if (isset($revenueTrend[$orderDate])) {
                $revenueTrend[$orderDate] += $order->total_harga;
            }

            // Mengisi data layanan terlaris dengan "membongkar" JSON
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
        
        // Urutkan layanan terlaris dari yang paling banyak
        arsort($layananCounts);
        $layananTerlaris = array_slice($layananCounts, 0, 5); // Ambil 5 teratas

        // Mengambil 5 transaksi terbaru untuk ditampilkan di tabel
        $transaksiTerbaru = $filteredOrders->sortByDesc('created_at')->take(10);

        return view('owner.laporan.index', compact(
            'cabangs',
            'selectedCabang',
            'selectedPeriode',
            'totalPendapatan',
            'jumlahTransaksi',
            'orderSelesai',
            'pelangganBaru',
            'pemasukanTertinggi',
            'pemasukanTerendah',
            'revenueTrend',
            'layananTerlaris',
            'transaksiTerbaru'
        ));
    }
}