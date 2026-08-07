@extends('theme::layouts.' . $layout)
@php
    $post = $single_artikel;
    $alt_slug = PREMIUM ? 'artikel' : 'first';
@endphp

@include('theme::commons.asset_highcharts')

@section('content')
@if ($post)
<article class="fs-article-detail" id="artikel-detail-{{ $post['id'] }}">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            @if (!empty($post['kategori']))
                <a href="{{ site_url('artikel/kategori/' . ($post['kat_slug'] ?: 1)) }}" style="color:var(--c-primary);font-weight:500;">
                    {{ $post['kategori'] }}
                </a>
                <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            @endif
            <span style="color:var(--c-text-muted);">Detail Artikel</span>
        </div>
    </nav>

    {{-- Title --}}
    <h1 class="fs-article-title" style="font-size:2rem;font-weight:800;color:var(--c-text-head);line-height:1.25;margin-bottom:.85rem;">
        {{ $post['judul'] }}
    </h1>

    {{-- Meta Info --}}
    <div class="fs-article-meta" style="display:flex;align-items:center;gap:1.25rem;flex-wrap:wrap;padding-bottom:1rem;margin-bottom:1.5rem;border-bottom:1px solid var(--c-border);font-size:.82rem;color:var(--c-text-muted);">
        <span><i class="fa-regular fa-user" style="color:var(--c-primary);margin-right:.3rem;"></i> <strong>{{ $post['owner'] ?? 'Admin' }}</strong></span>
        <span><i class="fa-regular fa-calendar" style="color:var(--c-primary);margin-right:.3rem;"></i> {{ $post['tgl_upload_local'] }}</span>
        <span><i class="fa-regular fa-eye" style="color:var(--c-primary);margin-right:.3rem;"></i> Dibaca {{ hit($post['hit']) }} kali</span>
    </div>

    {{-- Featured Main Image --}}
    @if (!empty($post['gambar']) && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar']))
        <div style="margin-bottom:2rem;border-radius:var(--r-md);overflow:hidden;box-shadow:var(--sh-md);">
            <a href="{{ AmbilFotoArtikel($post['gambar'], 'sedang') }}" data-fancybox="images">
                <img src="{{ AmbilFotoArtikel($post['gambar'], 'sedang') }}"
                     alt="{{ $post['judul'] }}"
                     style="width:100%;height:auto;max-height:480px;object-fit:cover;display:block;">
            </a>
        </div>
    @endif

    {{-- Body Content --}}
    <div class="fs-article-body">
        {!! $post['isi'] !!}
    </div>

    {{-- Additional Images --}}
    @for ($i = 1; $i <= 3; $i++)
        @if (!empty($post['gambar' . $i]) && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar' . $i]))
            <div style="margin-top:1.5rem;border-radius:var(--r-md);overflow:hidden;box-shadow:var(--sh-sm);">
                <a href="{{ AmbilFotoArtikel($post['gambar' . $i], 'sedang') }}" data-fancybox="images">
                    <img src="{{ AmbilFotoArtikel($post['gambar' . $i], 'sedang') }}"
                         alt="{{ $post['judul'] }}" style="width:100%;height:auto;display:block;">
                </a>
            </div>
        @endif
    @endfor

    {{-- Document Attachments --}}
    @if (!empty($post['dokumen']))
        <div style="background:var(--c-primary-bg);border-left:4px solid var(--c-primary);padding:1rem 1.25rem;border-radius:0 var(--r-md) var(--r-md) 0;margin-top:2rem;">
            <h4 style="font-size:.95rem;font-weight:700;color:var(--c-primary-dark);margin-bottom:.35rem;">
                <i class="fa-solid fa-paperclip" style="margin-right:.35rem;"></i> Dokumen Lampiran
            </h4>
            <a href="{{ ci_route('first.unduh_dokumen_artikel', $post['id']) }}"
               style="color:var(--c-primary);font-size:.875rem;font-weight:600;text-decoration:underline;">
                <i class="fa-solid fa-download"></i> Unduh {{ $post['dokumen'] }}
            </a>
        </div>
    @endif

    {{-- Share & Comments --}}
    <div style="margin-top:2.5rem;padding-top:1.5rem;border-top:1px solid var(--c-border);">
        @include('theme::commons.share')
    </div>

    <div style="margin-top:2rem;">
        @include('theme::partials.artikel.comment')
    </div>
</article>
@else
    @include('theme::commons.404')
@endif
@endsection
