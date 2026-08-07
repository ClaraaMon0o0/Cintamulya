<div class="box" style="background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.25rem;margin-bottom:1.5rem;box-shadow:var(--sh-sm);">
    <div class="box-header" style="margin-bottom:1rem;border-bottom:2px solid var(--c-primary-light);padding-bottom:.5rem;">
        <h3 class="box-title" style="font-size:1rem;font-weight:700;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;">
            <i class="fa-solid fa-chart-line" style="color:var(--c-primary);"></i> {{ $judul_widget }}
        </h3>
    </div>
    <div class="box-body">
        <table style="width:100%;border-collapse:collapse;font-size:.85rem;color:var(--c-text-body);">
            <tr style="border-bottom:1px solid var(--c-border);">
                <td style="padding:.5rem 0;color:var(--c-text-muted);">Hari Ini</td>
                <td style="padding:.5rem 0;text-align:right;font-weight:700;color:var(--c-text-head);">
                    {{ number_format($statistik_pengunjung['hari_ini'] ?? 0) }}
                </td>
            </tr>
            <tr style="border-bottom:1px solid var(--c-border);">
                <td style="padding:.5rem 0;color:var(--c-text-muted);">Kemarin</td>
                <td style="padding:.5rem 0;text-align:right;font-weight:700;color:var(--c-text-head);">
                    {{ number_format($statistik_pengunjung['kemarin'] ?? 0) }}
                </td>
            </tr>
            <tr>
                <td style="padding:.5rem 0;color:var(--c-text-head);font-weight:600;">Jumlah Pengunjung</td>
                <td style="padding:.5rem 0;text-align:right;font-weight:800;color:var(--c-primary-dark);font-size:.95rem;">
                    {{ number_format($statistik_pengunjung['total'] ?? 0) }}
                </td>
            </tr>
        </table>
    </div>
</div>
