<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Pelanggan Laundry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* [TAMBAHAN] Styling untuk welcome section dengan WhatsApp */
        .welcome-wa-container {
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .welcome-wa-icon {
            color: #25D366;
            transition: all 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .welcome-wa-icon:hover {
            color: #128C7E;
            transform: scale(1.1);
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
        }

        .welcome-wa-link {
            color: #e8f5e8;
            transition: all 0.3s ease;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .welcome-wa-link:hover {
            color: #ffffff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .welcome-main-icon {
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .welcome-main-icon:hover {
            transform: scale(1.05) rotate(5deg);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
            border-color: rgba(255,255,255,0.5);
        }

        /* [TAMBAHAN] CSS untuk indicators (dots) */
        .indicator-dot {
            transition: all 0.3s ease;
        }

        .indicator-dot.active {
            background-color: #3b82f6;
            transform: scale(1.2);
        }

        /* [PERBAIKAN] CSS untuk slider yang bisa di-scroll manual di desktop */
        .slider {
            scroll-behavior: smooth;
            cursor: grab;
        }

        .slider:active {
            cursor: grabbing;
        }

        /* Enable scroll di desktop tapi sembunyikan scrollbar */
        @media (min-width: 768px) {
            .slider {
                overflow-x: auto;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }
            
            .slider::-webkit-scrollbar {
                display: none;
            }
        }

        /* Responsif untuk indicators */
        @media (max-width: 767px) {
            #promo-indicators {
                margin-top: 1rem;
            }
        }

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
        }

        /* [DIUBAH] CSS untuk slider promo baru */
        .slider-container {
            position: relative;
        }

        .slider {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .slider::-webkit-scrollbar {
            display: none;
        }

        .slide {
            scroll-snap-align: start;
            flex-shrink: 0;
            width: 80%;
            margin-right: 1rem;
        }

        @media (min-width: 768px) {
            .slide {
                width: calc(50% - 0.5rem);
            }
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .slider-nav:hover {
            background-color: white;
        }

        .slider-nav.prev {
            left: -1.25rem;
        }

        .slider-nav.next {
            right: -1.25rem;
        }

        /* [TAMBAHAN] CSS untuk tombol WhatsApp */
        .whatsapp-button {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        @media (max-width: 767px) {
    .whatsapp-button {
        bottom: 80px; /* Atur lebih tinggi agar tidak menutupi nav bawah */
        right: 20px;
    }
}

        .whatsapp-button:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.6);
        }

        .whatsapp-button i {
            color: white;
            font-size: 28px;
        }

        /* [TAMBAHAN] CSS untuk modal WhatsApp */
        .whatsapp-modal {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 300px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            padding: 20px;
            transform: translateY(10px);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .whatsapp-modal.active {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .whatsapp-modal h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #333;
        }

        .whatsapp-modal p {
            font-size: 14px;
            color: #666;
            margin-bottom: 16px;
        }

        .whatsapp-modal .modal-actions {
            display: flex;
            gap: 10px;
        }

        .whatsapp-modal .modal-actions button {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .whatsapp-modal .modal-actions .btn-cancel {
            background-color: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .whatsapp-modal .modal-actions .btn-cancel:hover {
            background-color: #eaeaea;
        }

        .whatsapp-modal .modal-actions .btn-confirm {
            background-color: #25D366;
            color: white;
            border: none;
        }

        .whatsapp-modal .modal-actions .btn-confirm:hover {
            background-color: #128C7E;
        }

        /* [TAMBAHAN] CSS untuk tombol pesan di kartu layanan */
        .layanan-card {
            position: relative;
        }

        .pesan-button {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 36px;
            height: 36px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s;
            opacity: 0;
        }

        .layanan-card:hover .pesan-button {
            opacity: 1;
        }

        .pesan-button:hover {
            transform: scale(1.1);
            background-color: #128C7E;
        }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Sidebar -->
    @include('components.sidebar_pelanggan')

    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen">
        <!-- Header -->
        <div class="sticky top-0 z-20 bg-white/80 backdrop-blur-sm border border-slate-200/60 p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
            <div class="flex items-center gap-4">
                <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="text-lg font-semibold text-slate-800">Home</h1>
            </div>
            <div class="relative">
                <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                    <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                    @if (Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto Profil" class="w-8 h-8 rounded-full object-cover border-2 border-blue-400 shadow">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=64&bold=true" alt="Avatar" class="w-8 h-8 rounded-full border-2 border-blue-400 shadow">
                    @endif
                </button>
                <div id="user-menu" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                    <a href="pengaturan" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                    <div class="border-t border-slate-200 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" id="logout-button" class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="pt-20 lg:pt-6 px-4 pb-20">
            <!-- Welcome Section dengan WhatsApp yang Diperbaiki -->
            <div class="bg-gradient-to-r from-blue-500 to-teal-400 rounded-2xl p-6 text-white shadow-lg mb-8 relative overflow-hidden">
                <!-- Background pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Ccircle cx=\"30\" cy=\"30\" r=\"2\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                
                <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <!-- Bagian teks selamat datang -->
                    <div class="flex-1">
                        <h2 class="text-2xl md:text-3xl font-bold mb-2 text-white drop-shadow-lg">Selamat Datang, {{ Auth::user()->name ?? 'Pelanggan' }}! 👋</h2>
                        <p class="text-lg opacity-95 mb-4 text-blue-100">Mari kita jaga pakaian Anda tetap bersih, wangi, dan rapi!</p>
                        
                        <!-- Container WhatsApp yang menarik -->
                        <div class="welcome-wa-container rounded-xl p-4 md:p-5 mt-4">
                            <div class="flex items-start gap-4">
                                <!-- Konten teks -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg md:text-xl mb-2 text-white drop-shadow-md">
                                        🚀 Pesan Cepat via WhatsApp!
                                    </h3>
                                    <p class="text-sm md:text-base opacity-95 leading-relaxed text-blue-100 mb-3">
                                        Ingin laundry kilat? Order sekarang via WhatsApp! Dapatkan layanan express dengan penjemputan gratis dan proses lebih cepat. Tim profesional kami siap melayani!
                                    </p>
                                    <div class="flex flex-wrap gap-3 mt-4">
                                        <button class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg font-semibold text-sm transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5" id="welcome-wa-button">
                                            <i class=" text-green-500 bi bi-whatsapp mr-2"></i>Pesan Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-5 shadow-md border-l-4 border-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Data Order</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['hari_ini'] }}</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i class="bi bi-cart-check text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-md border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Order Selesai</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['selesai'] }}</h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i class="bi bi-check-circle text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-md border-l-4 border-orange-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Dalam Proses</p>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['diproses'] }}</h3>
                        </div>
                        <div class="bg-orange-100 p-3 rounded-full">
                            <i class="bi bi-arrow-repeat text-orange-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Terbaru Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                        <i class="bi bi-clock-history text-blue-600"></i> Data Order
                    </h2>
                </div>
                <div class="space-y-4">
                    @forelse ($orderTerbaru as $order)
                        @php
                            $statusInfo = match (strtolower($order->status)) {
                                'diproses' => ['class' => 'blue', 'text' => 'Diproses'],
                                'bisa-diambil', 'sudah bisa diambil' => ['class' => 'orange', 'text' => 'Sudah Bisa Diambil'],
                                'selesai' => ['class' => 'green', 'text' => 'Selesai'],
                                'menunggu' => ['class' => 'yellow', 'text' => 'Menunggu'],
                                default => ['class' => 'gray', 'text' => $order->status],
                            };
                            $layananItems = json_decode($order->layanan, true);
                        @endphp
                        <div class="order-card bg-gray-50 rounded-xl p-5 border border-gray-200 border-l-4 border-l-{{ $statusInfo['class'] }}-500">
                            <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="font-semibold text-lg">#{{ $order->id_order ?? $order->id }}</h3>
                                        <span class="status-badge bg-{{ $statusInfo['class'] }}-100 text-{{ $statusInfo['class'] }}-800">{{ $statusInfo['text'] }}</span>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span><i class="bi bi-calendar mr-1"></i>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d M Y') }}</span>
                                        <span class="font-bold"><i class="bi bi-wallet mr-1"></i> Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Detail Layanan:</p>
                                @if (is_array($layananItems))
                                    <ul class="space-y-1 text-sm text-gray-600 pl-1">
                                        @foreach ($layananItems as $item)
                                            <li class="flex justify-between items-center">
                                                <span>- {{ $item['nama'] ?? 'Layanan tidak diketahui' }}</span>
                                                <span class="font-medium bg-gray-200 text-gray-800 px-2 py-0.5 rounded-md">{{ $item['kuantitas'] ?? '?' }} {{ $item['satuan'] ?? '' }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-xs text-gray-400">Detail layanan tidak tersedia.</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 px-4 border-2 border-dashed rounded-lg">
                            <i class="bi bi-box-seam text-4xl text-gray-300"></i>
                            <p class="mt-4 text-gray-500">Anda belum memiliki order hari ini.</p>
                            <p class="text-sm text-gray-400">Ayo mulai order baru!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Promo Section -->
            @if ($semuaPromo->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                        <i class="bi bi-percent text-red-600"></i>
                        Promo Spesial untuk Anda
                    </h2>

                    <div class="slider-container relative">
                        <div id="promo-slider" class="slider">
                            @foreach ($semuaPromo as $index => $promo)
                                @php
                                    $colors = [
                                        'from-red-500 to-orange-400',
                                        'from-purple-500 to-pink-400',
                                        'from-green-500 to-teal-400',
                                        'from-blue-500 to-indigo-400',
                                        'from-yellow-400 to-amber-500',
                                    ];
                                    $gradientClass = $colors[$index % count($colors)];
                                @endphp
                                <div class="slide">
                                    <div class="bg-gradient-to-r {{ $gradientClass }} h-full rounded-xl p-5 text-white flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-start justify-between">
                                                <span class="bg-white/20 text-xs px-2 py-1 rounded-full">HOT OFFER</span>
                                                <div class="text-3xl font-bold">{{ $promo->diskon }}%</div>
                                            </div>
                                            <h3 class="text-lg font-bold mt-2">
                                                <span class="text-gray-200 line-through mr-2">Rp{{ number_format($promo->harga, 0, ',', '.') }}</span>
                                                <span class="text-white">Rp{{ number_format($promo->harga - ($promo->harga * $promo->diskon) / 100, 0, ',', '.') }}</span>
                                            </h3>
                                            <p class="text-sm opacity-90 font-bold mt-1">{{ $promo->nama }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div id="promo-indicators" class="flex justify-center space-x-2 mt-4">
                            <!-- Indicators akan dibuat dinamis oleh JavaScript -->
                        </div>
                    </div>
                </div>
            @endif

            <!-- Layanan Favorit Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="bi bi-heart text-red-600"></i> Layanan Favorit Anda
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($layananFavorit as $nama => $layanan)
                        <div class="layanan-card border border-gray-200 rounded-xl p-4 hover:border-blue-300 hover:shadow-md transition">
                            
                            <div class="flex items-center gap-3 mb-3">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <i class="bi bi-droplet text-blue-600 text-xl"></i>
                                </div>
                                <h3 class="font-semibold">{{ $layanan->nama }}</h3>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 h-10">
                                {{ $layanan->deskripsi ?? 'Deskripsi tidak tersedia.' }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-blue-600">Rp {{ number_format($layanan->harga, 0, ',', '.') }}{{ $layanan->satuan }}</span>
                                <span class="text-xs text-gray-500">{{ $frekuensiLayanan[$nama] ?? 0 }}x dipesan</span>
                            </div>
                        </div>
                    @empty
                        <div class="md:col-span-3 text-center py-8 px-4 border-2 border-dashed rounded-lg">
                            <i class="bi bi-star text-4xl text-gray-300"></i>
                            <p class="mt-4 text-gray-500">Anda belum memiliki layanan favorit.</p>
                            <p class="text-sm text-gray-400">Layanan yang sering Anda pesan akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <!-- Tombol WhatsApp Fixed -->
    <div class="whatsapp-button" id="whatsapp-button">
        <i class="bi bi-whatsapp"></i>
    </div>

    <!-- Modal Konfirmasi WhatsApp -->
    <div class="whatsapp-modal" id="whatsapp-modal">
        <h3>Pesan via WhatsApp</h3>
        <p>Anda akan diarahkan ke WhatsApp untuk memesan layanan laundry. Lanjutkan?</p>
        <div class="modal-actions">
            <button class="btn-cancel" id="cancel-order">Batal</button>
            <button class="btn-confirm" id="confirm-order">Pesan Sekarang</button>
        </div>
    </div>


<script>
document.addEventListener('DOMContentLoaded', function() {
// FAQ Toggle Functionality
            document.querySelectorAll('.faq-question').forEach(question => {
                question.addEventListener('click', function() {
                    const answer = this.nextElementSibling;
                    const icon = this.querySelector('i');
                    
                    // Toggle answer visibility
                    answer.classList.toggle('hidden');
                    
                    // Rotate icon
                    if (answer.classList.contains('hidden')) {
                        icon.classList.remove('bi-chevron-up');
                        icon.classList.add('bi-chevron-down');
                    } else {
                        icon.classList.remove('bi-chevron-down');
                        icon.classList.add('bi-chevron-up');
                    }
                });
            });

            // Toggle user menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                });

                // Optional: close menu if click outside
                document.addEventListener('click', function(e) {
                    if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }

            // Konfirmasi logout dengan SweetAlert
            const logoutButton = document.getElementById('logout-button');
            if (logoutButton) {
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
            }

    // --- PROMO SLIDER INDICATOR ---
    const slider = document.getElementById('promo-slider');
    const indicatorsContainer = document.getElementById('promo-indicators');
    let autoSlideInterval;
    let isAutoSliding = true;
    let currentPageIndex = 0;
    let isDragging = false;
    let startX;
    let scrollLeft;

    if (slider && indicatorsContainer) {
        const totalSlides = slider.children.length;
        let slidesPerView = 1;
        let totalPages = totalSlides;

        const calculateSlidesPerView = () => {
            if (window.innerWidth >= 768) {
                slidesPerView = 2;
            } else {
                slidesPerView = 1;
            }
            totalPages = Math.ceil(totalSlides / slidesPerView);
            return slidesPerView;
        };

        calculateSlidesPerView();

        const createIndicators = () => {
            indicatorsContainer.innerHTML = '';
            for (let i = 0; i < totalPages; i++) {
                const dot = document.createElement('div');
                dot.className = `indicator-dot w-2 h-2 bg-gray-300 rounded-full transition-all duration-300 cursor-pointer${i === 0 ? ' active' : ''}`;
                dot.dataset.page = i;
                indicatorsContainer.appendChild(dot);
            }
        };

        createIndicators();

        const firstSlide = slider.querySelector('.slide');
        const slideWidth = firstSlide ? firstSlide.offsetWidth + 16 : 300;

        const startAutoSlide = () => {
            stopAutoSlide();
            autoSlideInterval = setInterval(() => {
                if (!isAutoSliding || isDragging) return;
                const maxScroll = slider.scrollWidth - slider.clientWidth;
                if (slider.scrollLeft >= maxScroll - 1) {
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                    currentPageIndex = 0;
                } else {
                    const nextPageIndex = (currentPageIndex + 1) % totalPages;
                    slider.scrollTo({
                        left: nextPageIndex * slideWidth * slidesPerView,
                        behavior: 'smooth'
                    });
                    currentPageIndex = nextPageIndex;
                }
                updateIndicators();
            }, 3000);
        };

        const stopAutoSlide = () => {
            clearInterval(autoSlideInterval);
        };

        const updateIndicators = () => {
            const dots = indicatorsContainer.querySelectorAll('.indicator-dot');
            dots.forEach((dot, index) => {
                if (index === currentPageIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        };

        const snapToPage = () => {
            const scrollPosition = slider.scrollLeft;
            currentPageIndex = Math.round(scrollPosition / (slideWidth * slidesPerView));
            if (currentPageIndex >= totalPages) currentPageIndex = totalPages - 1;
            if (currentPageIndex < 0) currentPageIndex = 0;
            slider.scrollTo({
                left: currentPageIndex * slideWidth * slidesPerView,
                behavior: 'smooth'
            });
            updateIndicators();
        };

        // Drag events
        slider.addEventListener('mousedown', (e) => {
            isDragging = true;
            isAutoSliding = false;
            stopAutoSlide();
            startX = e.pageX;
            scrollLeft = slider.scrollLeft;
            slider.style.cursor = 'grabbing';
            slider.style.scrollSnapType = 'none';
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
        slider.addEventListener('mouseup', () => {
            isDragging = false;
            slider.style.cursor = 'grab';
            slider.style.scrollSnapType = 'x mandatory';
            setTimeout(snapToPage, 100);
            setTimeout(() => {
                isAutoSliding = true;
                startAutoSlide();
            }, 2000);
        });
        slider.addEventListener('mouseleave', () => {
            isDragging = false;
            slider.style.cursor = 'grab';
            slider.style.scrollSnapType = 'x mandatory';
        });

        // Touch events
        slider.addEventListener('touchstart', (e) => {
            isDragging = true;
            isAutoSliding = false;
            stopAutoSlide();
            startX = e.touches[0].pageX;
            scrollLeft = slider.scrollLeft;
        }, { passive: true });
        slider.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const x = e.touches[0].pageX;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        }, { passive: false });
        slider.addEventListener('touchend', () => {
            isDragging = false;
            setTimeout(snapToPage, 100);
            setTimeout(() => {
                isAutoSliding = true;
                startAutoSlide();
            }, 2000);
        });

        // Indicator click
        indicatorsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('indicator-dot')) {
                const targetPage = parseInt(e.target.dataset.page);
                slider.scrollTo({
                    left: targetPage * slideWidth * slidesPerView,
                    behavior: 'smooth'
                });
                currentPageIndex = targetPage;
                updateIndicators();
                stopAutoSlide();
                setTimeout(startAutoSlide, 3000);
            }
        });

        // Pause auto-slide saat hover
        slider.addEventListener('mouseenter', () => { isAutoSliding = false; stopAutoSlide(); });
        slider.addEventListener('mouseleave', () => { isAutoSliding = true; startAutoSlide(); });

        // Handle window resize
        window.addEventListener('resize', () => {
            const oldSlidesPerView = slidesPerView;
            calculateSlidesPerView();
            if (oldSlidesPerView !== slidesPerView) {
                createIndicators();
                currentPageIndex = 0;
                slider.scrollTo({ left: 0, behavior: 'smooth' });
                updateIndicators();
            }
        });

        // Inisialisasi
        updateIndicators();
        startAutoSlide();
    }

    @if(Auth::user()->cabang->no_whatsapp)
    // --- WHATSAPP BUTTON LANGSUNG KIRIM ---
    const whatsappButton = document.getElementById('whatsapp-button');
    const pesanButtons = document.querySelectorAll('.pesan-button');
    const welcomeWaButton = document.getElementById('welcome-wa-button');
    const whatsappNumber = "{{ Auth::user()->cabang->no_whatsapp }}"; // Ganti sesuai kebutuhan
    @endif

    // WhatsApp utama (pojok kanan bawah)
    if (whatsappButton) {
        whatsappButton.addEventListener('click', function() {
            const message = encodeURIComponent("Halo, saya ingin memesan layanan laundry");
            const whatsappURL = `https://wa.me/${whatsappNumber}?text=${message}`;
            window.open(whatsappURL, '_blank');
        });
    }

    // Tombol pesan di setiap kartu layanan
    pesanButtons.forEach(button => {
        button.addEventListener('click', function() {
            const layanan = this.getAttribute('data-layanan');
            const harga = parseInt(this.getAttribute('data-harga'));
            const message = encodeURIComponent(`Halo, saya ingin memesan ${layanan} seharga Rp ${harga.toLocaleString('id-ID')}.`);
            const whatsappURL = `https://wa.me/${whatsappNumber}?text=${message}`;
            window.open(whatsappURL, '_blank');
        });
    });

    // Tombol "Pesan Sekarang" di welcome section
    if (welcomeWaButton) {
        welcomeWaButton.addEventListener('click', function() {
            const message = encodeURIComponent("Halo, saya ingin memesan layanan laundry");
            const whatsappURL = `https://wa.me/${whatsappNumber}?text=${message}`;
            window.open(whatsappURL, '_blank');
        });
    }
});
</script>
</body>
</html>