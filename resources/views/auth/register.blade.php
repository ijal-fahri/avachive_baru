<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Owner - Avachive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes glow {
            0% { transform: translate(10%, 10%) scale(1); }
            25% { transform: translate(-10%, 10%) scale(1.2); }
            50% { transform: translate(-10%, -10%) scale(1); }
            75% { transform: translate(10%, -10%) scale(1.2); }
            100% { transform: translate(10%, 10%) scale(1); }
        }
        .glow-effect {
            animation: glow 40s linear infinite;
        }
        .welcome-bg {
            background-color: #4338ca; /* indigo-700 */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%234f46e5' fill-opacity='0.4'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h5v1h-5v9h5v1h-5v9h5v1h-5v9h5v1h-5v9h5v1h-5v9h5v1h-5v9h5v1h-5v9h5v1h-5v9h-1v-9h-9v9h-1v-9h-9v9h-1v-9h-9v9h-1v-9h-9v9h-1v-9h-9v9h-1v-9h-9v9h-1v-9h-9v9H0v-1h5v-9H0v-1h5v-9H0v-1h5v-9H0v-1h5v-9H0v-1h5v-9H0v-1h5v-9H0v-1h5V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5h9V0h1v5z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        /* [PERUBAHAN] Menambahkan animasi float */
        @keyframes float {
          0%, 100% { transform: translateY(0); }
          50% { transform: translateY(-15px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-900 font-[Poppins] text-white antialiased relative overflow-hidden">

    <!-- Background Glow Effect -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-600 rounded-full blur-3xl opacity-20 glow-effect"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full blur-3xl opacity-20 glow-effect animation-delay-5000"></div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        
        <div class="grid lg:grid-cols-2 items-center w-full max-w-sm lg:max-w-4xl bg-slate-800/50 backdrop-blur-lg rounded-3xl shadow-2xl border border-slate-700 overflow-hidden animate-[fadeIn_0.7s_ease-out]">
            
            <!-- Welcome Section -->
            <div class="hidden lg:flex flex-col justify-center items-center h-full p-12 welcome-bg text-center">
                 {{-- [PERUBAHAN] Menambahkan class animasi --}}
                 <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-24 w-auto drop-shadow-lg mb-4 animate-float">
                 <h2 class="text-3xl font-bold tracking-wide">Mulai Petualangan Bisnis Anda</h2>
                 <p class="mt-3 text-indigo-200">Daftarkan akun Owner untuk mengelola semua cabang dari satu tempat.</p>
            </div>
            
            <!-- Register Form Section -->
            <div class="w-full p-6 md:p-8 lg:p-12">
                <div class="text-center lg:hidden mb-6">
                     {{-- [PERUBAHAN] Menambahkan class animasi --}}
                     <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto mx-auto drop-shadow-lg animate-float">
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-center">Buat Akun Owner</h1>
                <p class="mt-2 text-sm text-slate-400 text-center">Halaman ini hanya untuk development.</p>
                
                <div class="mt-8">
                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf
                        <!-- Username -->
                        <div>
                            <label for="name" class="text-slate-300 font-semibold text-sm">Username</label>
                            <div class="mt-2 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="bi bi-person-fill text-xl text-indigo-300"></i>
                                </div>
                                <input id="name"
                                       class="block w-full pl-12 pr-4 py-3 text-base text-white bg-slate-700/50 border border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out"
                                       type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                       placeholder="Username Owner" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="text-slate-300 font-semibold text-sm">Password</label>
                            <div class="mt-2 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                     <i class="bi bi-lock-fill text-xl text-indigo-300"></i>
                                </div>
                                <input id="password"
                                       class="block w-full pl-12 pr-4 py-3 text-base text-white bg-slate-700/50 border border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out"
                                       type="password" name="password" required autocomplete="new-password"
                                       placeholder="Password baru" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
                        </div>
                        
                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="text-slate-300 font-semibold text-sm">Konfirmasi Password</label>
                            <div class="mt-2 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                     <i class="bi bi-shield-lock-fill text-xl text-indigo-300"></i>
                                </div>
                                <input id="password_confirmation"
                                       class="block w-full pl-12 pr-4 py-3 text-base text-white bg-slate-700/50 border border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out"
                                       type="password" name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Ulangi password" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit"
                                    class="w-full flex justify-center items-center py-3 px-6 rounded-xl shadow-lg text-base sm:text-lg font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-blue-500 transform transition-all duration-300 hover:scale-105 hover:shadow-blue-500/30">
                                Register Akun Owner
                                <i class="bi bi-arrow-right ml-2"></i>
                            </button>
                        </div>
                        
                        <div class="text-center mt-6">
                            <a class="text-sm text-blue-300 hover:text-white" href="{{ route('login') }}">
                                Sudah punya akun? Login di sini
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
