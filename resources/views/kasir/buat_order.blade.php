<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Order</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/0948e65078.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <style>
        .modal-content {
            max-height: 70vh;
            overflow-y: auto;
        }

        .selected-customer {
            background-color: #f0f9ff;
            border-left: 4px solid #3b82f6;
        }

        .service-card {
            transition: all 0.2s ease;
        }

        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .quantity-control {
            width: 100px;
        }

        .sticky-summary {
            position: sticky;
            top: 1rem;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Styling untuk DP section */
        .dp-section {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }

        .dp-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }

        .remaining-amount {
            font-weight: bold;
            color: #dc2626;
            margin-top: 0.5rem;
        }

        .payment-summary {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        /* Styling untuk tunai section */
        .tunai-section {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            background-color: #f8fafc;
            transition: all 0.3s ease;
        }

        .uang-diberikan-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }

        .kembalian-amount {
            font-weight: bold;
            color: #059669;
            margin-top: 0.5rem;
        }

        .payment-error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('components.sidebar_kasir')

    <div class="ml-0 lg:ml-64 min-h-screen p-6">
        <div
            class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
            <div class="flex items-center gap-4">
                <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="text-lg font-semibold text-slate-800">Buat Order Cabang
                    {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
            </div>
            <div class="relative">
                <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                    <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                    @if (Auth::user()->profile_photo)
                        <img src="{{ asset('uploads/profile_photos/' . Auth::user()->profile_photo) }}"
                            alt="Foto Profil" class="w-8 h-8 rounded-full object-cover border-2 border-blue-400 shadow">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=64&bold=true"
                            alt="Avatar" class="w-8 h-8 rounded-full border-2 border-blue-400 shadow">
                    @endif
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

        <div class="pt-20 lg:pt-6 max-w-6xl mx-auto">
            <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Buat Order Baru</h1>
                    <p class="text-gray-600 mt-1">Pilih layanan untuk order baru</p>
                </div>
            </div>

            <form id="orderForm" action="{{ route('buat_order.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tambah_pelanggan_id" id="tambah_pelanggan_id">
                <input type="hidden" name="layanan" id="layanan_input">
                <input type="hidden" name="total_harga" id="total_harga_input">
                <input type="hidden" name="dp_amount" id="dp_amount_input" value="0">
                <input type="hidden" name="remaining_amount" id="remaining_amount_input" value="0">
                <input type="hidden" name="uang_diberikan" id="uang_diberikan_input" value="0">
                <input type="hidden" name="kembalian" id="kembalian_input" value="0">

                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Services Section -->
                    <div class="lg:w-2/3">
                        <div class="bg-white rounded-xl shadow-sm p-6">
                            <!-- Header with title and search -->
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-xl font-semibold text-gray-800">Daftar Layanan</h2>
                                <div class="relative w-64">
                                    <input type="text" placeholder="Cari layanan..." id="serviceSearch"
                                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>

                            <!-- Category filter buttons -->
                            <div class="flex justify-center mb-6 space-x-4">
                                <button type="button"
                                    class="category-filter px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-50 transition"
                                    data-category="Semua">
                                    Semua
                                </button>
                                <button type="button"
                                    class="category-filter px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-50 transition"
                                    data-category="Satuan">
                                    Satuan
                                </button>
                                <button type="button"
                                    class="category-filter px-4 py-2 rounded-full border border-blue-500 text-blue-500 hover:bg-blue-50 transition"
                                    data-category="Kiloan">
                                    Kiloan
                                </button>
                            </div>

                            <!-- Services list -->
                            <div class="grid grid-cols-1 gap-4 service-list">
                                @foreach ($layanans as $layanan)
                                    <div class="service-card border rounded-lg p-4 hover:border-blue-400 cursor-pointer"
                                        data-id="{{ $layanan->id }}" data-nama="{{ $layanan->nama }}"
                                        data-harga="{{ $layanan->harga }}" data-kategori="{{ $layanan->kategori }}"
                                        data-paket="{{ $layanan->paket }}">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-bold text-lg text-gray-800">{{ $layanan->nama }}</h3>
                                                <div class="flex gap-4 mt-1">
                                                    <p class="text-sm text-gray-600">
                                                        Paket: <span
                                                            class="text-gray-800">{{ $layanan->paket }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="text-right flex flex-col items-end">
                                                <p class="font-bold text-blue-600">
                                                    Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                                                </p>
                                                <button type="button"
                                                    class="mt-2 px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition add-service-btn">
                                                    + Tambah
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary Section -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-sm p-6 sticky-summary">
                            <h2 class="text-xl font-semibold mb-4 text-gray-800">Ringkasan Order</h2>

                            <!-- Customer Selection -->
                            <div class="w-full mb-4">
                                <button id="openCustomerModal" type="button"
                                    class="w-full bg-blue-100 text-blue-600 px-4 py-2 rounded-lg flex items-center justify-center hover:bg-blue-200 transition">
                                    <i class="fas fa-user-plus mr-2"></i> Pilih Pelanggan
                                </button>
                                <div id="selectedCustomerDisplay"
                                    class="hidden mt-2 p-3 bg-blue-50 rounded-lg border border-blue-100">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-medium text-blue-700" id="customerName"></p>
                                            <p class="text-sm text-blue-600" id="customerPhone"></p>
                                        </div>
                                        <button id="clearCustomer" type="button"
                                            class="text-blue-400 hover:text-blue-600">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Services -->
                            <div class="mb-6">
                                <h3 class="font-medium text-gray-700 mb-3">Layanan yang Dipilih:</h3>
                                <div id="selectedServicesList" class="space-y-3"></div>
                            </div>

                            <!-- Total Price -->
                            <div class="border-t pt-4 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-gray-800">Total Harga:</span>
                                    <span id="totalPriceDisplay" class="font-bold text-lg text-blue-600">Rp 0</span>
                                </div>
                            </div>

                            <!-- Order Options - PERUBAHAN DIMULAI DI SINI -->
                            <div class="space-y-4 mb-6">
                                <!-- Waktu Pembayaran dipindahkan ke atas -->
                                <div>
                                    <label for="waktu_pembayaran"
                                        class="block text-sm font-medium text-gray-700 mb-2">Waktu Pembayaran</label>
                                    <select name="waktu_pembayaran" id="waktu_pembayaran"
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="Bayar Sekarang">Bayar Sekarang</option>
                                        <option value="Bayar Nanti">Bayar Nanti</option>
                                    </select>
                                </div>

                                <!-- Metode Pembayaran dipindahkan ke bawah Waktu Pembayaran -->
                                <div id="metodePembayaranContainer">
                                    <label for="metode_pembayaran"
                                        class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran"
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="Non Tunai">Non Tunai</option>
                                        <option value="Tunai">Tunai</option>
                                    </select>
                                </div>

                                <!-- DP Section (akan muncul jika Bayar Nanti dipilih) -->
                                <div id="dpSection" class="dp-section hidden">
                                    <h4 class="font-medium text-gray-700 mb-2">Pembayaran DP (Uang Muka)</h4>
                                    <input type="number" id="dp_input" name="dp_dibayar" class="dp-input"
                                        placeholder="Masukkan jumlah DP" min="0">
                                    <div id="remainingAmountDisplay" class="remaining-amount">Sisa yang harus dibayar:
                                        Rp 0</div>
                                </div>

                                <!-- Tunai Section (akan muncul jika metode pembayaran Tunai dipilih) -->
                                <div id="tunaiSection" class="tunai-section hidden">
                                    <h4 class="font-medium text-gray-700 mb-2">Pembayaran Tunai</h4>
                                    <input type="number" id="uang_diberikan" name="uang_diberikan_input"
                                        class="uang-diberikan-input" placeholder="Masukkan uang yang diberikan"
                                        min="0">
                                    <div id="kembalianDisplay" class="kembalian-amount">Kembalian: Rp 0</div>
                                    <div id="paymentError" class="payment-error hidden">Uang yang diberikan kurang!
                                    </div>
                                </div>

                                <div>
                                    <label for="metode_pengambilan"
                                        class="block text-sm font-medium text-gray-700 mb-2">Metode Pengambilan</label>
                                    <select name="metode_pengambilan" id="metode_pengambilan"
                                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                        <option value="Ambil Sendiri">Ambil Sendiri</option>
                                        <option value="Diantar">Diantar</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Payment Summary -->
                            <div id="paymentSummary" class="payment-summary hidden">
                                <h4 class="font-bold text-gray-800 mb-2">Rincian Pembayaran</h4>
                                <div class="flex justify-between mb-1">
                                    <span>Total Harga:</span>
                                    <span id="summaryTotal">Rp 0</span>
                                </div>
                                <div class="flex justify-between mb-1">
                                    <span>DP Dibayar:</span>
                                    <span id="summaryDP">Rp 0</span>
                                </div>
                                <div class="flex justify-between font-bold text-green-700">
                                    <span>Sisa Harus Dibayar:</span>
                                    <span id="summaryRemaining">Rp 0</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitOrderBtn"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition flex items-center justify-center mt-4">
                                <i class="fas fa-save mr-2"></i> Simpan Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Modal -->
    <div id="customerModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
        <div
            class="bg-white/95 rounded-xl shadow-xl w-full max-w-md max-h-[90vh] flex flex-col border border-gray-200">
            <div class="border-b px-6 py-4 flex justify-between items-center bg-white rounded-t-xl">
                <h2 class="text-xl font-semibold text-gray-800">Pilih Pelanggan</h2>
                <button id="closeCustomerModal" type="button" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-4 flex-1 flex flex-col bg-white/95">
                <div class="relative mb-4">
                    <input type="text" id="customerSearch" placeholder="Cari pelanggan..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <div class="flex-1 overflow-y-auto modal-content bg-white/95 rounded-b-xl">
                    <div class="customer-list space-y-2">
                        @foreach ($pelanggans as $pelanggan)
                            <div
                                class="customer-item border rounded-lg p-4 hover:bg-gray-50 transition cursor-pointer bg-white">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $pelanggan->nama }}</p>
                                        <p class="text-sm text-gray-600">{{ $pelanggan->no_handphone }}</p>
                                    </div>
                                    <button type="button"
                                        class="select-customer-btn px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm hover:bg-blue-200 transition"
                                        data-id="{{ $pelanggan->id }}" data-name="{{ $pelanggan->nama }}"
                                        data-phone="{{ $pelanggan->no_handphone }}">
                                        Pilih
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // User Dropdown Logic
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const logoutButton = document.getElementById('logout-button');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function(e) {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });

        // Logout Confirmation
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

        document.addEventListener('DOMContentLoaded', function() {
            // Data Layanan yang dipilih
            let selectedServices = {};
            let totalHarga = 0;

            // DOM Elements
            const customerModal = document.getElementById('customerModal');
            const openCustomerModalBtn = document.getElementById('openCustomerModal');
            const closeCustomerModalBtn = document.getElementById('closeCustomerModal');
            const customerSearch = document.getElementById('customerSearch');
            const selectedCustomerDisplay = document.getElementById('selectedCustomerDisplay');
            const customerNameDisplay = document.getElementById('customerName');
            const customerPhoneDisplay = document.getElementById('customerPhone');
            const clearCustomerBtn = document.getElementById('clearCustomer');
            const customerIdInput = document.getElementById('tambah_pelanggan_id');
            const orderForm = document.getElementById('orderForm');
            const submitOrderBtn = document.getElementById('submitOrderBtn');
            const selectedServicesList = document.getElementById('selectedServicesList');
            const totalPriceDisplay = document.getElementById('totalPriceDisplay');
            const serviceSearchInput = document.getElementById('serviceSearch');
            const servicesContainer = document.querySelector('.service-list');
            const waktuPembayaranSelect = document.getElementById('waktu_pembayaran');
            const metodePembayaranSelect = document.getElementById('metode_pembayaran');
            const dpSection = document.getElementById('dpSection');
            const tunaiSection = document.getElementById('tunaiSection');
            const dpInput = document.getElementById('dp_input');
            const uangDiberikanInput = document.getElementById('uang_diberikan');
            const remainingAmountDisplay = document.getElementById('remainingAmountDisplay');
            const kembalianDisplay = document.getElementById('kembalianDisplay');
            const paymentError = document.getElementById('paymentError');
            const paymentSummary = document.getElementById('paymentSummary');
            const summaryTotal = document.getElementById('summaryTotal');
            const summaryDP = document.getElementById('summaryDP');
            const summaryRemaining = document.getElementById('summaryRemaining');
            const paketFilter = document.getElementById('paketFilter');
            const metodePembayaranContainer = document.getElementById('metodePembayaranContainer');

            let activeCategory = 'Satuan'; // Default kategori
            let activePaket = 'Semua'; // Default paket

            function filterServices() {
                const searchTerm = serviceSearchInput.value.toLowerCase();
                document.querySelectorAll('.service-card').forEach(card => {
                    const cardCategory = card.dataset.kategori;
                    const cardPaket = card.dataset.paket;
                    const cardNama = card.dataset.nama.toLowerCase();

                    // Filter logic: kategori, paket, dan search
                    const matchCategory = (activeCategory === 'Semua' || cardCategory === activeCategory);
                    const matchPaket = (activePaket === 'Semua' || cardPaket === activePaket);
                    const matchSearch = (cardNama.includes(searchTerm));

                    if (matchCategory && matchPaket && matchSearch) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            // Customer Modal Functions
            const openCustomerModal = () => {
                customerModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            };

            const closeCustomerModal = () => {
                customerModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            };

            const clearCustomerSelection = (e) => {
                if (e) e.stopPropagation();
                selectedCustomerDisplay.classList.add('hidden');
                document.querySelectorAll('.customer-item').forEach(item => {
                    item.classList.remove('selected-customer');
                });
                customerIdInput.value = '';
            };

            // Event Listeners for Customer Modal
            openCustomerModalBtn.addEventListener('click', openCustomerModal);
            closeCustomerModalBtn.addEventListener('click', closeCustomerModal);
            clearCustomerBtn?.addEventListener('click', clearCustomerSelection);

            // Customer Search Functionality
            customerSearch.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const customerItems = document.querySelectorAll('.customer-item');

                customerItems.forEach(item => {
                    const name = item.querySelector('p.font-medium').textContent.toLowerCase();
                    const phone = item.querySelector('p.text-sm').textContent.toLowerCase();

                    if (name.includes(searchTerm) || phone.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Select Customer Functionality
            document.querySelectorAll('.select-customer-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const phone = this.getAttribute('data-phone');

                    customerNameDisplay.textContent = name;
                    customerPhoneDisplay.textContent = phone;
                    selectedCustomerDisplay.classList.remove('hidden');
                    customerIdInput.value = id;

                    document.querySelectorAll('.customer-item').forEach(item => {
                        item.classList.remove('selected-customer');
                    });
                    this.closest('.customer-item').classList.add('selected-customer');

                    closeCustomerModal();
                });
            });

            // Close modal on ESC key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !customerModal.classList.contains('hidden')) {
                    closeCustomerModal();
                }
            });

            // Update Order Summary Function
            const updateSummary = () => {
                totalHarga = 0;
                selectedServicesList.innerHTML = '';
                const servicesArray = [];

                for (const id in selectedServices) {
                    const service = selectedServices[id];
                    totalHarga += service.price * service.quantity;
                    servicesArray.push({
                        id: service.id,
                        nama: service.name,
                        harga: service.price,
                        kuantitas: service.quantity
                    });

                    const summaryItem = document.createElement('div');
                    summaryItem.className = 'border rounded-lg p-3 bg-gray-50';
                    summaryItem.innerHTML = `
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-medium text-gray-800">${service.name}</p>
                                <p class="text-xs text-gray-500">${service.category} (${service.unit})</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-800">Rp ${service.price.toLocaleString('id-ID')}</span>
                                <div class="flex items-center border rounded quantity-control" data-id="${id}">
                                    <button type="button" class="px-2 py-1 text-gray-600 hover:bg-gray-100 w-8 minus-btn">-</button>
                                    <span class="px-2 text-center flex-grow">${service.quantity}</span>
                                    <button type="button" class="px-2 py-1 text-gray-600 hover:bg-gray-100 w-8 plus-btn">+</button>
                                </div>
                            </div>
                        </div>
                    `;
                    selectedServicesList.appendChild(summaryItem);
                }

                totalPriceDisplay.textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
                document.getElementById('total_harga_input').value = totalHarga;
                document.getElementById('layanan_input').value = JSON.stringify(servicesArray);

                // Update DP calculation if needed
                updateDPCalculation();

                // Update tunai calculation if needed
                updateTunaiCalculation();
            };

            // Add Service Functionality
            document.querySelectorAll('.add-service-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const serviceCard = this.closest('.service-card');
                    const id = serviceCard.dataset.id;
                    const name = serviceCard.dataset.nama;
                    const price = parseInt(serviceCard.dataset.harga);
                    const category = serviceCard.dataset.kategori;
                    const unit = serviceCard.dataset.paket;

                    if (selectedServices[id]) {
                        selectedServices[id].quantity++;
                    } else {
                        selectedServices[id] = {
                            id,
                            name,
                            price,
                            category,
                            unit,
                            quantity: 1
                        };
                    }
                    updateSummary();
                });
            });

            // Quantity Control Functionality
            selectedServicesList.addEventListener('click', function(e) {
                const target = e.target;
                if (target.classList.contains('minus-btn') || target.classList.contains('plus-btn')) {
                    const quantityControl = target.closest('.quantity-control');
                    const id = quantityControl.dataset.id;

                    if (target.classList.contains('minus-btn')) {
                        if (selectedServices[id].quantity > 1) {
                            selectedServices[id].quantity--;
                        } else {
                            delete selectedServices[id];
                        }
                    } else if (target.classList.contains('plus-btn')) {
                        selectedServices[id].quantity++;
                    }
                    updateSummary();
                }
            });

            // Service Search Functionality
            serviceSearchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.service-card').forEach(card => {
                    const name = card.dataset.nama.toLowerCase();
                    if (name.includes(searchTerm)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });

            // DP Calculation Functions
            const updateDPCalculation = () => {
                const dpAmount = parseFloat(dpInput.value) || 0;
                const remainingAmount = totalHarga - dpAmount;

                // Update display
                remainingAmountDisplay.textContent =
                    `Sisa yang harus dibayar: Rp ${remainingAmount.toLocaleString('id-ID')}`;

                // Update hidden inputs
                document.getElementById('dp_amount_input').value = dpAmount;
                document.getElementById('remaining_amount_input').value = remainingAmount;

                // Update payment summary
                summaryTotal.textContent = `Rp ${totalHarga.toLocaleString('id-ID')}`;
                summaryDP.textContent = `Rp ${dpAmount.toLocaleString('id-ID')}`;
                summaryRemaining.textContent = `Rp ${remainingAmount.toLocaleString('id-ID')}`;
            };

            // Tunai Calculation Functions
            const updateTunaiCalculation = () => {
                const uangDiberikan = parseFloat(uangDiberikanInput.value) || 0;
                const kembalian = uangDiberikan - totalHarga;

                // Update display
                if (kembalian >= 0) {
                    kembalianDisplay.textContent = `Kembalian: Rp ${kembalian.toLocaleString('id-ID')}`;
                    kembalianDisplay.style.color = '#059669'; // Green color
                    paymentError.classList.add('hidden');
                } else {
                    kembalianDisplay.textContent =
                        `Kekurangan: Rp ${Math.abs(kembalian).toLocaleString('id-ID')}`;
                    kembalianDisplay.style.color = '#dc2626'; // Red color
                    paymentError.classList.remove('hidden');
                }

                // Update hidden inputs
                document.getElementById('uang_diberikan_input').value = uangDiberikan;
                document.getElementById('kembalian_input').value = kembalian > 0 ? kembalian : 0;
            };

            // Toggle Metode Pembayaran dan DP Section berdasarkan waktu pembayaran
            const togglePaymentSections = () => {
                if (waktuPembayaranSelect.value === 'Bayar Nanti') {
                    // Sembunyikan metode pembayaran dan tunai section
                    metodePembayaranContainer.classList.add('hidden');
                    tunaiSection.classList.add('hidden');

                    // Tampilkan DP section
                    dpSection.classList.remove('hidden');
                    paymentSummary.classList.remove('hidden');
                    updateDPCalculation();
                } else {
                    // Tampilkan metode pembayaran
                    metodePembayaranContainer.classList.remove('hidden');

                    // Sembunyikan DP section
                    dpSection.classList.add('hidden');
                    paymentSummary.classList.add('hidden');

                    // Reset DP values
                    dpInput.value = '';
                    document.getElementById('dp_amount_input').value = 0;
                    document.getElementById('remaining_amount_input').value = totalHarga;

                    // Tampilkan tunai section jika metode tunai dipilih
                    if (metodePembayaranSelect.value === 'Tunai') {
                        tunaiSection.classList.remove('hidden');
                        updateTunaiCalculation();
                    } else {
                        tunaiSection.classList.add('hidden');
                    }
                }
            };

            // Toggle Tunai Section berdasarkan metode pembayaran (hanya jika Bayar Sekarang)
            const toggleTunaiSection = () => {
                // Hanya proses jika Bayar Sekarang yang dipilih
                if (waktuPembayaranSelect.value === 'Bayar Sekarang') {
                    if (metodePembayaranSelect.value === 'Tunai') {
                        tunaiSection.classList.remove('hidden');
                        updateTunaiCalculation();
                    } else {
                        tunaiSection.classList.add('hidden');
                        // Reset tunai values
                        uangDiberikanInput.value = '';
                        document.getElementById('uang_diberikan_input').value = 0;
                        document.getElementById('kembalian_input').value = 0;
                    }
                }
            };

            // Event Listeners
            waktuPembayaranSelect.addEventListener('change', togglePaymentSections);
            metodePembayaranSelect.addEventListener('change', toggleTunaiSection);

            // Update DP calculation when DP input changes
            dpInput.addEventListener('input', function() {
                let dpValue = parseFloat(this.value) || 0;

                // Ensure DP doesn't exceed total
                if (dpValue > totalHarga) {
                    dpValue = totalHarga;
                    this.value = dpValue;
                }

                updateDPCalculation();
            });

            // Update tunai calculation when uang diberikan input changes
            uangDiberikanInput.addEventListener('input', function() {
                updateTunaiCalculation();
            });

            // Form Submission Handler
            orderForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Validasi pelanggan harus dipilih
                if (!customerIdInput.value) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Harap pilih pelanggan terlebih dahulu!',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validasi minimal satu layanan
                if (Object.keys(selectedServices).length === 0) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Harap pilih minimal satu layanan',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Validasi DP jika Bayar Nanti
                if (waktuPembayaranSelect.value === 'Bayar Nanti') {
                    const dpAmount = parseFloat(dpInput.value) || 0;
                    if (dpAmount <= 0) {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Harap masukkan jumlah DP yang valid',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }

                // Validasi metode pembayaran jika Bayar Sekarang
                if (waktuPembayaranSelect.value === 'Bayar Sekarang') {
                    const metodePembayaran = metodePembayaranSelect.value;
                    if (!metodePembayaran) {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Harap pilih metode pembayaran',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }

                    // Validasi uang diberikan jika metode Tunai
                    if (metodePembayaran === 'Tunai') {
                        const uangDiberikan = parseFloat(uangDiberikanInput.value) || 0;
                        if (uangDiberikan < totalHarga) {
                            Swal.fire({
                                title: 'Peringatan!',
                                text: 'Uang yang diberikan kurang dari total harga',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }
                    }
                }

                // Disable submit button
                submitOrderBtn.disabled = true;
                submitOrderBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';

                try {
                    const formData = new FormData();
                    formData.append('tambah_pelanggan_id', customerIdInput.value);
                    formData.append('layanan', document.getElementById('layanan_input').value);
                    formData.append('total_harga', document.getElementById('total_harga_input').value);
                    formData.append('metode_pembayaran', document.getElementById('metode_pembayaran')
                        .value);
                    formData.append('waktu_pembayaran', document.getElementById('waktu_pembayaran')
                        .value);
                    formData.append('metode_pengambilan', document.getElementById('metode_pengambilan')
                        .value);
                    formData.append('dp_dibayar', document.getElementById('dp_input').value);
                    formData.append('remaining_amount', document.getElementById(
                        'remaining_amount_input').value);
                    formData.append('uang_diberikan', document.getElementById('uang_diberikan_input')
                        .value);
                    formData.append('kembalian', document.getElementById('kembalian_input').value);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]')
                        .content);

                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Order berhasil disimpan',
                            icon: 'success',
                            confirmButtonText: 'OK',
                            timer: 2000,
                            timerProgressBar: true,
                            willClose: () => {
                                window.location.href =
                                    "data_order"; // Redirect to order list
                            }
                        });
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan saat menyimpan order');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Gagal!',
                        text: error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } finally {
                    submitOrderBtn.disabled = false;
                    submitOrderBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Simpan Order';
                }
            });

            // Filter services by category
            document.querySelectorAll('.category-filter').forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.dataset.category;

                    // Update active button style
                    document.querySelectorAll('.category-filter').forEach(btn => {
                        btn.classList.remove('bg-blue-500', 'text-white');
                        btn.classList.add('border-blue-500', 'text-blue-500',
                            'hover:bg-blue-50');
                    });

                    this.classList.remove('border-blue-500', 'text-blue-500', 'hover:bg-blue-50');
                    this.classList.add('bg-blue-500', 'text-white');

                    // Filter services
                    document.querySelectorAll('.service-card').forEach(card => {
                        if (category === 'Semua') {
                            card.style.display = 'block';
                        } else if (card.dataset.kategori === category) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Filter paket
            document.getElementById('paketFilter').addEventListener('change', function() {
                activePaket = this.value;
                filterServices();
            });

            // Filter search
            serviceSearchInput.addEventListener('input', filterServices);

            // Tampilkan kategori "Satuan" saat halaman dibuka
            document.addEventListener('DOMContentLoaded', function() {
                const satuanBtn = document.querySelector('.category-filter[data-category="Satuan"]');
                if (satuanBtn) {
                    satuanBtn.click();
                }
            });

            // Inisialisasi tampilan awal
            togglePaymentSections();
        });
    </script>
</body>

</html>
