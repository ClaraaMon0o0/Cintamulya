@php
    $bg_header = $latar_website ?: theme_asset('images/header-bg.jpg');
@endphp

<div class="w-full">
    <header style="background-image: url({{ $bg_header }});" class="bg-center bg-cover bg-no-repeat relative text-white">
        <div class="absolute bg-gray-800 bg-opacity-60 top-0 left-0 right-0 h-full">
        </div>

        @include('theme::commons.category_menu')

        <section class="relative z-10 text-center space-y-2 mt-3 px-3 lg:px-5">
            <a href="{{ site_url('/') }}">
                <span class="text-h2 block">{{ $desa['nama_desa'] }}</span>
                <p>{{ ucfirst(setting('sebutan_kecamatan_singkat')) }}
                    {{ ucwords($desa['nama_kecamatan']) }},
                    {{ ucfirst(setting('sebutan_kabupaten_singkat')) }}
                    {{ ucwords($desa['nama_kabupaten']) }},
                    Provinsi
                    {{ ucwords($desa['nama_propinsi']) }}
                </p>
            </a>
        </section>
        @if ($teks_berjalan)
            <div class="block px-3 bg-white text-white bg-opacity-20 py-1.5 text-xs mt-6 mb-0 z-20 relative">
                <marquee onmouseover="this.stop();" onmouseout="this.start();" class="block divide-x-4 relative">
                    @foreach ($teks_berjalan as $marquee)
                        <span class="px-3">
                            {{ $marquee['teks'] }}
                            @if (trim($marquee['tautan']) && $marquee['judul_tautan'])
                                <a href="{{ $marquee['tautan'] }}" class="hover:text-link">{{ $marquee['judul_tautan'] }}</a>
                            @endif
                        </span>
                    @endforeach
                </marquee>
            </div>
        @endif
    </header>
    @include('theme::commons.main_menu')
    @include('theme::commons.mobile_menu')
</div>
