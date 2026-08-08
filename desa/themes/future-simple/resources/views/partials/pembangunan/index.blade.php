@extends('theme::layouts.full-content')
@include('theme::commons.asset_peta')

@section('content')
<div class="fs-pembangunan-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span>Pembangunan Desa</span>
        </div>
    </nav>

    {{-- Hero Header --}}
    <div style="background:linear-gradient(135deg, var(--c-primary-dark) 0%, var(--c-primary) 100%);color:var(--c-text-inv);padding:2rem 2.25rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-10px;bottom:-20px;font-size:9rem;color:rgba(255,255,255,0.06);pointer-events:none;"><i class="fa-solid fa-helmet-safety"></i></div>
        <div style="position:relative;z-index:2;max-width:680px;">
            <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:var(--r-pill);display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;color:var(--c-text-inv);">
                <i class="fa-solid fa-building"></i> Proyek & Infrastruktur Desa
            </span>
            <h1 style="font-size:1.75rem;font-weight:700;margin-bottom:.5rem;line-height:1.3;color:var(--c-text-inv);">
                Pembangunan Desa {{ e($desa['nama_desa']) }}
            </h1>
            <p style="font-size:.9rem;color:rgba(255,255,255,0.9);line-height:1.6;margin:0;">
                Transparansi proyek pembangunan desa — anggaran, lokasi, dan perkembangan fisik.
            </p>
        </div>
    </div>

    {{-- Loading --}}
    <div id="pembangunan-loading" style="text-align:center;padding:3rem;color:var(--c-text-muted);">
        <i class="fa-solid fa-spinner fa-spin" style="font-size:1.8rem;margin-bottom:.5rem;color:var(--c-primary);display:block;"></i>
        <p style="font-size:.88rem;">Memuat data pembangunan...</p>
    </div>

    {{-- Grid --}}
    <div id="pembangunan-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;margin-bottom:2rem;"></div>

    {{-- Pagination --}}
    <div id="pagination-container" class="fs-paging" style="margin-top:1.75rem;display:none;">
        <ul class="pagination" style="display:flex;justify-content:center;gap:.5rem;list-style:none;flex-wrap:wrap;"></ul>
    </div>

    {{-- Map Modal --}}
    <div id="modalLokasi" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center;padding:1rem;">
        <div style="background:var(--c-white);border-radius:var(--r-lg);width:100%;max-width:680px;box-shadow:var(--sh-lg);overflow:hidden;animation:modalSlide .25s ease-out;">
            <div style="padding:1rem 1.25rem;background:var(--c-primary-dark);color:var(--c-text-inv);display:flex;align-items:center;justify-content:space-between;">
                <h3 id="modal-lokasi-title" style="font-size:.95rem;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;color:var(--c-text-inv);">
                    <i class="fa-solid fa-map-location-dot"></i> Lokasi Pembangunan
                </h3>
                <button onclick="document.getElementById('modalLokasi').style.display='none'" style="background:none;border:none;color:var(--c-text-inv);font-size:1.2rem;cursor:pointer;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="map" style="width:100%;height:360px;"></div>
        </div>
    </div>
</div>

<style>
.pmb-card { transition:transform .2s,box-shadow .2s; }
.pmb-card:hover { transform:translateY(-3px); box-shadow:var(--sh-md) !important; }
.pmb-card img { transition:transform .3s; }
.pmb-card:hover img { transform:scale(1.03); }
@keyframes modalSlide { from{opacity:0;transform:translateY(-15px);}to{opacity:1;transform:translateY(0);} }
</style>

