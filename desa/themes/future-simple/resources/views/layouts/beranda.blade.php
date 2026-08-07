{{--
|--------------------------------------------------------------------------
| Layout Beranda — Futuristic Simplism
| Full-width above-the-fold + content (tanpa sidebar kecuali desktop)
|--------------------------------------------------------------------------
--}}

@extends('theme::template')

@section('layout')
    {{-- Slot full-width: hero, pills, IDM stats, APBDes --}}
    @yield('above_the_fold')

    {{-- Wrapper konten artikel --}}
    <div style="min-height:20vh;">
        @yield('content')
    </div>
@endsection
