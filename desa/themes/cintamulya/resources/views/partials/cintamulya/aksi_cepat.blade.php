{{--
|--------------------------------------------------------------------------
| Aksi Cepat — pintasan layanan publik yang paling sering dicari warga
|--------------------------------------------------------------------------
| Prinsip HCI yang diterapkan:
| - Recognition over recall: ikon + label teks, bukan ikon saja.
| - Target sentuh minimal 84px tinggi supaya nyaman ditekan di layar ponsel.
| - Hanya 4 pintasan agar cognitive load rendah (menu lengkap tetap di navbar).
|
| Catatan deploy: tautan pembangunan / pengaduan / statistik hanya dapat dibuka
| bila menu terkait diaktifkan di Admin > Pengaturan > Menu. Bila salah satu
| dimatikan, cukup hapus <li> yang bersangkutan di bawah.
--}}

<nav class="cm-quick" aria-label="Pintasan layanan desa">
    <ul class="cm-quick__list">
        @if (setting('layanan_mandiri') == 1)
            <li>
                <a href="{{ site_url('layanan-mandiri') }}" class="cm-quick__item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <path d="M14 2v6h6M9 15h6M9 11h3" />
                    </svg>
                    <span>Layanan Mandiri</span>
                </a>
            </li>
        @endif

        <li>
            <a href="{{ site_url('data-statistik/jenis-kelamin') }}" class="cm-quick__item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13A4 4 0 0 1 16 11" />
                </svg>
                <span>Data Penduduk</span>
            </a>
        </li>

        <li>
            <a href="{{ site_url('pembangunan') }}" class="cm-quick__item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M2 20h20M4 20V9l8-5 8 5v11" />
                    <path d="M10 20v-5h4v5" />
                </svg>
                <span>Pembangunan</span>
            </a>
        </li>

        <li>
            <a href="{{ site_url('pengaduan') }}" class="cm-quick__item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
                    <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
                <span>Pengaduan Warga</span>
            </a>
        </li>
    </ul>
</nav>
