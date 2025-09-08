<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Avachive</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Hilangkan panah default select */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        /* Animasi fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Glow button */
        .btn-glow {
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.4);
        }
        .btn-glow:hover {
            box-shadow: 0 0 25px rgba(0, 123, 255, 0.7);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-800 via-gray-750 to-gray-900 font-sans antialiased relative overflow-hidden">

    <!-- Background Glow Effect -->
    <div class="absolute -top-35 -left-32 w-96 h-96 bg-blue-500 rounded-full blur-3xl opacity-20"></div>
    <div class="absolute -bottom-35 -right-32 w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-20"></div>

    <div class="flex flex-col items-center justify-center min-h-screen p-4 animate-[fadeIn_0.5s_ease-out]">

        <div class="w-full max-w-md p-8 space-y-6 bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20">

            <!-- Logo & Title -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-25 w-auto drop-shadow-lg">
                </div>
                <h1 class="text-3xl font-bold text-white tracking-wide">Selamat Datang</h1>
                <p class="mt-3 text-gray-300">Silakan login untuk mengakses akun Avachive Anda.</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <!-- Username -->
                <div>
                    <x-input-label for="name" :value="__('Username')" class="text-gray-200 font-semibold" />
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                             <svg class="h-5 w-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.095a1.23 1.23 0 00.41-1.412A9.99 9.99 0 0010 12c-2.31 0-4.438.784-6.131 2.095z" />
                            </svg>
                        </div>
                        <x-text-input id="name"
                                      class="block w-full pl-12 py-3 text-lg text-white bg-white/5 border-white/20 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out"
                                      type="text" name="name" :value="old('name')" required autofocus autocomplete="username"
                                      placeholder="Masukkan username" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="text-gray-200 font-semibold" />
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                             <svg class="h-5 w-5 text-blue-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <x-text-input id="password"
                                      class="block w-full pl-12 py-3 text-lg text-white bg-white/5 border-white/20 rounded-xl focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition duration-150 ease-in-out"
                                      type="password" name="password" required autocomplete="current-password"
                                      placeholder="Masukkan password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="h-5 w-5 text-blue-500 focus:ring-blue-500 border-white/30 rounded bg-white/10">
                        <label for="remember_me" class="ml-3 block text-md text-gray-200">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                            class="btn-glow w-full flex justify-center items-center py-4 px-6 rounded-xl shadow-lg text-lg font-semibold text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-transform duration-300 hover:scale-105">
                        Masuk
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
