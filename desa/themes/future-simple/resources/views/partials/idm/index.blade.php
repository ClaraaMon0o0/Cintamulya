@extends('theme::layouts.full-content')

@section('content')
<div class="fs-idm-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span style="color:var(--c-text-muted);">Status IDM</span>
        </div>
    </nav>

    {{-- Hero Header (Forest Green to Emerald Gradient Unique Identity) --}}
    <div style="background:linear-gradient(135deg, #064e3b 0%, #16803c 55%, #15803d 100%);color:#ffffff;padding:2.25rem 2.5rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-15px;bottom:-25px;font-size:10rem;color:rgba(255,255,255,0.06);pointer-events:none;">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <div style="position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1.25rem;">
            <div style="max-width:650px;">
                <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);color:#ffffff;font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                    <i class="fa-solid fa-award" style="color:#a7f3d0;"></i> Indeks Desa Membangun (IDM)
                </span>
                <h1 style="font-size:2rem;font-weight:800;margin-bottom:.5rem;line-height:1.2;color:#ffffff;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                    Status IDM {{ ucwords(setting('sebutan_desa')) }} {{ e($desa['nama_desa']) }}
                </h1>
                <p style="font-size:.95rem;color:#f1f5f9;line-height:1.65;margin:0;font-weight:400;">
                    Transparansi nilai dan status kemandirian desa berdasarkan pengukuran Indeks Ketahanan Sosial (IKS), Indeks Ketahanan Ekonomi (IKE), dan Indeks Ketahanan Lingkungan (IKL).
                </p>
            </div>

            <div style="background:rgba(255,255,255,0.15);padding:.85rem 1.25rem;border-radius:var(--r-md);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,0.25);">
                <label for="tahun-idm" style="display:block;font-size:.8rem;font-weight:600;color:#ccfbf1;margin-bottom:.35rem;">
                    <i class="fa-regular fa-calendar-check"></i> Pilih Tahun IDM:
                </label>
                <select id="tahun-idm" onchange="switchIdmTahun(this.value)" style="padding:.45rem text-indent:.5rem;border-radius:var(--r-sm);border:none;font-family:var(--ff-base);font-size:.9rem;background:white;color:var(--c-text-head);font-weight:700;outline:none;cursor:pointer;width:100%;">
                    @foreach (['2024', '2023', '2022', '2021', '2020'] as $t)
                        <option value="{{ $t }}" @selected($t == ($tahun ?? '2024'))>Tahun {{ $t }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Error Banner --}}
    <div id="status-error" style="display:none;margin-bottom:1.5rem;">
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#991b1b;padding:1rem 1.25rem;border-radius:var(--r-md);display:flex;align-items:center;gap:.75rem;">
            <i class="fa-solid fa-triangle-exclamation" style="font-size:1.25rem;"></i>
            <span id="error-message">Data IDM tidak ditemukan untuk tahun ini.</span>
        </div>
    </div>

    {{-- IDM Content Container --}}
    <div id="status-idm">
        {{-- Summary Cards Grid --}}
        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));gap:1.25rem;margin-bottom:2rem;">
            <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.25rem 1.5rem;box-shadow:var(--sh-sm);display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <span style="font-size:.78rem;font-weight:600;color:var(--c-text-muted);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:.35rem;">
                        Skor IDM Saat Ini
                    </span>
                    <span id="skor-saat-ini" style="font-size:1.75rem;font-weight:800;color:var(--c-primary-dark);line-height:1;">
                        0.0000
                    </span>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:var(--c-primary-bg);color:var(--c-primary);display:flex;align-items:center;justify-content:center;font-size:1.35rem;">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>

            <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.25rem 1.5rem;box-shadow:var(--sh-sm);display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <span style="font-size:.78rem;font-weight:600;color:var(--c-text-muted);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:.35rem;">
                        Status Desa
                    </span>
                    <span id="status-saat-ini" style="font-size:1.25rem;font-weight:800;color:#065f46;line-height:1;">
                        -
                    </span>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#dcfce7;color:#166534;display:flex;align-items:center;justify-content:center;font-size:1.35rem;">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
            </div>

            <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.25rem 1.5rem;box-shadow:var(--sh-sm);display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <span style="font-size:.78rem;font-weight:600;color:var(--c-text-muted);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:.35rem;">
                        Target Status
                    </span>
                    <span id="target-status" style="font-size:1.25rem;font-weight:800;color:#92400e;line-height:1;">
                        -
                    </span>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#fef3c7;color:#b45309;display:flex;align-items:center;justify-content:center;font-size:1.35rem;">
                    <i class="fa-solid fa-bullseye"></i>
                </div>
            </div>

            <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.25rem 1.5rem;box-shadow:var(--sh-sm);display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <span style="font-size:.78rem;font-weight:600;color:var(--c-text-muted);text-transform:uppercase;letter-spacing:.03em;display:block;margin-bottom:.35rem;">
                        Skor Minimal
                    </span>
                    <span id="skor-minimal" style="font-size:1.75rem;font-weight:800;color:#1e3a8a;line-height:1;">
                        0.0000
                    </span>
                </div>
                <div style="width:48px;height:48px;border-radius:12px;background:#dbeafe;color:#1d4ed8;display:flex;align-items:center;justify-content:center;font-size:1.35rem;">
                    <i class="fa-solid fa-gauge-high"></i>
                </div>
            </div>
        </div>

        {{-- Main Row: Identity & Chart --}}
        <div style="display:grid;grid-template-columns:1fr 1.3fr;gap:1.5rem;margin-bottom:2rem;">
            {{-- Village Identity Card --}}
            <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <h3 style="font-size:1.05rem;font-weight:700;color:var(--c-text-head);margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;">
                        <i class="fa-solid fa-location-dot" style="color:var(--c-primary);"></i> Identitas Wilayah {{ ucwords(setting('sebutan_desa')) }}
                    </h3>
                    
                    <div style="display:flex;flex-direction:column;gap:.85rem;font-size:.88rem;">
                        <div style="display:flex;justify-content:space-between;padding-bottom:.65rem;border-bottom:1px dashed var(--c-border);">
                            <span style="color:var(--c-text-muted);font-weight:500;">Provinsi</span>
                            <strong id="nama-provinsi" style="color:var(--c-text-head);">-</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding-bottom:.65rem;border-bottom:1px dashed var(--c-border);">
                            <span style="color:var(--c-text-muted);font-weight:500;">Kabupaten</span>
                            <strong id="nama-kabupaten" style="color:var(--c-text-head);">-</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;padding-bottom:.65rem;border-bottom:1px dashed var(--c-border);">
                            <span style="color:var(--c-text-muted);font-weight:500;">{{ strtoupper(setting('sebutan_kecamatan')) }}</span>
                            <strong id="nama-kecamatan" style="color:var(--c-text-head);">-</strong>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span style="color:var(--c-text-muted);font-weight:500;">{{ strtoupper(setting('sebutan_desa')) }}</span>
                            <strong id="nama-desa" style="color:var(--c-text-head);">-</strong>
                        </div>
                    </div>
                </div>

                <div style="margin-top:1.5rem;padding:.85rem 1rem;background:#f8fafc;border-radius:var(--r-md);border:1px solid var(--c-border);font-size:.78rem;color:var(--c-text-muted);">
                    <i class="fa-solid fa-circle-info" style="color:var(--c-primary);"></i> Sumber Data Resmi dari Kementerian Desa, Pembangunan Daerah Tertinggal, dan Transmigrasi (Kemendesa).
                </div>
            </div>

            {{-- Highcharts Container Card --}}
            <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);">
                <h3 style="font-size:1.05rem;font-weight:700;color:var(--c-text-head);margin-bottom:1rem;display:flex;align-items:center;gap:.5rem;">
                    <i class="fa-solid fa-chart-pie" style="color:var(--c-primary);"></i> Proporsi Indeks Ketahanan
                </h3>
                <div id="container-idm-chart" style="min-height:300px;width:100%;"></div>
            </div>
        </div>

        {{-- Indicator Breakdown Table --}}
        <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem;">
                <h3 style="font-size:1.1rem;font-weight:700;color:var(--c-text-head);margin:0;display:flex;align-items:center;gap:.5rem;">
                    <i class="fa-solid fa-list-check" style="color:var(--c-primary);"></i> Rincian Indikator IDM {{ $tahun }}
                </h3>
            </div>

            <div style="overflow-x:auto;">
                <table class="fs-table" id="tabel-daftar" style="width:100%;border-collapse:collapse;font-size:.82rem;">
                    <thead>
                        <tr style="background:var(--c-primary-dark);color:white;">
                            <th rowspan="2" style="padding:.75rem .6rem;text-align:center;width:40px;">NO</th>
                            <th rowspan="2" style="padding:.75rem .85rem;text-align:left;">INDIKATOR IDM</th>
                            <th rowspan="2" style="padding:.75rem .6rem;text-align:center;width:55px;">SKOR</th>
                            <th rowspan="2" style="padding:.75rem .85rem;text-align:left;">KETERANGAN</th>
                            <th rowspan="2" style="padding:.75rem .85rem;text-align:left;">KEGIATAN YANG DAPAT DILAKUKAN</th>
                            <th rowspan="2" style="padding:.75rem .6rem;text-align:center;width:55px;">+NILAI</th>
                            <th colspan="6" style="padding:.5rem .6rem;text-align:center;border-bottom:1px solid rgba(255,255,255,0.2);">YANG DAPAT MELAKSANAKAN KEGIATAN</th>
                        </tr>
                        <tr style="background:#0f4c25;color:white;font-size:.78rem;">
                            <th style="padding:.4rem;text-align:center;">PUSAT</th>
                            <th style="padding:.4rem;text-align:center;">PROV</th>
                            <th style="padding:.4rem;text-align:center;">KAB</th>
                            <th style="padding:.4rem;text-align:center;">DESA</th>
                            <th style="padding:.4rem;text-align:center;">CSR</th>
                            <th style="padding:.4rem;text-align:center;">LAIN</th>
                        </tr>
                    </thead>
                    <tbody style="color:var(--c-text-body);"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.fs-table th, .fs-table td {
    padding: .65rem .75rem; border-bottom: 1px solid var(--c-border);
}
.fs-table tbody tr:hover { background: #f8fafc; }
</style>

@push('scripts')
<script type="text/javascript">
function switchIdmTahun(th) {
    window.location.href = `{{ site_url('status-idm') }}/${th}`;
}

$(document).ready(function() {
    var tahun = '{{ $tahun ?? "2024" }}';
    var route = `{{ site_url('internal_api/idm') }}/${tahun}`;

    $.get(route, function(data) {
        if (!data || data['error_msg'] || !data['data'] || !data['data'][0]) {
            $('#status-error').show();
            $('#status-idm').hide();
            $('#error-message').text(data ? (data['error_msg'] || 'Data IDM tidak ditemukan') : 'Data IDM tidak ditemukan');
            return;
        }

        $('#status-idm').show();
        $('#status-error').hide();

        var summaries = data['data'][0]['attributes']['SUMMARIES'];
        var row = data['data'][0]['attributes']['ROW'];
        var identitas = data['data'][0]['attributes']['IDENTITAS'][0];
        
        var iks = parseFloat(row[35] ? row[35].SKOR : 0);
        var ike = parseFloat(row[48] ? row[48].SKOR : 0);
        var ikl = parseFloat(row[52] ? row[52].SKOR : 0);

        $('#skor-saat-ini').text(parseFloat(summaries.SKOR_SAAT_INI || 0).toFixed(4));
        $('#status-saat-ini').text(summaries.STATUS || '-');
        $('#skor-minimal').text(parseFloat(summaries.SKOR_MINIMAL || 0).toFixed(4));
        $('#target-status').text(summaries.TARGET_STATUS || '-');

        $('#nama-provinsi').text(identitas.nama_provinsi || '-');
        $('#nama-kabupaten').text(identitas.nama_kab_kota || '-');
        $('#nama-kecamatan').text(identitas.nama_kecamatan || '-');
        $('#nama-desa').text(identitas.nama_desa || '-');

        // Render Highcharts Safely
        if (typeof Highcharts !== 'undefined') {
            Highcharts.chart('container-idm-chart', {
                chart: {
                    type: 'pie',
                    style: { fontFamily: 'Poppins, sans-serif' }
                },
                title: { text: null },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y:,.4f}'
                        }
                    }
                },
                series: [{
                    name: 'Skor Indeks',
                    colorByPoint: true,
                    data: [
                        { name: 'IKS (Sosial)', y: iks, color: '#16803c' },
                        { name: 'IKE (Ekonomi)', y: ike, color: '#d97706' },
                        { name: 'IKL (Lingkungan)', y: ikl, color: '#0f766e' }
                    ]
                }],
                credits: { enabled: false }
            });
        }

        // Populate Table
        var tbody = $('#tabel-daftar tbody');
        tbody.empty();
        row.forEach(item => {
            var tr = `
            <tr>
                <td style="text-align:center;font-weight:600;">${item.NO || ''}</td>
                <td style="font-weight:500;color:var(--c-text-head);">${item.INDIKATOR || ''}</td>
                <td style="text-align:center;font-weight:700;color:var(--c-primary-dark);">${item.SKOR || ''}</td>
                <td>${item.KETERANGAN || ''}</td>
                <td>${item.KEGIATAN || ''}</td>
                <td style="text-align:center;">${item.NILAI || ''}</td>
                <td style="text-align:center;">${item.PUSAT || ''}</td>
                <td style="text-align:center;">${item.PROV || ''}</td>
                <td style="text-align:center;">${item.KAB || ''}</td>
                <td style="text-align:center;">${item.DESA || ''}</td>
                <td style="text-align:center;">${item.CSR || ''}</td>
                <td style="text-align:center;">${item.LAINNYA || ''}</td>
            </tr>
            `;
            tbody.append(tr);
        });

    }).fail(function() {
        $('#status-error').show();
        $('#status-idm').hide();
        $('#error-message').text('Data IDM tahun ' + tahun + ' tidak dapat dimuat dari server Kemendesa.');
    });
});
</script>
@endpush
@endsection
