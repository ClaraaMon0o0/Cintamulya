<?php defined('BASEPATH') || exit('No direct script access allowed'); ?>

<div class="box" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.25rem;margin-bottom:1.5rem;box-shadow:var(--sh-sm);">
    <div class="box-header" style="margin-bottom:1rem;border-bottom:2px solid var(--c-primary-light);padding-bottom:.5rem;">
        <h3 class="box-title" style="font-size:1rem;font-weight:700;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;">
            <i class="fa-solid fa-globe" style="color:var(--c-primary);"></i> {{ $judul_widget }}
        </h3>
    </div>
    <div class="box-body" style="display:flex;flex-wrap:wrap;gap:.65rem;align-items:center;">
        @foreach ($sosmed as $data)
            @php
                $link = trim($data['link'] ?? '');
                $namaLow = strtolower($data['nama'] ?? '');
                
                $faIcon = 'fa-solid fa-globe';
                $bgColor = '#16803c';

                if (str_contains($namaLow, 'facebook')) {
                    $faIcon = 'fa-brands fa-facebook-f'; $bgColor = '#1877f2';
                    $finalUrl = str_starts_with($link, 'http') ? $link : 'https://facebook.com/' . $link;
                } elseif (str_contains($namaLow, 'instagram')) {
                    $faIcon = 'fa-brands fa-instagram'; $bgColor = 'linear-gradient(45deg, #f09433, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888)';
                    $finalUrl = str_starts_with($link, 'http') ? $link : 'https://instagram.com/' . $link;
                } elseif (str_contains($namaLow, 'youtube')) {
                    $faIcon = 'fa-brands fa-youtube'; $bgColor = '#ff0000';
                    $finalUrl = str_starts_with($link, 'http') ? $link : 'https://youtube.com/channel/' . $link;
                } elseif (str_contains($namaLow, 'whatsapp')) {
                    $faIcon = 'fa-brands fa-whatsapp'; $bgColor = '#25d366';
                    $finalUrl = str_starts_with($link, 'http') ? $link : 'https://wa.me/' . preg_replace('/[^0-9]/', '', $link);
                } elseif (str_contains($namaLow, 'telegram')) {
                    $faIcon = 'fa-brands fa-telegram'; $bgColor = '#26a5e4';
                    $finalUrl = str_starts_with($link, 'http') ? $link : 'https://t.me/' . $link;
                } elseif (str_contains($namaLow, 'twitter') || str_contains($namaLow, 'x')) {
                    $faIcon = 'fa-brands fa-x-twitter'; $bgColor = '#0f1419';
                    $finalUrl = str_starts_with($link, 'http') ? $link : 'https://x.com/' . $link;
                } else {
                    $finalUrl = str_starts_with($link, 'http') ? $link : ($link ? 'https://' . $link : '');
                }
            @endphp

            @if (!empty($finalUrl) && !empty($link))
                <a href="{{ $finalUrl }}" target="_blank" rel="noopener noreferrer" style="width:38px;height:38px;border-radius:50%;background:{{ $bgColor }};color:white;display:inline-flex;align-items:center;justify-content:center;font-size:1.1rem;text-decoration:none;box-shadow:var(--sh-sm);transition:transform .2s;" title="{{ $data['nama'] }}">
                    <i class="{{ $faIcon }}"></i>
                </a>
            @endif
        @endforeach
    </div>
</div>
