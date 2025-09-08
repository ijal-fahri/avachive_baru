<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil | Avachive</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
      body { font-family: 'Poppins', sans-serif; }
      .sidebar-mobile-open { transform: translateX(0) !important; }
      .modal-content { transition: all 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-slate-100">

    <div class="flex h-screen overflow-hidden">
        
        <aside id="sidebar" class="bg-slate-900 text-slate-300 w-64 min-h-screen p-4 fixed transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 flex flex-col">
            <div>
                <div class="flex flex-col items-center text-center mb-10">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Avachive" class="w-16 h-auto mb-2">
                    <div class="text-2xl font-bold text-teal-400">Avachive Owner</div>
                </div>
                
                <nav class="space-y-3">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-grid-1x2-fill mr-4 text-lg"></i><span class="font-medium">Dashboard</span></a>
                    <a href="{{ route('owner.manage') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-receipt-cutoff mr-4 text-lg"></i><span class="font-medium">Manajemen Order</span></a>
                    <a href="{{ route('owner.dataadmin.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-person-badge-fill mr-4 text-lg"></i><span class="font-medium">Data Admin</span></a>
                    <a href="{{ route('owner.datakaryawan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-people-fill mr-4 text-lg"></i><span class="font-medium">Data Karyawan</span></a>
                    <a href="{{ route('owner.laporan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-graph-up-arrow mr-4 text-lg"></i><span class="font-medium">Laporan</span></a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            <header class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
                <div class="flex items-center gap-4">
                    <button id="menu-btn" class="text-slate-800 text-2xl md:hidden"><i class="bi bi-list"></i></button>
                    <h1 class="text-xl font-semibold text-slate-800">Profil Saya</h1>
                </div>
                <div class="relative">
                    <button id="profileDropdownBtn" class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</button>
                    <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-10 border">
                        <div class="p-2">
                            <a href="{{ route('owner.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat Profile</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf </form>
                            <button id="logoutBtn" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                        </div>
                    </div>
                </div>
            </header>
            
            <main class="px-6 pb-6 mt-8">
                 @if (session('success'))
                    <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg max-w-4xl mx-auto" role="alert"><p>{{ session('success') }}</p></div>
                @endif

                <div class="max-w-4xl mx-auto space-y-6">
                    <section class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800 mb-4"><i class="bi bi-person-circle text-teal-500"></i>Profil Owner</h3>
                        <div class="flex flex-col items-center text-center md:flex-row md:text-left gap-6">
                            <img src="https://placehold.co/150x150/2dd4bf/1f2937?text={{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="Foto Profil" class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md">
                            <div class="profile-info">
                                <h4 class="text-2xl font-bold text-slate-900">{{ Auth::user()->name }}</h4>
                                <p class="text-slate-500 mt-1 capitalize">Role : {{ Auth::user()->usertype }}</p>
                                <div class="flex items-center gap-3 mt-4 flex-wrap">
                                    <button id="openPasswordModalBtn" class="bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors duration-200 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                        <i class="bi bi-key-fill mr-2"></i>Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800 mb-4">
                            <i class="bi bi-info-circle text-teal-500"></i>
                            Tentang Aplikasi
                        </h3>
                        <div id="infoApp" class="pl-5 border-l-4 border-teal-400 text-slate-600 text-sm leading-relaxed">
                            Avachive adalah sistem manajemen modern yang dirancang untuk membantu Anda mengelola operasional bisnis laundry dengan lebih efisien, dari pemantauan order hingga laporan penjualan.
                        </div>
                    </section>

                    <section class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800 mb-4">
                            <i class="bi bi-question-circle text-teal-500"></i>
                            Cara Menggunakan Aplikasi
                        </h3>
                        <div id="caraPakai" class="pl-5 border-l-4 border-teal-400 text-slate-600 text-sm leading-relaxed">
                            <ol class="list-decimal list-inside space-y-2">
                                <li>Gunakan menu <b class="font-semibold text-slate-700">Dashboard</b> untuk melihat ringkasan bisnis secara cepat.</li>
                                <li>Masuk ke <b class="font-semibold text-slate-700">Manajemen Order</b> untuk menambah, mengedit, dan melihat status semua pesanan.</li>
                                <li>Kelola data admin dan karyawan di halaman <b class="font-semibold text-slate-700">Data Admin</b> & <b class="font-semibold text-slate-700">Data Karyawan</b>.</li>
                                <li>Analisis performa bisnis Anda melalui menu <b class="font-semibold text-slate-700">Laporan</b>.</li>
                            </ol>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden"></div>

    {{-- MODAL UBAH PASSWORD --}}
    <div id="passwordModal" class="fixed inset-0 bg-black bg-opacity-60 z-50 flex justify-center items-center p-4 hidden">
        <div id="passwordModalContent" class="modal-content bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative transform scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-200">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800"><i class="bi bi-key-fill text-teal-500"></i>Ubah Password</h3>
                <button id="closePasswordModalBtn" class="text-slate-400 hover:text-slate-800 text-3xl leading-none">&times;</button>
            </div>
            <form id="changePasswordForm" action="{{ route('owner.profile.updatePassword') }}" method="POST" class="space-y-4 pt-2">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" class="block w-full px-3 py-2 border border-slate-300 rounded-md" required>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-3 py-2 border border-slate-300 rounded-md" required>
                </div>
                <div class="flex justify-end pt-4">
                    <button type="button" id="cancelPasswordChangeBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2 px-6 rounded-lg mr-3">Batal</button>
                    <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Element Constants ---
        const passwordModal = document.getElementById('passwordModal');
        const passwordModalContent = document.getElementById('passwordModalContent');
        const openPasswordModalBtn = document.getElementById('openPasswordModalBtn');
        const closePasswordModalBtn = document.getElementById('closePasswordModalBtn');
        const cancelPasswordChangeBtn = document.getElementById('cancelPasswordChangeBtn');
        
        // --- Utility Functions ---
        const openModal = (modal, content) => {
            modal.classList.remove('hidden');
            setTimeout(() => content.classList.remove('scale-95', 'opacity-0'), 10);
        };

        const closeModal = (modal, content) => {
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        };

        // --- Change Password Modal Logic ---
        openPasswordModalBtn.addEventListener('click', () => openModal(passwordModal, passwordModalContent));
        closePasswordModalBtn.addEventListener('click', () => closeModal(passwordModal, passwordModalContent));
        cancelPasswordChangeBtn.addEventListener('click', () => closeModal(passwordModal, passwordModalContent));
        passwordModal.addEventListener('click', (e) => { 
            if (e.target === passwordModal) closeModal(passwordModal, passwordModalContent); 
        });
        
        // --- SweetAlert for Validation Errors ---
        @if($errors->any() && session('error_modal') === 'password')
            let errorMessages = `<ul class="mt-2 list-disc list-inside text-sm text-left">`;
            @foreach ($errors->all() as $error)
                errorMessages += `<li>{{ $error }}</li>`;
            @endforeach
            errorMessages += `</ul>`;

            Swal.fire({
                icon: 'error',
                title: 'Gagal Memperbarui Password',
                html: errorMessages,
                confirmButtonColor: '#38b2ac'
            });
            openModal(passwordModal, passwordModalContent); // Buka kembali modalnya
        @endif

        // --- UI Scripts ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuBtn = document.getElementById('menu-btn');
        const toggleSidebar = () => {
            sidebar.classList.toggle('sidebar-mobile-open');
            overlay.classList.toggle('hidden');
        };
        menuBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');
        profileDropdownBtn.addEventListener('click', () => profileDropdownMenu.classList.toggle('hidden'));
        window.addEventListener('click', (e) => {
            if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                profileDropdownMenu.classList.add('hidden');
            }
        });
        
        document.getElementById('logoutBtn').addEventListener('click', () => {
             Swal.fire({
                title: 'Konfirmasi Logout', text: "Anda yakin ingin keluar?", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Logout!'
            }).then((result) => { if (result.isConfirmed) document.getElementById('logout-form').submit(); });
        });
        
        const successAlert = document.getElementById('success-alert');
        if(successAlert) setTimeout(() => { successAlert.style.display = 'none'; }, 5000);
    });
    </script>
</body>
</html>

