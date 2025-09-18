<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Karyawan - Avachive Admin</title>
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

    <style>
        /* FONT & SCROLLBAR DASAR */
        body {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #14b8a6;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #0d9488;
        }

        /* STYLING TERPUSAT UNTUK INPUT & SELECT */
        .form-input,
        #userTable_wrapper .dt-search input,
        #userTable_wrapper .dt-length select {
            width: 100%;
            background-color: white !important;
            color: #1e293b !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.6rem 1rem !important;
            transition: all 0.2s ease-in-out;
            outline: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .form-input:focus,
        #userTable_wrapper .dt-search input:focus,
        #userTable_wrapper .dt-length select:focus {
            border-color: #14b8a6 !important;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) !important;
        }

        select.form-input,
        #userTable_wrapper .dt-length select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem !important;
        }

        #userTable_wrapper .dt-search input {
            border-radius: 9999px !important;
        }

        #userTable_wrapper .dt-length select {
            width: auto;
        }

        @media (min-width: 768px) {
            #userTable_wrapper .dt-search input {
                min-width: 250px;
                width: auto;
            }
        }

        /* STYLING LAYOUT DATATABLES */
        #userTable_wrapper .dt-controls-row,
        #userTable_wrapper .dt-bottom-row {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0.5rem 0.25rem;
        }

        #userTable_wrapper .dt-controls-row {
            margin-bottom: 1.5rem;
        }

        #userTable_wrapper .dt-bottom-row {
            margin-top: 1.5rem;
        }

        @media (min-width: 768px) {

            #userTable_wrapper .dt-controls-row,
            #userTable_wrapper .dt-bottom-row {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        /* STYLING TABEL UTAMA */
        #userTable {
            border-collapse: collapse;
        }

        #userTable thead th {
            font-weight: 600;
            text-align: left;
            padding: 1rem 1.25rem;
            color: #475569;
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        #userTable tbody td {
            padding: 1rem 1.25rem;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            white-space: nowrap;
        }

        #userTable tbody tr:last-child td {
            border-bottom: none;
        }

        #userTable tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Animasi untuk modal */
        @keyframes modal-in {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .animate-modal-in {
            animation: modal-in 0.3s ease-out;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800 antialiased">
    <div class="relative flex h-screen bg-slate-100">

        <aside id="sidebar"
            class="w-64 bg-slate-900 text-slate-300 p-4 flex-col fixed inset-y-0 left-0 z-30 transition-transform duration-300 ease-in-out hidden md:flex">
            <div class="mb-8 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto mx-auto mb-2">
                <h2 class="text-2xl font-bold text-teal-400">Avachive Admin</h2>
            </div>
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i
                        class="bi bi-speedometer2 text-lg"></i><span>Dashboard</span></a>
                <a href="{{ route('produk.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i
                        class="bi bi-list-check text-lg"></i><span>Data Layanan</span></a>
                <a href="{{ route('datauser') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-white bg-teal-500 font-semibold transition-colors"
                    aria-current="page"><i class="bi bi-people text-lg"></i><span>Data Karyawan</span></a>
                <a href="{{ route('dataorder') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-slate-800 hover:text-white transition-colors"><i
                        class="bi bi-printer text-lg"></i><span>Laporan</span></a>
            </nav>
        </aside>

        <div class="flex-1 md:ml-64 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto">
                <div class="p-4 sm:p-6 pb-28 md:pb-6">
                    <div
                        class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <h1 class="text-lg font-semibold text-slate-800">Daftar Karyawan Cabang
                                {{ Auth::user()->cabang->nama_cabang ?? 'Cabang Tidak Ditemukan' }}</h1>
                        </div>
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                                <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="bi bi-person-circle text-2xl text-slate-600"></i>
                            </button>
                            <div id="user-menu"
                                class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                                <a href="pengaturan"
                                    class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100"><i
                                        class="bi bi-person-circle"></i><span>Profile</span></a>
                                <div class="border-t border-slate-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <button type="button" id="logout-button"
                                        class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i
                                            class="bi bi-box-arrow-right"></i><span>Logout</span></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <section class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-8">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-slate-800">👥 Daftar Karyawan</h3>
                                <p class="text-slate-500 mt-1">Kelola data kasir dan driver untuk cabang ini.</p>
                            </div>
                            <button
                                class="add-btn w-full md:w-auto flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow-md hover:bg-teal-600 transition-all active:scale-95">
                                <i class="bi bi-plus-circle-fill"></i>
                                <span>Tambah Karyawan</span>
                            </button>
                        </div>

                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-lg mb-6">
                            <div id="role-filter"
                                class="flex items-center bg-white rounded-full p-1 text-sm self-start overflow-x-auto">
                                <div><input type="radio" name="role" id="filter-all" value=""
                                        class="peer hidden" checked><label for="filter-all"
                                        class="cursor-pointer px-4 py-1.5 rounded-full peer-checked:bg-teal-500 peer-checked:text-white peer-checked:shadow-md transition-colors duration-200">Semua</label>
                                </div>
                                <div><input type="radio" name="role" id="filter-kasir" value="kasir"
                                        class="peer hidden"><label for="filter-kasir"
                                        class="cursor-pointer px-4 py-1.5 rounded-full peer-checked:bg-teal-500 peer-checked:text-white peer-checked:shadow-md transition-colors duration-200">Kasir</label>
                                </div>
                                <div><input type="radio" name="role" id="filter-driver" value="driver"
                                        class="peer hidden"><label for="filter-driver"
                                        class="cursor-pointer px-4 py-1.5 rounded-full peer-checked:bg-teal-500 peer-checked:text-white peer-checked:shadow-md transition-colors duration-200">Driver</label>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table id="userTable" class="w-full text-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Foto</th>
                                        <th>Nama</th>
                                        <th>Role</th>
                                        <th>Password Terakhir</th>
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
    </div>

    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] z-30 flex justify-around items-center px-2">
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-speedometer2 text-2xl"></i>
            <span class="text-xs">Dashboard</span>
        </a>
        <a href="{{ route('produk.index') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-list-check text-2xl"></i>
            <span class="text-xs">Layanan</span>
        </a>
        <a href="{{ route('datauser') }}" class="flex flex-col items-center gap-1 text-teal-500 font-semibold">
            <i class="bi bi-people text-2xl"></i>
            <span class="text-xs">Karyawan</span>
        </a>
        <a href="{{ route('dataorder') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-500 transition-colors">
            <i class="bi bi-printer text-2xl"></i>
            <span class="text-xs">Laporan</span>
        </a>
    </nav>

    <div id="userModal"
        class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-40 flex justify-center items-center p-4">
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl w-full max-w-lg relative animate-modal-in">
            <button
                class="close-modal-btn absolute top-4 right-4 text-3xl text-slate-400 hover:text-slate-600 transition-colors">&times;</button>
            <h4 id="modalTitle" class="text-xl font-bold text-slate-800 mb-6">Tambah Karyawan</h4>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="space-y-4">

                    <div>
                        <label class="block mb-2 text-sm font-medium text-slate-700">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <img id="imagePreview"
                                src="https://ui-avatars.com/api/?name=?&background=e2e8f0&color=64748b" alt="Avatar"
                                class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                            <div class="opacity-50">
                                <label for="profile_photo_dummy"
                                    class="cursor-not-allowed bg-slate-100 text-slate-800 font-semibold py-2 px-4 rounded-lg text-sm">Pilih
                                    Foto</label>
                                <input type="file" id="profile_photo_dummy" class="hidden" disabled>
                                <p class="text-xs text-slate-500 mt-2">Fitur ini belum tersedia.</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="name" class="block mb-1 text-sm font-medium text-slate-700">Nama</label>
                        <input type="text" name="name" id="name" required class="form-input">
                    </div>
                    <div>
                        <label for="password" class="block mb-1 text-sm font-medium text-slate-700">Password</label>
                        <input type="password" name="password" id="password"
                            placeholder="Kosongkan jika tidak ingin mengubah" class="form-input">
                    </div>
                    <div>
                        <label for="usertype" class="block mb-1 text-sm font-medium text-slate-700">Role</label>
                        <select name="usertype" id="usertype" required class="form-input">
                            <option value="kasir">Kasir</option>
                            <option value="driver">Driver</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-4 mt-8">
                    <button type="button"
                        class="cancel-btn px-6 py-2.5 text-sm font-semibold rounded-lg bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 transition active:scale-95">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow-md hover:bg-teal-600 transition active:scale-95">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const userModal = document.getElementById('userModal');
                const modalTitle = document.getElementById('modalTitle');
                const userForm = document.getElementById('userForm');
                const formMethod = document.getElementById('formMethod');

                modalTitle.innerText = "{{ session('error_modal_title', 'Periksa Kembali Isian') }}";
                userForm.action = "{{ session('error_modal_action', '#') }}";
                formMethod.value = "{{ session('error_modal_method', 'POST') }}";

                document.getElementById('name').value = "{{ old('name') }}";
                document.getElementById('usertype').value = "{{ old('usertype') }}";

                let errorList =
                    "<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>";
                Swal.fire({
                    title: 'Terjadi Kesalahan!',
                    html: errorList,
                    icon: 'error',
                    confirmButtonColor: '#14b8a6'
                });

                userModal.classList.replace('hidden', 'flex');
            });
        </script>
    @endif


    <script>
        $(document).ready(function() {
            // --- DataTable Initialization ---
            let table = $('#userTable').DataTable({
                dom: '<"dt-controls-row"<"dt-length"l><"dt-search"f>>t<"dt-bottom-row"<"dt-info"i><"dt-paging"p>>',
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: "{{ route('karyawan.data') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: function(d) {
                        d.role = $('#role-filter input[name="role"]:checked').val();
                    }
                },
                columns: [{
                        data: 'no',
                        name: 'no',
                        orderable: false,
                        searchable: false
                    },
                    // PENAMBAHAN: Kolom untuk foto profil di tabel
                    {
                        data: 'name',
                        name: 'foto',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `<img src="https://ui-avatars.com/api/?name=${encodeURIComponent(data)}&background=14b8a6&color=fff&size=40" alt="${data}" class="w-10 h-10 rounded-full object-cover">`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'font-semibold'
                    },
                    {
                        data: 'usertype',
                        name: 'usertype',
                        className: 'capitalize'
                    },
                    {
                        data: 'plain_password',
                        name: 'plain_password'
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            let editUrl = `{{ url('admin/pengguna') }}/${data}`;
                            let deleteUrl = `{{ url('admin/pengguna') }}/${data}`;

                            return `
                            <div class="flex gap-2 justify-center">
                                <button class="btn-edit w-9 h-9 flex items-center justify-center rounded-lg bg-amber-500 text-white shadow-md hover:bg-amber-600 transition-all" 
                                    data-id="${data}" 
                                    data-name="${row.name}" 
                                    data-usertype="${row.usertype}">
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
                    searchPlaceholder: "Cari karyawan...",
                    lengthMenu: "Tampil _MENU_ entri",
                    emptyTable: `<div class="text-center p-10"><i class="bi bi-people text-5xl text-slate-300 mb-4 block"></i><h4 class="font-semibold text-xl text-slate-700">Belum Ada Karyawan</h4><p class="text-slate-500">Gunakan tombol 'Tambah Karyawan' untuk membuat data baru.</p></div>`,
                    zeroRecords: `<div class="text-center p-10"><i class="bi bi-search text-5xl text-slate-300 mb-4 block"></i><h4 class="font-semibold text-xl text-slate-700">Karyawan Tidak Ditemukan</h4><p class="text-slate-500">Tidak ada hasil yang cocok dengan pencarian Anda.</p></div>`,
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 entri",
                    infoFiltered: "(disaring dari _MAX_ total entri)",
                    paginate: {
                        next: ">",
                        previous: "<"
                    },
                    processing: '<div class="flex items-center gap-2 text-slate-600"><svg class="animate-spin h-5 w-5 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Memuat Data...</span></div>',
                }
            });

            // --- Role Filter Event ---
            $('#role-filter input[name="role"]').on('change', () => table.ajax.reload());

            // --- Modal Handling ---
            const userModal = document.getElementById('userModal');
            const modalTitle = document.getElementById('modalTitle');
            const userForm = document.getElementById('userForm');
            const formMethod = document.getElementById('formMethod');
            const nameInput = document.getElementById('name');
            const passwordInput = document.getElementById('password');
            const usertypeInput = document.getElementById('usertype');
            const imagePreview = document.getElementById('imagePreview');
            const openModal = () => userModal.classList.replace('hidden', 'flex');
            const closeModal = () => userModal.classList.replace('flex', 'hidden');

            $('.add-btn').on('click', () => {
                userForm.reset();
                modalTitle.innerText = 'Tambah Karyawan';
                userForm.action = "{{ route('pengguna.store') }}";
                formMethod.value = 'POST';
                passwordInput.setAttribute('required', 'required');
                passwordInput.placeholder = "Minimal 8 karakter";
                imagePreview.src = "https://ui-avatars.com/api/?name=?&background=e2e8f0&color=64748b";
                openModal();
            });

            $('#userTable tbody').on('click', '.btn-edit', function() {
                const data = $(this).data();
                userForm.reset();
                modalTitle.innerText = 'Edit Karyawan';
                userForm.action = `{{ url('admin/pengguna') }}/${data.id}`;
                formMethod.value = 'PUT';
                nameInput.value = data.name;
                usertypeInput.value = data.usertype;
                passwordInput.removeAttribute('required');
                passwordInput.placeholder = "Kosongkan jika tidak ingin mengubah";
                imagePreview.src =
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}&background=14b8a6&color=fff`;
                openModal();
            });

            $('.close-modal-btn, .cancel-btn').on('click', closeModal);

            // --- Delete Confirmation ---
            $('#userTable tbody').on('click', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: 'Anda yakin?',
                    text: 'Data karyawan ini akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            // --- UI Logic (User Menu & Logout) ---
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            const logoutButton = document.getElementById('logout-button');

            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenu.classList.toggle('hidden');
            });
            window.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
            });
            logoutButton.addEventListener('click', (e) => {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: "Apakah Anda yakin ingin keluar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#14b8a6',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, keluar!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) logoutButton.closest('form').submit();
                });
            });
        });
    </script>
</body>

</html>
