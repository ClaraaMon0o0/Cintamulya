<div class="modal fade" id="aktifkan-cookie" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true" style="z-index:99999;">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;margin:30px auto;">
        <div class="modal-content" style="border:none;border-radius:16px;box-shadow:0 20px 40px rgba(0,0,0,0.25);overflow:hidden;font-family:'Poppins',sans-serif;">
            <div class="modal-header" style="background:#fffbe0;border-bottom:1px solid #fef08a;padding:1.1rem 1.5rem;display:flex;align-items:center;justify-content:space-between;">
                <h4 class="modal-title" id="warningModalLabel" style="font-size:1.05rem;font-weight:700;color:#854d0e;margin:0;display:flex;align-items:center;gap:.5rem;">
                    <i class="fa-solid fa-triangle-exclamation" style="color:#ca8a04;"></i> Akses Cookie Diperlukan
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-size:1.4rem;opacity:.5;border:none;background:transparent;cursor:pointer;">&times;</button>
            </div>
            <div class="modal-body" style="padding:1.5rem;color:#334155;font-size:.88rem;line-height:1.6;">
                <div>Perambah web Anda tidak mengizinkan akses cookie. Silakan aktifkan izin cookie untuk alamat <strong><?= site_url() ?></strong> agar layanan berjalan lancar.</div>
            </div>
            <div class="modal-footer" style="background:#ffffff;border-top:1px solid #f1f5f9;padding:.85rem 1.5rem;display:flex;justify-content:flex-end;margin:0;">
                <button type="button" class="btn" data-dismiss="modal" style="background:#16803c;color:#ffffff;border:none;border-radius:8px;padding:.5rem 1.25rem;font-size:.84rem;font-weight:700;cursor:pointer;">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>
</div>
