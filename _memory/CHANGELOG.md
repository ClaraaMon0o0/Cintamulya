# CHANGELOG: OpenSID CintaMulya

Konteks: Catatan historis perubahan struktur repositori dan memory system. Bagian dari [[INDEX]].

## [2026-08-04] Initial Memory System Setup & Cleanup

### Added
- Membuat folder `_memory/` berisi [[INDEX]], [[CHANGELOG]], dan [[DIARY]].
- Membuat folder `_doctrine/` berisi [[OPENSID_ARCHITECTURE_DOCTRINE]] untuk standar arsitektur CodeIgniter 3 + Laravel 10 Hybrid.

### Changed
- Mengatur aturan `.gitignore` agar mengecualikan folder `.claude/` secara global di repositori.
- Memastikan folder `_memory/` dan `_doctrine/` dilacak oleh Git untuk menjaga persistensi second brain project.

### Removed
- Mengosongkan dan menghapus folder `.claude/` lokal serta dari Git index sesuai instruksi pengguna.
---

## [2026-08-07] — Perbaikan Total Tema future-simple

### Root Cause yang Diselesaikan
- style.min.css (Tailwind dari cintamulya) masih di-load dan override semua custom CSS
- @import url('_tokens.css') tidak bekerja via OpenSID theme_asset() handler  
- layout beranda.blade.php masih pakai Tailwind classes (container mx-auto, lg:px-5, dll)
- artikel/index.blade.php tidak menggunakan @extends/@section dengan benar
- logo_desa() bukan fungsi valid OpenSID, yang benar adalah gambar_desa()

### File yang Dimodifikasi
- [BARU] desa/themes/future-simple/assets/css/futuristic.css — CSS mandiri 550+ baris, tanpa @import
- [UPDATE] commons/source_css.blade.php — Hapus style.min.css, hanya load futuristic.css
- [UPDATE] commons/source_js.blade.php — Tambah Anime.js animations (IntersectionObserver, counter, bars)
- [UPDATE] commons/header.blade.php — Pakai fs-* CSS classes, fix gambar_desa()
- [UPDATE] commons/footer.blade.php — Pakai fs-* CSS classes, fix gambar_desa()
- [UPDATE] layouts/beranda.blade.php — Hapus Tailwind, pakai div plain
- [UPDATE] layouts/full-content.blade.php — Hapus Tailwind, pakai fs-container
- [UPDATE] layouts/right-sidebar.blade.php — Hapus Tailwind, pakai fs-content-wrap
- [UPDATE] partials/sidebar.blade.php — Hapus Tailwind, pakai fs-sidebar-widget
- [UPDATE] partials/artikel/index.blade.php — @extends beranda + @section benar, fs-* classes
- [UPDATE] template.blade.php — Clean, hapus duplikasi Leaflet/Anime

### Hasil Verifikasi
- futuristic.css HTTP 200 OK, loading sukses
- Navbar hijau sticky tampil dengan benar
- Hero 2-kolom dengan foto landscape dan CTA buttons
- Quick pills (Berita, Galeri, Peta, Pemerintah Desa, APBDes)
- IDM Stats 4-card grid dengan data dari 
- APBDes progress bars dari 
- Artikel 3-kolom dengan gambar, meta, dan tombol Selengkapnya
- Footer dark green dengan logo, links, sosmed
- Back-to-top button
- No console errors
---

## [2026-08-07] — Perbaikan Route Artikel Single Parameter & Integrasi Statistik Live DB

### Root Cause 404 pada URL Artikel
- Routing OpenSID Artikel@index membutuhkan 4 parameter (\, \, \, \) untuk URL lengkap, sehingga pemanggilan single parameter seperti irst/artikel/visi-misi atau irst/artikel/sejarah langsung memicu show_404().

### Perbaikan yang Diterapkan
- [UPDATE] donjo-app/controllers/fweb/Artikel.php: Menambahkan handler single parameter pada method index(). Jika $thn berupa ID numerik atau slug (isi-misi, sejarah, dll), controller mencari artikel terkait via slug/judul dan melakukan redirect ke URL artikel resmi.
- [UPDATE] desa/themes/future-simple/resources/views/partials/artikel/index.blade.php: Menghubungkan seluruh statistik beranda secara langsung ke Database MySQL OpenSID (Penduduk: 5.054, KK: 1.550, Luas Wilayah, APBDes, dan Aparatur Desa Pamong dengan foto & status).
- [UPDATE] desa/themes/future-simple/resources/views/commons/header.blade.php: Memperbarui seluruh tautan navigasi utama ke rute resmi OpenSID (data-wilayah, pemerintah, status-idm, galeri, pengaduan).

