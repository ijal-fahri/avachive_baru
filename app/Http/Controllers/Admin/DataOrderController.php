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
     * Menampilkan halaman Laporan dan mereset notifikasi berbasis waktu.
     */
    public function index()
    {
        $cabangId = Auth::user()->cabang_id;
        $sessionKey = 'last_order_report_check_admin_' . $cabangId;

        // 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $lastVisit = session($sessionKey);

        // 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session([$sessionKey => now()]);
        
        // --- Logika lama Anda untuk tampilan awal tetap dipertahankan ---
        $orders = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($order) {
                return Carbon::parse($order->created_at)->format('Y-m-d');
            });

        $orderData = [];
        $availableYears = [];

        foreach ($orders as $date => $ordersOnDate) {
            $dailyTotal = $ordersOnDate->sum('total_harga');
            
            $year = Carbon::parse($date)->format('Y');
            if (!in_array($year, $availableYears)) {
                $availableYears[] = $year;
            }

            $orderData[$date] = [
                'orders' => $ordersOnDate,
                'total_pemasukan' => $dailyTotal
            ];
        }

        rsort($availableYears);
        
        // 3. Kirim waktu kunjungan terakhir ke view.
        return view('order', [
            'order_groups' => $orderData,
            'years' => $availableYears,
            'lastVisit' => $lastVisit // <-- Variabel baru dikirim ke view
        ]);
    }
    
    /**
     * Metode update status (tidak diubah).
     */
    public function updateStatus(Request $request, BuatOrder $order)
    {
        if ($order->cabang_id != Auth::user()->cabang_id) {
            abort(403);
        }
        
        $request->validate(['status' => 'required|in:Diproses,Sudah Bisa Diambil,Selesai']);
        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status berhasil diubah!', 'order' => $order]);
    }

    /**
     * Menyediakan opsi filter (tidak diubah).
     */
    public function getFilterOptions()
    {
        $cabangId = Auth::user()->cabang_id;
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
     * Menyediakan data untuk DataTables dan menambahkan penanda "baru".
     */
    public function getData(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;
        
        // [LOGIKA BARU] Ambil waktu kunjungan terakhir dari request AJAX
        $lastVisitInput = $request->input('last_visit');
        $lastVisitTime = $lastVisitInput ? Carbon::parse($lastVisitInput) : null;

        $query = BuatOrder::with('pelanggan')->where('cabang_id', $cabangId);

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }
        
        $filteredOrders = $query->orderBy('created_at', 'desc')->get();
        $totalPemasukan = $filteredOrders->sum('total_harga');

        $groupedData = $filteredOrders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('Y-m');
        })->map(function ($ordersInMonth) use ($lastVisitTime) { // <-- Kirim $lastVisitTime ke dalam map
            
            $details = $ordersInMonth->map(function($order) use ($lastVisitTime) { // <-- Kirim lagi ke map inner
                $layananItems = json_decode($order->layanan, true) ?? [];
                $layananStr = collect($layananItems)->map(function($item) {
                    return ($item['nama'] ?? 'N/A') . ' (' . ($item['kuantitas'] ?? 0) . 'x)';
                })->implode(', ');

                // [LOGIKA BARU] Tentukan apakah order ini "baru"
                $isNew = $lastVisitTime && Carbon::parse($order->created_at)->isAfter($lastVisitTime);

                return [
                    'date'     => $order->created_at,
                    'customer' => optional($order->pelanggan)->nama ?? 'N/A',
                    'service'  => $layananStr,
                    'total'    => $order->total_harga,
                    'is_new'   => $isNew, // <-- Tambahkan penanda "baru" ke data JSON
                ];
            });

            $firstOrderDate = Carbon::parse($ordersInMonth->first()->created_at);

            return [
                'monthName'    => $firstOrderDate->locale('id')->isoFormat('MMMM YYYY'),
                'orderCount'   => $ordersInMonth->count(),
                'totalRevenue' => $ordersInMonth->sum('total_harga'),
                'details'      => $details,
            ];
        });
        
        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $groupedData->count(),
            'recordsFiltered' => $groupedData->count(),
            'data' => array_values($groupedData->toArray()),
            'totalPemasukanKeseluruhan' => $totalPemasukan,
        ]);
    }
}

