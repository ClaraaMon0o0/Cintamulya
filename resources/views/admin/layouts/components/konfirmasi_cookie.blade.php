<div class="modal fade" id="konfirmasi-cookie" tabindex="-1" role="dialog" aria-labelledby="cookieModalLabel" aria-hidden="true" style="z-index:99999;">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px;margin:30px auto;">
        <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 20px 40px rgba(0,0,0,0.25);overflow:hidden;font-family:'Poppins',sans-serif;">
            <div class="modal-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;padding:1.1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;">
                <h4 class="modal-title" id="cookieModalLabel" style="font-size:1.05rem;font-weight:700;color:#0f172a;margin:0;display:flex;align-items:center;gap:.5rem;">
                    <i class="fa-solid fa-cookie-bite" style="color:#16803c;"></i> Privasi & Cookie
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size:1.4rem;opacity:.5;border:none;background:transparent;cursor:pointer;">&times;</button>
            </div>
            <div class="modal-body" style="padding:1.5rem;color:#334155;font-size:.88rem;line-height:1.6;">
                <div>
                    Dengan mengklik <strong>"Terima Semua Cookie"</strong>, Anda menyetujui bahwa sistem OpenSID dapat menyimpan cookie di perangkat Anda untuk meningkatkan pengalaman akses layanan digital desa.
                </div>
            </div>
            <div class="modal-footer" style="background:#ffffff;border-top:1px solid #f1f5f9;padding:1rem 1.5rem;display:flex;gap:.75rem;justify-content:flex-end;margin:0;">
                <button type="button" class="btn" onclick="rejectCookie()" style="background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;border-radius:8px;padding:.55rem 1.1rem;font-size:.84rem;font-weight:600;cursor:pointer;">
                    Tolak
                </button>
                <button type="button" class="btn" onclick="buatPengunjungCookie('<?= $cookie_name ?>')" style="background:#16803c;color:#ffffff;border:none;border-radius:8px;padding:.55rem 1.25rem;font-size:.84rem;font-weight:700;box-shadow:0 4px 12px rgba(22,128,60,0.25);cursor:pointer;">
                    <i class="fa-solid fa-check mr-1"></i> Terima Semua Cookie
                </button>
            </div>
        </div>
    </div>
</div>
