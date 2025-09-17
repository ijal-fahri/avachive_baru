<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DataOrderController extends Controller
{
    /**
     * Metode ini tetap ada untuk fungsionalitas lama Anda.
     * Tidak diubah.
     */
    public function index()
    {
        // 1. Dapatkan ID cabang dari admin yang sedang login
        $cabangId = Auth::user()->cabang_id;

        // 2. Ambil semua order HANYA dari cabang ini, di-group berdasarkan tanggal
        $orders = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId) // <-- FILTER KUNCI DI SINI
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m-d');
            });

        // 3. Struktur data yang akan dikirim ke view
        $orderData = [];
        $availableYears = [];

        foreach ($orders as $date => $ordersOnDate) {
            $dailyTotal = $ordersOnDate->sum('total_harga');
            
            $year = Carbon::parse($date)->format('Y');
            if (!in_array($year, $availableYears)) {
                $availableYears[] = $year;
            }

            $orderData[$date] = [
                'orders' => $ordersOnDate, // Kirim koleksi order lengkap
                'total_pemasukan' => $dailyTotal
            ];
        }

        // Mengurutkan tahun dari yang terbaru
        rsort($availableYears);
        
        // Pastikan nama view-nya benar: admin.dataorder.index
        return view('order', [
            'order_groups' => $orderData,
            'years' => $availableYears
        ]);
    }
    
    /**
     * Metode ini tetap ada untuk fungsionalitas lama Anda.
     * Tidak diubah.
     */
    public function updateStatus(Request $request, BuatOrder $order)
    {
        // Keamanan: Pastikan admin hanya bisa mengubah status order di cabangnya
        if ($order->cabang_id != Auth::user()->cabang_id) {
            abort(403);
        }
        
        $request->validate(['status' => 'required|in:Diproses,Sudah Bisa Diambil,Selesai']);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status berhasil diubah!', 'order' => $order]);
    }

    // ====================================================================
    // METODE BARU DITAMBAHKAN DI SINI UNTUK AJAX DATATABLES
    // ====================================================================

    /**
     * [BARU] Menyediakan data untuk mengisi dropdown filter (Tahun & Bulan).
     * Endpoint ini dipanggil oleh AJAX dari halaman laporan.
     */
    public function getFilterOptions()
    {
        $cabangId = Auth::user()->cabang_id;

        // Ambil semua tahun unik dari order di cabang ini
        $years = BuatOrder::where('cabang_id', $cabangId)
                   ->selectRaw('DISTINCT YEAR(created_at) as year')
                   ->orderBy('year', 'desc')
                   ->pluck('year');

        $months = collect(range(1, 12))->map(function ($month) {
            return [
                'value' => $month,
                'name'  => Carbon::create()->month($month)->locale('id')->monthName,
            ];
        });

        return response()->json([
            'years'  => $years,
            'months' => $months,
        ]);
    }

    /**
     * [BARU] Menyediakan data untuk DataTables dengan server-side processing.
     * Endpoint ini dipanggil oleh AJAX dari halaman laporan.
     */
    public function getData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;

        // Query dasar, hanya mengambil order dari cabang admin yang login
        $query = BuatOrder::with('pelanggan')->where('cabang_id', $cabangId);

        // Terapkan filter tahun jika ada
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Terapkan filter bulan jika ada
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        
        // Ambil semua hasil yang sudah difilter untuk diproses di PHP
        $filteredOrders = $query->orderBy('created_at', 'desc')->get();

        // Hitung total pemasukan dari data yang sudah difilter
        $totalPemasukan = $filteredOrders->sum('total_harga');

        // Kelompokkan data berdasarkan Bulan & Tahun
        $groupedData = $filteredOrders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y-m');
        })->map(function ($ordersInMonth) {
            
            $details = $ordersInMonth->map(function($order) {
                // Dekode JSON layanan jika perlu
                $layananItems = json_decode($order->layanan, true) ?? [];
                $layananStr = collect($layananItems)->map(function($item) {
                    return ($item['nama'] ?? 'N/A') . ' (' . ($item['kuantitas'] ?? 0) . 'x)';
                })->implode(', ');

                return [
                    'date'     => $order->created_at,
                    'customer' => optional($order->pelanggan)->nama ?? 'N/A',
                    'service'  => $layananStr,
                    'total'    => $order->total_harga,
                ];
            });

            // Ambil data bulan dari order pertama dalam grup
            $firstOrderDate = Carbon::parse($ordersInMonth->first()->created_at);

            return [
                'monthName'    => $firstOrderDate->locale('id')->isoFormat('MMMM YYYY'),
                'orderCount'   => $ordersInMonth->count(),
                'totalRevenue' => $ordersInMonth->sum('total_harga'),
                'details'      => $details,
            ];
        });
        
        // Format respons sesuai yang diharapkan DataTables
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $groupedData->count(),
            'recordsFiltered' => $groupedData->count(),
            'data' => array_values($groupedData->toArray()),
            'totalPemasukanKeseluruhan' => $totalPemasukan,
        ]);
    }
}