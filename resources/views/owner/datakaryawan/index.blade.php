<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Karyawan | Avachive</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-input,
        #karyawanTable_wrapper .dt-search input,
        #karyawanTable_wrapper .dt-length select {
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
        #karyawanTable_wrapper .dt-search input:focus,
        #karyawanTable_wrapper .dt-length select:focus {
            border-color: #14b8a6 !important;
            box-shadow: 0 0 0 3px rgba(20, 184, 166, 0.2) !important;
        }

        select.form-input,
        #karyawanTable_wrapper .dt-length select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2364748b' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem !important;
        }

        #karyawanTable_wrapper .dt-search input {
            border-radius: 9999px !important;
        }

        #karyawanTable_wrapper .dt-length select {
            width: auto;
        }

        @media (min-width: 768px) {
            #karyawanTable_wrapper .dt-search input {
                min-width: 250px;
                width: auto;
            }
        }

        #karyawanTable_wrapper .dt-controls-row,
        #karyawanTable_wrapper .dt-bottom-row {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0.5rem 0.25rem;
        }

        #karyawanTable_wrapper .dt-controls-row {
            margin-bottom: 1.5rem;
        }

        #karyawanTable_wrapper .dt-bottom-row {
            margin-top: 1.5rem;
        }

        @media (min-width: 768px) {

            #karyawanTable_wrapper .dt-controls-row,
            #karyawanTable_wrapper .dt-bottom-row {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }

        #karyawanTable {
            border-collapse: collapse;
        }

        #karyawanTable thead th {
            font-weight: 600;
            text-align: left;
            padding: 1rem 1.25rem;
            color: #475569;
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        #karyawanTable tbody td {
            padding: 1rem 1.25rem;
            color: #334155;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        #karyawanTable tbody tr:last-child td {
            border-bottom: none;
        }

        #karyawanTable tbody tr:hover {
            background-color: #f8fafc;
        }

        #karyawanTable_wrapper .dt-info {
            color: #64748b;
            font-size: 0.875rem;
        }

        #karyawanTable_wrapper .dt-paging .dt-paging-button {
            border: 1px solid #cbd5e1 !important;
            transition: all 0.15s ease-in-out !important;
            font-weight: 600 !important;
            border-radius: 0.5rem !important;
            margin: 0 3px !important;
            padding: 0.5em 1em !important;
            background: #fff !important;
            color: #334155 !important;
        }

        #karyawanTable_wrapper .dt-paging .dt-paging-button:not(.disabled):hover {
            background-color: #f1f5f9 !important;
            border-color: #94a3b8 !important;
        }

        #karyawanTable_wrapper .dt-paging .dt-paging-button.current {
            background-color: #14b8a6 !important;
            color: #ffffff !important;
            border-color: #14b8a6 !important;
        }

        #karyawanTable_wrapper .dt-paging .dt-paging-button.disabled {
            color: #94a3b8 !important;
            background-color: #f8fafc !important;
        }

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

