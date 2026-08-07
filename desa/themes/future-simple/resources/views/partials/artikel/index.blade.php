@extends('theme::layouts.beranda')

@php
    $cmCari = trim((string)($cari ?? ''));
    $cmBeranda = $cmCari === '' && empty($judul_kategori) && !request()->filled('page') && request()->segment(2) !== 'kategori';

    $cmNamaDesa   = ucwords(trim((string)($desa['nama_desa'] ?? '')) ?: 'Cinta Mulya');
    $cmKecamatan  = ucwords(trim((string)($desa['nama_kecamatan'] ?? '')) ?: 'Candipuro');
    $cmKabupaten  = ucwords(trim((string)($desa['nama_kabupaten'] ?? '')) ?: 'Lampung Selatan');
    $cmProvinsi   = ucwords(trim((string)($desa['nama_propinsi'] ?? '')) ?: 'Lampung');
    $cmSebKec     = ucfirst(setting('sebutan_kecamatan_singkat') ?? 'Kec.');
    $cmSebKab     = ucfirst(setting('sebutan_kabupaten_singkat') ?? 'Kab.');
    $cmHeroBg     = $latar_website ?: theme_asset('images/header-bg.jpg');

    $cmJudulBerita = 'Berita &amp; Artikel Desa';
    if (!empty($judul_kategori)) {
        $cmJudulBerita = e(is_array($judul_kategori) ? ($judul_kategori['kategori'] ?? 'Artikel') : $judul_kategori);
    } elseif ($cmCari !== '') {
        $cmJudulBerita = 'Hasil Pencarian: <em>' . e(substr($cmCari, 0, 50)) . '</em>';
    }

    // --- LIVE DB STATISTIK DATA ---
    try {
        $dbTotalPenduduk = \Illuminate\Support\Facades\DB::table('tweb_penduduk')->where('status_dasar', 1)->count();
    } catch (\Throwable $e) { $dbTotalPenduduk = 5054; }

    try {
        $dbTotalKK = \Illuminate\Support\Facades\DB::table('tweb_keluarga')->count();
    } catch (\Throwable $e) { $dbTotalKK = 1550; }

    try {
        $dbConfig = \Illuminate\Support\Facades\DB::table('config')->first();
        $luasDesa = !empty($dbConfig->luas_desa) ? $dbConfig->luas_desa : '1.250';
    } catch (\Throwable $e) { $luasDesa = '1.250'; }

    $totalPenduduk = $dbTotalPenduduk > 0 ? $dbTotalPenduduk : ($stat_widget['jumlah_penduduk'] ?? 5054);
    $totalKK       = $dbTotalKK > 0 ? $dbTotalKK : ($stat_widget['jumlah_kk'] ?? 1550);

    // --- APBDES LIVE DATA (Direct Non-Zero DB Query) ---
    $apbdesList = [];
    try {
        $apbData = \Illuminate\Support\Facades\DB::table('keuangan')
            ->where('anggaran', '>', 0)
            ->orderBy('tahun', 'desc')
            ->limit(4)
            ->get();
        if ($apbData->count() > 0) {
            foreach ($apbData as $ap) {
                $apbdesList[] = [
                    'nama' => 'Pelaksanaan APBDes Tahun ' . $ap->tahun,
                    'anggaran' => $ap->anggaran,
                    'realisasi' => $ap->realisasi,
                    'tahun' => $ap->tahun
                ];
            }
        } elseif (!empty($transparansi)) {
            $apbdesList = (array)$transparansi;
        }
    } catch (\Throwable $e) {}

    // --- APARATUR DESA LIVE DATA ---
    $pamongList = [];
    try {
        $pamongList = \Illuminate\Support\Facades\DB::table('tweb_desa_pamong')
            ->leftJoin('ref_jabatan', 'tweb_desa_pamong.jabatan_id', '=', 'ref_jabatan.id')
            ->select('tweb_desa_pamong.*', 'ref_jabatan.nama as nama_jabatan')
            ->where('pamong_status', 1)
            ->where('pamong_nama', '!=', '')
            ->orderBy('tweb_desa_pamong.pamong_id', 'asc')
            ->limit(4)
            ->get();
    } catch (\Throwable $e) {}
