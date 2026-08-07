@extends('theme::layouts.full-content')
@include('theme::commons.asset_sweetalert')

@section('content')
<div class="fs-infopublik-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span>Informasi Publik</span>
        </div>
    </nav>

    {{-- Hero Header --}}
    <div style="background:linear-gradient(135deg,#164e63 0%,#0e7490 55%,#06b6d4 100%);color:#fff;padding:2.25rem 2.5rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-10px;bottom:-20px;font-size:10rem;color:rgba(255,255,255,0.05);pointer-events:none;"><i class="fa-solid fa-landmark"></i></div>
        <div style="position:relative;z-index:2;max-width:700px;">
            <span style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);font-size:.75rem;font-weight:600;padding:.25rem .75rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.75rem;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-shield-halved" style="color:#a5f3fc;"></i> Daftar Informasi Publik (DIP)
            </span>
            <h1 style="font-size:2rem;font-weight:800;margin-bottom:.5rem;line-height:1.2;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                Informasi Publik Desa {{ e($desa['nama_desa']) }}
            </h1>
            <p style="font-size:.95rem;color:#cffafe;line-height:1.65;margin:0;">
                Dokumen informasi berkala dan serta merta yang wajib tersedia sesuai UU Keterbukaan Informasi Publik (KIP) No. 14/2008.
            </p>
        </div>
    </div>

    {{-- Table Card --}}
    <div style="background:white;border-radius:var(--r-lg);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);">
        <h3 style="font-size:1rem;font-weight:700;color:var(--c-text-head);margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-folder-open" style="color:var(--c-primary);"></i> Daftar Dokumen Informasi Publik
        </h3>
        <div style="overflow-x:auto;">
            <table class="fs-table" id="tabelData" style="width:100%;border-collapse:collapse;font-size:.83rem;">
                <thead>
                    <tr style="background:linear-gradient(135deg,#164e63,#0e7490);color:white;">
                        <th style="padding:.75rem .85rem;text-align:center;width:50px;">No</th>
                        <th style="padding:.75rem .85rem;text-align:left;">Judul Informasi</th>
                        <th style="padding:.75rem .85rem;text-align:center;width:75px;">Tahun</th>
                        <th style="padding:.75rem .85rem;text-align:left;">Kategori</th>
                        <th style="padding:.75rem .85rem;text-align:center;width:110px;">Tanggal Upload</th>
                        <th style="padding:.75rem .85rem;text-align:center;width:80px;">Aksi</th>
                    </tr>
                </thead>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>

<style>
.fs-table th, .fs-table td { padding:.65rem .85rem; border-bottom:1px solid var(--c-border); }
.fs-table tbody tr:hover { background:#f0fdff; }
</style>

@push('scripts')
<script>
$(document).ready(function() {
    var tabelData = $('#tabelData').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        ordering: true,
        language: { search: 'Cari:', lengthMenu: 'Tampil _MENU_ data', zeroRecords: 'Tidak ada dokumen informasi publik.', info: 'Halaman _PAGE_ dari _PAGES_', infoEmpty: '', paginate: { first: '&laquo;', previous: '&lsaquo;', next: '&rsaquo;', last: '&raquo;' } },
        ajax: {
            url: '{{ route('api.informasi-publik') }}',
            method: 'GET',
            data: row => ({
                'page[size]': row.length,
                'page[number]': (row.start / row.length) + 1,
                'filter[search]': row.search.value,
                'sort': (row.order[0]?.dir === 'asc' ? '' : '-') + (row.columns[row.order[0]?.column]?.name || 'tgl_upload')
            }),
            dataSrc: function(json) {
                json.recordsTotal = json.meta.pagination.total;
                json.recordsFiltered = json.meta.pagination.total;
                return json.data;
            }
        },
        columns: [
            { data: null, searchable: false, orderable: false, className: 'text-center', render: (d, t, r, m) => m.row + m.settings._iDisplayStart + 1 },
            { data: 'nama', name: 'nama', render: (d, t, r) => `<span style="font-weight:600;color:var(--c-text-head);">${r.attributes.nama}</span>` },
            { data: 'tahun', name: 'tahun', className: 'text-center', render: (d, t, r) => `<strong>${r.attributes.tahun || '-'}</strong>` },
            { data: 'kategori', name: 'kategori', render: (d, t, r) => `<span style="background:#cffafe;color:#164e63;font-size:.75rem;padding:.15rem .5rem;border-radius:999px;font-weight:600;">${r.attributes.kategori || '-'}</span>` },
            { data: 'tgl_upload', name: 'tgl_upload', className: 'text-center', render: (d, t, r) => r.attributes.tgl_upload || '-' },
            {
                data: null, searchable: false, orderable: false, className: 'text-center',
                render: (d, t, r) => (r.attributes.satuan || r.attributes.url)
                    ? `<button class="lihat-dokumen" data-nama="${r.attributes.nama}" data-url="${r.attributes.url||''}" data-file="${r.attributes.satuan||''}" style="padding:.3rem .7rem;background:var(--c-primary);color:white;border:none;border-radius:var(--r-sm);font-size:.75rem;cursor:pointer;font-weight:600;"><i class="fa-solid fa-file" style="margin-right:.3rem;"></i>Lihat</button>`
                    : `<span style="color:var(--c-text-muted);font-size:.75rem;">-</span>`
            }
        ],
        order: [[4, 'desc']]
    });

    $(document).on('click', '.lihat-dokumen', function() {
        var nama = $(this).data('nama');
        var file = $(this).data('file') || $(this).data('url');
        if (!file) { Swal.fire('Tidak Ada File', 'Dokumen belum tersedia.', 'warning'); return; }
        var slug = nama.toLowerCase().replace(/ /g,'-').replace(/[^\w-]+/g,'');
        Swal.fire({
            title: `<h4 style="font-size:1rem;">${nama}</h4>`,
            html: `<div style="display:flex;flex-direction:column;align-items:center;gap:1rem;">
                <iframe src="${file}" style="width:100%;min-height:420px;border:1px solid #e2e8f0;border-radius:8px;"></iframe>
                <button class="unduh-dokumen" data-nama="${slug}" data-file="${file}" style="padding:.5rem 1.25rem;background:var(--c-primary);color:white;border:none;border-radius:8px;cursor:pointer;font-weight:600;">
                    <i class="fa-solid fa-download" style="margin-right:.4rem;"></i>Unduh File
                </button></div>`,
            width: '65%', showCloseButton: true, showConfirmButton: false,
            didOpen: () => {
                $('.unduh-dokumen').on('click', function() {
                    var f = $(this).data('file'); var n = $(this).data('nama');
                    if (f.includes('drive.google.com')) {
                        var id = f.includes('/d/') ? f.split('/d/')[1].split('/')[0] : new URLSearchParams(new URL(f).search).get('id');
                        if (id) f = 'https://drive.google.com/uc?export=download&id='+id;
                    }
                    $('<a>').attr({href:f,download:n}).appendTo('body')[0].click();
                    $('a[download]').remove();
                });
            }
        });
    });
});
</script>
@endpush
@endsection
