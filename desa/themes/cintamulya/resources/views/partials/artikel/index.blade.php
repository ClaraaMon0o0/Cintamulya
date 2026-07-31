{{--
|==============================================================================
| HALAMAN DEPAN — Website Resmi Desa Cintamulya
| Kecamatan Candipuro, Kabupaten Lampung Selatan, Provinsi Lampung
|==============================================================================
| Lokasi file (arsitektur Blade OpenSID):
|   storage/app/themes/<tema>/resources/views/partials/artikel/index.blade.php
|
| View ini dipakai oleh TIGA rute sekaligus:
|   1. fweb/Utama::index()      -> beranda
|   2. fweb/Utama::index()      -> hasil pencarian (?cari=...)
|   3. fweb/Artikel::kategori() -> daftar artikel per kategori
| Karena itu section khas beranda (hero, potensi, statistik) dibungkus flag
| $cmBeranda supaya tidak ikut tampil di halaman kategori / hasil pencarian /
| halaman kedua dan seterusnya.
|
| ---- Strategi performa yang diterapkan ------------------------------------
| 1. Above-the-fold didahulukan: hero + CTA + potensi + statistik dirender
|    melalui slot @section('above_the_fold') pada layouts/beranda, sehingga
|    berada di awal DOM. Sidebar (peta, grafik keuangan, galeri) di akhir.
| 2. Critical CSS di-inline ke <head> lewat partials/cintamulya/styles.
|    Include-nya sengaja ditaruh di level teratas file ini agar @push('styles')
|    terdaftar sebelum <head> dirender oleh template induk.
| 3. Gambar hero: fetchpriority="high" + preload (elemen LCP, TIDAK di-lazy).
|    Seluruh gambar di bawah lipatan: loading="lazy" + decoding="async".
| 4. Slider bawaan (Owl Carousel, butuh JS) ditempatkan di bawah lipatan supaya
|    tidak memblokir tampilan pertama.
| 5. Nol library animasi. Ikon memakai inline SVG, bukan webfont dari CDN,
|    supaya tetap tampil saat koneksi desa lambat.
|
| ---- Variabel yang tersedia -----------------------------------------------
| Dari Web_Controller (View::share): $desa, $latar_website, $slider_gambar,
|   $widgetAktif, $stat_widget, $teks_berjalan, $w_gal, dst.
| Dari Utama::index():        $artikel, $headline, $links, $cari
| Dari Artikel::kategori():   $artikel, $links, $judul_kategori
--}}

@extends('theme::layouts.beranda')

@php
    // --- Deteksi konteks halaman -------------------------------------------
    $cmCari = trim((string) ($cari ?? ''));
    $cmBeranda = $cmCari === '' && empty($judul_kategori) && ! request()->filled('page') && request()->segment(2) !== 'kategori';

    // --- Identitas desa (dinamis, dengan fallback) --------------------------
    // Pakai ?: bukan ?? — pada instalasi baru kolom identitas berisi STRING
    // KOSONG, bukan null, sehingga ?? tidak akan pernah memicu fallback.
    $cmIdentitas = static fn ($nilai, $bawaan) => ucwords(trim((string) $nilai) ?: $bawaan);

    $cm_nama_desa = $cmIdentitas($desa['nama_desa'] ?? null, 'Cintamulya');
    $cm_kecamatan = $cmIdentitas($desa['nama_kecamatan'] ?? null, 'Candipuro');
    $cm_kabupaten = $cmIdentitas($desa['nama_kabupaten'] ?? null, 'Lampung Selatan');
    $cm_hero_bg = $latar_website ?? null;

    // --- Judul aliran artikel ----------------------------------------------
    $cmJudulAliran = 'Berita &amp; Informasi Desa';
    if (! empty($judul_kategori)) {
        $cmJudulAliran = e(is_array($judul_kategori) ? $judul_kategori['kategori'] ?? 'Artikel' : $judul_kategori);
    } elseif ($cmCari !== '') {
        $cmJudulAliran = 'Hasil pencarian: ' . e(substr($cmCari, 0, 50));
    }

    $cmAdaSlider = count($slider_gambar['gambar'] ?? []) > 0;
@endphp

{{-- Critical CSS + preload gambar hero. WAJIB di level teratas (di luar @section). --}}
@include('theme::partials.cintamulya.styles')

{{-- Animasi Anime.js. Hanya dimuat di beranda, dan hanya bila ada koneksi.
     Halaman tetap utuh bila skripnya gagal dimuat — lihat catatan di dalamnya.
     Untuk mematikan animasi sepenuhnya: cukup komentari satu baris ini. --}}
@if ($cmBeranda)
    @include('theme::partials.cintamulya.animasi')
@endif

{{--
|--------------------------------------------------------------------------
| ABOVE-THE-FOLD (full width) — hanya di beranda
|--------------------------------------------------------------------------
--}}
@section('above_the_fold')
    @if ($cmBeranda)
        @include('theme::partials.cintamulya.hero')
        @include('theme::partials.cintamulya.aksi_cepat')
        @include('theme::partials.cintamulya.potensi')
        @include('theme::partials.cintamulya.statistik_penduduk')
    @endif
@endsection

{{--
|--------------------------------------------------------------------------
| KONTEN UTAMA — aliran berita desa (below-the-fold)
|--------------------------------------------------------------------------
--}}
@section('content')
    {{-- Slider bawaan OpenSID: hanya di beranda --}}
    @if ($cmBeranda && $cmAdaSlider)
        @include('theme::partials.slider')
    @endif

    <div class="cm-stream__head">
        <h2 class="cm-stream__title">{!! $cmJudulAliran !!}</h2>
        <a href="{{ site_url('arsip') }}" class="cm-link">Indeks berita</a>
    </div>

    @if ($cmBeranda && !empty($headline))
        @include('theme::partials.headline')
    @endif

    @if (($artikel ?? collect())->count() > 0)
        @foreach ($artikel as $post)
            @include('theme::partials.artikel.list', ['post' => $post])
        @endforeach

        <div class="pagination space-y-1 flex-wrap w-full mt-5">
            @include('theme::commons.paging')
        </div>
    @else
        @include('theme::partials.artikel.empty', ['title' => html_entity_decode(strip_tags($cmJudulAliran))])
    @endif
@endsection
