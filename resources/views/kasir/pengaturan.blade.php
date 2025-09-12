<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Pengaturan</title>
    <script src="https://kit.fontawesome.com/0948e65078.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <style>
        .setting-card {
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .setting-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left-color: #3b82f6;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        /* Modal styles */
        .modal-overlay {
            transition: opacity 0.3s ease;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Fix untuk header dan sidebar */
        #sidebar {
            z-index: 40;
            transition: transform 0.3s ease;
        }

        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            position: relative;
            z-index: 10;
        }

        @media (min-width: 768px) {
            .main-content {
                margin-left: 16rem;
                /* Sesuaikan dengan lebar sidebar */
            }
        }

        .header-fixed {
            position: sticky;
            top: 0.75rem;
            /* Memberikan sedikit jarak dari atas */
            z-index: 30;
            margin: 0 0.75rem;
            width: auto;
        }

        #overlay {
            z-index: 35;
            /* Di antara sidebar dan header */
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar Start -->
    @include('components.sidebar_kasir')
    <!-- Sidebar End -->

    <!-- Main Content Start -->
    <div class="main-content">
        <div class="p-4 sm:p-6">
            <!-- Header - Diperbaiki -->
            <div
                class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
                <div class="flex items-center gap-4">
                    <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-slate-800">Profile Kasir Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
                </div>
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                        <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                        <i class="bi bi-person-circle text-2xl text-slate-600"></i>
                    </button>
                    <div id="user-menu"
                        class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                        <a href="pengaturan"
                            class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                            <i class="bi bi-person-circle"></i>
                            <span>Profile</span>
                        </a>
                        <div class="border-t border-slate-200 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" id="logout-button"
                                class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Header -->

            <div class="pt-20 lg:pt-6 max-w-4xl mx-auto space-y-8 mt-4">
                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2"><i
                            class="bi bi-person-circle text-blue-600"></i> Profil Anda</h3>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&size=128&bold=true' }}"
                            alt="Foto Profil" class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md">
                        <div class="text-center sm:text-left">
                            <strong class="text-2xl font-bold text-slate-900">{{ Auth::user()->name }}</strong>
                            <p class="text-slate-500 mt-1">Role: {{ ucfirst(Auth::user()->usertype) }}</p>
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2"><i
                            class="bi bi-question-circle text-blue-600"></i> Cara Menggunakan Aplikasi</h3>
                    <ul class="list-disc list-inside space-y-2 text-slate-600 leading-relaxed">
                        <li>Gunakan halaman <strong class="font-semibold text-slate-700">Dashboard</strong> untuk
                            melihat data data pesanan laundry yang sudah dibuat.</li>
                        <li>Gunakan halaman <strong class="font-semibold text-slate-700">Pelanggan</strong> untuk
                            melihat dan mengelola data pelanggan.</li>
                        <li>Gunakan halaman <strong class="font-semibold text-slate-700">Buat Order</strong> untuk
                            menambahkan pesanan laundry.</li>
                        <li>Gunakan halaman <strong class="font-semibold text-slate-700">Data Order</strong> untuk
                            melihat dan mengelola semua transaksi yang sudah dibuat.</li>
                    </ul>

                </section>

                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2"><i
                            class="bi bi-info-circle text-blue-600"></i> Tentang Aplikasi</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Aplikasi ini dibuat untuk membantu pemilik laundry dalam mengelola operasional harian secara
                        efisien dan profesional. Dikembangkan oleh <strong class="font-semibold text-slate-700">My
                            Team</strong> sebagai bagian dari sistem administrasi digital laundry modern.
                    </p>
                </section>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Responsive Sidebar Toggle
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const mainContent = document.querySelector('.main-content');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');

                // Pada tampilan mobile, geser konten utama saat sidebar terbuka
                if (window.innerWidth < 768) {
                    if (sidebar.classList.contains('-translate-x-full')) {
                        mainContent.style.marginLeft = '0';
                    } else {
                        mainContent.style.marginLeft = '16rem';
                    }
                }
            }

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', toggleSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', toggleSidebar);
            }

            // User Dropdown Logic
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const logoutButton = document.getElementById('logout-button');

            if (userMenuButton) {
                userMenuButton.addEventListener('click', () => {
                    userMenu.classList.toggle('hidden');
                });

                // Close dropdown if clicked outside
                window.addEventListener('click', function(e) {
                    if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }

            // Logout Confirmation
            if (logoutButton) {
                logoutButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Anda yakin ingin logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Logout!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutButton.closest('form').submit();
                        }
                    });
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    // Pada desktop, pastikan sidebar terbuka dan konten utama memiliki margin
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.add('hidden');
                    mainContent.style.marginLeft = '16rem';
                } else {
                    // Pada mobile, pastikan sidebar tertutup dan konten utama tidak memiliki margin
                    sidebar.classList.add('-translate-x-full');
                    mainContent.style.marginLeft = '0';
                }
            });
        });
    </script>
</body>

</html>