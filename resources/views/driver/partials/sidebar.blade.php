{{-- ====================================================================== --}}
{{-- == 		   FILE SIDEBAR & NAVIGASI BAWAH UNTUK DRIVER 		 == --}}
{{-- ====================================================================== --}}

{{-- 
    [PENJELASAN PERUBAIKAN]
    1. Tag <aside> diberi class 'fixed', 'h-screen', dan 'z-40'.
       - 'fixed': Membuat sidebar "melayang" dan tetap di posisinya saat di-scroll.
       - 'h-screen': Memastikan tingginya selalu 100% dari tinggi layar.
       - 'z-40': Memberi z-index agar sidebar selalu tampil di atas elemen lain.
    2. Perubahan ini akan membuat layout di file dashboard.blade.php berfungsi benar.
--}}

{{-- SIDEBAR UNTUK TAMPILAN DESKTOP (VERSI FIXED) --}}
<aside id="sidebar" class="fixed left-0 top-0 z-40 hidden h-screen w-64 flex-col bg-slate-900 p-4 text-slate-300 md:flex">
    <div class="mb-8 text-center">
        <div class="flex flex-col items-center justify-center py-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mb-4 h-20 w-auto">
            <h2 class="text-2xl font-bold text-teal-400">Avachive Driver</h2>
        </div>
        <nav class="flex flex-col space-y-2">

            {{-- Link Pengiriman (Dengan Notifikasi) --}}
            <a href="/driver/dashboard"
                class="flex items-center justify-between gap-3 rounded-lg px-4 py-3 {{ request()->is('driver/dashboard*') ? 'bg-teal-500 font-semibold text-white' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="bi bi-box-seam"></i>
                    <span>Pengiriman</span>
                </div>
                @if (isset($driverNotificationCount) && $driverNotificationCount > 0)
                    <span
                        class="flex h-6 w-6 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                        {{ $driverNotificationCount }}
                    </span>
                @endif
            </a>

            {{-- Link Riwayat --}}
            <a href="/driver/riwayat"
                class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->is('driver/riwayat*') ? 'bg-teal-500 font-semibold text-white' : 'hover:bg-slate-800 hover:text-white' }} transition-colors">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>
        </nav>
    </div>
</aside>

{{-- NAVIGASI BAWAH UNTUK TAMPILAN MOBILE (KODE SUDAH BENAR) --}}
<nav
    class="fixed bottom-0 left-0 right-0 z-30 flex h-20 items-center justify-around bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] md:hidden">

    {{-- Tombol Pengiriman (Dengan Notifikasi Angka) --}}
    <a href="/driver/dashboard"
        class="flex h-full w-full flex-col items-center justify-center {{ request()->is('driver/dashboard*') ? 'font-semibold text-teal-500' : 'text-slate-500' }} transition-colors hover:text-teal-500">
        <div class="relative">
            <i class="bi bi-box-seam text-2xl"></i>
            @if (isset($driverNotificationCount) && $driverNotificationCount > 0)
                <span
                    class="absolute -right-2 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white animate-pulse">
                    {{ $driverNotificationCount }}
                </span>
            @endif
        </div>
        <span class="mt-1 text-xs">Pengiriman</span>
    </a>

    {{-- Tombol Riwayat --}}
    <a href="/driver/riwayat"
        class="flex h-full w-full flex-col items-center justify-center {{ request()->is('driver/riwayat*') ? 'font-semibold text-teal-500' : 'text-slate-500' }} transition-colors hover:text-teal-500">
        <div class="relative">
            <i class="bi bi-clock-history text-2xl"></i>
        </div>
        <span class="mt-1 text-xs">Riwayat</span>
    </a>
</nav>