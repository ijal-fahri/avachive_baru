<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100">

    <aside class="hidden lg:flex flex-col w-64 h-screen bg-[#1e272e] shadow-2xl fixed top-0 left-0 z-50">
        <div class="flex flex-col items-center justify-center py-8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto mb-4">
            <h2 class="text-2xl font-bold text-teal-400">Avachive Kasir</h2>
        </div>

        <nav class="mt-6 space-y-1 px-4">
            <ul>
                <li>
                    <a href="../kasir/dashboard"
                        class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-teal-400 hover:text-slate-900 rounded-lg transition-all duration-200 group {{ request()->is('kasir/dashboard*') ? 'bg-teal-400 text-slate-900' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="../kasir/pelanggan"
                        class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-teal-400 hover:text-slate-900 rounded-lg transition-all duration-200 group {{ request()->is('kasir/pelanggan*') ? 'bg-teal-400 text-slate-900' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="../kasir/buat_order"
                        class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-teal-400 hover:text-slate-900 rounded-lg transition-all duration-200 group {{ request()->is('kasir/buat_order*') ? 'bg-teal-400 text-slate-900' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Buat Order
                    </a>
                </li>
                <li>
                    <div x-data="{ open: {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'true' : 'false' }} }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center justify-between w-full px-4 py-3 text-[#dcdde1] hover:bg-teal-400 hover:text-slate-900 rounded-lg transition-all duration-200 group {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'bg-teal-400 text-slate-900' : '' }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Data Order
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                :class="{ 'transform rotate-90': open }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <div x-show="open" x-transition class="ml-8 mt-1 space-y-1">
                            <a href="../kasir/data_order"
                                class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-teal-400 hover:text-slate-900 rounded-lg transition-all duration-200 group {{ request()->is('kasir/data_order*') ? 'bg-teal-400 text-slate-900' : '' }}">
                                List Order
                            </a>
                            <a href="../kasir/riwayat_order"
                                class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-teal-400 hover:text-slate-900 rounded-lg transition-all duration-200 group {{ request()->is('kasir/riwayat_order*') ? 'bg-teal-400 text-slate-900' : '' }}">
                                Riwayat Order
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </aside>

    <header
        class="bg-white fixed top-0 left-0 right-0 flex items-center justify-between px-4 py-3 lg:hidden z-40 shadow-md">
        <div class="w-10"></div>

        <div class="font-bold text-blue-800 text-lg">Kasir</div>

        <div class="relative">
            <button id="userMenuBtnMobile"
                class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-gray-100">
                @php
                    $profilePhoto = Auth::user()->profile_photo
                        ? asset('storage/' . Auth::user()->profile_photo)
                        : 'https://ui-avatars.com/api/?name=' .
                            urlencode(Auth::user()->name) .
                            '&background=3b82f6&color=fff&size=64&bold=true';
                @endphp
                <img src="{{ $profilePhoto }}" alt="Foto Profil"
                    class="w-10 h-10 rounded-full object-cover border-2 border-blue-400 shadow">
            </button>
            <div id="userMenuMobile"
                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50 border">
                <a href="pengaturan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white shadow-[0_-2px_5px_rgba(0,0,0,0.1)] z-40">
        <div class="flex justify-around max-w-screen-sm mx-auto">
            <a href="../kasir/dashboard"
                class="flex flex-col items-center justify-center p-3 w-full transition-colors duration-200 {{ request()->is('kasir/dashboard*') ? 'text-[#00cec9]' : 'text-gray-500 hover:text-[#00cec9]' }}">
                <i class="bi bi-house-door-fill text-xl"></i>
                <span class="text-xs font-medium mt-1">Dashboard</span>
            </a>

            <a href="../kasir/pelanggan"
                class="flex flex-col items-center justify-center p-3 w-full transition-colors duration-200 {{ request()->is('kasir/pelanggan*') ? 'text-[#00cec9]' : 'text-gray-500 hover:text-[#00cec9]' }}">
                <i class="bi bi-people-fill text-xl"></i>
                <span class="text-xs font-medium mt-1">Pelanggan</span>
            </a>

            <a href="../kasir/buat_order"
                class="flex flex-col items-center justify-center p-3 w-full transition-colors duration-200 {{ request()->is('kasir/buat_order*') ? 'text-[#00cec9]' : 'text-gray-500 hover:text-[#00cec9]' }}">
                <i class="bi bi-plus-square-fill text-xl"></i>
                <span class="text-xs font-medium mt-1">Buat Order</span>
            </a>

            <div x-data="{ open: false }" class="w-full h-full relative flex justify-center">
                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    class="absolute bottom-full mb-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50"
                    style="display: none;">

                    <a href="../kasir/data_order"
                        class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->is('kasir/data_order*') ? 'font-bold text-[#00cec9]' : '' }}">
                        List Order
                    </a>
                    <a href="../kasir/riwayat_order"
                        class="flex items-center w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->is('kasir/riwayat_order*') ? 'font-bold text-[#00cec9]' : '' }}">
                        Riwayat Order
                    </a>
                </div>

                <button type="button" @click="open = !open"
                    class="flex flex-col items-center justify-center p-3 w-full transition-colors duration-200 {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'text-[#00cec9]' : 'text-gray-500 hover:text-[#00cec9]' }}">
                    <i class="bi bi-file-earmark-text-fill text-xl"></i>
                    <span class="text-xs font-medium mt-1">Data Order</span>
                </button>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle profile dropdown (Mobile)
            const userMenuBtnMobile = document.getElementById('userMenuBtnMobile');
            const userMenuMobile = document.getElementById('userMenuMobile');

            if (userMenuBtnMobile) {
                userMenuBtnMobile.addEventListener('click', (event) => {
                    event.stopPropagation(); // Mencegah event dari menyebar
                    userMenuMobile.classList.toggle('hidden');
                });
            }

            // Tutup dropdown kalau klik di luar
            window.addEventListener('click', function(e) {
                if (userMenuMobile && !userMenuMobile.classList.contains('hidden')) {
                    if (!userMenuBtnMobile.contains(e.target) && !userMenuMobile.contains(e.target)) {
                        userMenuMobile.classList.add('hidden');
                    }
                }
            });

            // SweetAlert untuk hapus pelanggan (tidak berubah)
            document.querySelectorAll('.delete-pelanggan-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Pastikan Swal sudah di-load jika menggunakan CDN
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Yakin ingin menghapus?',
                            text: 'Data pelanggan yang dihapus tidak dapat dikembalikan!',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    } else {
                        // Fallback jika Swal tidak ada
                        if (confirm('Yakin ingin menghapus data ini?')) {
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
