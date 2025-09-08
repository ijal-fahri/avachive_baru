<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Daftar Pelanggan</title>
    <script src="https://kit.fontawesome.com/0948e65078.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        .modal-content {
            max-height: 80vh;
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

        /* Responsive Table (Card View) Styling */
        @media (max-width: 768px) {
            .responsive-table thead {
                display: none;
            }

            .responsive-table tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.75rem;
                padding: 1rem;
                background-color: white;
                box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            }

            .responsive-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid #f1f5f9;
                text-align: right;
            }

            .responsive-table td:last-child {
                border-bottom: none;
                padding-top: 1rem;
            }

            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                text-align: left;
                padding-right: 1rem;
                color: #475569;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
                justify-content: flex-end;
            }
        }

        /* Styling untuk tabel seperti kodingan pertama */
        .table-container {
            background-color: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-header {
            background-color: #f8fafc;
            display: table-header-group;
        }

        .table-header th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table-header th:first-child {
            border-top-left-radius: 0.75rem;
        }

        .table-header th:last-child {
            border-top-right-radius: 0.75rem;
        }

        .table-row {
            background-color: white;
            transition: background-color 0.2s;
        }

        .table-row:hover {
            background-color: #f8fafc;
        }

        .table-row td {
            padding: 1rem;
            color: #334155;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-row:last-child td {
            border-bottom: none;
        }

        .table-row td:first-child {
            border-bottom-left-radius: 0.75rem;
        }

        .table-row td:last-child {
            border-bottom-right-radius: 0.75rem;
        }

        /* Button styling seperti kodingan pertama */
        .btn-edit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            background-color: #f97316;
            color: white;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .btn-edit:hover {
            background-color: #ea580c;
        }

        .btn-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            background-color: #dc2626;
            color: white;
            border-radius: 0.375rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s;
        }

        .btn-delete:hover {
            background-color: #b91c1c;
        }

        .btn-detail {
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

        .btn-detail:hover {
            background-color: #2563eb;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .user-avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            background-color: #dbeafe;
            border-radius: 9999px;
            font-weight: 500;
            color: #1d4ed8;
        }

        /* Pagination Styles */
        .pagination {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-top: 1px solid #e2e8f0;
            background-color: white;
        }

        @media (min-width: 768px) {
            .pagination {
                flex-direction: row;
            }
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        @media (min-width: 768px) {
            .pagination-info {
                margin-bottom: 0;
            }
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
            font-size: 0.875rem;
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
        }

        .perpage-label {
            font-size: 0.875rem;
            color: #64748b;
            white-space: nowrap;
        }

        .perpage-dropdown {
            padding: 0.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            background-color: white;
            color: #334155;
            cursor: pointer;
            min-width: 80px;
        }

        .perpage-dropdown:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Untuk tampilan mobile */
        @media (max-width: 640px) {
            .perpage-selector {
                width: 100%;
                justify-content: space-between;
            }

            .perpage-dropdown {
                flex-grow: 1;
                margin-left: 0.5rem;
            }
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
                <h1 class="text-lg font-semibold text-slate-800">Daftar Pelanggan</h1>
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

        <div class="pt-20 lg:pt-6 flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Daftar Pelanggan</h1>
                <p class="text-gray-600 mt-2">Manajemen data pelanggan laundry</p>
            </div>
            <button id="openModal"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition">
                <i class="fas fa-plus mr-2"></i> Tambah Pelanggan
            </button>
        </div>

        <div class="bg-white rounded-xl shadow-md p-4 mb-6">
            <form action="{{ route('pelanggan.index') }}" method="GET">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="relative flex-grow">
                        <input type="text" name="search" placeholder="Cari pelanggan..."
                            class="w-full pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition whitespace-nowrap">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <!-- Dropdown untuk memilih jumlah data per halaman -->
                        <div class="perpage-selector flex items-center">
                            <span class="perpage-label mr-2 text-sm text-gray-600">Tampilkan:</span>
                            <select name="perPage" id="perPage"
                                class="perpage-dropdown border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                onchange="this.form.submit()">
                                <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="15" {{ ($perPage ?? 10) == 15 ? 'selected' : '' }}>15</option>
                                <option value="20" {{ ($perPage ?? 10) == 20 ? 'selected' : '' }}>20</option>
                                <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                                <option value="30" {{ ($perPage ?? 10) == 30 ? 'selected' : '' }}>30</option>
                                <option value="all" {{ ($perPage ?? 10) == 'all' ? 'selected' : '' }}>All</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="table-container">
            <table class="w-full responsive-table">
                <thead class="table-header hidden md:table-header-group">
                    <tr>
                        <th class="py-3 px-4 w-12 text-left font-semibold text-slate-600 rounded-l-lg">No</th>
                        <th class="py-3 px-4 text-left font-semibold text-slate-600">Nama Pelanggan</th>
                        <th class="py-3 px-4 text-left font-semibold text-slate-600">Nomor Telepon</th>
                        <th class="py-3 px-4 text-left font-semibold text-slate-600">Alamat</th>
                        <th class="py-3 px-4 text-left font-semibold text-slate-600 rounded-r-lg w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelanggans as $pelanggan)
                        <tr class="table-row">
                            <td data-label="No" class="py-5 px-4 rounded-l-lg">
                                {{ ($pelanggans->currentPage() - 1) * $pelanggans->perPage() + $loop->iteration }}</td>
                            <td data-label="Nama Pelanggan" class="py-5 px-4 font-semibold">
                                <div class="flex items-center">
                                    <div class="user-avatar mr-3">
                                        {{ substr($pelanggan->nama, 0, 1) }}
                                    </div>
                                    <div>{{ $pelanggan->nama }}</div>
                                </div>
                            </td>
                            <td data-label="Nomor Telepon" class="py-5 px-4">{{ $pelanggan->no_handphone }}</td>
                            <td data-label="Alamat" class="py-5 px-4">{{ $pelanggan->kecamatan }}</td>
                            <td data-label="Aksi" class="py-5 px-4 rounded-r-lg">
                                <div class="action-buttons flex items-center gap-2">
                                    <button
                                        class="btn-detail detail-btn flex items-center gap-2 px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition"
                                        data-nama="{{ $pelanggan->nama }}" data-phone="{{ $pelanggan->no_handphone }}"
                                        data-provinsi="{{ $pelanggan->provinsi }}" data-kota="{{ $pelanggan->kota }}"
                                        data-kecamatan="{{ $pelanggan->kecamatan }}"
                                        data-desa="{{ $pelanggan->desa }}" data-kodepos="{{ $pelanggan->kodepos }}"
                                        data-alamat="{{ $pelanggan->detail_alamat }}">
                                        <i class="fas fa-eye"></i>
                                        <span class="hidden sm:inline">Detail</span>
                                    </button>

                                    <button
                                        class="btn-edit openEditModal flex items-center gap-2 px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md transition"
                                        data-id="{{ $pelanggan->id }}">
                                        <i class="fas fa-edit"></i>
                                        <span class="hidden sm:inline">Edit</span>
                                    </button>

                                    <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST"
                                        class="delete-pelanggan-form inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn-delete flex items-center gap-2 px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md transition">
                                            <i class="fas fa-trash-alt"></i>
                                            <span class="hidden sm:inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="table-row">
                            <td colspan="5" class="text-center py-8 text-slate-500">Tidak ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Section -->
            <div class="pagination flex flex-col md:flex-row md:justify-between md:items-center gap-2 mt-4">
                <div class="pagination-info text-sm text-gray-600 mb-2 md:mb-0">
                    Menampilkan <span class="font-medium">{{ $pelanggans->firstItem() }}</span>
                    sampai <span class="font-medium">{{ $pelanggans->lastItem() }}</span>
                    dari <span class="font-medium">{{ $pelanggans->total() }}</span> hasil
                </div>

                <nav class="pagination-controls flex gap-1" aria-label="Pagination">
                    {{-- Previous Page Link --}}
                    @if ($pelanggans->onFirstPage())
                        <span class="page-btn disabled" aria-disabled="true"><i
                                class="bi bi-chevron-left"></i></span>
                    @else
                        <a href="{{ $pelanggans->previousPageUrl() }}&perPage={{ request('perPage', 10) }}"
                            class="page-btn" aria-label="Sebelumnya">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $current = $pelanggans->currentPage();
                        $last = $pelanggans->lastPage();
                        $start = max($current - 2, 1);
                        $end = min($current + 2, $last);
                    @endphp

                    {{-- First Page Link --}}
                    @if ($start > 1)
                        <a href="{{ $pelanggans->url(1) }}&perPage={{ request('perPage', 10) }}"
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
                            <a href="{{ $pelanggans->url($i) }}&perPage={{ request('perPage', 10) }}"
                                class="page-btn">{{ $i }}</a>
                        @endif
                    @endfor

                    {{-- Last Page Link --}}
                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <span class="page-btn disabled">...</span>
                        @endif
                        <a href="{{ $pelanggans->url($last) }}&perPage={{ request('perPage', 10) }}"
                            class="page-btn">{{ $last }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($pelanggans->hasMorePages())
                        <a href="{{ $pelanggans->nextPageUrl() }}&perPage={{ request('perPage', 10) }}"
                            class="page-btn" aria-label="Berikutnya">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-btn disabled" aria-disabled="true"><i
                                class="bi bi-chevron-right"></i></span>
                    @endif
                </nav>
            </div>

        </div>
    </div>

    <div id="pelangganModal"
        class="hidden fixed inset-0 z-50 flex items-start justify-center pt-10 bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 modal-content">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Tambah Pelanggan</h2>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700"><i
                        class="fas fa-times"></i></button>
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
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="no_handphone" class="block text-sm font-medium text-gray-700 mb-1">No.
                            Handphone</label>
                        <input type="tel" name="no_handphone" id="no_handphone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <select id="provinsi" name="provinsi_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kota"
                            class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                        <select id="kota" name="kota_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" required>
                            <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <select id="kecamatan" name="kecamatan_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="desa"
                            class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                        <select id="desa" name="desa_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="kodepos" class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                        <input type="text" name="kodepos" id="kodepos"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-6">
                        <label for="detail_alamat" class="block text-sm font-medium text-gray-700 mb-1">Detail
                            Alamat</label>
                        <textarea name="detail_alamat" id="detail_alamat" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelBtn" class="px-4 py-2 border rounded-md">Kembali</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan
                            Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editPelangganModal"
        class="hidden fixed inset-0 z-50 flex items-start justify-center pt-10 bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 modal-content">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Edit Pelanggan</h2>
                <button id="closeEditModal" class="text-gray-500 hover:text-gray-700"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="p-6">
                <form id="formEditPelanggan" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="provinsi" id="edit_provinsi_nama">
                    <input type="hidden" name="kota" id="edit_kota_nama">
                    <input type="hidden" name="kecamatan" id="edit_kecamatan_nama">
                    <input type="hidden" name="desa" id="edit_desa_nama">

                    <div class="mb-4">
                        <label for="edit_nama" class="block text-sm font-medium text-gray-700 mb-1">Nama
                            Pelanggan</label>
                        <input type="text" name="nama" id="edit_nama"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_no_handphone" class="block text-sm font-medium text-gray-700 mb-1">No.
                            Handphone</label>
                        <input type="tel" name="no_handphone" id="edit_no_handphone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_provinsi"
                            class="block text-sm font-medium text-gray-700 mb-1">Provinsi</label>
                        <select id="edit_provinsi" name="provinsi_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit_kota"
                            class="block text-sm font-medium text-gray-700 mb-1">Kota/Kabupaten</label>
                        <select id="edit_kota" name="kota_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" required>
                            <option value="">Pilih Kota/Kabupaten</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit_kecamatan"
                            class="block text-sm font-medium text-gray-700 mb-1">Kecamatan</label>
                        <select id="edit_kecamatan" name="kecamatan_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit_desa"
                            class="block text-sm font-medium text-gray-700 mb-1">Desa/Kelurahan</label>
                        <select id="edit_desa" name="desa_id" disabled
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100">
                            <option value="">Pilih Desa/Kelurahan</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="edit_kodepos" class="block text-sm font-medium text-gray-700 mb-1">Kode
                            Pos</label>
                        <input type="text" name="kodepos" id="edit_kodepos"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div class="mb-6">
                        <label for="edit_detail_alamat" class="block text-sm font-medium text-gray-700 mb-1">Detail
                            Alamat</label>
                        <textarea name="detail_alamat" id="edit_detail_alamat" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelEditBtn"
                            class="px-4 py-2 border rounded-md">Kembali</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Pelanggan -->
    <div id="detailPelangganModal"
        class="hidden fixed inset-0 z-50 flex items-start justify-center pt-10 bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md mx-4 modal-content">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Detail Pelanggan</h2>
                <button id="closeDetailModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Nama Pelanggan</p>
                            <p id="detail-nama" class="text-gray-900 font-medium"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">No. Handphone</p>
                            <p id="detail-phone" class="text-gray-900"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Provinsi</p>
                            <p id="detail-provinsi" class="text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kota/Kabupaten</p>
                            <p id="detail-kota" class="text-gray-900"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kecamatan</p>
                            <p id="detail-kecamatan" class="text-gray-900"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Desa/Kelurahan</p>
                            <p id="detail-desa" class="text-gray-900"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Kode Pos</p>
                            <p id="detail-kodepos" class="text-gray-900"></p>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-500">Detail Alamat</p>
                        <p id="detail-alamat" class="text-gray-900 mt-1 p-3 bg-gray-100 rounded-lg"></p>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button id="closeDetailBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiBaseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

            // Fungsi untuk mengambil data dan mengisi dropdown
            async function populateSelect(url, selectElement, defaultText, selectedId = null) {
                try {
                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();

                    selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                    data.forEach(item => {
                        const option = new Option(item.name, item.id);
                        option.selected = (item.id == selectedId);
                        selectElement.add(option);
                    });
                    if (selectedId) {
                        selectElement.disabled = false;
                        selectElement.classList.remove('bg-gray-100');
                    }
                } catch (error) {
                    console.error(`Error loading data for ${selectElement.id}:`, error);
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

            // --- LOGIKA MODAL TAMBAH ---
            const addModal = document.getElementById('pelangganModal');
            const addProvinsi = document.getElementById('provinsi');
            const addHiddenInputs = {
                provinsi: document.getElementById('provinsi_nama'),
                kota: document.getElementById('kota_nama'),
                kecamatan: document.getElementById('kecamatan_nama'),
                desa: document.getElementById('desa_nama')
            };
            document.getElementById('openModal').addEventListener('click', () => {
                populateSelect(`${apiBaseUrl}/provinces.json`, addProvinsi, 'Pilih Provinsi');
                addModal.classList.remove('hidden');
            });
            setupDropdownListeners(addProvinsi, document.getElementById('kota'), document.getElementById(
                'kecamatan'), document.getElementById('desa'), addHiddenInputs);

            // --- LOGIKA MODAL EDIT ---
            const editModal = document.getElementById('editPelangganModal');
            const editProvinsi = document.getElementById('edit_provinsi');
            const editHiddenInputs = {
                provinsi: document.getElementById('edit_provinsi_nama'),
                kota: document.getElementById('edit_kota_nama'),
                kecamatan: document.getElementById('edit_kecamatan_nama'),
                desa: document.getElementById('edit_desa_nama')
            };
            setupDropdownListeners(editProvinsi, document.getElementById('edit_kota'), document.getElementById(
                'edit_kecamatan'), document.getElementById('edit_desa'), editHiddenInputs);

            document.querySelectorAll('.openEditModal').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const pelangganId = e.currentTarget.dataset.id;
                    try {
                        const response = await fetch(`/kasir/pelanggan/${pelangganId}/edit`);
                        const data = await response.json();

                        document.getElementById('formEditPelanggan').action =
                            `/kasir/pelanggan/${pelangganId}`;
                        document.getElementById('edit_nama').value = data.nama;
                        document.getElementById('edit_no_handphone').value = data.no_handphone;
                        document.getElementById('edit_kodepos').value = data.kodepos;
                        document.getElementById('edit_detail_alamat').value = data
                        .detail_alamat;

                        editHiddenInputs.provinsi.value = data.provinsi;
                        editHiddenInputs.kota.value = data.kota;
                        editHiddenInputs.kecamatan.value = data.kecamatan;
                        editHiddenInputs.desa.value = data.desa;

                        await populateSelect(`${apiBaseUrl}/provinces.json`, editProvinsi,
                            'Pilih Provinsi', data.provinsi_id);
                        await populateSelect(`${apiBaseUrl}/regencies/${data.provinsi_id}.json`,
                            document.getElementById('edit_kota'), 'Pilih Kota/Kabupaten',
                            data.kota_id);
                        await populateSelect(`${apiBaseUrl}/districts/${data.kota_id}.json`,
                            document.getElementById('edit_kecamatan'), 'Pilih Kecamatan',
                            data.kecamatan_id);
                        await populateSelect(`${apiBaseUrl}/villages/${data.kecamatan_id}.json`,
                            document.getElementById('edit_desa'), 'Pilih Desa/Kelurahan',
                            data.desa_id);

                        editModal.classList.remove('hidden');
                    } catch (error) {
                        console.error('Gagal mengambil data pelanggan:', error);
                    }
                });
            });

            // --- LOGIKA MODAL DETAIL ---
            const detailModal = document.getElementById('detailPelangganModal');
            const closeDetailBtn = document.getElementById('closeDetailBtn');
            const closeDetailModalBtn = document.getElementById('closeDetailModal');

            // Open detail modal
            document.querySelectorAll('.detail-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    // Set data to modal
                    document.getElementById('detail-nama').textContent = btn.dataset.nama;
                    document.getElementById('detail-phone').textContent = btn.dataset.phone;
                    document.getElementById('detail-provinsi').textContent = btn.dataset.provinsi ||
                        '-';
                    document.getElementById('detail-kota').textContent = btn.dataset.kota || '-';
                    document.getElementById('detail-kecamatan').textContent = btn.dataset
                        .kecamatan || '-';
                    document.getElementById('detail-desa').textContent = btn.dataset.desa || '-';
                    document.getElementById('detail-kodepos').textContent = btn.dataset.kodepos ||
                        '-';
                    document.getElementById('detail-alamat').textContent = btn.dataset.alamat ||
                    '-';

                    // Show modal
                    detailModal.classList.remove('hidden');
                });
            });

            // Close detail modal
            const closeDetailModal = () => {
                detailModal.classList.add('hidden');
            };

            closeDetailBtn.addEventListener('click', closeDetailModal);
            closeDetailModalBtn.addEventListener('click', closeDetailModal);

            // Close when clicking outside modal
            window.addEventListener('click', (e) => {
                if (e.target === detailModal) {
                    closeDetailModal();
                }
            });

            // --- Pengaturan Umum Modal ---
            const closeButtons = document.querySelectorAll(
                '#closeModal, #cancelBtn, #closeEditModal, #cancelEditBtn');
            closeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    addModal.classList.add('hidden');
                    editModal.classList.add('hidden');
                    document.getElementById('formPelanggan').reset();
                    document.getElementById('formEditPelanggan').reset();
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            // SweetAlert untuk hapus pelanggan
            document.querySelectorAll('.delete-pelanggan-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: 'Data pelanggan yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
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
</body>

</html>
