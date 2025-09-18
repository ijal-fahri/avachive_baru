<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\OwnerDashboardController;
use App\Http\Controllers\Owner\OwnerOrderController;
use App\Http\Controllers\Owner\DataKaryawanController;
use App\Http\Controllers\Owner\OwnerLaporanController;
use App\Http\Controllers\Owner\OwnerCabangController;
use App\Http\Controllers\Owner\OwnerDataKaryawanController;
use App\Http\Controllers\Owner\ProfileController as OwnerProfileController;

// --- DAFTAR SEMUA CONTROLLER ANDA ---
// Auth & Roles
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\DriverController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CabangController;
use App\Http\Controllers\Admin\LayananController;
use App\Http\Controllers\Admin\DataOrderController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Middleware\EnsureCabangIsSelected;

// Kasir Controllers
use App\Http\Controllers\kasir\KasirPelangganController;
use App\Http\Controllers\kasir\KasirBuatOrderController;
use App\Http\Controllers\kasir\KasirDataOrderController;
use App\Http\Controllers\kasir\KasirSettingsController;
use App\Http\Controllers\kasir\KasirRiwayatOrderController;

// Driver Controllers
use App\Http\Controllers\driver\DriverPengaturanController;
use App\Http\Controllers\driver\DriverRiwayatController;

// Pelanggan Controllers
use App\Http\Controllers\pelanggan\HomePelangganController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Route otentikasi dari Laravel Breeze/UI
require __DIR__.'/auth.php';


// --- SEMUA ROUTE YANG MEMBUTUHKAN LOGIN ---
Route::middleware('auth')->group(function () {

    // Rute Profile (umum untuk semua user)
    // Catatan: Anda belum mendefinisikan ProfileController umum, ini mungkin menyebabkan error.
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    
    // --- GRUP ROUTE UNTUK ADMIN ---
    Route::middleware(['admin', EnsureCabangIsSelected::class])->prefix('admin')->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Fitur Cabang
        Route::get('/set-cabang/{cabang}', [DashboardController::class, 'setCabangAktif'])->name('admin.set_cabang');
        Route::resource('cabang', CabangController::class)->except(['index', 'create', 'edit']);

        // Fitur Order Admin
        Route::get('/order', [DataOrderController::class, 'index'])->name('dataorder');
        Route::patch('/order/{order}/status', [DataOrderController::class, 'updateStatus'])->name('admin.order.updateStatus');

        // Fitur Layanan (Produk)
        Route::resource('produk', LayananController::class);
        Route::post('/layanan/data', [LayananController::class, 'getLayananData'])->name('layanan.data');

        // Fitur Pengguna (Karyawan)
        Route::resource('pengguna', PenggunaController::class)->names(['index' => 'datauser']);
        Route::post('/karyawan/data', [PenggunaController::class, 'getKaryawanData'])->name('karyawan.data');

        // Fitur Pengaturan
        Route::get('/pengaturan', function () { return view('pengaturan'); })->name('pengaturan');

        // Fitur Laporan
        // Route API untuk fungsionalitas AJAX di halaman laporan
        Route::get('/laporan/filters', [DataOrderController::class, 'getFilterOptions'])->name('laporan.filters');
        Route::post('/laporan/data', [DataOrderController::class, 'getData'])->name('laporan.data');
    });


    // --- GRUP ROUTE UNTUK KASIR ---
    Route::middleware('kasir')->prefix('kasir')->group(function () {
        Route::get('/dashboard', [KasirController::class, 'index'])->name('kasir.dashboard');
        Route::resource('/pelanggan', KasirPelangganController::class);
        Route::resource('/buat_order', KasirBuatOrderController::class);
        Route::get('/pengaturan', [KasirSettingsController::class, 'index'])->name('kasir.pengaturan.index');
        Route::put('/pengaturan/{id}', [KasirSettingsController::class, 'update'])->name('kasir.pengaturan.update');
        Route::get('/data_order', [KasirDataOrderController::class, 'index'])->middleware('auth','kasir')->name('kasir.dataorder.index');
        Route::patch('/data_order/{order}/status', [KasirDataOrderController::class, 'updateStatus'])->middleware('auth','kasir')->name('kasir.dataorder.update_status');
        Route::get('/riwayat_order', [KasirRiwayatOrderController::class, 'index'])->name('kasir.riwayatorder.index');
        Route::post('/data_order/{id}/bayar', [KasirBuatOrderController::class, 'bayar'])->name('kasir.dataorder.bayar');
        Route::get('/riwayat_order/{order}/cetak', [KasirController::class, 'cetakRiwayatOrder'])->name('kasir.riwayatorder.cetak');
    });


    // --- GRUP ROUTE UNTUK DRIVER ---
    Route::middleware('driver')->prefix('driver')->group(function () {
        Route::get('/dashboard', [DriverController::class, 'index'])->name('driver.dashboard');
        Route::post('/pengiriman/{id}/lunaskan', [DriverController::class, 'lunaskanPembayaran'])->name('driver.order.lunaskan');
        Route::resource('/riwayat', DriverRiwayatController::class);
        Route::get('/pengaturan', [DriverPengaturanController::class, 'index'])->name('driver.pengaturan.index');
        Route::put('/pengaturan/{id}', [DriverPengaturanController::class, 'update'])->name('driver.pengaturan.update');
        Route::post('/pengiriman/{id}/update-status', [DriverController::class, 'orderSelesai'])->name('driver.order.update-status');
    });

    // route untuk pelanggan 
    Route::middleware(['auth', 'pelanggan'])->prefix('pelanggan')->group(function () {
    Route::get('/home', [HomePelangganController::class, 'index'])->name('pelanggan.home');
    // Tambahkan route lain khusus pelanggan di sini
});

});
Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/manage', [OwnerOrderController::class, 'index'])->name('manage');
    
    // --- Profile ---
    Route::get('/profile', [OwnerProfileController::class, 'index'])->name('profile');
    // PERBAIKAN DI SINI: Menambahkan route untuk update password
    Route::patch('/profile/password', [OwnerProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // --- Laporan ---
    Route::get('/laporan', [OwnerLaporanController::class, 'index'])->name('laporan.index');
    
    // --- CRUD Cabang (digunakan oleh halaman laporan) ---
    Route::post('/cabang', [OwnerCabangController::class, 'store'])->name('cabang.store');
    Route::get('/cabang/{cabang}', [OwnerCabangController::class, 'show'])->name('cabang.show');
    Route::put('/cabang/{cabang}', [OwnerCabangController::class, 'update'])->name('cabang.update');
    Route::delete('/cabang/{cabang}', [OwnerCabangController::class, 'destroy'])->name('cabang.destroy');
    
    // --- CRUD Admin ---
    Route::resource('/dataadmin', DataKaryawanController::class)->except(['create', 'edit'])->names('dataadmin');
    Route::post('/admins/data', [DataKaryawanController::class, 'getAdminsData'])->name('admins.data');

    // --- CRUD Karyawan ---
    Route::resource('/datakaryawan', OwnerDataKaryawanController::class)->except(['create', 'edit'])->names('datakaryawan');
    // [BARU] Route API untuk mengambil data karyawan (owner view) via AJAX
    Route::post('/karyawan/data', [OwnerDataKaryawanController::class, 'getKaryawanData'])->name('datakaryawan.data');
    
});