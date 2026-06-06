<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kasir - Sistem Antrean Pegadaian</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', sans-serif; background:#f3f4f6; color:#1f2937; }

        /* Header */
        .header {
            background:#006428;
            color:white;
            padding:14px 16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            position:sticky;
            top:0;
            z-index:100;
        }
        .header-title { font-size:15px; font-weight:700; }
        .header-sub { font-size:11px; color:rgba(255,255,255,0.7); }
        .clock { font-size:12px; color:rgba(255,255,255,0.9); text-align:right; }

        /* Loket selector */
        .loket-section {
            background:white;
            padding:14px 16px;
            border-bottom:1px solid #e5e7eb;
        }
        .loket-label { font-size:12px; color:#6b7280; margin-bottom:8px; }
        .loket-grid { display:grid; gap:8px; }
        .loket-btn {
            padding:12px;
            border-radius:10px;
            border:2px solid #e5e7eb;
            background:white;
            font-weight:600;
            font-size:14px;
            cursor:pointer;
            color:#4b5563;
            transition:all 0.2s;
        }
        .loket-btn.active {
            border-color:#006428;
            background:#f0fdf4;
            color:#006428;
        }

        /* Tabs */
        .tabs {
            display:flex;
            background:white;
            border-bottom:1px solid #e5e7eb;
            position:sticky;
            top:60px;
            z-index:99;
        }
        .tab-btn {
            flex:1;
            padding:12px;
            border:none;
            background:none;
            font-size:13px;
            font-weight:600;
            color:#6b7280;
            cursor:pointer;
            border-bottom:3px solid transparent;
        }
        .tab-btn.active {
            color:#006428;
            border-bottom-color:#006428;
        }
        .tab-badge {
            display:inline-block;
            background:#ef4444;
            color:white;
            font-size:10px;
            border-radius:999px;
            padding:1px 6px;
            margin-left:4px;
        }

        /* Content */
        .content { padding:12px 16px; }

        /* Queue card */
        .queue-card {
            background:white;
            border-radius:12px;
            padding:14px;
            margin-bottom:10px;
            border:1px solid #e5e7eb;
        }
        .queue-card.called {
            background:#fff7ed;
            border-color:#fed7aa;
        }
        .ticket-row {
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:4px;
        }
        .ticket-number {
            font-size:22px;
            font-weight:800;
            color:#006428;
        }
        .ticket-number.called { color:#ea580c; }
        .badge {
            font-size:11px;
            padding:2px 8px;
            border-radius:999px;
            font-weight:600;
        }
        .badge-waiting { background:#fef9c3; color:#a16207; }
        .badge-called { background:#ffedd5; color:#c2410c; }
        .customer-name { font-weight:600; font-size:14px; color:#1f2937; }
        .service-name { font-size:12px; color:#6b7280; margin-bottom:4px; }
        .wait-time { font-size:11px; color:#9ca3af; margin-bottom:10px; }
        .counter-badge {
            font-size:11px;
            color:#6b7280;
            margin-bottom:10px;
        }

        /* Buttons */
        .btn-panggil {
            width:100%;
            background:#006428;
            color:white;
            border:none;
            padding:11px;
            border-radius:10px;
            font-weight:700;
            font-size:14px;
            cursor:pointer;
        }
        .btn-group { display:flex; gap:8px; }
        .btn-ulangi {
            flex:1; background:#3b82f6; color:white;
            border:none; padding:9px; border-radius:8px;
            font-weight:600; font-size:13px; cursor:pointer;
        }
        .btn-selesai {
            flex:1; background:#22c55e; color:white;
            border:none; padding:9px; border-radius:8px;
            font-weight:600; font-size:13px; cursor:pointer;
        }
        .btn-lewati {
            flex:1; background:#6b7280; color:white;
            border:none; padding:9px; border-radius:8px;
            font-weight:600; font-size:13px; cursor:pointer;
        }

        /* Empty state */
        .empty {
            text-align:center;
            padding:40px 20px;
            color:#9ca3af;
        }
        .empty-icon { font-size:40px; margin-bottom:8px; }

        /* Loading */
        .loading { text-align:center; padding:20px; color:#9ca3af; font-size:13px; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="header-title">🏦 Pegadaian</div>
            <div class="header-sub">Sistem Antrean Kasir</div>
        </div>
        <div class="clock" id="clock"></div>
    </div>

    {{-- Pilih Loket --}}
    <div class="loket-section">
        <div class="loket-label">Pilih Loket Anda</div>
        <div class="loket-grid" style="grid-template-columns: repeat({{ $counters->count() }}, 1fr)">
            @foreach($counters as $counter)
            <button class="loket-btn {{ $loop->first ? 'active' : '' }}"
                    data-id="{{ $counter->id }}"
                    data-name="{{ $counter->name }}"
                    onclick="selectLoket(this)">
                {{ $counter->name }}
            </button>
            @endforeach
        </div>
    </div>

    {{-- Tabs --}}
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('waiting', this)">
            Menunggu <span class="tab-badge" id="badge-waiting">0</span>
        </button>
        <button class="tab-btn" onclick="switchTab('called', this)">
            Dilayani <span class="tab-badge" id="badge-called">0</span>
        </button>
    </div>

    {{-- Content --}}
    <div class="content">
        {{-- Tab Menunggu --}}
        <div id="tab-waiting">
            <div class="loading">Memuat data...</div>
        </div>

        {{-- Tab Dilayani --}}
        <div id="tab-called" style="display:none">
            <div class="loading">Memuat data...</div>
        </div>
    </div>

    <script>
        let selectedLocketId = {{ $counters->first()?->id ?? 1 }};
        let selectedLocketName = '{{ $counters->first()?->name ?? "Loket 1" }}';
        let currentTab = 'waiting';

        // Clock
        function updateClock() {
            const now = new Date();
            const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            document.getElementById('clock').innerHTML =
                days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear() +
                '<br>' + String(now.getHours()).padStart(2,'0') + '.' +
                String(now.getMinutes()).padStart(2,'0') + '.' +
                String(now.getSeconds()).padStart(2,'0');
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Select loket
        function selectLoket(el) {
            document.querySelectorAll('.loket-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            selectedLocketId = el.dataset.id;
            selectedLocketName = el.dataset.name;
        }

        // Switch tab
        function switchTab(tab, el) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');
            document.getElementById('tab-waiting').style.display = tab === 'waiting' ? 'block' : 'none';
            document.getElementById('tab-called').style.display = tab === 'called' ? 'block' : 'none';
            currentTab = tab;
        }

        // Load antrean
        function loadAntrean() {
            fetch('/kasir/antrean')
                .then(r => r.json())
                .then(data => {
                    renderWaiting(data.waiting);
                    renderCalled(data.called);
                    document.getElementById('badge-waiting').textContent = data.waiting.length;
                    document.getElementById('badge-called').textContent = data.called.length;
                });
        }

        function renderWaiting(list) {
            const el = document.getElementById('tab-waiting');
            if (list.length === 0) {
                el.innerHTML = '<div class="empty"><div class="empty-icon">✅</div><p>Tidak ada antrean menunggu</p></div>';
                return;
            }
            el.innerHTML = list.map(q => `
                <div class="queue-card">
                    <div class="ticket-row">
                        <span class="ticket-number">${q.ticket_number}</span>
                        <span class="badge badge-waiting">Menunggu</span>
                    </div>
                    <div class="customer-name">${q.customer_name || 'Nasabah Umum'}</div>
                    <div class="service-name">${q.service_category?.name || '-'}</div>
                    <div class="wait-time">Estimasi: ${q.service_category?.estimated_time || 5} menit</div>
                    <button class="btn-panggil" onclick="panggil(${q.id})">
                        📞 Panggil ke ${selectedLocketName}
                    </button>
                </div>
            `).join('');
        }

        function renderCalled(list) {
            const el = document.getElementById('tab-called');
            if (list.length === 0) {
                el.innerHTML = '<div class="empty"><div class="empty-icon">📞</div><p>Belum ada antrean dipanggil</p></div>';
                return;
            }
            el.innerHTML = list.map(q => `
                <div class="queue-card called">
                    <div class="ticket-row">
                        <span class="ticket-number called">${q.ticket_number}</span>
                        <span class="badge badge-called">Dipanggil - ${q.counter?.name || '-'}</span>
                    </div>
                    <div class="customer-name">${q.customer_name || 'Nasabah Umum'}</div>
                    <div class="service-name">${q.service_category?.name || '-'}</div>
                    <div class="btn-group">
                        <button class="btn-ulangi" onclick="ulangi(${q.id}, '${q.ticket_number}')">🔊 Ulangi</button>
                        <button class="btn-selesai" onclick="selesai(${q.id})">✅ Selesai</button>
                        <button class="btn-lewati" onclick="lewati(${q.id})">⏭ Lewati</button>
                    </div>
                </div>
            `).join('');
        }

        function panggil(queueId) {
            fetch('/kasir/panggil', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ queue_id: queueId, counter_id: selectedLocketId })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    speak(data.ticket, selectedLocketName);
                    loadAntrean();
                }
            });
        }

        function selesai(queueId) {
            fetch('/kasir/selesai', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ queue_id: queueId })
            })
            .then(r => r.json())
            .then(() => loadAntrean());
        }

        function lewati(queueId) {
            fetch('/kasir/lewati', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ queue_id: queueId })
            })
            .then(r => r.json())
            .then(() => loadAntrean());
        }

        function ulangi(queueId, ticketNumber) {
            speak(ticketNumber, selectedLocketName);
        }

        function speak(ticketNumber, counterName) {
            const text = `Nomor antrean ${ticketNumber.split('').join(' ')}, silakan menuju ${counterName}`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 0.9;
            window.speechSynthesis.speak(utterance);
        }

        // Auto refresh setiap 10 detik
        loadAntrean();
        setInterval(loadAntrean, 10000);
    </script>
</body>
</html>