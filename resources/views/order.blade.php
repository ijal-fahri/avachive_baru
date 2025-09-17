<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Pemasukan Laundry</title>

    <meta name="theme-color" content="#14b8a6">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* FONT & SCROLLBAR DASAR */
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; /* slate-100 */ }
        ::-webkit-scrollbar-thumb { background: #14b8a6; /* teal-500 */ border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #0d9488; /* teal-600 */ }
        .sidebar-mobile-open { transform: translateX(0) !important; }

        /* STYLING TERPUSAT UNTUK SEMUA INPUT & SELECT */
        .form-input, 
        #orderTable_wrapper .dt-search input, 
        #orderTable_wrapper .dt-length select { width: 100%; background-color: white !important; color: #1e293b !important; /* slate-800 */ border: 1px solid #cbd5e1 !important; /* slate-300 */ border-radius: 0.5rem !important; padding: 0.6rem 1rem !important; transition: all 0.2s ease-in-out; outline: none; -webkit-appearance: none; -moz-appearance: none; appearance: none; }
        .form-input:focus,
        #orderTable_wrapper .dt-search input:focus, 
        #orderTable_wrapper .dt-length select:focus { border-color: #14b8a6 !important; /* teal-500 */ box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) !important; }
        select.form-input,
        #orderTable_wrapper .dt-length select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem !important; }
        #orderTable_wrapper .dt-search input { border-radius: 9999px !important; }
        #orderTable_wrapper .dt-length select { width: auto; }
        @media (min-width: 768px) { #orderTable_wrapper .dt-search input { min-width: 250px; width: auto; } }

        /* STYLING LAYOUT DATATABLES */
        #orderTable_wrapper .dt-controls-row,
        #orderTable_wrapper .dt-bottom-row { display: flex; flex-direction: column; gap: 1rem; padding: 0.5rem 0.25rem; }
        #orderTable_wrapper .dt-controls-row { margin-bottom: 1.5rem; }
        #orderTable_wrapper .dt-bottom-row { margin-top: 1.5rem; }
        @media (min-width: 768px) { #orderTable_wrapper .dt-controls-row, #orderTable_wrapper .dt-bottom-row { flex-direction: row; justify-content: space-between; align-items: center; } }

        /* STYLING TABEL UTAMA */
        #orderTable { border-collapse: collapse; }
        #orderTable thead th { font-weight: 600; text-align: left; padding: 1rem 1.25rem; color: #475569; /* slate-600 */ background-color: #f8fafc; /* slate-50 */ border-bottom: 2px solid #e2e8f0; /* slate-200 */ }
        #orderTable tbody td { padding: 1rem 1.25rem; color: #334155; /* slate-700 */ vertical-align: middle; border-bottom: 1px solid #f1f5f9; /* slate-100 */ }
        #orderTable tbody tr:last-child td { border-bottom: none; }
        #orderTable tbody tr:hover { background-color: #f8fafc; /* slate-50 */ }
        #orderTable tfoot tr { border-top: 2px solid #e2e8f0; }

        /* STYLING ACCORDION/CHILD ROW */
        td.details-control { cursor: pointer; position: relative; width: 20px; padding-left: 25px !important; }
        td.details-control::before { content: '+'; position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 1.2rem; font-weight: bold; color: #14b8a6; /* teal-500 */ transition: transform 0.2s ease-in-out; }
        tr.dt-hasChild td.details-control::before { content: '−'; transform: translateY(-50%) rotate(180deg); }
        .child-table-container { padding: 1rem; background-color: #f1f5f9; /* slate-100 */ }
        .child-table { font-size: 0.8rem; width: 100%; border-collapse: collapse; }
        .child-table th, .child-table td { padding: 0.75rem; border-bottom: 1px solid #e2e8f0; }
        .child-table th { font-weight: 600; color: #475569; background-color: #f8fafc; text-align: left;}
        .child-table tr:last-child td { border-bottom: none; }

        /* STYLING PAGINASI & INFO BAWAH */
        #orderTable_wrapper .dt-info { color: #64748b; font-size: 0.875rem; }
        #orderTable_wrapper .dt-paging .dt-paging-button { border: 1px solid #cbd5e1 !important; /* slate-300 */ transition: all 0.15s ease-in-out !important; font-weight: 600 !important; border-radius: 0.5rem !important; margin: 0 3px !important; padding: 0.5em 1em !important; background: #fff !important; color: #334155 !important; /* slate-700 */ }
        #orderTable_wrapper .dt-paging .dt-paging-button:not(.disabled):hover { background-color: #f1f5f9 !important; /* slate-100 */ border-color: #94a3b8 !important; /* slate-400 */ }
        #orderTable_wrapper .dt-paging .dt-paging-button.current { background-color: #14b8a6 !important; /* teal-500 */ color: #ffffff !important; border-color: #14b8a6 !important; /* teal-500 */ }
        #orderTable_wrapper .dt-paging .dt-paging-button.disabled { color: #94a3b8 !important; /* slate-400 */ background-color: #f8fafc !important; /* slate-50 */ }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased min-h-screen">
    <div class="relative flex h-screen overflow-hidden">
        <aside id="sidebar" class="w-64 bg-slate-900 text-slate-300 p-4 flex-col fixed inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 z-30 transition-transform duration-300 ease-in-out" aria-label="Sidebar Navigasi">
            <div class="mb-8 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Avachive" class="h-16 w-auto mx-auto mb-2">
                <h2 class="text-2xl font-bold text-teal-400">Avachive Admin</h2>
            </div>
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i class="bi bi-speedometer2 text-lg"></i><span>Dashboard</span></a>
                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i class="bi bi-list-check text-lg"></i><span>Data Layanan</span></a>
                <a href="{{ route('datauser') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i class="bi bi-people text-lg"></i><span>Data Karyawan</span></a>
                <a href="{{ route('dataorder') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors" aria-current="page"><i class="bi bi-printer text-lg"></i><span>Laporan</span></a>
            </nav>
        </aside>
        
        <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

        <main class="flex-1 overflow-y-auto">
            <div class="p-4 sm:p-6">
                
                <div class="sticky top-0 z-10 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700"><i class="bi bi-list"></i></button>
                        <h1 class="text-base sm:text-lg font-semibold text-slate-800">Laporan Pemasukan Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Pusat' }}</h1>
                    </div>
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                            <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                            <i class="bi bi-person-circle text-2xl text-slate-600"></i>
                        </button>
                        <div id="user-menu" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50 transition-all duration-300">
                            <a href="pengaturan" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i class="bi bi-person-circle"></i><span>Profile</span></a>
                            <div class="border-t border-slate-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="button" id="logout-button" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button>
                            </form>
                        </div>
                    </div>
                </div>
                </header>

                <section class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-8">
                    <div class="mb-8">
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-800">🗓️ Laporan Pemasukan</h3>
                        <p class="text-slate-500 mt-1">Ringkasan pemasukan bulanan berdasarkan order yang telah selesai.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 p-4 bg-slate-50 border border-slate-200 rounded-lg">
                        <div>
                            <label for="yearFilter" class="block text-sm font-medium mb-1 text-slate-600">Filter Tahun</label>
                            <select id="yearFilter" class="form-input" aria-label="Pilih tahun untuk filter" disabled>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                        <div>
                            <label for="monthFilter" class="block text-sm font-medium mb-1 text-slate-600">Filter Bulan</label>
                            <select id="monthFilter" class="form-input" aria-label="Pilih bulan untuk filter" disabled>
                                <option value="">Memuat...</option>
                            </select>
                        </div>
                        <div class="self-end">
                            <button id="resetFilter" class="w-full bg-slate-700 hover:bg-slate-800 text-white font-semibold text-sm rounded-lg px-4 py-2.5 transition duration-200 flex items-center justify-center gap-2">
                                <i class="bi bi-arrow-counterclockwise"></i><span>Reset Filter</span>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="orderTable" class="w-full text-sm" style="min-width: 700px;">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap"></th>
                                    <th class="whitespace-nowrap">Bulan & Tahun</th>
                                    <th class="whitespace-nowrap">Jumlah Order</th>
                                    <th class="whitespace-nowrap">Total Pemasukan</th>
                                    <th class="whitespace-nowrap">Rata-rata / Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                             <tfoot class="bg-slate-50 font-bold">
                                <tr>
                                    <th colspan="3" class="p-4 text-right text-slate-800 text-base">Total Pemasukan (Filter)</th>
                                    <th id="totalPemasukan" class="p-4 text-left text-teal-600 text-lg">Rp 0</th>
                                    <th class="hidden sm:table-cell"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>

    <script>
    $(document).ready(function() {
        // --- KONFIGURASI & URL ---
        const API_URL_FILTERS = '{{ route("laporan.filters") }}';
        const API_URL_DATA = '{{ route("laporan.data") }}';
        let table;

        // --- FUNGSI HELPERS ---
        const formatCurrency = (val) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val || 0);
        
        // --- INISIALISASI ---
        function initFilters() {
            const yearFilter = $('#yearFilter');
            const monthFilter = $('#monthFilter');
            yearFilter.prop('disabled', true);
            monthFilter.prop('disabled', true);
            $.ajax({
                url: API_URL_FILTERS,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    yearFilter.empty().append('<option value="">Semua Tahun</option>');
                    response.years.forEach(year => yearFilter.append(`<option value="${year}">${year}</option>`));
                    monthFilter.empty().append('<option value="">Semua Bulan</option>');
                    response.months.forEach(month => monthFilter.append(`<option value="${month.value}">${month.name}</option>`));
                    yearFilter.prop('disabled', false);
                    monthFilter.prop('disabled', false);
                },
                error: function() {
                    $('#yearFilter, #monthFilter').prop('disabled', true).html('<option value="">Gagal</option>');
                    Swal.fire('Error', 'Gagal memuat data filter dari server.', 'error');
                }
            });
        }

        function initDataTable() {
            table = $('#orderTable').DataTable({
                dom: '<"dt-controls-row"<"dt-length"l><"dt-search"f>>' + 't' + '<"dt-bottom-row"<"dt-info"i><"dt-paging"p>>',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: API_URL_DATA,
                    type: "POST",
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    data: d => {
                        d.year = $('#yearFilter').val();
                        d.month = $('#monthFilter').val();
                    },
                    dataSrc: json => {
                        $('#totalPemasukan').html(formatCurrency(json.totalPemasukanKeseluruhan || 0));
                        return json.data;
                    },
                    error: (xhr, error, thrown) => {
                        $('.dataTables_processing').hide();
                        $('#orderTable tbody').html(`<tr><td colspan="5" class="text-center p-10 text-red-500">Gagal memuat data. <br><small>${xhr.statusText || error}</small></td></tr>`);
                    }
                },
                columns: [
                    { className: 'details-control', orderable: false, data: null, defaultContent: '' },
                    { data: 'monthName', name: 'monthName', className: 'font-semibold text-slate-700' },
                    { data: 'orderCount', name: 'orderCount', render: d => `${d} Order` },
                    { data: 'totalRevenue', name: 'totalRevenue', render: data => formatCurrency(data) },
                    { 
                        data: null, 
                        orderable: false,
                        searchable: false,
                        render: (data, type, row) => formatCurrency(row.orderCount > 0 ? row.totalRevenue / row.orderCount : 0)
                    }
                ],
                order: [],
                language: {
                    search: "",
                    searchPlaceholder: "Cari data bulanan...",
                    lengthMenu: "Tampil _MENU_ entri",
                    emptyTable: `<div class="text-center p-10"><i class="bi bi-archive text-5xl text-slate-300 mb-4 block"></i><h4 class="font-semibold text-xl text-slate-700">Belum Ada Data</h4><p class="text-slate-500">Silakan pilih filter di atas untuk menampilkan laporan.</p></div>`,
                    zeroRecords: `<div class="text-center p-10"><i class="bi bi-search text-5xl text-slate-300 mb-4 block"></i><h4 class="font-semibold text-xl text-slate-700">Data Tidak Ditemukan</h4><p class="text-slate-500">Tidak ada hasil yang cocok dengan kata kunci pencarian Anda.</p></div>`,
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    infoEmpty: "Data tidak tersedia",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    paginate: { next: ">", previous: "<" },
                    processing: '<div class="flex items-center gap-2 text-slate-600"><svg class="animate-spin h-5 w-5 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Memuat Data...</span></div>',
                }
            });
        }

        function formatChildRow(data) {
            if (!data.details || data.details.length === 0) {
                return '<div class="p-4 text-center text-slate-500">Tidak ada detail transaksi untuk bulan ini.</div>';
            }
            let rows = data.details.map(d => `
                <tr>
                    <td>${new Date(d.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}</td>
                    <td>${d.customer || 'N/A'}</td>
                    <td>${d.service || 'N/A'}</td>
                    <td>${formatCurrency(d.total)}</td>
                </tr>
            `).join('');
            
            return `<div class="child-table-container">
                        <table class="child-table">
                            <thead><tr><th>Tanggal</th><th>Customer</th><th>Layanan</th><th>Total</th></tr></thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>`;
        }

        function attachEventListeners() {
            $('#yearFilter, #monthFilter').on('change', () => table.ajax.reload());
            $('#resetFilter').on('click', () => {
                $('#yearFilter, #monthFilter').val('');
                table.ajax.reload();
            });
            $('#orderTable tbody').on('click', 'td.details-control', function() {
                const tr = $(this).closest('tr');
                const row = table.row(tr);
                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('dt-hasChild');
                } else {
                    row.child(formatChildRow(row.data())).show();
                    tr.addClass('dt-hasChild');
                }
            });
        }
        
        // --- EKSEKUSI UTAMA & UI LOGIC ---
        initFilters();
        initDataTable();
        attachEventListeners();

        // UI Logic (Sidebar, User Menu, Logout - Tidak diubah)
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const logoutButton = document.getElementById('logout-button');
        hamburgerBtn.addEventListener('click', () => { sidebar.classList.toggle('sidebar-mobile-open'); overlay.classList.toggle('hidden'); });
        overlay.addEventListener('click', () => { sidebar.classList.remove('sidebar-mobile-open'); overlay.classList.add('hidden'); });
        userMenuButton.addEventListener('click', (e) => { e.stopPropagation(); userMenu.classList.toggle('hidden'); userMenuButton.setAttribute('aria-expanded', !userMenu.classList.contains('hidden')); });
        window.addEventListener('click', () => { if (!userMenu.classList.contains('hidden')) { userMenu.classList.add('hidden'); userMenuButton.setAttribute('aria-expanded', 'false'); } });
        logoutButton.addEventListener('click', (e) => { 
            e.preventDefault(); 
            Swal.fire({ title: 'Anda yakin ingin logout?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#14b8a6', cancelButtonColor: '#64748b', confirmButtonText: 'Ya, Logout', cancelButtonText: 'Batal' })
            .then((result) => { if (result.isConfirmed) { logoutButton.closest('form').submit(); } }); 
        });
    });
    </script>
</body>
</html>