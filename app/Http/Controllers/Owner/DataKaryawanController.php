<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class DataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $cabangs = Cabang::orderBy('nama_cabang')->get();
        // Cukup kirim data cabang, DataTables akan menangani sisanya
        return view('owner.dataadmin.index', compact('cabangs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['required', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Validasi foto
        ]);

        if ($validator->fails()) {
            return redirect()->route('owner.dataadmin.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_type', 'add');
        }

        $data = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password,
            'usertype' => 'admin',
            'cabang_id' => $request->cabang_id,
        ];

        // Proses upload foto jika ada
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo'] = $path;
        }

        User::create($data);

        return redirect()->route('owner.dataadmin.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function show(User $dataadmin)
    {
        if ($dataadmin->usertype !== 'admin') {
            return response()->json(['message' => 'Not Found'], 404);
        }
        // Kirim response dengan path foto yang sudah di-format
        $dataadmin->profile_photo_url = $dataadmin->profile_photo ? asset('storage/' . $dataadmin->profile_photo) : null;
        return response()->json($dataadmin);
    }

    public function update(Request $request, User $dataadmin)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $dataadmin->id],
            'cabang_id' => ['required', 'exists:cabangs,id'],
            'password' => ['nullable', Rules\Password::defaults()],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // Validasi foto
        ]);

        if ($validator->fails()) {
            return redirect()->route('owner.dataadmin.index')
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal_type', 'edit')
                ->with('error_id', $dataadmin->id);
        }

        $dataToUpdate = [
            'name' => $request->name,
            'cabang_id' => $request->cabang_id,
        ];

        // Proses update password jika diisi
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
            $dataToUpdate['plain_password'] = $request->password;
        }

        // Proses update foto jika ada file baru
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($dataadmin->profile_photo) {
                Storage::disk('public')->delete($dataadmin->profile_photo);
            }
            // Simpan foto baru
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $dataToUpdate['profile_photo'] = $path;
        }

        $dataadmin->update($dataToUpdate);

        return redirect()->route('owner.dataadmin.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    public function destroy(User $dataadmin)
    {
        try {
            if ($dataadmin->usertype !== 'admin') {
                return back()->with('error', 'Gagal menghapus pengguna.');
            }

            // Hapus foto dari storage sebelum hapus data user
            if ($dataadmin->profile_photo) {
                Storage::disk('public')->delete($dataadmin->profile_photo);
            }

            $dataadmin->delete();
            return redirect()->route('owner.dataadmin.index')->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus admin.');
        }
    }

    public function getAdminsData(Request $request)
    {
        $query = User::with('cabang')->where('usertype', 'admin');

        if ($request->filled('cabang_id') && $request->cabang_id != 'semua') {
            $query->where('cabang_id', $request->cabang_id);
        }

        if ($request->filled('search.value')) {
            $searchValue = $request->input('search.value');
            $query->where(function($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                  ->orWhereHas('cabang', function($cq) use ($searchValue) {
                      $cq->where('nama_cabang', 'like', '%' . $searchValue . '%');
                  });
            });
        }

        $recordsFiltered = $query->count();
        
        $admins = $query->skip($request->start)
                        ->take($request->length)
                        ->latest()
                        ->get();

        $data = [];
        foreach ($admins as $key => $admin) {
            $data[] = [
                'no' => $request->start + $key + 1,
                'profile_photo' => $admin->profile_photo, // Kirim path foto
                'name' => $admin->name,
                'nama_cabang' => $admin->cabang->nama_cabang ?? 'Tidak Terkait',
                'plain_password' => $admin->plain_password,
                'id' => $admin->id,
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