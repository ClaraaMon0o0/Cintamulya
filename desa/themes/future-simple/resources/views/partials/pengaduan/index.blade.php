@extends('theme::layouts.full-content')

@section('content')
<div class="fs-pengaduan-wrap">
    {{-- Breadcrumb --}}
    <nav aria-label="Breadcrumb" style="margin-bottom:1.25rem;">
        <div class="fs-breadcrumb" style="color:var(--c-text-muted);font-size:.82rem;display:flex;align-items:center;gap:.4rem;">
            <a href="{{ site_url() }}" style="color:var(--c-primary);font-weight:500;">Beranda</a>
            <i class="fa-solid fa-angle-right" style="font-size:.7rem;opacity:.6;"></i>
            <span style="color:var(--c-text-muted);">Pengaduan Online</span>
        </div>
    </nav>

    {{-- Hero Header (Vibrant Forest Gradient & Crisp White Typography) --}}
    <div style="background:linear-gradient(135deg, #064e3b 0%, #16803c 60%, #059669 100%);color:#ffffff;padding:2.25rem 2.5rem;border-radius:var(--r-lg);margin-bottom:2rem;box-shadow:var(--sh-md);position:relative;overflow:hidden;">
        <div style="position:absolute;right:-20px;bottom:-30px;font-size:12rem;color:rgba(255,255,255,0.05);pointer-events:none;">
            <i class="fa-solid fa-comments"></i>
        </div>
        <div style="max-width:700px;position:relative;z-index:2;">
            <span style="background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.3);color:#ffffff;font-size:.75rem;font-weight:600;padding:.3rem .85rem;border-radius:999px;display:inline-flex;align-items:center;gap:.4rem;margin-bottom:.85rem;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-shield-halved" style="color:#a7f3d0;"></i> Layanan Pengaduan &amp; Aspirasi Publik
            </span>
            <h1 style="font-size:2rem;font-weight:800;margin-bottom:.65rem;line-height:1.2;color:#ffffff;letter-spacing:-0.01em;text-shadow:0 2px 4px rgba(0,0,0,0.15);">
                Layanan Pengaduan Warga
            </h1>
            <p style="font-size:.95rem;color:#f1f5f9;line-height:1.65;margin:0;font-weight:400;">
                Sampaikan laporan, kendala fasilitas, atau aspirasi Anda secara online. Pemerintah Desa {{ ucwords($desa['nama_desa'] ?? 'Cinta Mulya') }} berkomitmen memproses setiap laporan secara cepat, terukur, dan akuntabel.
            </p>
        </div>
    </div>

    {{-- Ethics & Privacy Guarantee Banner --}}
    <div style="background:#f0fdf4;border:1.5px solid #bbf7d0;padding:1rem 1.25rem;border-radius:var(--r-md);margin-bottom:1.5rem;display:flex;align-items:center;gap:.85rem;">
        <div style="width:38px;height:38px;border-radius:50%;background:#16803c;color:white;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <div style="font-size:.85rem;color:#166534;line-height:1.5;">
            <strong>Jaminan Kerahasiaan &amp; Etika Publik:</strong> Identitas pelapor (NIK, No. HP, Email) <u>selalu dilindungi dan dirahasiakan</u>. Pada daftar publik di bawah, nama warga disamarkan (contoh: <em>Sdr. M***</em>) demi menjaga privasi dan keamanan Anda.
        </div>
    </div>

    {{-- Notification Alert --}}
    @include('theme::commons.notifikasi')

    {{-- Action Bar --}}
    <div style="display:flex;flex-wrap:wrap;gap:1rem;align-items:center;justify-content:space-between;margin-bottom:1.75rem;background:white;padding:1.25rem 1.5rem;border-radius:var(--r-md);border:1px solid var(--c-border);box-shadow:var(--sh-sm);">
        <button type="button" onclick="openModal('newpengaduan')" class="fs-btn-primary" id="btn-open-pengaduan">
            <i class="fa-solid fa-plus-circle"></i> Buat Pengaduan Baru
        </button>

        <div style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:center;flex:1;max-width:550px;justify-content:flex-end;">
            <select id="caristatus" name="caristatus" onchange="loadPengaduanData(1)"
                    style="padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;background:white;color:var(--c-text-body);outline:none;">
                <option value="">Semua Status</option>
                <option value="1">⏳ Menunggu Diproses</option>
                <option value="2">⚙️ Sedang Diproses</option>
                <option value="3">✅ Selesai Diproses</option>
            </select>

            <div style="position:relative;flex:1;min-width:200px;">
                <input type="text" name="cari-pengaduan" id="cari-pengaduan" placeholder="Cari pengaduan..."
                       onkeyup="if(event.key==='Enter') loadPengaduanData(1)"
                       style="width:100%;padding:.55rem .85rem .55rem 2.2rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;background:white;outline:none;box-sizing:border-box;">
                <i class="fa-solid fa-magnifying-glass" style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);color:var(--c-text-muted);font-size:.85rem;"></i>
            </div>

            <button type="button" onclick="loadPengaduanData(1)" class="fs-btn-outline" style="padding:.55rem .85rem;">
                Cari
            </button>
        </div>
    </div>

    {{-- Pengaduan Cards List Container --}}
    <div id="pengaduan-list" style="display:flex;flex-direction:column;gap:1rem;min-height:200px;">
        <div style="text-align:center;padding:3rem 1rem;color:var(--c-text-muted);">
            <i class="fa-solid fa-spinner fa-spin" style="font-size:1.8rem;color:var(--c-primary);margin-bottom:.5rem;"></i>
            <p>Memuat data pengaduan...</p>
        </div>
    </div>

    {{-- Pagination Container --}}
    <div id="pengaduan-pagination" class="fs-paging" style="margin-top:1.75rem;"></div>

    {{-- ============================================================
         MODAL 1: FORMULIR BUAT PENGADUAN BARU
         ============================================================ --}}
    <div id="newpengaduan" class="fs-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div class="fs-modal-content" style="background:white;border-radius:var(--r-lg);width:100%;max-width:680px;box-shadow:var(--sh-lg);overflow:hidden;animation:modalSlide .25s ease-out;margin:auto;">
            <div style="padding:1.25rem 1.5rem;background:linear-gradient(135deg, #064e3b, #16803c);color:white;display:flex;align-items:center;justify-content:space-between;">
                <h3 style="font-size:1.1rem;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;color:#ffffff;">
                    <i class="fa-solid fa-pen-to-square" style="color:#a7f3d0;"></i> Buat Pengaduan Baru
                </h3>
                <button type="button" onclick="closeModal('newpengaduan')" style="background:none;border:none;color:white;font-size:1.25rem;cursor:pointer;opacity:.85;" aria-label="Tutup">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="{{ $form_action }}" method="POST" enctype="multipart/form-data" style="padding:1.5rem;">
                @php $sessData = session('data') ?: []; @endphp

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">NIK (16 Digit) *</label>
                        <input name="nik" type="text" maxlength="16" required
                               value="{{ $sessData['nik'] ?? '' }}" placeholder="Masukkan NIK Anda"
                               style="width:100%;padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Nama Lengkap *</label>
                        <input name="nama" type="text" required
                               value="{{ $sessData['nama'] ?? '' }}" placeholder="Nama Pelapor"
                               style="width:100%;padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                    <div>
                        <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Email</label>
                        <input name="email" type="email"
                               value="{{ $sessData['email'] ?? '' }}" placeholder="contoh@email.com"
                               style="width:100%;padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Nomor Telepon / WhatsApp</label>
                        <input name="telepon" type="text"
                               value="{{ $sessData['telepon'] ?? '' }}" placeholder="08xxxxxxxxxx"
                               style="width:100%;padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">
                    </div>
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Judul Pengaduan *</label>
                    <input name="judul" type="text" required
                           value="{{ $sessData['judul'] ?? '' }}" placeholder="Subjek atau ringkasan pengaduan"
                           style="width:100%;padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Isi Pengaduan / Deskripsi *</label>
                    <textarea name="isi" required rows="4" placeholder="Jelaskan kronologi atau rincian aduan secara jelas..."
                              style="width:100%;padding:.55rem .85rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">{{ $sessData['isi'] ?? '' }}</textarea>
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:.82rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Foto Pendukung (Opsional)</label>
                    <input type="file" name="foto" id="file_foto_input" accept="image/*" onchange="previewFoto(this)"
                           style="width:100%;padding:.4rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-size:.82rem;background:#f8fafc;">
                    <small style="color:var(--c-text-muted);font-size:.75rem;">Format: PNG, JPG, JPEG, WEBP (Max 5MB)</small>
                    <img id="img_preview" src="#" alt="Preview Foto" style="display:none;max-height:160px;border-radius:var(--r-md);margin-top:.5rem;border:1px solid var(--c-border);">
                </div>

                {{-- Captcha Section --}}
                <div style="background:var(--c-bg);padding:1rem;border-radius:var(--r-md);margin-bottom:1.5rem;display:flex;gap:1rem;align-items:center;flex-wrap:wrap;">
                    <div style="display:flex;align-items:center;gap:.5rem;">
                        <img id="captcha_img" src="{{ ci_route('captcha') }}" alt="CAPTCHA" style="height:40px;border-radius:var(--r-sm);border:1px solid var(--c-border);">
                        <button type="button" onclick="refreshCaptcha()" class="fs-btn-outline" style="padding:.4rem .6rem;font-size:.8rem;" title="Refresh Captcha">
                            <i class="fa-solid fa-rotate-right"></i>
                        </button>
                    </div>
                    <div style="flex:1;min-width:180px;">
                        <input type="text" name="captcha_code" maxlength="6" required placeholder="Ketik Kode Captcha"
                               style="width:100%;padding:.5rem .75rem;border:1.5px solid var(--c-border);border-radius:var(--r-md);font-family:var(--ff-base);font-size:.875rem;outline:none;box-sizing:border-box;">
                    </div>
                </div>

                <div style="display:flex;justify-content:flex-end;gap:.75rem;padding-top:1rem;border-top:1px solid var(--c-border);">
                    <button type="button" onclick="closeModal('newpengaduan')" class="fs-btn-outline">Tutup</button>
                    <button type="submit" class="fs-btn-primary">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Pengaduan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================
         MODAL 2: DETAIL TICKET PENGADUAN
         ============================================================ --}}
    <div id="pengaduan-detail" class="fs-modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,.65);backdrop-filter:blur(6px);z-index:9999;align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div class="fs-modal-content" style="background:white;border-radius:var(--r-lg);width:100%;max-width:640px;box-shadow:var(--sh-lg);overflow:hidden;animation:modalSlide .25s ease-out;margin:auto;">
            <div style="padding:1.25rem 1.5rem;background:linear-gradient(135deg, #064e3b, #16803c);color:white;display:flex;align-items:center;justify-content:space-between;">
                <h3 style="font-size:1.1rem;font-weight:700;margin:0;display:flex;align-items:center;gap:.5rem;color:#ffffff;">
                    <i class="fa-solid fa-folder-open" style="color:#a7f3d0;"></i> <span id="pengaduan-judul-detail">Detail Ticket</span>
                </h3>
                <button type="button" onclick="closeModal('pengaduan-detail')" style="background:none;border:none;color:white;font-size:1.25rem;cursor:pointer;opacity:.85;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div id="pengaduan-detail-body" style="padding:1.5rem;max-height:70vh;overflow-y:auto;"></div>
            <div style="padding:1rem 1.5rem;background:#f8fafc;border-top:1px solid var(--c-border);display:flex;justify-content:flex-end;">
                <button type="button" onclick="closeModal('pengaduan-detail')" class="fs-btn-outline">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes modalSlide {
    from { opacity: 0; transform: translateY(-20px) scale(.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.fs-ticket-card {
    background: white; border-radius: var(--r-md); border: 1.5px solid var(--c-border);
    padding: 1.25rem 1.5rem; transition: transform .2s, box-shadow .2s, border-color .2s;
}
.fs-ticket-card:hover {
    transform: translateY(-2px); box-shadow: var(--sh-md); border-color: var(--c-primary);
}
.fs-status-badge {
    font-size: .75rem; font-weight: 700; padding: .25rem .75rem; border-radius: 999px; display: inline-flex; align-items: center; gap: .35rem;
}
.fs-status-1 { background: #fef3c7; color: #92400e; } /* Menunggu */
.fs-status-2 { background: #dbeafe; color: #1e40af; } /* Sedang Diproses */
.fs-status-3 { background: #dcfce7; color: #166534; } /* Selesai */
</style>

@endsection

@push('scripts')
<script type="text/javascript">
function openModal(id) {
    var el = document.getElementById(id);
    if (el) { el.style.display = 'flex'; }
}

function closeModal(id) {
    var el = document.getElementById(id);
    if (el) { el.style.display = 'none'; }
}

function previewFoto(input) {
    var preview = document.getElementById('img_preview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function refreshCaptcha() {
    var img = document.getElementById('captcha_img');
    if (img) {
        img.src = '{{ ci_route("captcha") }}?' + Math.random();
    }
}

// Sensor citizen name for public privacy ethics (e.g. "Budi Santoso" -> "Sdr. B*** S***")
function censorName(name) {
    if (!name || name === 'Warga') return 'Warga Anonim';
    var parts = name.trim().split(' ');
    var censored = parts.map(function(p) {
        if (p.length <= 1) return p;
        return p.charAt(0) + '***';
    }).join(' ');
    return 'Sdr. ' + censored;
}

function loadPengaduanData(page) {
    var pageNumber = page || 1;
    var pageSize = 10;
    var status = document.getElementById('caristatus').value;
    var cari = document.getElementById('cari-pengaduan').value;

    var filter = '';
    if (status) filter += '&filter[status]=' + status;
    if (cari) filter += '&filter[search]=' + encodeURIComponent(cari);

    var listEl = document.getElementById('pengaduan-list');
    listEl.innerHTML = '<div style="text-align:center;padding:3rem;color:var(--c-text-muted);"><i class="fa-solid fa-spinner fa-spin" style="font-size:1.8rem;color:var(--c-primary);margin-bottom:.5rem;"></i><p>Memuat data pengaduan...</p></div>';

    $.ajax({
        url: '{{ ci_route("internal_api.pengaduan") }}?sort=-created_at&page[number]=' + pageNumber + '&page[size]=' + pageSize + filter,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            listEl.innerHTML = '';
            var data = response.data || [];
            
            if (data.length === 0) {
                listEl.innerHTML = '<div style="background:white;padding:3rem 1.5rem;text-align:center;border-radius:var(--r-md);border:1px dashed var(--c-border);color:var(--c-text-muted);"><i class="fa-regular fa-folder-open" style="font-size:2rem;margin-bottom:.5rem;"></i><p style="margin:0;font-weight:600;">Belum ada pengaduan masyarakat.</p></div>';
                document.getElementById('pengaduan-pagination').innerHTML = '';
                return;
            }

            data.forEach(function(item) {
                var attr = item.attributes || {};
                var statusClass = 'fs-status-1';
                var statusLabel = 'Menunggu Diproses';
                
                if (attr.status == 2) {
                    statusClass = 'fs-status-2'; statusLabel = 'Sedang Diproses';
                } else if (attr.status == 3) {
                    statusClass = 'fs-status-3'; statusLabel = 'Selesai Diproses';
                }

                var publicName = censorName(attr.nama);

                var card = document.createElement('div');
                card.className = 'fs-ticket-card';
                card.innerHTML = `
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.75rem;flex-wrap:wrap;gap:.5rem;">
                        <span class="fs-status-badge ${statusClass}">${statusLabel}</span>
                        <span style="font-size:.78rem;color:var(--c-text-muted);">
                            <i class="fa-regular fa-calendar"></i> ${attr.created_at || '—'}
                        </span>
                    </div>
                    <h3 style="font-size:1.1rem;font-weight:700;color:var(--c-text-head);margin-bottom:.4rem;line-height:1.3;">
                        ${attr.judul || 'Pengaduan Tanpa Judul'}
                    </h3>
                    <div style="font-size:.82rem;color:var(--c-text-muted);margin-bottom:.75rem;display:flex;gap:1rem;flex-wrap:wrap;">
                        <span><i class="fa-solid fa-user-shield" style="color:var(--c-primary);"></i> ${publicName}</span>
                    </div>
                    <p style="font-size:.9rem;color:var(--c-text-body);line-height:1.6;margin-bottom:1rem;">
                        ${attr.isi ? attr.isi.substring(0, 180) + '...' : ''}
                    </p>
                    <button type="button" onclick="viewDetail(${item.id})" class="fs-btn-outline" style="font-size:.78rem;padding:.35rem .85rem;">
                        Lihat Detail Ticket <i class="fa-solid fa-arrow-right" style="font-size:.7rem;"></i>
                    </button>
                `;
                listEl.appendChild(card);
            });
        },
        error: function() {
            listEl.innerHTML = '<div style="background:#fef2f2;color:#991b1b;padding:1.5rem;border-radius:var(--r-md);text-align:center;"><i class="fa-solid fa-triangle-exclamation"></i> Gagal memuat data pengaduan. Silakan coba lagi.</div>';
        }
    });
}

function viewDetail(id) {
    $.ajax({
        url: '{{ ci_route("internal_api.pengaduan") }}/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            var item = res.data || {};
            var attr = item.attributes || {};
            var publicName = censorName(attr.nama);
            
            document.getElementById('pengaduan-judul-detail').innerText = attr.judul || 'Detail Pengaduan';
            
            var bodyHtml = `
                <div style="margin-bottom:1rem;">
                    <span style="font-size:.78rem;color:var(--c-text-muted);display:block;margin-bottom:.25rem;">Pelapor (Identitas Disamarkan)</span>
                    <strong style="color:var(--c-text-head);">${publicName}</strong>
                </div>
                <div style="margin-bottom:1rem;">
                    <span style="font-size:.78rem;color:var(--c-text-muted);display:block;margin-bottom:.25rem;">Isi Pengaduan</span>
                    <div style="background:#f8fafc;padding:1rem;border-radius:var(--r-md);font-size:.92rem;line-height:1.7;color:#334155;">
                        ${attr.isi || ''}
                    </div>
                </div>
            `;
            
            if (attr.tanggapan) {
                bodyHtml += `
                    <div style="margin-top:1.5rem;background:var(--c-primary-bg);border-left:4px solid var(--c-primary);padding:1rem;border-radius:0 var(--r-md) var(--r-md) 0;">
                        <h4 style="font-size:.9rem;font-weight:700;color:var(--c-primary-dark);margin-bottom:.35rem;">
                            <i class="fa-solid fa-reply"></i> Tanggapan Pemerintah Desa
                        </h4>
                        <p style="font-size:.88rem;color:#1e293b;margin:0;line-height:1.6;">${attr.tanggapan}</p>
                    </div>
                `;
            }
            
            document.getElementById('pengaduan-detail-body').innerHTML = bodyHtml;
            openModal('pengaduan-detail');
        }
    });
}

document.addEventListener("DOMContentLoaded", function() {
    loadPengaduanData(1);
    
    // Close modal on click backdrop
    document.querySelectorAll('.fs-modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.style.display = 'none';
            }
        });
    });
});
</script>
@endpush
