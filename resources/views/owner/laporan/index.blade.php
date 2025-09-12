<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan | Avachive</title>

    {{-- Aset-aset (CSS & JS Libraries) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <style>
      body { font-family: 'Poppins', sans-serif; }
      .sidebar-mobile-open { transform: translateX(0) !important; }
      @media (max-width: 767px) {
        .responsive-table thead { display: none; }
        .responsive-table tbody, .responsive-table tr { display: block; width: 100%; }
        .responsive-table tr { margin-bottom: 1rem; border-radius: 0.75rem; background-color: #ffffff; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); overflow: hidden; padding: 0; }
        .responsive-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; text-align: right; border-bottom: 1px solid #f1f5f9; }
        .responsive-table tr:last-child { margin-bottom: 0; }
        .responsive-table td:last-child { border-bottom: none; justify-content: center; padding-top: 1rem; }
        .responsive-table td::before { content: attr(data-label); font-weight: 600; text-align: left; color: #475569; margin-right: 1rem; }
        .responsive-table td:first-child { background-color: #f8fafc; padding: 0.75rem 1rem; font-size: 1rem; }
        .responsive-table td[data-label="Aksi"]::before { display: none; }
      }
    </style>
</head>
<body class="bg-slate-100">
    <div class="flex">
        {{-- ===== SIDEBAR ===== --}}
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
                    <a href="{{ route('owner.laporan.index') }}" class="flex items-center py-3 px-4 rounded-lg bg-teal-400 text-slate-900 font-semibold shadow-lg"><i class="bi bi-graph-up-arrow mr-4 text-lg"></i><span class="font-medium">Laporan</span></a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            {{-- ===== HEADER ===== --}}
            <header class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
                 <div class="flex items-center gap-4">
                  <button id="menu-btn" class="text-slate-800 text-2xl md:hidden"><i class="bi bi-list"></i></button>
                  <h1 class="text-xl font-semibold text-slate-800">Laporan Keuangan & Cabang</h1>
                </div>
                <div class="relative">
                    <button id="profileDropdownBtn" class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all">
                        {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                    </button>
                    <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-10 border">
                        <div class="p-2">
                            <a href="{{ route('owner.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat Profile</a>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" id="logoutBtn" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <main class="px-4 md:px-6 pb-6 mt-8">
                @if (session('success'))
                    <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg shadow-md" role="alert"><p>{{ session('success') }}</p></div>
                @endif
                @if (session('error'))
                    <div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert"><p>{{ session('error') }}</p></div>
                @endif

                {{-- ===== FILTER FORM ===== --}}
                <div class="bg-white p-4 md:p-6 rounded-xl shadow-md mb-6">
                    <form id="filterForm" action="{{ route('owner.laporan.index') }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                            <div class="w-full">
                                <label for="cabangFilter" class="text-sm font-medium text-slate-600">Pilih Cabang</label>
                                <select id="cabangFilter" name="cabang_id" class="mt-1 block w-full border border-slate-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                    <option value="semua">Semua Cabang</option>
                                    @foreach ($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}" {{ $selectedCabang == $cabang->id ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full">
                                <label for="dateFilter" class="text-sm font-medium text-slate-600">Pilih Periode</label>
                                <select id="dateFilter" name="periode" class="mt-1 block w-full border border-slate-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                    <option value="hari_ini" {{ $selectedPeriode == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="7_hari" {{ $selectedPeriode == '7_hari' ? 'selected' : '' }}>7 Hari Terakhir</option>
                                    <option value="bulan_ini" {{ $selectedPeriode == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                                </select>
                            </div>
                            <div class="w-full flex flex-wrap gap-2 items-center justify-start md:justify-end">
                                <button type="button" id="btnTambahCabang" class="px-4 py-2 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow hover:bg-teal-600 transition flex items-center gap-2"><i class="bi bi-plus-circle"></i> Tambah</button>
                                <button type="button" id="btnDetailCabang" class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-700 text-white shadow hover:bg-slate-800 transition flex items-center gap-2 disabled:opacity-50" disabled><i class="bi bi-eye"></i> Detail</button>
                                <button type="button" id="btnEditCabang" class="px-4 py-2 text-sm font-semibold rounded-lg bg-slate-700 text-white shadow hover:bg-slate-800 transition flex items-center gap-2 disabled:opacity-50" disabled><i class="bi bi-pencil-square"></i> Edit</button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ===== KARTU STATISTIK (DINAMIS & STYLED) ===== --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute -right-4 -bottom-4 text-sky-100 pointer-events-none z-0"><i class="bi bi-wallet2 text-8xl"></i></div>
                        <div class="relative z-10"><p class="text-sm text-slate-500">Total Pendapatan</p><p class="text-2xl font-bold text-slate-800 mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute -right-4 -bottom-4 text-indigo-100 pointer-events-none z-0"><i class="bi bi-box-seam text-8xl"></i></div>
                        <div class="relative z-10"><p class="text-sm text-slate-500">Jumlah Transaksi</p><p class="text-2xl font-bold text-slate-800 mt-1">{{ $jumlahTransaksi }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute -right-4 -bottom-4 text-green-100 pointer-events-none z-0"><i class="bi bi-check2-circle text-8xl"></i></div>
                        <div class="relative z-10"><p class="text-sm text-slate-500">Order Selesai</p><p class="text-2xl font-bold text-slate-800 mt-1">{{ $orderSelesai }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute -right-4 -bottom-4 text-cyan-100 pointer-events-none z-0"><i class="bi bi-person-fill-add text-8xl"></i></div>
                        <div class="relative z-10"><p class="text-sm text-slate-500">Pelanggan Baru</p><p class="text-2xl font-bold text-slate-800 mt-1">{{ $pelangganBaru }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute -right-4 -bottom-4 text-lime-100 pointer-events-none z-0"><i class="bi bi-trophy text-8xl"></i></div>
                        <div class="relative z-10"><p class="text-sm text-slate-500">Pemasukan Tertinggi</p><p class="text-2xl font-bold text-green-600 mt-1">{{ $pemasukanTertinggi }}</p></div>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute -right-4 -bottom-4 text-red-100 pointer-events-none z-0"><i class="bi bi-graph-down-arrow text-8xl"></i></div>
                        <div class="relative z-10"><p class="text-sm text-slate-500">Pemasukan Terendah</p><p class="text-2xl font-bold text-red-600 mt-1">{{ $pemasukanTerendah }}</p></div>
                    </div>
                </div>

                {{-- ===== GRAFIK (DINAMIS) ===== --}}
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
                    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-md"><h3 class="font-semibold mb-4 text-slate-700">Tren Pendapatan</h3><div class="h-64"><canvas id="revenueChart"></canvas></div></div>
                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md"><h3 class="font-semibold mb-4 text-slate-700">Layanan Terlaris</h3><div class="h-64"><canvas id="servicesChart"></canvas></div></div>
                </div>
                
                {{-- ===== TABEL TRANSAKSI (DINAMIS) ===== --}}
                <div class="bg-white rounded-xl shadow-md">
                    <div class="p-4 md:p-6 border-b"><h3 class="text-lg font-semibold text-slate-700">Detail Riwayat Transaksi</h3></div>
                    <div class="overflow-x-auto">
                        <table class="responsive-table w-full text-sm text-left">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-100">
                                <tr>
                                    <th class="px-6 py-3">ID Transaksi</th>
                                    <th class="px-6 py-3">Pelanggan</th>
                                    <th class="px-6 py-3">Cabang</th>
                                    <th class="px-6 py-3">Tgl Masuk</th>
                                    <th class="px-6 py-3">Tgl Selesai</th>
                                    <th class="px-6 py-3">Pengambilan</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transaksiTerbaru as $order)
                                <tr class="odd:bg-white even:bg-slate-50 hover:bg-teal-50">
                                    <td data-label="ID Transaksi" class="px-6 py-4 font-medium text-slate-800">TRX-{{ \Carbon\Carbon::parse($order->created_at)->format('Ym') }}-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td data-label="Pelanggan" class="px-6 py-4">{{ $order->pelanggan->nama ?? 'N/A' }}</td>
                                    <td data-label="Cabang" class="px-6 py-4">{{ $order->cabang->nama_cabang ?? 'N/A' }}</td>
                                    <td data-label="Tgl Masuk" class="px-6 py-4">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                    <td data-label="Tgl Selesai" class="px-6 py-4">{{ strtotime($order->waktu_pembayaran) ? \Carbon\Carbon::parse($order->waktu_pembayaran)->format('d M Y') : ($order->status == 'Selesai' ? \Carbon\Carbon::parse($order->updated_at)->format('d M Y') : '-') }}</td>
                                    <td data-label="Pengambilan" class="px-6 py-4">{{ $order->metode_pengambilan ?? 'N/A' }}</td>
                                    <td data-label="Status" class="px-6 py-4">
                                        @php
                                            $statusClass = 'bg-slate-100 text-slate-800';
                                            if ($order->status === 'Selesai') $statusClass = 'bg-green-100 text-green-800';
                                            else if ($order->status === 'Diproses') $statusClass = 'bg-blue-100 text-blue-800';
                                            else if ($order->status === 'Baru') $statusClass = 'bg-yellow-100 text-yellow-800';
                                        @endphp
                                        <span class="{{ $statusClass }} px-3 py-1 rounded-full text-xs font-semibold">{{ $order->status }}</span>
                                    </td>
                                    <td data-label="Aksi" class="px-6 py-4 text-center">
                                        <button class="bg-slate-200 text-slate-800 hover:bg-slate-300 text-xs font-bold py-2 px-3 rounded-lg view-detail-btn" data-transaction='@json($order)'>
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="8" class="text-center p-4 text-slate-500">Tidak ada transaksi pada periode ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden"></div>

    {{-- ===== MODAL DETAIL TRANSAKSI ===== --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-95 opacity-0" id="modalContent">
          <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-lg font-bold text-slate-800">Detail Order #<span id="modalOrderId"></span></h3>
            <button id="closeModalBtn" class="text-slate-500 hover:text-slate-800 text-2xl">&times;</button>
          </div>
          <div id="modalBody" class="space-y-3 text-sm"></div>
        </div>
    </div>

    {{-- ===== MODAL CRUD CABANG ===== --}}
    <div id="modalTambahCabang" class="hidden fixed inset-0 bg-black/50 z-50 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Tambah Cabang Baru</h3>
            <form id="formTambahCabang" action="{{ route('owner.cabang.store') }}" method="POST">
                @csrf
                <div class="mb-4"><label for="addNamaCabang" class="block text-sm font-medium text-slate-600 mb-1">Nama Cabang</label><input type="text" name="nama_cabang" id="addNamaCabang" class="w-full border border-slate-300 rounded-lg p-2" required></div>
                <div class="mb-4"><label for="addAlamatCabang" class="block text-sm font-medium text-slate-600 mb-1">Alamat Cabang</label><input type="text" name="alamat" id="addAlamatCabang" class="w-full border border-slate-300 rounded-lg p-2" required></div>
                <div class="flex justify-end gap-3 mt-6"><button type="button" class="btn-batal px-4 py-2 text-sm rounded-lg bg-slate-200 hover:bg-slate-300">Batal</button><button type="submit" class="px-4 py-2 text-sm rounded-lg bg-teal-500 text-white hover:bg-teal-600">Simpan</button></div>
            </form>
        </div>
    </div>
    <div id="modalDetailCabang" class="hidden fixed inset-0 bg-black/50 z-50 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Detail Cabang</h3>
            <div id="detailContent" class="space-y-3 text-sm">
                <p><strong>Nama:</strong> <span id="detailNamaCabang">Memuat...</span></p>
                <p><strong>Alamat:</strong> <span id="detailAlamatCabang">Memuat...</span></p>
            </div>
            <div class="flex justify-end gap-3 mt-6"><a id="btnLihatMaps" href="#" target="_blank" class="px-4 py-2 text-sm rounded-lg bg-slate-700 text-white hover:bg-slate-800 flex items-center gap-2"><i class="bi bi-geo-alt-fill"></i> Lihat di Maps</a><button type="button" class="btn-batal px-4 py-2 text-sm rounded-lg bg-slate-200 hover:bg-slate-300">Tutup</button></div>
        </div>
    </div>
    <div id="modalEditCabang" class="hidden fixed inset-0 bg-black/50 z-50 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Edit Cabang</h3>
            <form id="formEditCabang" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4"><label for="editNamaCabang" class="block text-sm font-medium text-slate-600 mb-1">Nama Cabang</label><input type="text" name="nama_cabang" id="editNamaCabang" class="w-full border border-slate-300 rounded-lg p-2" required></div>
                <div class="mb-4"><label for="editAlamatCabang" class="block text-sm font-medium text-slate-600 mb-1">Alamat Cabang</label><input type="text" name="alamat" id="editAlamatCabang" class="w-full border border-slate-300 rounded-lg p-2" required></div>
                <hr class="my-4">
                <div class="flex justify-between items-center mt-6">
                    <button type="button" id="btnHapusCabang" class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 flex items-center gap-2"><i class="bi bi-trash"></i> Hapus</button>
                    <div class="flex gap-3"><button type="button" class="btn-batal px-4 py-2 text-sm rounded-lg bg-slate-200 hover:bg-slate-300">Batal</button><button type="submit" class="px-4 py-2 text-sm rounded-lg bg-teal-500 text-white hover:bg-teal-600">Simpan Perubahan</button></div>
                </div>
            </form>
            <form id="formHapusCabang" action="" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // === DATA DARI CONTROLLER LARAVEL ===
        const revenueTrendData = @json($revenueTrend);
        const layananTerlarisData = @json($layananTerlaris);
        const showCabangUrlTemplate = "{{ route('owner.cabang.show', ['cabang' => 'PLACEHOLDER']) }}";
        const updateCabangUrlTemplate = "{{ route('owner.cabang.update', ['cabang' => 'PLACEHOLDER']) }}";
        const destroyCabangUrlTemplate = "{{ route('owner.cabang.destroy', ['cabang' => 'PLACEHOLDER']) }}";
        
        // === FUNGSI SETUP CHARTS ===
        const setupCharts = () => {
            const revCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revCtx, {
                type: 'line',
                data: {
                    labels: Object.keys(revenueTrendData).map(date => dayjs(date).format('DD MMM')),
                    datasets: [{ label: 'Pendapatan', data: Object.values(revenueTrendData), borderColor: '#2dd4bf', borderWidth: 3, tension: 0.4 }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });

            const servCtx = document.getElementById('servicesChart').getContext('2d');
            new Chart(servCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(layananTerlarisData),
                    datasets: [{ data: Object.values(layananTerlarisData), backgroundColor: ['#2dd4bf', '#60a5fa', '#c084fc', '#f87171', '#fbbf24'] }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        };
        
        // === LOGIKA FILTER ===
        const cabangFilter = document.getElementById('cabangFilter');
        const dateFilter = document.getElementById('dateFilter');
        cabangFilter.addEventListener('change', () => document.getElementById('filterForm').submit());
        dateFilter.addEventListener('change', () => document.getElementById('filterForm').submit());

        // === LOGIKA MODAL DETAIL TRANSAKSI (FINAL) ===
        const mainContent = document.querySelector('main'); 
        const detailModal = document.getElementById('detailModal');
        const modalContent = document.getElementById('modalContent');
        const closeModalBtn = document.getElementById('closeModalBtn');

        const openDetailModal = (transactionData) => {
            const trx = transactionData;
            if (!trx) { console.error('Data transaksi tidak valid.'); return; }
            
            document.getElementById('modalOrderId').textContent = `TRX-${dayjs(trx.created_at).format('YYYYMM')}-${String(trx.id).padStart(4, '0')}`;
            
            let servicesHtml = 'Tidak ada detail layanan.';
            if (trx.layanan && typeof trx.layanan === 'string') {
                try {
                    const services = JSON.parse(trx.layanan);
                    if (Array.isArray(services) && services.length > 0) {
                        servicesHtml = services.map(s => `<li>${s.kuantitas || 1}x ${s.nama || 'N/A'} - Rp ${(s.harga ? parseInt(s.harga) : 0).toLocaleString('id-ID')}</li>`).join('');
                        servicesHtml = `<ul class="list-disc list-inside">${servicesHtml}</ul>`;
                    }
                } catch (e) { servicesHtml = 'Format data layanan tidak valid.'; }
            }

            const statusBadgeHtml = (status) => {
                let sClass = 'bg-slate-100 text-slate-800';
                if (status === 'Selesai') sClass = 'bg-green-100 text-green-800';
                else if (status === 'Diproses') sClass = 'bg-blue-100 text-blue-800';
                else if (status === 'Baru') sClass = 'bg-yellow-100 text-yellow-800';
                return `<span class="${sClass} px-3 py-1 rounded-full text-xs font-semibold">${status || 'N/A'}</span>`;
            };

            // PERBAIKAN LOGIKA TANGGAL SELESAI DI SINI
            const tglSelesai = trx.waktu_pembayaran && dayjs(trx.waktu_pembayaran).isValid() 
                             ? dayjs(trx.waktu_pembayaran).format('DD MMMM YYYY') 
                             : (trx.status == 'Selesai' && trx.updated_at ? dayjs(trx.updated_at).format('DD MMMM YYYY') : '-');

            document.getElementById('modalBody').innerHTML = `
                <div class="space-y-1"><p><strong>Nama Pelanggan:</strong> ${trx.pelanggan?.nama || 'N/A'}</p><p><strong>No. Telepon:</strong> ${trx.pelanggan?.no_handphone || 'N/A'}</p><p><strong>Asal Cabang:</strong> ${trx.cabang?.nama_cabang || 'N/A'}</p></div><hr class="my-3"/>
                <div class="space-y-1"><p><strong>Tanggal Masuk:</strong> ${dayjs(trx.created_at).format('DD MMMM YYYY')}</p><p><strong>Tanggal Selesai:</strong> ${tglSelesai}</p></div><hr class="my-3"/>
                <div class="space-y-1"><p><strong>Layanan:</strong></p><div class="pl-1">${servicesHtml}</div><p><strong>Total Biaya:</strong> Rp ${(trx.total_harga ? parseInt(trx.total_harga) : 0).toLocaleString('id-ID')}</p></div><hr class="my-3"/>
                <div class="space-y-1"><p><strong>Metode Pengambilan:</strong> ${trx.metode_pengambilan || 'N/A'}</p><p><strong>Status Saat Ini:</strong> ${statusBadgeHtml(trx.status)}</p></div>`;
            
            detailModal.classList.remove('hidden');
            setTimeout(() => { modalContent.classList.remove('scale-95', 'opacity-0'); }, 10);
        };

        const closeDetailModal = () => {
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { detailModal.classList.add('hidden'); }, 200);
        };
        
        mainContent.addEventListener('click', (e) => {
            const detailButton = e.target.closest('.view-detail-btn');
            if (detailButton) {
                try { openDetailModal(JSON.parse(detailButton.dataset.transaction)); } 
                catch (e) { Swal.fire('Error', 'Data detail transaksi rusak.', 'error'); }
            }
        });
        closeModalBtn.addEventListener('click', closeDetailModal);
        detailModal.addEventListener('click', (e) => { if (e.target === detailModal) closeDetailModal(); });
        
        // === LOGIKA CRUD CABANG ===
        const btnTambah = document.getElementById('btnTambahCabang');
        const btnDetail = document.getElementById('btnDetailCabang');
        const btnEdit = document.getElementById('btnEditCabang');

        const setupModal = (modal, openTrigger, closeSelectors) => {
            const open = () => modal.classList.remove('hidden');
            const close = () => modal.classList.add('hidden');
            if(openTrigger) openTrigger.addEventListener('click', open);
            modal.querySelectorAll(closeSelectors).forEach(el => el.addEventListener('click', close));
            modal.addEventListener('click', e => { if(e.target === modal) close(); });
        };
        setupModal(document.getElementById('modalTambahCabang'), btnTambah, '.btn-batal');
        setupModal(document.getElementById('modalDetailCabang'), btnDetail, '.btn-batal');
        setupModal(document.getElementById('modalEditCabang'), btnEdit, '.btn-batal');

        const toggleCrudButtons = () => {
            const isCabangSelected = cabangFilter.value !== 'semua';
            btnDetail.disabled = !isCabangSelected;
            btnEdit.disabled = !isCabangSelected;
        };
        cabangFilter.addEventListener('change', toggleCrudButtons);
        toggleCrudButtons();

        const fetchCabangData = async (id) => {
            const url = showCabangUrlTemplate.replace('PLACEHOLDER', id);
            try {
                const response = await fetch(url);
                if (!response.ok) throw new Error('Gagal mengambil data cabang');
                return await response.json();
            } catch (error) {
                Swal.fire('Error', 'Tidak dapat memuat data cabang.', 'error');
            }
        };

        btnDetail.addEventListener('click', async () => {
            const id = cabangFilter.value;
            if (id === 'semua') return;
            const data = await fetchCabangData(id);
            if(data){
                document.getElementById('detailNamaCabang').textContent = data.nama_cabang;
                document.getElementById('detailAlamatCabang').textContent = data.alamat;
                document.getElementById('btnLihatMaps').href = `https://maps.google.com/?q=${encodeURIComponent(data.alamat)}`;
            }
        });

        btnEdit.addEventListener('click', async () => {
            const id = cabangFilter.value;
            if (id === 'semua') return;
            const data = await fetchCabangData(id);
            if(data){
                document.getElementById('formEditCabang').action = updateCabangUrlTemplate.replace('PLACEHOLDER', id);
                document.getElementById('formHapusCabang').action = destroyCabangUrlTemplate.replace('PLACEHOLDER', id);
                document.getElementById('editNamaCabang').value = data.nama_cabang;
                document.getElementById('editAlamatCabang').value = data.alamat;
            }
        });

        document.getElementById('btnHapusCabang').addEventListener('click', () => {
            Swal.fire({
                title: 'Anda yakin?', text: "Data cabang akan dihapus!", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formHapusCabang').submit();
                }
            });
        });

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

        // --- INISIALISASI ---
        setupCharts();
    });
    </script>
</body>
</html>

