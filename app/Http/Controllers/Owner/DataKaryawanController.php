<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class DataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        $selectedCabang = $request->input('cabang_id');
        $adminQuery = User::where('usertype', 'admin')->with('cabang');

        if ($selectedCabang && $selectedCabang !== 'semua') {
            $adminQuery->where('cabang_id', $selectedCabang);
        }
        $admins = $adminQuery->latest()->get()->groupBy('cabang.nama_cabang');

        return view('owner.dataadmin.index', compact('admins', 'cabangs', 'selectedCabang'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->route('owner.dataadmin.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_type', 'add');
        }

        User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'usertype' => 'admin',
            'cabang_id' => $request->cabang_id,
        ]);

        return redirect()->route('owner.dataadmin.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function show(User $dataadmin)
    {
        if ($dataadmin->usertype !== 'admin') {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($dataadmin);
    }

    public function update(Request $request, User $dataadmin)
    {
         $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $dataadmin->id],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return redirect()->route('owner.dataadmin.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_type', 'edit') 
                ->with('error_id', $dataadmin->id); 
        }

        $dataadmin->update([
            'name' => $request->name,
            'cabang_id' => $request->cabang_id,
        ]);

        if ($request->filled('password')) {
            $dataadmin->update([
                'password' => Hash::make($request->password),
                'plain_password' => $request->password,
            ]);
        }

        return redirect()->route('owner.dataadmin.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $dataadmin)
    {
        try {
            if ($dataadmin->usertype !== 'admin') {
                 return back()->with('error', 'Gagal menghapus pengguna.');
            }
            $dataadmin->delete();
            return redirect()->route('owner.dataadmin.index')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus admin.');
        }
    }


    // ====================================================================
    // [BARU] METHOD UNTUK MELAYANI AJAX DATATABLES
    // ====================================================================

    /**
     * Menyediakan data admin untuk DataTables dengan server-side processing.
     */
    public function getAdminsData(Request $request)
    {
        // Query dasar hanya untuk user dengan role 'admin'
        $query = User::with('cabang')->where('usertype', 'admin');

        // Filter berdasarkan cabang yang dipilih
        if ($request->filled('cabang_id') && $request->cabang_id != 'semua') {
            $query->where('cabang_id', $request->cabang_id);
        }

        // Filter berdasarkan pencarian DataTables
        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('cabang', function($cq) use ($searchValue) {
                      $cq->where('nama_cabang', 'like', '%' . $searchValue . '%');
                  });
            });
        }

        // Hitung total record sebelum paginasi
        $recordsFiltered = $query->count();
        
        // Ambil data sesuai paginasi dari DataTables
        $admins = $query->skip($request->start)
                        ->take($request->length)
                        ->latest()
                        ->get();

        // Format data untuk respons JSON
        $data = [];
        foreach ($admins as $key => $admin) {
            $data[] = [
                'no' => $request->start + $key + 1,
                'name' => $admin->name,
                'nama_cabang' => $admin->cabang->nama_cabang ?? 'Tidak Terkait',
                'plain_password' => $admin->plain_password,
                'id' => $admin->id,
                'cabang_id' => $admin->cabang_id,
            ];
        }
        
        $totalRecords = User::where('usertype', 'admin')->count();

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}