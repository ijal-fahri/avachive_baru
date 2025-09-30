<?php

namespace App\Http\Controllers\pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BuatOrder;
use App\Models\Layanan;

class PelangganHomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pelanggan = $user->pelanggan;

        if (!$pelanggan) {
            return view('pelanggan.home_kosong');
        }

        // --- 1. Statistik Order ---
        $stats = [
            'hari_ini' => BuatOrder::where('tambah_pelanggan_id', $pelanggan->id)
                ->whereDate('created_at', today())
                ->count(),
            'selesai' => BuatOrder::where('tambah_pelanggan_id', $pelanggan->id)
                ->where('status', 'Selesai')
                ->count(),
            'diproses' => BuatOrder::where('tambah_pelanggan_id', $pelanggan->id)
                ->whereNotIn('status', ['Selesai', 'Dibatalkan', 'Gagal'])
                ->count(),
        ];

        // --- 2. Order Terbaru ---
        $orderTerbaru = BuatOrder::where('tambah_pelanggan_id', $pelanggan->id)
            ->whereDate('created_at', today())
            ->whereIn('status', ['Diproses', 'Sudah Bisa Diambil'])
            ->latest()
            ->get();

        // --- 3. Promo Spesial ---
        // Mengambil SEMUA promo untuk slider, diurutkan dari diskon terbesar
        $semuaPromo = Layanan::where('cabang_id', $user->cabang_id)
            ->where('diskon', '>', 0)
            ->orderBy('diskon', 'desc')
            ->get();

        // --- 4. Layanan Favorit ---
        $semuaOrderPelanggan = BuatOrder::where('tambah_pelanggan_id', $pelanggan->id)->get();
        $frekuensiLayanan = [];

        foreach ($semuaOrderPelanggan as $order) {
            $layananDipesan = json_decode($order->layanan, true);
            if (is_array($layananDipesan)) {
                foreach ($layananDipesan as $item) {
                    $namaLayanan = $item['nama'] ?? null;
                    if ($namaLayanan) {
                        if (!isset($frekuensiLayanan[$namaLayanan])) {
                            $frekuensiLayanan[$namaLayanan] = 0;
                        }
                        $frekuensiLayanan[$namaLayanan]++;
                    }
                }
            }
        }
        
        arsort($frekuensiLayanan);
        $namaLayananFavorit = array_keys(array_slice($frekuensiLayanan, 0, 3, true));
        
        $layananFavorit = Layanan::where('cabang_id', $user->cabang_id)
            ->whereIn('nama', $namaLayananFavorit)
            ->get()
            ->keyBy('nama'); 

        return view('pelanggan.home', compact(
            'stats',
            'orderTerbaru',
            'semuaPromo', // Variabel yang dikirim ke view adalah semuaPromo
            'layananFavorit',
            'frekuensiLayanan'
        ));
    }

// app/Http/Controllers/pelanggan/PelangganHomeController.php

public function orderDetail($id)
{
    $user = Auth::user();
    $pelanggan = $user->pelanggan;

    // [FIX] Tambahkan pengecekan ini untuk menghindari error jika pelanggan tidak ada
    if (!$pelanggan) {
        // Mengembalikan response error yang jelas, bukan membuat server crash
        return response()->json(['message' => 'Profil pelanggan tidak ditemukan.'], 404);
    }

    $order = \App\Models\BuatOrder::where('id', $id)
        ->where('tambah_pelanggan_id', $pelanggan->id)
        ->first(); // Menggunakan first() agar tidak langsung error

    // [FIX] Tambahkan juga pengecekan jika order tidak ditemukan untuk pelanggan ini
    if (!$order) {
        return response()->json(['message' => 'Order tidak ditemukan.'], 404);
    }

    $layanan = json_decode($order->layanan, true);

    $estimasiSelesai = $order->updated_at->format('d M Y');
    if (strtolower($order->status) !== 'selesai' && strtolower($order->status) !== 'sudah bisa diambil') {
        $estimasiSelesai = $order->created_at->addDays(1)->format('d M Y');
    }

    return response()->json([
        'id' => $order->id_order ?? $order->id,
        'status' => $order->status,
        'created_at' => $order->created_at->format('d M Y'),
        'estimasi_selesai' => $estimasiSelesai,
        'total_harga' => 'Rp ' . number_format($order->total_harga, 0, ',', '.'),
        'layanan' => $layanan,
        'metode_pembayaran' => $order->metode_pembayaran,
    ]);
}
}

