<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Order - Pelanggan Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .order-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50">
    @include('components.sidebar_pelanggan')

    <div class="lg:ml-64 min-h-screen">
        <div
            class="sticky top-0 z-20 glass-effect p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
            <div class="flex items-center gap-4">
                <h1 class="text-lg font-semibold text-slate-800">Riwayat Order</h1>
            </div>
            <div class="relative">
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
                <div id="user-menu"
                    class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                    <a href="{{ route('pelanggan.pengaturan') }}"
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

        <main class="pt-20 lg:pt-6 px-4 pb-20">
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Filter Riwayat</h2>

                <form method="GET" action="{{ route('pelanggan.riwayat_order') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Mulai</label>
                            <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                                Selesai</label>
                            <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari
                                Order</label>
                            <div class="relative">
                                <input type="text" id="search" name="search"
                                    placeholder="Cari No. Order atau layanan..." value="{{ request('search') }}"
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i class="bi bi-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>
                        <div>
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <select id="sort_by" name="sort_by"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="terbaru" @if (request('sort_by') == 'terbaru') selected @endif>Terbaru
                                </option>
                                <option value="terlama" @if (request('sort_by') == 'terlama') selected @endif>Terlama
                                </option>
                                <option value="harga_tertinggi" @if (request('sort_by') == 'harga_tertinggi') selected @endif>Harga
                                    Tertinggi</option>
                                <option value="harga_terendah" @if (request('sort_by') == 'harga_terendah') selected @endif>Harga
                                    Terendah</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Terapkan Filter
                        </button>

                        <a href="{{ route('pelanggan.riwayat_order') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                            Reset Filter
                        </a>
                    </div>
                </form>
            </div>
            </form>

            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-clock-history text-blue-600"></i>
                        Semua Riwayat Order
                    </h2>
                </div>

                {{-- ... (bagian atas file blade Anda biarkan sama) ... --}}

                <div class="space-y-4">
                    @forelse ($orders as $order)
                        @php
                            // Decode JSON layanan
                            $layananDetails = json_decode($order->layanan, true);

                            // Logika untuk menentukan warna berdasarkan status
                            $statusColors = [
                                'Selesai' => [
                                    'border' => 'border-l-green-500',
                                    'badge' => 'bg-green-100 text-green-800',
                                    'text' => 'text-green-600',
                                ],
                                'Diproses' => [
                                    'border' => 'border-l-yellow-500',
                                    'badge' => 'bg-yellow-100 text-yellow-800',
                                    'text' => 'text-yellow-600',
                                ],
                                'Bisa Diambil' => [
                                    'border' => 'border-l-blue-500',
                                    'badge' => 'bg-blue-100 text-blue-800',
                                    'text' => 'text-blue-600',
                                ],
                                'Dibatalkan' => [
                                    'border' => 'border-l-red-500',
                                    'badge' => 'bg-red-100 text-red-800',
                                    'text' => 'text-red-600',
                                ],
                                'Sudah Diambil' => [
                                    'border' => 'border-l-emerald-500',
                                    'badge' => 'bg-emerald-100 text-emerald-800',
                                    'text' => 'text-emerald-600',
                                ],
                                'default' => [
                                    'border' => 'border-l-gray-400',
                                    'badge' => 'bg-gray-100 text-gray-800',
                                    'text' => 'text-gray-600',
                                ],
                            ];
                            $colors = $statusColors[$order->status] ?? $statusColors['default'];
                        @endphp
                        <div
                            class="order-card bg-white rounded-xl p-5 border border-gray-200 border-l-4 {{ $colors['border'] }}">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex flex-wrap items-center gap-3 mb-2">
                                        <h3 class="font-semibold text-lg">
                                            #{{ $order->id_order ?? $order->id }}</h3>
                                        <span class="status-badge {{ $colors['badge'] }}">{{ $order->status }}</span>
                                        @if (is_array($layananDetails))
                                            @foreach ($layananDetails as $item)
                                                <span
                                                    class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full">{{ $item['nama'] }}</span>
                                            @endforeach
                                        @endif
                                    </div>
                                    <p class="text-gray-600 mb-2">
                                        {{ $order->metode_pengambilan }} &bull; {{ $order->waktu_pembayaran }}
                                    </p>
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        <span><i class="bi bi-calendar-check mr-1"></i> Order:
                                            {{ $order->created_at->isoFormat('D MMM YYYY') }}</span>
                                        <span class="font-bold text-slate-700"><i class="bi bi-cash-stack mr-1"></i> Rp
                                            {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="flex flex-col items-start md:items-end gap-2">
                                    <div class="text-left md:text-right">
                                        <p class="text-sm text-gray-500">Update Terakhir:</p>
                                        <p class="font-medium {{ $colors['text'] }}">
                                            {{ $order->updated_at->format('d-m-Y') }}</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button
                                            class="detail-btn px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm hover:bg-blue-200"
                                            data-order-id="{{ $order->id_order ?? $order->id }}"
                                            data-status="{{ $order->status }}"
                                            data-order-date="{{ $order->created_at->isoFormat('D MMM YYYY') }}"
                                            data-finish-date="{{ $order->updated_at->isoFormat('D MMM YYYY') }}"
                                            data-total-harga="{{ 'Rp ' . number_format($order->total_harga, 0, ',', '.') }}"
                                            data-dp-dibayar="{{ 'Rp ' . number_format($order->dp_dibayar, 0, ',', '.') }}"
                                            data-sisa-harga="{{ 'Rp ' . number_format($order->sisa_harga, 0, ',', '.') }}"
                                            data-layanan="{{ $order->layanan }}"
                                            data-metode-pembayaran="{{ $order->metode_pembayaran }}"
                                            data-waktu-pembayaran="{{ $order->waktu_pembayaran }}"
                                            data-metode-pengambilan="{{ $order->metode_pengambilan }}">
                                            Detail
                                        </button>
                                        <a href="#"
                                            class="invoice-btn px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200">
                                            <i class="bi bi-download"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 px-6 bg-gray-50 rounded-lg">
                            <i class="bi bi-folder-x text-5xl text-gray-400"></i>
                            <h3 class="mt-4 text-lg font-semibold text-gray-700">Tidak Ada Riwayat Order</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum pernah membuat order apapun.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ... (bagian bawah file blade Anda biarkan sama) ... --}}
                @if ($orders->hasPages())
                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} dari
                            {{ $orders->total() }} order
                        </div>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <div id="detailModal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center z-10">
                <h3 id="modalTitle" class="text-xl font-semibold text-slate-800">Detail Order</h3>
                <button id="closeDetailModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="p-6">
                <div id="modalContent">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User Dropdown Logic
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            if (userMenuButton) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }

            // Modal Logic
            const detailModal = document.getElementById('detailModal');
            const modalContent = document.getElementById('modalContent');
            const modalTitle = document.getElementById('modalTitle');
            const closeDetailModal = document.getElementById('closeDetailModal');

            function showOrderDetails(button) {
                const data = button.dataset;
                const layanan = JSON.parse(data.layanan);

                modalTitle.innerText = `Detail Order #${data.orderId}`;

                let layananHtml = layanan.map(item => `
                    <div class="flex justify-between items-center text-sm py-1">
                        <span class="text-gray-600">${item.nama} (${item.kuantitas} ${item.satuan || 'item'})</span>
                        <span class="font-medium">Rp ${parseInt(item.harga).toLocaleString('id-ID')}</span>
                    </div>
                `).join('');

                modalContent.innerHTML = `
                    <div class="space-y-4">
                        <div class="border-b pb-4">
                            <h5 class="text-md font-semibold text-slate-800 mb-2">Rincian Layanan</h5>
                            <div class="space-y-1">${layananHtml}</div>
                        </div>

                        <div class="border-b pb-4">
                            <h5 class="text-md font-semibold text-slate-800 mb-2">Informasi Order</h5>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <span class="text-gray-500">Status:</span>
                                <span class="font-medium text-green-600">${data.status}</span>
                                
                                <span class="text-gray-500">Tanggal Order:</span>
                                <span>${data.orderDate}</span>
                                
                                <span class="text-gray-500">Tanggal Selesai:</span>
                                <span>${data.finishDate}</span>

                                <span class="text-gray-500">Metode Pengambilan:</span>
                                <span>${data.metodePengambilan}</span>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-md font-semibold text-slate-800 mb-2">Rincian Pembayaran</h5>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Metode Bayar:</span>
                                    <span>${data.metodePembayaran} (${data.waktuPembayaran})</span>
                                </div>
                                <div class="border-t my-2"></div>
                                <div class="flex justify-between font-bold text-base">
                                    <span class="text-slate-800">Total Harga:</span>
                                    <span class="text-blue-600">${data.totalHarga}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                detailModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            document.querySelectorAll('.detail-btn').forEach(button => {
                button.addEventListener('click', () => showOrderDetails(button));
            });

            // Close modal events
            const closeModal = () => {
                detailModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            };
            closeDetailModal.addEventListener('click', closeModal);
            window.addEventListener('click', (e) => {
                if (e.target === detailModal) {
                    closeModal();
                }
            });

            // Konfirmasi logout
            const logoutButton = document.getElementById('logout-button');
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
        });
    </script>
</body>

</html>
