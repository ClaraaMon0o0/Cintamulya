<aside class="fs-sidebar" role="complementary">
    <div class="fs-sidebar-widget">
        <form action="{{ site_url('/') }}" role="search" style="position:relative;">
            <i class="fa-solid fa-search" style="position:absolute;top:50%;left:.85rem;transform:translateY(-50%);color:var(--c-text-muted);font-size:.85rem;"></i>
            <input type="text" name="cari"
                   style="width:100%;padding:.55rem .85rem .55rem 2.25rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;background:var(--c-white);outline:none;transition:border-color .2s;"
                   placeholder="Cari artikel..."
                   onfocus="this.style.borderColor='var(--c-primary)'"
                   onblur="this.style.borderColor='var(--c-border)'">
        </form>
    </div>

    @if ($widgetAktif)
        @foreach ($widgetAktif as $widget)
            @php
                $judul_widget = [
                    'judul_widget' => str_replace('Desa', ucwords(setting('sebutan_desa')), strip_tags($widget['judul'])),
                ];
            @endphp
            <div class="fs-sidebar-widget">
                @includeIf("theme::widgets.{$widget['isi']}", $judul_widget)
            </div>
        @endforeach
    @endif
</aside>
