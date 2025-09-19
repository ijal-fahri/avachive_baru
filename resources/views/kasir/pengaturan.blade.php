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
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-ico">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            transition: all 0.3s ease-in-out;
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
                    <h1 class="text-lg font-semibold text-slate-800">Profil Kasir</h1>
                </div>
                <div class="relative">
                    {{-- Ganti bagian ini di header setiap halaman kasir --}}
                    {{-- ...existing code... --}}
                    {{-- ...existing code... --}}
                    <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                        <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto Profil"
                                class="w-8 h-8 rounded-full object-cover border-2 border-blue-400 shadow">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=64&bold=true"
                                alt="Avatar" class="w-8 h-8 rounded-full border-2 border-blue-400 shadow">
                        @endif
                    </button>
                    {{-- ...existing code... --}}
                    {{-- ...existing code... --}}
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

            <div class="pb-20 pt-20 lg:pt-6 max-w-4xl mx-auto space-y-8 mt-4">
                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-person-circle text-blue-600"></i> Profil Anda
                    </h3>
                    <div class="flex flex-col sm:flex-row items-center gap-6">
                        @if (Auth::user()->profile_photo)
                            <img id="profilePhoto" src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                                alt="Foto Profil"
                                class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md object-cover cursor-pointer">
                        @else
                            <img id="profilePhoto"
                                src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&size=128&bold=true' }}"
                                alt="Foto Profil"
                                class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md cursor-pointer">
                        @endif
                        <div class="text-center sm:text-left">
                            <strong class="text-2xl font-bold text-slate-900">{{ Auth::user()->name }}</strong>
                            <p class="text-slate-500 mt-1">Role: {{ ucfirst(Auth::user()->usertype) }}</p>
                            <button id="openProfileModalBtn"
                                class="mt-4 bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors duration-200 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                <i class="bi bi-pencil-square mr-2"></i>Edit Profil
                            </button>
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

    {{-- MODAL EDIT PROFIL --}}
    <div id="profileModal"
        class="fixed inset-0 bg-black bg-opacity-60 z-50 flex justify-center items-center p-4 hidden">
        <div id="profileModalContent"
            class="modal-content bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative transform scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-200">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800"><i
                        class="bi bi-pencil-square text-teal-500"></i>Edit Profil</h3>
                <button id="closeProfileModalBtn"
                    class="text-slate-400 hover:text-slate-800 text-3xl leading-none">&times;</button>
            </div>

            <form id="editProfileForm" action="{{ route('kasir.pengaturan.update', $user->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4 pt-2">
                @csrf
                @method('PUT')

                {{-- Fitur Foto Profil (Dummy/Non-aktif) --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('uploads/profile_photos/' . Auth::user()->profile_photo) }}"
                                alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                        @else
                            <img src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=3b82f6&color=fff&size=128&bold=true' }}"
                                alt="Foto Profil" class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                        @endif
                        <div>
                            <label for="profile_photo"
                                class="cursor-pointer bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold py-2 px-4 rounded-lg text-sm">
                                Pilih Foto
                            </label>
                            <input type="file" name="profile_photo" id="profile_photo" class="hidden"
                                accept="image/*">
                            <p class="text-xs text-slate-500 mt-2">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>


                {{-- Username --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name', Auth::user()->name) }}"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>
                <hr class="border-slate-200 !my-6">

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                    <input type="password" name="password" id="password"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400">
                </div>
                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400">
                    <p class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" id="cancelProfileChangeBtn"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2 px-6 rounded-lg mr-3">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white font-bold py-2 px-6 rounded-lg shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Modal Preview Foto Profil -->
    <div id="photoPreviewModal"
        class="fixed inset-0 bg-black bg-opacity-70 z-50 hidden flex justify-center items-center p-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 relative max-w-xs w-full flex flex-col items-center">
            <button id="closePhotoPreviewBtn"
                class="absolute top-2 right-3 text-slate-400 hover:text-slate-800 text-3xl leading-none">&times;</button>
            @if (Auth::user()->profile_photo)
                <img src="{{ asset('uploads/profile_photos/' . Auth::user()->profile_photo) }}" alt="Foto Profil"
                    class="w-48 h-48 rounded-full object-cover border-4 border-teal-400 shadow-md">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=256&bold=true"
                    alt="Foto Profil" class="w-48 h-48 rounded-full border-4 border-teal-400 shadow-md">
            @endif
            <div class="mt-4 text-center text-lg font-semibold text-slate-800">{{ Auth::user()->name }}</div>
        </div>
    </div>

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

            // --- Modal Edit Profile Logic ---
            const profileModal = document.getElementById('profileModal');
            const profileModalContent = document.getElementById('profileModalContent');
            const openProfileModalBtn = document.getElementById('openProfileModalBtn');
            const closeProfileModalBtn = document.getElementById('closeProfileModalBtn');
            const cancelProfileChangeBtn = document.getElementById('cancelProfileChangeBtn');

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

            // Foto Profil Preview Modal
            const profilePhoto = document.getElementById('profilePhoto');
            const photoPreviewModal = document.getElementById('photoPreviewModal');
            const closePhotoPreviewBtn = document.getElementById('closePhotoPreviewBtn');

            if (profilePhoto && photoPreviewModal && closePhotoPreviewBtn) {
                profilePhoto.addEventListener('click', () => {
                    photoPreviewModal.classList.remove('hidden');
                });
                closePhotoPreviewBtn.addEventListener('click', () => {
                    photoPreviewModal.classList.add('hidden');
                });
                photoPreviewModal.addEventListener('click', (e) => {
                    if (e.target === photoPreviewModal) photoPreviewModal.classList.add('hidden');
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

            // SweetAlert for Laravel session success (jika ada)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#14b8a6'
                });
            @endif

            // SweetAlert for Validation Errors (jika ada error dari Laravel)
            @if ($errors->any())
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
