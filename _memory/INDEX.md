# Central Map: OpenSID CintaMulya Workspace

Konteks: Peta Utama repositori OpenSID Desa Cinta Mulya. Dokumen ini menghubungkan seluruh struktur repositori dan membedakan kode dasar (template) dengan hasil kerja spesifik desa (kerjaan).

## Architecture & Code Base Overview

```mermaid
graph TD
    A[OpenSID Repo Root] --> B[Template / Core OpenSID]
    A --> C[Kerjaan / Custom Desa CintaMulya]
    A --> D[Dokumentasi & Memory System]

    subgraph Template Core
        B --> B1[app/ - Laravel Hybrid Controllers & Services]
        B --> B2[donjo-app/ - Legacy CodeIgniter 3 Logic]
        B --> B3[assets/ & vendor/ - Shared Libraries & Dependencies]
        B --> B4[resources/ - Core Blade Views]
    end

    subgraph Custom Kerjaan
        C --> C1[desa/themes/cintamulya/ - Custom Theme CintaMulya]
        C --> C2[Modules/ - Custom Modules]
        C --> C3[ToDoBooting.txt & ToDoPribadi.txt - Setup Notes]
    end

    subgraph Memory & Doctrines
        D --> D1[_memory/ - Central Project Knowledge Base]
        D --> D2[_doctrine/ - System Standards & Guardrails]
    end
```

## Separasi Kode (Template vs. Kerjaan)

| Kategori | Path Files & Folder | Deskripsi & Tujuan | Risk Level Saat Update |
| :--- | :--- | :--- | :--- |
| **Template** | `donjo-app/`, `app/`, `vendor/`, `bootstrap/`, `config/` | Core framework OpenSID (CodeIgniter 3 + Laravel 10 Hybrid). Diperbarui secara berkala dari upstream OpenSID. | High (Jangan modifikasi langsung jika bisa di-override) |
| **Kerjaan** | `desa/themes/cintamulya/` | Tema kustom khusus Desa Cinta Mulya. Aman dari overwrite pembaruan rilis OpenSID. | Low (Area kerja utama frontend desa) |
| **Kerjaan** | `Modules/` (`Anjungan`, `Analisis`, `BukuTamu`, `Kehadiran`, `Lapak`, `Pelanggan`) | Modul-modul kustom aktif untuk fitur desa. | Medium (Tergantung integrasi ke core OpenSID) |
| **Memory** | `_memory/` (`INDEX.md`, `CHANGELOG.md`, `DIARY.md`) | Catatan status project, log perubahan, dan keputusan arsitektur. | Safe (Dipertahankan di Git) |
| **Doctrine** | `_doctrine/` (`OPENSID_ARCHITECTURE_DOCTRINE.md`) | Panduan arsitektur dan aturan teknis workspace. | Safe (Dipertahankan di Git) |

## Related Memory Files

- Untuk riwayat perubahan sistem dan repositori, lihat [[CHANGELOG]].
- Untuk catatan keputusan arsitektur, bug findings, dan analisis tema, lihat [[DIARY]].
- Untuk standar teknis dan panduan pengembangan, lihat [[OPENSID_ARCHITECTURE_DOCTRINE]].
