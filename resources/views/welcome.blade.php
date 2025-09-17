<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Avachive Laundry</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <meta name="description" content="Jasa laundry kilat, wangi, dan rapi. Antar-jemput, cuci setrika, express. Pesan sekarang!">
  
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
 <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
  <style>
    @keyframes pulse-whatsapp {
      0%, 100% {
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
  </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-sky-100 text-gray-800 font-[Poppins]">

  <header class="sticky top-0 z-50 backdrop-blur bg-white/70 border-b border-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="h-16 flex items-center justify-between">
        <a href="#home" class="flex items-center gap-3 group">
          <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto"/>
          <span class="text-lg sm:text-xl font-semibold tracking-wide">
            <span class="text-indigo-600 group-hover:text-indigo-700 transition">Ava</span>chive
          </span>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm">
          <a href="#fitur" class="hover:text-indigo-600 transition">Fitur</a>
          <a href="#layanan" class="hover:text-indigo-600 transition">Layanan</a>
          <a href="#proses" class="hover:text-indigo-600 transition">Proses</a>
          <a href="#testimoni" class="hover:text-indigo-600 transition">Testimoni</a>
          <a href="#faq" class="hover:text-indigo-600 transition">FAQ</a>
          <a href="#kontak" class="hover:text-indigo-600 transition">Kontak</a>
        </nav>

        <div class="flex items-center gap-3">
          <a href="{{ route('login') }}"
             class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-600 text-white text-sm font-semibold shadow hover:from-indigo-700 hover:to-blue-700 active:scale-[.98] transition-all duration-300">
            Login
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h8.586L10.293 6.707a1 1 0 111.414-1.414l4.5 4.5a1 1 0 010 1.414l-4.5 4.5a1 1 0 11-1.414-1.414L12.586 11H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </header>

  <main>
    <section id="home" class="relative overflow-hidden pt-16 lg:pt-24">
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-indigo-200/50 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-blue-200/50 rounded-full blur-3xl"></div>
      </div>

      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-2 gap-12 items-center">
        <div data-aos="fade-right">
          <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white shadow text-xs font-semibold text-indigo-700">
            🔔 Promo Bulan Ini: Diskon hingga 20%
          </span>
          <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold leading-tight">
            Laundry Kilat, <span class="text-indigo-600">Wangi</span>, & <span class="text-indigo-600">Rapi</span>
          </h1>
          <p class="mt-4 text-gray-600 text-base sm:text-lg">
            Cuci & setrika tanpa ribet. Layanan pengantaran, proses cepat, kualitas hotel. Hemat waktu—biar kami yang urus cucianmu.
          </p>

          <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="#layanan"
               class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold shadow hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
              Lihat Layanan
            </a>
            <a href="https://wa.me/6285187803535?text=Halo%20saya%20ingin%20pesan%20jasa%20laundry"
               class="px-6 py-3 rounded-xl bg-white text-indigo-700 font-semibold border border-indigo-200 hover:border-indigo-300 shadow-sm hover:shadow-lg transition-all duration-300 transform hover:scale-105"
               target="_blank" rel="noopener">
              Pesan via WhatsApp
            </a>
          </div>

          <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-600">
            <div class="flex items-center gap-2">
              <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-500"></span> Express 6–24 Jam
            </div>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2.5 h-2.5 rounded-full bg-indigo-500"></span> Pengantaran
            </div>
            <div class="flex items-center gap-2">
              <span class="inline-block w-2.5 h-2.5 rounded-full bg-blue-500"></span> Garansi Uang Kembali
            </div>
          </div>
        </div>

        <div class="relative" data-aos="fade-left">
          <div class="absolute -inset-4 bg-gradient-to-tr from-indigo-200 via-blue-200 to-sky-200 rounded-3xl blur-xl opacity-60"></div>
          <div class="relative bg-white rounded-3xl shadow-xl p-6">
            <div class="grid sm:grid-cols-2 gap-4">
              <div class="rounded-2xl border border-indigo-100 p-4">
                <div class="h-36 rounded-xl bg-indigo-50 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6 2h12a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zm0 2v3h12V4H6zm6 5a6 6 0 100 12 6 6 0 000-12zm-4-5h2v2H8V4zm4 0h2v2h-2V4z"/>
                  </svg>
                </div>
                <h3 class="mt-3 font-semibold">Cuci & Setrika</h3>
                <p class="text-sm text-gray-600">Kualitas rapi dan wangi tahan lama.</p>
              </div>

              <div class="rounded-2xl border border-indigo-100 p-4">
                <div class="h-36 rounded-xl bg-sky-50 flex items-center justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-sky-600" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 6h11a1 1 0 011 1v3h3l3 3v5a1 1 0 01-1 1h-1.18A3 3 0 0116 21a3 3 0 01-2.82-2H10.82A3 3 0 018 21a3 3 0 01-2.82-2H4a1 1 0 01-1-1V7a1 1 0 011-1zm2 10a1 1 0 100 2 1 1 0 000-2zm11 0a1 1 0 100 2 1 1 0 000-2z"/>
                  </svg>
                </div>
                <h3 class="mt-3 font-semibold">Pengantaran</h3>
                <p class="text-sm text-gray-600">Gratis area tertentu, jadwal fleksibel.</p>
              </div>
            </div>

            <div class="mt-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-4">
              <p class="text-sm">Tip: Jadwalkan <span class="font-semibold">cuci pagi</span> untuk paket express selesai sore hari!</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="fitur" class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
          <h2 class="text-3xl sm:text-4xl font-bold">Kenapa Pilih <span class="text-indigo-600">Kami?</span></h2>
          <p class="mt-3 text-gray-600">Layanan yang dirancang untuk memudahkan harimu.</p>
        </div>

        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
             <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg></div>
            <h3 class="font-semibold text-lg">Express 6–24 Jam</h3>
            <p class="text-sm text-gray-600 mt-1">Selesai cepat tanpa mengorbankan kualitas.</p>
          </div>
          <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
             <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg></div>
            <h3 class="font-semibold text-lg">Detergen Premium</h3>
            <p class="text-sm text-gray-600 mt-1">Aman untuk kulit & ramah serat pakaian.</p>
          </div>
          <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
             <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg></div>
            <h3 class="font-semibold text-lg">Pemisahan Pakaian</h3>
            <p class="text-sm text-gray-600 mt-1">Warna & bahan dipisah agar tetap awet.</p>
          </div>
          <div class="p-6 rounded-2xl bg-white shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
            <div class="w-12 h-12 rounded-lg bg-indigo-100 flex items-center justify-center mb-4 text-indigo-600"><svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            <h3 class="font-semibold text-lg">Garansi Kepuasan</h3>
            <p class="text-sm text-gray-600 mt-1">Ulang cuci gratis jika kurang bersih.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="layanan" class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
          <h2 class="text-3xl sm:text-4xl font-bold">Paket <span class="text-indigo-600">Layanan</span></h2>
          <p class="mt-3 text-gray-600">Sesuaikan kebutuhanmu—kiloan hemat atau satuan premium.</p>
        </div>

        <div class="mt-12 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="rounded-2xl border border-indigo-200 bg-gradient-to-b from-white to-indigo-50 p-6 shadow-lg flex flex-col transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
            <div class="flex-grow">
              <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold">Laundry Kiloan</h3>
                <span class="text-xs px-2 py-1 rounded-full bg-indigo-600 text-white font-semibold">Paling Hemat</span>
              </div>
              <p class="mt-2 text-gray-600 text-sm">Cuci + setrika, lipat rapi, wangi.</p>
              <div class="mt-4">
                <div class="text-4xl font-extrabold">Rp<span class="tabular-nums">8.000</span><span class="text-lg font-normal">/kg</span></div>
                <p class="text-xs text-gray-500 mt-1">*Harga contoh, bisa disesuaikan.</p>
              </div>
              <ul class="mt-6 space-y-2 text-sm text-gray-700">
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Min. 3 kg</li>
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Estimasi 24–48 jam</li>
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Free parfum premium</li>
              </ul>
            </div>
            <a href="https://wa.me/6285187803535?text=Halo%2C%20saya%20ingin%20pesan%20Laundry%20Kiloan"
               class="mt-6 block text-center w-full px-4 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition-all duration-300 transform hover:scale-105">
              Pesan Paket Ini
            </a>
          </div>

          <div class="rounded-2xl border border-blue-200 bg-gradient-to-b from-white to-blue-50 p-6 shadow-lg flex flex-col transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
            <div class="flex-grow">
              <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold">Laundry Satuan</h3>
                <span class="text-xs px-2 py-1 rounded-full bg-blue-600 text-white font-semibold">Paling Rapi</span>
              </div>
              <p class="mt-2 text-gray-600 text-sm">Cocok untuk jas, gaun, bed cover, dll.</p>
              <div class="mt-4">
                <div class="text-4xl font-extrabold">Rp<span class="tabular-nums">-</span><span class="text-lg font-normal">/item</span></div>
                <p class="text-xs text-gray-500 mt-1">*Tergantung jenis & bahan.</p>
              </div>
              <ul class="mt-6 space-y-2 text-sm text-gray-700">
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Penanganan khusus</li>
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Pengecekan noda</li>
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Packaging eksklusif</li>
              </ul>
            </div>
            <a href="https://wa.me/6285187803535?text=Halo%2C%20saya%20ingin%20tanya%20harga%20Laundry%20Satuan"
               class="mt-6 block text-center w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition-all duration-300 transform hover:scale-105">
              Tanya Harga
            </a>
          </div>

          <div class="rounded-2xl border border-sky-200 bg-gradient-to-b from-white to-sky-50 p-6 shadow-lg relative flex flex-col md:col-span-2 lg:col-span-1 transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
             <div class="absolute -top-3 right-4 text-xs px-3 py-1 rounded-full bg-emerald-500 text-white font-bold shadow-lg">EXTRA CEPAT</div>
            <div class="flex-grow">
              <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold">Express</h3>
                <span class="text-xs px-2 py-1 rounded-full bg-sky-600 text-white font-semibold">6–24 Jam</span>
              </div>
              <p class="mt-2 text-gray-600 text-sm">Prioritas antrian—selesai di hari yang sama*.</p>
              <div class="mt-4">
                <div class="text-4xl font-extrabold">+<span class="tabular-nums">50%</span><span class="text-lg font-normal"> dari tarif</span></div>
                <p class="text-xs text-gray-500 mt-1">*Tergantung waktu & kuota.</p>
              </div>
              <ul class="mt-6 space-y-2 text-sm text-gray-700">
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Pengantaran prioritas</li>
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Notifikasi update</li>
                <li class="flex items-center gap-2"><span class="text-green-500 font-bold">✔</span> Garansi tepat waktu</li>
              </ul>
            </div>
            <a href="https://wa.me/6285187803535?text=Halo%2C%20saya%20ingin%20pakai%20layanan%20Express"
               class="mt-6 block text-center w-full px-4 py-2.5 rounded-xl bg-sky-600 text-white font-semibold hover:bg-sky-700 transition-all duration-300 transform hover:scale-105">
              Cek Ketersediaan
            </a>
          </div>
        </div>
      </div>
    </section>

    <section id="proses" class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
          <h2 class="text-3xl sm:text-4xl font-bold">Proses Mudah dalam <span class="text-indigo-600">4 Langkah</span></h2>
          <p class="mt-3 text-gray-600">Cepat, transparan, dan tanpa ribet.</p>
        </div>

        <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="p-6 rounded-2xl bg-white shadow border border-indigo-100 text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="text-4xl font-bold text-indigo-600">01</div>
            <h3 class="mt-2 font-semibold text-lg">Pendataan</h3>
            <p class="mt-1 text-sm text-gray-600">Menggunakan teknologi kasir yang efektif dan akurat</p>
          </div>
          <div class="p-6 rounded-2xl bg-white shadow border border-indigo-100 text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="text-4xl font-bold text-indigo-600">02</div>
            <h3 class="mt-2 font-semibold text-lg">Cuci & Rawat</h3>
            <p class="mt-1 text-sm text-gray-600">Pemisahan warna & bahan, detergen premium.</p>
          </div>
          <div class="p-6 rounded-2xl bg-white shadow border border-indigo-100 text-center" data-aos="fade-up" data-aos-delay="300">
            <div class="text-4xl font-bold text-indigo-600">03</div>
            <h3 class="mt-2 font-semibold text-lg">Setrika Rapi</h3>
            <p class="mt-1 text-sm text-gray-600">Uap panas, lipat rapi, dan siap simpan.</p>
          </div>
          <div class="p-6 rounded-2xl bg-white shadow border border-indigo-100 text-center" data-aos="fade-up" data-aos-delay="400">
            <div class="text-4xl font-bold text-indigo-600">04</div>
            <h3 class="mt-2 font-semibold text-lg">Pengantaran</h3>
            <p class="mt-1 text-sm text-gray-600">Diantar tepat waktu ke alamatmu.</p>
          </div>
        </div>
      </div>
    </section>

    <section id="testimoni" class="py-16 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto" data-aos="fade-up">
          <h2 class="text-3xl sm:text-4xl font-bold">Apa Kata <span class="text-indigo-600">Pelanggan</span></h2>
          <p class="mt-3 text-gray-600">Mereka sudah hemat waktu & tenaga.</p>
        </div>

        <div class="mt-12 grid md:grid-cols-3 gap-6">
          <figure class="p-6 rounded-2xl border border-indigo-100 bg-gradient-to-b from-white to-indigo-50 shadow" data-aos="fade-up" data-aos-delay="100">
            <blockquote class="text-base text-gray-700 italic">"Baju wangi & rapi, selesai cepat. Driver ramah!"</blockquote>
            <figcaption class="mt-4 text-sm font-semibold text-indigo-700">Rani • Freelancer</figcaption>
          </figure>
          <figure class="p-6 rounded-2xl border border-indigo-100 bg-gradient-to-b from-white to-blue-50 shadow" data-aos="fade-up" data-aos-delay="200">
            <blockquote class="text-base text-gray-700 italic">"Suka paket express-nya, sangat menolong saat mendesak."</blockquote>
            <figcaption class="mt-4 text-sm font-semibold text-blue-700">Dimas • Karyawan</figcaption>
          </figure>
          <figure class="p-6 rounded-2xl border border-indigo-100 bg-gradient-to-b from-white to-sky-50 shadow" data-aos="fade-up" data-aos-delay="300">
            <blockquote class="text-base text-gray-700 italic">"Harga masuk akal, hasil memuaskan. Recommended!"</blockquote>
            <figcaption class="mt-4 text-sm font-semibold text-sky-700">Ayu • Ibu Rumah Tangga</figcaption>
          </figure>
        </div>
      </div>
    </section>

    <section id="faq" class="py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="text-center max-w-2xl mx-auto">
          <h2 class="text-3xl sm:text-4xl font-bold">Pertanyaan yang Sering <span class="text-indigo-600">Diajukan</span></h2>
          <p class="mt-3 text-gray-600">Masih bingung? Mungkin jawabanmu ada di sini.</p>
        </div>

        <div class="mt-12 space-y-4">
          <details class="group rounded-xl border border-indigo-100 bg-white p-5 shadow-sm open:shadow-lg transition-shadow duration-300">
            <summary class="flex cursor-pointer list-none items-center justify-between font-semibold">
              Berapa lama proses laundry?
              <span class="transition group-open:rotate-180">⌄</span>
            </summary>
            <p class="mt-3 text-sm text-gray-600">Reguler 24–48 jam. Express bisa 6–24 jam tergantung antrean & kuota yang tersedia.</p>
          </details>

          <details class="group rounded-xl border border-indigo-100 bg-white p-5 shadow-sm open:shadow-lg transition-shadow duration-300">
            <summary class="flex cursor-pointer list-none items-center justify-between font-semibold">
              Apakah ada layanan pengantaran?
              <span class="transition group-open:rotate-180">⌄</span>
            </summary>
            <p class="mt-3 text-sm text-gray-600">Ya, kami menyediakan layanan antar-jemput. Gratis untuk area tertentu dengan radius maksimal 2,3 KM dari lokasi kami.</p>
          </details>

          <details class="group rounded-xl border border-indigo-100 bg-white p-5 shadow-sm open:shadow-lg transition-shadow duration-300">
            <summary class="flex cursor-pointer list-none items-center justify-between font-semibold">
              Bagaimana jika hasil tidak memuaskan?
              <span class="transition group-open:rotate-180">⌄</span>
            </summary>
            <p class="mt-3 text-sm text-gray-600">Kami menyediakan garansi cuci ulang gratis. Silakan klaim dalam waktu 1x24 jam setelah pakaian diterima jika Anda merasa kurang puas.</p>
          </details>
        </div>

        <p class="mt-6 text-center text-xs text-gray-500">*Ketentuan jam mengikuti ketersediaan. Syarat & Ketentuan berlaku.</p>
      </div>
    </section>

    <section class="py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="zoom-in">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-8 md:p-12">
          <div class="max-w-2xl relative z-10">
            <h3 class="text-3xl md:text-4xl font-bold">Siap Bebas dari Urusan Cucian?</h3>
            <p class="mt-3 text-white/90">Klik pesan sekarang, kurir kami siap menjemput cucianmu.</p>
            <div class="mt-6 flex flex-wrap gap-4">
              <a href="https://wa.me/6285187803535?text=Halo%20Laundry%2C%20saya%20ingin%20pickup%20cucian"
                 class="px-6 py-3 rounded-xl bg-white text-indigo-700 font-semibold hover:bg-white/90 transition-all duration-300 shadow-lg transform hover:scale-105"
                 target="_blank" rel="noopener">
                Pesan via WhatsApp
              </a>
              <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl border border-white/40 font-semibold hover:bg-white/10 transition">
                Login Admin/Staff
              </a>
            </div>
          </div>
          <div class="absolute -right-20 -bottom-24 w-80 h-80 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        </div>
      </div>
    </section>
  </main>

  <footer id="kontak" class="pt-16 pb-32 md:pb-8 bg-white border-t border-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8">
        <div class="md:col-span-2">
          <a href="#home" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 w-auto">
            <span class="text-lg font-semibold"><span class="text-indigo-600">Ava</span>chive</span>
          </a>
          <p class="mt-3 text-sm text-gray-600 max-w-md">
            Laundry terpercaya untuk kebutuhan harian, kantor, hingga acara spesial. Kami rawat pakaianmu seperti milik kami sendiri.
          </p>
        </div>

        <div>
          <h4 class="font-semibold text-gray-800">Kontak</h4>
          <ul class="mt-3 text-sm text-gray-600 space-y-2">
            <li>📍 Alamat: Laladon Ciomas</li>
            <li>☎️ Telepon: 0812-3456-789</li>
            <li>✉️ Email: admin@gmail.com</li>
            <li>
              <a href="https://wa.me/6285187803535" target="_blank" rel="noopener" class="inline-block text-indigo-600 hover:text-indigo-700 font-semibold">
                Chat WhatsApp →
              </a>
            </li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold text-gray-800">Navigasi</h4>
          <ul class="mt-3 text-sm text-gray-600 space-y-2">
            <li><a href="#fitur" class="hover:text-indigo-600">Fitur</a></li>
            <li><a href="#layanan" class="hover:text-indigo-600">Layanan</a></li>
            <li><a href="#proses" class="hover:text-indigo-600">Proses</a></li>
            <li><a href="#faq" class="hover:text-indigo-600">FAQ</a></li>
          </ul>
        </div>
      </div>

      <div class="mt-10 border-t border-indigo-100 pt-6 text-xs text-gray-500 text-center">
        <p>© <span class="tabular-nums">{{ date('Y') }}</span> Avachive. All rights reserved.</p>
      </div>
    </div>
  </footer>
  
  <nav class="md:hidden fixed bottom-0 left-0 right-0 h-20 bg-white/80 backdrop-blur-sm border-t border-indigo-100 shadow-[0_-2px_10px_rgba(0,0,0,0.05)] z-50 flex justify-around items-center px-2">
    <a href="#home" class="mobile-nav-link flex flex-col items-center gap-1 text-gray-600 hover:text-indigo-600 transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
        <span class="text-xs font-medium">Home</span>
    </a>
    <a href="#layanan" class="mobile-nav-link flex flex-col items-center gap-1 text-gray-600 hover:text-indigo-600 transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 8v5z" /></svg>
        <span class="text-xs font-medium">Layanan</span>
    </a>
    <a href="#proses" class="mobile-nav-link flex flex-col items-center gap-1 text-gray-600 hover:text-indigo-600 transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>
        <span class="text-xs font-medium">Proses</span>
    </a>
    <a href="#kontak" class="mobile-nav-link flex flex-col items-center gap-1 text-gray-600 hover:text-indigo-600 transition-colors group">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
        <span class="text-xs font-medium">Kontak</span>
    </a>
  </nav>

  <a href="https://wa.me/6285187803535?text=Halo%20Laundry%2C%20saya%20ingin%20bertanya"
     class="animate-pulse-whatsapp fixed bottom-24 md:bottom-5 right-5 p-3 rounded-full shadow-lg bg-green-500 text-white"
     target="_blank" rel="noopener" aria-label="Chat WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
      <path d="M.057 24l1.687-6.163A11.867 11.867 0 0112.014 0C18.627 0 24 5.373 24 11.986c0 6.613-5.373 11.986-11.986 11.986a11.94 11.94 0 01-6.09-1.688L.057 24zM6.6 20.6a9.7 9.7 0 005.414 1.64h.005c5.356 0 9.713-4.357 9.713-9.714 0-5.356-4.357-9.713-9.713-9.713-5.357 0-9.714 4.357-9.714 9.713 0 2.064.63 3.98 1.712 5.555l-.997 3.64 3.57-.12zM8.84 6.98c-.2-.45-.41-.46-.6-.47-.15-.01-.33-.01-.51-.01s-.47.07-.71.35c-.24.28-.93.91-.93 2.22s.95 2.58 1.08 2.76c.13.18 1.83 2.94 4.45 4.01 2.2.86 2.65.69 3.13.65.48-.04 1.54-.63 1.76-1.24.22-.61.22-1.13.16-1.24-.06-.11-.24-.17-.5-.3-.26-.13-1.54-.76-1.78-.85-.24-.09-.41-.13-.59.13-.18.26-.68.85-.84 1.03-.15.18-.31.2-.57.07-.26-.13-1.07-.39-2.03-1.25-.75-.67-1.25-1.49-1.4-1.75-.15-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.15.17-.26.26-.44.09-.18.04-.34-.02-.47-.06-.13-.53-1.28-.73-1.74z"/>
    </svg>
  </a>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    // Initialize AOS
    AOS.init({
      duration: 800, // Animation duration
      once: true,    // Animate only once
      offset: 50,    // Trigger animation a bit early
    });

    // Mobile Nav Active State Script
    document.addEventListener('DOMContentLoaded', () => {
      const sections = document.querySelectorAll('section[id]');
      const navLinks = document.querySelectorAll('.mobile-nav-link');

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            navLinks.forEach(link => {
              link.classList.remove('text-indigo-600');
              if (link.getAttribute('href').substring(1) === entry.target.id) {
                link.classList.add('text-indigo-600');
              }
            });
          }
        });
      }, { rootMargin: '-50% 0px -50% 0px' }); // Trigger when section is in the middle of the screen

      sections.forEach(section => {
        observer.observe(section);
      });
    });
  </script>

</body>
</html>