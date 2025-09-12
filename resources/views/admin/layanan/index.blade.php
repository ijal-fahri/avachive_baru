<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Layanan - Admin Laundry</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
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
            .responsive-table td:last-child { border-bottom: none; padding-top: 1rem; }
            .responsive-table td::before { content: attr(data-label); font-weight: 600; text-align: left; padding-right: 1rem; color: #475569; }
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
                <a href="{{ route('produk.index') }}" class="active flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors">
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

                <section class="bg-white rounded-2xl shadow-lg p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                        <h3 class="text-xl font-bold text-slate-800">🧺 Daftar Layanan</h3>
                        <div class="flex flex-wrap items-center gap-2">
                            <button class="tab-button px-4 py-2 text-sm font-semibold rounded-full" data-tab="Kiloan">Kiloan</button>
                            <button class="tab-button px-4 py-2 text-sm font-semibold rounded-full" data-tab="Satuan">Satuan</button>
                            <button id="openTambahBtn" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full bg-teal-500 text-white shadow hover:bg-teal-600 transition active:scale-95">
                                <i class="bi bi-plus-circle"></i> Tambah Layanan
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="layananTable" class="w-full text-sm responsive-table border-separate border-spacing-y-2">
                            <thead class="bg-slate-100 hidden md:table-header-group">
                                <tr>
                                    <th class="py-3 px-4 w-12 text-left font-semibold text-slate-600 rounded-l-lg">No</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Nama Layanan</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Paket</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Harga</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600 rounded-r-lg w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="layananTbody">
                                @forelse($layanans as $layanan)
                                    <tr data-kategori="{{ $layanan->kategori }}" class="bg-white hover:bg-slate-50 transition">
                                        <td data-label="No" class="py-5 px-4 rounded-l-lg"></td>
                                        <td data-label="Nama Layanan" class="py-5 px-4 font-semibold">{{ $layanan->nama }}</td>
                                        <td data-label="Paket" class="py-5 px-4">{{ $layanan->paket }}</td>
                                        <td data-label="Harga" class="py-5 px-4">Rp {{ number_format($layanan->harga, 0, ',', '.') }} / {{ $layanan->kategori == 'Kiloan' ? 'Kg' : 'Pcs' }}</td>
                                        <td data-label="Aksi" class="py-5 px-4 rounded-r-lg">
                                            <div class="flex gap-2">
                                                <button class="btn-edit flex-1 px-3 py-2 rounded-md bg-orange-500 text-white shadow hover:bg-orange-600 transition" data-json='@json($layanan)'><i class="bi bi-pencil-square"></i></button>
                                                <form action="{{ route('produk.destroy', $layanan->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete flex-1 w-full px-3 py-2 rounded-md bg-red-600 text-white shadow hover:bg-red-700 transition"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty-row"><td colspan="5" class="text-center py-8 text-slate-500">Belum ada data layanan. Silakan tambahkan layanan baru.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>
    
    {{-- MODAL TAMBAH LAYANAN --}}
    <div id="tambahModal" class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-lg relative">
            <button class="close-modal absolute top-4 right-4 text-2xl text-slate-500 hover:text-slate-800">&times;</button>
            <h4 class="text-xl font-bold text-slate-800 mb-4">Tambah Layanan Baru</h4>
            <form id="tambahForm" action="{{ route('produk.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kategori" id="kategoriInput">
                <div class="space-y-4">
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Nama Layanan</label><input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"></div>
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Paket</label><select name="paket" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"><option value="Standar" @if(old('paket') == 'Standar') selected @endif>Standar</option><option value="Express" @if(old('paket') == 'Express') selected @endif>Express</option></select></div>
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Harga</label><input type="number" name="harga" value="{{ old('harga') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"></div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="cancel-modal px-5 py-2 text-sm font-semibold rounded-lg bg-slate-200 hover:bg-slate-300 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow hover:bg-teal-600 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- MODAL EDIT LAYANAN --}}
    <div id="editModal" class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-lg relative">
            <button class="close-modal absolute top-4 right-4 text-2xl text-slate-500 hover:text-slate-800">&times;</button>
            <h4 class="text-xl font-bold text-slate-800 mb-4">Edit Layanan</h4>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Nama Layanan</label><input type="text" name="nama" id="editNama" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"></div>
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Paket</label><select name="paket" id="editPaket" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"><option value="Standar">Standar</option><option value="Express">Express</option></select></div>
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Kategori</label><select name="kategori" id="editKategori" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"><option value="Kiloan">Kiloan</option><option value="Satuan">Satuan</option></select></div>
                    <div><label class="block mb-1 text-sm font-medium text-slate-700">Harga</label><input type="number" name="harga" id="editHarga" required class="w-full px-4 py-2 border border-slate-300 rounded-lg"></div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="cancel-modal px-5 py-2 text-sm font-semibold rounded-lg bg-slate-200 hover:bg-slate-300 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow hover:bg-teal-600 transition">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tbody = document.getElementById('layananTbody');
        const tambahModal = document.getElementById('tambahModal');
        const editModal = document.getElementById('editModal');
        const openTambahBtn = document.getElementById('openTambahBtn');
        const kategoriInput = document.getElementById('kategoriInput');
        const editForm = document.getElementById('editForm');
        let activeTab = localStorage.getItem('activeLayananTab') || 'Kiloan';

        const filterAndRenumberRows = () => {
            let visibleCount = 0;
            const rows = tbody.querySelectorAll('tr[data-kategori]');
            rows.forEach(row => {
                const isVisible = row.dataset.kategori === activeTab;
                row.style.display = isVisible ? '' : 'none';
                if (isVisible) {
                    visibleCount++;
                    const noCell = row.querySelector('td[data-label="No"]');
                    if (noCell) noCell.textContent = visibleCount;
                }
            });
            const emptyRow = tbody.querySelector('.empty-row');
            if(emptyRow) {
                emptyRow.style.display = visibleCount > 0 ? 'none' : 'table-row';
                if (window.innerWidth <= 768) emptyRow.style.display = visibleCount > 0 ? 'none' : 'block';
            }
        };
        const setActiveTab = (tabName) => {
            activeTab = tabName;
            localStorage.setItem('activeLayananTab', tabName);
            tabButtons.forEach(b => {
                const isActive = b.dataset.tab === tabName;
                b.classList.toggle('bg-blue-600', isActive); b.classList.toggle('text-white', isActive);
                b.classList.toggle('bg-slate-100', !isActive); b.classList.toggle('text-slate-600', !isActive);
            });
            filterAndRenumberRows();
        };
        const openModal = (modal) => { modal.classList.remove('hidden'); modal.classList.add('flex'); };
        const closeModal = (modal) => { modal.classList.add('hidden'); modal.classList.remove('flex'); };
        
        tabButtons.forEach(btn => btn.addEventListener('click', () => setActiveTab(btn.dataset.tab)));
        openTambahBtn.addEventListener('click', () => {
            document.getElementById('tambahForm').reset();
            kategoriInput.value = activeTab;
            openModal(tambahModal);
        });

        tbody.addEventListener('click', (e) => {
            const editBtn = e.target.closest('.btn-edit');
            const deleteForm = e.target.closest('.delete-form');
            if (editBtn) {
                const data = JSON.parse(editBtn.dataset.json);
                editForm.action = `{{ url('admin/produk') }}/${data.id}`;
                document.getElementById('editNama').value = data.nama;
                document.getElementById('editPaket').value = data.paket;
                document.getElementById('editKategori').value = data.kategori;
                document.getElementById('editHarga').value = data.harga;
                openModal(editModal);
            }
            if (deleteForm) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin?', text: "Data yang dihapus tidak bisa dikembalikan!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
                }).then((result) => { if (result.isConfirmed) deleteForm.submit(); });
            }
        });
        
        document.querySelectorAll('.close-modal, .cancel-modal').forEach(btn => {
            const modal = btn.closest('.modal');
            if(modal) btn.addEventListener('click', () => closeModal(modal));
        });
        window.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) closeModal(e.target);
        });

        // UI Scripts
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const logoutButton = document.getElementById('logout-button');
        
        const toggleSidebar = () => { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); }
        hamburgerBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        
        userMenuButton.addEventListener('click', () => userMenu.classList.toggle('hidden'));
        window.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) userMenu.classList.add('hidden');
        });
        logoutButton.addEventListener('click', (e) => {
            e.preventDefault(); 
            Swal.fire({
                title: 'Anda yakin ingin logout?', icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout!', cancelButtonText: 'Batal'
            }).then((result) => { if (result.isConfirmed) logoutButton.closest('form').submit(); });
        });

        @if (session('success'))
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000 });
        @endif
        
        @if($errors->any())
            let errorMessages = `<ul class="mt-2 list-disc list-inside text-sm text-left">`;
            @foreach ($errors->all() as $error)
                errorMessages += `<li>{{ $error }}</li>`;
            @endforeach
            errorMessages += `</ul>`;

            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan Data',
                html: errorMessages,
            });

            @if(session('error_modal') === 'tambah')
                openModal(tambahModal);
            @elseif(session('error_modal') === 'edit' && session('error_id'))
                // Logika untuk membuka kembali modal edit jika diperlukan
                const editButton = document.querySelector(`.btn-edit[data-json*='"id":{{ session('error_id') }}']`);
                if(editButton) editButton.click();
            @endif
        @endif

        setActiveTab(activeTab);
    });
    </script>
</body>
</html>

