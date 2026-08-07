<footer class="fs-footer">
    <div class="fs-container">
        <div class="fs-footer-grid">
            {{-- Brand --}}
            <div>
                <img src="{{ gambar_desa($desa['logo'] ?? null) }}" alt="Logo Desa"
                     class="fs-footer-brand" style="height:52px;margin-bottom:.75rem;"
                     onerror="this.style.display='none'">
                <p class="fs-footer-brand-name">Pemerintah Desa {{ $desa['nama_desa'] ?? 'Cinta Mulya' }}</p>
                <p class="fs-footer-text">
                    {{ ucfirst(setting('sebutan_kecamatan_singkat') ?? 'Kec.') }} {{ ucwords($desa['nama_kecamatan'] ?? 'Candipuro') }},
                    {{ ucfirst(setting('sebutan_kabupaten_singkat') ?? 'Kab.') }} {{ ucwords($desa['nama_kabupaten'] ?? 'Lampung Selatan') }},
                    Provinsi {{ ucwords($desa['nama_propinsi'] ?? 'Lampung') }}
                </p>
                @if (!empty($desa['email_desa']))
                <p class="fs-footer-text" style="margin-top:.5rem;">
                    <i class="fa-solid fa-envelope" style="color:var(--c-secondary);margin-right:.35rem;"></i>
                    {{ $desa['email_desa'] }}
                </p>
                @endif
                @if (!empty($desa['telepon']))
                <p class="fs-footer-text">
                    <i class="fa-solid fa-phone" style="color:var(--c-secondary);margin-right:.35rem;"></i>
                    {{ $desa['telepon'] }}
                </p>
                @endif
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="fs-footer-title">Tautan Cepat</h4>
                <ul class="fs-footer-links">
                    <li><a href="{{ site_url() }}"><i class="fa-solid fa-angle-right"></i> Beranda</a></li>
                    <li><a href="{{ site_url('first/artikel/sejarah') }}"><i class="fa-solid fa-angle-right"></i> Sejarah Desa</a></li>
                    <li><a href="{{ site_url('first/artikel/visi-misi') }}"><i class="fa-solid fa-angle-right"></i> Visi &amp; Misi</a></li>
                    <li><a href="{{ site_url('data-wilayah') }}"><i class="fa-solid fa-angle-right"></i> Peta Wilayah</a></li>
                    <li><a href="{{ site_url('artikel/kategori/1') }}"><i class="fa-solid fa-angle-right"></i> Berita Desa</a></li>
                    <li><a href="{{ site_url('status-idm') }}"><i class="fa-solid fa-angle-right"></i> Status IDM</a></li>
                    <li><a href="{{ site_url('pemerintah') }}"><i class="fa-solid fa-angle-right"></i> Aparatur Desa</a></li>
                    <li><a href="{{ site_url('galeri') }}"><i class="fa-solid fa-angle-right"></i> Galeri</a></li>
                </ul>
            </div>

            {{-- Sosmed & Admin --}}
            <div>
                <h4 class="fs-footer-title">Ikuti Kami</h4>
                <div class="fs-socmed" style="margin-bottom:1rem;">
                    @if (setting('sosmed_facebook'))
                        <a href="{{ setting('sosmed_facebook') }}" class="fs-socmed-btn" target="_blank" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @else
                        <a href="#" class="fs-socmed-btn" aria-label="Facebook">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    @endif
                    @if (setting('sosmed_instagram'))
                        <a href="{{ setting('sosmed_instagram') }}" class="fs-socmed-btn" target="_blank" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @else
                        <a href="#" class="fs-socmed-btn" aria-label="Instagram">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    @endif
                    <a href="#" class="fs-socmed-btn" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                </div>
                <h4 class="fs-footer-title" style="margin-top:1rem;">Layanan &amp; Sistem</h4>
                <ul class="fs-footer-links">
                    <li><a href="{{ site_url('layanan-mandiri') }}"><i class="fa-solid fa-angle-right"></i> Layanan Mandiri</a></li>
                    <li><a href="{{ site_url('pengaduan') }}"><i class="fa-solid fa-angle-right"></i> Pengaduan Online</a></li>
                    <li><a href="{{ site_url('siteman') }}"><i class="fa-solid fa-user-shield"></i> Login Admin OpenSID</a></li>
                </ul>
            </div>
        </div>

        <div class="fs-footer-bottom">
            <p>&copy; {{ date('Y') }} Desa {{ $desa['nama_desa'] ?? 'Cinta Mulya' }}.
            Ditenagai oleh <strong>OpenSID</strong> &amp; Tema Futuristic Simplism.</p>
        </div>
    </div>
</footer>
