{{-- ====================================================================== --}}
{{-- == 			SIDEBAR DESKTOP & NAVIGASI BAWAH OWNER 		         == --}}
{{-- ====================================================================== --}}

{{-- SIDEBAR UNTUK TAMPILAN DESKTOP (TIDAK ADA PERUBAHAN) --}}
<aside class="bg-slate-900 text-slate-300 w-64 min-h-screen p-4 fixed z-40 flex-col hidden md:flex">
    <div>
        <div class="flex flex-col items-center text-center mb-10">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Avachive" class="w-16 h-auto mb-2">
            <div class="text-2xl font-bold text-teal-400">Avachive Owner</div>
        </div>
        
        <nav class="space-y-3">
            {{-- Link Dashboard (Notif pergerakan data) --}}
            <a href="{{ route('owner.dashboard') }}"
               class="flex items-center justify-between py-3 px-4 rounded-lg {{ request()->routeIs('owner.dashboard*') ? 'bg-teal-400 text-slate-900 font-semibold shadow-lg' : 'hover:bg-slate-800 hover:text-white' }} transition-colors duration-200">
                <div class="flex items-center">
                    <i class="bi bi-grid-1x2-fill mr-4 text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </div>
                @if (isset($dashboardNotificationCount) && $dashboardNotificationCount > 0)
                    <span class="flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 animate-pulse">
                        {{ $dashboardNotificationCount }}
                    </span>
                @endif
            </a>

            {{-- Link Manajemen Order (Notif order baru) --}}
            <a href="{{ route('owner.manage') }}"
               class="flex items-center justify-between py-3 px-4 rounded-lg {{ request()->routeIs('owner.manage*') ? 'bg-teal-400 text-slate-900 font-semibold shadow-lg' : 'hover:bg-slate-800 hover:text-white' }} transition-colors duration-200">
                <div class="flex items-center">
                    <i class="bi bi-receipt-cutoff mr-4 text-lg"></i>
                    <span class="font-medium">Manajemen Order</span>
                </div>
                @if (isset($activeOrderNotificationCount) && $activeOrderNotificationCount > 0)
                    <span class="flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 animate-pulse">
                        {{ $activeOrderNotificationCount }}
                    </span>
                @endif
            </a>

            {{-- Link Data Cabang (Notif order selesai) --}}
            <a href="{{ route('owner.laporan.index') }}"
               class="flex items-center justify-between py-3 px-4 rounded-lg {{ request()->routeIs('owner.laporan.*') ? 'bg-teal-400 text-slate-900 font-semibold shadow-lg' : 'hover:bg-slate-800 hover:text-white' }} transition-colors duration-200">
                <div class="flex items-center">
                    <i class="bi bi-shop-window mr-4 text-lg"></i>
                    <span class="font-medium">Data Cabang</span>
                </div>
                @if (isset($completedOrderNotificationCount) && $completedOrderNotificationCount > 0)
                    <span class="flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 animate-pulse">
                        {{ $completedOrderNotificationCount }}
                    </span>
                @endif
            </a>

            {{-- Link Data Admin (tanpa notifikasi) --}}
            <a href="{{ route('owner.dataadmin.index') }}" class="flex items-center py-3 px-4 rounded-lg {{ request()->routeIs('owner.dataadmin.*') ? 'bg-teal-400 text-slate-900 font-semibold shadow-lg' : 'hover:bg-slate-800 hover:text-white' }} transition-colors duration-200">
                <i class="bi bi-person-badge-fill mr-4 text-lg"></i><span class="font-medium">Data Admin</span>
            </a>

            {{-- Link Data Karyawan (DENGAN NOTIFIKASI BARU) --}}
            <a href="{{ route('owner.datakaryawan.index') }}"
               class="flex items-center justify-between py-3 px-4 rounded-lg {{ request()->routeIs('owner.datakaryawan.*') ? 'bg-teal-400 text-slate-900 font-semibold shadow-lg' : 'hover:bg-slate-800 hover:text-white' }} transition-colors duration-200">
                <div class="flex items-center">
                    <i class="bi bi-people-fill mr-4 text-lg"></i>
                    <span class="font-medium">Data Karyawan</span>
                </div>
                 @if (isset($karyawanNotificationCount) && $karyawanNotificationCount > 0)
                    <span class="flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-6 h-6 animate-pulse">
                        {{ $karyawanNotificationCount }}
                    </span>
                @endif
            </a>
        </nav>
    </div>
</aside>

{{-- ===== [ NAVIGASI MOBILE DIPERBAIKI DENGAN NOTIFIKASI ANGKA ] ===== --}}
<nav class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] z-30 flex justify-around items-center">
    
    {{-- Link Dashboard --}}
    <a href="{{ route('owner.dashboard') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('owner.dashboard*') ? 'text-teal-400 font-semibold' : 'text-slate-500' }} hover:text-teal-400 transition-colors relative">
        <i class="bi bi-grid-1x2-fill text-2xl"></i>
        <span class="text-xs mt-1">Dashboard</span>
        @if (isset($dashboardNotificationCount) && $dashboardNotificationCount > 0)
            <span class="absolute top-1 right-4 flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 animate-pulse">
                {{ $dashboardNotificationCount }}
            </span>
        @endif
    </a>
    
    {{-- Link Manajemen Order --}}
    <a href="{{ route('owner.manage') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('owner.manage*') ? 'text-teal-400 font-semibold' : 'text-slate-500' }} hover:text-teal-400 transition-colors relative">
        <i class="bi bi-receipt-cutoff text-2xl"></i>
        <span class="text-xs mt-1">Order</span>
        @if (isset($activeOrderNotificationCount) && $activeOrderNotificationCount > 0)
             <span class="absolute top-1 right-4 flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 animate-pulse">
                {{ $activeOrderNotificationCount }}
            </span>
        @endif
    </a>
    
    {{-- Link Data Cabang --}}
    <a href="{{ route('owner.laporan.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('owner.laporan.*') ? 'text-teal-400 font-semibold' : 'text-slate-500' }} hover:text-teal-400 transition-colors relative">
        <i class="bi bi-shop-window text-2xl"></i>
        <span class="text-xs mt-1">Cabang</span>
        @if (isset($completedOrderNotificationCount) && $completedOrderNotificationCount > 0)
             <span class="absolute top-1 right-4 flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 animate-pulse">
                {{ $completedOrderNotificationCount }}
            </span>
        @endif
    </a>
    
    {{-- Link Data Admin --}}
    <a href="{{ route('owner.dataadmin.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('owner.dataadmin.*') ? 'text-teal-400 font-semibold' : 'text-slate-500' }} hover:text-teal-400 transition-colors">
        <i class="bi bi-person-badge-fill text-2xl"></i>
        <span class="text-xs mt-1">Admin</span>
    </a>
    
    {{-- Link Data Karyawan --}}
    <a href="{{ route('owner.datakaryawan.index') }}" class="flex flex-col items-center justify-center w-full h-full {{ request()->routeIs('owner.datakaryawan.*') ? 'text-teal-400 font-semibold' : 'text-slate-500' }} hover:text-teal-400 transition-colors relative">
        <i class="bi bi-people-fill text-2xl"></i>
        <span class="text-xs mt-1">Karyawan</span>
        @if (isset($karyawanNotificationCount) && $karyawanNotificationCount > 0)
             <span class="absolute top-1 right-4 flex items-center justify-center bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 animate-pulse">
                {{ $karyawanNotificationCount }}
            </span>
        @endif
    </a>
</nav>