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
