<header class="fs-navbar" id="fs-navbar">
    <div class="fs-container">
        <nav class="fs-nav-inner">
            {{-- Brand --}}
            <a href="{{ site_url() }}" class="fs-brand" aria-label="Halaman beranda">
                <img src="{{ gambar_desa($desa['logo'] ?? null) }}" alt="Logo {{ $desa['nama_desa'] ?? 'Desa' }}"
                     style="height:42px;width:auto;object-fit:contain;"
                     onerror="this.style.display='none'">
                <div>
                    <span class="fs-brand-name">Desa {{ $desa['nama_desa'] ?? 'Cinta Mulya' }}</span>
                    <span class="fs-brand-sub">
                        {{ ucfirst(setting('sebutan_kecamatan_singkat') ?? 'Kec.') }} {{ ucwords($desa['nama_kecamatan'] ?? 'Candipuro') }},
                        {{ ucfirst(setting('sebutan_kabupaten_singkat') ?? 'Kab.') }} {{ ucwords($desa['nama_kabupaten'] ?? 'Lampung Selatan') }}
                    </span>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <ul class="fs-nav-menu" role="navigation" aria-label="Menu utama">
                <li>
                    <a href="{{ site_url() }}" class="fs-nav-link {{ request()->is('/') || request()->is('') ? 'active' : '' }}" id="nav-beranda">Beranda</a>
                </li>
                <li class="fs-dropdown">
                    <a href="#" class="fs-nav-link {{ request()->is('first/artikel/*') || request()->is('data-wilayah') || request()->is('pemerintah') ? 'active' : '' }}" id="nav-profil">
                        Profil Desa <i class="fa-solid fa-chevron-down" style="font-size:.65rem;"></i>
                    </a>
                    <ul class="fs-dropdown-menu" aria-label="Profil Desa">
                        <li><a href="{{ site_url('first/artikel/sejarah') }}">Sejarah Desa</a></li>
                        <li><a href="{{ site_url('first/artikel/visi-misi') }}">Visi &amp; Misi</a></li>
                        <li><a href="{{ site_url('data-wilayah') }}">Peta Wilayah</a></li>
                        <li><a href="{{ site_url('pemerintah') }}">Aparatur Desa</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ site_url('artikel/kategori/1') }}" class="fs-nav-link {{ request()->is('artikel*') ? 'active' : '' }}" id="nav-berita">Berita</a>
                </li>
                <li>
                    <a href="{{ site_url('status-idm') }}" class="fs-nav-link {{ request()->is('status-idm*') ? 'active' : '' }}" id="nav-idm">IDM</a>
                </li>
                <li>
                    <a href="{{ site_url('galeri') }}" class="fs-nav-link {{ request()->is('galeri*') ? 'active' : '' }}" id="nav-galeri">Galeri</a>
                </li>
                <li>
                    <a href="{{ site_url('pengaduan') }}" class="fs-nav-link {{ request()->is('pengaduan*') ? 'active' : '' }}" id="nav-layanan">Pengaduan</a>
                </li>
            </ul>

            <div style="display:flex;align-items:center;gap:.5rem;">
                <a href="{{ site_url('layanan-mandiri') }}" class="fs-nav-cta" id="nav-mandiri">
                    <i class="fa-solid fa-user"></i> Layanan Mandiri
                </a>
                <a href="{{ site_url('siteman') }}" class="fs-nav-cta" id="nav-admin" style="background:var(--c-primary-dark);" title="Login Admin OpenSID">
                    <i class="fa-solid fa-lock"></i> Admin
                </a>
            </div>

            {{-- Hamburger --}}
            <button class="fs-hamburger" id="fs-ham" aria-label="Buka menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </nav>
    </div>

    {{-- Mobile Menu --}}
    <div class="fs-mobile-menu" id="fs-mobile-menu" role="navigation" aria-label="Menu mobile">
        <a href="{{ site_url() }}">Beranda</a>
        <a href="{{ site_url('first/artikel/sejarah') }}">Sejarah Desa</a>
        <a href="{{ site_url('first/artikel/visi-misi') }}">Visi &amp; Misi</a>
        <a href="{{ site_url('data-wilayah') }}">Peta Wilayah</a>
        <a href="{{ site_url('pemerintah') }}">Aparatur Desa</a>
        <a href="{{ site_url('artikel/kategori/1') }}">Berita Desa</a>
        <a href="{{ site_url('status-idm') }}">Status IDM</a>
        <a href="{{ site_url('galeri') }}">Galeri Desa</a>
        <a href="{{ site_url('pengaduan') }}">Pengaduan Online</a>
        <a href="{{ site_url('layanan-mandiri') }}">Layanan Mandiri</a>
        <a href="{{ site_url('siteman') }}">Login Admin OpenSID</a>
    </div>
</header>

{{-- Running Text --}}
@if (!empty($teks_berjalan))
<div class="fs-ticker" role="marquee" aria-label="Pengumuman berjalan">
    <div class="fs-container">
        <marquee onmouseover="this.stop();" onmouseout="this.start();">
            <span class="fs-ticker-inner">
                @foreach ($teks_berjalan as $tk)
                    <span style="margin-right:2.5rem;">
                        <i class="fa-solid fa-bullhorn"></i>
                        {{ $tk['teks'] }}
                        @if (!empty($tk['tautan']) && !empty($tk['judul_tautan']))
                            &nbsp;<a href="{{ $tk['tautan'] }}">{{ $tk['judul_tautan'] }}</a>
                        @endif
                    </span>
                @endforeach
            </span>
        </marquee>
    </div>
</div>
@endif
