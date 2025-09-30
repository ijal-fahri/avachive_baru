<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Riwayat Order</title>
    <script src="https://kit.fontawesome.com/0948e65078.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <style>
        /* Improved Table Styles */
        .order-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.875rem;
        }

        .order-table thead th {
            background-color: #f8fafc;
            color: #64748b;
            font-weight: 600;
            text-align: left;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
        }

        .order-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .order-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .order-table td {
            padding: 1rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            color: #334155;
        }

        .order-table td:first-child {
            border-top-left-radius: 0.5rem;
            border-bottom-left-radius: 0.5rem;
        }

        .order-table td:last-child {
            border-top-right-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }

        .customer-cell {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .customer-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            background-color: #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0369a1;
            font-weight: 500;
            flex-shrink: 0;
        }

        .customer-info {
            display: flex;
            flex-direction: column;
        }

        .customer-name {
            font-weight: 500;
            color: #1e293b;
        }

        .customer-phone {
            color: #64748b;
            font-size: 0.8125rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-completed {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background-color: #fef9c3;
            color: #854d0e;
        }

        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .price-cell {
            font-weight: 500;
            text-align: right;
        }

        .action-cell {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.2s ease;
        }

        .detail-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .detail-btn:hover {
            background-color: #2563eb;
        }

        .print-btn {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .print-btn:hover {
            background-color: #e2e8f0;
        }

        /* History Section */
        .history-section {
            margin-top: 2rem;
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .history-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            color: #1e293b;
        }

        .history-container {
            max-height: 400px;
            overflow-y: auto;
            margin-top: 1rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.25rem;
            color: #94a3b8;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .modal-close:hover {
            color: #64748b;
        }

        .service-box {
            background-color: #f8fafc;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin: 0.5rem 0;
            border: 1px solid #e2e8f0;
        }

        .button-group {
            margin-top: 1.5rem;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn-green,
        .btn-gray {
            padding: 0.625rem 1rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.2s ease;
        }

        .btn-green {
            background-color: #22c55e;
            color: white;
        }

        .btn-green:hover {
            background-color: #16a34a;
        }

        .btn-gray {
            background-color: #f1f5f9;
            color: #334155;
        }

        .btn-gray:hover {
            background-color: #e2e8f0;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            background-color: white;
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.875rem;
        }

        .pagination-controls {
            display: flex;
            gap: 0.25rem;
        }

        .page-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            color: #64748b;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .page-btn:hover {
            background-color: #f1f5f9;
        }

        .page-btn.active {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Dropdown untuk batasan data */
        .perpage-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .perpage-label {
            font-size: 0.875rem;
            color: #64748b;
            white-space: nowrap;
        }

        .perpage-dropdown {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            background-color: white;
            color: #334155;
            cursor: pointer;
        }

        .perpage-dropdown:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar Start -->
    @include('components.sidebar_kasir')
    <!-- Sidebar End -->

    <!-- Main Content Start -->
    <div class="ml-0 lg:ml-64 min-h-screen p-6">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div
                class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
                <div class="flex items-center gap-4">
                    <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                        <i class="bi bi-list"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-slate-800">Riwayat Order Kasir Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
                </div>
                <div class="relative">
                    {{-- ...existing code... --}}
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
                    {{-- ...existing code... --}}
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

            <div class="pt-20 lg:pt-6 mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Riwayat Order</h1>
                    <p class="text-gray-600 mt-1">Daftar semua riwayat order</p>
                </div>
                <div class="flex gap-3 flex-wrap">
                    <form action="{{ route('kasir.riwayatorder.index') }}" method="GET"
                        class="flex gap-3 flex-wrap items-center">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Cari order..."
                                class="w-full md:w-64 pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ request('search') }}">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>

                        <!-- Dropdown untuk memilih jumlah data per halaman -->
                        <div class="perpage-selector">
                            <span class="perpage-label">Tampilkan:</span>
                            <select name="perPage" id="perPage" class="perpage-dropdown"
                                onchange="this.form.submit()">
                                <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ request('perPage', 10) == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ request('perPage', 10) == 20 ? 'selected' : '' }}>20</option>
                                <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25</option>
                                <option value="30" {{ request('perPage', 10) == 30 ? 'selected' : '' }}>30</option>
                                <option value="all" {{ request('perPage', 10) == 'all' ? 'selected' : '' }}>All
                                </option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Riwayat Order Selesai -->
            <div class="history-section">
                <h3 class="history-title">Riwayat Order Selesai</h3>
                <div class="history-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class="w-12">No</th>
                                <th>Pelanggan</th>
                                <th>Tanggal</th>
                                <th>Layanan</th>
                                <th class="text-right">Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = ($historyOrders->currentPage() - 1) * $historyOrders->perPage() + 1;
                            @endphp
                            @foreach ($historyOrders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td>{{ $no++ }}</td>
                                    <td>
                                        <div class="customer-cell">
                                            <div class="customer-avatar">
                                                {{ strtoupper(substr($order->pelanggan->nama, 0, 1)) }}
                                            </div>
                                            <div class="customer-info">
                                                <span class="customer-name">{{ $order->pelanggan->nama }}</span>
                                                <span
                                                    class="customer-phone">{{ $order->pelanggan->no_handphone }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                                    <td>
                                        @php
                                            $layanan = json_decode($order->layanan, true);
                                            echo implode(', ', array_column($layanan, 'nama'));
                                        @endphp
                                    </td>
                                    <td class="price-cell">Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td><span class="status-badge status-completed">{{ $order->status }}</span></td>
                                    <td>
                                        <div class="action-cell">
                                            <button class="action-btn detail-btn"
                                                data-order="{{ json_encode($order) }}">
                                                <i class="fas fa-eye"></i>
                                                <span class="hidden sm:inline">Detail</span>
                                            </button>
                                            <button class="action-btn print-btn"
                                                onclick="window.open('{{ route('kasir.riwayatorder.cetak', $order->id) }}', '_blank')">
                                                <i class="fas fa-print"></i>
                                                <span class="hidden sm:inline">Cetak</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="pagination flex flex-col md:flex-row md:justify-between md:items-center gap-2 mt-4">
                    <div class="pagination-info text-sm text-gray-600 mb-2 md:mb-0">
                        Menampilkan <span class="font-medium">{{ $historyOrders->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $historyOrders->lastItem() }}</span>
                        dari <span class="font-medium">{{ $historyOrders->total() }}</span> hasil
                    </div>
                    <nav class="pagination-controls flex gap-1" aria-label="Pagination">
                        {{-- Previous Page Link --}}
                        @if ($historyOrders->onFirstPage())
                            <span class="page-btn disabled" aria-disabled="true"><i
                                    class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $historyOrders->previousPageUrl() }}&perPage={{ request('perPage', 10) }}"
                                class="page-btn" aria-label="Sebelumnya">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $current = $historyOrders->currentPage();
                            $last = $historyOrders->lastPage();
                            $start = max($current - 2, 1);
                            $end = min($current + 2, $last);
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <a href="{{ $historyOrders->url(1) }}&perPage={{ request('perPage', 10) }}"
                                class="page-btn">1</a>
                            @if ($start > 2)
                                <span class="page-btn disabled">...</span>
                            @endif
                        @endif

                        {{-- Page Number Links --}}
                        @for ($i = $start; $i <= $end; $i++)
                            @if ($i == $current)
                                <span class="page-btn active" aria-current="page">{{ $i }}</span>
                            @else
                                <a href="{{ $historyOrders->url($i) }}&perPage={{ request('perPage', 10) }}"
                                    class="page-btn">{{ $i }}</a>
                            @endif
                        @endfor

                        {{-- Last Page Link --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <span class="page-btn disabled">...</span>
                            @endif
                            <a href="{{ $historyOrders->url($last) }}&perPage={{ request('perPage', 10) }}"
                                class="page-btn">{{ $last }}</a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($historyOrders->hasMorePages())
                            <a href="{{ $historyOrders->nextPageUrl() }}&perPage={{ request('perPage', 10) }}"
                                class="page-btn" aria-label="Berikutnya">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        @else
                            <span class="page-btn disabled" aria-disabled="true">
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content End -->
<div class="pb-20"></div>
    <!-- Modal Detail Order -->
    <div class="modal" id="detailModal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h4 class="text-xl font-bold mb-4">Detail Order</h4>
            <div id="detailContent"></div>
        </div>
    </div>

    <script>
        // Format nomor telepon
        function formatPhoneNumber(phoneNumber) {
            const cleaned = ('' + phoneNumber).replace(/\D/g, '');
            if (cleaned.length === 12 && cleaned.startsWith('628')) {
                return cleaned.replace(/(\d{3})(\d{3})(\d{4})(\d{2})/, '+$1 $2-$3-$4');
            } else if (cleaned.length === 11 && cleaned.startsWith('08')) {
                return cleaned.replace(/(\d{2})(\d{3})(\d{4})(\d{2})/, '+62 $1 $2-$3-$4');
            } else if (cleaned.length === 10 && cleaned.startsWith('8')) {
                return cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '+62 $1-$2-$3');
            }
            return phoneNumber;
        }

        // Fungsi untuk membuat dan membuka pesan WhatsApp
        function openWhatsApp(orderData, alamatLengkap) {
            const cleanedPhone = ('' + orderData.pelanggan.no_handphone).replace(/\D/g, '');
            let whatsappNumber = cleanedPhone.startsWith('0') ? '62' + cleanedPhone.substring(1) : cleanedPhone;

            const layanan = JSON.parse(orderData.layanan);
            const waktuOrder = new Date(orderData.created_at).toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            const layananMessages = layanan.map(item => {
                return `*Nama Layanan:* ${item.nama}
*Kategori:* Satuan
*Harga:* Rp ${parseInt(item.harga).toLocaleString('id-ID')}
*Jumlah:* ${item.kuantitas}
*Subtotal:* Rp ${(item.harga * item.kuantitas).toLocaleString('id-ID')}`;
            });

            const layananMessage = layananMessages.join('\n----------------\n');

            const message = `*📌 Detail Pelanggan*
*Nama:* ${orderData.pelanggan.nama}
*No Handphone:* ${formatPhoneNumber(orderData.pelanggan.no_handphone)}
*Alamat:* ${alamatLengkap}
*Metode Pengambilan:* ${orderData.metode_pengambilan}
*Waktu Pembayaran:* ${orderData.waktu_pembayaran}

*📌 Detail Layanan*
${layananMessage}

*📌 Rincian Pembayaran*
*Subtotal:* Rp ${parseInt(orderData.total_harga).toLocaleString('id-ID')}
*Ongkir:* Rp 0
*Total Harga:* Rp ${parseInt(orderData.total_harga).toLocaleString('id-ID')}
*Uang Diberikan:* Rp 0
*Kembalian:* Rp 0

*📌 Status Order*
${orderData.status}

*📌 Metode Pembayaran*
${orderData.metode_pembayaran}

*📌 Waktu Order*
${waktuOrder}`;

            const encodedMessage = encodeURIComponent(message.trim());
            window.open(`https://wa.me/${whatsappNumber}?text=${encodedMessage}`, '_blank');
        }

        // Event listener tombol detail
        document.querySelectorAll('.detail-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const orderData = JSON.parse(btn.dataset.order);
                const layanan = JSON.parse(orderData.layanan);

                let layananHtml = '';
                layanan.forEach(item => {
                    layananHtml += `
                    <div class="service-box">
                        <strong>${item.nama}</strong><br/>
                        Harga: Rp ${parseInt(item.harga).toLocaleString('id-ID')}<br/>
                        Jumlah: ${item.kuantitas}<br/>
                        Subtotal: Rp ${(item.harga * item.kuantitas).toLocaleString('id-ID')}
                    </div>
                `;
                });

                // Gabungkan seluruh data alamat dari pelanggan
                let alamatLengkap = '-';
                if (orderData.pelanggan) {
                    const provinsi = orderData.pelanggan.provinsi ?? '';
                    const kota = orderData.pelanggan.kota ?? '';
                    const kecamatan = orderData.pelanggan.kecamatan ?? '';
                    const kodepos = orderData.pelanggan.kodepos ?? '';
                    const detail_alamat = orderData.pelanggan.detail_alamat ?? '';
                    alamatLengkap = `${detail_alamat}, ${kecamatan}, ${kota}, ${provinsi}, ${kodepos}`
                        .replace(/^, |, $/g, '').replace(/(, ){2,}/g, ', ');
                }

                const formattedPhone = formatPhoneNumber(orderData.pelanggan.no_handphone);

                detailContent.innerHTML = `
                <div class="space-y-3">
                    <p><strong>Nama:</strong> ${orderData.pelanggan.nama}</p>
                    <p><strong>No HP:</strong> ${formattedPhone}</p>
                    <p><strong>Alamat:</strong> ${alamatLengkap}</p>
                    <p><strong>Pengambilan:</strong> ${orderData.metode_pengambilan}</p>
                    <p><strong>Pembayaran:</strong> ${orderData.metode_pembayaran}</p>
                    <p><strong>Waktu Order:</strong> ${new Date(orderData.created_at).toLocaleString('id-ID', { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                    <p><strong>Waktu Selesai:</strong> ${new Date(orderData.updated_at).toLocaleString('id-ID', { year: 'numeric', month: 'numeric', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</p>
                    <div class="mt-4">
                        <h5 class="font-semibold text-gray-700">Detail Layanan:</h5>
                        <div class="services-container" style="max-height:200px;overflow-y:auto;">
                            ${layananHtml}
                        </div>
                    </div>
                    <p class="text-xl font-bold mt-4 text-right">Total: Rp ${parseInt(orderData.total_harga).toLocaleString('id-ID')}</p>
                </div>
                <div class="button-group">
                    <button class="btn-green" id="whatsappBtn"><i class="bi bi-whatsapp"></i> WhatsApp</button>
                    <a href="http://maps.google.com/?q=${encodeURIComponent(alamatLengkap)}" class="btn-gray" target="_blank"><i class="bi bi-geo-alt-fill"></i> Buka Maps</a>
                </div>
            `;
                modal.style.display = "flex";

                document.getElementById('whatsappBtn').addEventListener('click', () => {
                    openWhatsApp(orderData, alamatLengkap);
                });
            });
        });

        // Fungsi close modal
        function closeModal() {
            modal.style.display = "none";
        }

        window.onclick = function(e) {
            if (e.target === modal) closeModal();
        }

        const modal = document.getElementById('detailModal');
        const detailContent = document.getElementById('detailContent');

        const searchInput = document.querySelector('input[name="search"]');
        const orderTableRows = document.querySelectorAll('.order-table tbody tr');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                orderTableRows.forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }

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

        // Simpan nilai perPage di localStorage untuk preferensi pengguna
        document.addEventListener('DOMContentLoaded', function() {
            const perPageSelect = document.getElementById('perPage');
            const savedPerPage = localStorage.getItem('perPage');

            if (savedPerPage) {
                perPageSelect.value = savedPerPage;
            }

            perPageSelect.addEventListener('change', function() {
                localStorage.setItem('perPage', this.value);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
