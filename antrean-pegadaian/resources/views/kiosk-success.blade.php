<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset="utf-8" />
    <title>Pendaftaran Berhasil - Kiosk Pegadaian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
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
    
    <style>
        .success-animation {
            width: 80px;
            height: 80px;
            margin-bottom: 12px;
            animation: scale-pop 0.3s 1s ease-out forwards;
            transform: scale(1);
        }

        .success-animation .path.circle {
            stroke-dasharray: 391; 
            stroke-dashoffset: 391;
            animation: draw-circle 0.6s ease-out forwards;
        }

        .success-animation .path.check {
            stroke-dasharray: 100; 
            stroke-dashoffset: 100;
            animation: draw-check 0.4s 0.6s ease-out forwards;
        }

        @keyframes draw-circle {
            0% { stroke-dashoffset: 391; }
            100% { stroke-dashoffset: 0; }
        }

        @keyframes draw-check {
            0% { stroke-dashoffset: 100; }
            100% { stroke-dashoffset: 0; }
        }

        @keyframes scale-pop {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        @media print {
            @page {
                size: 58mm auto; 
                margin: 0mm; 
            }
            
            body > *:not(#print-area) {
                display: none !important;
            }
            
            #print-area {
                display: block !important;
                position: relative;
                width: 58mm; 
                margin: 0;
                padding: 10px 0;
            }
            body {
                background: white !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-[linear-gradient(117deg,rgba(255,255,255,1)_0%,rgba(247,249,248,1)_40%,rgba(232,245,238,1)_100%)] flex flex-col items-center justify-center p-6 overflow-y-auto select-none font-sans">

    <div class="w-full max-w-[1140px] grid grid-cols-1 md:grid-cols-2 gap-8 items-center my-auto px-4">
        
        <div class="w-full flex flex-col items-center">
            
            <div class="flex flex-col items-center text-center mb-6 shrink-0">
                <div class="success-animation">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                        <circle class="path circle" fill="none" stroke="#00ab4e" stroke-width="6" stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1"/>
                        <polyline class="path check" fill="none" stroke="#00ab4e" stroke-width="10" stroke-linecap="round" stroke-miterlimit="10" points="29.8,67.1 51.5,88.8 100.2,40.2"/>
                    </svg>
                </div>
                
                <h1 class="font-bold text-[#004e44] text-4xl tracking-tight mb-1">
                    Pendaftaran Berhasil!
                </h1>
                <p class="font-normal text-[#5f6b66] text-xl tracking-tight">
                    Nomor antrean Anda
                </p>
            </div>

            <div class="bg-white rounded-[32px] border border-[#dde5df] shadow-[0px_8px_32px_rgba(0,171,78,0.06)] p-8 flex flex-col items-center justify-center min-h-[360px] w-full mb-5">
                <div class="w-full max-w-[360px] py-6 bg-[#00ab4e] rounded-[24px] flex items-center justify-center shadow-md">
                    <span class="font-bold text-white text-7xl md:text-8xl tracking-tight font-mono">
                        {{ $queue->ticket_number ?? 'A01' }}
                    </span>
                </div>
                
                <div class="w-full border-t border-[#dde5df] pt-6 mt-8 text-center">
                    <span class="text-[#5f6b66] text-lg block mb-1">Layanan</span>
                    <span class="font-bold text-[#00ab4e] text-3xl md:text-4xl block">
                        {{ $queue->serviceCategory->name ?? 'Cicilan' }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-[20px] border border-[#dde5df] p-4 flex items-center gap-4 w-full shadow-[0px_4px_16px_rgba(0,0,0,0.02)]">
                <div class="w-12 h-12 bg-[#bfd730]/20 text-[#004e44] rounded-xl flex items-center justify-center shrink-0">
                    <span class="iconify text-2xl" data-icon="solar:printer-bold"></span>
                </div>
                <p class="font-medium text-[#004e44] text-[15px] md:text-base leading-relaxed">
                    Tiket antrean Anda sedang dicetak. Silakan ambil tiket pada printer.
                </p>
            </div>
        </div>

        <div class="w-full flex flex-col gap-5">
            
            <div class="bg-white rounded-[24px] border border-[#dde5df] shadow-[0px_4px_20px_rgba(0,0,0,0.04)] p-6 flex items-center gap-6 w-full">
                <div class="w-16 h-16 bg-[#00ab4e] rounded-2xl flex items-center justify-center text-white shrink-0 shadow-sm">
                    <span class="iconify text-3xl" data-icon="solar:users-group-two-rounded-bold"></span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[#5f6b66] text-lg font-medium">Antrean di Depan</span>
                    <span class="font-bold text-[#00ab4e] text-5xl font-sans mt-0.5 leading-none">
                        {{ $queuesAhead ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-[24px] border border-[#dde5df] shadow-[0px_4px_20px_rgba(0,0,0,0.04)] p-6 flex items-start gap-4 w-full">
                <div class="w-12 h-12 bg-[#bfd730] text-[#004e44] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                    <span class="iconify text-2xl" data-icon="solar:bell-bing-bold"></span>
                </div>
                <div class="flex flex-col">
                    <h4 class="font-bold text-[#004e44] text-lg mb-1">Penting!</h4>
                    <p class="text-[#5f6b66] text-[15px] md:text-base leading-relaxed">
                        Nomor antrean Anda akan dipanggil melalui <span class="font-bold text-[#004e44]">speaker/pengeras suara</span>. Harap tunggu di ruang tunggu dan perhatikan panggilan dengan seksama.
                    </p>
                </div>
            </div>

            <div class="flex w-full gap-4 mt-2">
                <a href="{{ url('/kiosk') }}" class="w-1/2 py-4 bg-white border-2 border-[#dde5df] hover:bg-gray-50 text-[#004e44] font-bold rounded-2xl shadow-sm transition-all text-center text-xl flex items-center justify-center">
                    Daftar Lagi
                </a>
                <a href="{{ url('/kiosk') }}" class="w-1/2 py-4 bg-[#00ab4e] hover:bg-[#008f41] text-white font-bold rounded-2xl shadow-md transition-all text-center text-xl flex items-center justify-center">
                    Selesai
                </a>
            </div>

            <div class="text-center text-xs text-gray-400 mt-2 w-full">
                Layar akan kembali ke menu utama otomatis dalam <span id="auto-timer" class="font-bold">5</span> detik...
            </div>

        </div>
    </div>

    <div id="print-area" class="hidden">
        <div style="width: 58mm; max-width: 100%; margin: 0 auto; font-family: 'Inter', Arial, sans-serif; color: #000; background: #fff; padding: 0; text-align: center;">
            
            <div style="margin-bottom: 12px; width: 100%; text-align: center;">
                <img src="{{ asset('images/logo-pegadaian.png') }}" alt="Pegadaian" style="height: 35px; width: auto; display: block; margin: 0 auto;" />
            </div>

            <h2 style="font-size: 14px; font-weight: 900; margin: 0 0 12px 0; text-transform: uppercase; letter-spacing: 0.5px;">UPC MAJENANG</h2>

            <div style="border-top: 2px dashed #000; margin: 12px 0;"></div>

            <p style="font-size: 11px; font-weight: 700; margin: 0 0 5px 0; letter-spacing: 1px;">NOMOR ANTREAN</p>
            <h1 style="font-size: 52px; font-weight: 900; margin: 0; line-height: 1; letter-spacing: -1px;">
                {{ $queue->ticket_number ?? 'A02' }}
            </h1>

            <div style="border-top: 2px dashed #000; margin: 15px 0 12px 0;"></div>

            <table style="width: 100%; font-size: 12px; text-align: left; margin-bottom: 12px; border-collapse: collapse;">
                <tr>
                    <td style="font-weight: 700; padding: 3px 0; width: 40%;">Nama:</td>
                    <td style="text-align: right; padding: 3px 0;">
                        {{ $queue->customer_name ?: 'Nasabah' }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: 700; padding: 3px 0;">Layanan:</td>
                    <td style="text-align: right; padding: 3px 0;">
                        {{ $queue->serviceCategory->name ?? 'Cicilan' }}
                    </td>
                </tr>
            </table>

            <div style="border-top: 1px solid #000; margin: 12px 0;"></div>

            <p style="font-size: 11px; margin: 0; line-height: 1.5;">
                Harap menuju ke <strong>LOKET</strong> saat nomor<br>Anda dipanggil.
            </p>

            <div style="border-top: 1px solid #000; margin: 12px 0;"></div>

            <p style="font-size: 10px; margin: 0;">
                {{ \Carbon\Carbon::now()->translatedFormat('d M Y | H:i') }} WIB
            </p>

        </div>
    </div>

    <script>
        // Panggil print otomatis setelah halaman (termasuk logo) selesai dimuat
        window.onload = function() {
            window.print();
        };

        let secondsLeft = 8;
        const timerElement = document.getElementById('auto-timer');
        
        const countdown = setInterval(() => {
            secondsLeft--;
            if(timerElement) {
                timerElement.innerText = secondsLeft;
            }
            if (secondsLeft <= 0) {
                clearInterval(countdown);
                window.location.href = "{{ url('/kiosk') }}";
            }
        }, 1000);
    </script>
</body>
</html>