<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Layanan - Admin Laundry</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <style>
        /* FONT & SCROLLBAR DASAR */
        body { font-family: 'Poppins', sans-serif; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #14b8a6; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #0d9488; }
        .sidebar-mobile-open { transform: translateX(0) !important; }

        /* STYLING TERPUSAT UNTUK INPUT & SELECT */
        .form-input, 
        #layananTable_wrapper .dt-search input, 
        #layananTable_wrapper .dt-length select { width: 100%; background-color: white !important; color: #1e293b !important; border: 1px solid #cbd5e1 !important; border-radius: 0.5rem !important; padding: 0.6rem 1rem !important; transition: all 0.2s ease-in-out; outline: none; -webkit-appearance: none; -moz-appearance: none; appearance: none; }
        .form-input:focus,
        #layananTable_wrapper .dt-search input:focus, 
        #layananTable_wrapper .dt-length select:focus { border-color: #14b8a6 !important; box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) !important; }
        select.form-input,
        #layananTable_wrapper .dt-length select { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position: right 0.5rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em; padding-right: 2.5rem !important; }
        #layananTable_wrapper .dt-search input { border-radius: 9999px !important; }
        #layananTable_wrapper .dt-length select { width: auto; }
        @media (min-width: 768px) { #layananTable_wrapper .dt-search input { min-width: 250px; width: auto; } }

        /* STYLING LAYOUT DATATABLES */
        #layananTable_wrapper .dt-controls-row,
        #layananTable_wrapper .dt-bottom-row { display: flex; flex-direction: column; gap: 1rem; padding: 0.5rem 0.25rem; }
        #layananTable_wrapper .dt-controls-row { margin-bottom: 1.5rem; }
        #layananTable_wrapper .dt-bottom-row { margin-top: 1.5rem; }
        @media (min-width: 768px) { #layananTable_wrapper .dt-controls-row, #layananTable_wrapper .dt-bottom-row { flex-direction: row; justify-content: space-between; align-items: center; } }

        /* STYLING TABEL UTAMA */
        #layananTable { border-collapse: collapse; }
        #layananTable thead th { font-weight: 600; text-align: left; padding: 1rem 1.25rem; color: #475569; background-color: #f8fafc; border-bottom: 2px solid #e2e8f0; }
        #layananTable tbody td { padding: 1rem 1.25rem; color: #334155; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
        #layananTable tbody tr:last-child td { border-bottom: none; }
        #layananTable tbody tr:hover { background-color: #f8fafc; }
        
        /* Animasi untuk modal */
        @keyframes modal-in { from { opacity: 0; transform: translateY(-20px) scale(0.95); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .animate-modal-in { animation: modal-in 0.3s ease-out; }
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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i class="bi bi-speedometer2 text-lg"></i><span>Dashboard</span></a>
                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors" aria-current="page"><i class="bi bi-list-check text-lg"></i><span>Data Layanan</span></a>
                <a href="{{ route('datauser') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i class="bi bi-people text-lg"></i><span>Data Karyawan</span></a>
                <a href="{{ route('dataorder') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i class="bi bi-printer text-lg"></i><span>Laporan</span></a>
            </nav>
        </aside>
        
        <div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-20 md:hidden hidden"></div>

        <main class="flex-1 overflow-y-auto">
            <div class="p-4 sm:p-6">
                <div class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700"><i class="bi bi-list"></i></button>
                        <h1 class="text-lg font-semibold text-slate-800">Daftar Layanan Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
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
                </header>

                <section class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-8">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-slate-800">🧺 Daftar Layanan</h3>
                            <p class="text-slate-500 mt-1">Kelola semua jenis layanan laundry yang tersedia.</p>
                        </div>
                        <button id="add-btn" class="w-full md:w-auto flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow-md hover:bg-teal-600 transition-all active:scale-95">
                            <i class="bi bi-plus-circle-fill"></i> 
                            <span>Tambah Layanan</span>
                        </button>
                    </div>
                    
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg mb-6">
                        <div id="kategori-filter" class="flex items-center bg-white rounded-full p-1 text-sm self-start">
                            <div><input type="radio" name="kategori" id="filter-all" value="" class="peer hidden" checked><label for="filter-all" class="cursor-pointer px-4 py-1.5 rounded-full peer-checked:bg-teal-500 peer-checked:text-white peer-checked:shadow-md transition-colors duration-200">Semua</label></div>
                            <div><input type="radio" name="kategori" id="filter-kiloan" value="Kiloan" class="peer hidden"><label for="filter-kiloan" class="cursor-pointer px-4 py-1.5 rounded-full peer-checked:bg-teal-500 peer-checked:text-white peer-checked:shadow-md transition-colors duration-200">Kiloan</label></div>
                            <div><input type="radio" name="kategori" id="filter-satuan" value="Satuan" class="peer hidden"><label for="filter-satuan" class="cursor-pointer px-4 py-1.5 rounded-full peer-checked:bg-teal-500 peer-checked:text-white peer-checked:shadow-md transition-colors duration-200">Satuan</label></div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="layananTable" class="w-full text-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Layanan</th>
                                    <th>Paket</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div id="formModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 flex justify-center items-center p-4">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-lg relative animate-modal-in">
            <button class="close-modal-btn absolute top-4 right-4 text-3xl text-slate-400 hover:text-slate-600 transition-colors">&times;</button>
            <h4 id="modalTitle" class="text-xl font-bold text-slate-800 mb-6">Tambah Layanan</h4>
            <form id="layananForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="space-y-4">
                    <div>
                        <label for="nama" class="block mb-1 text-sm font-medium text-slate-700">Nama Layanan</label>
                        <input type="text" name="nama" id="nama" required class="form-input">
                    </div>
                    <div>
                        <label for="paket" class="block mb-1 text-sm font-medium text-slate-700">Paket</label>
                        <select name="paket" id="paket" required class="form-input">
                            <option value="Standar">Standar</option>
                            <option value="Express">Express</option>
                        </select>
                    </div>
                    <div>
                        <label for="kategori" class="block mb-1 text-sm font-medium text-slate-700">Kategori</label>
                        <select name="kategori" id="kategori" required class="form-input">
                            <option value="Kiloan">Kiloan</option>
                            <option value="Satuan">Satuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="harga" class="block mb-1 text-sm font-medium text-slate-700">Harga</label>
                        <input type="number" name="harga" id="harga" required class="form-input">
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-8">
                    <button type="button" class="cancel-btn px-6 py-2.5 text-sm font-semibold rounded-lg bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 transition active:scale-95">Batal</button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow-md hover:bg-teal-600 transition active:scale-95">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    @if (session('success'))
    <script>
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000 });
    </script>
    @endif
    @if($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const formModal = document.getElementById('formModal');
                const modalTitle = document.getElementById('modalTitle');
                const layananForm = document.getElementById('layananForm');
                const formMethod = document.getElementById('formMethod');
                
                modalTitle.innerText = "{{ session('error_modal_title', 'Periksa Kembali Isian') }}";
                layananForm.action = "{{ session('error_modal_action', '#') }}";
                formMethod.value = "{{ session('error_modal_method', 'POST') }}";
                
                document.getElementById('nama').value = "{{ old('nama') }}";
                document.getElementById('paket').value = "{{ old('paket') }}";
                document.getElementById('kategori').value = "{{ old('kategori') }}";
                document.getElementById('harga').value = "{{ old('harga') }}";

                let errorList = "<ul class='mt-2 list-disc list-inside text-sm text-left'>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>";
                Swal.fire({ title: 'Terjadi Kesalahan!', html: errorList, icon: 'error', confirmButtonColor: '#14b8a6' });

                formModal.classList.replace('hidden', 'flex');
            });
        </script>
    @endif


    <script>
    $(document).ready(function() {
        // --- DataTable Initialization ---
        let table = $('#layananTable').DataTable({
            dom: '<"dt-controls-row"<"dt-length"l><"dt-search"f>>t<"dt-bottom-row"<"dt-info"i><"dt-paging"p>>',
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('layanan.data') }}",
                type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: function(d) {
                    d.kategori = $('#kategori-filter input[name="kategori"]:checked').val();
                }
            },
            columns: [
                { data: 'no', name: 'no', orderable: false, searchable: false },
                { data: 'nama', name: 'nama', className: 'font-semibold' },
                { data: 'paket', name: 'paket' },
                { data: 'harga', name: 'harga' },
                { 
                    data: 'json',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        const layananJson = JSON.stringify(data);
                        const deleteUrl = `{{ url('admin/produk') }}/${data.id}`;
                        return `
                            <div class="flex gap-2 justify-center">
                                <button class="btn-edit w-9 h-9 flex items-center justify-center rounded-lg bg-amber-500 text-white shadow-md hover:bg-amber-600 transition-all" data-json='${layananJson}'>
                                    <span class="sr-only">Edit</span><i class="bi bi-pencil-square"></i>
                                </button>
                                <form method="POST" action="${deleteUrl}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete w-9 h-9 flex items-center justify-center rounded-lg bg-rose-600 text-white shadow-md hover:bg-rose-700 transition-all">
                                        <span class="sr-only">Hapus</span><i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                search: "",
                searchPlaceholder: "Cari layanan...",
                lengthMenu: "Tampil _MENU_ entri",
                emptyTable: `<div class="text-center p-10"><i class="bi bi-box-seam text-5xl text-slate-300 mb-4 block"></i><h4 class="font-semibold text-xl text-slate-700">Belum Ada Layanan</h4><p class="text-slate-500">Gunakan tombol 'Tambah Layanan' untuk membuat data baru.</p></div>`,
                zeroRecords: `<div class="text-center p-10"><i class="bi bi-search text-5xl text-slate-300 mb-4 block"></i><h4 class="font-semibold text-xl text-slate-700">Layanan Tidak Ditemukan</h4><p class="text-slate-500">Tidak ada hasil yang cocok dengan pencarian Anda.</p></div>`,
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                infoEmpty: "Menampilkan 0 entri",
                infoFiltered: "(disaring dari _MAX_ total entri)",
                paginate: { next: ">", previous: "<" },
                processing: '<div class="flex items-center gap-2 text-slate-600"><svg class="animate-spin h-5 w-5 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Memuat Data...</span></div>',
            }
        });

        // --- Kategori Filter Event ---
        $('#kategori-filter input[name="kategori"]').on('change', () => table.ajax.reload());

        // --- Modal Handling ---
        const formModal = document.getElementById('formModal');
        const modalTitle = document.getElementById('modalTitle');
        const layananForm = document.getElementById('layananForm');
        const formMethod = document.getElementById('formMethod');
        const openModal = () => formModal.classList.replace('hidden', 'flex');
        const closeModal = () => formModal.classList.replace('flex', 'hidden');
        
        $('#add-btn').on('click', () => {
            layananForm.reset();
            modalTitle.innerText = 'Tambah Layanan Baru';
            layananForm.action = "{{ route('produk.store') }}";
            formMethod.value = 'POST';
            openModal();
        });

        $('#layananTable tbody').on('click', '.btn-edit', function() {
            const data = $(this).data('json');
            layananForm.reset();
            modalTitle.innerText = 'Edit Layanan';
            layananForm.action = `{{ url('admin/produk') }}/${data.id}`;
            formMethod.value = 'PUT';
            $('#nama').val(data.nama);
            $('#paket').val(data.paket);
            $('#kategori').val(data.kategori);
            $('#harga').val(data.harga);
            openModal();
        });

        $('.close-modal-btn, .cancel-btn').on('click', closeModal);

        // --- Delete Confirmation ---
        $('#layananTable tbody').on('click', '.delete-form', function(e) {
             e.preventDefault();
             const form = this;
             Swal.fire({
                 title: 'Anda yakin?', text: 'Data layanan ini akan dihapus permanen!', icon: 'warning',
                 showCancelButton: true, confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b',
                 confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
             }).then((result) => { if (result.isConfirmed) form.submit(); });
        });

        // --- UI Logic (Sidebar, User Menu) ---
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const logoutButton = document.getElementById('logout-button');
        const toggleSidebar = () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        };
        hamburgerBtn.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);
        userMenuButton.addEventListener('click', (e) => { e.stopPropagation(); userMenu.classList.toggle('hidden'); });
        window.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
        logoutButton.addEventListener('click', (e) => {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout', text: "Apakah Anda yakin ingin keluar?", icon: 'question',
                showCancelButton: true, confirmButtonColor: '#14b8a6', cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, keluar!', cancelButtonText: 'Batal'
            }).then((result) => { if (result.isConfirmed) logoutButton.closest('form').submit(); });
        });
    });
    </script>
</body>
</html>