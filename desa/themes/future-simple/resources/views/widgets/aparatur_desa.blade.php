<div class="box" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.25rem;margin-bottom:1.5rem;box-shadow:var(--sh-sm);">
    <div class="box-header" style="margin-bottom:1rem;border-bottom:2px solid var(--c-primary-light);padding-bottom:.5rem;">
        <h3 class="box-title" style="font-size:1rem;font-weight:700;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;">
            <i class="fa-solid fa-users" style="color:var(--c-primary);"></i> {{ $judul_widget }}
        </h3>
    </div>
    <div class="box-body">
        <div class="owl-carousel owl-theme">
            @foreach ($aparatur_desa['daftar_perangkat'] as $data)
                <div style="text-align:center;padding:.5rem;">
                    <div style="width:140px;height:170px;margin:0 auto 1rem;border-radius:var(--r-md);overflow:hidden;box-shadow:var(--sh-sm);border:2px solid var(--c-primary-light);">
                        <img src="{{ $data['foto'] }}" alt="{{ $data['nama'] }}" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    @if (getWidgetSetting('aparatur_desa', 'overlay') == true)
                        <div>
                            <strong style="display:block;font-size:.9rem;color:var(--c-text-head);margin-bottom:.2rem;">{{ $data['nama'] }}</strong>
                            <span style="display:block;font-size:.78rem;color:var(--c-primary);font-weight:600;margin-bottom:.35rem;">{{ $data['jabatan'] }}</span>
                            @if ($data['pamong_niap'])
                                <span style="display:block;font-size:.72rem;color:var(--c-text-muted);">{{ setting('sebutan_nip_desa') }} : {{ $data['pamong_niap'] }}</span>
                            @endif
                            @if ($tampilkan_status_kehadiran)
                                @if ($data['kehadiran'] == 1)
                                    @if ($data['status_kehadiran'] == 'hadir')
                                        <span style="display:inline-block;margin-top:.4rem;font-size:.72rem;background:#dcfce7;color:#166534;padding:.15rem .6rem;border-radius:var(--r-pill);font-weight:600;">Hadir</span>
                                    @elseif ($data['tanggal'] == date('Y-m-d'))
                                        <span style="display:inline-block;margin-top:.4rem;font-size:.72rem;background:#fee2e2;color:#991b1b;padding:.15rem .6rem;border-radius:var(--r-pill);font-weight:600;">{{ ucwords($data['status_kehadiran']) }}</span>
                                    @else
                                        <span style="display:inline-block;margin-top:.4rem;font-size:.72rem;background:#fee2e2;color:#991b1b;padding:.15rem .6rem;border-radius:var(--r-pill);font-weight:600;">Belum Rekam Kehadiran</span>
                                    @endif
                                @endif
                            @else
                                <span style="display:inline-block;margin-top:.4rem;font-size:.72rem;background:#f3f4f6;color:var(--c-text-muted);padding:.15rem .6rem;border-radius:var(--r-pill);font-weight:500;">Hari Libur</span>
                            @endif
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
