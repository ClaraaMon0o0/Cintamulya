@extends('theme::template')

@section('layout')
<div style="background:var(--c-bg);padding:2rem 0;min-height:60vh;">
    <div class="fs-container">
        <div class="fs-content-wrap">
            <div class="fs-main-panel">
                @yield('content')
            </div>
            <aside class="fs-sidebar">
                @include('theme::partials.sidebar')
            </aside>
        </div>
    </div>
</div>
@endsection
