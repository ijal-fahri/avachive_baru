<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Avachive Laundry - Cepat, Wangi, Rapi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="description"
        content="Jasa laundry kilat, wangi, dan rapi. Antar-jemput, cuci setrika, express. Pesan sekarang!">
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @keyframes pulse-whatsapp {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            50% {
                transform: scale(1.1);
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }
        }

        .animate-pulse-whatsapp {
            animation: pulse-whatsapp 2s infinite;
        }

        .section-bg {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='%23e0e7ff' stroke-dasharray='5 3'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-animation 5s ease infinite;
        }

        @keyframes gradient-animation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 font-[Poppins]">

    <header class="sticky top-0 z-50 backdrop-blur-lg bg-white/80 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <a href="#home" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto" />
                    <span class="text-lg sm:text-xl font-semibold tracking-wide">
                        <span class="text-indigo-600 group-hover:text-indigo-700 transition">Ava</span>chive
                    </span>
                </a>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
                    <a href="#fitur" class="hover:text-indigo-600 transition-colors">Fitur</a>
                    <a href="#layanan" class="hover:text-indigo-600 transition-colors">Layanan</a>
                    <a href="#proses" class="hover:text-indigo-600 transition-colors">Proses</a>
                    <a href="#testimoni" class="hover:text-indigo-600 transition-colors">Testimoni</a>
                    <a href="#faq" class="hover:text-indigo-600 transition-colors">FAQ</a>
                    <a href="#kontak" class="hover:text-indigo-600 transition-colors">Kontak</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="animate-gradient inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 via-blue-500 to-cyan-500 text-white text-sm font-semibold shadow-lg hover:shadow-indigo-500/30 active:scale-[.98] transition-all duration-300">
                        Login
                        <i class="bi bi-arrow-right-circle"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <section id="home" class="relative overflow-hidden pt-16 lg:pt-24 section-bg">
            <div class="absolute inset-0 pointer-events-none bg-gradient-to-b from-white via-white/80 to-transparent">
            </div>
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-2 gap-12 items-center relative z-10">
                <div data-aos="fade-right">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white shadow-md text-xs font-semibold text-indigo-700 border border-slate-200">
                        🔔 Promo Bulan Ini: Diskon hingga 20%
                    </span>
                    <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold leading-tight text-slate-900">
                        Laundry Kilat, <span class="text-indigo-600">Wangi</span>, & <span
                            class="text-indigo-600">Rapi</span>
                    </h1>
                    <p class="mt-4 text-slate-600 text-base sm:text-lg">
                        Cuci & setrika tanpa ribet. Layanan pengantaran, proses cepat, kualitas hotel. Hemat waktu—biar
                        kami yang urus cucianmu.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="#layanan"
                            class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                            Lihat Layanan
                        </a>
                        <a href="https://wa.me/6285187803535?text=Halo%20saya%20ingin%20pesan%20jasa%20laundry"
                            class="px-6 py-3 rounded-xl bg-white text-indigo-700 font-semibold border border-slate-200 shadow-sm hover:border-indigo-300 hover:shadow-lg transition-all duration-300 transform hover:scale-105"
                            target="_blank" rel="noopener">
                            Pesan via WhatsApp
                        </a>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-slate-600">
                        <div class="flex items-center gap-2"><span
                                class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Express 6–24 Jam
                        </div>
                        <div class="flex items-center gap-2"><span
                                class="inline-block w-2.5 h-2.5 rounded-full bg-cyan-500"></span> Pengantaran</div>
                        <div class="flex items-center gap-2"><span
                                class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500"></span> Garansi Uang Kembali
                        </div>
                    </div>
                </div>

                <div class="relative animate-float" data-aos="fade-left" data-aos-delay="200">
                    <div
                        class="absolute -inset-4 bg-gradient-to-tr from-indigo-200 via-blue-200 to-sky-200 rounded-3xl blur-xl opacity-60">
                    </div>
                    <div class="relative bg-white rounded-3xl shadow-xl p-6">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div
                                class="rounded-2xl border border-slate-100 p-4 transition-all duration-300 hover:shadow-md hover:border-indigo-100">
                                <div class="h-36 rounded-xl bg-indigo-50 flex items-center justify-center"><i
                                        class="bi bi-water text-6xl text-indigo-500"></i></div>
                                <h3 class="mt-3 font-semibold text-slate-800">Cuci & Setrika</h3>
                                <p class="text-sm text-slate-600">Kualitas rapi dan wangi tahan lama.</p>
                            </div>

                            <div
                                class="rounded-2xl border border-slate-100 p-4 transition-all duration-300 hover:shadow-md hover:border-blue-100">
                                <div class="h-36 rounded-xl bg-blue-50 flex items-center justify-center"><i
                                        class="bi bi-truck text-6xl text-blue-600"></i></div>
                                <h3 class="mt-3 font-semibold text-slate-800">Pengantaran</h3>
                                <p class="text-sm text-slate-600">Gratis area tertentu, jadwal fleksibel.</p>
                            </div>
                        </div>

                        <div
                            class="mt-4 rounded-2xl animate-gradient bg-gradient-to-r from-indigo-600 via-blue-500 to-sky-500 text-white p-4">
                            <p class="text-sm">Tip: Jadwalkan <span class="font-semibold">cuci pagi</span> untuk paket
                                express selesai sore hari!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="fitur" class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Kenapa Pilih <span
                            class="text-indigo-600">Kami?</span></h2>
                    <p class="mt-3 text-slate-600">Layanan yang dirancang untuk memudahkan harimu.</p>
                </div>

                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-500 ease-in-out transform hover:-translate-y-2 hover:rotate-1 group"
                        data-aos="fade-up" data-aos-delay="100">
                        <div
                            class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-200 group-hover:text-indigo-700">
                            <i class="bi bi-lightning-charge-fill text-2xl"></i></div>
                        <h3 class="font-semibold text-lg text-slate-800">Express 6–24 Jam</h3>
                        <p class="text-sm text-slate-600 mt-1">Selesai cepat tanpa mengorbankan kualitas.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-500 ease-in-out transform hover:-translate-y-2 hover:-rotate-1 group"
                        data-aos="fade-up" data-aos-delay="200">
                        <div
                            class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-200 group-hover:text-indigo-700">
                            <i class="bi bi-shield-check text-2xl"></i></div>
                        <h3 class="font-semibold text-lg text-slate-800">Detergen Premium</h3>
                        <p class="text-sm text-slate-600 mt-1">Aman untuk kulit & ramah serat pakaian.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-500 ease-in-out transform hover:-translate-y-2 hover:rotate-1 group"
                        data-aos="fade-up" data-aos-delay="300">
                        <div
                            class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-200 group-hover:text-indigo-700">
                            <i class="bi bi-check2-square text-2xl"></i></div>
                        <h3 class="font-semibold text-lg text-slate-800">Pemisahan Pakaian</h3>
                        <p class="text-sm text-slate-600 mt-1">Warna & bahan dipisah agar tetap awet.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-500 ease-in-out transform hover:-translate-y-2 hover:-rotate-1 group"
                        data-aos="fade-up" data-aos-delay="400">
                        <div
                            class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-indigo-200 group-hover:text-indigo-700">
                            <i class="bi bi-award-fill text-2xl"></i></div>
                        <h3 class="font-semibold text-lg text-slate-800">Garansi Kepuasan</h3>
                        <p class="text-sm text-slate-600 mt-1">Ulang cuci gratis jika kurang bersih.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="layanan" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Paket <span
                            class="text-indigo-600">Layanan</span></h2>
                    <p class="mt-3 text-slate-600">Sesuaikan kebutuhanmu—kiloan hemat atau satuan premium.</p>
                </div>

                <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-b from-white to-slate-50 p-6 shadow-lg flex flex-col transition-all duration-500 ease-in-out transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-indigo-500/10"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-slate-800">Laundry Kiloan</h3>
                                <span
                                    class="text-xs px-2 py-1 rounded-full bg-indigo-600 text-white font-semibold">Paling
                                    Hemat</span>
                            </div>
                            <p class="mt-2 text-slate-600 text-sm">Cuci + setrika, lipat rapi, wangi.</p>
                            <div class="mt-4">
                                <div class="text-4xl font-extrabold text-slate-900">Rp<span
                                        class="tabular-nums">8.000</span><span
                                        class="text-lg font-normal text-slate-500">/kg</span></div>
                                <p class="text-xs text-slate-500 mt-1">*Harga contoh, bisa disesuaikan.</p>
                            </div>
                            <ul class="mt-6 space-y-2 text-sm text-slate-700">
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Min. 3 kg</li>
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Estimasi 24–48 jam</li>
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Free parfum premium</li>
                            </ul>
                        </div>
                        <a href="https://wa.me/6285187803535?text=Halo%2C%20saya%20ingin%20pesan%20Laundry%20Kiloan"
                            class="mt-6 block text-center w-full px-4 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
                            Pesan Paket Ini
                        </a>
                    </div>

                    <div class="rounded-2xl border-2 border-indigo-600 bg-gradient-to-b from-white to-indigo-50 p-6 shadow-2xl relative flex flex-col transform hover:-translate-y-2 transition-all duration-500 ease-in-out hover:shadow-indigo-500/30"
                        data-aos="fade-up" data-aos-delay="200">
                        <div
                            class="absolute -top-3 right-4 text-xs px-3 py-1 rounded-full bg-indigo-600 text-white font-bold shadow-lg">
                            POPULER</div>
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-slate-800">Laundry Satuan</h3>
                                <span
                                    class="text-xs px-2 py-1 rounded-full bg-blue-600 text-white font-semibold">Paling
                                    Rapi</span>
                            </div>
                            <p class="mt-2 text-slate-600 text-sm">Cocok untuk jas, gaun, bed cover, dll.</p>
                            <div class="mt-4">
                                <div class="text-4xl font-extrabold text-slate-900">Rp<span
                                        class="tabular-nums">-</span><span
                                        class="text-lg font-normal text-slate-500">/item</span></div>
                                <p class="text-xs text-slate-500 mt-1">*Tergantung jenis & bahan.</p>
                            </div>
                            <ul class="mt-6 space-y-2 text-sm text-slate-700">
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Penanganan khusus</li>
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Pengecekan noda</li>
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Packaging eksklusif</li>
                            </ul>
                        </div>
                        <a href="https://wa.me/6285187803535?text=Halo%2C%20saya%20ingin%20tanya%20harga%20Laundry%20Satuan"
                            class="mt-6 block text-center w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
                            Tanya Harga
                        </a>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-gradient-to-b from-white to-slate-50 p-6 shadow-lg flex flex-col md:col-span-2 lg:col-span-1 transition-all duration-500 ease-in-out transform hover:-translate-y-2 hover:shadow-2xl hover:shadow-emerald-500/10"
                        data-aos="fade-up" data-aos-delay="300">
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-semibold text-slate-800">Express</h3>
                                <span
                                    class="text-xs px-2 py-1 rounded-full bg-emerald-600 text-white font-semibold">6–24
                                    Jam</span>
                            </div>
                            <p class="mt-2 text-slate-600 text-sm">Prioritas antrian—selesai di hari yang sama*.</p>
                            <div class="mt-4">
                                <div class="text-4xl font-extrabold text-slate-900">+<span
                                        class="tabular-nums">50%</span><span
                                        class="text-lg font-normal text-slate-500"> dari tarif</span></div>
                                <p class="text-xs text-slate-500 mt-1">*Tergantung waktu & kuota.</p>
                            </div>
                            <ul class="mt-6 space-y-2 text-sm text-slate-700">
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Pengantaran prioritas</li>
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Notifikasi update</li>
                                <li class="flex items-center gap-2"><i
                                        class="bi bi-check-circle-fill text-green-500"></i> Garansi tepat waktu</li>
                            </ul>
                        </div>
                        <a href="https://wa.me/6285187803535?text=Halo%2C%20saya%20ingin%20pakai%20layanan%20Express"
                            class="mt-6 block text-center w-full px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition-all duration-300 transform hover:scale-105">
                            Cek Ketersediaan
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="proses" class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Proses Mudah dalam <span
                            class="text-indigo-600">4 Langkah</span></h2>
                    <p class="mt-3 text-slate-600">Cepat, transparan, dan tanpa ribet.</p>
                </div>

                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="p-6 rounded-2xl bg-white shadow-lg border border-slate-100 text-center transition-all duration-500 ease-in-out hover:border-indigo-200 hover:shadow-2xl hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="100">
                        <div class="text-4xl font-bold text-indigo-600">01</div>
                        <h3 class="mt-2 font-semibold text-lg text-slate-800">Pendataan</h3>
                        <p class="mt-1 text-sm text-slate-600">Menggunakan teknologi kasir yang efektif dan akurat</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white shadow-lg border border-slate-100 text-center transition-all duration-500 ease-in-out hover:border-indigo-200 hover:shadow-2xl hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="200">
                        <div class="text-4xl font-bold text-indigo-600">02</div>
                        <h3 class="mt-2 font-semibold text-lg text-slate-800">Cuci & Rawat</h3>
                        <p class="mt-1 text-sm text-slate-600">Pemisahan warna & bahan, detergen premium.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white shadow-lg border border-slate-100 text-center transition-all duration-500 ease-in-out hover:border-indigo-200 hover:shadow-2xl hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="300">
                        <div class="text-4xl font-bold text-indigo-600">03</div>
                        <h3 class="mt-2 font-semibold text-lg text-slate-800">Setrika Rapi</h3>
                        <p class="mt-1 text-sm text-slate-600">Uap panas, lipat rapi, dan siap simpan.</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-white shadow-lg border border-slate-100 text-center transition-all duration-500 ease-in-out hover:border-indigo-200 hover:shadow-2xl hover:-translate-y-2"
                        data-aos="fade-up" data-aos-delay="400">
                        <div class="text-4xl font-bold text-indigo-600">04</div>
                        <h3 class="mt-2 font-semibold text-lg text-slate-800">Pengantaran</h3>
                        <p class="mt-1 text-sm text-slate-600">Diantar tepat waktu ke alamatmu.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Apa Kata <span
                            class="text-indigo-600">Pelanggan</span></h2>
                    <p class="mt-3 text-slate-600">Mereka sudah hemat waktu & tenaga.</p>
                </div>

                <div class="mt-12 grid md:grid-cols-3 gap-6">
                    <figure
                        class="p-6 rounded-2xl border border-slate-100 bg-slate-50 shadow-md transition-all duration-500 ease-in-out hover:shadow-xl hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="100">
                        <blockquote class="text-base text-slate-700 italic">"Baju wangi & rapi, selesai cepat. Driver
                            ramah!"</blockquote>
                        <figcaption class="mt-4 text-sm font-semibold text-indigo-700">Rani • Freelancer</figcaption>
                    </figure>
                    <figure
                        class="p-6 rounded-2xl border border-slate-100 bg-slate-50 shadow-md transition-all duration-500 ease-in-out hover:shadow-xl hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="200">
                        <blockquote class="text-base text-slate-700 italic">"Suka paket express-nya, sangat menolong
                            saat mendesak."</blockquote>
                        <figcaption class="mt-4 text-sm font-semibold text-blue-700">Dimas • Karyawan</figcaption>
                    </figure>
                    <figure
                        class="p-6 rounded-2xl border border-slate-100 bg-slate-50 shadow-md transition-all duration-500 ease-in-out hover:shadow-xl hover:-translate-y-1"
                        data-aos="fade-up" data-aos-delay="300">
                        <blockquote class="text-base text-slate-700 italic">"Harga masuk akal, hasil memuaskan.
                            Recommended!"</blockquote>
                        <figcaption class="mt-4 text-sm font-semibold text-sky-700">Ayu • Ibu Rumah Tangga</figcaption>
                    </figure>
                </div>
            </div>
        </section>

        <section id="faq" class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
                <div class="text-center max-w-2xl mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900">Pertanyaan yang Sering <span
                            class="text-indigo-600">Diajukan</span></h2>
                    <p class="mt-3 text-slate-600">Masih bingung? Mungkin jawabanmu ada di sini.</p>
                </div>

                <div class="mt-12 space-y-4">
                    <details
                        class="group rounded-xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-lg transition-shadow duration-300 hover:border-indigo-300">
                        <summary
                            class="flex cursor-pointer list-none items-center justify-between font-semibold text-slate-800">
                            Berapa lama proses laundry?
                            <span class="transition group-open:rotate-180 text-indigo-500"><i
                                    class="bi bi-chevron-down"></i></span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-600">Reguler 24–48 jam. Express bisa 6–24 jam tergantung
                            antrean & kuota yang tersedia.</p>
                    </details>

                    <details
                        class="group rounded-xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-lg transition-shadow duration-300 hover:border-indigo-300">
                        <summary
                            class="flex cursor-pointer list-none items-center justify-between font-semibold text-slate-800">
                            Apakah ada layanan pengantaran?
                            <span class="transition group-open:rotate-180 text-indigo-500"><i
                                    class="bi bi-chevron-down"></i></span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-600">Ya, kami menyediakan layanan antar-jemput. Gratis untuk
                            area tertentu dengan radius maksimal 2,3 KM dari lokasi kami.</p>
                    </details>

                    <details
                        class="group rounded-xl border border-slate-200 bg-white p-5 shadow-sm open:shadow-lg transition-shadow duration-300 hover:border-indigo-300">
                        <summary
                            class="flex cursor-pointer list-none items-center justify-between font-semibold text-slate-800">
                            Bagaimana jika hasil tidak memuaskan?
                            <span class="transition group-open:rotate-180 text-indigo-500"><i
                                    class="bi bi-chevron-down"></i></span>
                        </summary>
                        <p class="mt-3 text-sm text-slate-600">Kami menyediakan garansi cuci ulang gratis. Silakan
                            klaim dalam waktu 1x24 jam setelah pakaian diterima jika Anda merasa kurang puas.</p>
                    </details>
                </div>

                <p class="mt-6 text-center text-xs text-gray-500">*Ketentuan jam mengikuti ketersediaan. Syarat &
                    Ketentuan berlaku.</p>
            </div>
        </section>

        <section class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="zoom-in">
                <div
                    class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-8 md:p-12 animate-gradient">
                    <div class="max-w-2xl relative z-10">
                        <h3 class="text-3xl md:text-4xl font-bold">Siap Bebas dari Urusan Cucian?</h3>
                        <p class="mt-3 text-white/90">Klik pesan sekarang, kurir kami siap menjemput cucianmu.</p>
                        <div class="mt-6 flex flex-wrap gap-4">
                            <a href="https://wa.me/6285187803535?text=Halo%20Laundry%2C%20saya%20ingin%20pickup%20cucian"
                                class="px-6 py-3 rounded-xl bg-white text-indigo-700 font-semibold hover:bg-white/90 transition-all duration-300 shadow-lg transform hover:scale-105"
                                target="_blank" rel="noopener">
                                Pesan via WhatsApp
                            </a>
                            <a href="{{ route('login') }}"
                                class="px-6 py-3 rounded-xl border border-white/40 font-semibold hover:bg-white/10 transition">
                                Login Admin/Staff
                            </a>
                        </div>
                    </div>
                    <div
                        class="absolute -right-20 -bottom-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none">
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="kontak" class="pt-16 pb-32 md:pb-8 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <a href="#home" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
                        <span class="text-lg font-semibold"><span class="text-indigo-600">Ava</span>chive</span>
                    </a>
                    <p class="mt-3 text-sm text-slate-600 max-w-md">
                        Laundry terpercaya untuk kebutuhan harian, kantor, hingga acara spesial. Kami rawat pakaianmu
                        seperti milik kami sendiri.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-slate-800">Kontak</h4>
                    <ul class="mt-3 text-sm text-slate-600 space-y-2">
                        <li><i class="bi bi-geo-alt-fill text-indigo-500 mr-2"></i>Laladon, Ciomas</li>
                        <li><i class="bi bi-telephone-fill text-indigo-500 mr-2"></i>0812-3456-789</li>
                        <li><i class="bi bi-envelope-fill text-indigo-500 mr-2"></i>admin@gmail.com</li>
                        <li>
                            <a href="https://wa.me/6285187803535" target="_blank" rel="noopener"
                                class="inline-block text-indigo-600 hover:text-indigo-700 font-semibold">
                                Chat WhatsApp →
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-slate-800">Navigasi</h4>
                    <ul class="mt-3 text-sm text-slate-600 space-y-2">
                        <li><a href="#fitur" class="hover:text-indigo-600">Fitur</a></li>
                        <li><a href="#layanan" class="hover:text-indigo-600">Layanan</a></li>
                        <li><a href="#proses" class="hover:text-indigo-600">Proses</a></li>
                        <li><a href="#faq" class="hover:text-indigo-600">FAQ</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 border-t border-slate-100 pt-6 text-xs text-slate-500 text-center">
                <p>© <span class="tabular-nums">{{ date('Y') }}</span> Avachive. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white/80 backdrop-blur-sm border-t border-slate-100 shadow-[0_-2px_10px_rgba(0,0,0,0.05)] z-50 flex justify-around items-center px-2">
        <a href="#home"
            class="mobile-nav-link flex flex-col items-center gap-1 text-slate-600 hover:text-indigo-600 transition-colors group">
            <i class="bi bi-house-door-fill text-2xl transition-transform group-hover:scale-110"></i>
            <span class="text-xs font-medium">Home</span>
        </a>
        <a href="#layanan"
            class="mobile-nav-link flex flex-col items-center gap-1 text-slate-600 hover:text-indigo-600 transition-colors group">
            <i class="bi bi-tags-fill text-2xl transition-transform group-hover:scale-110"></i>
            <span class="text-xs font-medium">Layanan</span>
        </a>
        <a href="#proses"
            class="mobile-nav-link flex flex-col items-center gap-1 text-slate-600 hover:text-indigo-600 transition-colors group">
            <i class="bi bi-clipboard-check-fill text-2xl transition-transform group-hover:scale-110"></i>
            <span class="text-xs font-medium">Proses</span>
        </a>
        <a href="#kontak"
            class="mobile-nav-link flex flex-col items-center gap-1 text-slate-600 hover:text-indigo-600 transition-colors group">
            <i class="bi bi-telephone-fill text-2xl transition-transform group-hover:scale-110"></i>
            <span class="text-xs font-medium">Kontak</span>
        </a>
    </nav>

    <a href="https://wa.me/6285187803535?text=Halo%20Laundry%2C%20saya%20ingin%20bertanya"
        class="animate-pulse-whatsapp fixed bottom-24 md:bottom-5 right-5 p-3 rounded-full shadow-lg bg-green-500 text-white"
        target="_blank" rel="noopener" aria-label="Chat WhatsApp">
        <i class="bi bi-whatsapp text-2xl"></i>
    </a>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
        });

        document.addEventListener('DOMContentLoaded', () => {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.mobile-nav-link');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navLinks.forEach(link => {
                            link.classList.remove('text-indigo-600');
                            if (link.getAttribute('href').substring(1) === entry.target
                                .id) {
                                link.classList.add('text-indigo-600');
                            }
                        });
                    }
                });
            }, {
                rootMargin: '-50% 0px -50% 0px'
            });

            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>

</body>

</html>
