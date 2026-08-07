<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Cinta Mulya - Futuristic Simplism')</title>

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- CSS Tokens & Main Styles -->
    <link rel="stylesheet" href="{{ theme_asset('css/_tokens.css') }}">
    <link rel="stylesheet" href="{{ theme_asset('css/main.css') }}">

    <!-- Verified CDN Libraries -->
    <!-- Anime.js v3.2.2 (Verified) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>
    <!-- Leaflet.js v1.9.4 (Verified) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    @stack('styles')
</head>
<body class="bg-page">
    <a href="#konten" class="skip-link">Lompat ke konten utama</a>

    @include('theme::commons.header')

    <main id="konten">
        @yield('content')
    </main>

    @include('theme::commons.footer')

    <script src="{{ theme_asset('js/animations.js') }}"></script>
    @stack('scripts')
</body>
</html>
