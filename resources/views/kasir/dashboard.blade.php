<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dashboard Kasir</title>
    <script src="https://kit.fontawesome.com/0948e65078.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .modal {
            transition: opacity 0.3s ease;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .service-table {
            width: 100%;
            border-collapse: collapse;
        }

        .service-table th,
        .service-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .service-table th {
            background-color: #f9fafb;
            font-weight: 600;
        }

        .service-table tr:hover {
            background-color: #f3f4f6;
        }

        .layanan-modal-content {
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .layanan-modal-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
        }

        .layanan-modal-body {
            flex: 1 1 auto;
            overflow-y: auto;
        }

        .loading-spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Styling untuk select yang disabled */
        select:disabled {
            background-color: #f9fafb;
            color: #6b7280;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar Start -->
    @include('components.sidebar_kasir')
    <!-- Sidebar End -->

    <!-- Main Content Start -->
    <div class="ml-0 lg:ml-64 min-h-screen p-6">
        <!-- Header -->
        <div
            class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
            <div class="flex items-center gap-4">
                <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="text-lg font-semibold text-slate-800">Dashboard Kasir Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
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

        <div class="pt-20 lg:pt-6 mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Selamat Datang di Dashboard</h1>
            <p class="text-gray-600 mt-2">Ringkasan aktivitas laundry Anda</p>
        </div>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Ringkasan Laporan Card -->
            <div class="bg-white rounded-xl shadow-md p-6 col-span-1 md:col-span-2">
                <h2 class="text-xl font-semibold mb-6 text-gray-800">Ringkasan Laporan</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-blue-600">Pendapatan Hari Ini</p>
                        <p class="font-bold text-lg">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <p class="text-sm text-green-600">Order Hari Ini</p>
                        <p class="font-bold text-lg">{{ $todayOrders }}</p>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <p class="text-sm text-purple-600">Order Bulan Ini</p>
                        <p class="font-bold text-lg">{{ $monthOrders }}</p>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-yellow-600">Pelanggan Terbaru</p>
                        <p class="font-bold text-lg">{{ $newCustomers }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold mb-6 text-gray-800">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="buat_order" class="block">
                        <button
                            class="w-full flex items-center justify-between p-3 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                            <span>Buat Order Baru</span>
                            <i class="fas fa-plus"></i>
                        </button>
                    </a>
                    <button id="openModalFromQuickAction"
                        class="w-full flex items-center justify-between p-3 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition">
                        <span>Tambah Pelanggan</span>
                        <i class="fas fa-user-plus"></i>
                    </button>
                    <a href="data_order" class="block">
                        <button
                            class="w-full flex items-center justify-between p-3 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition">
                            <span>Lihat Semua Order</span>
                            <i class="fas fa-list"></i>
                        </button>
                    </a>
                </div>
            </div>

            <!-- Kelola Laundry Card -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-xl font-semibold mb-6 text-gray-800">Kelola Laundry</h2>
                <div class="grid grid-cols-2 gap-4">
                    <a href="javascript:void(0);" id="openServiceModal"
                        class="text-center p-4 hover:bg-gray-50 rounded-lg transition cursor-pointer">
                        <div class="text-blue-600 text-3xl mb-2">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <p class="text-sm font-semibold">Layanan</p>
                        <p class="text-xs text-gray-600">{{ $totalServices }} Layanan aktif</p>
                    </a>
                    <a href="pelanggan" class="text-center p-4 hover:bg-gray-50 rounded-lg transition cursor-pointer">
                        <div class="text-green-600 text-3xl mb-2">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="text-sm font-semibold">Pelanggan</p>
                        <p class="text-xs text-gray-600">{{ $totalCustomers }} Pelanggan</p>
                    </a>
                    <a href="data_order" class="text-center p-4 hover:bg-gray-50 rounded-lg transition cursor-pointer">
                        <div class="text-purple-600 text-3xl mb-2">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <p class="text-sm font-semibold">Data Order</p>
                        <p class="text-xs text-gray-600">{{ $totalOrders }} Order</p>
                    </a>
                    <a href="pengaturan" class="text-center p-4 hover:bg-gray-50 rounded-lg transition cursor-pointer">
                        <div class="text-yellow-600 text-3xl mb-2">
                            <i class="fas fa-cog"></i>
                        </div>
                        <p class="text-sm font-semibold">Pengaturan</p>
                        <p class="text-xs text-gray-600">Konfigurasi sistem</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content End -->

    <!-- Pelanggan Modal -->
    <div id="pelangganModal"
        class="hidden fixed inset-0 z-50 flex items-start justify-center pt-10 pb-10 bg-white/50 backdrop-blur-sm transition-opacity overflow-y-auto">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 my-8 modal-content"
            style="max-height: 80vh; overflow-y: auto;">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Pelanggan</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <form id="formPelanggan" action="{{ route('pelanggan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="provinsi" id="provinsi_nama">
                    <input type="hidden" name="kota" id="kota_nama">
                    <input type="hidden" name="kecamatan" id="kecamatan_nama">
                    <input type="hidden" name="desa" id="desa_nama">

                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama
                            Pelanggan</label>
                        <input type="text" name="nama" id="nama"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Tambahkan field nomor handphone -->
                    <div class="mb-4">
                        <label for="no_handphone" class="block text-sm font-medium text-gray-700 mb-1">No.
                            Handphone</label>
                        <input type="tel" name="no_handphone" id="no_handphone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <!-- Dropdown Wilayah Indonesia -->
                    <div class="mb-4">
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <div class="relative">
                            <select id="provinsi" name="provinsi_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none"
                                required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="loading-provinsi" class="hidden mt-2 text-sm text-blue-600">
                            <span class="loading-spinner mr-1"></span> Memuat provinsi...
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="kota"
                            class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                        <div class="relative">
                            <select id="kota" name="kota_id" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-gray-100"
                                required>
                                <option value="">Pilih Kota/Kabupaten</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="loading-kota" class="hidden mt-2 text-sm text-blue-600">
                            <span class="loading-spinner mr-1"></span> Memuat kota...
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <div class="relative">
                            <select id="kecamatan" name="kecamatan_id" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-gray-100"
                                required>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="loading-kecamatan" class="hidden mt-2 text-sm text-blue-600">
                            <span class="loading-spinner mr-1"></span> Memuat kecamatan...
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="desa"
                            class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                        <div class="relative">
                            <select id="desa" name="desa_id" disabled
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-gray-100">
                                <option value="">Pilih Desa/Kelurahan</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <div id="loading-desa" class="hidden mt-2 text-sm text-blue-600">
                            <span class="loading-spinner mr-1"></span> Memuat desa/kelurahan...
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="kodepos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="kodepos" id="kodepos"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="detail_alamat" class="block text-sm font-medium text-gray-700 mb-1">Detail Alamat
                            (Nama Jalan, Gedung, No Rumah)</label>
                        <textarea name="detail_alamat" id="detail_alamat" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required></textarea>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelBtn"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Kembali</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">Simpan
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Layanan Modal -->
    <div id="layananModal"
        class="hidden fixed inset-0 z-50 flex items-start justify-center pt-10 pb-10 bg-white/50 backdrop-blur-sm transition-opacity overflow-y-auto">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl mx-4 my-8 modal-content layanan-modal-content">
            <!-- Header Modal -->
            <div
                class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center layanan-modal-header">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Layanan</h2>
                <button id="closeLayananModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Search Bar Sticky -->
            <div class="sticky top-[64px] bg-white px-6 py-4 z-10 layanan-modal-header">
                <div class="relative">
                    <input type="text" id="searchLayanan" placeholder="Cari layanan..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
            </div>
            <!-- Body Scroll -->
            <div class="layanan-modal-body p-6">
                <div class="overflow-x-auto">
                    <table class="service-table">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diisi oleh JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Dropdown Logic
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const logoutButton = document.getElementById('logout-button');

            if (userMenuButton) {
                userMenuButton.addEventListener('click', () => {
                    userMenu.classList.toggle('hidden');
                });
            }

            window.addEventListener('click', function(e) {
                if (userMenuButton && !userMenuButton.contains(e.target) && userMenu && !userMenu.contains(e
                        .target)) {
                    userMenu.classList.add('hidden');
                }
            });

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

            // --- LOGIKA MODAL PELANGGAN & API WILAYAH ---
            const apiBaseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';
            const pelangganModal = document.getElementById('pelangganModal');
            const openQuickActionBtn = document.getElementById('openModalFromQuickAction');
            const closeModalBtn = document.getElementById('closeModal');
            const cancelModalBtn = document.getElementById('cancelBtn');

            // Fungsi untuk mengambil data dan mengisi dropdown
            async function populateSelect(url, selectElement, defaultText, selectedId = null) {
                try {
                    // Tampilkan loading spinner
                    const loadingElement = document.getElementById(`loading-${selectElement.id}`);
                    if (loadingElement) loadingElement.classList.remove('hidden');

                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();

                    selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                    data.forEach(item => {
                        const option = new Option(item.name, item.id);
                        if (selectedId && item.id == selectedId) {
                            option.selected = true;
                        }
                        selectElement.add(option);
                    });

                    // Sembunyikan loading spinner
                    if (loadingElement) loadingElement.classList.add('hidden');
                } catch (error) {
                    console.error(`Error loading data for ${selectElement.id}:`, error);
                    // Sembunyikan loading spinner jika error
                    const loadingElement = document.getElementById(`loading-${selectElement.id}`);
                    if (loadingElement) loadingElement.classList.add('hidden');
                }
            }

            // Fungsi untuk mengatur listener pada dropdown
            function setupDropdownListeners(provSelect, kotaSelect, kecSelect, desaSelect, hiddenInputs) {
                provSelect.addEventListener('change', function() {
                    const selectedText = this.options[this.selectedIndex].text;
                    hiddenInputs.provinsi.value = (this.value) ? selectedText : '';
                    hiddenInputs.kota.value = '';
                    hiddenInputs.kecamatan.value = '';
                    hiddenInputs.desa.value = '';

                    populateSelect(`${apiBaseUrl}/regencies/${this.value}.json`, kotaSelect,
                        'Pilih Kota/Kabupaten');
                    kotaSelect.disabled = !this.value;
                    kotaSelect.classList.toggle('bg-gray-100', !this.value);
                    kecSelect.disabled = true;
                    kecSelect.classList.add('bg-gray-100');
                    kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    desaSelect.disabled = true;
                    desaSelect.classList.add('bg-gray-100');
                    desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                });

                kotaSelect.addEventListener('change', function() {
                    hiddenInputs.kota.value = (this.value) ? this.options[this.selectedIndex].text : '';
                    hiddenInputs.kecamatan.value = '';
                    hiddenInputs.desa.value = '';

                    populateSelect(`${apiBaseUrl}/districts/${this.value}.json`, kecSelect,
                        'Pilih Kecamatan');
                    kecSelect.disabled = !this.value;
                    kecSelect.classList.toggle('bg-gray-100', !this.value);
                    desaSelect.disabled = true;
                    desaSelect.classList.add('bg-gray-100');
                    desaSelect.innerHTML = '<option value="">Pilih Desa</option>';
                });

                kecSelect.addEventListener('change', function() {
                    hiddenInputs.kecamatan.value = (this.value) ? this.options[this.selectedIndex].text :
                        '';
                    hiddenInputs.desa.value = '';

                    populateSelect(`${apiBaseUrl}/villages/${this.value}.json`, desaSelect,
                        'Pilih Desa/Kelurahan');
                    desaSelect.disabled = !this.value;
                    desaSelect.classList.toggle('bg-gray-100', !this.value);
                });

                desaSelect.addEventListener('change', function() {
                    hiddenInputs.desa.value = (this.value) ? this.options[this.selectedIndex].text : '';
                });
            }

            // Inisialisasi untuk Modal Tambah Pelanggan di Dashboard
            const addProvinsi = document.getElementById('provinsi');
            const addKota = document.getElementById('kota');
            const addKecamatan = document.getElementById('kecamatan');
            const addDesa = document.getElementById('desa');
            const addHiddenInputs = {
                provinsi: document.getElementById('provinsi_nama'),
                kota: document.getElementById('kota_nama'),
                kecamatan: document.getElementById('kecamatan_nama'),
                desa: document.getElementById('desa_nama')
            };

            // Setup dropdown listeners
            setupDropdownListeners(addProvinsi, addKota, addKecamatan, addDesa, addHiddenInputs);

            const openModal = () => {
                document.getElementById('formPelanggan').reset();
                addKota.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                addKota.disabled = true;
                addKota.classList.add('bg-gray-100');
                addKecamatan.innerHTML = '<option value="">Pilih Kecamatan</option>';
                addKecamatan.disabled = true;
                addKecamatan.classList.add('bg-gray-100');
                addDesa.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                addDesa.disabled = true;
                addDesa.classList.add('bg-gray-100');

                // Reset hidden inputs
                addHiddenInputs.provinsi.value = '';
                addHiddenInputs.kota.value = '';
                addHiddenInputs.kecamatan.value = '';
                addHiddenInputs.desa.value = '';

                populateSelect(`${apiBaseUrl}/provinces.json`, addProvinsi, 'Pilih Provinsi');
                pelangganModal.classList.remove('hidden');
            }

            const closeModal = () => {
                pelangganModal.classList.add('hidden');
            }

            openQuickActionBtn.addEventListener('click', openModal);
            closeModalBtn.addEventListener('click', closeModal);
            cancelModalBtn.addEventListener('click', closeModal);

            // --- LOGIKA MODAL LAYANAN ---
            const layananModal = document.getElementById('layananModal');
            const openServiceBtn = document.getElementById('openServiceModal');
            const closeLayananBtn = document.getElementById('closeLayananModal');
            const searchLayananInput = document.getElementById('searchLayanan');
            const rawData = @json($layanans);

            const layananData = rawData.map(item => ({
                kategori: item.paket,
                nama: item.nama,
                harga: item.harga,
                satuan: item.kategori
            }));

            openServiceBtn.addEventListener('click', (e) => {
                e.preventDefault();
                populateLayananTable(layananData);
                layananModal.classList.remove('hidden');
            });

            const closeLayananModal = () => {
                layananModal.classList.add('hidden');
            };

            closeLayananBtn.addEventListener('click', closeLayananModal);

            searchLayananInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const filteredData = layananData.filter(item =>
                    item.nama.toLowerCase().includes(searchTerm) ||
                    item.kategori.toLowerCase().includes(searchTerm)
                );
                populateLayananTable(filteredData);
            });

            function populateLayananTable(data) {
                const tbody = layananModal.querySelector('tbody');
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML =
                        '<tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada layanan yang ditemukan</td></tr>';
                    return;
                }
                data.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td>${capitalizeFirstLetter(item.kategori)}</td>
                <td>${item.nama}</td>
                <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                <td>${item.satuan}</td>
            `;
                    tbody.appendChild(row);
                });
            }

            function capitalizeFirstLetter(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (!pelangganModal.classList.contains('hidden')) closeModal();
                    if (!layananModal.classList.contains('hidden')) closeLayananModal();
                }
            });

            // Handle form submission
            document.getElementById('formPelanggan').addEventListener('submit', function(e) {
                // Pastikan semua hidden input terisi dengan nilai yang benar
                const provinsiSelect = document.getElementById('provinsi');
                const kotaSelect = document.getElementById('kota');
                const kecamatanSelect = document.getElementById('kecamatan');
                const desaSelect = document.getElementById('desa');

                if (provinsiSelect.value) {
                    addHiddenInputs.provinsi.value = provinsiSelect.options[provinsiSelect.selectedIndex]
                        .text;
                }
                if (kotaSelect.value) {
                    addHiddenInputs.kota.value = kotaSelect.options[kotaSelect.selectedIndex].text;
                }
                if (kecamatanSelect.value) {
                    addHiddenInputs.kecamatan.value = kecamatanSelect.options[kecamatanSelect.selectedIndex]
                        .text;
                }
                if (desaSelect.value) {
                    addHiddenInputs.desa.value = desaSelect.options[desaSelect.selectedIndex].text;
                }
            });
        });
    </script>

</body>

</html>