### Hasil Verifikasi
- URL irst/artikel/visi-misi berhasil membuka halaman Visi dan Misi secara utuh (200 OK, tanpa 404).
- Statistik beranda menampilkan data riil secara otomatis dari database Desa Cintamulya.
---

## [2026-08-07] — Penyelesaian Masalah Duplikasi Berita, Menu Belum Aktif, Anggaran APBDes & Tombol Login Admin

### Perbaikan yang Diterapkan
- **Penghapusan Duplikasi Section Artikel**: Memperbarui 	emplate.blade.php dengan kondisional @hasSection('layout') @yield('layout') @else @yield('content') @endif sehingga @yield('content') tidak dirender dua kali.
- **Penyelesaian 'Menu Belum Aktif'**: Mengaktifkan seluruh rute & entri menu utama di tabel database menu (pemerintah, peraturan-desa, informasi-publik, status-idm, status-sdgs, galeri, pengaduan, pembangunan, lapak, data-wilayah) sehingga seluruh halaman mengembalikan HTTP 200 OK.
- **Data Anggaran APBDes Real DB**: Mengupdate query rtikel/index.blade.php untuk memprioritaskan data anggaran riil non-nol dari tabel keuangan (Tahun 2020: Anggaran Rp 1.808.646.506 / Realisasi 94.5%).
- **Tombol Login Admin OpenSID**: Menambahkan tombol **Admin Login** (site_url('siteman')) di header (di sebelah tombol Layanan Mandiri), mobile menu, dan footer website.

### Status Audit Halaman (Seluruh Rute Active 200 OK)
- Beranda: OK (200)
- Sejarah (irst/artikel/sejarah): OK (200)
- Visi Misi (irst/artikel/visi-misi): OK (200)
- Wilayah (data-wilayah): OK (200)
- Pemerintah (pemerintah): OK (200)
- Status IDM (status-idm): OK (200)
- Status SDGs (status-sdgs): OK (200)
- Galeri (galeri): OK (200)
- Pengaduan (pengaduan): OK (200)
- Pembangunan (pembangunan): OK (200)
- Peraturan Desa (peraturan-desa): OK (200)
- Informasi Publik (informasi-publik): OK (200)
- Lapak Desa (lapak): OK (200)
- Layanan Mandiri (layanan-mandiri): OK (200)
- Login Admin (siteman): OK (200)
---

## [2026-08-07] — Perbaikan Tipografi Artikel (Line-Height & Paragraph Spacing) & Rendering Widget Peta Leaflet

### Perbaikan yang Diterapkan
- **Peta Wilayah & Lokasi Kantor (Leaflet Maps)**: Rewrote widgets/peta_wilayah_desa.blade.php dan widgets/peta_lokasi_kantor.blade.php. Menambahkan fallback tile layer OpenStreetMap (L.tileLayer) dan penanganan error bertahap sehingga peta Leaflet & polygon batas desa Cintamulya dapat merender peta secara utuh (tidak lagi berupa kotak putih kosong).
- **Tipografi Artikel (Spacious & Clean)**: Rewrote partials/artikel/detail.blade.php dan memperbarui uturistic.css dengan styling .fs-article-body. Mengatur line-height: 1.85, margin antar paragraf 1.5rem, warna teks slate #334155, alignment 	ext-align: justify, serta perbaikan tata letak breadcrumb dan metadata artikel.
---

## [2026-08-07] — Redesign Total Halaman Pengaduan Online & Integrasi Visual Preview Protocol

### Perbaikan & Fitur Baru
- **Rombak Total Halaman Pengaduan (partials/pengaduan/index.blade.php)**:
  - Mengubah tampilan lama "web 1998" menjadi portal pengaduan modern Futuristic Simplism.
  - Menambahkan Hero Banner bertema *Transparansi & Layanan Publik*.
  - Menambahkan Action Bar dengan filter status (Menunggu, Sedang Diproses, Selesai) dan pencarian instan.
  - Membuat Modal Dialog Pop-up berbasis Vanilla JS dengan *backdrop blur*, grid input form (NIK, Nama, Email, Telepon, Judul, Isi Deskripsi), custom file upload preview, captcha refresh, dan tombol kirim.
  - Memperbarui sistem pembacaan API internal (internal_api.pengaduan) untuk menampilkan status badge berwarna pada setiap tiket pengaduan.
