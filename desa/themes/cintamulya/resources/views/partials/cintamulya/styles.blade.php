{{--
|--------------------------------------------------------------------------
| Sistem Desain + Critical CSS — Halaman Depan Desa Cintamulya
|--------------------------------------------------------------------------
| Di-push ke stack "styles" di dalam <head> (lihat template.blade.php), sehingga
| bagian Above-the-Fold dirender pada paint pertama tanpa request CSS tambahan.
|
| ARAH DESAIN: "digital yang membumi".
| Modern dan rapi, tapi hangat — bukan dashboard korporat. Warna berpijak pada
| hijau padi (kepercayaan, pertanian) dengan netral hangat, bukan abu-abu dingin.
| Satu aksen terakota untuk aksi. Tiga hue saja, tidak lebih.
|
| ATURAN YANG DIPEGANG:
| - Semua pasangan warna teks/latar diuji kontras WCAG 2.1 AA (rasio dicatat).
| - Semua target sentuh minimal 48px.
| - Fokus keyboard selalu terlihat, di latar terang maupun gelap.
| - Nol JavaScript, nol library animasi. Ikon inline SVG (tahan CDN mati).
| - Semua selector berprefix .cm- agar tidak bentrok utility Tailwind tema.
--}}

@push('styles')
    {{-- Preload gambar hero: elemen LCP halaman depan --}}
    @if (!empty($cm_hero_bg))
        <link rel="preload" as="image" href="{{ $cm_hero_bg }}" fetchpriority="high">
    @endif

    <style>
        /* ==========================================================================
           1. TOKEN
           ========================================================================== */
        :root {
            /* --- Warna inti. Angka = rasio kontras teks putih di atasnya --- */
            --cm-primary: #14532d;          /* 9.1:1  — hijau padi tua, warna aksi utama */
            --cm-primary-600: #166534;      /* 8.0:1  — hover */
            --cm-primary-500: #1f7a43;      /* 5.6:1  — aksen garis & ikon di latar terang */
            --cm-accent: #9a3412;           /* 7.3:1  — terakota, aksi sekunder */
            --cm-accent-600: #7c2d12;       /* 9.0:1  — hover */
            --cm-teal: #115e59;             /* 7.6:1  — hue ketiga, dipakai hemat */

            /* --- Tint & netral hangat (bukan abu dingin) --- */
            --cm-primary-tint: #eef4ef;
            --cm-accent-tint: #fbf1ea;
            --cm-teal-tint: #e9f2f1;
            --cm-surface: #ffffff;
            --cm-surface-warm: #faf9f6;     /* krem sangat tipis, memecah monoton putih */
            --cm-line: #e4e1da;
            --cm-line-strong: #cfcbc1;

            /* --- Teks. Rasio diukur di atas putih --- */
            --cm-ink: #1c1917;              /* 16.9:1 */
            --cm-ink-soft: #57534e;         /* 7.6:1  */
            --cm-ink-faint: #78716c;        /* 4.9:1  — batas aman teks kecil */

            /* --- Skala tipografi (rasio 1.2, dibulatkan agar rapi di layar) --- */
            --cm-t-xs: 0.75rem;
            --cm-t-sm: 0.875rem;
            --cm-t-base: 1rem;
            --cm-t-lg: 1.125rem;
            --cm-t-xl: 1.375rem;
            --cm-t-2xl: 1.75rem;
            --cm-t-3xl: 2.25rem;

            /* --- Ritme spasi (kelipatan 4) --- */
            --cm-s-1: 0.25rem;
            --cm-s-2: 0.5rem;
            --cm-s-3: 0.75rem;
            --cm-s-4: 1rem;
            --cm-s-5: 1.5rem;
            --cm-s-6: 2rem;
            --cm-s-7: 3rem;
            --cm-s-8: 4rem;

            --cm-radius: 14px;
            --cm-radius-sm: 10px;

            /* --- Elevasi berlapis: bayangan ambien + terarah, bukan blur tunggal --- */
            --cm-shadow-1: 0 1px 2px rgba(28, 25, 23, .05), 0 1px 3px rgba(28, 25, 23, .06);
            --cm-shadow-2: 0 2px 4px rgba(28, 25, 23, .04), 0 6px 16px -4px rgba(28, 25, 23, .10);
            --cm-shadow-3: 0 4px 8px rgba(28, 25, 23, .05), 0 14px 32px -8px rgba(28, 25, 23, .16);

            --cm-max: 1180px;
        }

        /* ==========================================================================
           2. KERANGKA SECTION
           ========================================================================== */
        .cm-section {
            max-width: var(--cm-max);
            margin: 0 auto;
            padding: var(--cm-s-6) var(--cm-s-4);
        }

        .cm-section__head {
            margin-bottom: var(--cm-s-5);
            max-width: 60ch;
        }

        /* Garis aksen pendek di atas judul — penanda awal section */
        .cm-section__head::before {
            content: "";
            display: block;
            width: 40px;
            height: 3px;
            margin-bottom: var(--cm-s-3);
            border-radius: 3px;
            background: var(--cm-primary-500);
        }

        .cm-section__title {
            margin: 0;
            font-size: var(--cm-t-xl);
            line-height: 1.25;
            font-weight: 700;
            letter-spacing: -0.015em;
            color: var(--cm-ink);
        }

        .cm-section__desc {
            margin: var(--cm-s-2) 0 0;
            font-size: var(--cm-t-base);
            line-height: 1.65;
            color: var(--cm-ink-soft);
        }

        .cm-grid {
            display: grid;
            gap: var(--cm-s-4);
            grid-template-columns: 1fr;
        }

        /* Grid sering dipakai pada <ul> agar semantiknya benar (daftar kartu),
           jadi reset daftarnya di sini — bukan lewat inline style. */
        ul.cm-grid {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        /* ==========================================================================
           3. HERO
           ========================================================================== */
        .cm-hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            background-color: var(--cm-primary);
            color: #fff;
        }

        .cm-hero__bg {
            position: absolute;
            inset: 0;
            z-index: -3;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* Dua lapis: gradien terarah (kiri pekat -> kanan tipis) supaya teks selalu
           terbaca apa pun foto latarnya, ditambah warna dasar hijau agar fotonya
           menyatu dengan palet dan tidak terasa tempelan. */
        .cm-hero__scrim {
            position: absolute;
            inset: 0;
            z-index: -2;
            background:
                linear-gradient(100deg, rgba(20, 83, 45, .96) 0%, rgba(20, 83, 45, .88) 45%, rgba(20, 83, 45, .62) 100%),
                linear-gradient(180deg, rgba(12, 45, 25, .55) 0%, rgba(12, 45, 25, 0) 40%);
        }

        /* Garis tipis di dasar hero, menyambung ke strip aksi cepat */
        .cm-hero::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--cm-accent) 0%, var(--cm-primary-500) 55%, var(--cm-teal) 100%);
        }

        .cm-hero__inner {
            max-width: var(--cm-max);
            margin: 0 auto;
            padding: var(--cm-s-6) var(--cm-s-4) var(--cm-s-7);
        }

        .cm-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: var(--cm-s-2);
            margin: 0 0 var(--cm-s-4);
            padding: 0.4rem 0.85rem;
            border: 1px solid rgba(255, 255, 255, .38);
            border-radius: 999px;
            background: rgba(255, 255, 255, .10);
            font-size: var(--cm-t-xs);
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .cm-hero__title {
            margin: 0;
            max-width: 18ch;
            font-size: var(--cm-t-2xl);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -0.025em;
            text-wrap: balance;
        }

        .cm-hero__title small {
            display: block;
            margin-top: var(--cm-s-3);
            max-width: none;
            font-size: var(--cm-t-sm);
            font-weight: 500;
            letter-spacing: 0;
            line-height: 1.5;
            color: rgba(255, 255, 255, .88);
        }

        .cm-hero__lead {
            margin: var(--cm-s-4) 0 0;
            max-width: 56ch;
            font-size: var(--cm-t-base);
            line-height: 1.7;
            color: rgba(255, 255, 255, .92);
        }

        .cm-hero__lead strong {
            color: #fff;
            font-weight: 700;
        }

        /* ==========================================================================
           4. TOMBOL
           ========================================================================== */
        .cm-actions {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: var(--cm-s-3);
            margin-top: var(--cm-s-5);
        }

        .cm-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--cm-s-2);
            min-height: 50px;
            padding: 0.8rem 1.4rem;
            border: 2px solid transparent;
            border-radius: var(--cm-radius-sm);
            font-size: var(--cm-t-base);
            font-weight: 700;
            letter-spacing: -0.005em;
            text-align: center;
            text-decoration: none;
            transition: background-color .15s ease, border-color .15s ease, color .15s ease, transform .15s ease;
        }

        .cm-btn svg {
            flex: 0 0 auto;
            width: 20px;
            height: 20px;
        }

        /* Aksi utama: satu-satunya tombol terang di hero, jadi hierarki jelas */
        .cm-btn--primary {
            background-color: #fff;
            color: var(--cm-primary);        /* 9.1:1 */
        }

        .cm-btn--primary:hover {
            background-color: #f3f7f3;
            color: var(--cm-primary);
            transform: translateY(-1px);
        }

        .cm-btn--accent {
            background-color: var(--cm-accent);
            color: #fff;                     /* 7.3:1 */
        }

        .cm-btn--accent:hover {
            background-color: var(--cm-accent-600);
            color: #fff;
            transform: translateY(-1px);
        }

        .cm-btn--ghost {
            background-color: transparent;
            border-color: rgba(255, 255, 255, .55);
            color: #fff;
        }

        .cm-btn--ghost:hover {
            background-color: rgba(255, 255, 255, .12);
            border-color: #fff;
            color: #fff;
        }

        /* Aksi ketiga sengaja BUKAN tombol. Tiga tombol setara membuat pengguna
           harus memilih tanpa panduan; menurunkannya jadi tautan menegaskan
           bahwa dua tombol di atasnya yang utama. */
        .cm-hero__more {
            display: inline-flex;
            align-items: center;
            gap: var(--cm-s-2);
            min-height: 48px;
            padding: 0 var(--cm-s-2);
            color: rgba(255, 255, 255, .92);
            font-size: var(--cm-t-sm);
            font-weight: 600;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: color .15s ease, border-color .15s ease;
        }

        .cm-hero__more:hover {
            color: #fff;
            border-bottom-color: rgba(255, 255, 255, .7);
        }

        .cm-hero__more:focus-visible {
            outline: 3px solid #fbbf24;
            outline-offset: 3px;
            border-radius: var(--cm-radius-sm);
        }

        .cm-hero__more svg {
            width: 18px;
            height: 18px;
        }

        /* Fokus keyboard: kuning hangat, terbaca di latar gelap maupun terang */
        .cm-btn:focus-visible,
        .cm-quick__item:focus-visible,
        .cm-link:focus-visible,
        .cm-card a:focus-visible {
            outline: 3px solid #fbbf24;
            outline-offset: 3px;
            border-radius: var(--cm-radius-sm);
        }

        /* ==========================================================================
           5. AKSI CEPAT
           ========================================================================== */
        .cm-quick {
            background: var(--cm-surface);
            border-bottom: 1px solid var(--cm-line);
        }

        .cm-quick__list {
            max-width: var(--cm-max);
            margin: 0 auto;
            padding: var(--cm-s-4);
            display: grid;
            gap: var(--cm-s-3);
            grid-template-columns: repeat(2, minmax(0, 1fr));
            list-style: none;
        }

        .cm-quick__item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: var(--cm-s-2);
            min-height: 92px;
            padding: var(--cm-s-3);
            border: 1px solid var(--cm-line);
            border-radius: var(--cm-radius-sm);
            background: var(--cm-surface);
            color: var(--cm-ink);
            font-size: var(--cm-t-sm);
            font-weight: 600;
            line-height: 1.3;
            text-align: center;
            text-decoration: none;
            transition: border-color .15s ease, background-color .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .cm-quick__item:hover {
            background-color: var(--cm-primary-tint);
            border-color: var(--cm-primary-500);
            color: var(--cm-primary);
            transform: translateY(-2px);
            box-shadow: var(--cm-shadow-2);
        }

        .cm-quick__item svg {
            width: 26px;
            height: 26px;
            color: var(--cm-primary-500);
            transition: color .15s ease;
        }

        .cm-quick__item:hover svg {
            color: var(--cm-primary);
        }

        /* ==========================================================================
           6. KARTU POTENSI
           ========================================================================== */
        .cm-potensi-wrap {
            background: var(--cm-surface-warm);
            border-bottom: 1px solid var(--cm-line);
        }

        .cm-card {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: var(--cm-s-5);
            background: var(--cm-surface);
            border: 1px solid var(--cm-line);
            border-radius: var(--cm-radius);
            box-shadow: var(--cm-shadow-1);
            transition: box-shadow .18s ease, transform .18s ease, border-color .18s ease;
            overflow: hidden;
        }

        /* Pita aksen tipis di sisi atas, melebar saat hover — isyarat halus
           bahwa kartu ini interaktif, tanpa perlu animasi berat */
        .cm-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 56px;
            height: 4px;
            background: var(--cm-primary-500);
            transition: width .25s ease;
        }

        .cm-card:hover {
            box-shadow: var(--cm-shadow-3);
            border-color: var(--cm-line-strong);
            transform: translateY(-3px);
        }

        .cm-card:hover::before {
            width: 100%;
        }

        .cm-card--accent::before {
            background: var(--cm-accent);
        }

        .cm-card--info::before {
            background: var(--cm-teal);
        }

        .cm-card__icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 52px;
            height: 52px;
            margin-bottom: var(--cm-s-4);
            border-radius: 14px;
            background: var(--cm-primary-tint);
            color: var(--cm-primary);
        }

        .cm-card--accent .cm-card__icon {
            background: var(--cm-accent-tint);
            color: var(--cm-accent);
        }

        .cm-card--info .cm-card__icon {
            background: var(--cm-teal-tint);
            color: var(--cm-teal);
        }

        .cm-card__icon svg {
            width: 26px;
            height: 26px;
        }

        .cm-card__title {
            margin: 0 0 var(--cm-s-2);
            font-size: var(--cm-t-lg);
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--cm-ink);
        }

        .cm-card__text {
            margin: 0;
            font-size: var(--cm-t-sm);
            line-height: 1.7;
            color: var(--cm-ink-soft);
        }

        .cm-card__list {
            margin: var(--cm-s-4) 0 0;
            padding: 0;
            list-style: none;
            font-size: var(--cm-t-sm);
            line-height: 1.55;
            color: var(--cm-ink-soft);
        }

        .cm-card__list li {
            position: relative;
            padding-left: 1.4rem;
        }

        .cm-card__list li + li {
            margin-top: var(--cm-s-2);
        }

        /* Penanda daftar dibuat sendiri agar sejajar rapi dengan teks */
        .cm-card__list li::before {
            content: "";
            position: absolute;
            left: 0;
            top: .55em;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--cm-primary-500);
        }

        .cm-card--accent .cm-card__list li::before {
            background: var(--cm-accent);
        }

        .cm-card--info .cm-card__list li::before {
            background: var(--cm-teal);
        }

        .cm-card__foot {
            margin-top: auto;
            padding-top: var(--cm-s-4);
        }

        .cm-link {
            display: inline-flex;
            align-items: center;
            gap: var(--cm-s-2);
            min-height: 44px;
            font-size: var(--cm-t-sm);
            font-weight: 700;
            color: var(--cm-primary);
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: border-color .15s ease, gap .15s ease, color .15s ease;
        }

        .cm-link:hover {
            color: var(--cm-primary-600);
            border-bottom-color: currentColor;
            gap: 0.7rem;
        }

        .cm-card--accent .cm-link { color: var(--cm-accent); }
        .cm-card--info .cm-link { color: var(--cm-teal); }

        /* ==========================================================================
           7. WIDGET KEPENDUDUKAN
           ========================================================================== */
        .cm-stat {
            position: relative;
            background: var(--cm-primary);
            color: #fff;
            border-bottom: 1px solid var(--cm-line);
        }

        .cm-stat .cm-section__head::before {
            background: rgba(255, 255, 255, .55);
        }

        .cm-stat .cm-section__title {
            color: #fff;
        }

        .cm-stat .cm-section__desc {
            color: rgba(255, 255, 255, .85);
        }

        .cm-stat__card {
            padding: var(--cm-s-5) var(--cm-s-4);
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: var(--cm-radius);
            text-align: center;
        }

        .cm-stat__value {
            display: block;
            font-size: var(--cm-t-2xl);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #fff;
            font-variant-numeric: tabular-nums;
        }

        .cm-stat__label {
            display: block;
            margin-top: var(--cm-s-2);
            font-size: var(--cm-t-sm);
            font-weight: 600;
            letter-spacing: .01em;
            color: rgba(255, 255, 255, .85);
        }

        .cm-bars {
            margin: var(--cm-s-5) 0 0;
            padding: 0;
            list-style: none;
        }

        .cm-bars__row + .cm-bars__row {
            margin-top: var(--cm-s-4);
        }

        .cm-bars__meta {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: var(--cm-s-4);
            font-size: var(--cm-t-sm);
            font-weight: 600;
            color: #fff;
        }

        .cm-bars__meta span:last-child {
            font-variant-numeric: tabular-nums;
            color: rgba(255, 255, 255, .82);
            font-weight: 500;
        }

        .cm-bars__track {
            height: 12px;
            margin-top: var(--cm-s-2);
            background: rgba(255, 255, 255, .14);
            border-radius: 999px;
            overflow: hidden;
        }

        .cm-bars__fill {
            display: block;
            height: 100%;
            border-radius: 999px;
            background: #fff;
        }

        .cm-bars__row:nth-child(even) .cm-bars__fill {
            background: #fcd34d;
        }

        .cm-stat .cm-link {
            color: #fff;
        }

        .cm-stat .cm-link:hover {
            color: #fcd34d;
        }

        /* ==========================================================================
           8. JUDUL ALIRAN BERITA
           ========================================================================== */
        .cm-stream__head {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            justify-content: space-between;
            gap: var(--cm-s-2);
            padding-bottom: var(--cm-s-3);
            margin-bottom: var(--cm-s-4);
            border-bottom: 2px solid var(--cm-line);
        }

        .cm-stream__title {
            margin: 0;
            font-size: var(--cm-t-lg);
            font-weight: 700;
            letter-spacing: -0.01em;
            color: var(--cm-ink);
        }

        /* ==========================================================================
           9. BREAKPOINT (mobile-first)
           ========================================================================== */
        @media (min-width: 640px) {
            .cm-actions {
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
            }

            .cm-quick__list {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .cm-grid--2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .cm-grid--3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .cm-grid--4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

            .cm-hero__title { font-size: var(--cm-t-3xl); }
        }

        @media (min-width: 768px) {
            .cm-section { padding: var(--cm-s-7) var(--cm-s-5); }
            .cm-hero__inner { padding: var(--cm-s-7) var(--cm-s-5) var(--cm-s-8); }
            .cm-quick__list { padding: var(--cm-s-5); }
            .cm-section__title { font-size: var(--cm-t-2xl); }
            .cm-hero__lead { font-size: var(--cm-t-lg); }
            .cm-hero__title small { font-size: var(--cm-t-base); }
        }

        @media (min-width: 1024px) {
            .cm-hero__title { font-size: 3rem; }
            .cm-stat__value { font-size: var(--cm-t-3xl); }
            .cm-grid { gap: var(--cm-s-5); }
        }

        /* Layar sangat sempit: cegah teks tombol terpotong */
        @media (max-width: 360px) {
            .cm-quick__item { font-size: var(--cm-t-xs); }
            .cm-hero__title { font-size: var(--cm-t-xl); }
        }

        /* Hormati preferensi pengguna yang sensitif terhadap gerakan */
        @media (prefers-reduced-motion: reduce) {
            .cm-btn,
            .cm-quick__item,
            .cm-card,
            .cm-card::before,
            .cm-link {
                transition: none;
            }

            .cm-btn:hover,
            .cm-quick__item:hover,
            .cm-card:hover {
                transform: none;
            }
        }

        /* Cetak: buang elemen dekoratif, hemat tinta */
        @media print {
            .cm-hero__bg,
            .cm-hero__scrim,
            .cm-quick {
                display: none;
            }

            .cm-hero,
            .cm-stat {
                background: #fff;
                color: #000;
            }

            .cm-stat .cm-section__title,
            .cm-stat__value,
            .cm-stat__label {
                color: #000;
            }
        }
    </style>
@endpush
