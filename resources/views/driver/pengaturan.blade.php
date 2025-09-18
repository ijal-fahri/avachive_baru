@php use Illuminate\Support\Facades\Auth; @endphp
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

        .modal-content {
            transition: all 0.3s ease-in-out;
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
                    {{-- ...existing code... --}}
                    <button id="profileDropdownBtn"
                        class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-600 hover:ring-2 hover:ring-blue-400 transition-all">
                        @if (Auth::user()->profile_photo)
                            <img src="{{ asset('uploads/profile_photos/' . Auth::user()->profile_photo) }}"
                                alt="Foto Profil"
                                class="w-10 h-10 rounded-full object-cover border-2 border-blue-400 shadow">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff&size=64&bold=true"
                                alt="Avatar" class="w-10 h-10 rounded-full border-2 border-blue-400 shadow">
                        @endif
                    </button>
                    {{-- ...existing code... --}}
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
                    @if ($user->profile_photo)
                        <img id="profilePhoto" src="{{ asset('uploads/profile_photos/' . $user->profile_photo) }}"
                            alt="Foto Profil"
                            class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md object-cover cursor-pointer">
                    @else
                        <img id="profilePhoto"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3498db&color=fff&size=128&bold=true"
                            alt="Foto Profil"
                            class="w-24 h-24 rounded-full border-4 border-teal-400 shadow-md cursor-pointer">
                    @endif
                    <div class="profile-info">
                        <h4 class="text-2xl font-bold text-slate-900">{{ $user->name }}</h4>
                        <p class="text-slate-500 mt-1">Role: {{ $user->usertype }}</p>
                        <button id="openProfileModalBtn"
                            class="mt-4 bg-teal-500 hover:bg-teal-600 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors duration-200 shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                            <i class="bi bi-pencil-square mr-2"></i>Edit Profil
                        </button>
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

        {{-- Navigasi mobile disesuaikan agar konsisten --}}
        <nav
            class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] z-30 flex justify-around items-center px-2">
            <a href="/driver/dashboard"
                class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
                <i class="bi bi-box-seam text-2xl"></i>
                <span class="text-xs">Pengiriman</span>
            </a>
            <a href="/driver/riwayat"
                class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
                <i class="bi bi-clock-history text-2xl"></i>
                <span class="text-xs">Riwayat</span>
            </a>
        </nav>
    </div>

    {{-- MODAL EDIT PROFIL --}}
    <div id="profileModal"
        class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden flex justify-center items-center p-4">
        <div id="profileModalContent"
            class="modal-content bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative transform scale-95 opacity-0">
            <div class="flex justify-between items-center mb-4 pb-3 border-b border-slate-200">
                <h3 class="flex items-center gap-3 text-xl font-semibold text-slate-800"><i
                        class="bi bi-pencil-square text-teal-500"></i>Edit Profil</h3>
                <button id="closeProfileModalBtn"
                    class="text-slate-400 hover:text-slate-800 text-3xl leading-none">&times;</button>
            </div>
            <form id="editProfileForm" action="{{ route('driver.pengaturan.update', $user->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4 pt-2">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Foto Profil</label>
                    <div class="flex items-center gap-4">
                        @if ($user->profile_photo)
                            <img src="{{ asset('uploads/profile_photos/' . $user->profile_photo) }}" alt="Foto Profil"
                                class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3498db&color=fff&size=128&bold=true"
                                alt="Foto Profil"
                                class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                        @endif
                        <input type="file" name="profile_photo" accept="image/*" class="block mt-2 text-sm">
                    </div>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                    <input type="text" id="name" name="name" value="{{ $user->name }}"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md" required>
                </div>
                <hr class="border-slate-200 !my-6">
                <h4 class="text-base font-semibold text-slate-800 -mb-2">Ubah Password</h4>
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru</label>
                    <input type="password" id="password" name="password"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md">
                </div>
                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="block w-full px-3 py-2 border border-slate-300 rounded-md">
                </div>
                <div class="flex justify-end pt-4">
                    <button type="button" id="cancelProfileChangeBtn"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-2 px-6 rounded-lg mr-3">Tutup</button>
                    <button type="submit"
                        class="bg-teal-500 text-white font-bold py-2 px-6 rounded-lg shadow-md">Simpan
                        Perubahan</button>
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
            @if ($user->profile_photo)
                <img src="{{ asset('uploads/profile_photos/' . $user->profile_photo) }}" alt="Foto Profil"
                    class="w-48 h-48 rounded-full object-cover border-4 border-teal-400 shadow-md">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=3498db&color=fff&size=256&bold=true"
                    alt="Foto Profil" class="w-48 h-48 rounded-full border-4 border-teal-400 shadow-md">
            @endif
            <div class="mt-4 text-center text-lg font-semibold text-slate-800">{{ $user->name }}</div>
        </div>
    </div>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                            document.getElementById('logout-form').submit();
                        }
                    });
                });
            }

            // ====== DUMMY EDIT PROFILE MODAL LOGIC ======
            const profileModal = el('#profileModal');
            const profileModalContent = el('#profileModalContent');
            const openProfileModalBtn = el('#openProfileModalBtn');
            const closeProfileModalBtn = el('#closeProfileModalBtn');
            const cancelProfileChangeBtn = el('#cancelProfileChangeBtn');
            const editProfileFormDummy = el('#editProfileFormDummy');

            const openModal = () => {
                profileModal.classList.remove('hidden');
                setTimeout(() => profileModalContent.classList.remove('scale-95', 'opacity-0'), 10);
            };
            const closeModal = () => {
                profileModalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => profileModal.classList.add('hidden'), 300);
            };

            openProfileModalBtn.addEventListener('click', openModal);
            closeProfileModalBtn.addEventListener('click', closeModal);
            cancelProfileChangeBtn.addEventListener('click', closeModal);
            profileModal.addEventListener('click', (e) => {
                if (e.target === profileModal) closeModal();
            });

            // Handle dummy form submission
            editProfileFormDummy.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Fitur Belum Tersedia',
                    text: 'Fungsi untuk mengubah profil masih dalam tahap pengembangan.',
                    confirmButtonColor: '#14b8a6'
                });
            });

            // ====== PHOTO PREVIEW MODAL LOGIC ======
            const photoPreviewModal = el('#photoPreviewModal');
            const closePhotoPreviewBtn = el('#closePhotoPreviewBtn');

            // Function to open the photo preview modal
            window.openPhotoPreview = () => {
                photoPreviewModal.classList.remove('hidden');
            };

            // Function to close the photo preview modal
            const closePhotoPreviewModal = () => {
                photoPreviewModal.classList.add('hidden');
            };

            closePhotoPreviewBtn.addEventListener('click', closePhotoPreviewModal);
            photoPreviewModal.addEventListener('click', (e) => {
                if (e.target === photoPreviewModal) closePhotoPreviewModal();
            });
        });

        // ...existing code...
        const profilePhoto = document.getElementById('profilePhoto');
        const photoPreviewModal = document.getElementById('photoPreviewModal');
        const closePhotoPreviewBtn = document.getElementById('closePhotoPreviewBtn');

        profilePhoto.addEventListener('click', () => {
            photoPreviewModal.classList.remove('hidden');
        });
        closePhotoPreviewBtn.addEventListener('click', () => {
            photoPreviewModal.classList.add('hidden');
        });
        photoPreviewModal.addEventListener('click', (e) => {
            if (e.target === photoPreviewModal) photoPreviewModal.classList.add('hidden');
        });
        // ...existing code...
    </script>

</body>

</html>
