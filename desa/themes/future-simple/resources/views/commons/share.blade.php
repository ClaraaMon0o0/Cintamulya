<div style="margin-top:2rem;padding-top:1.25rem;border-top:1px solid var(--c-border);">
    <h5 style="font-size:.9rem;font-weight:700;color:var(--c-text-head);margin-bottom:.75rem;display:flex;align-items:center;gap:.4rem;">
        <i class="fa-solid fa-share-nodes" style="color:var(--c-primary);"></i> Bagikan Artikel Ini
    </h5>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
        @php
            $url = $post['url_slug'] ?? site_url();
            $title = $post['judul'] ?? 'Bagikan Artikel Ini';
            $shareButtons = [
                ['url' => 'https://www.facebook.com/sharer.php?u=' . $url, 'icon' => 'fa-brands fa-facebook-f', 'bg' => '#1877f2', 'name' => 'Facebook'],
                ['url' => 'https://twitter.com/share?text=' . rawurlencode($title) . '&url=' . $url, 'icon' => 'fa-brands fa-x-twitter', 'bg' => '#0f1419', 'name' => 'Twitter'],
                ['url' => 'https://telegram.me/share/url?url=' . $url . '&text=' . rawurlencode($title), 'icon' => 'fa-brands fa-telegram', 'bg' => '#26a5e4', 'name' => 'Telegram'],
                ['url' => 'https://api.whatsapp.com/send?text=' . rawurlencode($title . ' ' . $url), 'icon' => 'fa-brands fa-whatsapp', 'bg' => '#25d366', 'name' => 'WhatsApp'],
                ['url' => 'mailto:?subject=' . rawurlencode($title) . '&body=' . rawurlencode("Baca selengkapnya di $url"), 'icon' => 'fa-solid fa-envelope', 'bg' => '#ea4335', 'name' => 'Email'],
            ];
        @endphp

        @foreach ($shareButtons as $sm)
            <a href="{{ $sm['url'] }}" target="_blank" rel="noopener" style="width:36px;height:36px;border-radius:50%;background:{{ $sm['bg'] }};color:white;display:flex;align-items:center;justify-content:center;font-size:.9rem;text-decoration:none;transition:transform .2s;" title="Bagikan ke {{ $sm['name'] }}">
                <i class="{{ $sm['icon'] }}"></i>
            </a>
        @endforeach
    </div>
</div>
