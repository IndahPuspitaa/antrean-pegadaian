<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset="utf-8" />
    <title>Login Kiosk Pegadaian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                },
            },
        }
    </script>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-[#00ab4e] to-[#005c2a] flex flex-col items-center justify-center p-4 font-sans antialiased">

    <div class="bg-white w-full max-w-[420px] rounded-[24px] shadow-[0px_20px_40px_rgba(0,0,0,0.2)] p-8 md:p-10 relative z-10">
        
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('images/logo-pegadaian.png') }}" alt="Logo Pegadaian" class="h-10 mb-3 object-contain" />
            <h1 class="text-[#5f6b66] text-[15px] font-medium tracking-wide">
                Sistem Manajemen Antrean UPC Majenang
            </h1>
        </div>

        <form method="POST" action="{{ url('/login') }}" class="flex flex-col gap-5">
            @csrf
            
            <div class="flex flex-col gap-1.5">
                <label for="username" class="text-[#5f6b66] font-bold text-sm">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       placeholder="Masukkan username" 
                       class="w-full px-4 py-3 rounded-xl border @error('username') border-red-500 @else border-gray-200 @enderror text-[#004e44] focus:outline-none focus:ring-2 focus:ring-[#00ab4e] focus:border-transparent transition-all placeholder-gray-400 font-medium"
                       value="{{ old('username') }}"
                       required autofocus>
                @error('username')
                    <p class="text-red-500 text-xs font-semibold mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1.5 relative">
                <label for="password" class="text-[#5f6b66] font-bold text-sm">Password</label>
                <div class="relative w-full">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Masukkan password" 
                           class="w-full pl-4 pr-12 py-3 rounded-xl border border-gray-200 text-[#004e44] focus:outline-none focus:ring-2 focus:ring-[#00ab4e] focus:border-transparent transition-all placeholder-gray-400 font-medium"
                           required>
                    
                    <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-[#00ab4e] transition-colors focus:outline-none">
                        <span id="eye-icon" class="iconify text-xl" data-icon="solar:eye-closed-bold-duotone"></span>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full mt-2 bg-[#00ab4e] hover:bg-[#008f41] text-white font-bold py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 text-base">
                <span class="iconify text-xl" data-icon="solar:login-2-bold"></span>
                Login
            </button>
        </form>
    </div>

    <div class="mt-8 text-white/70 text-xs md:text-sm font-medium tracking-wide text-center">
        &copy; 2026 Pegadaian UPC Majenang - Sistem Manajemen Antrean UPC Majenang
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Ganti ikon jadi mata terbuka
                eyeIcon.setAttribute('data-icon', 'solar:eye-bold-duotone');
            } else {
                passwordInput.type = 'password';
                // Kembalikan ke ikon mata tertutup
                eyeIcon.setAttribute('data-icon', 'solar:eye-closed-bold-duotone');
            }
        }
    </script>
</body>
</html>