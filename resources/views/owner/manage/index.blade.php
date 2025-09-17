<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Order | Avachive</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        .sidebar-mobile-open { transform: translateX(0) !important; }
        .table-wrapper::-webkit-scrollbar { height: 8px; }
        .table-wrapper::-webkit-scrollbar-track { background: #f1f5f9; }
        .table-wrapper::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        @media (max-width: 767px) {
            .responsive-table thead { display: none; }
            .responsive-table tbody, .responsive-table tr { display: block; width: 100%; }
            .responsive-table tr { margin-bottom: 1rem; border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 1rem; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.05); }
            .responsive-table td { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 0.25rem; text-align: right; border-bottom: 1px solid #f1f5f9; }
            .responsive-table td:last-child { border-bottom: none; }
            .responsive-table td::before { content: attr(data-label); font-weight: 600; text-align: left; color: #475569; margin-right: 1rem; }
            .responsive-table td[data-label="Aksi"] { justify-content: center; padding-top: 1rem; }
            .responsive-table td[data-label="Aksi"]::before { display: none; }
        }
    </style>
</head>
<body class="bg-slate-100">
    <div class="flex">
        <aside id="sidebar" class="bg-slate-900 text-slate-300 w-64 min-h-screen p-4 fixed transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40 flex flex-col">
            <div>
                <div class="flex flex-col items-center text-center mb-10">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Avachive" class="w-16 h-auto mb-2">
                    <div class="text-2xl font-bold text-teal-400">Avachive Owner</div>
                </div>
                <nav class="space-y-3">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-grid-1x2-fill mr-4 text-lg"></i><span class="font-medium">Dashboard</span></a>
                    <a href="{{ route('owner.manage') }}" class="flex items-center py-3 px-4 rounded-lg bg-teal-400 text-slate-900 font-semibold shadow-lg"><i class="bi bi-receipt-cutoff mr-4 text-lg"></i><span class="font-medium">Manajemen Order</span></a>
                    <a href="{{ route('owner.laporan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-shop-window mr-4 text-lg"></i><span class="font-medium">Data Cabang</span></a>
                    <a href="{{ route('owner.dataadmin.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-person-badge-fill mr-4 text-lg"></i><span class="font-medium">Data Admin</span></a>
                    <a href="{{ route('owner.datakaryawan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i class="bi bi-people-fill mr-4 text-lg"></i><span class="font-medium">Data Karyawan</span></a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            <header class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
                <div class="flex items-center gap-4">
                    <button id="menu-btn" class="text-slate-800 text-2xl md:hidden"><i class="bi bi-list"></i></button>
                    <h1 class="text-xl font-semibold text-slate-800">Manajemen Order</h1>
                </div>
                <div class="relative">
                    <button id="profileDropdownBtn" class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all">
                        {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                    </button>
                    <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-10 border">
                        <div class="p-2">
                            <a href="{{ route('owner.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="px-4 md:px-6 pb-6 mt-8">
                <div class="bg-white p-4 rounded-xl shadow-md mb-6">
                    <form action="{{ route('owner.manage') }}" method="GET">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <h2 class="text-xl font-semibold text-slate-700">Monitoring Order Berjalan</h2>
                                <p class="text-sm text-slate-500 mt-1">💡 Klik kartu status untuk memfilter tabel.</p>
                            </div>
                            <div class="relative w-full md:w-auto">
                                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" name="search" placeholder="Cari ID atau nama..." value="{{ $searchQuery }}" class="pl-10 pr-4 py-2 w-full sm:w-64 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-400">
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
                    <a href="{{ route('owner.manage', ['status' => 'Diproses']) }}" class="report-card bg-white p-4 rounded-xl shadow-md flex items-center gap-4 cursor-pointer transition-all duration-200 hover:shadow-xl hover:-translate-y-1 {{ $filterStatus == 'Diproses' ? 'ring-2 ring-teal-400' : '' }}">
                        <div class="bg-orange-100 p-3 rounded-full"><i class="bi bi-arrow-repeat text-orange-600 text-2xl"></i></div>
                        <div><p class="text-sm text-slate-500">Order Proses</p><p class="text-2xl font-bold text-slate-800">{{ $statusCounts['Diproses'] ?? 0 }}</p></div>
                    </a>
                     <a href="{{ route('owner.manage', ['status' => 'Siap diantar']) }}" class="report-card bg-white p-4 rounded-xl shadow-md flex items-center gap-4 cursor-pointer transition-all duration-200 hover:shadow-xl hover:-translate-y-1 {{ $filterStatus == 'Siap diantar' ? 'ring-2 ring-teal-400' : '' }}">
                        <div class="bg-purple-100 p-3 rounded-full"><i class="bi bi-truck text-purple-600 text-2xl"></i></div>
                        <div><p class="text-sm text-slate-500">Siap Diantar</p><p class="text-2xl font-bold text-slate-800">{{ $statusCounts['Siap diantar'] ?? 0 }}</p></div>
                    </a>
                     <a href="{{ route('owner.manage', ['status' => 'Siap diambil']) }}" class="report-card bg-white p-4 rounded-xl shadow-md flex items-center gap-4 cursor-pointer transition-all duration-200 hover:shadow-xl hover:-translate-y-1 {{ $filterStatus == 'Siap diambil' ? 'ring-2 ring-teal-400' : '' }}">
                        <div class="bg-indigo-100 p-3 rounded-full"><i class="bi bi-person-walking text-indigo-600 text-2xl"></i></div>
                        <div><p class="text-sm text-slate-500">Siap Diambil</p><p class="text-2xl font-bold text-slate-800">{{ $statusCounts['Siap diambil'] ?? 0 }}</p></div>
                    </a>
                    <a href="{{ route('owner.manage', ['status' => 'Selesai']) }}" class="report-card bg-white p-4 rounded-xl shadow-md flex items-center gap-4 cursor-pointer transition-all duration-200 hover:shadow-xl hover:-translate-y-1 {{ $filterStatus == 'Selesai' ? 'ring-2 ring-teal-400' : '' }}">
                        <div class="bg-green-100 p-3 rounded-full"><i class="bi bi-check2-circle text-green-600 text-2xl"></i></div>
                        <div><p class="text-sm text-slate-500">Order Selesai</p><p class="text-2xl font-bold text-slate-800">{{ $statusCounts['Selesai'] ?? 0 }}</p></div>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-md md:p-2">
                    <div class="table-wrapper overflow-x-auto">
                        <table class="responsive-table w-full text-sm text-left text-slate-500">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3">ID Order</th>
                                    <th scope="col" class="px-6 py-3">Pelanggan</th>
                                    <th scope="col" class="px-6 py-3">Cabang</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Masuk</th>
                                    <th scope="col" class="px-6 py-3">Pengambilan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                @forelse ($orders as $order)
                                <tr class="hover:bg-slate-50">
                                    <td data-label="ID Order" class="px-6 py-4 font-medium text-slate-900 whitespace-nowrap">#{{ $order->id }}</td>
                                    <td data-label="Pelanggan" class="px-6 py-4">{{ $order->pelanggan->nama ?? 'N/A' }}</td>
                                    <td data-label="Cabang" class="px-6 py-4 font-medium">{{ $order->cabang->nama_cabang ?? 'N/A' }}</td>
                                    <td data-label="Tanggal Masuk" class="px-6 py-4">{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }}</td>
                                    <td data-label="Pengambilan" class="px-6 py-4">{{ $order->metode_pengambilan }}</td>
                                    <td data-label="Status" class="px-6 py-4">
                                        @php
                                            $statusClass = 'bg-slate-100 text-slate-800';
                                            if ($order->status == 'Diproses') $statusClass = 'bg-orange-100 text-orange-800';
                                            else if ($order->status == 'Siap diantar') $statusClass = 'bg-purple-100 text-purple-800';
                                            else if ($order->status == 'Siap diambil') $statusClass = 'bg-indigo-100 text-indigo-800';
                                            else if ($order->status == 'Selesai') $statusClass = 'bg-green-100 text-green-800';
                                        @endphp
                                        <span class="{{ $statusClass }} px-3 py-1 rounded-full text-xs font-semibold">{{ $order->status }}</span>
                                    </td>
                                    <td data-label="Aksi" class="px-6 py-4 text-center">
                                        <button class="bg-slate-200 text-slate-800 hover:bg-slate-300 text-xs font-bold py-2 px-3 rounded-lg view-detail-btn" data-order='@json($order)'>
                                            Lihat Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center p-8 text-slate-500">Tidak ada data order untuk ditampilkan.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden"></div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex justify-center items-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-95 opacity-0" id="modalContent">
          <div class="flex justify-between items-center border-b pb-3 mb-4">
            <h3 class="text-lg font-bold text-slate-800">Detail Order #<span id="modalOrderId"></span></h3>
            <button id="closeModalBtn" class="text-slate-500 hover:text-slate-800 text-2xl">&times;</button>
          </div>
          <div id="modalBody" class="space-y-3 text-sm"></div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- LOGIKA MODAL DETAIL ---
        const detailModal = document.getElementById('detailModal');
        const modalContent = document.getElementById('modalContent');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalBody = document.getElementById('modalBody');

        const statusBadge = (status) => {
            const baseStyle = 'px-3 py-1 rounded-full text-xs font-semibold';
            switch (status) {
                case 'Diproses': return `<span class="bg-orange-100 text-orange-800 ${baseStyle}">${status}</span>`;
                case 'Siap diantar': return `<span class="bg-purple-100 text-purple-800 ${baseStyle}">${status}</span>`;
                case 'Siap diambil': return `<span class="bg-indigo-100 text-indigo-800 ${baseStyle}">${status}</span>`;
                case 'Selesai': return `<span class="bg-green-100 text-green-800 ${baseStyle}">${status}</span>`;
                default: return `<span class="bg-slate-100 text-slate-800 ${baseStyle}">${status}</span>`;
            }
        };

        const openModal = (order) => {
            if (!order) return;
            document.getElementById('modalOrderId').textContent = order.id;

            let servicesHtml = 'Tidak ada detail layanan.';
            if (order.layanan && typeof order.layanan === 'string') {
                try {
                    const services = JSON.parse(order.layanan);
                    if (Array.isArray(services) && services.length > 0) {
                        servicesHtml = services.map(s => {
                            const harga = s.harga ? parseInt(s.harga).toLocaleString('id-ID') : 'N/A';
                            return `<li>${s.kuantitas || 1}x ${s.nama || 'Layanan tidak diketahui'} - Rp ${harga}</li>`;
                        }).join('');
                        servicesHtml = `<ul class="list-disc list-inside">${servicesHtml}</ul>`;
                    }
                } catch (e) { 
                    servicesHtml = 'Format data layanan tidak valid.';
                }
            }

            modalBody.innerHTML = `
                <p><strong>Nama Pelanggan:</strong> ${order.pelanggan ? order.pelanggan.nama : 'N/A'}</p>
                <p><strong>No. Telepon:</strong> ${order.pelanggan ? order.pelanggan.no_handphone : 'N/A'}</p>
                <p><strong>Asal Cabang:</strong> ${order.cabang ? order.cabang.nama_cabang : 'N/A'}</p>
                <p><strong>Tanggal Order:</strong> ${dayjs(order.created_at).format('DD MMMM YYYY')}</p>
                <hr class="my-3"/>
                <p><strong>Detail Layanan:</strong></p>
                <div>${servicesHtml}</div>
                <p><strong>Total Biaya:</strong> Rp ${parseInt(order.total_harga).toLocaleString('id-ID')}</p>
                <hr class="my-3"/>
                <p><strong>Metode Pengambilan:</strong> ${order.metode_pengambilan}</p>
                <p><strong>Status Saat Ini:</strong> ${statusBadge(order.status)}</p>
            `;
            detailModal.classList.remove('hidden');
            setTimeout(() => { modalContent.classList.remove('scale-95', 'opacity-0'); }, 10);
        };
        const closeModal = () => {
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => { detailModal.classList.add('hidden'); }, 200);
        };
        closeModalBtn.addEventListener('click', closeModal);
        detailModal.addEventListener('click', (e) => { if (e.target === detailModal) closeModal(); });

        document.getElementById('ordersTableBody').addEventListener('click', function(e) {
            const detailButton = e.target.closest('.view-detail-btn');
            if (detailButton) {
                try {
                    const orderData = JSON.parse(detailButton.dataset.order);
                    openModal(orderData);
                } catch (err) {
                    console.error('Gagal parsing data order:', err);
                    Swal.fire('Error', 'Data detail order rusak.', 'error');
                }
            }
        });

        // --- UI Scripts (Sidebar & Profile) ---
        const menuBtn = document.getElementById('menu-btn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = () => {
            sidebar.classList.toggle('sidebar-mobile-open');
            overlay.classList.toggle('hidden');
        };
        menuBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);

        const profileDropdownBtn = document.getElementById('profileDropdownBtn');
        const profileDropdownMenu = document.getElementById('profileDropdownMenu');
        profileDropdownBtn.addEventListener('click', () => {
            profileDropdownMenu.classList.toggle('hidden');
        });
        window.addEventListener('click', (e) => {
            if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                profileDropdownMenu.classList.add('hidden');
            }
        });
    });
    </script>
</body>
</html>