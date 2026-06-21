<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta charset="utf-8" />
    <title>Kiosk Antrean Pegadaian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<body class="min-h-screen bg-[linear-gradient(117deg,rgba(255,255,255,1)_0%,rgba(247,249,248,1)_40%,rgba(232,245,238,1)_100%)] flex flex-col items-center justify-center py-4 overflow-y-auto select-none font-sans">

    <div id="step-1" class="w-full flex flex-col items-center justify-center p-4">
        <div class="flex flex-col items-center mt-2 mb-6 px-4 text-center shrink-0">
            <div class="flex items-center justify-center mb-4">
                <img src="{{ asset('images/logo-pegadaian.png') }}" alt="Logo Pegadaian" class="h-[55px] object-contain" />
            </div>
            
            <h1 class="font-bold text-[#004e44] text-4xl tracking-tight mb-1">
                Daftar Antrean Kasir
            </h1>
            <p class="font-medium text-[#004e44] text-[18px] tracking-tight">
                Silakan pilih jenis layanan untuk mendapatkan nomor antrean
            </p>
        </div>

        <div class="w-full max-w-[1100px] flex flex-wrap justify-center gap-[24px] px-4 mb-2">
            @foreach($services as $service)
            <div class="w-full md:w-[330px] h-[220px] md:h-[240px]">
                <button type="button" 
                        onclick="goToStep2('{{ $service->id }}', '{{ $service->name }}', '{{ $service->waitingToday() }}')"
                        class="w-full h-full flex flex-col bg-white rounded-[24px] md:rounded-[28px] shadow-[0px_8px_24px_rgba(0,0,0,0.06)] text-left transition-transform hover:scale-105 active:scale-95 focus:outline-none p-6 md:p-7 justify-between border border-gray-50 group">
                    
                    <div class="flex w-full items-start justify-between">
                        <div class="flex w-[72px] h-[72px] items-center justify-center bg-[#00ab4e] rounded-[18px] shadow-sm group-hover:bg-[#008f41] transition-colors shrink-0">
                            @php
                                $serviceNameLower = strtolower($service->name);
                                $iconCode = match($serviceNameLower) {
                                    'cicilan' => 'mdi:wallet',
                                    'perpanjang' => 'mdi:calendar-plus',
                                    'tabungan' => 'mdi:gold', 
                                    'pelunasan' => 'mdi:hand-coin',
                                    'angsuran' => 'mdi:bank',           
                                    'minta tambah (mt)' => 'mdi:plus-circle',
                                    default => 'mdi:dots-horizontal-circle'
                                };
                            @endphp
                            <span class="iconify text-white text-[40px]" data-icon="{{ $iconCode }}"></span>
                        </div>
                        
                        <div class="flex items-center justify-center px-4 py-1.5 bg-[#bfd730] rounded-full shadow-sm">
                            <span id="waiting-badge-{{ $service->id }}" class="font-bold text-[#004e44] text-[13px] whitespace-nowrap">
                                {{ $service->waitingToday() }} menunggu
                            </span>
                        </div>
                    </div>

                    <div class="w-full">
                        <h2 class="font-bold text-[#004e44] text-[28px] truncate mb-1">
                            {{ $service->name }}
                        </h2>
                        <p class="font-medium text-[#5f6b66] text-[15px] line-clamp-1 leading-relaxed">
                            {{ $service->description ?? 'Layanan kasir Pegadaian' }}
                        </p>
                    </div>
                </button>
            </div>
            @endforeach
        </div>

        <div class="w-full flex justify-center mt-6 mb-1 shrink-0">
            <div class="flex items-center justify-center px-5 py-2 md:py-2.5 bg-white rounded-full shadow-[0px_2px_8px_rgba(0,0,0,0.04)] border border-gray-100/50">
                <span class="iconify text-[#00ab4e] w-5 h-5 mr-2.5 shrink-0" data-icon="mdi:volume-high"></span>
                <p class="font-medium text-[#004e44] text-[14px] tracking-tight whitespace-nowrap">
                    Nomor antrean akan dipanggil melalui speaker
                </p>
            </div>
        </div>

    </div> <div id="step-2" class="w-full flex flex-col items-center justify-center hidden p-4">
        <div class="w-full max-w-[460px] flex flex-col items-center relative text-center px-4 mb-2">
            
            <button type="button" onclick="backToStep1()" class="absolute left-0 top-2 text-[#00ab4e] hover:text-[#008f41] transition-colors focus:outline-none">
                <span class="iconify text-3xl" data-icon="solar:alt-arrow-left-linear"></span>
            </button>
            
            <div class="flex flex-col items-center">
                <div class="w-14 h-14 bg-[#00ab4e] rounded-2xl flex items-center justify-center text-white mb-3 shadow-sm border border-gray-100">
                    <span class="iconify text-3xl" data-icon="solar:user-bold"></span>
                </div>
                
                <h2 class="font-bold text-[#004e44] text-3xl tracking-tight mb-2">Data Nasabah</h2>
                
                <div class="px-5 py-1.5 bg-white rounded-full shadow-[0px_2px_8px_rgba(0,0,0,0.02)] border border-gray-100 text-sm font-medium text-[#004e44] mb-5">
                    <span id="target-service-name" class="font-bold">Layanan</span>
                </div>
            </div>

            <form action="{{ route('kiosk.store') }}" method="POST" class="w-full flex flex-col items-center">
                @csrf
                <input type="hidden" name="service_category_id" id="target-service-id">

                <div class="bg-white rounded-[24px] shadow-[0px_8px_32px_rgba(0,0,0,0.04)] border border-gray-100/50 p-6 w-full mb-4 text-left">
                    <label class="font-bold text-[#004e44] text-base mb-3 block">Nama Lengkap (Opsional)</label>
                    <input type="text" 
                           name="customer_name" 
                           id="customer-name-field"
                           placeholder="Masukkan nama Anda" 
                           class="w-full px-4 py-3.5 bg-[#f7f9f8] border border-gray-200 rounded-xl text-base font-medium text-[#004e44] focus:outline-none focus:ring-2 focus:ring-[#00ab4e] focus:bg-white placeholder-gray-400"
                           autocomplete="off">
                    <p class="text-xs text-gray-400 mt-3 leading-relaxed">Anda dapat mengosongkan nama nasabah</p>
                </div>

                <div class="bg-white rounded-[24px] shadow-[0px_8px_32px_rgba(0,0,0,0.04)] border border-gray-100/50 p-6 w-full mb-5 text-left">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-[#004e44] text-base">Antrean Menunggu</span>
                        <span id="target-waiting-count" class="font-bold text-[#00ab4e] text-4xl font-sans">0</span>
                    </div>
                </div>

                <div class="flex w-full gap-4">
                    <button type="button" onclick="backToStep1()" class="w-1/2 py-4 bg-white border border-gray-200 hover:bg-gray-50 text-[#004e44] font-bold rounded-2xl shadow-sm transition-all text-center text-base">
                        Kembali
                    </button>
                    <button type="submit" class="w-1/2 py-4 bg-[#00ab4e] hover:bg-[#008f41] text-white font-bold rounded-2xl shadow-md transition-all flex items-center justify-center gap-2 text-base focus:ring-2 focus:ring-[#bfd730] focus:outline-none">
                        Daftar <span class="iconify text-xl" data-icon="line-md:arrow-right"></span>
                    </button>
                </div>
            </form>

        </div>
    </div> <script>
        function goToStep2(serviceId, serviceName, waitingCount) {
            document.getElementById('target-service-id').value = serviceId;
            document.getElementById('target-service-name').innerText = serviceName;
            document.getElementById('target-waiting-count').innerText = waitingCount;
            document.getElementById('customer-name-field').value = '';

            document.getElementById('step-1').classList.add('hidden');
            document.getElementById('step-2').classList.remove('hidden');
            
            document.getElementById('customer-name-field').focus();
        }

        function backToStep1() {
            document.getElementById('step-2').classList.add('hidden');
            document.getElementById('step-1').classList.remove('hidden');
        }

        @if(session('success_queue'))
            @php
                $q = session('success_queue');
                $nomorTicket = $q->ticket_number ?? 'A01';
                $namaLayanan = $q->serviceCategory->name ?? 'Layanan';
                $tanggal = date('d M Y');
            @endphp

            Swal.fire({
                html: `
                    <div class="flex flex-col items-center p-2 font-sans select-none">
                        <div class="text-[#004e44] font-bold text-xl tracking-wide mb-1">PT Pegadaian</div>
                        <div class="text-gray-400 text-xs mb-4">{{ $tanggal }}</div>
                        <div class="w-full border-t border-dashed border-gray-200 mb-4"></div>
                        
                        <div class="text-gray-500 font-medium text-sm mb-2">Nomor Antrean Anda</div>
                        <div class="text-[#004e44] font-bold text-6xl tracking-tight my-2 font-mono">{{ $nomorTicket }}</div>
                        
                        <div class="my-3 px-6 py-1.5 bg-[#bfd730] text-[#004e44] font-bold text-sm rounded-full shadow-sm">
                            {{ $namaLayanan }}
                        </div>
                        
                        <div class="w-full border-t border-dashed border-gray-200 mt-4 mb-4"></div>
                        <div class="text-[#004e44] font-medium text-sm mb-1">Silakan tunggu nomor Anda dipanggil.</div>
                        <div id="swal-timer" class="text-gray-400 text-xs mt-2">Layar ini akan kembali otomatis dalam 5 detik...</div>
                    </div>
                `,
                showConfirmButton: false,
                width: '420px',
                background: '#ffffff',
                color: '#004e44',
                borderRadius: '32px',
                timer: 5000,
                timerProgressBar: false,
                didOpen: () => {
                    let timeLeft = 5;
                    const timerInterval = setInterval(() => {
                        timeLeft--;
                        const timerText = document.getElementById('swal-timer');
                        if (timerText) {
                            timerText.innerText = `Layar ini akan kembali otomatis dalam ${timeLeft} detik...`;
                        }
                    }, 1000);
                }
            });
        @endif

        // FUNGSI AUTO-UPDATE TANPA REFRESH (AJAX POLLING)
        setInterval(function() {
            // Jangan lakukan auto-update jika nasabah sedang berada di Langkah 2 (isi form)
            if (!document.getElementById('step-2').classList.contains('hidden')) {
                return;
            }

            fetch('/api/kiosk-data')
                .then(response => response.json())
                .then(data => {
                    for (const [id, count] of Object.entries(data)) {
                        const badge = document.getElementById('waiting-badge-' + id);
                        if (badge) {
                            badge.innerText = count + ' menunggu';
                        }
                    }
                })
                .catch(error => console.error('Gagal mengambil data terbaru:', error));
        }, 5000); // Setiap 5 detik
    </script>
</body>
</html>