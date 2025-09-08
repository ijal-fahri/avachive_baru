<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerOrderController extends Controller
{
    /**
     * Menampilkan halaman manajemen order dengan data dinamis.
     */
    public function index(Request $request)
    {
        // 1. Menghitung jumlah order untuk setiap status secara akurat
        $statusCounts = collect([
            'Diproses' => BuatOrder::where('status', 'Diproses')->count(),
            'Siap diambil' => BuatOrder::where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Ambil Sendiri')->count(),
            'Siap diantar' => BuatOrder::where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Diantar')->count(),
            'Selesai' => BuatOrder::where('status', 'Selesai')->count(),
        ]);

        // 2. Query dasar untuk mengambil semua order dengan relasinya
        $orderQuery = BuatOrder::with(['pelanggan', 'cabang'])->latest();

        // 3. Terapkan filter berdasarkan status yang diklik dari kartu (DIPERBAIKI)
        $filterStatus = $request->query('status');
        if ($filterStatus && $filterStatus !== 'semua') {
            if ($filterStatus === 'Siap diambil') {
                $orderQuery->where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Ambil Sendiri');
            } elseif ($filterStatus === 'Siap diantar') {
                $orderQuery->where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Diantar');
            } else {
                $orderQuery->where('status', $filterStatus);
            }
        }
        
        // 4. Terapkan filter pencarian
        $searchQuery = $request->query('search');
        if ($searchQuery) {
            $orderQuery->where(function($q) use ($searchQuery) {
                $q->where('id', 'like', "%{$searchQuery}%")
                  ->orWhereHas('pelanggan', function($subQ) use ($searchQuery) {
                      $subQ->where('nama', 'like', "%{$searchQuery}%");
                  });
            });
        }

        // 5. Ambil data order dengan pagination
        $orders = $orderQuery->paginate(10)->withQueryString();

        // 6. Kirim semua data ke view
        return view('owner.manage.index', [
            'orders' => $orders,
            'statusCounts' => $statusCounts,
            'filterStatus' => $filterStatus ?: 'semua',
            'searchQuery' => $searchQuery,
        ]);
    }
}

