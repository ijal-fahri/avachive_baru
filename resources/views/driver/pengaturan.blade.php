<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil Driver | Avachive</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Custom styles untuk Poppins font & scrollbar */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Simple Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="flex h-screen overflow-hidden bg-slate-100">

        <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 p-4 flex-col hidden md:flex">
            <div class="mb-8 text-center">
                <div class="flex flex-col items-center justify-center py-8">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-20 w-auto mb-4">
                    <h2 class="text-2xl font-bold text-teal-400">Avachive Driver</h2>
                </div>
                <nav class="flex flex-col space-y-2">
                    <a href="/driver/dashboard"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                        <i class="bi bi-box-seam"></i> Pengiriman
                    </a>
                    <a href="/driver/riwayat"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                </nav>
        </aside>

        <main class="flex-1 p-4 sm:p-6 overflow-y-auto">
            <div
                class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">⚙️</span>
                    <div>
                        <h1 class="font-semibold text-slate-800">Profil Saya</h1>
                        <p class="text-xs text-slate-500">Informasi Akun & Aplikasi</p>
                    </div>
                </div>
                <div class="relative">
                    <button id="profileDropdownBtn"
                        class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 hover:ring-2 hover:ring-blue-400 transition-all">
                        <i class="bi bi-person-fill text-xl"></i>
                    </button>
                    <div id="profileDropdownMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl z-20 border border-slate-200">
                        <div class="p-2">
                            <a href="/driver/pengaturan"
                                class="block w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat
                                Profile</a>
                            <button id="logoutBtn"
                                class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800 mb-4">
                    <i class="bi bi-person-circle text-teal-500"></i>
                    Profil Driver
                </h3>
                <div class="flex flex-col items-center text-center md:flex-row md:text-left gap-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff&size=128&bold=true"
                        alt="Foto Profil" class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md">
                    <div class="profile-info">
                        <h4 class="text-2xl font-bold text-slate-900">{{ Auth::user()->name }}</h4>
                        <p class="text-slate-500 mt-1">Role: {{ Auth::user()->usertype }}</p>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800 mb-4">
                    <i class="bi bi-info-circle text-teal-500"></i>
                    Tentang Aplikasi
                </h3>
                <div id="infoApp" class="pl-5 border-l-4 border-teal-400 text-slate-600 text-sm leading-relaxed">
                    Avachive adalah aplikasi pengelolaan dan pengantaran laundry yang membantu driver mengelola tugas
                    harian secara efisien. Dengan antarmuka yang sederhana dan informatif, aplikasi ini mempermudah
                    proses pelacakan barang dan pengiriman ke pelanggan.
                </div>
            </section>

            <section class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800 mb-4">
                    <i class="bi bi-question-circle text-teal-500"></i>
                    Cara Menggunakan Aplikasi
                </h3>
                <div id="caraPakai" class="pl-5 border-l-4 border-teal-400 text-slate-600 text-sm leading-relaxed">
                    <ol class="list-decimal list-inside space-y-2">
                        <li>Masuk ke halaman <b class="font-semibold text-slate-700">Pengiriman</b> untuk melihat daftar
                            barang yang harus diantar.</li>
                        <li>Klik tombol <b class="font-semibold text-slate-700">Detail</b> untuk melihat informasi
                            lengkap pelanggan.</li>
                        <li>Setelah barang dikirim, klik tombol <b class="font-semibold text-slate-700">Selesai</b>
                            untuk memindahkannya ke Riwayat.</li>
                        <li>Masuk ke halaman <b class="font-semibold text-slate-700">Riwayat</b> untuk melihat barang
                            yang sudah dikirim.</li>
                        <li>Gunakan menu <b class="font-semibold text-slate-700">Pengaturan</b> untuk melihat profil dan
                            panduan ini.</li>
                    </ol>
                </div>
            </section>

            <footer class="text-center py-6 text-sm text-slate-500">
                © 2025 Avachive Driver. All rights reserved.
            </footer>
        </main>

        <nav
            class="md:hidden fixed bottom-0 left-0 right-0 bg-slate-900 text-slate-300 p-2 flex justify-around shadow-lg">
            <a href="/driver/dashboard"
                class="flex flex-col items-center justify-center hover:text-white p-2 rounded-lg w-full">
                <i class="bi bi-box-seam text-xl"></i><span class="text-xs">Pengiriman</span>
            </a>
            <a href="/driver/riwayat"
                class="flex flex-col items-center justify-center hover:text-white p-2 rounded-lg w-full">
                <i class="bi bi-clock-history text-xl"></i><span class="text-xs">Riwayat</span>
            </a>
        </nav>

    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // ==========================================================
        // JAVASCRIPT LOGIC
        // ==========================================================

        const el = sel => document.querySelector(sel);

        // ====== PROFILE DROPDOWN & LOGOUT LOGIC ======
        const profileDropdownBtn = el('#profileDropdownBtn');
        const profileDropdownMenu = el('#profileDropdownMenu');
        const logoutBtn = el('#logoutBtn');

        if (profileDropdownBtn) {
            profileDropdownBtn.addEventListener('click', () => {
                profileDropdownMenu.classList.toggle('hidden');
            });

            window.addEventListener('click', (e) => {
                if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                    profileDropdownMenu.classList.add('hidden');
                }
            });

            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                profileDropdownMenu.classList.add('hidden');
                Swal.fire({
                    title: 'Anda yakin ingin keluar?',
                    text: "Anda akan dikembalikan ke halaman login.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // INI BAGIAN PENTING: Mengirimkan form logout yang tersembunyi
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        }
    </script>

</body>

</html>
