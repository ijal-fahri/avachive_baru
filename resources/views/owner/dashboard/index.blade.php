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
        
        {{-- Memanggil sidebar terpusat (yang sudah berisi navigasi desktop & mobile) --}}
        @include('owner.partials.sidebar')

        <div class="flex-1 md:ml-64 h-screen overflow-y-auto">
            <header class="bg-white/80 backdrop-blur-sm p-4 flex justify-between items-center sticky top-4 z-20 mx-4 md:mx-6 rounded-2xl shadow-lg">
                <div class="flex items-center gap-4">
                    <h1 class="text-xl font-semibold text-slate-800">Dashboard Owner</h1>
                </div>
                <div class="relative">
                    <button id="profileDropdownBtn" class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-teal-400 transition-all overflow-hidden">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        @endif
                    </button>
                    
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
                                            {{-- [PERUBAHAN] Logika badge "BARU" ditambahkan di sini --}}
                                            <p class="font-semibold text-sm text-slate-700 flex items-center">
                                                <span>{{ $order->pelanggan->nama ?? 'N/A' }}</span>
                                                @if (isset($order->is_new) && $order->is_new)
                                                    <span class="ml-2 px-2 py-0.5 text-xs font-bold text-white bg-green-500 rounded-full animate-pulse">BARU</span>
                                                @endif
                                            </p>
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
