@php use Illuminate\Support\Facades\Auth; @endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profil - Admin Panel</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Simple Scrollbar Styling */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="relative flex h-screen overflow-hidden bg-slate-100">
        
        <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 p-4 flex-col fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 z-30 transition-transform duration-300 ease-in-out">
            <div class="mb-8 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto mx-auto mb-2">
                <h2 class="text-2xl font-bold text-teal-400">Avachive Admin</h2>
            </div>

            <nav class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-speedometer2 text-lg"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-list-check text-lg"></i>
                    <span>Layanan</span>
                </a>
                <a href="{{ route('dataorder') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-cart-check text-lg"></i>
                    <span>Order</span>
                </a>
                <a href="{{ route('datauser') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-people text-lg"></i>
                    <span>Karyawan</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <div class="p-4 sm:p-6">
                <div class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                            <i class="bi bi-list"></i>
                        </button>
                        <h1 class="text-lg font-semibold text-slate-800">Profile Admin Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
                    </div>
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                            <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                            <i class="bi bi-person-circle text-2xl text-slate-600"></i>
                        </button>
                        <div id="user-menu" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                            <a href="{{ route('pengaturan') }}" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <i class="bi bi-person-circle"></i>
                                <span>Profile</span>
                            </a>
                            <div class="border-t border-slate-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="button" id="logout-button" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto space-y-6">
                    <section class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2"><i class="bi bi-person-circle text-blue-600"></i> Profil Anda</h3>
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&size=128&bold=true' }}" alt="Foto Profil" class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md">
                            <div class="text-center sm:text-left">
                                <strong class="text-2xl font-bold text-slate-900">{{ Auth::user()->name }}</strong>
                                <p class="text-slate-500 mt-1">Role: {{ ucfirst(Auth::user()->usertype) }}</p>
                            </div>
                        </div>
                    </section>

                    <section class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="bi bi-question-circle text-blue-600"></i> Cara Menggunakan Aplikasi</h3>
                        <ul class="list-disc list-inside space-y-2 text-slate-600 leading-relaxed">
                            <li>Gunakan halaman <strong class="font-semibold text-slate-700">Layanan</strong> untuk menambah atau mengatur jenis laundry.</li>
                            <li>Gunakan halaman <strong class="font-semibold text-slate-700">Order</strong> untuk melihat dan mengelola transaksi pelanggan.</li>
                            <li>Gunakan halaman <strong class="font-semibold text-slate-700">Karyawan</strong> untuk menambahkan atau mengedit data karyawan.</li>
                            <li>Gunakan halaman <strong class="font-semibold text-slate-700">Pengaturan</strong> ini untuk melihat profil Anda.</li>
                        </ul>
                    </section>

                    <section class="bg-white rounded-2xl shadow-lg p-6">
                         <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="bi bi-info-circle text-blue-600"></i> Tentang Aplikasi</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Aplikasi ini dibuat untuk membantu pemilik laundry dalam mengelola operasional harian secara efisien dan profesional. Dikembangkan oleh <strong class="font-semibold text-slate-700">My Team</strong> sebagai bagian dari sistem administrasi digital laundry modern.
                        </p>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Responsive Sidebar Toggle
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
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
                    event.preventDefault(); // Mencegah form submit langsung
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
        });
    </script>
</body>
</html>