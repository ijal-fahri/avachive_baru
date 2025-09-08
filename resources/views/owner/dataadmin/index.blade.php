<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Admin | Avachive</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
      body { font-family: 'Poppins', sans-serif; }
      .sidebar-mobile-open { transform: translateX(0) !important; }
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
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-grid-1x2-fill mr-4 text-lg"></i><span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('owner.manage') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-receipt-cutoff mr-4 text-lg"></i><span class="font-medium">Manajemen Order</span>
                    </a>
                    <a href="{{ route('owner.dataadmin.index') }}" class="flex items-center py-3 px-4 rounded-lg bg-teal-400 text-slate-900 font-semibold shadow-lg">
                        <i class="bi bi-person-badge-fill mr-4 text-lg"></i><span class="font-medium">Data Admin</span>
                    </a>
                    <a href="{{ route('owner.datakaryawan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-people-fill mr-4 text-lg"></i><span class="font-medium">Data Karyawan</span>
                    </a>
                    <a href="{{ route('owner.laporan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-graph-up-arrow mr-4 text-lg"></i><span class="font-medium">Laporan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            {{-- ===== HEADER ===== --}}
            <header class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
                <div class="flex items-center gap-4">
                  <button id="menu-btn" class="text-slate-800 text-2xl md:hidden"><i class="bi bi-list"></i></button>
                  <h1 class="text-xl font-semibold text-slate-800">Manajemen Admin</h1>
                </div>
                <div class="flex items-center gap-4">
                    <button id="addAdminBtn" class="bg-teal-500 text-white font-bold py-2 px-5 rounded-lg flex items-center gap-2 hover:bg-teal-600 transition-colors">
                        <i class="bi bi-plus-circle-fill"></i><span class="hidden sm:block">Tambah Admin</span>
                    </button>
                    <div class="relative">
                        <button id="profileDropdownBtn" class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all">
                            {{ strtoupper(substr(Auth::user()->name ?? 'O', 0, 1)) }}
                        </button>
                        <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-10 border">
                            <div class="p-2">
                                <a href="{{ route('owner.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat Profile</a>
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <button type="button" id="logoutBtn" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <main class="w-full px-4 md:px-6 pb-6 mt-8">
                @if (session('success'))
                    <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert"><p>{{ session('success') }}</p></div>
                @endif
                @if (session('error'))
                    <div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert"><p>{{ session('error') }}</p></div>
                @endif

                <div class="w-full max-w-4xl mx-auto">
                    <div class="bg-white p-4 rounded-xl shadow-md mb-6">
                        <form id="filterForm" action="{{ route('owner.dataadmin.index') }}" method="GET">
                            <label for="cabangFilter" class="block text-sm font-medium text-slate-600">Filter berdasarkan Cabang</label>
                            <select id="cabangFilter" name="cabang_id" class="mt-1 block w-full md:w-1/3 border border-slate-300 rounded-lg py-2 px-3 focus:outline-none focus:ring-2 focus:ring-teal-400">
                                <option value="semua">Semua Cabang</option>
                                @foreach ($cabangs as $cabang)
                                    <option value="{{ $cabang->id }}" {{ $selectedCabang == $cabang->id ? 'selected' : '' }}>
                                        {{ $cabang->nama_cabang }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <div id="adminGroupContainer" class="space-y-6">
                        @forelse ($admins as $namaCabang => $adminsInCabang)
                        <div class="bg-white rounded-xl shadow-lg">
                            <div class="p-4 border-b border-slate-200">
                                <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2">
                                    <i class="bi bi-building text-teal-500"></i>Cabang {{ $namaCabang ?: 'Tidak Terkait' }}
                                    <span class="text-sm font-medium bg-slate-200 text-slate-600 rounded-full px-2 py-0.5">{{ count($adminsInCabang) }} Admin</span>
                                </h3>
                            </div>
                            <div class="divide-y divide-slate-100 p-2">
                                @foreach ($adminsInCabang as $index => $admin)
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 px-4 hover:bg-slate-50 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <i class="bi bi-person-circle text-slate-400 text-2xl"></i>
                                        <span class="w-6 text-slate-500 font-medium">{{ $index + 1 }}.</span>
                                        <span class="font-medium text-slate-800">{{ $admin->name }}</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-3 sm:mt-0 sm:justify-end sm:gap-4">
                                        <div class="flex items-center gap-2">
                                            <span id="pass-text-{{ $admin->id }}" class="text-slate-400 tracking-wider transition-all duration-200 text-sm">••••••••</span>
                                            <button class="toggle-pass-table-btn text-slate-500 hover:text-slate-800 text-lg" 
                                                    data-id="{{ $admin->id }}" 
                                                    data-password="{{ $admin->plain_password }}" 
                                                    title="{{ $admin->plain_password ? 'Lihat Password' : 'Password tidak tersedia' }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </div>
                                        <div class="flex items-center gap-3 sm:pl-3 sm:border-l">
                                            <button class="edit-btn text-blue-600 hover:text-blue-800 text-lg" data-id="{{ $admin->id }}" title="Edit"><i class="bi bi-pencil-square"></i></button>
                                            <form action="{{ route('owner.dataadmin.destroy', $admin->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-lg" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="text-center p-8 bg-white rounded-xl shadow-md text-slate-500">Tidak ada data admin untuk ditampilkan.</div>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-30 hidden"></div>

    {{-- MODAL TAMBAH/EDIT --}}
    <div id="adminFormModal" class="fixed inset-0 bg-black/50 z-50 hidden flex justify-center items-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md" id="modalContent">
            <form id="adminForm" action="" method="POST" class="p-6">
                @csrf
                <input type="hidden" name="_method" id="formMethod">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h3 id="modalTitle" class="text-lg font-bold text-slate-800"></h3>
                    <button type="button" class="close-modal-btn text-slate-500 hover:text-slate-800 text-2xl">&times;</button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Username</label>
                        <input type="text" id="name" name="name" class="w-full border border-slate-300 rounded-lg p-2" required>
                    </div>
                    <div>
                        <label for="cabang_id" class="block text-sm font-medium text-slate-600 mb-1">Penempatan Cabang</label>
                        <select id="cabang_id" name="cabang_id" class="w-full border border-slate-300 rounded-lg p-2" required>
                            <option value="">-- Pilih Cabang --</option>
                            @foreach($cabangs as $cabang)
                            <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-600 mb-1">Password</label>
                        <input type="password" id="password" name="password" placeholder="Isi untuk menambah/mengubah" class="w-full border border-slate-300 rounded-lg p-2">
                        <p id="password-hint" class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="cancel-btn bg-slate-200 text-slate-800 font-bold py-2 px-4 rounded-lg hover:bg-slate-300">Batal</button>
                    <button type="submit" class="bg-teal-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-teal-600">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Setup Modal ---
        const adminFormModal = document.getElementById('adminFormModal');
        const adminForm = document.getElementById('adminForm');
        const modalTitle = document.getElementById('modalTitle');
        const formMethodInput = document.getElementById('formMethod');
        const passwordHint = document.getElementById('password-hint');

        const storeUrl = "{{ route('owner.dataadmin.store') }}";
        const showUrlTemplate = "{{ route('owner.dataadmin.show', ['dataadmin' => 'PLACEHOLDER']) }}";
        const updateUrlTemplate = "{{ route('owner.dataadmin.update', ['dataadmin' => 'PLACEHOLDER']) }}";

        const openModal = (mode, adminId = null) => {
            adminForm.reset();
            
            if (mode === 'add') {
                modalTitle.textContent = 'Tambah Admin Baru';
                adminForm.action = storeUrl;
                formMethodInput.value = 'POST';
                document.getElementById('password').setAttribute('required', 'true');
                passwordHint.style.display = 'none';
            } else {
                modalTitle.textContent = 'Ubah Data Admin';
                formMethodInput.value = 'PUT';
                document.getElementById('password').removeAttribute('required');
                passwordHint.style.display = 'block';

                const url = showUrlTemplate.replace('PLACEHOLDER', adminId);
                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Admin tidak ditemukan');
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('name').value = data.name;
                        document.getElementById('cabang_id').value = data.cabang_id;
                        adminForm.action = updateUrlTemplate.replace('PLACEHOLDER', data.id);
                    })
                    .catch(error => {
                        console.error('Error fetching admin data:', error);
                        Swal.fire('Error', 'Gagal memuat data admin.', 'error');
                        closeModal();
                    });
            }
            adminFormModal.classList.remove('hidden');
        };

        const closeModal = () => {
            adminFormModal.classList.add('hidden');
        };

        // --- Event Listeners ---
        document.getElementById('addAdminBtn').addEventListener('click', () => openModal('add'));
        
        adminFormModal.addEventListener('click', (e) => {
            if (e.target.classList.contains('close-modal-btn') || e.target.classList.contains('cancel-btn') || e.target === adminFormModal) {
                closeModal();
            }
        });

        // Event Delegation for dynamic buttons
        document.getElementById('adminGroupContainer').addEventListener('click', function(e) {
            const editBtn = e.target.closest('.edit-btn');
            if (editBtn) {
                openModal('edit', editBtn.dataset.id);
            }

            const deleteForm = e.target.closest('.delete-form');
            if (deleteForm) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin?', text: "Data admin akan dihapus permanen!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            }

            const togglePassBtn = e.target.closest('.toggle-pass-table-btn');
            if(togglePassBtn) {
                const adminId = togglePassBtn.dataset.id;
                const password = togglePassBtn.dataset.password || '';
                if (!password) return;

                const passTextSpan = document.getElementById(`pass-text-${adminId}`);
                const eyeIcon = togglePassBtn.querySelector('i');
                
                if (eyeIcon.classList.contains('bi-eye-fill')) {
                    passTextSpan.textContent = password;
                    passTextSpan.classList.remove('text-slate-400', 'tracking-wider', 'text-sm');
                    passTextSpan.classList.add('text-slate-700', 'font-semibold');
                    eyeIcon.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
                } else {
                    passTextSpan.textContent = '••••••••';
                    passTextSpan.classList.add('text-slate-400', 'tracking-wider', 'text-sm');
                    passTextSpan.classList.remove('text-slate-700', 'font-semibold');
                    eyeIcon.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                }
            }
        });
        
        document.getElementById('cabangFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
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
        profileDropdownBtn.addEventListener('click', () => {
            profileDropdownMenu.classList.toggle('hidden');
        });
        window.addEventListener('click', (e) => {
            if (!profileDropdownBtn.contains(e.target) && !profileDropdownMenu.contains(e.target)) {
                profileDropdownMenu.classList.add('hidden');
            }
        });
        document.getElementById('logoutBtn').addEventListener('click', () => {
            Swal.fire({
                title: 'Konfirmasi Logout', text: "Anda yakin ingin keluar?", icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Logout!', cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });

        const successAlert = document.getElementById('success-alert');
        if(successAlert) setTimeout(() => { successAlert.style.display = 'none'; }, 5000);
        const errorAlert = document.getElementById('error-alert');
        if(errorAlert) setTimeout(() => { errorAlert.style.display = 'none'; }, 5000);
    });
    </script>
</body>
</html>

