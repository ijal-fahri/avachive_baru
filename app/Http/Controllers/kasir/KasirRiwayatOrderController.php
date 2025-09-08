<?php

namespace App\Http\Controllers\kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;

class KasirRiwayatOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil nilai perPage dari request, jika tidak ada gunakan nilai dari session atau default 10
        $perPage = $request->get('perPage', session('perPage', 10));
        
        // Simpan pilihan perPage ke session
        if ($request->has('perPage')) {
            session(['perPage' => $request->get('perPage')]);
        }
        
        $query = BuatOrder::with('pelanggan')
            ->where('status', 'Selesai');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pelanggan', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('no_handphone', 'like', "%{$search}%");
            });
        }

        // Jika perPage adalah 'all', gunakan get() tanpa pagination
        if ($perPage === 'all') {
            $historyOrders = $query->orderBy('created_at', 'desc')->get();
            // Convert to LengthAwarePaginator dengan jumlah item sangat besar
            $historyOrders = new \Illuminate\Pagination\LengthAwarePaginator(
                $historyOrders,
                $historyOrders->count(),
                1000000, // items per page sangat besar
                1, // current page
                [
                    'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                    'pageName' => 'page'
                ]
            );
        } else {
            $historyOrders = $query->orderBy('created_at', 'desc')->paginate($perPage);
        }

        return view('kasir.riwayat_order', compact('historyOrders', 'perPage'));
    }
}