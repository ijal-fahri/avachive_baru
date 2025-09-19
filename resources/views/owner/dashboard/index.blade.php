<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Owner | Avachive</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
      body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-slate-100">
    <div class="flex">
        <aside class="bg-slate-900 text-slate-300 w-64 min-h-screen p-4 fixed z-40 flex-col hidden md:flex">
            <div>
                <div class="flex flex-col items-center text-center mb-10">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Avachive" class="w-16 h-auto mb-2">
                    <div class="text-2xl font-bold text-teal-400">Avachive Owner</div>
                </div>
                
                <nav class="space-y-3">
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center py-3 px-4 rounded-lg bg-teal-400 text-slate-900 font-semibold shadow-lg">
                        <i class="bi bi-grid-1x2-fill mr-4 text-lg"></i><span class="font-medium">Dashboard</span>
                    </a>
                    <a href="{{ route('owner.manage') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-receipt-cutoff mr-4 text-lg"></i><span class="font-medium">Manajemen Order</span>
                    </a>
                    <a href="{{ route('owner.laporan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-shop-window mr-4 text-lg"></i><span class="font-medium">Data Cabang</span>
                    </a>
                    <a href="{{ route('owner.dataadmin.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-person-badge-fill mr-4 text-lg"></i><span class="font-medium">Data Admin</span>
                    </a>
                    <a href="{{ route('owner.datakaryawan.index') }}" class="flex items-center py-3 px-4 rounded-lg hover:bg-slate-800 hover:text-white transition-colors duration-200">
                        <i class="bi bi-people-fill mr-4 text-lg"></i><span class="font-medium">Data Karyawan</span>
                    </a>
                </nav>
            </div>
        </aside>

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            <header class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
    <div class="flex items-center gap-4">
        <h1 class="text-xl font-semibold text-slate-800">Dashboard Owner</h1>
    </div>
    <div class="relative">
        {{-- GANTI BAGIAN INI --}}
        <button id="profileDropdownBtn" class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all overflow-hidden">
            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto" class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            @endif
        </button>
        {{-- AKHIR BAGIAN PENGGANTIAN --}}
        
        <div id="profileDropdownMenu" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl hidden z-10 border">
            <div class="p-2">
                <a href="{{ route('owner.profile') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 rounded-md">Lihat Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md">Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

            <main class="px-4 md:px-6 pb-28 md:pb-6 mt-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <p class="text-sm text-slate-500">Total Pendapatan</p>
                        <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-400 mt-2">Total dari semua cabang</p>
                        <i class="bi bi-cash-stack text-teal-500 absolute -right-3 -bottom-3 text-7xl opacity-20"></i>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <p class="text-sm text-slate-500">Order Bulan Ini</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $orderBulanIni }}</p>
                        <p class="text-xs text-slate-400 mt-2">Akumulasi semua cabang</p>
                        <i class="bi bi-box-seam text-blue-500 absolute -right-3 -bottom-3 text-7xl opacity-20"></i>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <p class="text-sm text-slate-500">Order Dalam Proses</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $orderDalamProses }}</p>
                        <p class="text-xs text-slate-400 mt-2">Di semua cabang saat ini</p>
                        <i class="bi bi-arrow-repeat text-orange-500 absolute -right-3 -bottom-3 text-7xl opacity-20"></i>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-md relative overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <p class="text-sm text-slate-500">Pelanggan Baru</p>
                        <p class="text-2xl font-bold text-slate-800">{{ $pelangganBaru }}</p>
                        <p class="text-xs text-slate-400 mt-2">Dari semua cabang</p>
                        <i class="bi bi-person-fill-add text-red-500 absolute -right-3 -bottom-3 text-7xl opacity-20"></i>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-slate-700 mb-4">Pipeline Order</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                        @php
                            $statusColors = [
                                'diproses' => 'bg-blue-500',
                                'siap diambil' => 'bg-orange-500',
                                'siap diantar' => 'bg-purple-500',
                                'selesai' => 'bg-green-500',
                            ];
                        @endphp

                        @foreach($pipelineOrders as $status => $orders)
                            @php
                                $normalizedStatus = strtolower(trim($status));
                                $color = $statusColors[$normalizedStatus] ?? 'bg-gray-400';
                            @endphp

                            <div class="bg-white p-4 rounded-xl shadow-sm">
                                <h3 class="font-bold text-slate-800 flex items-center gap-2 mb-4">
                                    <span class="w-3 h-3 {{ $color }} rounded-full"></span>
                                    {{ $status }} ({{ $orders->count() }})
                                </h3>
                                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                                    @forelse($orders as $order)
                                        @php
                                            $layananItems = is_string($order->layanan) ? json_decode($order->layanan, true) : ($order->layanan ?? []);
                                        @endphp
                                        <div class="bg-slate-50 p-3 rounded-lg hover:bg-slate-100 transition">
                                            <p class="font-semibold text-sm text-slate-700">{{ $order->pelanggan->nama ?? 'N/A' }}</p>
                                            <ul class="text-xs text-slate-500 list-disc pl-4 mt-1">
                                                @if(is_array($layananItems))
                                                    @foreach($layananItems as $item)
                                                        <li>{{ $item['nama'] ?? 'N/A' }} (x{{ $item['kuantitas'] ?? '?' }})</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                            <p class="text-xs text-slate-600 mt-1 font-medium">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-slate-400 italic">Tidak ada order</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mt-8">
                    <div class="lg:col-span-3 bg-white p-6 rounded-xl shadow-md">
                        <h2 class="text-lg font-semibold text-slate-700 mb-4">Grafik Transaksi Harian</h2>
                        <div class="h-64"><canvas id="transactionChart"></canvas></div>
                    </div>
                    <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-md">
                        <h2 class="text-lg font-semibold text-slate-700 mb-4">Pelanggan Teratas</h2>
                        <div class="space-y-4">
                            @forelse($pelangganTeratas as $pelanggan)
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-slate-200 rounded-full flex-shrink-0 flex items-center justify-center text-slate-600 font-bold">
                                    {{ strtoupper(substr($pelanggan->pelanggan->nama ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $pelanggan->pelanggan->nama ?? 'Tidak diketahui' }}</p>
                                    <p class="text-sm text-slate-500">{{ $pelanggan->total_orders }} Transaksi</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-slate-500 italic">Belum ada data pelanggan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <nav class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white shadow-[0_-2px_10px_rgba(0,0,0,0.1)] z-30 flex justify-around items-center px-2">
        <a href="{{ route('owner.dashboard') }}" class="flex flex-col items-center gap-1 text-teal-400 font-semibold">
            <i class="bi bi-grid-1x2-fill text-2xl"></i>
            <span class="text-xs">Dashboard</span>
        </a>
        <a href="{{ route('owner.manage') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-receipt-cutoff text-2xl"></i>
            <span class="text-xs">Order</span>
        </a>
        <a href="{{ route('owner.laporan.index') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-shop-window text-2xl"></i>
            <span class="text-xs">Cabang</span>
        </a>
        <a href="{{ route('owner.dataadmin.index') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-person-badge-fill text-2xl"></i>
            <span class="text-xs">Admin</span>
        </a>
        <a href="{{ route('owner.datakaryawan.index') }}" class="flex flex-col items-center gap-1 text-slate-500 hover:text-teal-400 transition-colors">
            <i class="bi bi-people-fill text-2xl"></i>
            <span class="text-xs">Karyawan</span>
        </a>
    </nav>


    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // --- Chart.js Setup Dinamis ---
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(45, 212, 191, 0.4)');
        gradient.addColorStop(1, 'rgba(45, 212, 191, 0)');

        const transaksiLabels = {!! json_encode($transaksiHarian->keys()) !!};
        const transaksiData = {!! json_encode($transaksiHarian->values()) !!};

        new Chart(ctx, { 
            type: 'line', 
            data: { 
                labels: transaksiLabels, 
                datasets: [{ 
                    label: 'Jumlah Transaksi', 
                    data: transaksiData, 
                    borderColor: '#2dd4bf', 
                    borderWidth: 3, 
                    pointBackgroundColor: '#2dd4bf', 
                    pointRadius: 4, 
                    tension: 0.4, 
                    fill: true, 
                    backgroundColor: gradient,
                }] 
            }, 
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, 
                plugins: { legend: { display: false } } 
            } 
        });

        // --- Profile Dropdown Script ---
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
    });
    </script>
</body>
</html>