{{-- Breadcrumb --}}
<nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
    <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
        <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
        <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
        <a href="{{ site_url('data-wilayah') }}" style="color:var(--c-primary);font-weight:500;">Data Statistik</a>
        <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
        <span style="color:var(--c-text-muted);">{{ $heading ?? 'Statistik Penduduk' }}</span>
    </div>
</nav>

{{-- Hero Header (Teal to Forest Green Unique Identity) --}}
<div style="background:linear-gradient(135deg, #0f766e 0%, #16803c 60%, #047857 100%);color:#ffffff;padding:2rem 2.25rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
    <div style="position:absolute;right:-15px;bottom:-25px;font-size:10rem;color:rgba(255,255,255,0.06);pointer-events:none;">
        <i class="fa-solid fa-chart-line"></i>
    </div>
    <div style="position:relative;z-index:2;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
        <div>
            <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);color:#ffffff;font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-chart-pie" style="color:#99f6e4;"></i> Kependudukan &amp; Statistik
            </span>
            <h1 style="font-size:1.85rem;font-weight:800;margin-bottom:.4rem;line-height:1.25;color:#ffffff;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                Data Statistik {{ $heading }}
            </h1>
            <p style="font-size:.92rem;color:#ccfbf1;line-height:1.6;margin:0;font-weight:400;max-width:620px;">
                Visualisasi data dan distribusi statistik kependudukan {{ ucwords(setting('sebutan_desa')) }} {{ e($desa['nama_desa']) }} secara terperinci.
            </p>
        </div>

        @if (isset($list_tahun) && count($list_tahun) > 0)
            <div style="background:rgba(255,255,255,0.15);padding:.75rem 1rem;border-radius:var(--r-md);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,0.25);">
                <label for="tahun" style="display:block;font-size:.78rem;font-weight:600;color:#ccfbf1;margin-bottom:.25rem;">
                    <i class="fa-regular fa-calendar-check"></i> Filter Tahun:
                </label>
                <select id="tahun" name="tahun" style="padding:.4rem .75rem;border-radius:var(--r-sm);border:none;font-family:var(--ff-base);font-size:.875rem;background:white;color:var(--c-text-head);font-weight:600;outline:none;">
                    <option value="" @selected(empty($selected_tahun))>Semua Tahun</option>
                    @foreach ($list_tahun as $item_tahun)
                        <option value="{{ $item_tahun }}" @selected($item_tahun == $selected_tahun)>Tahun {{ $item_tahun }}</option>
                    @endforeach
                </select>
            </div>
        @endif
    </div>
</div>

{{-- Smart Categorization Filter Tabs (Specifically for Rentang Umur / Key 13) --}}
@if (in_array($key ?? '', ['13', 'rentang-umur', 'rentang_umur']) || str_contains(strtolower($heading ?? ''), 'rentang umur'))
    <div style="background:white;padding:1.25rem;border-radius:var(--r-lg);border:1px solid var(--c-border);margin-bottom:1.75rem;box-shadow:var(--sh-sm);">
        <div style="font-size:.85rem;font-weight:700;color:var(--c-text-head);margin-bottom:.85rem;display:flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-sliders" style="color:var(--c-primary);"></i> Kelompokkan Data Rentang Umur (Mencegah Redundansi Overlap):
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
            <button type="button" onclick="filterAgeGroup('bps')" class="fs-age-tab fs-tab-active" id="tab-bps" style="padding:.5rem .95rem;border-radius:var(--r-md);font-size:.82rem;font-weight:600;border:1.5px solid var(--c-primary);background:var(--c-primary);color:white;cursor:pointer;transition:all .2s;">
                <i class="fa-solid fa-chart-column"></i> Kelompok 5 Tahun (Standar BPS)
            </button>
            <button type="button" onclick="filterAgeGroup('produktif')" class="fs-age-tab" id="tab-produktif" style="padding:.5rem .95rem;border-radius:var(--r-md);font-size:.82rem;font-weight:600;border:1.5px solid var(--c-border);background:white;color:var(--c-text-head);cursor:pointer;transition:all .2s;">
                <i class="fa-solid fa-briefcase"></i> Usia Kerja &amp; Lansia (0-14, 15-56, 56+)
            </button>
            <button type="button" onclick="filterAgeGroup('pendidikan')" class="fs-age-tab" id="tab-pendidikan" style="padding:.5rem .95rem;border-radius:var(--r-md);font-size:.82rem;font-weight:600;border:1.5px solid var(--c-border);background:white;color:var(--c-text-head);cursor:pointer;transition:all .2s;">
                <i class="fa-solid fa-graduation-cap"></i> Kategori Sekolah &amp; Hak Pilih
            </button>
            <button type="button" onclick="filterAgeGroup('all')" class="fs-age-tab" id="tab-all" style="padding:.5rem .95rem;border-radius:var(--r-md);font-size:.82rem;font-weight:600;border:1.5px solid var(--c-border);background:white;color:var(--c-text-head);cursor:pointer;transition:all .2s;">
                <i class="fa-solid fa-list-ul"></i> Semua Kategori (Lengkap)
            </button>
        </div>
    </div>
