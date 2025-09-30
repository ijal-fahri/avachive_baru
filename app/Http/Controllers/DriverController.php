<?php

namespace App\Http\Controllers;

use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $cabangId = Auth::user()->cabang_id;
        
        if (!$cabangId) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda tidak terhubung ke cabang manapun.');
        }

        // [LOGIKA BARU] 1. Ambil waktu kunjungan terakhir SEBELUM di-reset.
        $lastVisit = session('last_driver_dashboard_check');

        // [LOGIKA RESET] 2. Reset notifikasi dengan mencatat waktu SEKARANG.
        session(['last_driver_dashboard_check' => now()]);

        // 3. Ambil semua order yang relevan untuk driver
        $orders = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId)
            ->where('metode_pengambilan', 'Diantar')
            ->whereIn('status', ['Sudah Bisa Diambil', 'Selesai'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) use ($lastVisit) {
                // [LOGIKA BARU] 4. Tandai sebagai 'baru' jika diupdate setelah kunjungan terakhir
                if ($lastVisit) {
                    $order->is_new = Carbon::parse($order->updated_at)->isAfter(Carbon::parse($lastVisit));
                } else {
                    // Jika ini kunjungan pertama (setelah session hilang), anggap semua yang 'Siap Diambil' adalah baru
                    $order->is_new = ($order->status === 'Sudah Bisa Diambil');
                }
                return $order;
            });

        // Hitungan di bawah ini sudah benar sesuai logika di atas.
        $countTotal = $orders->count();
        $countSudah = $orders->where('status', 'Selesai')->count();
        $countBelum = $orders->where('status', 'Sudah Bisa Diambil')->count();
        $countPercent = $countTotal > 0 ? round(($countSudah / $countTotal) * 100) : 0;

        return view('driver.dashboard', compact(
            'orders',
            'countTotal',
            'countBelum',
            'countSudah',
            'countPercent'
        ));
    }

    // Method untuk menyelesaikan order (tidak diubah)
    public function orderSelesai($id, Request $request)
    {
        try {
            $order = BuatOrder::findOrFail($id);

            if ($order->cabang_id != Auth::user()->cabang_id) {
                abort(403, 'AKSES DITOLAK');
            }

            $order->status = 'Selesai';
            $order->sisa_harga = 0;
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Status pengiriman berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk melunaskan pembayaran (tidak diubah)
    public function lunaskanPembayaran($id, Request $request)
    {
        try {
            $order = BuatOrder::findOrFail($id);
            
            if ($order->cabang_id != Auth::user()->cabang_id) {
                abort(403, 'AKSES DITOLAK');
            }

            if ($order->sisa_harga <= 0) {
                return response()->json(['success' => false, 'message' => 'Order sudah lunas'], 400);
            }
            
            $order->sisa_harga = 0;
            $order->metode_pembayaran = 'Tunai';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Pembayaran berhasil dilunaskan']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal melunaskan pembayaran: ' . $e->getMessage()], 500);
        }
    }
}

