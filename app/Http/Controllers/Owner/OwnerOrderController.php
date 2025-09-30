<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OwnerOrderController extends Controller
{
    public function index(Request $request)
    {
        // [LOGIKA BARU] 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $lastVisit = session('last_manage_check');

        // [LOGIKA RESET] 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session(['last_manage_check' => now()]);

        
        // --- Sisa kode untuk menampilkan data (tetap sama) ---
        $statusCounts = collect([
            'Diproses' => BuatOrder::where('status', 'Diproses')->count(),
            'Siap diambil' => BuatOrder::where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Ambil Sendiri')->count(),
            'Siap diantar' => BuatOrder::where('status', 'Sudah Bisa Diambil')->where('metode_pengambilan', 'Diantar')->count(),
            'Selesai' => BuatOrder::where('status', 'Selesai')->count(),
        ]);
        
        $orderQuery = BuatOrder::with(['pelanggan', 'cabang'])->latest();
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
        $searchQuery = $request->query('search');
        if ($searchQuery) {
            $orderQuery->where(function($q) use ($searchQuery) {
                $q->where('id', 'like', "%{$searchQuery}%")
                  ->orWhereHas('pelanggan', function($subQ) use ($searchQuery) {
                      $subQ->where('nama', 'like', "%{$searchQuery}%");
                  });
            });
        }
        $orders = $orderQuery->paginate(10)->withQueryString();

        // [LOGIKA BARU] 3. Tambahkan penanda 'is_new' pada data order yang baru masuk
        if ($lastVisit) {
            $lastVisitTime = Carbon::parse($lastVisit);
            
            $orders->getCollection()->transform(function ($order) use ($lastVisitTime) {
                // Kriteria "baru" untuk halaman ini adalah order 'Diproses' yang dibuat setelah kunjungan terakhir.
                if ($order->status === 'Diproses') {
                    $order->is_new = Carbon::parse($order->created_at)->isAfter($lastVisitTime);
                } else {
                    $order->is_new = false;
                }
                return $order;
            });
        }

        return view('owner.manage.index', [
            'orders' => $orders,
            'statusCounts' => $statusCounts,
            'filterStatus' => $filterStatus ?: 'semua',
            'searchQuery' => $searchQuery,
        ]);
    }
}