@endif

{{-- Highcharts Chart Card --}}
<div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;margin-bottom:2rem;box-shadow:var(--sh-sm);">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:1rem;">
        <h3 style="font-size:1.1rem;font-weight:700;color:var(--c-text-head);margin:0;display:flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-chart-column" style="color:var(--c-primary);"></i> Grafik Visualisasi {{ $heading }}
        </h3>
        
        <div class="btn-switch-chart" style="display:flex;gap:.5rem;flex-wrap:wrap;align-items:center;">
            <button type="button" onclick="switchChartType('column')" class="button-switch fs-btn-outline is-active" id="btn-chart-column" style="font-size:.78rem;padding:.35rem .75rem;">
                <i class="fa-solid fa-chart-column"></i> Grafik Batang
            </button>
            <button type="button" onclick="switchChartType('pie')" class="button-switch fs-btn-outline" id="btn-chart-pie" style="font-size:.78rem;padding:.35rem .75rem;">
                <i class="fa-solid fa-chart-pie"></i> Grafik Lingkaran
            </button>

            <a href="{{ ci_route("data-statistik.{$slug_aktif}.cetak.cetak") }}?tahun={{ $selected_tahun }}" 
               class="fs-btn-outline" target="_blank" title="Cetak Laporan" style="font-size:.78rem;padding:.35rem .75rem;">
                <i class="fa-solid fa-print"></i> Cetak
            </a>
            <a href="{{ ci_route("data-statistik.{$slug_aktif}.cetak.unduh") }}?tahun={{ $selected_tahun }}" 
               class="fs-btn-outline" target="_blank" title="Unduh Laporan" style="font-size:.78rem;padding:.35rem .75rem;">
                <i class="fa-solid fa-file-arrow-down"></i> Unduh
            </a>
        </div>
    </div>

    {{-- Highcharts Target Container --}}
    <div id="statistics" style="min-height:420px;width:100%;"></div>
</div>

{{-- Statistical Data Table Card --}}
<div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:.5rem;">
        <h3 style="font-size:1.1rem;font-weight:700;color:var(--c-text-head);margin:0;display:flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-table-list" style="color:var(--c-primary);"></i> Tabel Distribusi Data {{ $heading }}
        </h3>
    </div>

    <div style="overflow-x:auto;">
        <table class="fs-table" id="table-statistik" style="width:100%;border-collapse:collapse;font-size:.875rem;">
            <thead>
                <tr style="background:var(--c-primary-dark);color:white;">
                    <th rowspan="2" style="padding:.75rem .85rem;text-align:center;width:45px;border-top-left-radius:var(--r-sm);">No</th>
                    <th rowspan="2" style="padding:.75rem .85rem;text-align:left;">Kelompok Kategori</th>
                    <th colspan="2" style="padding:.5rem .85rem;text-align:center;border-bottom:1px solid rgba(255,255,255,0.2);">Jumlah Total</th>
                    <th colspan="2" style="padding:.5rem .85rem;text-align:center;border-bottom:1px solid rgba(255,255,255,0.2);">Laki-Laki</th>
                    <th colspan="2" style="padding:.5rem .85rem;text-align:center;border-bottom:1px solid rgba(255,255,255,0.2);border-top-right-radius:var(--r-sm);">Perempuan</th>
                </tr>
                <tr style="background:#0f4c25;color:white;font-size:.8rem;">
                    <th style="padding:.5rem .85rem;text-align:center;width:75px;">Jiwa</th>
                    <th style="padding:.5rem .85rem;text-align:center;width:65px;">%</th>
                    <th style="padding:.5rem .85rem;text-align:center;width:75px;">Jiwa</th>
                    <th style="padding:.5rem .85rem;text-align:center;width:65px;">%</th>
                    <th style="padding:.5rem .85rem;text-align:center;width:75px;">Jiwa</th>
                    <th style="padding:.5rem .85rem;text-align:center;width:65px;">%</th>
                </tr>
            </thead>
            <tbody style="color:var(--c-text-body);"></tbody>
        </table>
    </div>

    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1.25rem;padding-top:1rem;border-top:1px solid var(--c-border);flex-wrap:wrap;gap:.5rem;">
        <span style="font-size:.78rem;color:var(--c-text-muted);">
            <i class="fa-regular fa-clock"></i> Diperbarui pada: {{ tgl_indo($last_update ?? date('Y-m-d')) }}
        </span>
    </div>
