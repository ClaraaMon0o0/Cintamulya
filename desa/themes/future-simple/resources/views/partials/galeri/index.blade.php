@extends('theme::layouts.full-content')

@section('content')
<div class="fs-galeri-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            @if(isset($parent))
                <a href="{{ ci_route('galeri') }}" style="color:var(--c-primary);font-weight:500;">Galeri</a>
                <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
                <span>{{ $title }}</span>
            @else
                <span>Galeri</span>
            @endif
        </div>
    </nav>

    {{-- Hero Header --}}
    <div style="background:linear-gradient(135deg, var(--c-primary-dark) 0%, var(--c-primary) 100%);color:var(--c-text-inv);padding:2rem 2.25rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-10px;bottom:-20px;font-size:9rem;color:rgba(255,255,255,0.06);pointer-events:none;"><i class="fa-solid fa-images"></i></div>
        <div style="position:relative;z-index:2;max-width:680px;">
            <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:var(--r-pill);display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;color:var(--c-text-inv);">
                <i class="fa-solid fa-camera"></i> Dokumentasi Visual Desa
            </span>
            <h1 style="font-size:1.75rem;font-weight:700;margin-bottom:.5rem;line-height:1.3;color:var(--c-text-inv);">
                @if(isset($parent)) Album Galeri @else Galeri @endif {{ $title ?? e($desa['nama_desa']) }}
            </h1>
            <p style="font-size:.9rem;color:rgba(255,255,255,0.9);line-height:1.6;margin:0;">
                Koleksi foto kegiatan, pembangunan, dan momen penting {{ e($desa['nama_desa']) }}.
            </p>
        </div>
    </div>

    {{-- Loading --}}
    <div id="galeri-loading" style="text-align:center;padding:3rem;color:var(--c-text-muted);">
        <i class="fa-solid fa-spinner fa-spin" style="font-size:1.8rem;margin-bottom:.5rem;color:var(--c-primary);"></i>
        <p style="font-size:.88rem;">Memuat galeri...</p>
    </div>

    {{-- Galeri Grid --}}
    <div id="galeri-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.25rem;"></div>

    {{-- Pagination --}}
    <div id="pagination-container" class="fs-paging" style="margin-top:1.75rem;display:none;">
        <ul class="pagination" style="display:flex;justify-content:center;gap:.5rem;list-style:none;flex-wrap:wrap;"></ul>
    </div>
</div>

{{-- Lightbox overlay --}}
<div id="fs-lightbox" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.85);z-index:9999;align-items:center;justify-content:center;">
    <button onclick="document.getElementById('fs-lightbox').style.display='none'" style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,.2);border:none;color:white;font-size:1.3rem;width:40px;height:40px;border-radius:50%;cursor:pointer;">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <img id="fs-lightbox-img" src="" alt="" style="max-width:90vw;max-height:85vh;border-radius:var(--r-md);object-fit:contain;">
    <div id="fs-lightbox-cap" style="position:absolute;bottom:1.5rem;left:50%;transform:translateX(-50%);background:rgba(0,0,0,.7);color:white;padding:.4rem 1rem;border-radius:var(--r-pill);font-size:.85rem;font-weight:500;"></div>
</div>

<style>
.galeri-card { transition:transform .2s,box-shadow .2s; }
.galeri-card:hover { transform:translateY(-3px); box-shadow:var(--sh-md) !important; }
.galeri-card img { transition:transform .3s; }
.galeri-card:hover img { transform:scale(1.03); }
</style>

@push('scripts')
<script src="{{ theme_asset('js/pagination.js') }}"></script>
<script>
$(document).ready(function() {
    var parent = `{{ $parent ?? '' }}`;
    var routeGaleri = `{{ ci_route('internal_api.galeri') }}`;
    var pageSizes = parent ? 12 : 8;

    if (parent) routeGaleri += '/' + parent;

    function openLightbox(src, caption) {
        $('#fs-lightbox-img').attr('src', src);
        $('#fs-lightbox-cap').text(caption);
        $('#fs-lightbox').css('display', 'flex');
    }

    const loadGaleri = function(pageNumber) {
        $('#galeri-loading').show();
        $('#galeri-list').empty();

        $.ajax({
            url: routeGaleri + `?sort=-tgl_upload&page[number]=${pageNumber}&page[size]=${pageSizes}`,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#galeri-loading').hide();

                if (!data.data || !data.data.length) {
                    $('#galeri-list').html('<div style="text-align:center;padding:3rem;color:var(--c-text-muted);grid-column:1/-1;"><i class="fa-solid fa-images" style="font-size:2.2rem;margin-bottom:.5rem;display:block;opacity:.4;"></i><p style="font-size:.88rem;">Album galeri belum tersedia.</p></div>');
                    return;
                }

                data.data.forEach(function(item) {
                    var imgHtml = item.attributes.src_gambar
                        ? `<img src="${item.attributes.src_gambar}" alt="${item.attributes.nama}" style="width:100%;height:180px;object-fit:cover;display:block;"/>`
                        : `<div style="height:180px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:var(--c-text-muted);"><i class="fa-solid fa-image" style="font-size:1.8rem;opacity:.4;"></i></div>`;

                    var card = $('<div class="galeri-card" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);overflow:hidden;box-shadow:var(--sh-sm);cursor:pointer;"></div>');

                    if (parent) {
                        card.html(`
                            <div style="overflow:hidden;">${imgHtml}</div>
                            <div style="padding:.75rem .9rem;font-size:.85rem;font-weight:600;color:var(--c-text-head);display:flex;align-items:center;gap:.5rem;">
                                <i class="fa-regular fa-image" style="color:var(--c-primary);"></i> ${item.attributes.nama}
                            </div>
                        `);
                        card.on('click', function() { openLightbox(item.attributes.src_gambar, item.attributes.nama); });
                    } else {
                        card.html(`
                            <a href="${item.attributes.url_detail}" style="display:block;text-decoration:none;color:inherit;">
                                <div style="overflow:hidden;">${imgHtml}</div>
                                <div style="padding:.75rem .9rem;font-size:.85rem;font-weight:600;color:var(--c-text-head);display:flex;align-items:center;justify-content:space-between;">
                                    <span style="display:flex;align-items:center;gap:.4rem;"><i class="fa-solid fa-folder-open" style="color:var(--c-primary);"></i> ${item.attributes.nama}</span>
                                    <i class="fa-solid fa-angle-right" style="font-size:.75rem;opacity:.5;"></i>
                                </div>
                            </a>
                        `);
                    }

                    $('#galeri-list').append(card);
                });

                initPagination(data);
            }
        });
    };

    $('#fs-lightbox').on('click', function(e) { if (e.target === this) $(this).hide(); });
    $('.pagination').on('click', '.btn-page', function() { loadGaleri($(this).data('page')); });
    loadGaleri(1);
});
</script>
@endpush
@endsection
