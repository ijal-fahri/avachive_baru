<?php

namespace App\Http\Controllers\pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use Carbon\Carbon;

class PelangganRiwayatOrderController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = TambahPelanggan::where('user_id', Auth::id())->first();

        if (!$pelanggan) {
            return view('pelanggan.riwayat_order', ['orders' => collect()]);
        }

        // Mulai query dan filter HANYA yang statusnya 'Selesai'
        $query = BuatOrder::query()
            ->where('tambah_pelanggan_id', $pelanggan->id)
            ->where('status', 'Selesai');

        // Filter tanggal mulai (berdasarkan created_at - tanggal order dibuat)
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        // Filter tanggal selesai (berdasarkan updated_at - tanggal order selesai)
        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('updated_at', '<=', $endDate);
        }

        // Filter pencarian (no order atau layanan)
       if ($request->filled('search')) {
    $searchTerm = $request->search;

    $query->where(function ($q) use ($searchTerm) {
        // Cek apakah input search berupa angka saja
        if (ctype_digit($searchTerm)) {
            // Cari id yang sama dengan angka input
            $q->where('id', $searchTerm);
        } else {
            // Cari nomor order yang mengandung input (misal ORD00000006)
            $q->whereRaw("CONCAT('ORD', LPAD(id, 8, '0')) LIKE ?", ["%{$searchTerm}%"])
              ->orWhere('layanan', 'LIKE', "%{$searchTerm}%");
        }
    });
}

        
        // Pengurutan
        $sortBy = $request->input('sort_by', 'terbaru');
        switch ($sortBy) {
            case 'terlama':
                $query->orderBy('updated_at', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('total_harga', 'desc');
                break;
            case 'harga_terendah':
                $query->orderBy('total_harga', 'asc');
                break;
            default: // terbaru
                $query->orderBy('updated_at', 'desc');
                break;
        }

        // Ambil data dengan pagination (10 item per halaman)
        $orders = $query->paginate(10)->withQueryString();

        return view('pelanggan.riwayat_order', ['orders' => $orders]);
    }
}