</div>

<style>
.fs-table th, .fs-table td {
    padding: .7rem .85rem; border-bottom: 1px solid var(--c-border);
}
.fs-table tbody tr:hover { background: #f8fafc; }
.fs-table tr.total-row { background: var(--c-primary-bg); font-weight: 700; color: var(--c-primary-dark); }
.fs-age-tab.fs-tab-active {
    background: var(--c-primary) !important; color: white !important; border-color: var(--c-primary) !important;
}
</style>

@push('scripts')
<script type="text/javascript">
let dataStats = [];
let fullRawData = [];
let currentAgeGroupFilter = 'bps'; // Default to BPS 5-year groups
let currentChartType = 'column';

function filterAgeGroup(mode) {
    currentAgeGroupFilter = mode;

    $('.fs-age-tab').removeClass('fs-tab-active').css({'background':'white','color':'var(--c-text-head)','border-color':'var(--c-border)'});
    $('#tab-' + mode).addClass('fs-tab-active').css({'background':'var(--c-primary)','color':'white','border-color':'var(--c-primary)'});

    renderFilteredTableAndChart();
}

function switchChartType(type) {
    currentChartType = type;
    if (type === 'column') {
        $('#btn-chart-column').addClass('is-active');
        $('#btn-chart-pie').removeClass('is-active');
    } else {
        $('#btn-chart-pie').addClass('is-active');
        $('#btn-chart-column').removeClass('is-active');
    }
    renderChart();
}

function renderFilteredTableAndChart() {
    if (!fullRawData || fullRawData.length === 0) return;

    var filtered = fullRawData;
    var keyStr = '{{ $key ?? "" }}';
    var slugStr = '{{ $slug_aktif ?? "" }}';
    var isRentangUmur = (keyStr === '13' || keyStr === 'rentang-umur' || keyStr === 'rentang_umur' || slugStr === 'rentang-umur' || slugStr === '13');

    if (isRentangUmur) {
        if (currentAgeGroupFilter === 'bps') {
            // Tab 1: Standar 5-Tahun BPS (Items 0 to 13: 0 s/d 4 up to 70+ Tahun) + TOTAL
            filtered = fullRawData.filter(function(item, idx) {
                var isTotal = ['666', '777', '888'].includes(String(item.id)) || item.nama.toUpperCase().includes('TOTAL') || item.nama.toUpperCase().includes('JUMLAH');
                return (idx >= 0 && idx <= 13) || isTotal;
            });
        } else if (currentAgeGroupFilter === 'produktif') {
            // Tab 2: Usia Kerja & Lansia (ONLY 3 categories: 0-14, 15-56, 56+) + TOTAL
            filtered = fullRawData.filter(function(item) {
                var isTotal = ['666', '777', '888'].includes(String(item.id)) || item.nama.toUpperCase().includes('TOTAL') || item.nama.toUpperCase().includes('JUMLAH');
                var nama = item.nama;
                return (nama.includes('0 s/d 14') && !nama.includes('10')) || nama.includes('15 s/d 56') || nama.includes('56 s/d 200') || isTotal;
            });
        } else if (currentAgeGroupFilter === 'pendidikan') {
            // Tab 3: Kategori Sekolah & Hak Pilih (0-3, 3-6, 7-12, 13-15, 16-18, 17-150) + TOTAL
            filtered = fullRawData.filter(function(item) {
                var isTotal = ['666', '777', '888'].includes(String(item.id)) || item.nama.toUpperCase().includes('TOTAL') || item.nama.toUpperCase().includes('JUMLAH');
                var nama = item.nama;
                return nama.includes('0 s/d 3') || nama.includes('3 s/d 6') || nama.includes('7 s/d 12') || nama.includes('13 s/d 15') || nama.includes('16 s/d 18') || nama.includes('17 s/d 150') || isTotal;
            });
        }
    }

    dataStats = filtered;
    populateTable(filtered);
    renderChart();
}

function renderChart() {
    if (!dataStats || dataStats.length === 0) return;

    var categories = [];
    var seriesData = [];

    dataStats.forEach(function(stat) {
        var isTotal = ['666', '777', '888'].includes(String(stat.id)) || stat.nama.toUpperCase().includes('TOTAL') || stat.nama.toUpperCase().includes('JUMLAH');
        if (!isTotal) {
            categories.push(stat.nama);
            seriesData.push({
                name: stat.nama,
                y: parseInt(stat.jumlah, 10) || 0
            });
        }
    });

    if (typeof Highcharts !== 'undefined') {
        Highcharts.chart('statistics', {
            chart: {
                type: currentChartType,
                style: { fontFamily: 'Poppins, sans-serif' }
            },
            title: { text: null },
            xAxis: {
                categories: categories,
                labels: { style: { fontSize: '11px', color: '#475569' } }
            },
            yAxis: {
                min: 0,
                title: { text: 'Jumlah Populasi (Jiwa)', style: { color: '#475569' } }
            },
            tooltip: {
                pointFormat: '<b>{point.y} Jiwa</b> ({point.percentage:.1f}%)'
            },
            plotOptions: {
                column: { color: '#16803c', borderRadius: 4 },
                pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: true, format: '<b>{point.name}</b>: {point.y} Jiwa' } }
            },
            series: [{
                name: 'Jumlah Populasi',
                colorByPoint: (currentChartType === 'pie'),
                data: seriesData
            }],
            credits: { enabled: false }
        });
    }
}

