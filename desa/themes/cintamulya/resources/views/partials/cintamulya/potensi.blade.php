{{--
|--------------------------------------------------------------------------
| Potensi & Keunikan Desa Cintamulya — 3 kolom
|--------------------------------------------------------------------------
| 1. Pionir Smart Village
| 2. Sektor Pertanian & Gotong Royong
| 3. Transparansi Pemerintahan
|
| Struktur: <ul> berisi <li> dengan <article> — semantik, mudah dibaca screen
| reader, dan otomatis menumpuk (stack) di layar ponsel karena grid 1 kolom.
| Naskah tiap kartu sengaja ditulis inline agar tim desa mudah menyuntingnya
| tanpa perlu mengubah struktur/CSS.
--}}

{{-- Pembungkus memberi latar krem hangat, supaya section ini terbaca sebagai
     satu pita tersendiri di antara strip aksi cepat dan blok kependudukan. --}}
<div class="cm-potensi-wrap">
<section class="cm-section" id="cm-potensi" aria-labelledby="cm-potensi-title">
    <div class="cm-section__head">
        <h2 class="cm-section__title" id="cm-potensi-title">Potensi &amp; Keunikan {{ $cm_nama_desa }}</h2>
        <p class="cm-section__desc">Tiga hal yang menjadi wajah dan kekuatan desa kami.</p>
    </div>

    <ul class="cm-grid cm-grid--3">
        {{-- Kolom 1 — Pionir Smart Village --}}
        <li>
            <article class="cm-card">
                <span class="cm-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <rect x="4" y="4" width="16" height="16" rx="2" />
                        <path d="M9 9h6v6H9zM9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2" />
                    </svg>
                </span>
                <h3 class="cm-card__title">Pionir Smart Village</h3>
                <p class="cm-card__text">
                    {{ $cm_nama_desa }} menjadi salah satu desa perintis tata kelola digital di
                    {{ $cm_kabupaten }}. Data penduduk, surat-menyurat,
                    dan pelaporan desa dikelola melalui satu sistem informasi desa yang bisa
                    diakses warga dari rumah.
                </p>
                <ul class="cm-card__list">
                    <li>Pengajuan surat daring lewat Layanan Mandiri</li>
                    <li>Basis data kependudukan yang selalu diperbarui</li>
                    <li>Informasi desa satu pintu melalui website resmi</li>
                </ul>
                <div class="cm-card__foot">
                    @if (setting('layanan_mandiri') == 1)
                        <a href="{{ site_url('layanan-mandiri') }}" class="cm-link">
                            Coba Layanan Mandiri
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true" focusable="false">
                                <path d="M5 12h14M13 6l6 6-6 6" />
                            </svg>
                        </a>
                    @endif
                </div>
            </article>
        </li>

        {{-- Kolom 2 — Sektor Pertanian & Gotong Royong --}}
        <li>
            <article class="cm-card cm-card--accent">
                <span class="cm-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M12 22V8" />
                        <path d="M12 12c0-3.3 2.7-6 6-6 0 3.3-2.7 6-6 6z" />
                        <path d="M12 12c0-3.3-2.7-6-6-6 0 3.3 2.7 6 6 6z" />
                        <path d="M4 22h16" />
                    </svg>
                </span>
                <h3 class="cm-card__title">Pertanian &amp; Gotong Royong</h3>
                <p class="cm-card__text">
                    Denyut ekonomi desa bertumpu pada lahan pertanian dan perkebunan warga.
                    Pengelolaannya berjalan bersama-sama: dari kelompok tani, irigasi, hingga
                    perbaikan jalan usaha tani yang dikerjakan secara gotong royong antar dusun.
                </p>
                <ul class="cm-card__list">
                    <li>Kelompok tani dan lembaga desa yang aktif</li>
                    <li>Kerja bakti rutin memelihara sarana bersama</li>
                    <li>Produk pertanian sebagai penopang utama warga</li>
                </ul>
                <div class="cm-card__foot">
                    <a href="{{ site_url('data-wilayah') }}" class="cm-link">
                        Lihat wilayah &amp; dusun
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true" focusable="false">
                            <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                </div>
            </article>
        </li>

        {{-- Kolom 3 — Transparansi Pemerintahan --}}
        <li>
            <article class="cm-card cm-card--info">
                <span class="cm-card__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false">
                        <path d="M3 21h18M5 21V9l7-5 7 5v12" />
                        <path d="M9 21v-6h6v6" />
                    </svg>
                </span>
                <h3 class="cm-card__title">Transparansi Pemerintahan</h3>
                <p class="cm-card__text">
                    Warga berhak tahu ke mana anggaran desa mengalir. Rincian APBDes,
                    daftar kegiatan pembangunan, serta produk hukum desa dipublikasikan
                    terbuka di website ini &mdash; lengkap dengan kanal pengaduan bila ada
                    yang perlu dipertanyakan.
                </p>
                <ul class="cm-card__list">
                    <li>Ringkasan APBDes pada widget keuangan</li>
                    <li>Daftar kegiatan pembangunan beserta capaiannya</li>
                    <li>Pengaduan warga langsung ke pemerintah desa</li>
                </ul>
                <div class="cm-card__foot">
                    <a href="{{ site_url('pembangunan') }}" class="cm-link">
                        Buka data pembangunan
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true" focusable="false">
                            <path d="M5 12h14M13 6l6 6-6 6" />
                        </svg>
                    </a>
                </div>
            </article>
        </li>
    </ul>
</section>
</div>
