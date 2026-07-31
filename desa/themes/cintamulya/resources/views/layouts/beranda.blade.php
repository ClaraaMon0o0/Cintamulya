{{--
|--------------------------------------------------------------------------
| Layout Beranda — varian right-sidebar + slot full-width above-the-fold
|--------------------------------------------------------------------------
| Sama seperti layouts/right-sidebar.blade.php, hanya menambah satu slot
| @yield('above_the_fold') yang dirender FULL WIDTH dan LEBIH DULU dari
| aliran artikel + sidebar.
|
| Urutan render inilah yang menentukan performa terasa: hero & CTA berada
| paling awal di DOM, sementara sidebar (widget peta, grafik keuangan,
| galeri — bagian termahal) berada di akhir dokumen.
--}}

@extends('theme::template')

@section('layout')
    {{-- Slot prioritas: hero, aksi cepat, potensi, statistik penduduk --}}
    @yield('above_the_fold')

    <div class="container mx-auto lg:px-5 px-3 flex flex-col lg:flex-row my-5 gap-3 lg:gap-5 justify-between text-gray-600">
        {{-- Konten utama --}}
        <main id="konten" class="lg:w-2/3 w-full bg-white rounded-lg px-4 py-2 lg:py-4 lg:px-5 shadow">
            @yield('content')
        </main>

        {{-- Widget bawaan OpenSID (below-the-fold) --}}
        <div class="lg:w-1/3 w-full">
            @include('theme::partials.sidebar')
        </div>
    </div>
@endsection
