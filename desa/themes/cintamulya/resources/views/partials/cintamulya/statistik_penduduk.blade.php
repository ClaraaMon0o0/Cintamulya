{{--
|--------------------------------------------------------------------------
| Area Widget Data Kependudukan Dinamis (native OpenSID)
|--------------------------------------------------------------------------
| Sumber data: $stat_widget — di-share oleh Web_Controller melalui
| (new LaporanPenduduk())->listData(4) yaitu laporan "Jenis Kelamin".
|
| Bentuk data:
|   $stat_widget[0..n] => ['nama' => 'LAKI-LAKI', 'jumlah' => 123, 'laki' => .., 'perempuan' => ..]
|   $stat_widget['total'] => ['nama' => 'TOTAL', 'jumlah' => .., 'laki' => .., 'perempuan' => ..]
| Baris 'JUMLAH' dan 'BELUM MENGISI' ikut disertakan OpenSID, jadi disaring di bawah.
|
| Alasan tidak memakai chart JS di sini: bagian ini masih dekat dengan
| above-the-fold. Grafik batang dibuat murni CSS (0 KB JavaScript) supaya
| halaman tetap ringan di jaringan seluler. Widget Highcharts bawaan tetap
| tersedia di sidebar (widgets/statistik.blade.php) bila dibutuhkan grafik penuh.
--}}

@php
    $cmStatRows = collect($stat_widget ?? [])
        ->filter(static fn ($row, $key) => is_int($key)
            && is_array($row)
            && ! in_array(strtoupper((string) ($row['nama'] ?? '')), ['JUMLAH', 'BELUM MENGISI', 'TOTAL'], true)
            && (int) ($row['jumlah'] ?? 0) > 0);

    $cmTotal = (array) ($stat_widget['total'] ?? []);
    $cmTotalJiwa = (int) ($cmTotal['jumlah'] ?? $cmStatRows->sum(static fn ($row) => (int) $row['jumlah']));
    $cmLaki = (int) ($cmTotal['laki'] ?? 0);
    $cmPerempuan = (int) ($cmTotal['perempuan'] ?? 0);
    $cmFmt = static fn ($angka) => number_format((int) $angka, 0, ',', '.');
@endphp

@if ($cmTotalJiwa > 0)
    <section class="cm-stat" aria-labelledby="cm-stat-title">
        <div class="cm-section">
            <div class="cm-section__head">
                <h2 class="cm-section__title" id="cm-stat-title">Data Kependudukan {{ $cm_nama_desa }}</h2>
                <p class="cm-section__desc">
                    Angka berikut diambil langsung dari basis data {{ ucfirst(setting('sebutan_desa')) }} dan
                    ikut berubah setiap kali perangkat desa memperbarui data warga.
                </p>
            </div>

            {{-- Kartu ringkasan --}}
            <div class="cm-grid cm-grid--3">
                <div class="cm-stat__card">
                    <span class="cm-stat__value">{{ $cmFmt($cmTotalJiwa) }}</span>
                    <span class="cm-stat__label">Total Penduduk (jiwa)</span>
                </div>
                <div class="cm-stat__card">
                    <span class="cm-stat__value">{{ $cmFmt($cmLaki) }}</span>
                    <span class="cm-stat__label">Laki-laki</span>
                </div>
                <div class="cm-stat__card">
                    <span class="cm-stat__value">{{ $cmFmt($cmPerempuan) }}</span>
                    <span class="cm-stat__label">Perempuan</span>
                </div>
            </div>

            {{-- Rincian per kategori: grafik batang murni CSS, tanpa JavaScript --}}
            @if ($cmStatRows->isNotEmpty())
                <ul class="cm-bars">
                    @foreach ($cmStatRows as $row)
                        @php
                            $jumlah = (int) $row['jumlah'];
                            $persen = $cmTotalJiwa > 0 ? round($jumlah / $cmTotalJiwa * 100, 1) : 0;
                        @endphp
                        <li class="cm-bars__row">
                            <div class="cm-bars__meta">
                                <span>{{ ucwords(strtolower((string) $row['nama'])) }}</span>
                                <span>{{ $cmFmt($jumlah) }} jiwa &middot; {{ $persen }}%</span>
                            </div>
                            <div
                                class="cm-bars__track"
                                role="img"
                                aria-label="{{ ucwords(strtolower((string) $row['nama'])) }}: {{ $cmFmt($jumlah) }} jiwa, {{ $persen }} persen dari total penduduk"
                            >
                                <span class="cm-bars__fill" style="width: {{ $persen }}%"></span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="cm-card__foot">
                <a href="{{ site_url('data-statistik/jenis-kelamin') }}" class="cm-link">
                    Lihat statistik lengkap
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="16" height="16" aria-hidden="true" focusable="false">
                        <path d="M5 12h14M13 6l6 6-6 6" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endif
