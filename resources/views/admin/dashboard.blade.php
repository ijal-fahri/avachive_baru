<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Admin - Avachive</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 10px; }
        .sidebar-mobile-open { transform: translateX(0) !important; }
        @media (max-width: 768px) {
            .responsive-table thead { display: none; }
            .responsive-table tr { display: block; margin-bottom: 1rem; border-radius: 0.75rem; padding: 1rem; background-color: white; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
            .responsive-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; text-align: right; }
            .responsive-table td:last-child { border-bottom: none; justify-content: center; padding-top: 1rem; }
            .responsive-table td::before { content: attr(data-label); font-weight: 600; text-align: left; padding-right: 1rem; color: #475569; }
            .responsive-table td[data-label="Aksi"]::before { display: none; }
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
                <a href="{{ route('dashboard') }}" class="active flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors">
                    <i class="bi bi-speedometer2 text-lg"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-list-check text-lg"></i><span>Layanan</span>
                </a>
                <a href="{{ route('dataorder') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
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
                        <h1 class="text-lg font-semibold text-slate-800">Dashboard Admin Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
                    </div>
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                            <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                            <i class="bi bi-person-circle text-2xl text-slate-600"></i>
                        </button>
                        <div id="user-menu" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                            <a href="pengaturan" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <i class="bi bi-person-circle"></i><span>Profile</span>
                            </a>
                            <div class="border-t border-slate-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" id="logout-button" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="bi bi-box-arrow-right"></i><span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <section class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">📊 Ringkasan Data</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-blue-100 pointer-events-none z-0"><i class="bi bi-wallet2 text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Pendapatan Tahun Ini</h4><p class="text-2xl font-bold text-blue-600 mt-1">Rp {{ number_format($pendapatan_tahun_ini, 0, ',', '.') }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-blue-100 pointer-events-none z-0"><i class="bi bi-calendar-check text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Pendapatan Bulan Ini</h4><p class="text-2xl font-bold text-blue-600 mt-1">Rp {{ number_format($pendapatan_bulan_ini, 0, ',', '.') }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-indigo-100 pointer-events-none z-0"><i class="bi bi-journal-check text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Total Order Tahun Ini</h4><p class="text-2xl font-bold text-slate-700 mt-1">{{ $total_order_tahun_ini }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-indigo-100 pointer-events-none z-0"><i class="bi bi-journal-arrow-down text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Total Order Bulan Ini</h4><p class="text-2xl font-bold text-slate-700 mt-1">{{ $total_order_bulan_ini }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-teal-100 pointer-events-none z-0"><i class="bi bi-person-plus text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Jumlah Pelanggan</h4><p class="text-2xl font-bold text-slate-700 mt-1">{{ $jumlah_pelanggan }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-slate-100 pointer-events-none z-0"><i class="bi bi-tags text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Jumlah Layanan</h4><p class="text-2xl font-bold text-slate-700 mt-1">{{ $jumlah_layanan }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-green-100 pointer-events-none z-0"><i class="bi bi-check2-circle text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Order Selesai</h4><p class="text-2xl font-bold text-green-600 mt-1">{{ $order_selesai }}</p></div></div>
                        <div class="bg-white p-5 rounded-xl shadow-lg transition hover:-translate-y-1 relative overflow-hidden"><div class="absolute -right-4 -bottom-4 text-amber-100 pointer-events-none z-0"><i class="bi bi-people text-8xl"></i></div><div class="relative z-10"><h4 class="text-sm font-medium text-slate-500">Jumlah Karyawan</h4><p class="text-2xl font-bold text-slate-700 mt-1">{{ $jumlah_karyawan }}</p></div></div>
                    </div>
                </section>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <section class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-slate-800 mb-4"><i class="bi bi-bar-chart-line-fill text-blue-600"></i> Statistik Pesanan {{ now()->year }}</h3>
                        <div class="relative h-80"><canvas id="orderChart"></canvas></div>
                    </section>
                     <section class="bg-gradient-to-br from-teal-400 to-blue-500 text-white p-6 rounded-2xl shadow-lg flex flex-col">
                        <h3 class="text-xl font-bold mb-4 flex items-center gap-2"><i class="bi bi-info-circle-fill"></i> Info Cabang</h3>
                        <div class="space-y-4">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                                <p class="text-sm opacity-80">Dashboard Cabang</p>
                                <h4 class="font-bold text-lg">{{ Auth::user()->cabang->nama_cabang ?? 'N/A' }}</h4>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4">
                                <p class="text-sm opacity-80">Layanan Favorit Cabang Ini</p>
                                <h4 class="font-bold text-lg flex items-center gap-2"><i class="bi bi-star-fill"></i> {{ $layananFavorit }}</h4>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-4">📦 Pesanan Hari Ini ({{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }})</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm responsive-table border-separate border-spacing-y-2">
                            <thead class="bg-slate-100 hidden md:table-header-group">
                                <tr>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600 rounded-l-lg">ID Order</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Nama</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Tgl Masuk</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Tgl Selesai</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Pengambilan</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Status</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600 rounded-r-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pesanan_hari_ini as $order)
                                <tr class="bg-white shadow-sm hover:shadow-md transition">
                                    <td data-label="ID Order" class="py-4 px-4 font-semibold text-slate-700">#{{ $order->id }}</td>
                                    <td data-label="Nama" class="py-4 px-4">{{ $order->pelanggan->nama ?? 'N/A' }}</td>
                                    <td data-label="Tgl Masuk" class="py-4 px-4">{{ \Carbon\Carbon::parse($order->created_at)->isoFormat('DD MMM YYYY') }}</td>
                                    <td data-label="Tgl Selesai" class="py-4 px-4">{{ strtotime($order->waktu_pembayaran) ? \Carbon\Carbon::parse($order->waktu_pembayaran)->isoFormat('DD MMM YYYY') : ($order->status == 'Selesai' ? \Carbon\Carbon::parse($order->updated_at)->isoFormat('DD MMM YYYY') : 'Belum Selesai') }}</td>
                                    <td data-label="Pengambilan" class="py-4 px-4">{{ $order->metode_pengambilan ?? 'N/A' }}</td>
                                    <td data-label="Status" class="py-4 px-4">
                                        @php
                                            $statusClass = 'bg-slate-100 text-slate-700';
                                            if ($order->status == 'Selesai') { $statusClass = 'bg-green-100 text-green-700'; }
                                            else if ($order->status == 'Sudah Bisa Diambil') { $statusClass = 'bg-yellow-100 text-yellow-700'; }
                                            else if ($order->status == 'Diproses') { $statusClass = 'bg-blue-100 text-blue-700'; }
                                        @endphp
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">{{ $order->status }}</span>
                                    </td>
                                    <td data-label="Aksi" class="py-4 px-4">
                                        <button class="bg-slate-200 text-slate-800 hover:bg-slate-300 text-xs font-bold py-2 px-3 rounded-lg view-detail-btn" data-order='@json($order)'>
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-8 text-slate-500">Tidak ada pesanan hari ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-95 opacity-0" id="modalContent">
          <div class="flex justify-between items-center pb-3 mb-4"><h3 id="modalOrderId" class="text-xl font-bold text-slate-800">Detail Order</h3><button id="closeModalBtn" class="text-slate-500 hover:text-slate-800 text-2xl font-bold leading-none">&times;</button></div>
          <div id="modalBody" class="space-y-3 text-sm"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart.js Configuration
            const labels = @json($chart_labels);
            const data = @json($chart_data);
            const orderChartCanvas = document.getElementById('orderChart');
            if(orderChartCanvas && labels.length > 0) {
                new Chart(orderChartCanvas, {
                    type: 'line',
                    data: { labels: labels, datasets: [{ label: 'Jumlah Order', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderColor: 'rgba(59, 130, 246, 1)', data: data, fill: true, borderWidth: 2, tension: 0.4, pointBackgroundColor: '#3b82f6' }] },
                    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } }, plugins: { legend: { display: false } } }
                });
            }

            // UI Interaction Scripts
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

            // Detail Modal Logic
            const detailModal = document.getElementById('detailModal');
            const modalContent = document.getElementById('modalContent');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const modalBody = document.getElementById('modalBody');
            const modalOrderId = document.getElementById('modalOrderId');

            const openModal = (orderData) => {
                const order = orderData;
                if(!order) return;

                modalOrderId.textContent = `Detail Order #${order.id}`;
                let layananHTML = '';
                try {
                    const layananItems = JSON.parse(order.layanan);
                    if (layananItems && layananItems.length > 0) {
                        layananItems.forEach(item => {
                            layananHTML += `
                                <div class="border-t pt-2 mt-2 first:mt-0 first:pt-0 first:border-t-0">
                                    <p class="font-semibold text-slate-800">${item.nama || 'N/A'}</p>
                                    <div class="text-slate-600 pl-2 grid grid-cols-[auto_1fr] gap-x-2 text-xs">
                                        <span>Harga</span> <span>: Rp ${new Intl.NumberFormat('id-ID').format(item.harga || 0)}</span>
                                        <span>Jumlah</span><span>: ${item.kuantitas || 0}</span>
                                        <span>Subtotal</span><span>: Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal || 0)}</span>
                                    </div>
                                </div>`;
                        });
                    }
                } catch (e) { layananHTML = '<p>Gagal memuat detail layanan.</p>'; }

                const tglSelesai = new Date(order.waktu_pembayaran).getTime() > 0 
                                 ? new Date(order.waktu_pembayaran).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short'})
                                 : (order.status === 'Selesai' ? new Date(order.updated_at).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short'}) : '-');

                modalBody.innerHTML = `
                    <div class="space-y-1 text-slate-700">
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">Nama</strong>: ${order.pelanggan?.nama || 'N/A'}</div>
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">No Hp</strong>: ${order.pelanggan?.no_handphone || 'N/A'}</div>
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">Alamat</strong>: ${order.pelanggan?.detail_alamat || 'N/A'}</div>
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">Pengambilan</strong>: ${order.metode_pengambilan || 'N/A'}</div>
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">Pembayaran</strong>: ${order.metode_pembayaran || 'N/A'}</div>
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">Waktu Order</strong>: ${order.created_at ? new Date(order.created_at).toLocaleString('id-ID', { dateStyle: 'short', timeStyle: 'short'}) : 'N/A'}</div>
                        <div class="flex"><strong class="font-semibold text-slate-900 w-28 flex-shrink-0">Waktu Selesai</strong>: ${tglSelesai}</div>
                    </div>
                    <div class="border-t my-3"></div>
                    <div><h4 class="font-bold text-slate-900 mb-1">Detail Layanan:</h4>${layananHTML}</div>
                    <div class="border-t my-3"></div>
                    <div class="text-right"><p class="text-lg font-bold text-slate-900">Total: Rp ${new Intl.NumberFormat('id-ID').format(order.total_harga)}</p></div>`;
                
                detailModal.classList.remove('hidden');
                setTimeout(() => { modalContent.classList.remove('scale-95', 'opacity-0'); }, 10);
            }

            const closeModal = () => {
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => { detailModal.classList.add('hidden'); }, 200);
            }

            document.querySelectorAll('.view-detail-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    openModal(JSON.parse(this.dataset.order));
                });
            });

            closeModalBtn.addEventListener('click', closeModal);
            detailModal.addEventListener('click', (e) => {
                if (e.target === detailModal) closeModal();
            });
        });
    </script>
</body>
</html>

