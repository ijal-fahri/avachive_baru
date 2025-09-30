<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan & Kontak - Laundry Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .faq-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        
        .faq-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-left-color: #3b82f6;
        }
        
        .contact-card {
            transition: all 0.3s ease;
        }
        
        .contact-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }
        
        /* Styling khusus untuk WhatsApp */
        .whatsapp-card {
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: white;
        }
        
        .whatsapp-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.3);
        }

        .email-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.2);
        }
        
        .hours-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(139, 92, 246, 0.2);
        }
        
        /* Animasi untuk elemen yang muncul */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        
        /* Efek glassmorphism */
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Gradient teks */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Sidebar -->
    @include('components.sidebar_pelanggan')
    
    <!-- Main Content -->
    <div class="lg:ml-64 min-h-screen">
        <!-- Header -->
        <div class="sticky top-0 z-20 glass-effect p-4 rounded-xl shadow-lg mb-6 justify-between items-center hidden md:flex">
            <div class="flex items-center gap-4">
                <button id="hamburgerBtn" class="md:hidden text-2xl text-slate-700">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="text-lg font-semibold text-slate-800">Bantuan & Kontak</h1>
            </div>
            <div class="relative">
                <button id="user-menu-button" class="flex items-center gap-3 cursor-pointer">
                    <span class="font-semibold text-sm hidden sm:inline">{{ Auth::user()->name }}</span>
                    @if (Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}"
                            alt="Foto Profil"
                            class="w-8 h-8 rounded-full object-cover border-2 border-blue-400 shadow">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=64&bold=true"
                            alt="Avatar" class="w-8 h-8 rounded-full border-2 border-blue-400 shadow">
                    @endif
                </button>
                <div id="user-menu"
                    class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                    <a href="pengaturan"
                        class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                    <div class="border-t border-slate-200 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" id="logout-button"
                            class="flex items-center gap-3 w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="pt-20 lg:pt-6 px-4 pb-20">
            <div class="max-w-6xl mx-auto">
                <!-- Header Section -->
                <div class="text-center mb-12 animate-fade-in-up">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full mb-6">
                        <i class="bi bi-headset text-3xl text-white"></i>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-4">Kami Siap Membantu Anda</h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Tim support kami siap memberikan solusi terbaik untuk setiap pertanyaan atau masalah yang Anda hadapi.
                    </p>
                </div>


                <!-- FAQ Section -->
                <div class="glass-effect rounded-2xl shadow-lg p-8 mb-16">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                            <i class="bi bi-patch-question text-blue-600"></i>
                            Pertanyaan Umum
                        </h2>
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                            FAQ
                        </span>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- FAQ 1 -->
                        <div class="faq-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                            <button class="faq-question w-full text-left font-semibold text-gray-800 flex justify-between items-center">
                                <span class="text-lg">Berapa lama proses laundry biasanya?</span>
                                <i class="bi bi-chevron-down text-blue-600"></i>
                            </button>
                            <div class="faq-answer mt-4 text-gray-600 hidden pl-2 border-l-4 border-blue-200">
                                <p class="mb-2">Proses laundry reguler memakan waktu 2-3 hari kerja. Untuk layanan express, laundry dapat selesai dalam 24 jam dengan biaya tambahan 30%.</p>
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Laundry Reguler: 2-3 hari kerja</li>
                                    <li>Laundry Express: 24 jam (+30% biaya)</li>
                                    <li>Laundry Kilat: 8 jam (+50% biaya)</li>
                                </ul>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="faq-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                            <button class="faq-question w-full text-left font-semibold text-gray-800 flex justify-between items-center">
                                <span class="text-lg">Bagaimana cara melacak status order saya?</span>
                                <i class="bi bi-chevron-down text-blue-600"></i>
                            </button>
                            <div class="faq-answer mt-4 text-gray-600 hidden pl-2 border-l-4 border-blue-200">
                                <p>Anda dapat melacak status order melalui beberapa cara:</p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li>Melalui halaman "Riwayat Order" di akun Anda</li>
                                    <li>Notifikasi WhatsApp ketika order sudah bisa diambil</li>
                                    <li>Menghubungi admin via WhatsApp untuk info terupdate</li>
                                </ul>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="faq-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                            <button class="faq-question w-full text-left font-semibold text-gray-800 flex justify-between items-center">
                                <span class="text-lg">Bagaimana jika ada kerusakan pada pakaian?</span>
                                <i class="bi bi-chevron-down text-blue-600"></i>
                            </button>
                            <div class="faq-answer mt-4 text-gray-600 hidden pl-2 border-l-4 border-blue-200">
                                <p>Kami bertanggung jawab penuh atas pakaian Anda. Jika terjadi kerusakan:</p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li>Laporkan segera saat mengambil order</li>
                                    <li>Kami akan memberikan kompensasi sesuai ketentuan</li>
                                    <li>Untuk pakaian premium, kami sarankan memilih layanan khusus</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- FAQ 4 -->
                        <div class="faq-card bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
                            <button class="faq-question w-full text-left font-semibold text-gray-800 flex justify-between items-center">
                                <span class="text-lg">Apakah tersedia layanan antar-jemput?</span>
                                <i class="bi bi-chevron-down text-blue-600"></i>
                            </button>
                            <div class="faq-answer mt-4 text-gray-600 hidden pl-2 border-l-4 border-blue-200">
                                <p>Ya, kami menyediakan layanan antar-jemput gratis dengan ketentuan:</p>
                                <ul class="list-disc pl-5 mt-2 space-y-1">
                                    <li>Minimal order 5 kg</li>
                                    <li>Dalam radius 5 km dari outlet kami</li>
                                    <li>Booking minimal 2 jam sebelumnya</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
                    <!-- Tips Section -->
                    <div class="glass-effect rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <i class="bi bi-lightbulb text-yellow-500"></i>
                            Tips Laundry
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="bi bi-1-circle text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Pisahkan Pakaian Berwarna</h4>
                                    <p class="text-gray-600 text-sm">Pisahkan pakaian putih dan berwarna untuk menghindari luntur.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="bi bi-2-circle text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Cek Kantong Sebelum Laundry</h4>
                                    <p class="text-gray-600 text-sm">Pastikan tidak ada barang berharga di kantong pakaian.</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="bi bi-3-circle text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Informasi Khusus</h4>
                                    <p class="text-gray-600 text-sm">Beritahu kami jika ada noda membandel atau bahan khusus.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Service Info Section -->
                    <div class="glass-effect rounded-2xl shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-3">
                            <i class="bi bi-info-circle text-green-500"></i>
                            Informasi Layanan
                        </h2>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-700">Laundry Reguler</span>
                                <span class="font-semibold text-blue-600">Rp 8.000/kg</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-700">Laundry Express</span>
                                <span class="font-semibold text-blue-600">Rp 10.400/kg</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-700">Setrika Saja</span>
                                <span class="font-semibold text-blue-600">Rp 5.000/kg</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-gray-700">Antar Jemput</span>
                                <span class="font-semibold text-green-600">Gratis</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Call to Action Section -->
                <div class="text-center py-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Masih Ada Pertanyaan?</h2>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Jangan ragu untuk menghubungi kami. Tim support kami siap membantu Anda 7 hari dalam seminggu.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="https://wa.me/6285694659069?text=Halo%20Admin%20Laundry%2C%20saya%20membutuhkan%20bantuan" 
                           target="_blank" 
                           class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg transition transform hover:scale-105">
                            <i class="bi bi-whatsapp"></i>
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </main>
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

            // Animasi untuk elemen saat scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Terapkan animasi ke elemen yang diinginkan
            document.querySelectorAll('.contact-card, .faq-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>