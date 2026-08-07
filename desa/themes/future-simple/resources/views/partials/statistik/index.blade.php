@extends('theme::template')
@include('theme::commons.asset_highcharts')

@section('layout')
<div class="fs-content-wrap" style="display:grid;grid-template-columns:280px 1fr;gap:2rem;margin:2rem 0;align-items:start;">
    {{-- Sidebar Navigation --}}
    <aside class="fs-sidebar">
        @include('theme::partials.statistik.sidenav')
    </aside>

    {{-- Main Statistics Area --}}
    <main class="fs-main-body">
        @include('theme::partials.statistik.default')
        <script>
            const enable3d = {{ setting('statistik_chart_3d') ? 1 : 0 }};
        </script>
    </main>
</div>
@endsection
