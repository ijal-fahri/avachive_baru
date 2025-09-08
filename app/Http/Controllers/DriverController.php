<?php

namespace App\Http\Controllers;

use App\Models\BuatOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // <-- Diperlukan untuk mengambil data user

class DriverController extends Controller
{
    public function index()
    {
        // 1. Dapatkan ID cabang dari driver yang sedang login
        $cabangId = Auth::user()->cabang_id;
        
        // Keamanan: Jika driver tidak terhubung ke cabang, logout
        if (!$cabangId) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda tidak terhubung ke cabang manapun.');
        }

        $today = Carbon::today();

        // 2. Ambil semua order HANYA dari cabang ini
        $orders = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId) // <-- FILTER KUNCI DI SINI
            ->where('metode_pengambilan', 'Diantar')
            ->whereDate('created_at', $today)
            ->whereIn('status', ['Sudah Bisa Diambil', 'Selesai'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung jumlah order
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

    // Method untuk menyelesaikan order
    public function orderSelesai($id, Request $request)
    {
        try {
            $order = BuatOrder::findOrFail($id);

            // Keamanan: Pastikan driver hanya bisa mengubah order dari cabangnya
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

    // Method untuk melunaskan pembayaran
    public function lunaskanPembayaran($id, Request $request)
    {
        try {
            $order = BuatOrder::findOrFail($id);
            
            // Keamanan: Pastikan driver hanya bisa mengubah order dari cabangnya
            if ($order->cabang_id != Auth::user()->cabang_id) {
                abort(403, 'AKSES DITOLAK');
            }

            // Pastikan order belum lunas
            if ($order->sisa_harga <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order sudah lunas'
                ], 400);
            }
            
            // Lunaskan pembayaran
            $order->sisa_harga = 0;
            $order->metode_pembayaran = 'Tunai'; // Atau sesuai input dari driver
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dilunaskan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melunaskan pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }
}
