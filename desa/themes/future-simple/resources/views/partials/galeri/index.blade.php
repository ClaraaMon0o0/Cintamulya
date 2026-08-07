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
    <div style="background:linear-gradient(135deg,#312e81 0%,#4f46e5 55%,#7c3aed 100%);color:#fff;padding:2.25rem 2.5rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-10px;bottom:-20px;font-size:10rem;color:rgba(255,255,255,0.05);pointer-events:none;"><i class="fa-solid fa-images"></i></div>
        <div style="position:relative;z-index:2;max-width:700px;">
            <span style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-camera" style="color:#c4b5fd;"></i> Dokumentasi Visual Desa
            </span>
            <h1 style="font-size:2rem;font-weight:800;margin-bottom:.5rem;line-height:1.2;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                @if(isset($parent)) Album Galeri @else Galeri @endif {{ $title ?? e($desa['nama_desa']) }}
            </h1>
            <p style="font-size:.95rem;color:#ede9fe;line-height:1.65;margin:0;">
                Koleksi foto kegiatan, pembangunan, dan momen bersejarah {{ e($desa['nama_desa']) }}.
            </p>
        </div>
    </div>

    {{-- Loading --}}
    <div id="galeri-loading" style="text-align:center;padding:3rem;color:var(--c-text-muted);">
        <i class="fa-solid fa-spinner fa-spin" style="font-size:2rem;margin-bottom:.5rem;color:var(--c-primary);"></i>
        <p>Memuat galeri...</p>
    </div>

    {{-- Galeri Grid --}}
    <div id="galeri-list" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;"></div>

    {{-- Pagination --}}
    <div id="pagination-container" class="fs-paging" style="margin-top:1.75rem;display:none;">
        <ul class="pagination" style="display:flex;justify-content:center;gap:.5rem;list-style:none;flex-wrap:wrap;"></ul>
    </div>
</div>

{{-- Lightbox overlay --}}
<div id="fs-lightbox" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:9999;align-items:center;justify-content:center;">
    <button onclick="document.getElementById('fs-lightbox').style.display='none'" style="position:absolute;top:1rem;right:1rem;background:rgba(255,255,255,.2);border:none;color:white;font-size:1.5rem;width:44px;height:44px;border-radius:50%;cursor:pointer;">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <img id="fs-lightbox-img" src="" alt="" style="max-width:90vw;max-height:90vh;border-radius:var(--r-md);object-fit:contain;">
    <div id="fs-lightbox-cap" style="position:absolute;bottom:1.5rem;left:50%;transform:translateX(-50%);background:rgba(0,0,0,.6);color:white;padding:.4rem 1rem;border-radius:999px;font-size:.85rem;"></div>
</div>

<style>
.galeri-card { transition:transform .2s,box-shadow .2s; }
.galeri-card:hover { transform:translateY(-4px); box-shadow:0 12px 30px rgba(0,0,0,0.15) !important; }
.galeri-card img { transition:transform .3s; }
.galeri-card:hover img { transform:scale(1.05); }
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
                    $('#galeri-list').html('<div style="text-align:center;padding:3rem;color:var(--c-text-muted);grid-column:1/-1;"><i class="fa-solid fa-images" style="font-size:2.5rem;margin-bottom:.5rem;display:block;opacity:.4;"></i><p>Album galeri belum tersedia.</p></div>');
                    return;
                }

                data.data.forEach(function(item) {
                    var imgHtml = item.attributes.src_gambar
                        ? `<img src="${item.attributes.src_gambar}" alt="${item.attributes.nama}" style="width:100%;height:200px;object-fit:cover;display:block;"/>`
                        : `<div style="height:200px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:var(--c-text-muted);"><i class="fa-solid fa-image" style="font-size:2rem;opacity:.4;"></i></div>`;

                    var card = $('<div class="galeri-card" style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);overflow:hidden;box-shadow:var(--sh-sm);cursor:pointer;"></div>');

                    if (parent) {
                        card.html(`
                            <div style="overflow:hidden;">${imgHtml}</div>
                            <div style="padding:.85rem 1rem;font-size:.88rem;font-weight:600;color:var(--c-text-head);display:flex;align-items:center;gap:.5rem;">
                                <i class="fa-regular fa-image" style="color:var(--c-primary);"></i> ${item.attributes.nama}
                            </div>
                        `);
                        card.on('click', function() { openLightbox(item.attributes.src_gambar, item.attributes.nama); });
                    } else {
                        card.html(`
                            <a href="${item.attributes.url_detail}" style="display:block;text-decoration:none;color:inherit;">
                                <div style="overflow:hidden;">${imgHtml}</div>
                                <div style="padding:.85rem 1rem;font-size:.88rem;font-weight:600;color:var(--c-text-head);display:flex;align-items:center;justify-content:space-between;">
                                    <span style="display:flex;align-items:center;gap:.5rem;"><i class="fa-solid fa-folder-open" style="color:var(--c-primary);"></i> ${item.attributes.nama}</span>
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

    // Lightbox close on overlay click
    $('#fs-lightbox').on('click', function(e) { if (e.target === this) $(this).hide(); });

    $('.pagination').on('click', '.btn-page', function() { loadGaleri($(this).data('page')); });
    loadGaleri(1);
});
</script>
@endpush
@endsection
