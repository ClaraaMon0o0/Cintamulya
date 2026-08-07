<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="fs-sidebar-widget" id="widget-peta-kantor">
    <h4 class="fs-sidebar-title" style="display:flex;align-items:center;gap:.4rem;">
        <i class="fa-solid fa-building-flag" style="color:var(--c-primary);"></i>
        {{ $judul_widget ?? 'Peta Lokasi Kantor' }}
    </h4>
    
    <div id="map_canvas" style="height:220px;width:100%;border-radius:var(--r-md);overflow:hidden;margin-bottom:.75rem;border:1px solid var(--c-border);z-index:1;"></div>
    
    @php
        $lat = !empty($desa['lat']) ? $desa['lat'] : '-5.5683';
        $lng = !empty($desa['lng']) ? $desa['lng'] : '105.4745';
    @endphp

    <div style="display:flex;gap:.5rem;">
        <a href="https://www.openstreetmap.org/#map=15/{{ $lat }}/{{ $lng }}" 
           target="_blank" 
           class="fs-btn-outline" 
           style="font-size:.78rem;padding:.3rem .6rem;flex:1;justify-center;box-sizing:border-box;">
            <i class="fa-solid fa-location-arrow"></i> Petunjuk Arah
        </a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof L === 'undefined') return;

    var lat = {{ !empty($desa['lat']) ? $desa['lat'] : -5.5683 }};
    var lng = {{ !empty($desa['lng']) ? $desa['lng'] : 105.4745 }};
    var zoom = {{ !empty($desa['zoom']) ? $desa['zoom'] : 14 }};

    var mapKantor = L.map('map_canvas', {
        scrollWheelZoom: false
    }).setView([lat, lng], zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapKantor);

    try {
        if (typeof getBaseLayers === 'function') {
            var baseLayers = getBaseLayers(mapKantor, "{{ setting('mapbox_key') }}", "{{ setting('jenis_peta') }}");
            if (baseLayers) {
                L.control.layers(baseLayers, null, { position: 'topright', collapsed: true }).addTo(mapKantor);
            }
        }
    } catch(e) {}

    @if (!empty($desa['lat']) && !empty($desa['lng']))
        L.marker([lat, lng]).bindPopup("<b>Kantor Desa {{ e($desa['nama_desa']) }}</b><br>{{ e($desa['alamat_kantor']) }}").addTo(mapKantor);
    @endif

    setTimeout(function() { mapKantor.invalidateSize(); }, 300);
});
</script>
