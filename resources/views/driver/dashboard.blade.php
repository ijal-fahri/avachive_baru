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
        body {
            font-family: 'Poppins', sans-serif;
        }
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
        .tab.active {
            background-color: #3b82f6 !important;
            color: white !important;
        }
    </style>

</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    <div class="flex min-h-screen bg-slate-100">

        @include('driver.partials.sidebar')

        <div class="flex flex-1 flex-col md:ml-64">
            <main class="flex-1 p-4 sm:p-6 pb-24 md:pb-6" id="main-content">
                <div
                    class="sticky top-0 z-10 mb-6 flex items-center justify-between rounded-xl border border-slate-200/60 bg-white/80 p-4 shadow-lg backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">🚚</span>
                        <div>
                            <h1 class="hidden font-semibold text-slate-800 sm:block">Dashboard Driver Laundry</h1>
                            <p class="text-xs text-slate-500">Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Tidak diketahui' }}</p>
                        </div>
                    </div>
                    <div class="relative">
                        <button id="profileDropdownBtn"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-200 text-slate-600 transition-all hover:ring-2 hover:ring-blue-400">
                            @if (Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto Profil"
                                    class="h-10 w-10 rounded-full border-2 border-blue-400 object-cover shadow">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff&size=64&bold=true"
                                    alt="Avatar" class="h-10 w-10 rounded-full border-2 border-blue-400 shadow">
                            @endif
                        </button>
                        <div id="profileDropdownMenu"
                            class="absolute right-0 z-20 mt-2 hidden w-48 rounded-lg border border-slate-200 bg-white shadow-xl">
                            <div class="p-2">
                                <a href="/driver/pengaturan"
                                    class="block w-full rounded-md px-4 py-2 text-left text-sm text-slate-700 hover:bg-slate-100">Lihat
                                    Profile</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                <button id="logoutBtn"
                                    class="block w-full rounded-md px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="mb-6">
                    <h3 class="mb-4 text-xl font-semibold text-blue-600" id="todayBadge">Ringkasan Hari Ini</h3>
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-lg transition hover:-translate-y-1">
                            <div class="pointer-events-none absolute -bottom-3 -right-3 z-0 text-blue-100">
                               <i class="bi bi-box-seam text-7xl"></i>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-medium text-slate-500">Total Pengiriman</h4>
                                <p id="countTotal" class="mt-1 text-4xl font-bold text-slate-800">{{ $countTotal }}</p>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-lg transition hover:-translate-y-1">
                            <div class="pointer-events-none absolute -bottom-3 -right-3 z-0 text-orange-100">
                                <i class="bi bi-hourglass-split text-7xl"></i>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-medium text-slate-500">Belum Diantar</h4>
                                <p id="countBelum" class="mt-1 text-4xl font-bold text-slate-800">{{ $countBelum }}</p>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-lg transition hover:-translate-y-1">
                            <div class="pointer-events-none absolute -bottom-3 -right-3 z-0 text-green-100">
                               <i class="bi bi-check2-circle text-7xl"></i>
                            </div>
                            <div class="relative z-10">
                               <h4 class="font-medium text-slate-500">Sudah Diantar</h4>
                               <p id="countSudah" class="mt-1 text-4xl font-bold text-slate-800">{{ $countSudah }}</p>
                            </div>
                        </div>
                        <div class="relative overflow-hidden rounded-xl bg-white p-5 shadow-lg transition hover:-translate-y-1">
                            <div class="pointer-events-none absolute -bottom-3 -right-3 z-0 text-slate-100">
                                <i class="bi bi-percent text-7xl"></i>
                            </div>
                            <div class="relative z-10">
                                <h4 class="font-medium text-slate-500">Presentase Selesai</h4>
                                <p id="countPercent" class="mt-1 text-4xl font-bold text-slate-700">{{ $countPercent }}%</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl bg-white p-5 shadow-lg">
                    <div class="mb-5 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                        <div id="statusTabs" class="flex flex-wrap items-center gap-2">
                            <button id="filterSemua"
                                class="tab active flex items-center gap-2 rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition-colors"
                                data-status="ALL"><i class="bi bi-ui-checks-grid"></i> Semua</button>
                            <button id="filterBelum"
                                class="tab flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-200"
                                data-status="belum diantar"><i class="bi bi-hourglass-split"></i> Belum</button>
                            <button id="filterSudah"
                                class="tab flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-600 transition-colors hover:bg-slate-200"
                                data-status="selesai"><i class="bi bi-check2-circle"></i> Sudah</button>
                        </div>
                        <div class="flex w-full items-center gap-2 md:w-auto">
                            <input type="text" id="searchInput" placeholder="Cari nama, alamat, pembayaran..."
                                class="w-full rounded-full border border-slate-300 px-4 py-2 text-sm outline-none transition focus:border-blue-400 focus:ring-2 focus:ring-blue-400 md:w-64" />
                            <button id="resetBtn"
                                class="rounded-full bg-slate-200 px-3 py-2 text-slate-700 transition-transform active:scale-95 hover:bg-slate-300"><i
                                    class="bi bi-arrow-counterclockwise"></i></button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="shipTable" class="w-full text-sm">
                            <thead class="hidden md:table-header-group">
                                <tr class="bg-slate-200">
                                    <th class="rounded-l-lg p-3 text-left font-semibold text-slate-600">No.</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Nama</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Alamat</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Detail Pembayaran</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Tanggal Kirim</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Tanggal Selesai</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Status</th>
                                    <th class="rounded-r-lg p-3 text-left font-semibold text-slate-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">
                                <tr id="no-results-row" class="hidden">
                                    <td colspan="8" class="py-10 text-center text-slate-500">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="h-16 w-16 text-slate-400" id="no-results-icon"
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
                                        class="mb-4 block rounded-lg bg-white p-4 shadow-md md:table-row md:mb-0 md:border-b md:border-slate-200 md:p-0 md:shadow-none md:even:bg-slate-50">
                                        <td class="block py-1 md:table-cell md:p-3"><span
                                                class="font-semibold md:hidden">No: </span>{{ $i + 1 }}</td>
                                        <td class="block py-1 md:table-cell md:p-3"><span
                                                class="font-semibold md:hidden">Nama: </span>
                                            {{-- [PERUBAHAN] Logika badge "BARU" ditambahkan di sini --}}
                                            <div class="flex items-center">
                                                <span>{{ $pelanggan->nama ?? '-' }}</span>
                                                @if (isset($order->is_new) && $order->is_new)
                                                    <span class="ml-2 px-2 py-0.5 text-xs font-bold text-white bg-teal-500 rounded-full animate-pulse">BARU</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="block py-1 md:table-cell md:p-3"><span
                                                class="font-semibold md:hidden">Alamat:
                                            </span>{{ $pelanggan->detail_alamat ?? '-' }}</td>
                                        <td class="block py-1 md:table-cell md:p-3"><span
                                                class="font-semibold md:hidden">Pembayaran: </span>
                                            @if ($isLunas)
                                                <span
                                                    class="inline-block rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Lunas</span>
                                            @else
                                                <span
                                                    class="inline-block rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
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
                                                    class="badge badge-done inline-block rounded-full bg-green-200 px-3 py-1 text-xs font-semibold text-green-700">Sudah
                                                    Diantar</span>
                                            @else
                                                <span
                                                    class="badge badge-pending inline-block rounded-full bg-orange-200 px-3 py-1 text-xs font-semibold text-orange-600">Belum
                                                    Diantar</span>
                                            @endif
                                        </td>
                                        <td class="block py-2 md:table-cell md:p-3">
                                            <div class="mt-2 flex flex-wrap gap-2 md:mt-0">
                                                <button
                                                    class="btn-detail rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow transition active:scale-95 hover:bg-blue-700"
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
                                                            class="btn-lunaskan rounded-md bg-amber-500 px-3 py-2 text-sm font-semibold text-white shadow transition active:scale-95 hover:bg-amber-600"
                                                            data-id="{{ $order->id }}">
                                                            <i class="bi bi-cash-coin mr-1"></i> Lunaskan
                                                        </button>
                                                    @endif
                                                    <button
                                                        class="btn-selesai rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow transition active:scale-95 hover:bg-green-700"
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
            </main>
            
            <footer class="py-6 text-center text-sm text-slate-500">
                © 2025 Avachive Driver. All rights reserved.
            </footer>
        </div>

    </div>

    <div class="modal fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4 backdrop-blur-sm"
        id="detailModal">
        <div class="modal-content relative w-full max-w-lg animate-scale-up rounded-2xl bg-white p-6 shadow-xl">
            <button class="modal-close absolute top-3 right-4 text-2xl text-slate-500 hover:text-slate-800"
                id="modalCloseBtn">×</button>
            <h4 class="mb-4 text-xl font-bold text-blue-600">Detail Pengiriman</h4>
            <div id="modalBody" class="max-h-[60vh] space-y-3 overflow-y-auto pr-2 text-sm"></div>
            <div class="mt-6 flex flex-wrap gap-3 border-t pt-4">
                <a href="#" id="whatsappLink"
                    class="flex flex-grow items-center justify-center gap-2 rounded-full bg-green-500 px-5 py-3 font-semibold text-white shadow transition active:scale-95 hover:bg-green-600"
                    target="_blank">
                    <i class="bi bi-whatsapp"></i> Hubungi
                </a>
                <a href="#" id="mapLink"
                    class="flex flex-grow items-center justify-center gap-2 rounded-full bg-slate-700 px-5 py-3 font-semibold text-white shadow transition active:scale-95 hover:bg-slate-800"
                    target="_blank">
                    <i class="bi bi-geo-alt-fill"></i> Lihat di Maps
                </a>
            </div>
        </div>
    </div>

    <button
        class="fab fixed right-6 bottom-20 z-20 hidden h-14 w-14 grid-cols-1 place-items-center rounded-full bg-blue-600 text-2xl text-white shadow-lg transition active:scale-95 hover:bg-blue-700 md:bottom-6"
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

            if(searchInput) {
                searchInput.addEventListener('input', function() {
                    const activeFilter = document.querySelector('.tab.active').getAttribute('data-status');
                    filterTable(activeFilter);
                });
            }
            
            if(resetBtn) {
                resetBtn.addEventListener('click', function() {
                    searchInput.value = '';
                    filterTable('ALL');
                });
            }

            if(filterButtons.length > 0) {
                filterTable('ALL');
            }

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
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
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