<body class="bg-slate-100">
    <div class="flex">
        <aside id="sidebar"
            class="bg-slate-900 text-slate-300 w-64 min-h-screen p-4 fixed z-40 flex-col hidden md:flex">
            <div>
                <div class="flex flex-col items-center text-center mb-10">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Avachive" class="w-16 h-auto mb-2">
                    <div class="text-2xl font-bold text-teal-400">Avachive Owner</div>
                </div>

                <nav class="space-y-3">
                    <a href="{{ route('owner.dashboard') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i
                            class="bi bi-grid-1x2-fill mr-4 text-lg"></i><span class="font-medium">Dashboard</span></a>
                    <a href="{{ route('owner.manage') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i
                            class="bi bi-receipt-cutoff mr-4 text-lg"></i><span class="font-medium">Manajemen
                            Order</span></a>
                    <a href="{{ route('owner.laporan.index') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i
                            class="bi bi-shop-window mr-4 text-lg"></i><span class="font-medium">Data Cabang</span></a>
                    <a href="{{ route('owner.dataadmin.index') }}"
                        class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200"><i
                            class="bi bi-person-badge-fill mr-4 text-lg"></i><span class="font-medium">Data
                            Admin</span></a>
                    <a href="{{ route('owner.datakaryawan.index') }}"
                        class="flex items-center py-3 px-4 rounded-lg bg-teal-400 text-slate-900 font-semibold shadow-lg"><i
                            class="bi bi-people-fill mr-4 text-lg"></i><span class="font-medium">Data
                            Karyawan</span></a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            <header
                class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
                <div class="flex items-center gap-4">
                    <h1 class="text-xl font-semibold text-slate-800">Manajemen Karyawan</h1>
                </div>
                <div class="flex items-center gap-4">
                    <button id="addKaryawanBtn"
                        class="bg-teal-500 text-white font-bold py-2 px-5 rounded-lg flex items-center gap-2 hover:bg-teal-600 transition-colors">
                        <i class="bi bi-plus-circle-fill"></i><span class="hidden sm:block">Tambah Karyawan</span>
                    </button>
                    <div class="relative">
                        <button id="profileDropdownBtn"
                            class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all overflow-hidden">
                            @if (Auth::user()->profile_photo)
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto"
                                    class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            @endif
                        </button>
                        <div id="profileDropdownMenu"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-10 border">
                            <div class="p-2">
                                <a href="{{ route('owner.profile') }}"
                                    class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat
                                    Profile</a>
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <button type="button" id="logoutBtn"
                                        class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="w-full px-4 md:px-6 pb-28 md:pb-6 mt-8">
                @if (session('success'))
                    <div id="success-alert"
                        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg"
                        role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg"
                        role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <section class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 md:p-8">
                    <div class="bg-slate-50 p-4 border border-slate-200 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="cabangFilter" class="block text-sm font-medium text-slate-600">Filter
                                    Cabang</label>
                                <select id="cabangFilter" name="cabang_id" class="mt-1 block w-full form-input">
                                    <option value="semua">Semua Cabang</option>
                                    @foreach ($cabangs as $cabang)
                                        <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="roleFilter" class="block text-sm font-medium text-slate-600">Filter
                                    Role</label>
                                <select id="roleFilter" name="usertype" class="mt-1 block w-full form-input">
                                    <option value="semua">Semua Role</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="driver">Driver</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="karyawanTable" class="w-full text-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Cabang</th>
                                    <th>Role</th>
                                    <th>Password</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>

    {{-- MODAL TAMBAH/EDIT KARYAWAN --}}
    <div id="karyawanFormModal" class="fixed inset-0 bg-black/50 z-50 hidden flex justify-center items-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md animate-modal-in">
            <form id="karyawanForm" action="" method="POST" class="p-6" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod">
                <div class="flex justify-between items-center border-b pb-3 mb-4">
                    <h3 id="modalTitle" class="text-lg font-bold text-slate-800"></h3>
                    <button type="button"
                        class="close-modal-btn text-slate-500 hover:text-slate-800 text-2xl">&times;</button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Foto Profil</label>
                        <div class="flex items-center gap-4">
                            <img id="imagePreview"
                                src="https://ui-avatars.com/api/?name=?&background=e2e8f0&color=64748b" alt="Avatar"
                                class="w-20 h-20 rounded-full object-cover border-2 border-slate-200">
                            <div>
                                <label for="profile_photo"
                                    class="cursor-pointer bg-slate-100 text-slate-800 font-semibold py-2 px-4 rounded-lg text-sm hover:bg-slate-200 transition-colors">
                                    Pilih Foto
                                </label>
                                <input type="file" id="profile_photo" name="profile_photo" class="hidden">
                                <p class="text-xs text-slate-500 mt-2">Opsional. Maks 2MB.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-600 mb-1">Nama
                            Karyawan</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    <div>
                        <label for="cabang_id_modal" class="block text-sm font-medium text-slate-600 mb-1">Penempatan
                            Cabang</label>
                        <select id="cabang_id_modal" name="cabang_id" class="form-input" required>
                            <option value="">-- Pilih Cabang --</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="usertype_modal" class="block text-sm font-medium text-slate-600 mb-1">Role</label>
                        <select id="usertype_modal" name="usertype" class="form-input" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="kasir">Kasir</option>
                            <option value="driver">Driver</option>
                        </select>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-600 mb-1">Password</label>
                        <input type="password" id="password" name="password"
                            placeholder="Isi untuk menambah/mengubah" class="form-input">
                        <p id="password-hint" class="text-xs text-slate-500 mt-1">Kosongkan jika tidak ingin mengubah
                            password.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button"
                        class="cancel-btn px-6 py-2.5 text-sm font-semibold rounded-lg bg-white text-slate-700 border border-slate-300 hover:bg-slate-50 transition active:scale-95">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 text-sm font-semibold rounded-lg bg-teal-500 text-white shadow-md hover:bg-teal-600 transition active:scale-95">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] z-30 flex justify-around items-center px-2">
        <a href="{{ route('owner.dashboard') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-grid-1x2-fill text-2xl"></i>
            <span class="text-xs">Dashboard</span>
        </a>
        <a href="{{ route('owner.manage') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-receipt-cutoff text-2xl"></i>
            <span class="text-xs">Order</span>
        </a>
        <a href="{{ route('owner.laporan.index') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-shop-window text-2xl"></i>
            <span class="text-xs">Cabang</span>
        </a>
        <a href="{{ route('owner.dataadmin.index') }}"
            class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-person-badge-fill text-2xl"></i>
            <span class="text-xs">Admin</span>
        </a>
        <a href="{{ route('owner.datakaryawan.index') }}"
            class="flex flex-col items-center gap-1 text-teal-400 font-semibold">
            <i class="bi bi-people-fill text-2xl"></i>
            <span class="text-xs">Karyawan</span>
        </a>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const karyawanTable = $('#karyawanTable').DataTable({
                dom: '<"dt-controls-row"<"dt-length"l><"dt-search"f>>t<"dt-bottom-row"<"dt-info"i><"dt-paging"p>>',
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('owner.datakaryawan.data') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: d => {
                        d.cabang_id = $('#cabangFilter').val();
                        d.usertype = $('#roleFilter').val();
                    }
                },
                columns: [{
                        data: 'no',
                        name: 'no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'profile_photo',
                        name: 'foto',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            const photoUrl = data ? `{{ asset('storage') }}/${data}` :
                                `https://ui-avatars.com/api/?name=${encodeURIComponent(row.name)}&background=14b8a6&color=fff&size=40`;
                            return `<img src="${photoUrl}" alt="${row.name}" class="w-10 h-10 rounded-full object-cover">`;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'font-semibold'
                    },
                    {
                        data: 'nama_cabang',
                        name: 'cabang.nama_cabang'
                    },
                    {
                        data: 'usertype',
                        name: 'usertype',
                        className: 'capitalize'
                    },
                    {
                        data: 'plain_password',
                        name: 'password',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) return '<span class="text-slate-400">Tidak tersedia</span>';
                            return `
                            <div class="flex items-center gap-2">
                                <span id="pass-text-${row.id}" class="text-slate-400 tracking-wider transition-all duration-200 text-sm">••••••••</span>
                                <button class="toggle-pass-btn text-slate-500 hover:text-slate-800 text-lg" 
                                        data-id="${row.id}" data-password="${data}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                            </div>
                        `;
                        }
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                            <div class="flex gap-2 justify-center">
                                <button class="btn-edit w-9 h-9 flex items-center justify-center rounded-lg bg-amber-500 text-white shadow-md hover:bg-amber-600 transition-all" data-id="${data}">
                                    <span class="sr-only">Edit</span><i class="bi bi-pencil-square"></i>
                                </button>
                                <form method="POST" action="{{ url('owner/datakaryawan') }}/${data}" class="delete-form">
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
                    /* ... Bahasa ... */ }
            });

            const karyawanFormModal = document.getElementById('karyawanFormModal');
            const karyawanForm = document.getElementById('karyawanForm');
            const modalTitle = document.getElementById('modalTitle');
            const formMethodInput = document.getElementById('formMethod');
            const passwordHint = document.getElementById('password-hint');
            const imagePreview = document.getElementById('imagePreview');
            const profilePhotoInput = document.getElementById('profile_photo');

            const openModal = (mode, data = {}) => {
                karyawanForm.reset();
                profilePhotoInput.value = '';
                if (mode === 'add') {
                    modalTitle.textContent = 'Tambah Karyawan Baru';
                    karyawanForm.action = "{{ route('owner.datakaryawan.store') }}";
                    formMethodInput.value = 'POST';
                    $('#password').prop('required', true);
                    passwordHint.style.display = 'none';
                    imagePreview.src = "https://ui-avatars.com/api/?name=?&background=e2e8f0&color=64748b";
                } else {
                    modalTitle.textContent = 'Ubah Data Karyawan';
                    karyawanForm.action = `{{ url('owner/datakaryawan') }}/${data.id}`;
                    formMethodInput.value = 'PUT';
                    $('#name').val(data.name);
                    $('#cabang_id_modal').val(data.cabang_id);
                    $('#usertype_modal').val(data.usertype);
                    $('#password').prop('required', false);
                    passwordHint.style.display = 'block';
                    imagePreview.src = data.profile_photo_url ? data.profile_photo_url :
                        `https://ui-avatars.com/api/?name=${encodeURIComponent(data.name)}&background=14b8a6&color=fff`;
                }
                karyawanFormModal.classList.replace('hidden', 'flex');
            };

            const closeModal = () => karyawanFormModal.classList.replace('flex', 'hidden');

            $('#addKaryawanBtn').on('click', () => openModal('add'));
            $('.close-modal-btn, .cancel-btn').on('click', closeModal);

            $('#karyawanTable tbody').on('click', '.btn-edit', function() {
                const karyawanId = $(this).data('id');
                fetch(`{{ url('owner/datakaryawan') }}/${karyawanId}`)
                    .then(response => response.json())
                    .then(data => {
                        openModal('edit', data);
                    });
            });

            $('#karyawanTable tbody').on('click', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: 'Anda yakin?',
                    text: 'Data karyawan ini akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            $('#karyawanTable tbody').on('click', '.toggle-pass-btn', function() {
                const btn = $(this);
                const passTextSpan = $(`#pass-text-${btn.data('id')}`);
                const eyeIcon = btn.find('i');

                if (eyeIcon.hasClass('bi-eye-fill')) {
                    passTextSpan.text(btn.data('password')).removeClass(
                        'text-slate-400 tracking-wider text-sm').addClass(
                        'text-slate-700 font-semibold');
                    eyeIcon.removeClass('bi-eye-fill').addClass('bi-eye-slash-fill');
                } else {
                    passTextSpan.text('••••••••').addClass('text-slate-400 tracking-wider text-sm')
                        .removeClass('text-slate-700 font-semibold');
                    eyeIcon.removeClass('bi-eye-slash-fill').addClass('bi-eye-fill');
                }
            });

            $('#cabangFilter, #roleFilter').on('change', () => karyawanTable.ajax.reload());

            profilePhotoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    imagePreview.src = URL.createObjectURL(file);
                }
            });

            // --- UI Scripts ---
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');
            profileDropdownBtn.addEventListener('click', () => profileDropdownMenu.classList.toggle('hidden'));
            window.addEventListener('click', (e) => {
                if (profileDropdownBtn && !profileDropdownBtn.contains(e.target) && !profileDropdownMenu
                    .contains(e.target)) {
                    profileDropdownMenu.classList.add('hidden');
                }
            });

            $('#logoutBtn').on('click', () => {
                Swal.fire({
                    title: 'Konfirmasi Logout',
                    text: "Anda yakin ingin keluar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, Logout!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) $('#logout-form').submit();
                });
            });

            const successAlert = $('#success-alert');
            if (successAlert.length) setTimeout(() => {
                successAlert.fadeOut('slow');
            }, 5000);
            const errorAlert = $('#error-alert');
            if (errorAlert.length) setTimeout(() => {
                errorAlert.fadeOut('slow');
            }, 5000);

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan Data',
                    html: `<ul class="mt-2 list-disc list-inside text-sm text-left">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
                    confirmButtonColor: '#14b8a6'
                });
                @if (session('error_modal_type') === 'edit')
                    fetch(`{{ url('owner/datakaryawan') }}/{{ old('id') }}`)
                        .then(res => res.json())
                        .then(data => {
                            openModal('edit', data);
                            $('#name').val("{{ old('name') }}");
                            $('#cabang_id_modal').val("{{ old('cabang_id') }}");
                            $('#usertype_modal').val("{{ old('usertype') }}");
                        });
                @else
                    openModal('add');
                    $('#name').val("{{ old('name') }}");
                    $('#cabang_id_modal').val("{{ old('cabang_id') }}");
                    $('#usertype_modal').val("{{ old('usertype') }}");
                @endif
            @endif
        });
    </script>
</body>

</html>
