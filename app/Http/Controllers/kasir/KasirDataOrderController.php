<?php

namespace App\Http\Controllers\kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuatOrder;
use App\Models\TambahPelanggan;
use Illuminate\Support\Facades\Auth; // pastikan sudah di-import

class KasirDataOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cabangId = Auth::user()->cabang_id;

        // Query utama: filter cabang dan relasi pelanggan
        $query = BuatOrder::with('pelanggan')->where('cabang_id', $cabangId);

        $perPage = $request->get('perPage', session('perPage', 10));
        if ($request->has('perPage')) {
            session(['perPage' => $request->get('perPage')]);
        }

        // Fitur pencarian
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('pelanggan', function ($q2) use ($searchTerm) {
                    $q2->where('nama', 'like', '%' . $searchTerm . '%');
                })->orWhere('id', 'like', '%' . $searchTerm . '%');
            });
        }

        // Fitur filter status
        if ($request->has('status') && $request->status != 'Semua') {
            $query->where('status', $request->status);
        }

        // Pisahkan order yang belum selesai dan yang sudah selesai
        if ($perPage === 'all') {
            $orders = $query->where('status', '!=', 'Selesai')->orderBy('created_at', 'desc')->get();
            $orders = new \Illuminate\Pagination\LengthAwarePaginator(
                $orders,
                $orders->count(),
                1000000,
                1,
                [
                    'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                    'pageName' => 'page'
                ]
            );
        } else {
            $orders = $query->where('status', '!=', 'Selesai')->orderBy('created_at', 'desc')->paginate($perPage);
        }

        // History order juga harus difilter cabang!
        $historyOrders = BuatOrder::with('pelanggan')
            ->where('cabang_id', $cabangId)
            ->where('status', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kasir.data_order', compact('orders', 'historyOrders', 'perPage'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, BuatOrder $order)
    {
        $request->validate(['status' => 'required|in:Diproses,Sudah Bisa Diambil,Selesai']);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status berhasil diubah!', 'order' => $order]);
    }
}