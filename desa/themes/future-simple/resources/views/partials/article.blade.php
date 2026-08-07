@php
    $post = $single_artikel;
    $alt_slug = (defined('PREMIUM') && PREMIUM) ? 'artikel' : 'first';
@endphp

<nav aria-label="Breadcrumb" style="margin-bottom:1rem;">
    <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
        <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
        <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
        <span>{!! $post['kategori'] ? '<a href="' . ci_route("{$alt_slug}.kategori.{$post['kat_slug']}") . '" style="color:var(--c-primary);font-weight:500;">' . $post['kategori'] . '</a>' : 'Artikel' !!}</span>
    </div>
</nav>

<article style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.65rem;font-weight:700;color:var(--c-text-head);line-height:1.35;margin-bottom:.65rem;">
        {{ $post['judul'] }}
    </h1>

    <div style="display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;font-size:.8rem;color:var(--c-text-muted);background:#f8fafc;padding:.5rem .85rem;border-radius:var(--r-sm);border:1px solid var(--c-border);">
        <span style="font-weight:600;color:var(--c-text-head);display:flex;align-items:center;gap:.35rem;">
            <i class="fa-solid fa-circle-check" style="color:var(--c-primary);"></i> {{ $post['owner'] }}
        </span>
        <span>&bull;</span>
        <span><i class="fa-regular fa-calendar" style="margin-right:.3rem;"></i>{{ tgl_indo($post['tgl_upload']) }}</span>
        <span>&bull;</span>
        <span><i class="fa-regular fa-eye" style="margin-right:.3rem;"></i>Dibaca {{ hit($post['hit']) }}x</span>
    </div>
</article>

<div class="content space-y-2 py-4">
    @if ($post['gambar'] && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar']))
        <a href="{{ AmbilFotoArtikel($post['gambar'], 'sedang') }}" class="h-auto block pb-3" data-fancybox="images">
            <figure>
                <img src="{{ AmbilFotoArtikel($post['gambar'], 'sedang') }}" alt="{{ $post['judul'] }}" class="w-full h-auto">
            </figure>
        </a>
    @endif
    {!! $post['isi'] !!}
</div>

@for ($i = 1; $i <= 3; $i++)
    @if ($post['gambar' . $i] && is_file(LOKASI_FOTO_ARTIKEL . 'sedang_' . $post['gambar' . $i]))
        <a href="{{ AmbilFotoArtikel($post['gambar' . $i], 'sedang') }}" class="block" data-fancybox="images">
            <figure>
                <img src="{{ AmbilFotoArtikel($post['gambar' . $i], 'sedang') }}" alt="{{ $post['nama'] }}" class="w-full">
            </figure>
        </a>
    @endif
@endfor
@if ($post['dokumen'])
    <div class="alert alert-info">
        <h4 class="text-h6">Dokumen Lampiran</h4>
        <a href="{{ ci_route('first.unduh_dokumen_artikel', $post['id']) }}" class="text-primary-200 text-sm flex space-x-3 pt-2">
            <span class="fas fa-download text-secondary inline-block"></span>
            <span class="hover:text-link">{{ $post['dokumen'] }}</span>
        </a>
    </div>
@endif
