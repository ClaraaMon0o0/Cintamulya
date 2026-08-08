<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>{{ setting('login_title') }} {{ ucwords(setting('sebutan_desa')) }} {{ $desa['nama_desa'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="robots" content="noindex">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ favico_desa() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>

    @if ($cek_anjungan)
        <link rel="stylesheet" href="{{ asset('css/keyboard.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front/css/mandiri-keyboard.css') }}">
    @endif

    @include('admin.layouts.components.token')

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green-50:  #f0fdf4;
            --green-100: #dcfce7;
            --green-600: #16a34a;
            --green-700: #15803d;
            --green-800: #166534;
            --green-900: #14532d;
            --gray-50:   #f9fafb;
            --gray-100:  #f3f4f6;
            --gray-200:  #e5e7eb;
            --gray-400:  #9ca3af;
            --gray-500:  #6b7280;
            --gray-700:  #374151;
            --gray-900:  #111827;
            --red-50:    #fef2f2;
            --red-200:   #fecaca;
            --red-700:   #b91c1c;
            --shadow-lg: 0 10px 40px rgba(0,0,0,.18), 0 2px 8px rgba(0,0,0,.08);
            --radius:    12px;
            --font:      'Inter', system-ui, -apple-system, sans-serif;
        }

        html, body {
            height: 100%;
            font-family: var(--font);
            -webkit-font-smoothing: antialiased;
        }

        body.mandiri-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 1.5rem 1rem 5rem;          /* bottom pad for cookie banner */
            background:
                linear-gradient(160deg, rgba(10,83,36,.92) 0%, rgba(21,128,61,.82) 60%, rgba(10,83,36,.94) 100%),
                url('{{ default_file(LATAR_LOGIN . setting('latar_login_mandiri'), DEFAULT_LATAR_KEHADIRAN) }}')
                center / cover no-repeat fixed;
        }

        /* ─── Card Wrapper ─────────────────────────────── */
        .card-wrap {
            width: 100%;
            max-width: 920px;
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 680px) {
            .card-wrap { flex-direction: row; min-height: 540px; }
        }

        /* ─── Left Info Panel ──────────────────────────── */
        .info-panel {
            background: linear-gradient(160deg, var(--green-900) 0%, var(--green-700) 100%);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 680px) {
            .info-panel { width: 42%; }
        }

        /* decorative circle */
        .info-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 240px; height: 240px;
            background: rgba(255,255,255,.05);
            border-radius: 50%;
        }

        .info-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .info-brand img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            flex-shrink: 0;
            filter: drop-shadow(0 2px 6px rgba(0,0,0,.2));
        }

        .brand-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: .3px;
            line-height: 1.25;
        }

        .brand-village {
            font-size: .78rem;
            font-weight: 400;
            color: rgba(255,255,255,.75);
            margin-top: .2rem;
        }

        .info-divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,.15);
        }

        .info-meta {
            display: flex;
            flex-direction: column;
            gap: .65rem;
        }

        .info-meta-row {
            display: flex;
            align-items: flex-start;
            gap: .65rem;
            font-size: .8rem;
            color: rgba(255,255,255,.82);
            line-height: 1.5;
        }

        .info-meta-row .icon {
            width: 16px;
            flex-shrink: 0;
            margin-top: 1px;
            color: #86efac;
        }

        .info-notice {
            margin-top: auto;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 8px;
            padding: .9rem 1rem;
            font-size: .78rem;
            line-height: 1.55;
            color: rgba(255,255,255,.9);
            display: flex;
            gap: .55rem;
        }

        .info-notice .icon { color: #86efac; flex-shrink: 0; margin-top: 1px; }

        /* ─── Right Form Panel ─────────────────────────── */
        .form-panel {
            flex: 1;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (min-width: 680px) {
            .form-panel { padding: 3rem 2.5rem; }
        }

        .form-heading {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--gray-900);
            margin-bottom: .3rem;
            line-height: 1.25;
        }

        .form-subheading {
            font-size: .83rem;
            color: var(--gray-500);
            margin-bottom: 1.75rem;
        }

        /* Alert Merah Tegas */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #f87171;
            border-left: 5px solid #dc2626;
            color: #991b1b;
            border-radius: 10px;
            padding: .9rem 1.15rem;
            font-size: .84rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.12);
            display: flex;
            align-items: flex-start;
            gap: .75rem;
        }

        .alert-error i.alert-icon {
            font-size: 1.25rem;
            color: #dc2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-error .alert-heading {
            font-weight: 700;
            color: #7f1d1d;
            font-size: .88rem;
            margin-bottom: .25rem;
        }

        /* Input field */
        .field {
            margin-bottom: 1rem;
            position: relative;
        }

        .field label {
            display: block;
            font-size: .78rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: .35rem;
            letter-spacing: .2px;
        }

        .field-inner {
            position: relative;
        }

        .field-inner .fi-icon {
            position: absolute;
            left: .9rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: .85rem;
            color: var(--gray-400);
            pointer-events: none;
        }

        .field input {
            width: 100%;
            padding: .72rem 1rem .72rem 2.55rem;
            border: 1.5px solid var(--gray-200);
            border-radius: 8px;
            font-family: var(--font);
            font-size: .88rem;
            color: var(--gray-900);
            background: var(--gray-50);
            transition: border-color .18s, box-shadow .18s, background .18s;
        }

        .field input::placeholder { color: var(--gray-400); }

        .field input:focus {
            outline: none;
            border-color: var(--green-600);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(22,163,74,.12);
        }

        /* Show PIN toggle */
        .show-pin-label {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .78rem;
            color: var(--gray-500);
            margin-bottom: 1.5rem;
            cursor: pointer;
            user-select: none;
        }

        .show-pin-label input { width: 14px; height: 14px; accent-color: var(--green-600); cursor: pointer; }

        /* Divider */
        .form-divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: .25rem 0 1rem;
            color: var(--gray-400);
            font-size: .75rem;
        }

        .form-divider::before, .form-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-200);
        }

        /* Buttons */
        .btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .78rem 1.25rem;
            border-radius: 8px;
            font-family: var(--font);
            font-size: .88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .18s;
            border: 1.5px solid transparent;
            margin-bottom: .6rem;
        }

        .btn:last-child { margin-bottom: 0; }

        .btn-primary {
            background: var(--green-700);
            color: #fff;
            border-color: var(--green-700);
            box-shadow: 0 2px 8px rgba(21,128,61,.3);
        }

        .btn-primary:hover, .btn-primary:focus {
            background: var(--green-800);
            border-color: var(--green-800);
            color: #fff;
            box-shadow: 0 4px 12px rgba(21,128,61,.35);
        }

        .btn-outline {
            background: #fff;
            color: var(--green-700);
            border-color: var(--green-700);
        }

        .btn-outline:hover, .btn-outline:focus {
            background: var(--green-50);
            color: var(--green-800);
        }

        .btn-ghost {
            background: var(--gray-100);
            color: var(--gray-700);
            border-color: var(--gray-200);
            font-weight: 500;
        }

        .btn-ghost:hover { background: var(--gray-200); color: var(--gray-900); }

        /* Footer */
        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: .72rem;
            color: var(--gray-400);
        }

        .form-footer a { color: var(--green-700); font-weight: 500; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }

        /* ─── Cookie Banner (fixed-bottom) ────────────── */
        #cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
            box-shadow: 0 -4px 20px rgba(0,0,0,.25);
        }

        #cookie-banner.hidden { display: none; }

        .cookie-text {
            font-size: .8rem;
            line-height: 1.55;
            flex: 1;
            min-width: 200px;
        }

        .cookie-text strong { color: #fff; }

        .cookie-actions {
            display: flex;
            gap: .65rem;
            flex-shrink: 0;
        }

        .cookie-btn {
            padding: .5rem 1.1rem;
            border-radius: 6px;
            font-family: var(--font);
            font-size: .8rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all .18s;
        }

        .cookie-btn-accept {
            background: var(--green-600);
            color: #fff;
        }

        .cookie-btn-accept:hover { background: var(--green-700); }

        .cookie-btn-reject {
            background: transparent;
            color: #94a3b8;
            border: 1px solid #475569;
        }

        .cookie-btn-reject:hover { background: #334155; color: #e2e8f0; }

        /* ─── Cookie Error Dialog ──────────────────────── */
        #cookie-error-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 10000;
            background: rgba(0,0,0,.55);
            backdrop-filter: blur(3px);
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        #cookie-error-overlay.active { display: flex; }

        .cookie-error-dialog {
            background: #fff;
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
        }

        .cookie-error-header {
            background: #fffbeb;
            border-bottom: 1px solid #fde68a;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: .6rem;
        }

        .cookie-error-header i { color: #d97706; font-size: 1rem; }
        .cookie-error-header span { font-size: .92rem; font-weight: 700; color: #92400e; }

        .cookie-error-body {
            padding: 1.25rem;
            font-size: .83rem;
            color: var(--gray-700);
            line-height: 1.6;
        }

        .cookie-error-body strong { color: var(--gray-900); word-break: break-all; }

        .cookie-error-footer {
            padding: .85rem 1.25rem;
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
            text-align: right;
        }

        .cookie-error-footer button {
            padding: .5rem 1.25rem;
            border-radius: 6px;
            background: var(--green-700);
            color: #fff;
            border: none;
            font-family: var(--font);
            font-size: .83rem;
            font-weight: 600;
            cursor: pointer;
        }

        .cookie-error-footer button:hover { background: var(--green-800); }
    </style>
</head>

<body class="mandiri-page">

    {{-- ── Main Card ── --}}
    <div class="card-wrap">

        {{-- Left: Info Panel --}}
        <div class="info-panel">
            <a href="{{ base_url('/') }}" class="info-brand">
                <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $desa['nama_desa'] }}" onerror="this.style.display='none'">
                <div>
                    <div class="brand-name">LAYANAN MANDIRI</div>
                    <div class="brand-village">{{ ucwords(setting('sebutan_desa')) }} {{ $desa['nama_desa'] }}</div>
                </div>
            </a>

            <hr class="info-divider">

            <div class="info-meta">
                <div class="info-meta-row">
                    <i class="fa-solid fa-location-dot icon"></i>
                    <span>{{ ucwords(setting('sebutan_kecamatan')) }} {{ $desa['nama_kecamatan'] }}, {{ ucwords(setting('sebutan_kabupaten')) }} {{ $desa['nama_kabupaten'] }}</span>
                </div>
                @if($desa['alamat_kantor'])
                <div class="info-meta-row">
                    <i class="fa-solid fa-building icon"></i>
                    <span>{{ $desa['alamat_kantor'] }}</span>
                </div>
                @endif
                <div class="info-meta-row">
                    <i class="fa-solid fa-envelope icon"></i>
                    <span>Kodepos {{ $desa['kode_pos'] ?: '-' }}</span>
                </div>
            </div>

            <div class="info-notice">
                <i class="fa-solid fa-circle-info icon"></i>
                <span>Hubungi operator desa untuk mendapatkan <strong>kode PIN</strong> Anda.</span>
            </div>
        </div>

        {{-- Right: Form Panel --}}
        <div class="form-panel">
            <h1 class="form-heading">Masuk</h1>
            <p class="form-subheading">Layanan Mandiri {{ ucwords(setting('sebutan_desa')) }} {{ $desa['nama_desa'] }}</p>

            @php
                preg_match('/(\d+)/', $errors->first('email'), $matches);
                $second = $matches[0] ?? 0;
            @endphp

            @if ($errors->any())
                <div class="alert-error" id="notif">
                    @foreach ($errors->all() as $item)
                        <p id="{{ str_contains($item, 'Terlalu banyak') ? 'countdown' : '' }}" style="margin:0;">{{ $item }}</p>
                    @endforeach
                </div>
            @endif

            @if ($notif = $ci->session->flashdata('notif'))
                <div class="alert-error" id="notif"><p style="margin:0;">{{ $notif }}</p></div>
            @endif

            @yield('content')

            <div class="form-footer">
                <a href="{{ base_url('/') }}"><i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda</a>
                &nbsp;·&nbsp;
                <a href="https://github.com/OpenSID/OpenSID" target="_blank" rel="noopener noreferrer">OpenSID v<?= AmbilVersi() ?></a>
            </div>
        </div>
    </div>

    {{-- ── Cookie Consent Banner (fixed bottom) ── --}}
    <div id="cookie-banner">
        <div class="cookie-text">
            <strong>Privasi & Cookie</strong> — Kami menggunakan cookie untuk memastikan layanan berjalan dengan baik dan pengalaman pengguna yang optimal.
        </div>
        <div class="cookie-actions">
            <button class="cookie-btn cookie-btn-reject" onclick="rejectCookie()">Tolak</button>
            <button class="cookie-btn cookie-btn-accept" onclick="buatPengunjungCookie('pengunjung')">
                <i class="fa-solid fa-check"></i> Terima Cookie
            </button>
        </div>
    </div>

    {{-- ── Cookie Error Dialog ── --}}
    <div id="cookie-error-overlay">
        <div class="cookie-error-dialog" role="dialog" aria-modal="true" aria-labelledby="cerr-title">
            <div class="cookie-error-header">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span id="cerr-title">Cookie Tidak Aktif</span>
            </div>
            <div class="cookie-error-body">
                Perambah web Anda tidak mengizinkan akses cookie. Silakan aktifkan cookie untuk alamat <strong><?= site_url() ?></strong> agar layanan dapat berjalan dengan semestinya.
            </div>
            <div class="cookie-error-footer">
                <button onclick="document.getElementById('cookie-error-overlay').classList.remove('active')">Saya Mengerti</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/validasi.js') }}"></script>

    @if ($cek_anjungan)
        <script src="{{ asset('js/jquery.keyboard.min.js') }}"></script>
        <script src="{{ asset('js/jquery.mousewheel.min.js') }}"></script>
        <script src="{{ asset('js/jquery.keyboard.extension-all.min.js') }}"></script>
        <script src="{{ asset('front/js/mandiri-keyboard.js') }}"></script>
    @endif

    <script src="{{ asset('js/id_browser.js') }}"></script>

    <script>
        // Cookie banner — hide if already accepted
        (function() {
            var name = 'pengunjung';
            function getCookie(n) {
                var m = document.cookie.match('(^|;)\\s*' + n + '\\s*=\\s*([^;]+)');
                return m ? m.pop() : '';
            }
            if (getCookie(name)) {
                document.getElementById('cookie-banner').classList.add('hidden');
            }
        })();

        function rejectCookie() {
            document.getElementById('cookie-banner').classList.add('hidden');
        }

        // Override buatPengunjungCookie to also hide banner
        var _origBuat = window.buatPengunjungCookie;
        window.buatPengunjungCookie = function(name) {
            if (typeof _origBuat === 'function') _origBuat(name);
            document.getElementById('cookie-banner').classList.add('hidden');
        };

        // Countdown for rate-limit
        function start_countdown() {
            var totalSeconds = {{ $second ?? 0 }};
            var timer = setInterval(function() {
                var minutes = Math.floor(totalSeconds / 60);
                var seconds = totalSeconds % 60;
                if (totalSeconds <= 0) {
                    clearInterval(timer);
                    location.reload();
                } else {
                    var el = document.getElementById('countdown');
                    if (el) el.textContent = 'Terlalu banyak upaya masuk. Silakan coba lagi dalam ' + minutes + ' menit ' + seconds + ' detik.';
                    totalSeconds--;
                }
            }, 1000);
        }

        $(function() {
            if ($('#pin').length) $('#pin').focus();
            else if ($('#tag').length) $('#tag').focus();
            if ($('#countdown').length) start_countdown();

            setTimeout(function() {
                $('#notif').fadeOut(400, function() { $(this).remove(); });
            }, 6000);
        });
    </script>

    @stack('script')
</body>
</html>