---

## [2026-08-07] — Redesign Halaman Data Wilayah Administratif & Peta Geospasial (Identitas Unik & Tanpa Emoji Raw)

### Perbaikan & Redesign
- **Redesign Halaman Data Wilayah (partials/wilayah/index.blade.php)**:
  - Mengubah tampilan lama yang berupa tabel polos/kaku menjadi halaman geospasial modern *Futuristic Simplism*.
  - Menambahkan Hero Banner bergradasi unik **Forest Green to Amber Gold** (#064e3b -> #16803c -> #d97706) dengan tipografi murni putih berpenekanan teks yang tajam.
  - Mengintegrasikan **Peta Interaktif Geospasial Leaflet** lengkap dengan tile layer OpenStreetMap dan polygon batas wilayah desa Cintamulya.
  - Merombak tabel hierarki demografi (Dusun, RW, RT) dengan *tree structure icon*, highlight Dusun emerald #f0fdf4, serta angka statistik KK, L+P, L, dan P yang rapi.
- **Redesign Sidebar Navigasi Statistik (partials/statistik/sidenav.blade.php)**:
  - Menghapus ketergantungan pada Bootstrap 5 accordion JS yang tidak termuat.
  - Membangun menu navigasi akordion Vanilla CSS yang responsif, terstruktur, dan dihiasi ikon profesional FontAwesome 6 (a-chart-pie, a-users, a-hand-holding-heart, a-chart-bar).
- **Standardisasi Ikon (Pengurangan Emoji Raw)**:
  - Mengganti seluruh emoji teks raw pada antarmuka web dengan ikon FontAwesome 6 berbasis SVG/Font murni.
---

## [2026-08-07] — Pengelompokan Data Statistik Rentang Umur (Pengeliminasian Redundansi & Chart X/Y Alignment)

### Perbaikan & Fitur Baru
- **Smart Categorization Tabs (partials/statistik/default.blade.php)**:
  - Menghapus redundansi data tumpang-tindih (*overlapping categories*) pada statistik Rentang Umur.
  - Membawa 3 tab filter pengelompokan yang saling lepas (*mutually exclusive*):
    1. **Kelompok 5 Tahun (Standar BPS / Piramida Penduduk)**: Rentang 0-4, 5-9, 10-14 ... hingga 70+ Tahun.
    2. **Usia Kerja & Lansia (Makro)**: Hanya menampilkan 3 kategori makro (  s/d 14 Anak-Anak, 15 s/d 56 Usia Kerja/Produktif, 56 s/d 200 Lansia).
    3. **Kategori Sekolah & Hak Pilih**: Hanya menampilkan rentang usia sekolah (Batita, Balita, SD, SMP, SMA) dan Hak Pilih (17+ Tahun).
- **Highcharts Multi-Axis & Chart Type Switching**:
  - Mengintegrasikan grafik Highcharts interaktif dengan sumbu X (Kelompok Umur) dan sumbu Y (Jumlah Populasi Jiwa).
  - Mendukung pergantian jenis grafik instan (Grafik Batang & Grafik Lingkaran) serta tombol cetak/unduh.
- **Header Gradient Unik Teal to Forest Green**:
  - Menggunakan gradien linear-gradient(135deg, #0f766e 0%, #16803c 60%, #047857 100%) dengan penekanan teks putih tajam yang mudah dibaca.
---

## [2026-08-07] — Penyelesaian Submenu Statistik Keluarga & Statistik Bantuan Kosong

### Perbaikan yang Diterapkan
- **Aktivasi Entri Menu Statistik & Bantuan di Database**: Mengaktifkan seluruh record menu statistik (statistik_k/1, statistik/bantuan_penduduk, statistik/bantuan_keluarga, dll.) pada tabel database menu.
- **Pembaruan Navigasi Sidebar (partials/statistik/sidenav.blade.php)**: Memperbarui logika penyaringan sidenav.blade.php agar seluruh item submenu statistik dari helper daftar_statistik() ditampilkan tanpa terhalang filter kondisi statis.
- **Daftar Submenu Aktif Tampil Sempurna**:
  - **Statistik Keluarga**: Menampilkan submenu *Kelas Sosial*.
  - **Statistik Bantuan**: Menampilkan submenu *Penerima Bantuan Penduduk*, *Penerima Bantuan Keluarga*, *BPNT*, *BLT DANA DESA*, *PKH*, *BEDAH RUMAH*, *JAMKESMAS*, *BST KEMENSOS*, *BLT APBD*, dll.
