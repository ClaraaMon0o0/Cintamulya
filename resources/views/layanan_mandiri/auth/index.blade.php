<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>
        {{ setting('login_title') . ' ' . ucwords(setting('sebutan_desa')) . ($desa['nama_desa'] ? ' ' . $desa['nama_desa'] : '') . get_dynamic_title_page_from_path() }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="{{ favico_desa() }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>

    @if ($cek_anjungan)
        <link rel="stylesheet" href="{{ asset('css/keyboard.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front/css/mandiri-keyboard.css') }}">
    @endif

    @include('admin.layouts.components.token')

    <style type="text/css">
        :root {
            --c-primary: #16803c;
            --c-primary-dark: #0a5b28;
            --c-primary-light: #dcfce7;
            --c-text-head: #111827;
            --c-text-body: #374151;
            --c-text-muted: #6b7280;
            --c-border: #e5e7eb;
            --ff-base: 'Poppins', system-ui, -apple-system, sans-serif;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body.login-mandiri-body {
            font-family: var(--ff-base);
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(10, 91, 40, 0.88) 0%, rgba(22, 128, 60, 0.8) 100%), 
                        url('{{ default_file(LATAR_LOGIN . setting('latar_login_mandiri'), DEFAULT_LATAR_KEHADIRAN) }}') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .mandiri-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 940px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 768px) {
            .mandiri-card {
                flex-direction: row;
                min-height: 520px;
            }
        }

        .mandiri-info-panel {
            background: linear-gradient(135deg, #0a5b28 0%, #16803c 100%);
            color: white;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .mandiri-info-panel {
                width: 48%;
            }
        }

        .mandiri-info-panel::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .mandiri-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .mandiri-brand img {
            height: 52px;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
        }

        .mandiri-brand-title {
            font-size: 1.25rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: .5px;
            color: white;
        }

        .mandiri-brand-sub {
            font-size: .8rem;
            opacity: .9;
            font-weight: 400;
            margin-top: .2rem;
        }

        .mandiri-details {
            font-size: .84rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.92);
            margin-bottom: 1.5rem;
        }

        .mandiri-details i {
            width: 20px;
            color: #a7f3d0;
        }

        .mandiri-notice {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: .85rem 1.1rem;
            border-radius: 12px;
            font-size: .8rem;
            line-height: 1.5;
            color: #ecfdf5;
        }

        .mandiri-form-panel {
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
        }

        @media (min-width: 768px) {
            .mandiri-form-panel {
                width: 52%;
                padding: 3rem 2.5rem;
            }
        }

        .mandiri-form-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--c-text-head);
            margin-bottom: .35rem;
        }

        .mandiri-form-sub {
            font-size: .85rem;
            color: var(--c-text-muted);
            margin-bottom: 1.75rem;
        }

        .mandiri-input-group {
            margin-bottom: 1.1rem;
            position: relative;
        }

        .mandiri-input-group i.input-icon {
            position: absolute;
            left: 1.1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-text-muted);
            font-size: .95rem;
        }

        .mandiri-input {
            width: 100%;
            padding: .75rem 1rem .75rem 2.8rem;
            border: 1.5px solid var(--c-border);
            border-radius: 10px;
            font-family: var(--ff-base);
            font-size: .9rem;
            color: var(--c-text-head);
            background: #f8fafc;
            transition: border-color .2s, box-shadow .2s;
        }

        .mandiri-input:focus {
            outline: none;
            border-color: var(--c-primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(22, 128, 60, 0.15);
        }

        .mandiri-checkbox {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .82rem;
            color: var(--c-text-body);
            margin-bottom: 1.5rem;
            cursor: pointer;
            user-select: none;
        }

        .mandiri-btn {
            width: 100%;
            padding: .8rem 1.25rem;
            border-radius: 10px;
            font-family: var(--ff-base);
            font-size: .9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            text-decoration: none;
            margin-bottom: .75rem;
        }

        .mandiri-btn-primary {
            background: var(--c-primary);
            color: white;
            border: none;
            box-shadow: 0 4px 12px rgba(22, 128, 60, 0.25);
        }

        .mandiri-btn-primary:hover {
            background: var(--c-primary-dark);
            color: white;
        }

        .mandiri-btn-outline {
            background: white;
            color: var(--c-primary);
            border: 1.5px solid var(--c-primary);
        }

        .mandiri-btn-outline:hover {
            background: var(--c-primary-light);
            color: var(--c-primary-dark);
        }

        .mandiri-btn-subtle {
            background: #f1f5f9;
            color: var(--c-text-body);
            border: 1px solid var(--c-border);
            font-weight: 600;
        }

        .mandiri-btn-subtle:hover {
            background: #e2e8f0;
            color: var(--c-text-head);
        }

        .mandiri-footer {
            margin-top: 1.25rem;
            text-align: center;
            font-size: .75rem;
            color: var(--c-text-muted);
        }

        .mandiri-footer a {
            color: var(--c-primary);
            font-weight: 600;
            text-decoration: none;
        }
    </style>
</head>

<body class="login-mandiri-body">
    <div class="mandiri-card">
        {{-- Left Info Panel --}}
        <div class="mandiri-info-panel">
            <div>
                <a href="{{ base_url('/') }}" class="mandiri-brand" style="text-decoration:none;">
                    <img src="{{ gambar_desa($desa['logo']) }}" alt="Logo {{ $desa['nama_desa'] }}" onerror="this.style.display='none'">
                    <div>
                        <div class="mandiri-brand-title">LAYANAN MANDIRI</div>
                        <div class="mandiri-brand-sub">{{ ucwords(setting('sebutan_desa')) }} {{ $desa['nama_desa'] }}</div>
                    </div>
                </a>

                <div class="mandiri-details">
                    <p style="margin-bottom:.5rem;"><i class="fa-solid fa-location-dot"></i> {{ ucwords(setting('sebutan_kecamatan')) }} {{ $desa['nama_kecamatan'] }}, {{ ucwords(setting('sebutan_kabupaten')) }} {{ $desa['nama_kabupaten'] }}</p>
                    <p style="margin-bottom:.5rem;"><i class="fa-solid fa-building-user"></i> {{ $desa['alamat_kantor'] ?: 'Kantor Desa' }}</p>
                    <p style="margin-bottom:.5rem;"><i class="fa-solid fa-mailbox"></i> Kodepos {{ $desa['kode_pos'] ?: '-' }}</p>
                </div>
            </div>

            <div>
                <div class="mandiri-notice">
                    <i class="fa-solid fa-circle-info" style="margin-right:.3rem;color:#a7f3d0;"></i> Silakan hubungi operator desa untuk mendapatkan kode PIN Anda.
                </div>
                <div style="font-size:.72rem;opacity:.7;margin-top:.75rem;">
                    IP Address: {{ request()->ip() }}
                    @if ($cek_anjungan)
                        @if ($cek_anjungan['mac_address']) | MAC: {{ $cek_anjungan['mac_address'] }} @endif
                        | Anjungan Mandiri
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Form Panel --}}
        <div class="mandiri-form-panel">
            <div class="mandiri-form-title">Masuk Layanan Mandiri</div>
            <div class="mandiri-form-sub">Akses surat online dan layanan warga {{ $desa['nama_desa'] }}</div>

            @php
                preg_match('/(\d+)/', $errors->first('email'), $matches);
                $second = $matches[0] ?? 0;
            @endphp

            @if ($errors->any())
                <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:.75rem 1rem;border-radius:10px;font-size:.82rem;margin-bottom:1.25rem;">
                    @foreach ($errors->all() as $item)
                        <p style="margin:0;">{{ $item }}</p>
                    @endforeach
                </div>
            @endif

            @if ($notif = $ci->session->flashdata('notif'))
                <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:.75rem 1rem;border-radius:10px;font-size:.82rem;margin-bottom:1.25rem;">
                    <p style="margin:0;">{{ $notif }}</p>
                </div>
            @endif

            @yield('content')

            <div class="mandiri-footer">
                Dipersembahkan oleh <a href="https://github.com/OpenSID/OpenSID" target="_blank" rel="noopener">OpenSID v<?= AmbilVersi() ?></a>
            </div>
        </div>
    </div>

    @include('admin.layouts.components.konfirmasi_cookie', ['cookie_name' => 'pengunjung'])
    @include('admin.layouts.components.aktifkan_cookie')

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
        function start_countdown() {
            let totalSeconds = {{ $second ?? 0 }};
            const timer = setInterval(function() {
                const minutes = Math.floor(totalSeconds / 60);
                const seconds = totalSeconds % 60;

                if (totalSeconds <= 0) {
                    clearInterval(timer);
                    location.reload();
                } else {
                    var el = document.getElementById("countdown");
                    if (el) el.innerHTML = `Terlalu banyak upaya masuk. Silakan coba lagi dalam ${minutes} menit ${seconds} detik.`;
                    totalSeconds--;
                }
            }, 1000);
        }

        $(document).ready(function() {
            if ($('#pin').length) {
                $('#pin').focus();
            } else if ($('#tag').length) {
                $('#tag').focus();
            }

            if ($('#countdown').length) {
                start_countdown();
            }

            window.setTimeout(function() {
                $("#notif").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>

    @stack('script')
</body>

</html>