function populateTable(list) {
    const table = document.getElementById('table-statistik');
    if (!table) return;
    const tbody = table.querySelector('tbody');
    tbody.innerHTML = '';

    list.forEach((item, index) => {
        const row = document.createElement('tr');
        var isTotal = ['666', '777', '888'].includes(String(item.id)) || item.nama.toUpperCase().includes('TOTAL') || item.nama.toUpperCase().includes('JUMLAH');
        
        if (isTotal) {
            row.className = 'total-row';
        }

        var noText = isTotal ? '' : (index + 1);

        row.innerHTML = `
            <td style="text-align:center;font-weight:${isTotal?'700':'400'};">${noText}</td>
            <td style="text-align:left;font-weight:${isTotal?'700':'500'};">${item.nama || '—'}</td>
            <td style="text-align:center;font-weight:${isTotal?'700':'600'};">${item.jumlah || 0}</td>
            <td style="text-align:center;">
                <div style="display:flex;align-items:center;justify-content:center;gap:.3rem;">
                    <span>${item.persen || 0}%</span>
                </div>
            </td>
            <td style="text-align:center;">${item.laki || 0}</td>
            <td style="text-align:center;">${item.persen1 || 0}%</td>
            <td style="text-align:center;">${item.perempuan || 0}</td>
            <td style="text-align:center;">${item.persen2 || 0}%</td>
        `;
        tbody.appendChild(row);
    });
}

$(function() {
    $.ajax({
        url: `{{ ci_route('internal_api.statistik', $key) }}?tahun={{ $selected_tahun ?? '' }}`,
        method: 'GET',
        success: function(json) {
            fullRawData = json.data.map(item => {
                const { id } = item;
                const { nama, jumlah, laki, perempuan, persen, persen1, persen2 } = item.attributes;
                return { id, nama, jumlah, persen, laki, persen1, perempuan, persen2 };
            });

            renderFilteredTableAndChart();
        }
    });

    $('#tahun').change(function() {
        const current_url = window.location.href.split('?')[0];
        window.location.href = `${current_url}?tahun=${$(this).val()}`;
    });
});
</script>
@endpush
