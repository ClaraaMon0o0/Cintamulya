@extends('theme::layouts.full-content')
@include('theme::commons.asset_peta')

@section('content')
<div class="fs-lapak-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span>Lapak Desa</span>
        </div>
    </nav>

    {{-- Hero Header --}}
    <div style="background:linear-gradient(135deg, var(--c-primary-dark) 0%, var(--c-primary) 100%);color:var(--c-text-inv);padding:2rem 2.25rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-10px;bottom:-20px;font-size:9rem;color:rgba(255,255,255,0.06);pointer-events:none;"><i class="fa-solid fa-store"></i></div>
        <div style="position:relative;z-index:2;max-width:680px;">
            <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:var(--r-pill);display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;color:var(--c-text-inv);">
                <i class="fa-solid fa-shop"></i> UMKM & Produk Unggulan Desa
            </span>
            <h1 style="font-size:1.75rem;font-weight:700;margin-bottom:.5rem;line-height:1.3;color:var(--c-text-inv);">
                Lapak Desa {{ e($desa['nama_desa']) }}
            </h1>
            <p style="font-size:.9rem;color:rgba(255,255,255,0.9);line-height:1.6;margin:0;">
                Katalog produk UMKM warga desa. Dukung ekonomi lokal dengan belanja langsung dari penjual.
            </p>
        </div>
    </div>

    {{-- Search & Filter Bar --}}
    <div style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1rem 1.25rem;margin-bottom:1.25rem;box-shadow:var(--sh-sm);">
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end;">
            <div style="flex:1;min-width:180px;">
                <label style="display:block;font-size:.78rem;font-weight:600;color:var(--c-text-body);margin-bottom:.35rem;">Kategori Produk</label>
                <select id="id_kategori" style="width:100%;padding:.45rem .65rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.85rem;background:var(--c-white);color:var(--c-text-head);">
                    <option value="">Semua Kategori</option>
                </select>
            </div>
            <div style="flex:2;min-width:220px;">
                <label style="display:block;font-size:.78rem;font-weight:600;color:var(--c-text-body);margin-bottom:.35rem;">Cari Produk</label>
                <input type="text" id="search" placeholder="Nama produk atau penjual..." style="width:100%;padding:.45rem .65rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.85rem;color:var(--c-text-head);">
            </div>
            <div style="display:flex;gap:.4rem;">
                <button id="btn-cari" style="padding:.45rem 1rem;background:var(--c-primary);color:white;border:none;border-radius:var(--r-sm);font-size:.85rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:.35rem;">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                <button id="btn-reset" style="display:none;padding:.45rem 1rem;background:#f3f4f6;color:var(--c-text-muted);border:1px solid var(--c-border);border-radius:var(--r-sm);font-size:.85rem;font-weight:600;cursor:pointer;align-items:center;gap:.35rem;">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </button>
            </div>
        </div>
    </div>

    {{-- Loading --}}
    <div id="produk-loading" style="text-align:center;padding:3rem;color:var(--c-text-muted);">
        <i class="fa-solid fa-spinner fa-spin" style="font-size:1.8rem;margin-bottom:.5rem;color:var(--c-primary);display:block;"></i>
        <p style="font-size:.88rem;">Memuat katalog produk...</p>
    </div>

    {{-- Products Grid --}}
    <div id="produk-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:1.25rem;margin-bottom:2rem;"></div>

    {{-- Pagination --}}
    <div id="pagination-container" class="fs-paging" style="margin-top:1.75rem;display:none;">
        <ul class="pagination" style="display:flex;justify-content:center;gap:.5rem;list-style:none;flex-wrap:wrap;"></ul>
    </div>

    {{-- Map Modal --}}
    <div id="modalLokasi" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center;padding:1rem;">
        <div style="background:var(--c-white);border-radius:var(--r-lg);width:100%;max-width:680px;box-shadow:var(--sh-lg);overflow:hidden;animation:modalSlide .25s ease-out;">
            <div style="padding:1rem 1.25rem;background:var(--c-primary-dark);color:var(--c-text-inv);display:flex;align-items:center;justify-content:space-between;">
                <h3 id="modal-lapak-title" style="font-size:.95rem;font-weight:700;margin:0;color:var(--c-text-inv);">
                    <i class="fa-solid fa-map-location-dot" style="margin-right:.4rem;"></i> Lokasi Penjual
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
.lapak-card { transition:transform .2s,box-shadow .2s; }
.lapak-card:hover { transform:translateY(-3px); box-shadow:var(--sh-md) !important; }
.lapak-foto-wrap { height:180px; overflow:hidden; }
.lapak-foto-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .3s; }
.lapak-card:hover .lapak-foto-wrap img { transform:scale(1.03); }
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

    $.get('{{ route('api.lapak.kategori') }}', function(data) {
        data.data.forEach(function(item) {
            $('#id_kategori').append('<option value="'+item.id+'">'+item.attributes.kategori+'</option>');
        });
    });

    function loadProduk(params) {
        params = params || {};
        $('#produk-loading').show();
        $('#produk-list').empty();
        $('#pagination-container').hide();

        $.get('{{ route('api.lapak.produk') }}', params, function(data) {
            $('#produk-loading').hide();
            var list = data.data;

            if (!list || !list.length) {
                $('#produk-list').html('<div style="text-align:center;padding:3rem;color:var(--c-text-muted);grid-column:1/-1;"><i class="fa-solid fa-store" style="font-size:2.2rem;display:block;margin-bottom:.5rem;opacity:.4;"></i><p style="font-size:.88rem;">Tidak ada produk yang tersedia saat ini.</p></div>');
                return;
            }

            list.forEach(function(item) {
                var a = item.attributes;
                var foto = (a.foto && a.foto.length > 0) ? a.foto[0] : '';
                var fotoHtml = foto
                    ? `<div class="lapak-foto-wrap"><img src="${foto}" alt="${a.nama}" loading="lazy"></div>`
                    : `<div style="height:180px;background:var(--c-primary-light);display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-store" style="font-size:2.5rem;color:var(--c-primary);opacity:.6;"></i></div>`;

                var harga = parseInt(a.harga_diskon || a.harga || 0);
                var hargaAsli = parseInt(a.harga || 0);
                var diskonHtml = (harga < hargaAsli && hargaAsli > 0)
                    ? `<span style="font-size:.75rem;color:#ef4444;text-decoration:line-through;">${formatRp(hargaAsli)}</span> `
                    : '';

                var penjual = a.pelapak?.penduduk?.nama || 'Admin';
                var waLink = a.pesan_wa || '#';
                var lat = a.pelapak?.lat;
                var lng = a.pelapak?.lng;
                var mapBtn = (lat && lng)
                    ? `<button class="btn-lokasi-lapak" data-lat="${lat}" data-lng="${lng}" data-zoom="${a.pelapak?.zoom||14}" data-title="${penjual}" style="padding:.4rem .65rem;background:var(--c-primary-light);color:var(--c-primary-dark);border:1px solid var(--c-border);border-radius:var(--r-sm);font-size:.75rem;font-weight:600;cursor:pointer;"><i class="fa-solid fa-map-pin"></i></button>`
                    : '';

                var card = `
                <div class="lapak-card" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);overflow:hidden;box-shadow:var(--sh-sm);display:flex;flex-direction:column;">
                    ${fotoHtml}
                    <div style="padding:.85rem;flex:1;display:flex;flex-direction:column;justify-content:space-between;gap:.6rem;">
                        <div>
                            <h3 style="font-size:.88rem;font-weight:700;color:var(--c-text-head);margin-bottom:.35rem;line-height:1.35;">${a.nama}</h3>
                            <div style="margin-bottom:.3rem;">
                                ${diskonHtml}
                                <span style="font-size:1rem;font-weight:700;color:var(--c-primary-dark);">${formatRp(harga)}</span>
                                <span style="font-size:.72rem;color:var(--c-text-muted);"> / ${a.satuan || 'pcs'}</span>
                            </div>
                            <p style="font-size:.75rem;color:var(--c-text-body);line-height:1.45;">${(a.deskripsi || '').substring(0, 75)}${(a.deskripsi || '').length > 75 ? '...' : ''}</p>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <span style="font-size:.72rem;color:var(--c-text-muted);display:flex;align-items:center;gap:.3rem;">
                                <i class="fa-solid fa-circle-check" style="color:var(--c-primary);"></i> ${penjual}
                            </span>
                        </div>
                        <div style="display:flex;gap:.4rem;">
                            <a href="${waLink}" target="_blank" rel="noopener noreferrer" style="flex:1;display:flex;align-items:center;justify-content:center;gap:.35rem;padding:.4rem;background:var(--c-primary);color:white;border-radius:var(--r-sm);font-size:.76rem;font-weight:600;text-decoration:none;">
                                <i class="fa-brands fa-whatsapp"></i> Beli
                            </a>
                            ${mapBtn}
                        </div>
                    </div>
                </div>`;

                $('#produk-list').append(card);
            });

            initPagination(data);
        });
    }

    $(document).on('click', '.btn-lokasi-lapak', function() {
        var lat = parseFloat($(this).data('lat'));
        var lng = parseFloat($(this).data('lng'));
        var zoom = parseInt($(this).data('zoom')) || 15;
        var title = $(this).data('title');
        $('#modal-lapak-title').html('<i class="fa-solid fa-map-location-dot" style="margin-right:.4rem;"></i> Lokasi: ' + title);
        $('#modalLokasi').css('display', 'flex');
        setTimeout(function() {
            if (window._lapak_map) { window._lapak_map.remove(); window._lapak_map = null; }
            window._lapak_map = L.map('map', { maxZoom: setting.max_zoom_peta, minZoom: setting.min_zoom_peta }).setView([lat, lng], zoom);
            getBaseLayers(window._lapak_map, setting.mapbox_key, setting.jenis_peta);
            var icon = L.icon({ iconUrl: setting.icon_lapak_peta });
            L.marker([lat, lng], { icon: icon }).addTo(window._lapak_map).bindPopup(title).openPopup();
            L.control.scale().addTo(window._lapak_map);
            window._lapak_map.invalidateSize();
        }, 150);
    });

    $('#modalLokasi').on('click', function(e) { if (e.target === this) $(this).hide(); });

    $('#btn-cari').on('click', function() {
        var p = {};
        var kat = $('#id_kategori').val(); if (kat) p['filter[id_produk_kategori]'] = kat;
        var s = $('#search').val(); if (s) p['filter[search]'] = s;
        loadProduk(p);
        $('#btn-reset').show().css('display','flex');
    });

    $('#btn-reset').on('click', function() {
        $('#id_kategori').val('');
        $('#search').val('');
        $(this).hide();
        loadProduk();
    });

    $('#search').on('keypress', function(e) {
        if (e.which === 13) { e.preventDefault(); $('#btn-cari').trigger('click'); }
    });

    $('.pagination').on('click', '.btn-page', function() {
        var p = { 'page[number]': $(this).data('page') };
        var kat = $('#id_kategori').val(); if (kat) p['filter[id_produk_kategori]'] = kat;
        var s = $('#search').val(); if (s) p['filter[search]'] = s;
        loadProduk(p);
    });

    loadProduk();
});
</script>
@endpush
@endsection
