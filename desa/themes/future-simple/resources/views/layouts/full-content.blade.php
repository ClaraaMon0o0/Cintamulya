@extends('theme::template')

@section('layout')
<div style="background:var(--c-bg);padding:2rem 0;min-height:60vh;">
    <div class="fs-container">
        <div class="fs-main-panel">
            @yield('content')
        </div>
    </div>
</div>
@endsection
