@if (!empty($widget_keuangan['tahun']) && !is_null($widget_keuangan['tahun']))
    @include('theme::commons.asset_highcharts')

    <div class="box" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.25rem;margin-bottom:1.5rem;box-shadow:var(--sh-sm);">
        <div class="box-header" style="margin-bottom:.85rem;border-bottom:2px solid var(--c-primary-light);padding-bottom:.5rem;display:flex;align-items:center;justify-content:space-between;">
            <h3 class="box-title" style="font-size:1rem;font-weight:700;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;margin:0;">
                <i class="fa-solid fa-chart-pie" style="color:var(--c-primary);"></i> Keuangan APBDes
            </h3>
            @if(!empty($widget_keuangan['tahun_terbaru']))
                <span style="font-size:.75rem;background:var(--c-primary-light);color:var(--c-primary-dark);padding:.15rem .5rem;border-radius:var(--r-pill);font-weight:600;">
                    Tahun {{ $widget_keuangan['tahun_terbaru'] }}
                </span>
            @endif
        </div>
        <div class="box-body">
            {{-- Filter Nav Tabs --}}
            <div style="display:flex;gap:.35rem;margin-bottom:1rem;background:#f8fafc;padding:.3rem;border-radius:var(--r-sm);border:1px solid var(--c-border);">
                <button type="button" class="btn-apbdes-tab active" onclick="switchApbdesTab('pelaksanaan', this)" style="flex:1;padding:.35rem .4rem;font-size:.73rem;font-weight:600;border:none;border-radius:var(--r-sm);cursor:pointer;background:var(--c-primary);color:white;">Pelaksanaan</button>
                <button type="button" class="btn-apbdes-tab" onclick="switchApbdesTab('pendapatan', this)" style="flex:1;padding:.35rem .4rem;font-size:.73rem;font-weight:600;border:none;border-radius:var(--r-sm);cursor:pointer;background:transparent;color:var(--c-text-muted);">Pendapatan</button>
                <button type="button" class="btn-apbdes-tab" onclick="switchApbdesTab('belanja', this)" style="flex:1;padding:.35rem .4rem;font-size:.73rem;font-weight:600;border:none;border-radius:var(--r-sm);cursor:pointer;background:transparent;color:var(--c-text-muted);">Belanja</button>
            </div>

            <div id="widget-keuangan-container">
                <div id="grafik-container"></div>
            </div>
        </div>
    </div>

    <style>
    .graph-sub { font-size:.76rem; font-weight:700; color:var(--c-text-head); margin-top:.75rem; margin-bottom:.25rem; }
    .graph-not-available { font-size:.75rem; color:var(--c-text-muted); font-style:italic; padding:.4rem 0; }
    </style>

    <script type="text/javascript">
        var rawData = {!! $widget_keuangan['data'] !!};
        var year = "{{ $widget_keuangan['tahun_terbaru'] }}";
        let tipe = "pelaksanaan";

        function switchApbdesTab(newType, btn) {
            $('.btn-apbdes-tab').css({'background':'transparent','color':'var(--c-text-muted)'});
            $(btn).css({'background':'var(--c-primary)','color':'white'});
            tipe = newType;
            displayChart(year, tipe);
        }

        function displayChart(tahun, tipe) {
            resetContainer();
            var tipeGrafik = 'res_pelaksanaan';
            if (tipe === 'belanja') tipeGrafik = 'res_belanja';
            if (tipe === 'pendapatan') tipeGrafik = 'res_pendapatan';

            var chartData = (rawData[tahun] && rawData[tahun][tipeGrafik]) ? rawData[tahun][tipeGrafik] : [];

            if (!chartData || !chartData.length) {
                $("#grafik-container").html("<div style='text-align:center;padding:1.5rem 0;color:var(--c-text-muted);font-size:.82rem;'><i class='fa-solid fa-file-invoice-dollar' style='font-size:1.8rem;display:block;margin-bottom:.4rem;opacity:.4;'></i>Data grafik Keuangan APBDes belum diisi untuk tahun " + tahun + ".</div>");
                return;
            }

            $("#grafik-container").append("<div id='graph-legend' class='graph' style='margin-bottom:.5rem;'></div>");
            Highcharts.chart("graph-legend", {
                chart: { type: 'bar', margin: 0, backgroundColor: "rgba(0,0,0,0)", height: 24 },
                title: { text: '' },
                subtitle: { text: '' },
                xAxis: { visible: false, categories: [''] },
                tooltip: { valueSuffix: '' },
                plotOptions: { bar: { dataLabels: { enabled: true } }, series: { pointPadding: 0, groupPadding: 0, grouping: false } },
                credits: { enabled: false },
                yAxis: { visible: false },
                exporting: { enabled: false },
                legend: { padding: 0, margin: 0, verticalAlign: 'middle', maxHeight: 50 },
                series: [
                    { name: 'Anggaran', color: '#3b82f6', data: [] },
                    { name: 'Realisasi', color: '#22c55e', data: [] }
                ]
            });

            chartData.forEach(function(subData, idx) {
                if (subData['nama']) {
                    var ang = parseInt(subData['anggaran']) || 0;
                    var rea = parseInt(subData['realisasi']) || 0;

                    if (ang === 0 && rea === 0) {
                        $("#grafik-container").append("<div class='graph-sub'>" + subData['nama'] + "</div><div class='graph-not-available'>Anggaran & Realisasi Rp 0</div>");
                    } else {
                        var persentase = (rea / (ang || 1)) * 100;
                        persentase = Math.round(persentase);
                        $("#grafik-container").append("<div class='graph-sub'>" + subData['nama'] + "</div><div id='graph-" + idx + "' class='graph'></div>");

                        Highcharts.chart("graph-" + idx, {
                            chart: { type: 'bar', margin: 0, height: 22, backgroundColor: "rgba(0,0,0,0)" },
                            title: { text: '' },
                            subtitle: { text: '' },
                            xAxis: { visible: false, categories: [''] },
                            tooltip: { valueSuffix: '', backgroundColor: "#fff", hideDelay: 0, shape: "square", outside: true },
                            plotOptions: { bar: { dataLabels: { enabled: true } }, series: { pointPadding: 0, groupPadding: 0, grouping: false } },
                            credits: { enabled: false },
                            yAxis: { visible: false },
                            exporting: { enabled: false },
                            legend: { enabled: false },
                            series: [
                                {
                                    name: 'Anggaran', color: '#3b82f6', data: [ang],
                                    dataLabels: {
                                        formatter: function() { return "Rp " + Highcharts.numberFormat(ang, 0, ',', '.'); },
                                        style: { "textOutline": "1px contrast", "fontSize": "10px" }
                                    }
                                },
                                {
                                    name: 'Realisasi', color: '#22c55e', data: [rea],
                                    dataLabels: {
                                        formatter: function() { return persentase + "%"; },
                                        style: { "textOutline": "1px contrast", "fontSize": "10px" }
                                    }
                                }
                            ]
                        });
                    }
                }
            });
        }

        function resetContainer() { $("#grafik-container").html(""); }

        $(document).ready(function() {
            displayChart(year, tipe);
        });
    </script>
@endif
