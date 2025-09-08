<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Driver | Avachive</title>

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

        /* Animasi untuk modal */
        @keyframes scale-up {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scale-up {
            animation: scale-up 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* Style untuk tab aktif */
        .tab.active {
            background-color: #3b82f6 !important;
            color: white !important;
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
                        class="active flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors">
                        <i class="bi bi-box-seam"></i> Pengiriman
                    </a>
                    <a href="/driver/riwayat"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                        <i class="bi bi-clock-history"></i> Riwayat
                    </a>
                </nav>
        </aside>

        <main class="flex-1 p-4 sm:p-6 overflow-y-auto" id="main-content">
            <div
                class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🚚</span>
                    <div>
                        <h1 class="font-semibold text-slate-800 hidden sm:block">Dashboard Driver Laundry</h1>
                        <p class="text-xs text-slate-500">Cabang Ciomas</p>
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
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>

                            <button id="logoutBtn"
                                class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">
                                Logout
                            </button>

                        </div>
                    </div>
                </div>
            </div>

            <section class="mb-6">
                <h3 class="text-xl font-semibold text-blue-600 mb-4" id="todayBadge">Ringkasan Hari Ini</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div
                        class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 text-blue-100 pointer-events-none">
                            <svg class="w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L8 2.122l3.75 1.339 2.404-.961L8.186 1.113zM14 4.267l-5.5 2.489L3 4.267V11.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V4.267zM7.5 14.762V12h1v2.762a.5.5 0 0 0 .814.39l3.5-2a.5.5 0 0 0 0-.868l-3.5-2a.5.5 0 0 0-.814.39V12h-1v-2.762a.5.5 0 0 0-.814-.39l-3.5 2a.5.5 0 0 0 0 .868l3.5 2A.5.5 0 0 0 7.5 14.762z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-500">Total Pengiriman</h4>
                        <p id="countTotal" class="text-4xl font-bold mt-1 text-slate-800">{{ $countTotal }}</p>
                    </div>
                    <div
                        class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 text-orange-100 pointer-events-none">
                            <svg class="w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8.5 5.5a.5.5 0 0 0-1 0v3.352l-1.558.52a.5.5 0 0 0-.253.918l2 1a.5.5 0 0 0 .498 0l2-1a.5.5 0 0 0-.253-.918l-1.558-.52V5.5z" />
                                <path
                                    d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1H7a.5.5 0 0 1-.5-.5zM8 16a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm0-1a5 5 0 1 0 0-10 5 5 0 0 0 0 10z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-500">Belum Diantar</h4>
                        <p id="countBelum" class="text-4xl font-bold mt-1 text-slate-800">{{ $countBelum }}</p>
                    </div>
                    <div
                        class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 text-green-100 pointer-events-none">
                            <svg class="w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z" />
                                <path
                                    d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-500">Sudah Diantar</h4>
                        <p id="countSudah" class="text-4xl font-bold mt-1 text-slate-800">{{ $countSudah }}</p>
                    </div>
                    <div
                        class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 text-slate-100 pointer-events-none">
                            <svg class="w-24 h-24" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M8 1.114v2.758c0 .566-.464 1.03-1.03 1.03H4.142c-.566 0-1.03-.464-1.03-1.03V1.114H8zm-1.03 1.03a.25.25 0 0 1 .499 0l.206 1.03a.25.25 0 0 1-.199.287l-1.03.206a.25.25 0 0 1-.287-.199l-1.03-.206a.25.25 0 0 1 .199-.287l1.03-.206zM13.858 4.142c.566 0 1.03.464 1.03 1.03v5.656c0 .566-.464 1.03-1.03-1.03H2.142c-.566 0-1.03-.464-1.03-1.03V5.172c0-.566.464-1.03 1.03-1.03h2.758v2.758c0 .566.464 1.03 1.03 1.03h2.144c.566 0 1.03-.464 1.03-1.03V4.142h2.758z" />
                            </svg>
                        </div>
                        <h4 class="font-medium text-slate-500">Presentase Selesai</h4>
                        <p id="countPercent" class="text-4xl font-bold mt-1 text-slate-700">{{ $countPercent }}%</p>
                    </div>
                </div>
            </section>

            <section class="bg-white rounded-2xl shadow-lg p-5">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-5">
                    <div id="statusTabs" class="flex flex-wrap items-center gap-2">
                        <button id="filterSemua"
                            class="tab active flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full bg-blue-600 text-white transition-colors"
                            data-status="ALL"><i class="bi bi-ui-checks-grid"></i> Semua</button>
                        <button id="filterBelum"
                            class="tab flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors"
                            data-status="belum diantar"><i class="bi bi-hourglass-split"></i> Belum</button>
                        <button id="filterSudah"
                            class="tab flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 transition-colors"
                            data-status="selesai"><i class="bi bi-check2-circle"></i> Sudah</button>
                    </div>
                    <div class="flex w-full md:w-auto items-center gap-2">
                        <input type="text" id="searchInput" placeholder="Cari nama, alamat, pembayaran..."
                            class="w-full md:w-64 px-4 py-2 text-sm border border-slate-300 rounded-full focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition" />
                        <button id="resetBtn"
                            class="px-3 py-2 bg-slate-200 text-slate-700 rounded-full hover:bg-slate-300 transition-transform active:scale-95"><i
                                class="bi bi-arrow-counterclockwise"></i></button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="shipTable" class="w-full text-sm">
                        <thead class="hidden md:table-header-group">
                            <tr class="bg-slate-200">
                                <th class="p-3 text-left font-semibold text-slate-600 rounded-l-lg">No.</th>
                                <th class="p-3 text-left font-semibold text-slate-600">Nama</th>
                                <th class="p-3 text-left font-semibold text-slate-600">Alamat</th>
                                <th class="p-3 text-left font-semibold text-slate-600">Detail Pembayaran</th>
                                <th class="p-3 text-left font-semibold text-slate-600">Tanggal Kirim</th>
                                <th class="p-3 text-left font-semibold text-slate-600">Tanggal Selesai</th>
                                <th class="p-3 text-left font-semibold text-slate-600">Status</th>
                                <th class="p-3 text-left font-semibold text-slate-600 rounded-r-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr id="no-results-row" class="hidden">
                                <td colspan="8" class="text-center text-slate-500 py-10">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-16 h-16 text-slate-400" id="no-results-icon"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="font-semibold text-slate-700" id="no-results-title"></p>
                                        <p class="text-sm" id="no-results-subtitle"></p>
                                    </div>
                                </td>
                            </tr>
                            @forelse($orders as $i => $order)
                                @php
                                    $pelanggan = $order->pelanggan;
                                    $layanan = json_decode($order->layanan, true) ?? [];

                                    if (json_last_error() !== JSON_ERROR_NONE) {
                                        $fixedLayanan = str_replace("'", '"', $order->layanan);
                                        $layanan = json_decode($fixedLayanan, true) ?? [];
                                    }

                                    $layananJson = '';
                                    if (is_array($layanan) && count($layanan) > 0) {
                                        if (isset($layanan[0]) && is_array($layanan[0])) {
                                            $layananJson = collect($layanan)
                                                ->map(function ($item) {
                                                    $harga = $item['harga'] ?? ($item['Harga'] ?? 0);
                                                    $kuantitas = $item['kuantitas'] ?? ($item['Kuantitas'] ?? 0);
                                                    return [
                                                        'nama' => $item['nama'] ?? ($item['Nama'] ?? 'N/A'),
                                                        'harga' => (float) $harga,
                                                        'kuantitas' => (int) $kuantitas,
                                                        'subtotal' => (float) $harga * (int) $kuantitas,
                                                    ];
                                                })
                                                ->toJson();
                                        } else {
                                            $harga = $layanan['harga'] ?? ($layanan['Harga'] ?? 0);
                                            $kuantitas = $layanan['kuantitas'] ?? ($layanan['Kuantitas'] ?? 0);
                                            $layananJson = json_encode([
                                                [
                                                    'nama' => $layanan['nama'] ?? ($layanan['Nama'] ?? 'N/A'),
                                                    'harga' => (float) $harga,
                                                    'kuantitas' => (int) $kuantitas,
                                                    'subtotal' => (float) $harga * (int) $kuantitas,
                                                ],
                                            ]);
                                        }
                                    } else {
                                        $layananJson = '[]';
                                    }

                                    $isLunas =
                                        ($order->sisa_harga ?? 0) == 0 || $order->waktu_pembayaran === 'Bayar Sekarang';
                                    $statusClass =
                                        strtolower($order->status) === 'selesai' ? 'selesai' : 'belum diantar';
                                    $waktuSelesai =
                                        $order->status === 'Selesai'
                                            ? $order->updated_at->toIso8601String()
                                            : 'Belum Selesai';
                                @endphp
                                <tr data-status="{{ $statusClass }}"
                                    class="block mb-4 p-4 bg-white rounded-lg shadow-md md:table-row md:mb-0 md:shadow-none md:p-0 md:border-b md:border-slate-200 md:even:bg-slate-50">
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">No: </span>{{ $i + 1 }}</td>
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">Nama: </span>{{ $pelanggan->nama ?? '-' }}
                                    </td>
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">Alamat:
                                        </span>{{ $pelanggan->detail_alamat ?? '-' }}</td>
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">Pembayaran: </span>
                                        @if ($isLunas)
                                            <span
                                                class="text-xs font-semibold inline-block py-1 px-3 rounded-full text-green-700 bg-green-100">Lunas</span>
                                        @else
                                            <span
                                                class="text-xs font-semibold inline-block py-1 px-3 rounded-full text-red-700 bg-red-100">
                                                Belum Lunas - Rp {{ number_format($order->sisa_harga, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">Tgl Kirim:
                                        </span>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}
                                    </td>
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">Tgl Selesai:
                                        </span>{{ $order->status === 'Selesai' ? \Carbon\Carbon::parse($order->updated_at)->translatedFormat('d F Y') : 'Belum Selesai' }}
                                    </td>
                                    <td class="block py-1 md:table-cell md:p-3"><span
                                            class="font-semibold md:hidden">Status: </span>
                                        @if ($order->status === 'Selesai')
                                            <span
                                                class="badge badge-done text-xs font-semibold inline-block py-1 px-3 rounded-full text-green-700 bg-green-200">Sudah
                                                Diantar</span>
                                        @else
                                            <span
                                                class="badge badge-pending text-xs font-semibold inline-block py-1 px-3 rounded-full text-orange-600 bg-orange-200">Belum
                                                Diantar</span>
                                        @endif
                                    </td>
                                    <td class="block py-2 md:table-cell md:p-3">
                                        <div class="flex flex-wrap gap-2 mt-2 md:mt-0">
                                            <button
                                                class="btn-detail text-sm px-3 py-2 rounded-md bg-blue-600 text-white font-semibold shadow hover:bg-blue-700 transition active:scale-95"
                                                data-nama="{{ $pelanggan->nama ?? '-' }}"
                                                data-hp="{{ $pelanggan->no_handphone ?? '-' }}"
                                                data-alamat="{{ $pelanggan->detail_alamat ?? '-' }}"
                                                data-metode-pengiriman="{{ $order->metode_pengambilan }}"
                                                data-metode-pembayaran="{{ $order->metode_pembayaran }}"
                                                data-status-pembayaran="{{ $isLunas ? 'Lunas' : 'Belum Lunas' }}"
                                                data-nominal-pembayaran="{{ $order->sisa_harga ?? 0 }}"
                                                data-waktu-order="{{ $order->created_at->toIso8601String() }}"
                                                data-waktu-selesai="{{ $waktuSelesai }}"
                                                data-total="Rp {{ number_format($order->total_harga, 0, ',', '.') }}"
                                                data-layanan="{{ $layananJson }}">
                                                <i class="bi bi-eye mr-1"></i> Detail
                                            </button>

                                            @if ($order->status !== 'Selesai')
                                                @if (!$isLunas)
                                                    <button
                                                        class="btn-lunaskan text-sm px-3 py-2 rounded-md bg-amber-500 text-white font-semibold shadow hover:bg-amber-600 transition active:scale-95"
                                                        data-id="{{ $order->id }}">
                                                        <i class="bi bi-cash-coin mr-1"></i> Lunaskan
                                                    </button>
                                                @endif
                                                <button
                                                    class="btn-selesai text-sm px-3 py-2 rounded-md bg-green-600 text-white font-semibold shadow hover:bg-green-700 transition active:scale-95"
                                                    data-id="{{ $order->id }}"
                                                    data-lunas="{{ $isLunas ? 'true' : 'false' }}">
                                                    <i class="bi bi-check-circle mr-1"></i> Selesai
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <footer class="text-center py-6 text-sm text-slate-500">
                © 2025 Avachive Driver. All rights reserved.
            </footer>
        </main>

        <nav
            class="md:hidden fixed bottom-0 left-0 right-0 bg-slate-900 text-slate-300 p-2 flex justify-around shadow-lg">
            <a href="/driver/dashboard"
                class="active flex flex-col items-center justify-center text-teal-400 p-2 rounded-lg w-full">
                <i class="bi bi-box-seam text-xl"></i><span class="text-xs">Pengiriman</span>
            </a>
            <a href="/driver/riwayat"
                class="flex flex-col items-center justify-center hover:text-white p-2 rounded-lg w-full">
                <i class="bi bi-clock-history text-xl"></i><span class="text-xs">Riwayat</span>
            </a>
        </nav>
    </div>

    <div class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 justify-center items-center p-4"
        id="detailModal">
        <div class="modal-content bg-white p-6 rounded-2xl shadow-xl w-full max-w-lg relative animate-scale-up">
            <button class="modal-close absolute top-3 right-4 text-2xl text-slate-500 hover:text-slate-800"
                id="modalCloseBtn">×</button>
            <h4 class="text-xl font-bold text-blue-600 mb-4">Detail Pengiriman</h4>
            <div id="modalBody" class="space-y-3 text-sm max-h-[60vh] overflow-y-auto pr-2"></div>
            <div class="mt-6 flex flex-wrap gap-3 border-t pt-4">
                <a href="#" id="whatsappLink"
                    class="flex items-center justify-center gap-2 px-5 py-3 rounded-full bg-green-500 text-white font-semibold shadow hover:bg-green-600 transition active:scale-95"
                    target="_blank">
                    <i class="bi bi-whatsapp"></i> Hubungi
                </a>
                <a href="#" id="mapLink"
                    class="flex items-center justify-center gap-2 px-5 py-3 rounded-full bg-slate-700 text-white font-semibold shadow hover:bg-slate-800 transition active:scale-95"
                    target="_blank">
                    <i class="bi bi-geo-alt-fill"></i> Lihat di Maps
                </a>
            </div>
        </div>
    </div>

    <button
        class="fab hidden fixed right-6 bottom-20 md:bottom-6 z-20 w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg grid place-items-center text-2xl hover:bg-blue-700 transition active:scale-95"
        id="scrollTopBtn" title="Kembali ke atas">
        <i class="bi bi-arrow-up"></i>
    </button>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ====== PROFILE DROPDOWN & LOGOUT LOGIC ======
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');
            const logoutBtn = document.getElementById('logoutBtn');

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

            // ====== FILTER FUNCTIONALITY ======
            const filterButtons = document.querySelectorAll('.tab');
            const tableRows = document.querySelectorAll('#tbody tr[data-status]');
            const searchInput = document.getElementById('searchInput');
            const resetBtn = document.getElementById('resetBtn');

            function filterTable(status) {
                let visibleRowCount = 0;
                const noResultsRow = document.getElementById('no-results-row');
                const noResultsTitle = document.getElementById('no-results-title');
                const noResultsSubtitle = document.getElementById('no-results-subtitle');

                const messages = {
                    'ALL': {
                        title: 'Tidak Ada Pengiriman',
                        subtitle: 'Belum ada data pengiriman untuk ditampilkan hari ini.'
                    },
                    'belum diantar': {
                        title: 'Semua Pengiriman Selesai!',
                        subtitle: 'Tidak ada lagi order yang perlu diantar hari ini.'
                    },
                    'selesai': {
                        title: 'Belum Ada Pengiriman Selesai',
                        subtitle: 'Selesaikan pengiriman agar datanya muncul di sini.'
                    }
                };

                tableRows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    const rowText = row.textContent.toLowerCase();
                    const searchTerm = searchInput.value.toLowerCase();
                    const statusMatch = status === 'ALL' || rowStatus === status;
                    const searchMatch = rowText.includes(searchTerm);
                    const isVisible = statusMatch && searchMatch;

                    row.style.display = isVisible ? '' : 'none';

                    if (isVisible) {
                        visibleRowCount++;
                    }
                });

                if (visibleRowCount === 0) {
                    const currentMessage = messages[status] || messages['ALL'];
                    noResultsTitle.textContent = currentMessage.title;
                    noResultsSubtitle.textContent = currentMessage.subtitle;

                    noResultsRow.classList.remove('hidden');
                    noResultsRow.style.display = '';
                } else {
                    noResultsRow.classList.add('hidden');
                    noResultsRow.style.display = 'none';
                }

                filterButtons.forEach(btn => {
                    if (btn.getAttribute('data-status') === status) {
                        btn.classList.add('active', 'bg-blue-600', 'text-white');
                        btn.classList.remove('bg-slate-100', 'text-slate-600');
                    } else {
                        btn.classList.remove('active', 'bg-blue-600', 'text-white');
                        btn.classList.add('bg-slate-100', 'text-slate-600');
                    }
                });
            }

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');
                    filterTable(status);
                });
            });

            searchInput.addEventListener('input', function() {
                const activeFilter = document.querySelector('.tab.active').getAttribute('data-status');
                filterTable(activeFilter);
            });

            resetBtn.addEventListener('click', function() {
                searchInput.value = '';
                filterTable('ALL');
            });

            filterTable('ALL');

            // ====== MODAL DETAIL LOGIC ======
            const modal = document.getElementById('detailModal');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalBody = document.getElementById('modalBody');

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
            window.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            document.querySelectorAll('.btn-detail').forEach(button => {
                button.addEventListener('click', function() {
                    const data = this.dataset;

                    function formatRp(number) {
                        const num = parseInt(number, 10);
                        if (isNaN(num)) return 'Rp 0';
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(num);
                    }

                    let layananHTML = '';
                    try {
                        const layananItems = JSON.parse(data.layanan);

                        if (layananItems && layananItems.length > 0) {
                            layananItems.forEach(item => {
                                layananHTML += `
                                <div class="border-t pt-2 mt-2 first:mt-0 first:pt-0 first:border-t-0">
                                    <p class="font-semibold text-slate-800">${item.nama || 'N/A'}</p>
                                    <div class="text-slate-600 pl-2 grid grid-cols-[auto_1fr] gap-x-2 text-xs">
                                        <span>Harga</span>   <span>: ${formatRp(item.harga || 0)}</span>
                                        <span>Jumlah</span>  <span>: ${item.kuantitas || 0}</span>
                                        <span>Subtotal</span><span>: ${formatRp(item.subtotal || (item.harga * item.kuantitas) || 0)}</span>
                                    </div>
                                </div>`;
                            });
                        } else {
                            layananHTML = '<p class="text-slate-500">Tidak ada detail layanan.</p>';
                        }
                    } catch (e) {
                        console.error("Gagal memproses data layanan:", e, data.layanan);
                        layananHTML = '<p class="text-red-500">Gagal memuat detail layanan.</p>';
                    }

                    let pembayaranHTML = '';
                    if (data.statusPembayaran === 'Lunas') {
                        pembayaranHTML =
                            `<span class="font-semibold text-green-600">Lunas (${data.metodePembayaran || 'N/A'})</span>`;
                    } else {
                        pembayaranHTML =
                            `<span class="font-semibold text-red-600">Belum Lunas (${formatRp(data.nominalPembayaran)})</span>`;
                    }

                    const dateTimeOptions = {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false,
                        timeZone: 'Asia/Jakarta'
                    };
                    const waktuOrderFormatted = new Date(data.waktuOrder).toLocaleString('id-ID',
                        dateTimeOptions);
                    const waktuSelesaiFormatted = data.waktuSelesai !== 'Belum Selesai' ?
                        new Date(data.waktuSelesai).toLocaleString('id-ID', dateTimeOptions) :
                        'Belum Selesai';

                    modalBody.innerHTML = `
                        <div class="space-y-1 text-slate-700">
                            <div class="flex"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">Nama</strong>: ${data.nama}</div>
                            <div class="flex"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">No Hp</strong>: ${data.hp}</div>
                            <div class="flex"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">Alamat</strong>: ${data.alamat}</div>
                            <div class="flex"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">Pengambilan</strong>: ${data.metodePengiriman}</div>
                            <div class="flex items-center"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">Pembayaran</strong>: ${pembayaranHTML}</div>
                            <div class="flex"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">Waktu Order</strong>: ${waktuOrderFormatted}</div>
                            <div class="flex"><strong class="font-semibold text-slate-900 w-32 flex-shrink-0">Waktu Selesai</strong>: ${waktuSelesaiFormatted}</div>
                        </div>
                        <div class="border-t my-3"></div>
                        <div>
                            <h4 class="font-bold text-slate-900 mb-1">Detail Layanan:</h4>
                            ${layananHTML}
                        </div>
                        <div class="border-t my-3"></div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-slate-900">Total: ${data.total}</p>
                        </div>`;

                    const waMessage =
                        `Halo ${data.nama}, kurir kami sedang dalam perjalanan untuk mengantar pesanan laundry Anda. Mohon siapkan pembayaran jika ada sisa tagihan. Terima kasih! - Avachive Driver`;
                    const cleanPhoneNumber = data.hp.startsWith('0') ? '62' + data.hp.substring(1) :
                        data.hp.replace(/[^0-9]/g, '');
                    document.getElementById('whatsappLink').href =
                        `https://wa.me/${cleanPhoneNumber}?text=${encodeURIComponent(waMessage)}`;
                    document.getElementById('mapLink').href =
                        `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.alamat)}`;

                    openModal();
                });
            });

            // ====== LOGIKA TOMBOL SELESAI (UPDATED) ======
            document.querySelectorAll('.btn-selesai').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.dataset.id;
                    const isLunas = this.dataset.lunas === 'true';
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    if (!isLunas) {
                        Swal.fire({
                            title: 'Pembayaran Belum Lunas!',
                            text: 'Anda tidak dapat menyelesaikan pesanan ini sebelum pembayarannya lunas.',
                            icon: 'warning',
                            confirmButtonColor: '#f59e0b',
                            confirmButtonText: 'Mengerti'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Selesaikan Pengiriman?',
                        text: "Pastikan Anda sudah berada di lokasi dan menyelesaikan transaksi.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Selesaikan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/driver/pengiriman/${orderId}/update-status`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Status pengiriman telah diperbarui.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Gagal!', data.message ||
                                            'Gagal memperbarui status. Coba lagi.',
                                            'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!',
                                        'Terjadi kesalahan koneksi. Silakan hubungi admin.',
                                        'error');
                                });
                        }
                    });
                });
            });

            // ====== LOGIKA TOMBOL LUNASKAN ======
            document.querySelectorAll('.btn-lunaskan').forEach(button => {
                button.addEventListener('click', function() {
                    const orderId = this.dataset.id;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    Swal.fire({
                        title: 'Lunaskan Pembayaran?',
                        text: "Pastikan Anda sudah menerima pembayaran tunai dari pelanggan.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#f59e0b',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lunaskan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/driver/pengiriman/${orderId}/lunaskan`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Status pembayaran telah diperbarui.',
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload();
                                        });
                                    } else {
                                        Swal.fire('Gagal!', data.message ||
                                            'Gagal memperbarui status pembayaran.',
                                            'error');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!', 'Terjadi kesalahan koneksi.',
                                        'error');
                                });
                        }
                    });
                });
            });

        });
    </script>

</body>

</html>