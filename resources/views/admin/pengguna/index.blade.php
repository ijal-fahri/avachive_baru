<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan - Admin Panel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
                <a href="{{ route('produk.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-list-check text-lg"></i><span>Layanan</span>
                </a>
                <a href="{{ route('dataorder') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors">
                    <i class="bi bi-cart-check text-lg"></i><span>Order</span>
                </a>
                <a href="{{ route('datauser') }}" class="active flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors">
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
                       <h1 class="text-lg font-semibold text-slate-800">Daftar Karyawan Cabang {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
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
                        <h3 class="text-xl font-bold text-slate-800">👥 Daftar Karyawan</h3>
                        <div class="flex flex-wrap items-center gap-2">
                            <button class="tab-btn px-4 py-2 text-sm font-semibold rounded-full" data-role="kasir">Kasir</button>
                            <button class="tab-btn px-4 py-2 text-sm font-semibold rounded-full" data-role="driver">Driver</button>
                            <button class="add-btn flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-full bg-teal-500 text-white shadow hover:bg-teal-600 transition active:scale-95">
                                <i class="bi bi-plus-circle"></i> Tambah Karyawan
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table id="userTable" class="w-full text-sm responsive-table border-separate border-spacing-y-2">
                            <thead class="bg-slate-100 hidden md:table-header-group">
                                <tr>
                                    <th class="py-3 px-4 w-12 text-left font-semibold text-slate-600 rounded-l-lg">No</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Nama</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Role</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600">Password Terakhir</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-600 rounded-r-lg w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                <tr data-role="{{ $user->usertype }}" class="bg-white hover:bg-slate-50 transition">
                                    <td data-label="No" class="py-4 px-4 rounded-l-lg"></td>
                                    <td data-label="Nama" class="py-4 px-4 font-semibold">{{ $user->name }}</td>
                                    <td data-label="Role" class="py-4 px-4 capitalize">{{ $user->usertype }}</td>
                                    <td data-label="Password Terakhir" class="py-4 px-4">{{ $user->plain_password ?? 'Belum Diatur' }}</td>
                                    <td data-label="Aksi" class="py-4 px-4 rounded-r-lg">
                                        <div class="flex gap-2">
                                            <button class="btn-edit flex-1 px-3 py-2 rounded-md bg-orange-500 text-white shadow hover:bg-orange-600 transition" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-usertype="{{ $user->usertype }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form method="POST" action="{{ route('pengguna.destroy', $user->id) }}" class="delete-form flex-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete w-full px-3 py-2 rounded-md bg-red-600 text-white shadow hover:bg-red-700 transition">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-8 text-slate-500">Belum ada data karyawan di cabang ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>

    <div id="userModal" class="modal hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 flex justify-center items-center p-4">
        <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-lg relative">
            <button class="close-modal-btn absolute top-4 right-4 text-2xl text-slate-500 hover:text-slate-800">&times;</button>
            <h4 id="modalTitle" class="text-xl font-bold text-slate-800 mb-4">Tambah Karyawan</h4>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Terjadi Kesalahan!</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block mb-1 text-sm font-medium text-slate-700">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-slate-300 rounded-lg">
                    </div>
                    <div>
                        <label for="password" class="block mb-1 text-sm font-medium text-slate-700">Password</label>
                        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-2 border border-slate-300 rounded-lg">
                    </div>
                    <div>
                        <label for="usertype" class="block mb-1 text-sm font-medium text-slate-700">Role</label>
                        <select name="usertype" id="usertype" required class="w-full px-4 py-2 border border-slate-300 rounded-lg">
                            <option value="kasir" @if(old('usertype') == 'kasir') selected @endif>Kasir</option>
                            <option value="driver" @if(old('usertype') == 'driver') selected @endif>Driver</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" class="cancel-btn px-5 py-2 text-sm font-semibold rounded-lg bg-slate-200 hover:bg-slate-300 transition">Batal</button>
                    <button type="submit" class="px-5 py-2 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow hover:bg-teal-600 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Elemen
        const userModal = document.getElementById('userModal');
        const modalTitle = document.getElementById('modalTitle');
        const userForm = document.getElementById('userForm');
        const formMethod = document.getElementById('formMethod');
        const nameInput = document.getElementById('name');
        const passwordInput = document.getElementById('password');
        const usertypeInput = document.getElementById('usertype');
        const tabButtons = document.querySelectorAll('.tab-btn');
        const tableRows = document.querySelectorAll('#userTable tbody tr');
        let activeRole = localStorage.getItem('activeRole') || 'kasir';

        // Fungsi Modal
        const openModal = () => { userModal.classList.remove('hidden'); userModal.classList.add('flex'); };
        const closeModal = () => { userModal.classList.add('hidden'); userModal.classList.remove('flex'); };

        const openAddForm = () => {
            userForm.reset();
            modalTitle.innerText = 'Tambah Karyawan';
            userForm.action = "{{ route('pengguna.store') }}";
            formMethod.value = 'POST';
            passwordInput.setAttribute('required', 'required');
            usertypeInput.value = activeRole;
            openModal();
        };

        const openEditForm = (id, name, usertype) => {
            userForm.reset();
            modalTitle.innerText = 'Edit Karyawan';
            userForm.action = `{{ url('admin/pengguna') }}/${id}`;
            formMethod.value = 'PUT';
            nameInput.value = name;
            usertypeInput.value = usertype;
            passwordInput.removeAttribute('required');
            openModal();
        };

        document.querySelector('.add-btn').addEventListener('click', openAddForm);
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', () => openEditForm(btn.dataset.id, btn.dataset.name, btn.dataset.usertype));
        });

        document.querySelectorAll('.close-modal-btn, .cancel-btn').forEach(btn => btn.addEventListener('click', closeModal));
        userModal.addEventListener('click', (e) => { if(e.target === userModal) closeModal(); });

        // Notifikasi & Delete Confirmation
        @if (session('success'))
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: '{{ session('success') }}', showConfirmButton: false, timer: 3000 });
        @endif

        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Anda yakin?', text: "Data karyawan ini akan dihapus permanen!", icon: 'warning',
                    showCancelButton: true, confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus!', cancelButtonText: 'Batal'
                }).then((result) => { if (result.isConfirmed) event.target.submit(); });
            });
        });

        // Logika Tab Filter
        const filterRows = (role) => {
            let counter = 1;
            tableRows.forEach(row => {
                if (row.dataset.role === role) {
                    row.style.display = '';
                    if (window.innerWidth <= 768) row.style.display = 'block';
                    row.querySelector('td[data-label="No"]').innerText = counter++;
                } else {
                    row.style.display = 'none';
                }
            });
        };

        const setActiveTab = (role) => {
            activeRole = role;
            localStorage.setItem('activeRole', activeRole);
            tabButtons.forEach(btn => {
                const isActive = btn.dataset.role === role;
                btn.classList.toggle('bg-blue-600', isActive); btn.classList.toggle('text-white', isActive);
                btn.classList.toggle('bg-slate-100', !isActive); btn.classList.toggle('text-slate-600', !isActive);
            });
            filterRows(activeRole);
        };
        tabButtons.forEach(btn => btn.addEventListener('click', () => setActiveTab(btn.dataset.role)));
        setActiveTab(activeRole);
        
        // --- Buka kembali modal jika ada error validasi ---
        @if($errors->any() && session('error_modal'))
            @if(session('error_modal') === 'tambah')
                openAddForm();
            @elseif(session('error_modal') === 'edit' && session('error_id'))
                openEditForm("{{ session('error_id') }}", "{{ old('name') }}", "{{ old('usertype') }}");
            @endif
        @endif
        
        // UI Scripts
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggleSidebar = () => { sidebar.classList.toggle('-translate-x-full'); overlay.classList.toggle('hidden'); }
        hamburgerBtn.addEventListener('click', toggleSidebar);
        overlay.addEventListener('click', toggleSidebar);
        
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');
        const logoutButton = document.getElementById('logout-button');
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
    });
    </script>
</body>
</html>

