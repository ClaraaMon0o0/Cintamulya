@php
    $daftar_statistik = daftar_statistik();
    $slug_aktif = str_replace('_', '-', $slug_aktif ?? '');
    $s_links = [
        [
            'target' => 'statPenduduk',
            'label' => 'Statistik Penduduk',
            'icon' => 'fa-solid fa-chart-pie',
            'submenu' => $daftar_statistik['penduduk'] ?? [],
        ],
        [
            'target' => 'statKeluarga',
            'label' => 'Statistik Keluarga',
            'icon' => 'fa-solid fa-users',
            'submenu' => $daftar_statistik['keluarga'] ?? [],
        ],
        [
            'target' => 'statBantuan',
            'label' => 'Statistik Bantuan',
            'icon' => 'fa-solid fa-hand-holding-heart',
            'submenu' => $daftar_statistik['bantuan'] ?? [],
        ],
        [
            'target' => 'statLainnya',
            'label' => 'Statistik Lainnya',
            'icon' => 'fa-solid fa-chart-bar',
            'submenu' => $daftar_statistik['lainnya'] ?? [],
        ],
    ];
@endphp

<div class="fs-stat-sidebar" style="background:white;border-radius:var(--r-md);border:1px solid var(--c-border);box-shadow:var(--sh-sm);overflow:hidden;margin-bottom:1.5rem;">
    <div style="padding:1rem 1.25rem;background:linear-gradient(135deg, #064e3b, #16803c);color:white;font-weight:700;font-size:.92rem;display:flex;align-items:center;gap:.5rem;">
        <i class="fa-solid fa-layer-group" style="color:#a7f3d0;"></i> Navigasi Data Statistik
    </div>

    <div class="fs-stat-menu">
        @foreach ($s_links as $index => $statistik)
            @php 
                $is_active = in_array($slug_aktif, array_column($statistik['submenu'], 'slug'));
            @endphp
            <div class="fs-stat-group" style="border-bottom:1px solid var(--c-border);">
                <button type="button" onclick="toggleStatMenu('{{ $statistik['target'] }}')"
                        style="width:100%;padding:.85rem 1.25rem;background:{{ $is_active ? 'var(--c-primary-bg)' : 'white' }};border:none;text-align:left;font-family:var(--ff-base);font-size:.88rem;font-weight:600;color:{{ $is_active ? 'var(--c-primary-dark)' : 'var(--c-text-head)' }};display:flex;align-items:center;justify-content:space-between;cursor:pointer;transition:background .2s;">
                    <span style="display:flex;align-items:center;gap:.6rem;">
                        <i class="{{ $statistik['icon'] }}" style="color:var(--c-primary);font-size:.9rem;"></i>
                        {{ $statistik['label'] }}
                    </span>
                    <i class="fa-solid fa-chevron-down fs-arrow-{{ $statistik['target'] }}" 
                       style="font-size:.75rem;color:var(--c-text-muted);transition:transform .2s;{{ $is_active ? 'transform:rotate(180deg);' : '' }}"></i>
                </button>

                <div id="{{ $statistik['target'] }}" style="display:{{ $is_active ? 'block' : 'none' }};background:#f8fafc;padding:.5rem 0;">
                    <ul style="list-style:none;padding:0;margin:0;">
                        @foreach ($statistik['submenu'] as $submenu)
                            @php
                                $stat_slug = in_array($statistik['target'], ['statBantuan', 'statLainnya']) ? str_replace('first/', '', $submenu['url']) : 'statistik/' . $submenu['key'];
                                if ($stat_slug == 'data-dpt') { $stat_slug = 'dpt'; }
                                $is_item_active = ($submenu['slug'] == $slug_aktif || str_contains($submenu['url'], $slug_aktif));
                            @endphp
                            <li>
                                <a href="{{ site_url($submenu['url']) }}" 
                                   style="display:flex;align-items:center;gap:.5rem;padding:.5rem 1.25rem .5rem 2.5rem;font-size:.82rem;text-decoration:none;color:{{ $is_item_active ? 'var(--c-primary-dark)' : 'var(--c-text-body)' }};font-weight:{{ $is_item_active ? '700' : '400' }};background:{{ $is_item_active ? '#dcfce7' : 'transparent' }};border-left:3px solid {{ $is_item_active ? 'var(--c-primary)' : 'transparent' }};">
                                    <i class="fa-solid fa-angle-right" style="font-size:.65rem;opacity:.7;"></i>
                                    {{ $submenu['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function toggleStatMenu(id) {
    var el = document.getElementById(id);
    var arrow = document.querySelector('.fs-arrow-' + id);
    if (el) {
        if (el.style.display === 'none' || el.style.display === '') {
            el.style.display = 'block';
            if (arrow) arrow.style.transform = 'rotate(180deg)';
        } else {
            el.style.display = 'none';
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        }
    }
}
</script>
