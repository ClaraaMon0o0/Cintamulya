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
    {{-- Loading screen --}}
    <div id="fs-loader">
        <div class="fs-loader-spinner"></div>
        <p class="fs-loader-text">Memuat halaman...</p>
    </div>

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
