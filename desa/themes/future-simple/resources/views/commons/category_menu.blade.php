@php
    $alt_slug = defined('PREMIUM') && PREMIUM ? 'artikel' : 'first';
@endphp

<style>
    .cm-cat-nav, .cm-cat-nav *, .cm-cat-nav a {
        white-space: nowrap !important;
        word-break: normal !important;
        word-wrap: normal !important;
    }
    .cm-cat-nav a {
        display: inline-block !important;
        width: auto !important;
        max-width: none !important;
    }
</style>

<section x-data="{ catMenu: false }">
    <button type="button" class="lg:hidden inline-block py-4 px-6 z-10 relative" @click="catMenu = !catMenu">
        <i class="fa fa-list fa-lg"></i>
    </button>

    <div x-show="catMenu" x-on:click="catMenu = false" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50 z-30 backdrop-blur-sm"></div>

    <div class="lg:py-3 px-3 lg:block transform transition-transform duration-300 lg:visible z-40"
        :class="{ 'bg-white text-gray-700 w-3/4 shadow fixed top-0 left-0 h-screen block inset-0 overflow-y-auto opacity-100 visible': catMenu, 'bg-white lg:bg-transparent fixed lg:relative -translate-x-full h-screen lg:h-auto lg:translate-x-0 opacity-0 lg:opacity-100': !catMenu }"
        x-transitionx-on:click.stop x-trap.noscroll.inert="catMenu"
    >

        <h5 class="text-h5 pt-5 pb-3 px-3 lg:hidden">Menu Kategori</h5>
        <div class="flex lg:flex-row flex-col justify-between items-center relative z-10 gap-4 px-2 py-1 cm-cat-nav">
            <div class="flex items-center gap-6 w-full lg:w-auto my-auto">
                <a href="{{ site_url('/') }}" class="flex items-center hover:opacity-90 transition-opacity shrink-0 my-auto">
                    <img src="{{ gambar_desa($desa['logo'] ?? null) }}" alt="Logo {{ $desa['nama_desa'] ?? '' }}" class="h-12 lg:h-14 w-auto object-contain my-auto">
                </a>
                <ul class="text-sm flex flex-row items-center flex-nowrap gap-3 my-auto">
                @foreach ($menu_kiri as $menu)
                    <li class="inline-block shrink-0">
                        <a href="{{ site_url("{$alt_slug}/kategori/{$menu['slug']}") }}" class="inline-block py-2 px-3 hover:text-link text-white font-semibold">
                            {{ $menu['kategori'] }}
                        </a>
                    </li>
                    @if (count($menu['submenu'] ?? []) > 0)
                        @foreach ($menu['submenu'] as $submenu)
                            <li class="inline-block shrink-0">
                                <a href="{{ site_url("{$alt_slug}/kategori/{$submenu['slug']}") }}" class="inline-block py-2 px-3 hover:text-link text-white font-semibold">
                                    {{ $submenu['kategori'] }}
                                </a>
                            </li>
                        @endforeach
                    @endif
                @endforeach
            </ul>
            </div>

            <div class="flex flex-col lg:flex-row gap-3 mt-5 lg:mt-0 flex-wrap lg:justify-end shrink-0 px-3">
                @if (setting('layanan_mandiri') == 1)
                    <a href="{{ site_url('layanan-mandiri') }}" class="btn btn-primary text-sm w-full lg:w-auto text-center">Layanan
                        Mandiri <i class="fas fa-external-link-alt ml-1"></i></a>
                @endif
                <a href="{{ site_url('siteman') }}" class="btn btn-accent text-sm w-full lg:w-auto text-center">Login Admin <i class="fas fa-external-link-alt ml-1"></i></a>
            </div>
        </div>
    </div>

</section>
