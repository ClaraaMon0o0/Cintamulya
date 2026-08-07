@push('scripts')
<script>
if (typeof Highcharts === 'undefined') {
    var script1 = document.createElement('script'); script1.src = "{{ asset('js/highcharts/highcharts.js') }}"; document.head.appendChild(script1);
    var script2 = document.createElement('script'); script2.src = "{{ asset('js/highcharts/highcharts-3d.js') }}"; document.head.appendChild(script2);
}
</script>
<script>
    if (typeof Highcharts !== 'undefined') {
        Highcharts.setOptions({
            lang: { thousandsSep: '.' }
        });
    }
</script>
@endpush
