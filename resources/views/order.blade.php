<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Order Laundry</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
        .sidebar-mobile-open { transform: translateX(0) !important; }
        @media (max-width: 768px) {
            .responsive-table thead { display: none; }
            .responsive-table tbody, .responsive-table tr { display: block; width: 100%; }
            .responsive-table tr.data-row { margin-bottom: 1rem; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; background-color: #fff; }
            .responsive-table tr.date-header-row, .responsive-table tr.total-row { display: block; margin-bottom: 1rem; }
            .responsive-table tr.total-row { margin-top: -1rem; }
            .responsive-table tr.total-row td { justify-content: center; background-color: #f1f5f9; border-radius: 0.5rem; padding: 0.75rem 1rem; }
            .responsive-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; text-align: right; }
            .responsive-table tr.data-row td:last-child { border-bottom: none; }
            .responsive-table td::before { content: attr(data-label); font-weight: 600; text-align: left; padding-right: 1rem; color: #475569; }
            .responsive-table tr.date-header-row td::before, .responsive-table tr.total-row td::before { display: none; }
        }
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
                    <i class="bi bi-speedometer2 text-lg"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-list-check text-lg"></i><span>Layanan</span>
                </a>
                <a href="{{ route('dataorder') }}" class="active flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors">
                    <i class="bi bi-cart-check text-lg"></i><span>Order</span>
                </a>
                <a href="{{ route('datauser') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-people text-lg"></i><span>Karyawan</span>
                </a>
            </nav>
        </aside>
        <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

        <main class="flex-1 overflow-y-auto">
            <div class="p-4 sm:p-6">
                <div class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700"><i class="bi bi-list"></i></button>
                        <h1 class="text-lg font-semibold text-slate-800">Riwayat Order Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
                    </div>
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                            <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                            <i class="bi bi-person-circle text-2xl text-slate-600"></i>
                        </button>
                        <div id="user-menu" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                            <a href="pengaturan" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i class="bi bi-person-circle"></i><span>Profile</span></a>
                            <div class="border-t border-slate-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" id="logout-button" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button>
                            </form>
                        </div>
                    </div>
                </div>

                <section class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">🗓️ Filter Data Order</h3>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-4">
                        <label for="yearSelect" class="font-semibold text-sm">Tahun:</label>
                        <select id="yearSelect" class="w-full sm:w-auto text-sm border border-slate-300 rounded-full px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition">
                            @forelse($years as $year)
                                <option value="{{ $year }}" @if(now()->year == $year) selected @endif>{{ $year }}</option>
                            @empty
                                <option>{{ now()->year }}</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <strong class="text-sm font-semibold">Pilih Bulan:</strong>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-12 gap-2 mt-2" id="monthButtons">
                            @php $months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]; @endphp
                            @foreach($months as $index => $month)
                                <button class="month-button px-3 py-2 text-sm font-semibold rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 transition" data-month="{{ $index + 1 }}">{{ $month }}</button>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">📦 Data Order per Hari</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm responsive-table">
                            <thead class="bg-slate-100">
                                <tr>
                                    <th class="p-3 text-left font-semibold text-slate-600 rounded-l-lg">Nama Customer</th>
                                    <th class="p-3 text-left font-semibold text-slate-600">Layanan</th>
                                    <th class="p-3 text-left font-semibold text-slate-600 rounded-r-lg">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody id="orderContent">
                                @forelse($order_groups as $tanggal => $grup)
                                    <tr class="date-header-row order-group" data-year="{{ \Carbon\Carbon::parse($tanggal)->format('Y') }}" data-month="{{ \Carbon\Carbon::parse($tanggal)->format('n') }}">
                                        <td colspan="3" class="p-3 bg-slate-200 font-bold text-slate-700 rounded-lg">
                                            Tanggal: {{ \Carbon\Carbon::parse($tanggal)->isoFormat('dddd, D MMMM YYYY') }}
                                        </td>
                                    </tr>

                                    @foreach($grup['orders'] as $order)
                                    <tr class="data-row order-group odd:bg-white even:bg-slate-50" data-year="{{ \Carbon\Carbon::parse($tanggal)->format('Y') }}" data-month="{{ \Carbon\Carbon::parse($tanggal)->format('n') }}">
                                        <td data-label="Customer" class="p-3">{{ $order->pelanggan->nama ?? 'N/A' }}</td>
                                        <td data-label="Layanan" class="p-3">
                                            @php $layanan_items = json_decode($order->layanan, true) ?? []; @endphp
                                            @foreach($layanan_items as $item)
                                            <div class="whitespace-nowrap">{{ $item['nama'] ?? 'N/A' }} <strong>({{ $item['kuantitas'] ?? 0 }}x)</strong></div>
                                            @endforeach
                                        </td>
                                        <td data-label="Total Harga" class="p-3 font-semibold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach

                                    <tr class="total-row order-group" data-year="{{ \Carbon\Carbon::parse($tanggal)->format('Y') }}" data-month="{{ \Carbon\Carbon::parse($tanggal)->format('n') }}">
                                        <td class="p-3 font-bold text-slate-800 text-right" colspan="2">Total Pemasukan Harian</td>
                                        <td class="p-3 font-bold text-blue-600">Rp {{ number_format($grup['total_pemasukan'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr id="initial-no-data">
                                        <td colspan="3" class="text-center py-8 text-slate-500">Tidak ada data order yang bisa ditampilkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const yearSelect = document.getElementById('yearSelect');
            const monthButtons = document.querySelectorAll('.month-button');
            const orderRows = document.querySelectorAll('.order-group');
            const orderTbody = document.getElementById('orderContent');
            const initialNoData = document.getElementById('initial-no-data');
            let noDataMessage = null;

            function filterOrders() {
                const selectedYear = yearSelect.value;
                const activeButton = document.querySelector('.month-button.active');
                if (!activeButton) return;

                const selectedMonth = activeButton.getAttribute('data-month');
                let hasVisibleData = false;

                orderRows.forEach(row => {
                    const rowYear = row.getAttribute('data-year');
                    const rowMonth = row.getAttribute('data-month');
                    if (rowYear === selectedYear && rowMonth === selectedMonth) {
                        row.style.display = '';
                        if (row.classList.contains('data-row')) {
                            hasVisibleData = true;
                        }
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                if(initialNoData) initialNoData.style.display = 'none';

                if (!hasVisibleData) {
                    if (!noDataMessage) {
                        noDataMessage = document.createElement('tr');
                        noDataMessage.innerHTML = `<td colspan="3" class="text-center py-8 text-slate-500">Tidak ada data untuk periode yang dipilih.</td>`;
                        orderTbody.appendChild(noDataMessage);
                    }
                    noDataMessage.style.display = '';
                } else {
                    if (noDataMessage) {
                        noDataMessage.style.display = 'none';
                    }
                }
            }

            monthButtons.forEach(button => {
                button.addEventListener('click', function() {
                    monthButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-blue-600', 'text-white');
                        btn.classList.add('bg-slate-100', 'hover:bg-slate-200', 'text-slate-600');
                    });
                    this.classList.add('active', 'bg-blue-600', 'text-white');
                    this.classList.remove('bg-slate-100', 'hover:bg-slate-200', 'text-slate-600');
                    filterOrders();
                });
            });

            yearSelect.addEventListener('change', filterOrders);

            // Auto select current month & year
            const currentMonth = new Date().getMonth() + 1;
            const currentMonthButton = document.querySelector(`.month-button[data-month="${currentMonth}"]`);
            if (currentMonthButton) {
                currentMonthButton.click();
            } else if (monthButtons.length > 0) {
                monthButtons[0].click();
            }

            // UI Scripts
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const logoutButton = document.getElementById('logout-button');

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
            hamburgerBtn.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);
            
            userMenuButton.addEventListener('click', () => userMenu.classList.toggle('hidden'));
            window.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
            logoutButton.addEventListener('click', (e) => {
                e.preventDefault(); 
                Swal.fire({
                    title: 'Anda yakin ingin logout?', icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) logoutButton.closest('form').submit();
                });
            });
        });
    </script>
</body>
</html>
