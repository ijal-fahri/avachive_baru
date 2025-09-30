<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\BuatOrder;
use App\Models\User;
use App\Models\Layanan; // Tambahkan ini
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ViewServiceProviders extends ServiceProvider
{
    public function register(): void
    {
        // Method ini sengaja dikosongkan.
    }
    
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // OWNER
                if ($user->usertype == 'owner') {
                    
                    // 1. Notifikasi Dashboard (Pergerakan Data Order)
                    $dashboardNotificationCount = 0;
                    if (session()->has('last_dashboard_check')) {
                        $lastCheck = Carbon::parse(session('last_dashboard_check'));
                        $dashboardNotificationCount = BuatOrder::where('updated_at', '>', $lastCheck)->count();
                    }

                    // 2. Notifikasi Manajemen Order (Order Baru 'Diproses')
                    $activeOrderNotificationCount = 0;
                    if (session()->has('last_manage_check')) {
                        $lastCheck = Carbon::parse(session('last_manage_check'));
                        $activeOrderNotificationCount = BuatOrder::where('status', 'Diproses')
                            ->where('created_at', '>', $lastCheck)
                            ->count();
                    } else {
                        $activeOrderNotificationCount = BuatOrder::where('status', 'Diproses')->count();
                    }

                    // 3. Notifikasi Data Cabang (Order 'Selesai' yang baru) - Diubah ke basis waktu
                    $completedOrderNotificationCount = 0;
                    if (session()->has('last_cabang_check')) {
                        $lastCheck = Carbon::parse(session('last_cabang_check'));
                        $completedOrderNotificationCount = BuatOrder::where('status', 'Selesai')
                            ->where('updated_at', '>', $lastCheck)
                            ->count();
                    } else {
                        $completedOrderNotificationCount = BuatOrder::where('status', 'Selesai')->count();
                    }

                    // 4. Notifikasi Data Karyawan (Karyawan Baru) - Diubah ke basis waktu
                    $karyawanNotificationCount = 0;
                    if (session()->has('last_karyawan_check')) {
                        $lastCheck = Carbon::parse(session('last_karyawan_check'));
                        $karyawanNotificationCount = User::whereIn('usertype', ['kasir', 'driver'])
                            ->where('created_at', '>', $lastCheck)
                            ->count();
                    } else {
                        $karyawanNotificationCount = User::whereIn('usertype', ['kasir', 'driver'])->count();
                    }

                    $view->with(compact('activeOrderNotificationCount', 'completedOrderNotificationCount', 'dashboardNotificationCount', 'karyawanNotificationCount'));

                // ADMIN
                } elseif ($user->usertype == 'admin') {
                    // --- Logika notifikasi admin (tetap sama) ---
                    $cabangId = $user->cabang_id;
                    $dashboardNotificationCount = 0;
                    if (session()->has('last_dashboard_check_admin_' . $cabangId)) {
                        $lastCheck = Carbon::parse(session('last_dashboard_check_admin_' . $cabangId));
                        $dashboardNotificationCount = BuatOrder::where('cabang_id', $cabangId)
                            ->where('updated_at', '>', $lastCheck)
                            ->count();
                    }
                    $activeOrderNotificationCount = 0;
                    if (session()->has('last_order_report_check_admin_' . $cabangId)) {
                        $lastCheck = Carbon::parse(session('last_order_report_check_admin_' . $cabangId));
                        $activeOrderNotificationCount = BuatOrder::where('cabang_id', $cabangId)
                            ->where('status', 'Diproses')
                            ->where('created_at', '>', $lastCheck)
                            ->count();
                    } else {
                        $activeOrderNotificationCount = BuatOrder::where('cabang_id', $cabangId)
                            ->where('status', 'Diproses')
                            ->count();
                    }
                    $karyawanNotificationCount = 0;
                    $sessionKey = 'last_karyawan_check_admin_' . $cabangId;
                    if (session()->has($sessionKey)) {
                        $lastCheck = Carbon::parse(session($sessionKey));
                        $karyawanNotificationCount = User::where('cabang_id', $cabangId)
                            ->whereIn('usertype', ['kasir', 'driver'])
                            ->where('created_at', '>', $lastCheck)
                            ->count();
                    } else {
                        $karyawanNotificationCount = User::where('cabang_id', $cabangId)
                            ->whereIn('usertype', ['kasir', 'driver'])
                            ->count();
                    }
                    $view->with(compact('dashboardNotificationCount', 'activeOrderNotificationCount', 'karyawanNotificationCount'));

                // DRIVER
                } elseif ($user->usertype == 'driver') {
                    // --- Logika notifikasi driver (tetap sama) ---
                    $driverNotificationCount = 0;
                    if (session()->has('last_driver_dashboard_check')) {
                        $lastCheck = Carbon::parse(session('last_driver_dashboard_check'));
                        $driverNotificationCount = BuatOrder::where('cabang_id', $user->cabang_id)
                            ->where('status', 'Sudah Bisa Diambil')
                            ->where('metode_pengambilan', 'Diantar')
                            ->where('updated_at', '>', $lastCheck)
                            ->count();
                    } else {
                        $driverNotificationCount = BuatOrder::where('cabang_id', $user->cabang_id)
                            ->where('status', 'Sudah Bisa Diambil')
                            ->where('metode_pengambilan', 'Diantar')
                            ->count();
                    }
                    $view->with('driverNotificationCount', $driverNotificationCount);

                // JIKA YANG LOGIN ADALAH KASIR
} elseif ($user->usertype == 'kasir') {
    
    $cabangId = $user->cabang_id;
    
    // Debug: Cek apakah cabang_id ada
    if (!$cabangId) {
        \Log::error('Kasir tidak memiliki cabang_id', ['user_id' => $user->id]);
    }
    
    // 1. Notifikasi Order Baru (Status: 'Diproses') untuk kasir
    $newOrderNotificationCount = 0;
    if (session()->has('last_new_order_check_kasir_' . $cabangId)) {
        $lastCheck = Carbon::parse(session('last_new_order_check_kasir_' . $cabangId));
        $newOrderNotificationCount = BuatOrder::where('cabang_id', $cabangId)
            ->where('status', 'Diproses')
            ->where('created_at', '>', $lastCheck)
            ->count();
    } else {
        // Jika belum ada session, hitung semua order dengan status Diproses
        $newOrderNotificationCount = BuatOrder::where('cabang_id', $cabangId)
            ->where('status', 'Diproses')
            ->count();
    }

    // 2. Notifikasi Order Siap Diambil (Status: 'Sudah Bisa Diambil') untuk kasir
    $readyOrderNotificationCount = 0;
    if (session()->has('last_ready_order_check_kasir_' . $cabangId)) {
        $lastCheck = Carbon::parse(session('last_ready_order_check_kasir_' . $cabangId));
        $readyOrderNotificationCount = BuatOrder::where('cabang_id', $cabangId)
            ->where('status', 'Sudah Bisa Diambil')
            ->where('metode_pengambilan', '!=', 'Diantar')
            ->where('updated_at', '>', $lastCheck)
            ->count();
    } else {
        $readyOrderNotificationCount = BuatOrder::where('cabang_id', $cabangId)
            ->where('status', 'Sudah Bisa Diambil')
            ->where('metode_pengambilan', '!=', 'Diantar')
            ->count();
    }

    // 3. Notifikasi Layanan Baru (Layanan yang baru ditambahkan oleh admin)
    $newServiceNotificationCount = 0;
    if (session()->has('last_service_check_kasir_' . $cabangId)) {
        $lastCheck = Carbon::parse(session('last_service_check_kasir_' . $cabangId));
        $newServiceNotificationCount = Layanan::where('cabang_id', $cabangId)
            ->where('created_at', '>', $lastCheck)
            ->count();
    } else {
        // Jika belum ada session, hitung semua layanan di cabang ini
        $newServiceNotificationCount = Layanan::where('cabang_id', $cabangId)->count();
    }

    // 4. Notifikasi Layanan Baru di Dashboard Kasir
    $dashboardNewServiceCount = 0;
    if (session()->has('last_dashboard_service_check_kasir_' . $cabangId)) {
        $lastCheck = Carbon::parse(session('last_dashboard_service_check_kasir_' . $cabangId));
        $dashboardNewServiceCount = Layanan::where('cabang_id', $cabangId)
            ->where('created_at', '>', $lastCheck)
            ->count();
    } else {
        // Jika belum ada session, hitung semua layanan di cabang ini
        $dashboardNewServiceCount = Layanan::where('cabang_id', $cabangId)->count();
    }

    // Debug: Log nilai notifikasi
    \Log::info('Notifikasi Kasir', [
        'cabang_id' => $cabangId,
        'new_order_count' => $newOrderNotificationCount,
        'ready_order_count' => $readyOrderNotificationCount,
        'new_service_count' => $newServiceNotificationCount
    ]);

    $view->with(compact(
        'newOrderNotificationCount',
        'readyOrderNotificationCount',
        'newServiceNotificationCount',
        'dashboardNewServiceCount' // tambahkan ini
    ));
}
            }
        });
    }
}