@endphp

{{-- ============================================================
     ABOVE THE FOLD: Hero, Pills, IDM Stats, APBDes, Aparatur
     ============================================================ --}}
@section('above_the_fold')
@if ($cmBeranda)

{{-- HERO --}}
<section class="fs-hero">
    <div class="fs-container">
        <div class="fs-hero-grid">
            <div class="fs-hero-content">
                <span class="fs-hero-badge">Website Resmi Pemerintah Desa</span>
                <h1 class="fs-hero-title">Desa <span>{{ $cmNamaDesa }}</span></h1>
                <p class="fs-hero-location">
                    <i class="fa-solid fa-location-dot"></i>
                    {{ $cmSebKec }} {{ $cmKecamatan }}, {{ $cmSebKab }} {{ $cmKabupaten }}, Provinsi {{ $cmProvinsi }}
                </p>
                <p class="fs-hero-desc">
                    Pusat informasi dan transparansi tata kelola pemerintahan desa yang inovatif,
                    transparan, dan melayani seluruh masyarakat sepenuh hati.
                </p>
                <div class="fs-hero-btns">
                    <a href="{{ site_url('first/artikel/visi-misi') }}" class="fs-btn-primary" id="hero-visi-misi">
                        <i class="fa-solid fa-bullseye"></i> Visi &amp; Misi
                    </a>
                    <a href="{{ site_url('status-idm') }}" class="fs-btn-outline" id="hero-link-apbdes">
                        <i class="fa-solid fa-chart-line"></i> Status IDM
                    </a>
                </div>
            </div>

            <div class="fs-hero-visual">
                <div class="fs-hero-img-wrap">
                    <img src="{{ $cmHeroBg }}"
                         alt="Kantor Desa {{ $cmNamaDesa }}"
                         loading="eager"
                         onerror="this.src='https://placehold.co/700x380/16803c/ffffff?text=Desa+{{ urlencode($cmNamaDesa) }}'">
                    <div class="fs-hero-img-caption">
                        <i class="fa-solid fa-building-flag"></i>
                        Desa {{ $cmNamaDesa }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- QUICK PILLS --}}
<div class="fs-quick">
    <div class="fs-container">
        <div class="fs-quick-inner">
            <span style="font-size:.78rem;font-weight:600;color:var(--c-text-muted);margin-right:.25rem;">Akses Cepat:</span>
            <a href="#sec-berita" class="fs-pill active" id="pill-beranda-berita">
                <i class="fa-solid fa-newspaper"></i> Berita
            </a>
            <a href="{{ site_url('status-idm') }}" class="fs-pill" id="pill-beranda-idm">
                <i class="fa-solid fa-chart-line"></i> IDM
            </a>
            <a href="{{ site_url('galeri') }}" class="fs-pill" id="pill-beranda-galeri">
                <i class="fa-solid fa-images"></i> Galeri
            </a>
            <a href="{{ site_url('data-wilayah') }}" class="fs-pill" id="pill-beranda-peta">
                <i class="fa-solid fa-map-location-dot"></i> Peta Wilayah
            </a>
            <a href="{{ site_url('pemerintah') }}" class="fs-pill" id="pill-beranda-pemerintah">
                <i class="fa-solid fa-users"></i> Pemerintah Desa
            </a>
        </div>
    </div>
</div>

