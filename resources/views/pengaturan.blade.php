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
        .modal-content { transition: all 0.3s ease-in-out; }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="flex h-screen bg-slate-100">
        
        <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 p-4 flex-col fixed inset-y-0 left-0 z-30 transition-transform duration-300 ease-in-out hidden md:flex">
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
                    <span>Data Layanan</span>
                </a>
                <a href="{{ route('datauser') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-people text-lg"></i>
                    <span>Data Karyawan</span>
                </a>
                <a href="{{ route('dataorder') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-printer text-lg"></i>
                    <span>Laporan</span>
                </a>
            </nav>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto">
                <div class="p-4 sm:p-6 pb-28 md:pb-6">
                    <div class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h1 class="text-base sm:text-lg font-semibold text-slate-800">Profile Admin Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
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
                                    <button id="openProfileModalBtn" class="mt-4 bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors duration-200 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                        <i class="bi bi-pencil-square mr-2"></i>Edit Profil
                                    </button>
                                </div>
                            </div>
                        </section>

                        <section class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2"><i class="bi bi-question-circle text-blue-600"></i> Cara Menggunakan Aplikasi</h3>
                            <ul class="list-disc list-inside space-y-2 text-slate-600 leading-relaxed">
                                <li>Gunakan halaman <strong class="font-semibold text-slate-700">Data Layanan</strong> untuk menambah atau mengatur jenis laundry.</li>
                                <li>Gunakan halaman <strong class="font-semibold text-slate-700">Data Karyawan</strong> untuk menambahkan atau mengedit data karyawan.</li>
                                <li>Gunakan halaman <strong class="font-semibold text-slate-700">Laporan</strong> untuk melihat ringkasan pemasukan.</li>
                                <li>Gunakan <strong class="font-semibold text-slate-700">menu Profile</strong> di pojok kanan atas untuk kembali ke halaman ini.</li>
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
    </div>
    
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] z-30 flex justify-around items-center px-2">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-speedometer2 text-2xl"></i>
            <span class="text-xs">Dashboard</span>
        </a>
        <a href="{{ route('produk.index') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-list-check text-2xl"></i>
            <span class="text-xs">Layanan</span>
        </a>
        <a href="{{ route('datauser') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-people text-2xl"></i>
            <span class="text-xs">Karyawan</span>
        </a>
        <a href="{{ route('dataorder') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-printer text-2xl"></i>
            <span class="text-xs">Laporan</span>
        </a>
    </nav>

    {{-- MODAL EDIT PROFIL (DUMMY) --}}
    <div id="profileModal" class="fixed inset-0 bg-black bg-opacity-60 z-50 flex justify-center items-center p-4 hidden">
        <div id="profileModalContent" class="modal-content bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative transform scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-200">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800"><i class="bi bi-pencil-square text-teal-500"></i>Edit Profil</h3>
                <button id="closeProfileModalBtn" class="text-slate-400 hover:text-slate-800 text-3xl leading-none">&times;</button>
            </div>
            
            <form id="editProfileFormDummy" action="#!" method="POST" class="space-y-4 pt-2">
                @csrf
                @method('PATCH')
                
                {{-- Fitur Foto Profil (Dummy/Non-aktif) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&size=128&bold=true' }}" alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                        <div class="opacity-50">
                            <label for="profile_photo_dummy" class="cursor-not-allowed bg-slate-100 text-slate-800 font-semibold py-2 px-4 rounded-lg text-sm">
                                Pilih Foto
                            </label>
                            <input type="file" name="profile_photo_dummy" id="profile_photo_dummy" class="hidden" accept="image/*" disabled>
                            <p class="text-xs text-slate-500 mt-2">Fitur ini masih dummy.</p>
                        </div>
                    </div>
                </div>

                {{-- Fitur Username (Dummy/Non-aktif) --}}
                <div>
                    <label for="name_dummy" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="name_dummy" id="name_dummy" value="{{ Auth::user()->name }}" class="block w-full px-3 py-2 border border-slate-300 rounded-md bg-slate-100 cursor-not-allowed" readonly>
                </div>
                <hr class="border-slate-200 !my-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password" class="block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" id="cancelProfileChangeBtn" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2 px-6 rounded-lg mr-3">Batal</button>
                    <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Dropdown Logic
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const logoutButton = document.getElementById('logout-button');

            if (userMenuButton) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
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
                            logoutButton.closest('form').submit(); // Ini akan submit form logout
                        }
                    });
                });
            }

            // --- Modal Edit Profile Logic ---
            const profileModal = document.getElementById('profileModal');
            const profileModalContent = document.getElementById('profileModalContent');
            const openProfileModalBtn = document.getElementById('openProfileModalBtn');
            const closeProfileModalBtn = document.getElementById('closeProfileModalBtn');
            const cancelProfileChangeBtn = document.getElementById('cancelProfileChangeBtn');
            const editProfileFormDummy = document.getElementById('editProfileFormDummy'); // Form di modal

            const openModal = (modal, content) => {
                modal.classList.remove('hidden');
                setTimeout(() => content.classList.remove('scale-95', 'opacity-0'), 10);
            };

            const closeModal = (modal, content) => {
                content.classList.add('scale-95', 'opacity-0');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            openProfileModalBtn.addEventListener('click', () => openModal(profileModal, profileModalContent));
            closeProfileModalBtn.addEventListener('click', () => closeModal(profileModal, profileModalContent));
            cancelProfileChangeBtn.addEventListener('click', () => closeModal(profileModal, profileModalContent));
            profileModal.addEventListener('click', (e) => { 
                if (e.target === profileModal) closeModal(profileModal, profileModalContent); 
            });

            // Handle dummy form submission
            editProfileFormDummy.addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah submit form
                
                const password = document.getElementById('password').value;
                const password_confirmation = document.getElementById('password_confirmation').value;

                if (password || password_confirmation) {
                    if (password !== password_confirmation) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Konfirmasi password tidak cocok.',
                            confirmButtonColor: '#14b8a6'
                        });
                        return;
                    }
                    if (password.length < 8) { // Contoh validasi minimal 8 karakter
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Password minimal 8 karakter.',
                            confirmButtonColor: '#14b8a6'
                        });
                        return;
                    }

                    // Jika password valid, ini adalah bagian yang akan kamu arahkan ke controller
                    // Untuk dummy, kita tampilkan alert berhasil.
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Password berhasil diubah (Dummy).',
                        confirmButtonColor: '#14b8a6'
                    }).then(() => {
                        closeModal(profileModal, profileModalContent);
                        // Reset form password setelah berhasil
                        document.getElementById('password').value = '';
                        document.getElementById('password_confirmation').value = '';
                    });
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: 'Tidak ada perubahan yang disimpan (hanya password yang bisa diubah saat ini).',
                        confirmButtonColor: '#14b8a6'
                    });
                    closeModal(profileModal, profileModalContent);
                }
            });


            // SweetAlert for Laravel session success (jika ada)
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#14b8a6'
                });
            @endif

            // SweetAlert for Validation Errors (jika ada error dari Laravel)
            @if($errors->any())
                let errorMessages = `<ul class="mt-2 list-disc list-inside text-sm text-left">`;
                @foreach ($errors->all() as $error)
                    errorMessages += `<li>{{ $error }}</li>`;
                @endforeach
                errorMessages += `</ul>`;

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memperbarui Profil',
                    html: errorMessages,
                    confirmButtonColor: '#14b8a6'
                });
                openModal(profileModal, profileModalContent); // Buka kembali modal edit profil
            @endif
        });
    </script>
</body>
</html>