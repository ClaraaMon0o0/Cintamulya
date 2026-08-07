@extends('theme::template')
@include('theme::commons.asset_peta')

@section('layout')
<div class="fs-content-wrap" style="display:grid;grid-template-columns:280px 1fr;gap:2rem;margin:2rem 0;align-items:start;">
    {{-- Sidebar Navigation --}}
    <aside class="fs-sidebar">
        @include('theme::partials.statistik.sidenav')
    </aside>

    {{-- Main Content Area --}}
    <main class="fs-main-body">
        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
            <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
                <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
                <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
                <a href="{{ site_url('data-wilayah') }}" style="color:var(--c-primary);font-weight:500;">Data Wilayah</a>
                <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
                <span style="color:var(--c-text-muted);">Administratif Dusun</span>
            </div>
        </nav>

        {{-- Hero Banner (Forest Green to Amber Gold Gradient Unique Identity) --}}
        <div style="background:linear-gradient(135deg, #064e3b 0%, #16803c 50%, #d97706 100%);color:#ffffff;padding:2rem 2.25rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
            <div style="position:absolute;right:-15px;bottom:-25px;font-size:10rem;color:rgba(255,255,255,0.06);pointer-events:none;">
                <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div style="position:relative;z-index:2;">
                <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);color:#ffffff;font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                    <i class="fa-solid fa-layer-group" style="color:#fef08a;"></i> Demografi &amp; Geospasial
                </span>
                <h1 style="font-size:1.85rem;font-weight:800;margin-bottom:.5rem;line-height:1.25;color:#ffffff;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                    Peta &amp; Data Wilayah Administratif
                </h1>
                <p style="font-size:.92rem;color:#fef3c7;line-height:1.6;margin:0;font-weight:400;max-width:650px;">
                    Struktur kewilayahan Dusun, RW, dan RT di {{ ucwords(setting('sebutan_desa')) }} {{ e($desa['nama_desa']) }}. Dilengkapi dengan peta interaktif geospasial dan rincian populasi penduduk.
                </p>
            </div>
        </div>

        {{-- Interactive Leaflet Map Card --}}
        <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.25rem;margin-bottom:2rem;box-shadow:var(--sh-sm);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:.5rem;">
                <h3 style="font-size:1.05rem;font-weight:700;color:var(--c-text-head);margin:0;display:flex;align-items:center;gap:.5rem;">
                    <i class="fa-solid fa-earth-asia" style="color:var(--c-primary);"></i> Peta Geospasial Wilayah Desa
                </h3>
                <a href="{{ site_url('peta') }}" target="_blank" class="fs-btn-outline" style="font-size:.78rem;padding:.35rem .75rem;">
                    <i class="fa-solid fa-expand"></i> Buka Peta Layar Penuh
                </a>
            </div>
            <div id="map_wilayah_full" style="height:360px;width:100%;border-radius:var(--r-md);overflow:hidden;border:1px solid var(--c-border);z-index:1;"></div>
        </div>

        {{-- Data Table Card --}}
        <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem;">
                <h2 style="font-size:1.15rem;font-weight:700;color:var(--c-text-head);margin:0;display:flex;align-items:center;gap:.5rem;">
                    <i class="fa-solid fa-list-check" style="color:var(--c-primary);"></i> Rincian Demografi Wilayah RT &amp; RW
                </h2>
                <span style="font-size:.78rem;background:var(--c-primary-bg);color:var(--c-primary-dark);padding:.25rem .75rem;border-radius:999px;font-weight:600;">
                    Tahun {{ date('Y') }}
                </span>
            </div>

            <div style="overflow-x:auto;">
                <table class="fs-table" id="tabelData" style="width:100%;border-collapse:collapse;font-size:.875rem;">
                    <thead>
                        <tr style="background:var(--c-primary-dark);color:white;">
                            <th style="padding:.75rem .85rem;text-align:center;width:45px;border-top-left-radius:var(--r-sm);">No</th>
                            <th style="padding:.75rem .85rem;text-align:left;">Wilayah / Nama Ketua</th>
                            <th style="padding:.75rem .85rem;text-align:center;width:90px;">Jumlah KK</th>
                            <th style="padding:.75rem .85rem;text-align:center;width:95px;">L + P</th>
                            <th style="padding:.75rem .85rem;text-align:center;width:80px;">Laki-laki</th>
                            <th style="padding:.75rem .85rem;text-align:center;width:85px;border-top-right-radius:var(--r-sm);">Perempuan</th>
                        </tr>
                    </thead>
                    <tbody style="color:var(--c-text-body);"></tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