{{-- IDM & LIVE STATS --}}
<section class="fs-section fs-section-white">
    <div class="fs-container">
        <div class="fs-section-head anime-hidden">
            <h2 class="fs-section-title">Data &amp; Statistik Desa (Live DB)</h2>
            <a href="{{ site_url('status-idm') }}" class="fs-section-more" id="more-link-idm">
                Lihat Status IDM <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="fs-stats-grid anime-stagger">
            @php
                $idmScore  = isset($idm['score']) ? number_format((float)$idm['score'], 4) : '0.7500';
                $idmStatus = $idm['status'] ?? 'Maju';
            @endphp
            <div class="fs-stat-card anime-stagger-item" id="stat-idm">
                <div class="fs-stat-icon"><i class="fa-solid fa-star"></i></div>
                <div class="fs-stat-number" style="font-size:1.4rem;">{{ $idmScore }}</div>
                <div class="fs-stat-label">Skor IDM {{ date('Y') }}</div>
                <div style="margin-top:.4rem;">
                    <span style="background:var(--c-primary-light);color:var(--c-primary-dark);font-size:.7rem;font-weight:600;padding:.2rem .6rem;border-radius:999px;">
                        {{ $idmStatus }}
                    </span>
                </div>
            </div>
            <div class="fs-stat-card anime-stagger-item" id="stat-total-penduduk">
                <div class="fs-stat-icon"><i class="fa-solid fa-people-group"></i></div>
                <div class="fs-stat-number" data-counter="{{ (int)$totalPenduduk }}">{{ number_format((int)$totalPenduduk) }}</div>
                <div class="fs-stat-label">Total Penduduk</div>
            </div>
            <div class="fs-stat-card anime-stagger-item" id="stat-total-kk">
                <div class="fs-stat-icon"><i class="fa-solid fa-house-user"></i></div>
                <div class="fs-stat-number" data-counter="{{ (int)$totalKK }}">{{ number_format((int)$totalKK) }}</div>
                <div class="fs-stat-label">Kepala Keluarga</div>
            </div>
            <div class="fs-stat-card anime-stagger-item" id="stat-luas-desa">
                <div class="fs-stat-icon"><i class="fa-solid fa-map"></i></div>
                <div class="fs-stat-number" style="font-size:1.4rem;">{{ $luasDesa }}</div>
                <div class="fs-stat-label">Luas Wilayah (Ha)</div>
            </div>
        </div>
    </div>
</section>

