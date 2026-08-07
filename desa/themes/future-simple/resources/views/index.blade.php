@extends('theme::template')

@section('title', 'Beranda - Desa Cinta Mulya')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container hero-grid">
        <div class="hero-content anime-fade-up">
            <h1 class="hero-title">Website Resmi</h1>
            <h2 class="hero-subtitle">Desa Cinta Mulya</h2>
            <p>Kecamatan Way Sulan, Kabupaten Lampung Selatan, Provinsi Lampung</p>
            <blockquote class="hero-quote">
                "Pusat informasi dan transparansi tata kelola pemerintahan desa yang inovatif, ramah, dan melayani sepenuh hati."
            </blockquote>
        </div>
        <div class="hero-visual anime-fade-up">
            <div style="background: white; padding: 1.5rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md); text-align: center;">
                <img src="{{ theme_asset('images/hero-sample.jpg') }}" alt="Kantor Desa Cinta Mulya" style="width:100%; border-radius: var(--radius-sm);" onerror="this.src='https://via.placeholder.com/600x350?text=Desa+Cinta+Mulya'">
            </div>
        </div>
    </div>
</section>

<!-- Quick Access Pills -->
<section class="section container">
    <div class="quick-access-wrapper anime-fade-up">
        <a href="#idm" class="quick-pill active">IDM</a>
        <a href="#galeri" class="quick-pill">Galeri Desa</a>
        <a href="#peta" class="quick-pill">Peta Wilayah</a>
        <a href="#pemerintah" class="quick-pill">Pemerintahan Desa</a>
        <a href="#apbdes" class="quick-pill">Transparansi APBDes</a>
    </div>
</section>

<!-- Core Sections: Grid Artikel & APBDes -->
<section class="section container">
    <h2 class="section-title">Kabar & Artikel Desa</h2>
    
    <div class="artikel-grid anime-stagger-container">
        <article class="artikel-card anime-stagger-item">
            <img src="https://via.placeholder.com/400x200?text=Pelantikan+Perangkat" alt="Artikel 1">
            <div class="artikel-card-body">
                <div class="artikel-card-meta">07 Agustus 2026 | Admin Desa</div>
                <h3 class="artikel-card-title">Pelantikan dan Pengambilan Sumpah Perangkat Desa Cinta Mulya</h3>
                <p style="font-size: var(--text-sm); margin-bottom: 1rem; color: var(--color-text-body);">Pemerintah Desa Cinta Mulya secara resmi melantik perangkat desa baru untuk mengoptimalkan pelayanan publik...</p>
                <a href="#" class="btn-detail">Lihat Detail</a>
            </div>
        </article>

        <article class="artikel-card anime-stagger-item">
            <img src="https://via.placeholder.com/400x200?text=Musrenbangdes" alt="Artikel 2">
            <div class="artikel-card-body">
                <div class="artikel-card-meta">02 Agustus 2026 | Pembina KKN</div>
                <h3 class="artikel-card-title">Musrenbangdes Penetapan Rencana Pembangunan Tahun 2027</h3>
                <p style="font-size: var(--text-sm); margin-bottom: 1rem; color: var(--color-text-body);">Musyawarah perencanaan pembangunan desa dihadiri oleh seluruh elemen masyarakat dan tokoh desa...</p>
                <a href="#" class="btn-detail">Lihat Detail</a>
            </div>
        </article>

        <article class="artikel-card anime-stagger-item">
            <img src="https://via.placeholder.com/400x200?text=BUMDes+Maju" alt="Artikel 3">
            <div class="artikel-card-body">
                <div class="artikel-card-meta">25 Juli 2026 | BUMDes</div>
                <h3 class="artikel-card-title">Inovasi Usaha BUMDes Cinta Mulya Dalam Meningkatkan Pendapatan</h3>
                <p style="font-size: var(--text-sm); margin-bottom: 1rem; color: var(--color-text-body);">BUMDes Cinta Mulya meluncurkan program kemitraan ekonomi warga berbasis produk unggulan lokal...</p>
                <a href="#" class="btn-detail">Lihat Detail</a>
            </div>
        </article>
    </div>
</section>

<!-- APBDes Progress Bar Section -->
<section class="section container" id="apbdes">
    <h2 class="section-title">Transparansi Keuangan (APBDes)</h2>
    <div class="apbdes-card anime-fade-up">
        <h4>Pelaksanaan Pendapatan Desa</h4>
        <div class="apbdes-bar-track">
            <div class="apbdes-bar-fill" style="width: 75%;"></div>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: var(--text-xs); margin-top: 0.35rem; color: var(--color-text-muted);">
            <span>Realisasi: Rp 750.000.000</span>
            <span>Target: Rp 1.000.000.000 (75%)</span>
        </div>
    </div>
</section>
@endsection