.fs-table th, .fs-table td {
    padding: .75rem .85rem; border-bottom: 1px solid var(--c-border);
}
.fs-table tbody tr:hover { background: #f8fafc; }
.fs-table tbody tr.row-dusun {
    background: #f0fdf4; font-weight: 700; color: var(--c-primary-dark);
}
.fs-table tbody tr.row-rw {
    background: #ffffff; font-weight: 600;
}
.fs-table tbody tr.row-rt {
    background: #ffffff; font-size: .82rem; color: #475569;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Initialize Leaflet Map
    if (typeof L !== 'undefined') {
        var lat = {{ !empty($desa['lat']) ? $desa['lat'] : -5.5683 }};
        var lng = {{ !empty($desa['lng']) ? $desa['lng'] : 105.4745 }};
        var zoom = {{ !empty($desa['zoom']) ? $desa['zoom'] : 13 }};

        var mapFull = L.map('map_wilayah_full', { scrollWheelZoom: false }).setView([lat, lng], zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19, attribution: '&copy; OpenStreetMap'
        }).addTo(mapFull);

        @if (!empty($desa['path']))
            try {
                var polygon_desa = {!! $desa['path'] !!};
                var layerDesa = L.polygon(polygon_desa, {
                    stroke: true, color: '#16803c', opacity: 0.9, weight: 2.5,
                    fillColor: '#22c55e', fillOpacity: 0.25
                }).bindTooltip("Wilayah Desa {{ e($desa['nama_desa']) }}").addTo(mapFull);
                mapFull.fitBounds(layerDesa.getBounds());
            } catch(e) {}
        @endif

        setTimeout(function() { mapFull.invalidateSize(); }, 300);
    }

    // 2. Load Administrative Table via AJAX
    var tabelData = $('#tabelData');
    var routeWilayah = '{{ route("api.wilayah.administratif") }}';

    $.get(routeWilayah, function(response) {
        var data = response.data || [];
        var tbody = tabelData.find('tbody');
        tbody.empty();

        if (!data.length) {
            tbody.append('<tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--c-text-muted);">Tidak ada data wilayah yang tersedia.</td></tr>');
            return;
        }

        var noDusun = 1;
        var totalKK = 0, totalPW = 0, totalPria = 0, totalWanita = 0;

        data.forEach(function(item) {
            var attr = item.attributes || {};
            var namaKepala = attr.kepala_nama ? ' (Ketua: ' + attr.kepala_nama + ')' : '';
            var dusunTitle = (attr.sebutan_dusun || 'Dusun') + ' ' + (attr.dusun || '') + namaKepala;

            var rowDusun = `
                <tr class="row-dusun">
                    <td style="text-align:center;">${noDusun}</td>
                    <td><i class="fa-solid fa-map-pin" style="color:var(--c-primary);margin-right:.4rem;"></i> <strong>${dusunTitle}</strong></td>
                    <td style="text-align:center;">${attr.keluarga_aktif_count || 0}</td>
                    <td style="text-align:center;color:var(--c-primary);font-weight:700;">${attr.penduduk_pria_wanita_count || 0}</td>
                    <td style="text-align:center;">${attr.penduduk_pria_count || 0}</td>
                    <td style="text-align:center;">${attr.penduduk_wanita_count || 0}</td>
                </tr>
            `;
            tbody.append(rowDusun);

            totalKK += (attr.keluarga_aktif_count || 0);
            totalPria += (attr.penduduk_pria_count || 0);
            totalWanita += (attr.penduduk_wanita_count || 0);
            totalPW += (attr.penduduk_pria_wanita_count || 0);
            noDusun++;

            // RW Level
            if (attr.rws && attr.rws.length) {
                var noRW = 1;
                attr.rws.forEach(function(rwItem) {
                    if (rwItem.rw !== '-') {
                        var rwTitle = (rwItem.sebutan_rw || 'RW') + ' ' + rwItem.rw + (rwItem.kepala_nama ? ' (' + rwItem.kepala_nama + ')' : '');
                        var rowRW = `
                            <tr class="row-rw">
                                <td></td>
                                <td style="padding-left:2rem;"><i class="fa-solid fa-turn-up" style="transform:rotate(90deg);color:var(--c-text-muted);margin-right:.4rem;"></i> ${rwTitle}</td>
                                <td style="text-align:center;">${rwItem.keluarga_aktif_count || 0}</td>
                                <td style="text-align:center;">${rwItem.penduduk_pria_wanita_count || 0}</td>
                                <td style="text-align:center;">${rwItem.penduduk_pria_count || 0}</td>
                                <td style="text-align:center;">${rwItem.penduduk_wanita_count || 0}</td>
                            </tr>
                        `;
                        tbody.append(rowRW);
                        noRW++;
                    }

                    // RT Level
                    if (rwItem.rts && rwItem.rts.length) {
                        rwItem.rts.forEach(function(rtItem) {
                            if (rtItem.rt !== '-') {
                                var rtTitle = (rtItem.sebutan_rt || 'RT') + ' ' + rtItem.rt + (rtItem.kepala_nama ? ' (' + rtItem.kepala_nama + ')' : '');
                                var rowRT = `
                                    <tr class="row-rt">
                                        <td></td>
                                        <td style="padding-left:3.5rem;color:var(--c-text-muted);"><i class="fa-regular fa-circle-dot" style="font-size:.6rem;margin-right:.4rem;"></i> ${rtTitle}</td>
                                        <td style="text-align:center;">${rtItem.keluarga_aktif_count || 0}</td>
                                        <td style="text-align:center;">${rtItem.penduduk_pria_wanita_count || 0}</td>
                                        <td style="text-align:center;">${rtItem.penduduk_pria_count || 0}</td>
                                        <td style="text-align:center;">${rtItem.penduduk_wanita_count || 0}</td>
                                    </tr>
                                `;
                                tbody.append(rowRT);
                            }
                        });
                    }
                });
            }
        });

        // Summary Foot Row
        var tfoot = `
            <tr style="background:var(--c-primary-dark);color:white;font-weight:700;">
                <td colspan="2" style="text-align:center;padding:.85rem;border-bottom-left-radius:var(--r-sm);">TOTAL KESELURUHAN WILAYAH</td>
                <td style="text-align:center;">${totalKK}</td>
                <td style="text-align:center;color:#fef08a;">${totalPW}</td>
                <td style="text-align:center;">${totalPria}</td>
                <td style="text-align:center;border-bottom-right-radius:var(--r-sm);">${totalWanita}</td>
            </tr>
        `;
        tbody.append(tfoot);
    });
});
</script>
@endsection