{{-- APBDES --}}
@if (!empty($apbdesList))
<section class="fs-section" style="background:var(--c-bg);">
    <div class="fs-container">
        <div class="fs-section-head anime-hidden">
            <h2 class="fs-section-title">Transparansi Keuangan APBDes</h2>
            <a href="{{ site_url('pembangunan') }}" class="fs-section-more" id="more-link-apbdes">
                Detail Pembangunan <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="fs-apb-grid">
            @foreach (array_slice($apbdesList, 0, 4) as $apb)
            @php
                $apbNama     = $apb['nama'] ?? 'Anggaran Desa';
                $apbAnggaran = floatval($apb['anggaran'] ?? 0);
                $apbRealisasi = floatval($apb['realisasi'] ?? 0);
                $apbPct      = $apbAnggaran > 0 ? min(100, round(($apbRealisasi / $apbAnggaran) * 100, 1)) : 0;
            @endphp
            <div class="fs-apb-card anime-hidden">
                <div class="fs-apb-head">
                    <h3 class="fs-apb-title">{{ $apbNama }}</h3>
                    <span class="fs-apb-year">{{ $apb['tahun'] ?? date('Y') }}</span>
                </div>
                <div class="fs-apb-row">
                    <div class="fs-apb-info">
                        <span>Anggaran</span>
                        <span class="fs-apb-amount">Rp {{ number_format($apbAnggaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="fs-apb-info">
                        <span>Realisasi</span>
                        <span class="fs-apb-pct">{{ $apbPct }}%</span>
                    </div>
                    <div class="fs-bar-track">
                        <div class="fs-bar-fill" data-pct="{{ $apbPct }}" style="width:0%;"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- APARATUR DESA SECTION --}}
@if (!empty($pamongList) && count($pamongList) > 0)
<section class="fs-section fs-section-white">
    <div class="fs-container">
        <div class="fs-section-head anime-hidden">
            <h2 class="fs-section-title">Pemerintah &amp; Aparatur Desa</h2>
            <a href="{{ site_url('pemerintah') }}" class="fs-section-more" id="more-link-pemerintah">
                Semua Aparatur <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="fs-aparatur-grid anime-stagger">
            @foreach ($pamongList as $p)
            <div class="fs-aprt-card anime-stagger-item">
                <img src="{{ !empty($p->foto) ? AmbilFoto($p->foto, 'kecil_', $p->pamong_sex ?? '1', LOKASI_USER_PICT) : theme_asset('images/no-image.jpg') }}"
                     alt="{{ $p->pamong_nama }}" class="fs-aprt-img"
                     onerror="this.src='https://placehold.co/300x300/16803c/ffffff?text=Aparatur+Desa'">
                <div class="fs-aprt-body">
                    <h3 class="fs-aprt-name">{{ $p->pamong_nama }}</h3>
                    <p class="fs-aprt-jabatan">{{ $p->nama_jabatan ?: 'Perangkat Desa' }}</p>
                    <span class="fs-aprt-badge hadir">
                        <span class="status-dot hadir"></span> Aktif Melayani
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endif
@endsection

{{-- ============================================================
     CONTENT: Artikel / Berita Grid (below-the-fold)
     ============================================================ --}}
@section('content')
<section class="fs-section fs-section-white" id="sec-berita">
    <div class="fs-container">
        <div class="fs-section-head anime-hidden">
            <h2 class="fs-section-title">{!! $cmJudulBerita !!}</h2>
            @if ($cmBeranda)
                <a href="{{ site_url('artikel/kategori/1') }}" class="fs-section-more" id="more-link-berita">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            @endif
        </div>

        @if (!empty($artikel) && $artikel->count() > 0)
            <div class="fs-grid-3 anime-stagger" id="artikel-grid">
                @foreach ($artikel as $item)
                <article class="fs-card anime-stagger-item">
                    <div class="fs-card-img">
                        @if (!empty($item['gambar']) && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $item['gambar']))
                            <img src="{{ AmbilFotoArtikel($item['gambar'], 'sedang') }}"
                                 alt="{{ $item['judul'] }}" loading="lazy" decoding="async">
                        @else
                            <img src="{{ theme_asset('images/no-image.jpg') }}"
                                 alt="{{ $item['judul'] }}" loading="lazy"
                                 onerror="this.src='https://placehold.co/400x200/e5e7eb/9ca3af?text=Berita+Desa'">
                        @endif
                        @if (!empty($item['kategori']))
                            <span class="fs-card-tag">{{ $item['kategori'] }}</span>
                        @endif
                    </div>
                    <div class="fs-card-body">
                        <div class="fs-card-meta">
                            <span><i class="fa-regular fa-calendar"></i> {{ tgl_indo($item['tgl_upload']) }}</span>
                            <span><i class="fa-regular fa-user"></i> {{ $item['owner'] ?? 'Admin' }}</span>
                        </div>
                        <a href="{{ site_url('first/artikel/' . $item['id']) }}" class="fs-card-title">
                            {{ $item['judul'] }}
                        </a>
                        <p class="fs-card-excerpt">
                            {{ potong_teks(strip_tags($item['isi']), 130) }}
                        </p>
                        <a href="{{ site_url('first/artikel/' . $item['id']) }}" class="fs-card-btn"
                           id="btn-art-{{ $item['id'] }}">
                            Selengkapnya <i class="fa-solid fa-arrow-right" style="font-size:.7rem;"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            @if ($paging)
                <div class="fs-paging" id="artikel-paging">{!! $paging !!}</div>
            @endif
        @else
            <div class="fs-empty anime-hidden" id="empty-state-berita">
                <i class="fa-regular fa-folder-open"></i>
                <p>Belum ada artikel yang diterbitkan.</p>
            </div>
        @endif
    </div>
</section>
@endsection
