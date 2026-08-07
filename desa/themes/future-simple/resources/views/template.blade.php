@php
    $themeVersion = 'v2409.1.0';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    @include('theme::commons.meta')
    @include('theme::commons.source_css')
    <title>{{ setting('nama_desa') ?? ($desa['nama_desa'] ?? 'Desa Cinta Mulya') }} - Website Resmi</title>
    @stack('styles')
</head>
<body>
    {{-- Loading screen dengan logo desa berputar --}}
    <div id="fs-loader" style="position:fixed;inset:0;z-index:9999;background:white;display:flex;flex-direction:column;align-items:center;justify-content:center;transition:opacity .4s;">
        <div style="position:relative;width:120px;height:120px;display:flex;align-items:center;justify-content:center;">
            <div style="width:100px;height:100px;border:4px solid var(--c-primary);border-top:4px solid transparent;border-radius:50%;position:absolute;animation:spinZoom 1.5s linear infinite;"></div>
            <div style="width:64px;height:64px;background:white;border-radius:50%;display:flex;justify-content:center;align-items:center;z-index:10;box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                <img src="{{ gambar_desa($desa['logo'] ?? null) }}" alt="Logo {{ $desa['nama_desa'] ?? 'Desa' }}" style="width:40px;height:40px;object-fit:contain;" onerror="this.style.display='none'">
            </div>
        </div>
        <p style="font-size:.85rem;color:var(--c-text-muted);font-weight:600;margin-top:.75rem;">Memuat {{ $desa['nama_desa'] ?? 'Desa' }}...</p>
    </div>

    <style>
    @keyframes spinZoom {
        0% { transform: rotate(0deg) scale(1); opacity: 1; }
        50% { transform: rotate(180deg) scale(1.15); opacity: 0.7; }
        100% { transform: rotate(360deg) scale(1); opacity: 1; }
    }
    </style>

    <a href="#konten" class="fs-skip">Lompat ke konten utama</a>

    @include('theme::commons.header')

    <main id="konten">
        @hasSection('layout')
            @yield('layout')
        @else
            @yield('content')
        @endif
    </main>

    @include('theme::commons.footer')

    <button id="fs-btt" aria-label="Kembali ke atas" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="fa-solid fa-chevron-up"></i>
    </button>

    @include('theme::commons.source_js')
    @stack('scripts')
</body>
</html>