@push('scripts')
<script src="{{ theme_asset('js/pagination.js') }}"></script>
<script>
$(document).ready(function() {
    function formatRp(num) {
        if (!num || isNaN(num)) return '-';
        return 'Rp ' + parseInt(num).toLocaleString('id-ID');
    }

    function loadPembangunan(params) {
        params = params || {};
        var pageSize = {{ theme_config('jumlah_pembangunan_perhalaman') ?? 9 }};
        var apiUrl = `{{ route('api.pembangunan') }}?page[size]=${pageSize}`;

        $('#pembangunan-loading').show();
        $('#pembangunan-list').empty();
        $('#pagination-container').hide();

        $.get(apiUrl, params, function(data) {
            $('#pembangunan-loading').hide();
            var list = data.data;

            if (!list || !list.length) {
                $('#pembangunan-list').html('<div style="text-align:center;padding:3rem;color:var(--c-text-muted);grid-column:1/-1;"><i class="fa-solid fa-helmet-safety" style="font-size:2.2rem;margin-bottom:.5rem;display:block;opacity:.4;"></i><p style="font-size:.88rem;">Data pembangunan belum tersedia.</p></div>');
                return;
            }

            list.forEach(function(item) {
                var a = item.attributes;
                var url = SITE_URL + 'pembangunan/' + a.slug;
                var fotoHtml = a.foto
                    ? `<div style="height:170px;overflow:hidden;"><img src="${a.foto}" alt="${a.judul}" style="width:100%;height:100%;object-fit:cover;"></div>`
                    : `<div style="height:170px;background:var(--c-primary-light);display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-helmet-safety" style="font-size:2.5rem;color:var(--c-primary);opacity:.6;"></i></div>`;

                var totalAnggaran = a.sumber_biaya_jumlah || a.anggaran || 0;
                var mapBtn = (a.lat && a.lng)
                    ? `<button class="btn-lokasi" data-lat="${a.lat}" data-lng="${a.lng}" data-title="${a.judul}" style="display:flex;align-items:center;gap:.35rem;padding:.4rem .75rem;background:var(--c-primary-light);color:var(--c-primary-dark);border:1px solid var(--c-border);border-radius:var(--r-sm);font-size:.76rem;font-weight:600;cursor:pointer;"><i class="fa-solid fa-map-location-dot"></i> Peta</button>`
                    : '';

                var card = `
                <div class="pmb-card" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);overflow:hidden;box-shadow:var(--sh-sm);display:flex;flex-direction:column;">
                    ${fotoHtml}
                    <div style="padding:1rem;flex:1;display:flex;flex-direction:column;justify-content:space-between;gap:.75rem;">
                        <div>
                            <h3 style="font-size:.9rem;font-weight:700;color:var(--c-text-head);margin-bottom:.45rem;line-height:1.35;">${a.judul}</h3>
                            <div style="display:flex;flex-wrap:wrap;gap:.35rem;margin-bottom:.55rem;">
                                <span style="font-size:.72rem;background:#f3f4f6;color:var(--c-text-body);padding:.15rem .45rem;border-radius:var(--r-pill);font-weight:500;">
                                    <i class="fa-regular fa-calendar"></i> ${a.tahun_anggaran || '-'}
                                </span>
                                <span style="font-size:.72rem;background:var(--c-primary-light);color:var(--c-primary-dark);padding:.15rem .45rem;border-radius:var(--r-pill);font-weight:600;">
                                    <i class="fa-solid fa-map-pin"></i> ${(a.lokasi || '-').substring(0, 25)}
                                </span>
                            </div>
                            ${totalAnggaran > 0 ? `<div style="font-size:.8rem;color:var(--c-text-muted);margin-bottom:.35rem;"><i class="fa-solid fa-money-bill-wave" style="color:var(--c-primary);margin-right:.3rem;"></i><strong style="color:var(--c-text-head);">${formatRp(totalAnggaran)}</strong></div>` : ''}
                            <p style="font-size:.78rem;color:var(--c-text-body);line-height:1.5;">${(a.keterangan || '').substring(0, 90)}${(a.keterangan || '').length > 90 ? '...' : ''}</p>
                        </div>
                        <div style="display:flex;gap:.4rem;flex-wrap:wrap;">
                            <a href="${url}" style="display:flex;align-items:center;gap:.35rem;padding:.4rem .75rem;background:var(--c-primary);color:white;border-radius:var(--r-sm);font-size:.76rem;font-weight:600;text-decoration:none;">
                                <i class="fa-solid fa-arrow-right"></i> Selengkapnya
                            </a>
                            ${mapBtn}
                        </div>
                    </div>
                </div>`;

                $('#pembangunan-list').append(card);
            });

            initPagination(data);
        });
    }

    $(document).on('click', '.btn-lokasi', function() {
        var lat = parseFloat($(this).data('lat'));
        var lng = parseFloat($(this).data('lng'));
        var title = $(this).data('title');

        $('#modal-lokasi-title').html('<i class="fa-solid fa-map-location-dot"></i> ' + title);
        $('#modalLokasi').css('display', 'flex');

        setTimeout(function() {
            if (window._pmb_map) { window._pmb_map.remove(); window._pmb_map = null; }
            window._pmb_map = L.map('map', { maxZoom: setting.max_zoom_peta, minZoom: setting.min_zoom_peta }).setView([lat, lng], 15);
            getBaseLayers(window._pmb_map, setting.mapbox_key, setting.jenis_peta);
            var icon = L.icon({ iconUrl: setting.icon_pembangunan_peta });
            L.marker([lat, lng], { icon: icon }).addTo(window._pmb_map).bindPopup(title).openPopup();
            L.control.scale().addTo(window._pmb_map);
            window._pmb_map.invalidateSize();
        }, 150);
    });

    $('#modalLokasi').on('click', function(e) { if (e.target === this) $(this).hide(); });
    $('.pagination').on('click', '.btn-page', function() { loadPembangunan({ 'page[number]': $(this).data('page') }); });
    loadPembangunan();
});
</script>
@endpush
@endsection
