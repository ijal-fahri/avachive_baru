<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DataOrderController extends Controller
{
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
    
    // Metode updateStatus Anda tetap sama
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
}
