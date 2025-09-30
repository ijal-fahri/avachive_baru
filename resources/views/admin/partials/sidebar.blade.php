{{-- ====================================================================== --}}
{{-- ==       FILE INI ADALAH PARTIALS UNTUK SIDEBAR & NAVIGASI ADMIN     == --}}
{{-- ====================================================================== --}}

{{-- SIDEBAR UNTUK TAMPILAN DESKTOP --}}
<aside id="sidebar" class="fixed inset-y-0 left-0 z-30 hidden w-64 flex-col bg-slate-900 p-4 text-slate-300 transition-transform duration-300 ease-in-out md:flex">
    <div class="mb-8 text-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto mb-2 h-16 w-auto">
        <h2 class="text-2xl font-bold text-teal-400">Avachive Admin</h2>
    </div>
    <nav class="flex flex-col space-y-2">
        {{-- Link Dashboard dengan Notifikasi --}}
        <a href="{{ route('dashboard') }}" class="flex items-center justify-between gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-teal-500 font-semibold text-white' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <div class="flex items-center gap-3">
                <i class="bi bi-speedometer2 text-lg"></i>
                <span>Dashboard</span>
            </div>
            @if (isset($dashboardNotificationCount) && $dashboardNotificationCount > 0)
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                    {{ $dashboardNotificationCount }}
                </span>
            @endif
        </a>

        <a href="{{ route('produk.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('produk.index') ? 'bg-teal-500 font-semibold text-white' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <i class="bi bi-list-check text-lg"></i><span>Data Layanan</span>
        </a>
        
        <a href="{{ route('datauser') }}" class="flex items-center justify-between gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('datauser') ? 'bg-teal-500 font-semibold text-white' : 'hover:bg-slate-800 hover:text-white' }} transition-colors" aria-current="page">
            <div class="flex items-center gap-3">
                <i class="bi bi-people text-lg"></i>
                <span>Data Karyawan</span>
            </div>
            @if (isset($karyawanNotificationCount) && $karyawanNotificationCount > 0)
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                    {{ $karyawanNotificationCount }}
                </span>
            @endif
        </a>

        {{-- [PERBAIKAN] Notifikasi untuk Laporan ditambahkan di sini --}}
        <a href="{{ route('dataorder') }}" class="flex items-center justify-between gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('dataorder') ? 'bg-teal-500 font-semibold text-white' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
            <div class="flex items-center gap-3">
                <i class="bi bi-printer text-lg"></i><span>Laporan</span>
            </div>
             @if (isset($activeOrderNotificationCount) && $activeOrderNotificationCount > 0)
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                    {{ $activeOrderNotificationCount }}
                </span>
            @endif
        </a>
    </nav>
</aside>

{{-- NAVIGASI BAWAH UNTUK TAMPILAN MOBILE --}}
<nav class="fixed bottom-0 left-0 right-0 z-30 flex h-20 items-center justify-around bg-white px-2 shadow-[0_-2px_10px_rgba(0,0,0,0.1)] md:hidden">
    <a href="{{ route('dashboard') }}" class="relative flex flex-col items-center gap-1 {{ request()->routeIs('dashboard') ? 'font-semibold text-teal-500' : 'text-slate-500' }} transition-colors hover:text-teal-500">
        <i class="bi bi-speedometer2 text-2xl"></i>
        <span class="text-xs">Dashboard</span>
        @if (isset($dashboardNotificationCount) && $dashboardNotificationCount > 0)
            <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                {{ $dashboardNotificationCount }}
            </span>
        @endif
    </a>
    <a href="{{ route('produk.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('produk.index') ? 'font-semibold text-teal-500' : 'text-slate-500' }} transition-colors hover:text-teal-500">
        <i class="bi bi-list-check text-2xl"></i>
        <span class="text-xs">Layanan</span>
    </a>
    <a href="{{ route('datauser') }}" class="relative flex flex-col items-center gap-1 {{ request()->routeIs('datauser') ? 'font-semibold text-teal-500' : 'text-slate-500' }} transition-colors hover:text-teal-500">
        <i class="bi bi-people text-2xl"></i>
        <span class="text-xs">Karyawan</span>
        @if (isset($karyawanNotificationCount) && $karyawanNotificationCount > 0)
            <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                {{ $karyawanNotificationCount }}
            </span>
        @endif
    </a>
    {{-- [PERBAIKAN] Notifikasi untuk Laporan ditambahkan di sini --}}
    <a href="{{ route('dataorder') }}" class="relative flex flex-col items-center gap-1 {{ request()->routeIs('dataorder') ? 'font-semibold text-teal-500' : 'text-slate-500' }} transition-colors hover:text-teal-500">
        <i class="bi bi-printer text-2xl"></i>
        <span class="text-xs">Laporan</span>
         @if (isset($activeOrderNotificationCount) && $activeOrderNotificationCount > 0)
            <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                {{ $activeOrderNotificationCount }}
            </span>
        @endif
    </a>
</nav>
    