{{--
|--------------------------------------------------------------------------
| Hero Section — Identitas Cintamulya sebagai Pionir Smart Village
|--------------------------------------------------------------------------
| ABOVE-THE-FOLD. Blok ini adalah hal pertama yang dilihat warga tanpa scroll,
| jadi:
| - Gambar latar TIDAK memakai loading="lazy" (justru fetchpriority="high"),
|   karena ia adalah elemen LCP. Lazy-load di sini akan memperlambat.
| - width/height diisi eksplisit untuk mencegah layout shift (CLS).
| - Hanya satu <h1> per halaman, ditempatkan di sini untuk kejelasan SEO.
|
| Variabel yang dipakai (disediakan Web_Controller / Utama::index()):
|   $desa            : identitas desa
|   $cm_hero_bg      : URL gambar latar (dari $latar_website)
|   $cm_nama_desa    : nama desa siap tampil
--}}

<section class="cm-hero" aria-labelledby="cm-hero-title">
    @if (!empty($cm_hero_bg))
        <img
            class="cm-hero__bg"
            src="{{ $cm_hero_bg }}"
            alt=""
            role="presentation"
            width="1600"
            height="700"
            fetchpriority="high"
            decoding="async"
        >
    @endif
    <div class="cm-hero__scrim" aria-hidden="true"></div>

    <div class="cm-hero__inner">
        <p class="cm-hero__eyebrow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14" aria-hidden="true" focusable="false">
                <path d="M12 2 4 6v6c0 5 3.4 9.1 8 10 4.6-.9 8-5 8-10V6l-8-4z" />
                <path d="M9 12l2 2 4-4" />
            </svg>
            Pionir Smart Village &middot; Lampung Selatan
        </p>

        <h1 class="cm-hero__title" id="cm-hero-title">
            {{ ucfirst(setting('sebutan_desa')) }} {{ $cm_nama_desa }}
            <small>
                {{ ucfirst(setting('sebutan_kecamatan_singkat')) }} {{ $cm_kecamatan }},
                {{ ucfirst(setting('sebutan_kabupaten_singkat')) }} {{ $cm_kabupaten }}
            </small>
        </h1>

        {{-- Narasi hero: silakan sunting sesuai perkembangan program desa. --}}
        <p class="cm-hero__lead">
            {{ $cm_nama_desa }} melangkah sebagai <strong>pionir Smart Village</strong> di
            {{ $cm_kabupaten }}: pelayanan administrasi
            dapat diurus secara daring, data penduduk terbuka untuk diperiksa warga, dan
            penggunaan anggaran dipublikasikan apa adanya. Teknologi kami pakai untuk
            memperkuat &mdash; bukan menggantikan &mdash; tradisi gotong royong yang sudah hidup di setiap dusun.
        </p>

        {{-- CTA utama: dua aksi yang paling sering dibutuhkan warga --}}
        <div class="cm-actions">
            @if (setting('layanan_mandiri') == 1)
                <a href="{{ site_url('layanan-mandiri') }}" class="cm-btn cm-btn--primary" aria-label="Buka Layanan Mandiri untuk mengurus surat secara daring">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path d="M14 2v6h6M9 15h6M9 11h3" />
                    </svg>
                    Layanan Mandiri
                </a>
            @endif

            <a href="{{ site_url('data-statistik/jenis-kelamin') }}" class="cm-btn cm-btn--accent" aria-label="Lihat statistik dan data kependudukan desa">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M3 3v18h18" />
                    <path d="M7 15v-4M12 17V8M17 17v-7" />
                </svg>
                Statistik Penduduk
            </a>

            {{-- Aksi ketiga sengaja berupa tautan, bukan tombol — lihat catatan
                 hierarki pada .cm-hero__more di partials/cintamulya/styles --}}
            <a href="#cm-potensi" class="cm-hero__more">
                Kenali desa kami
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M12 5v14M19 12l-7 7-7-7" />
                </svg>
            </a>
        </div>
    </div>
</section>
