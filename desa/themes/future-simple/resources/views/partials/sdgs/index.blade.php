@extends('theme::layouts.full-content')

@section('content')
<div class="fs-sdgs-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span>Status SDGs</span>
        </div>
    </nav>

    {{-- Hero Header --}}
    <div style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 50%,#0e7490 100%);color:#fff;padding:2.25rem 2.5rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-10px;bottom:-20px;font-size:10rem;color:rgba(255,255,255,0.05);pointer-events:none;"><i class="fa-solid fa-earth-asia"></i></div>
        <div style="position:relative;z-index:2;max-width:700px;">
            <span style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-globe" style="color:#67e8f9;"></i> Sustainable Development Goals
            </span>
            <h1 style="font-size:2rem;font-weight:800;margin-bottom:.5rem;line-height:1.2;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                Status SDGs {{ ucwords(setting('sebutan_desa')) }} {{ e($desa['nama_desa']) }}
            </h1>
            <p style="font-size:.95rem;color:#e0f2fe;line-height:1.65;margin:0;">
                Capaian 18 Goal Tujuan Pembangunan Berkelanjutan berbasis data desa terbarukan.
            </p>
        </div>
        <div id="sdgs-summary" style="display:none;position:absolute;right:2.5rem;top:50%;transform:translateY(-50%);background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);border-radius:var(--r-md);padding:1rem 1.5rem;text-align:center;">
            <div id="average" style="font-size:2.5rem;font-weight:900;line-height:1;color:#67e8f9;"></div>
            <div style="font-size:.78rem;color:#bae6fd;font-weight:600;margin-top:.25rem;">Rata-rata Skor SDGs</div>
        </div>
    </div>

    {{-- Error --}}
    <div id="errorMsg" style="display:none;margin-bottom:1.5rem;">
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:1rem 1.25rem;border-radius:var(--r-md);display:flex;align-items:center;gap:.75rem;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:1.25rem;"></i>
            <span id="errorText">Data SDGs tidak dapat dimuat.</span>
        </div>
    </div>

    {{-- SDGs Grid --}}
    <div id="sdgsData" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1.25rem;"></div>
</div>

<style>
.sdgs-card { transition:transform .2s,box-shadow .2s; }
.sdgs-card:hover { transform:translateY(-4px); box-shadow:var(--sh-md) !important; }
</style>

@push('scripts')
<script>
$(function() {
    $.get("{{ route('api.sdgs') }}", function(response) {
        // Handle top-level error (kode desa BPS belum diisi)
        if (response['error_msg']) {
            $('#errorMsg').show();
            $('#errorText').html(response['error_msg']);
            return;
        }

        if (!response.data || !response.data.length) {
            $('#errorMsg').show();
            $('#errorText').text('Data SDGs tidak ditemukan.');
            return;
        }

        var attrs = response.data[0].attributes;

        // Handle error_msg inside attributes (from error object wrapped by transformer)
        if (attrs && attrs.error_msg) {
            $('#errorMsg').show();
            $('#errorText').html(attrs.error_msg);
            return;
        }

        var items = attrs.data || [];
        var average = attrs.average || '-';

        $('#sdgs-summary').show();
        $('#average').text(average);

        var path = BASE_URL + 'assets/images/sdgs/';

        items.forEach(function(item) {
            var imgSrc = path + item.image;
            var score = parseFloat(item.score) || 0;
            var scoreColor = score >= 0.7 ? '#166534' : score >= 0.4 ? '#92400e' : '#991b1b';
            var scoreBg = score >= 0.7 ? '#dcfce7' : score >= 0.4 ? '#fef3c7' : '#fee2e2';

            $('#sdgsData').append(`
                <div class="sdgs-card" style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);overflow:hidden;box-shadow:var(--sh-sm);display:flex;flex-direction:column;">
                    <div style="overflow:hidden;height:120px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;">
                        <img src="${imgSrc}" alt="${item.image}" style="width:100%;height:100%;object-fit:cover;" onerror="this.style.display='none'"/>
                    </div>
                    <div style="padding:1rem;flex:1;display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-size:.8rem;font-weight:600;color:var(--c-text-muted);">Skor</span>
                        <span style="background:${scoreBg};color:${scoreColor};font-size:1rem;font-weight:800;padding:.2rem .75rem;border-radius:999px;">${item.score}</span>
                    </div>
                </div>
            `);
        });
    }).fail(function() {
        $('#errorMsg').show();
        $('#errorText').text('Gagal memuat data SDGs. Pastikan koneksi tersedia.');
    });
});
</script>
@endpush
@endsection
