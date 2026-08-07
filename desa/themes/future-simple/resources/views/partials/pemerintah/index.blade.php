@extends('theme::layouts.full-content')

@section('content')
@php
    $pamongList = [];
    try {
        $pamongList = \Illuminate\Support\Facades\DB::table('tweb_desa_pamong')
            ->leftJoin('ref_jabatan', 'tweb_desa_pamong.jabatan_id', '=', 'ref_jabatan.id')
            ->where('tweb_desa_pamong.pamong_status', 1)
            ->select(
                'tweb_desa_pamong.*',
                'ref_jabatan.nama as nama_jabatan'
            )
            ->orderBy('tweb_desa_pamong.pamong_urutan', 'asc')
            ->get();
    } catch (\Throwable $e) {}
@endphp

<div class="fs-pemerintah-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span style="color:var(--c-text-muted);">Aparatur Desa</span>
        </div>
    </nav>

    {{-- Hero Header (Forest Green to Emerald Gradient Unique Identity) --}}
    <div style="background:linear-gradient(135deg, #064e3b 0%, #16803c 55%, #15803d 100%);color:#ffffff;padding:2.25rem 2.5rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-15px;bottom:-25px;font-size:10rem;color:rgba(255,255,255,0.06);pointer-events:none;">
            <i class="fa-solid fa-users-gear"></i>
        </div>
        <div style="position:relative;z-index:2;max-width:700px;">
            <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);color:#ffffff;font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-building-user" style="color:#a7f3d0;"></i> Struktur Kepemimpinan &amp; Tata Kelola
            </span>
            <h1 style="font-size:2rem;font-weight:800;margin-bottom:.5rem;line-height:1.2;color:#ffffff;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                Pemerintah &amp; Aparatur Desa
            </h1>
            <p style="font-size:.95rem;color:#f1f5f9;line-height:1.65;margin:0;font-weight:400;">
                Daftar perangkat desa, jajaran struktur organisasi, dan pimpinan {{ ucwords(setting('sebutan_desa')) }} {{ e($desa['nama_desa']) }} yang berdedikasi melayani masyarakat.
            </p>
        </div>
    </div>

    {{-- Pamong Cards Grid --}}
    @if ($pamongList && count($pamongList) > 0)
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(260px, 1fr));gap:1.5rem;margin-bottom:2.5rem;">
            @foreach ($pamongList as $p)
                @php
                    $fotoUrl = AmbilFoto($p->foto, 'kecil_', $p->pamong_sex ?? '1', LOKASI_USER_PICT);
                    $isKades = str_contains(strtolower($p->nama_jabatan ?? ''), 'kepala desa') || str_contains(strtolower($p->nama_jabatan ?? ''), 'kades');
                @endphp
                <div class="fs-pamong-card" style="background:white;border-radius:var(--r-lg);border:1.5px solid var(--c-border);overflow:hidden;box-shadow:var(--sh-sm);transition:transform .2s, box-shadow .2s, border-color .2s;text-align:center;position:relative;display:flex;flex-direction:column;">
                    
                    {{-- Badge Kades/Pamong --}}
                    <div style="position:absolute;top:10px;right:10px;z-index:2;">
                        @if ($isKades)
                            <span style="background:linear-gradient(135deg, #d97706, #b45309);color:white;font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:999px;box-shadow:0 2px 4px rgba(0,0,0,0.15);">
                                <i class="fa-solid fa-crown"></i> Kepala Desa
                            </span>
                        @else
                            <span style="background:var(--c-primary-bg);color:var(--c-primary-dark);font-size:.7rem;font-weight:700;padding:.2rem .6rem;border-radius:999px;">
                                Perangkat Desa
                            </span>
                        @endif
                    </div>

                    {{-- Foto Avatar Container --}}
                    <div style="padding:1.5rem 1rem 1rem;background:#f8fafc;display:flex;justify-content:center;align-items:center;border-bottom:1px solid var(--c-border);">
                        <div style="width:110px;height:110px;border-radius:50%;overflow:hidden;border:3px solid white;box-shadow:var(--sh-md);background:#e2e8f0;">
                            <img src="{{ $fotoUrl }}" alt="{{ $p->pamong_nama }}" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                    </div>

                    {{-- Info Text --}}
                    <div style="padding:1.25rem 1rem;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                        <div>
                            <h3 style="font-size:1.05rem;font-weight:700;color:var(--c-text-head);margin-bottom:.35rem;line-height:1.3;">
                                {{ $p->pamong_nama }}
                            </h3>
                            <div style="color:var(--c-primary-dark);font-weight:600;font-size:.85rem;margin-bottom:.6rem;background:var(--c-primary-bg);display:inline-block;padding:.2rem .75rem;border-radius:var(--r-sm);">
                                {{ $p->nama_jabatan ?? 'Aparatur Desa' }}
                            </div>
                        </div>

                        <div style="font-size:.78rem;color:var(--c-text-muted);border-top:1px dashed var(--c-border);padding-top:.75rem;margin-top:.75rem;display:flex;flex-direction:column;gap:.25rem;">
                            @if (!empty($p->pamong_niap))
                                <span><i class="fa-regular fa-id-card"></i> NIAP: <strong>{{ $p->pamong_niap }}</strong></span>
                            @endif
                            @if (!empty($p->pamong_nip))
                                <span><i class="fa-regular fa-id-card"></i> NIP: <strong>{{ $p->pamong_nip }}</strong></span>
                            @endif
                            <span style="color:#166534;font-weight:500;"><i class="fa-solid fa-circle-check"></i> Status: Aktif Melayani</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div style="background:white;padding:3rem 1.5rem;text-align:center;border-radius:var(--r-lg);border:1px dashed var(--c-border);color:var(--c-text-muted);">
            <i class="fa-solid fa-users" style="font-size:2.5rem;margin-bottom:.5rem;color:var(--c-primary);"></i>
            <p style="margin:0;font-weight:600;">Data aparatur desa tidak tersedia.</p>
        </div>
    @endif
</div>

<style>
.fs-pamong-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--sh-md) !important;
    border-color: var(--c-primary) !important;
}
</style>
@endsection
