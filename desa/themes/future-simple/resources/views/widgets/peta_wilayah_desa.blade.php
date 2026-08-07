<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="fs-sidebar-widget" id="widget-peta-wilayah">
    <h4 class="fs-sidebar-title" style="display:flex;align-items:center;gap:.4rem;">
        <i class="fa-solid fa-map-location-dot" style="color:var(--c-primary);"></i>
        {{ $judul_widget ?? 'Peta Wilayah Desa' }}
    </h4>
    
    <div id="map_wilayah" style="height:220px;width:100%;border-radius:var(--r-md);overflow:hidden;margin-bottom:.75rem;border:1px solid var(--c-border);z-index:1;"></div>
    
    @php
        $lat = !empty($desa['lat']) ? $desa['lat'] : '-5.5683';
        $lng = !empty($desa['lng']) ? $desa['lng'] : '105.4745';
    @endphp
    
    <a href="https://www.openstreetmap.org/#map=15/{{ $lat }}/{{ $lng }}" 
       target="_blank" 
       class="fs-btn-outline" 
       style="font-size:.78rem;padding:.3rem .85rem;width:100%;justify-content:center;box-sizing:border-box;">
        <i class="fa-solid fa-up-right-from-square"></i> Buka Peta Lengkap
    </a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    if (typeof L === 'undefined') return;

    var lat = {{ !empty($desa['lat']) ? $desa['lat'] : -5.5683 }};
    var lng = {{ !empty($desa['lng']) ? $desa['lng'] : 105.4745 }};
    var zoom = {{ !empty($desa['zoom']) ? $desa['zoom'] : 13 }};

    var mapWilayah = L.map('map_wilayah', {
        scrollWheelZoom: false
    }).setView([lat, lng], zoom);

    // Fallback OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap'
    }).addTo(mapWilayah);

    try {
        if (typeof getBaseLayers === 'function') {
            var baseLayers = getBaseLayers(mapWilayah, "{{ setting('mapbox_key') }}", "{{ setting('jenis_peta') }}");
            if (baseLayers) {
                L.control.layers(baseLayers, null, { position: 'topright', collapsed: true }).addTo(mapWilayah);
            }
        }
    } catch(e) {}

    @if (!empty($desa['path']))
        try {
            var polygon_desa = {!! $desa['path'] !!};
            var style_polygon = {
                stroke: true, color: '#16803c', opacity: 0.9, weight: 2.5,
                fillColor: '#22c55e', fillOpacity: 0.25
            };
            var layerDesa = L.polygon(polygon_desa, style_polygon).bindTooltip("Wilayah Desa {{ e($desa['nama_desa']) }}").addTo(mapWilayah);
            mapWilayah.fitBounds(layerDesa.getBounds());
        } catch(e) {}
    @endif

    setTimeout(function() { mapWilayah.invalidateSize(); }, 300);
});
</script>
