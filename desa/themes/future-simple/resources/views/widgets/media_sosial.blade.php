<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="box" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.25rem;margin-bottom:1.5rem;box-shadow:var(--sh-sm);">
    <div class="box-header" style="margin-bottom:1rem;border-bottom:2px solid var(--c-primary-light);padding-bottom:.5rem;">
        <h3 class="box-title" style="font-size:1rem;font-weight:700;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;">
            <i class="fa-solid fa-globe" style="color:var(--c-primary);"></i> {{ $judul_widget }}
        </h3>
    </div>
    <div class="box-body" style="display:flex;flex-wrap:wrap;gap:.65rem;align-items:center;">
        @foreach ($sosmed as $data)
            @if (!empty($data['link']))
                <a href="{{ $data['link'] }}" target="_blank" rel="noopener noreferrer" style="width:40px;height:40px;border-radius:var(--r-md);overflow:hidden;box-shadow:var(--sh-sm);display:inline-flex;align-items:center;justify-content:center;transition:transform .2s;" title="{{ $data['nama'] }}">
                    <img src="{{ $data['icon'] }}" alt="{{ $data['nama'] }}" style="width:100%;height:100%;object-fit:cover;" />
                </a>
            @endif
        @endforeach
    </div>
</div>
