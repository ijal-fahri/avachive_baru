<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/0948e65078.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 30;
        }
        
        /* Sidebar mobile */
        .sidebar-mobile {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .sidebar-mobile.open {
            transform: translateX(0);
        }
        
        /* Animasi untuk submenu */
        .submenu-enter {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
        }
        
        .submenu-enter-active {
            max-height: 200px;
            opacity: 1;
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }
        
        .submenu-exit {
            max-height: 200px;
            opacity: 1;
        }
        
        .submenu-exit-active {
            max-height: 0;
            opacity: 0;
            transition: max-height 0.3s ease, opacity 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Container -->
    <header class="flex">
        <!-- Overlay untuk mobile -->
        <div id="sidebarOverlay" class="sidebar-overlay lg:hidden"></div>
        
        <!-- Sidebar Desktop (hanya muncul saat layar besar) -->
        <nav class="hidden lg:flex flex-col w-64 h-screen bg-[#1e272e] shadow-2xl fixed top-0 left-0 z-20">
            <!-- Logo Section -->
            <div class="flex flex-col items-center justify-center py-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto mb-4">
                <h2 class="text-2xl font-bold text-[#00cec9]">Avachive Kasir</h2>
            </div>

            <ul class="mt-6 space-y-1 px-4">
                <li>
                    <a href="../kasir/dashboard" class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/dashboard*') ? 'bg-[#00cec9] text-white' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="../kasir/pelanggan" class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/pelanggan*') ? 'bg-[#00cec9] text-white' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="../kasir/buat_order" class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/buat_order*') ? 'bg-[#00cec9] text-white' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Buat Order
                    </a>
                </li>
                <li>
                    <!-- Data Order with submenu -->
                    <div x-data="{ open: {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'true' : 'false' }} }" class="relative">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'bg-[#00cec9] text-white' : '' }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Data Order
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'transform rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        
                        <!-- Submenu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" 
                            x-transition:enter-start="opacity-0 scale-95" 
                            x-transition:enter-end="opacity-100 scale-100" 
                            x-transition:leave="transition ease-in duration-75" 
                            x-transition:leave-start="opacity-100 scale-100" 
                            x-transition:leave-end="opacity-0 scale-95"
                            class="ml-8 mt-1 space-y-1">
                            <a href="../kasir/data_order" class="flex items-center px-4 py-2 text-sm text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/data_order*') ? 'bg-[#00cec9] text-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                List Order
                            </a>
                            <a href="../kasir/riwayat_order" class="flex items-center px-4 py-2 text-sm text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/riwayat_order*') ? 'bg-[#00cec9] text-white' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Riwayat Order
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
            
            <!-- Footer sidebar -->
        </nav>

        <!-- Sidebar Mobile (muncul saat layar kecil) -->
        <nav id="sidebarMobile" class="sidebar-mobile lg:hidden flex flex-col w-64 h-screen bg-[#1e272e] shadow-2xl fixed top-0 left-0 z-40">
            <!-- Header Mobile Sidebar -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto mr-3">
                    <h2 class="text-xl font-bold text-[#00cec9]">Kasir</h2>
                </div>
                <button id="closeSidebar" class="p-2 text-[#dcdde1] hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Items -->
            <ul class="mt-4 space-y-1 px-4 overflow-y-auto flex-grow">
                <li>
                    <a href="../kasir/dashboard" class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/dashboard*') ? 'bg-[#00cec9] text-white' : '' }}" onclick="closeMobileSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="../kasir/pelanggan" class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/pelanggan*') ? 'bg-[#00cec9] text-white' : '' }}" onclick="closeMobileSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="../kasir/buat_order" class="flex items-center px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/buat_order*') ? 'bg-[#00cec9] text-white' : '' }}" onclick="closeMobileSidebar()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Buat Order
                    </a>
                </li>
                <li>
                    <!-- Data Order with submenu -->
                    <div x-data="{ open: {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'true' : 'false' }} }" class="relative">
                        <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-3 text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/data_order*') || request()->is('kasir/riwayat_order*') ? 'bg-[#00cec9] text-white' : '' }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Data Order
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'transform rotate-90': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                        
                        <!-- Submenu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" 
                            x-transition:enter-start="opacity-0 scale-95" 
                            x-transition:enter-end="opacity-100 scale-100" 
                            x-transition:leave="transition ease-in duration-75" 
                            x-transition:leave-start="opacity-100 scale-100" 
                            x-transition:leave-end="opacity-0 scale-95"
                            class="ml-8 mt-1 space-y-1">
                            <a href="../kasir/data_order" class="flex items-center px-4 py-2 text-sm text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/data_order*') ? 'bg-[#00cec9] text-white' : '' }}" onclick="closeMobileSidebar()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                List Order
                            </a>
                            <a href="../kasir/riwayat_order" class="flex items-center px-4 py-2 text-sm text-[#dcdde1] hover:bg-[#00cec9] hover:text-white rounded-lg transition-all duration-200 group {{ request()->is('kasir/riwayat_order*') ? 'bg-[#00cec9] text-white' : '' }}" onclick="closeMobileSidebar()">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                                Riwayat Order
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Header Navbar for Mobile -->
        <div class="w-full lg:ml-64">
    <div class="bg-white fixed top-0 left-0 w-full flex items-center justify-between px-6 py-3 lg:hidden z-30 shadow-md rounded-b-xl"
         style="max-width: 95vw; margin: 0 auto; left: 0; right: 0;">
        <!-- Hamburger -->
        <button id="hamburger" type="button" class="p-2 rounded-lg hover:bg-gray-100 transition-colors flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Title -->
        <div class="font-bold text-blue-800 text-lg mx-auto text-center">Kasir</div>

        <!-- Profile Dropdown Mobile -->
        <div class="relative">
            <button id="userMenuBtnMobile" class="flex items-center gap-2 p-2 rounded-full hover:bg-gray-100">
                <i class="bi bi-person-circle text-2xl text-gray-700"></i>
            </button>
            <div id="userMenuMobile" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg py-1 z-50">
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
    </div>
</div>
    </header>

    <script>
    // Toggle profile dropdown (Mobile)
    const userMenuBtnMobile = document.getElementById('userMenuBtnMobile');
    const userMenuMobile = document.getElementById('userMenuMobile');

    userMenuBtnMobile.addEventListener('click', () => {
        userMenuMobile.classList.toggle('hidden');
    });

    // Tutup dropdown kalau klik di luar
    window.addEventListener('click', function(e) {
        if (!userMenuBtnMobile.contains(e.target) && !userMenuMobile.contains(e.target)) {
            userMenuMobile.classList.add('hidden');
        }
        if (!userMenuBtnDesktop.contains(e.target) && !userMenuDesktop.contains(e.target)) {
            userMenuDesktop.classList.add('hidden');
        }
    });

        // Fungsi untuk membuka sidebar mobile
        function openMobileSidebar() {
            document.getElementById('sidebarMobile').classList.add('open');
            document.getElementById('sidebarOverlay').style.display = 'block';
            document.body.style.overflow = 'hidden'; // Mencegah scroll pada body
        }

        // Fungsi untuk menutup sidebar mobile
        function closeMobileSidebar() {
            document.getElementById('sidebarMobile').classList.remove('open');
            document.getElementById('sidebarOverlay').style.display = 'none';
            document.body.style.overflow = 'auto'; // Mengembalikan scroll pada body
        }

        // Event listener untuk tombol hamburger
        document.getElementById('hamburger').addEventListener('click', openMobileSidebar);
        
        // Event listener untuk tombol close sidebar
        document.getElementById('closeSidebar').addEventListener('click', closeMobileSidebar);
        
        // Event listener untuk overlay (menutup sidebar saat klik di luar)
        document.getElementById('sidebarOverlay').addEventListener('click', closeMobileSidebar);

        // Menutup sidebar saat resize window ke ukuran desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileSidebar();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert untuk hapus pelanggan
    document.querySelectorAll('.delete-pelanggan-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
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
        });
    });
});
    </script>
</body>
</html>