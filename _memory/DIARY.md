# DIARY & FINDINGS: OpenSID CintaMulya

Konteks: Catatan keputusan arsitektur, hasil temuan, dan analisis struktur workspace. Bagian dari [[INDEX]].

## Temuan Arsitektur Workspace

1. **Struktur Tema Desa (`desa/themes/cintamulya/`)**:
   - Tema `cintamulya` diletakkan di bawah `desa/themes/` agar aman dari pembaruan rilis OpenSID upstream.
   - Menggunakan komponen Blade Laravel yang di-render di atas framework CodeIgniter 3.
   - Pengecualian pada `.gitignore` (`!desa/themes/`) memastikan kode tema ini tetap berada di dalam Git repository untuk kolaborasi tim KKN / pengembang desa.

2. **Pemisahan Template vs Kerjaan**:
   - **Template**: Seluruh core aplikasi OpenSID (`donjo-app/`, `app/`, `vendor/`, `assets/`, dll.) adalah bawaan upstream OpenSID. Pembaruan fitur core harus dilakukan dengan mengikuti rilis resmi tanpa mengubah core logic jika tidak sangat terdesak.
   - **Kerjaan**: Pengmbangan fitur spesifik Desa Cinta Mulya terpusat pada:
     - Tema: `desa/themes/cintamulya/`
     - Modul Aktif: `Modules/Anjungan/`, `Modules/Analisis/`, `Modules/BukuTamu/`, `Modules/Kehadiran/`, `Modules/Lapak/`, `Modules/Pelanggan/`.

3. **Pembersihan Artifact Agen Lain**:
   - Direktori `.claude/` yang bersifat spesifik environment lokal/tools lain telah diabaikan di `.gitignore` dan dihapus dari repositori Git lokal dan remote.

---

## Sesi Analisis Tema: 2026-08-07

### Analisis Tema "Futuristic Simplism" (Referensi: Desa Timbang Purbalingga)

**Sumber**: https://timbang-purbalingga.digidesa.id/ — dianalisis secara empiris via browser screenshot.

**Keputusan Klien**: Buat **tema baru** bernama `future-simple` di `desa/themes/future-simple/`. Tema `cintamulya` lama TIDAK ditimpa.

**Hipotesis Utama "Futuristic Simplism"**:

```
Futuristic Simplism = Clean Whitespace + Strong Primary Color + Data Transparency + Subtle Microanimations
```

**Temuan Desain Kritis**:
1. **Warna**: Primary hijau `#16803c`, dark `#0a5b28`, background page `#efefef` (bukan putih keras)
2. **Font**: Poppins (300/400/500/700) — geometric sans-serif, terasa modern tanpa futuristik berlebihan
3. **Layout**: Max-width 1140px, grid 3-kolom, card radius 8px, shadow minimal
4. **Komponen wajib**: Navbar sticky, Hero 2-kolom, Quick pills, Visi-misi tab, Leaflet map, Grid artikel, Aparatur status badge, APBDes progress bar, Footer dark
5. **Animasi**: Micro hanya, max 300ms; progress bar 600ms; TIDAK ada animasi blocking

**Komponen Unik yang Menjadi "Futuristic"**:
- Status kehadiran aparatur real-time (dot berwarna)
- APBDes progress bar (data transparency visual dengan Anime.js counter easing)
- **Anime.js (v3.2.2) Integration**: Animasi interaktif unik (staggered scroll entrance, elastic hover micro-physics, SVG morphing) menggantikan AI Chatbot
- Leaflet.js map interaktif
- Stack image carousel di hero (efek depth)

**File Doctrine Baru Dibuat**: [[FUTURISTIC_SIMPLISM_THEME_DOCTRINE]]

**Open Items (Belum Diselesaikan)**:
- Warna primary desa CintaMulya yang sesungguhnya (perlu cek logo/kop surat resmi)
- Konfirmasi ketersediaan Alpine.js di OpenSID core
- CDN library (Alpine.js, OwlCarousel2, Animate.css, FA6) perlu diverifikasi sebelum eksekusi
