@php
    $comments = [];
    if (is_array($komentar) && $single_artikel['boleh_komentar']) {
        $comments = [];

        foreach ($komentar as $comment) {
            if ($comment['is_archived'] != 1) {
                $comments[] = $comment;
            }
        }
        $comments = array_reverse($comments);
        $forms = [
            'owner' => 'Nama',
            'email' => 'Alamat Email',
            'no_hp' => 'No. HP',
        ];
    }
    $notif = session('notif');
@endphp

@if (count($comments) > 0)
    <div style="margin-top:2.5rem;background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);">
        <h3 style="font-size:1.1rem;font-weight:700;color:var(--c-text-head);margin-bottom:1.25rem;display:flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-comments" style="color:var(--c-primary);"></i> Semua Komentar ({{ count($comments) }})
        </h3>
        <div style="display:flex;flex-direction:column;gap:1rem;">
            @foreach ($comments as $comment)
                <div style="background:#f8fafc;border-radius:var(--r-sm);border:1px solid var(--c-border);padding:1rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.5rem;">
                        <span style="font-weight:700;font-size:.9rem;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;">
                            <i class="fa-solid fa-user-circle" style="color:var(--c-primary);"></i> {{ $comment['pengguna']['nama'] }}
                        </span>
                        <span style="font-size:.75rem;color:var(--c-text-muted);">
                            <i class="fa-regular fa-clock" style="margin-right:.25rem;"></i> {{ tgl_indo($comment['tgl_upload']) }}
                        </span>
                    </div>
                    <blockquote style="font-size:.88rem;color:var(--c-text-body);line-height:1.5;margin:0;font-style:italic;">
                        "{{ $comment['komentar'] }}"
                    </blockquote>

                    @if (count($comment['children']) > 0)
                        <div style="margin-top:.75rem;margin-left:1.5rem;display:flex;flex-direction:column;gap:.75rem;">
                            @foreach ($comment['children'] as $children)
                                <div style="background:var(--c-white);border-radius:var(--r-sm);border:1px solid var(--c-border);padding:.75rem 1rem;">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.35rem;">
                                        <span style="font-weight:700;font-size:.85rem;color:var(--c-text-head);display:flex;align-items:center;gap:.4rem;">
                                            <i class="fa-solid fa-user-shield" style="color:var(--c-primary);"></i> {{ $children['pengguna']['nama'] }}
                                            <span style="font-size:.7rem;background:var(--c-primary-light);color:var(--c-primary-dark);padding:.1rem .4rem;border-radius:var(--r-pill);font-weight:600;">Admin</span>
                                        </span>
                                        <span style="font-size:.72rem;color:var(--c-text-muted);">{{ tgl_indo($children['tgl_upload']) }}</span>
                                    </div>
                                    <blockquote style="font-size:.85rem;color:var(--c-text-body);margin:0;">
                                        "{{ $children['komentar'] }}"
                                    </blockquote>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

@if ($single_artikel['boleh_komentar'] == 1)
    <div style="margin-top:2rem;background:var(--c-white);border-radius:var(--r-md);border:1px solid var(--c-border);padding:1.5rem;box-shadow:var(--sh-sm);" id="kolom-komentar">
        <h3 style="font-size:1.1rem;font-weight:700;color:var(--c-text-head);margin-bottom:.5rem;display:flex;align-items:center;gap:.5rem;">
            <i class="fa-solid fa-pen-to-square" style="color:var(--c-primary);"></i> Beri Komentar
        </h3>
        <p style="font-size:.82rem;color:var(--c-text-muted);margin-bottom:1.25rem;background:var(--c-primary-light);color:var(--c-primary-dark);padding:.5rem .75rem;border-radius:var(--r-sm);display:flex;align-items:center;gap:.4rem;">
            <i class="fa-solid fa-circle-info"></i> Komentar baru akan terbit setelah disetujui oleh admin desa.
        </p>

        @php $alert = ($notif['status'] == -1) ? 'error' : 'success'; @endphp
        @if ($flash_message = $notif['pesan'])
            <div style="padding:.65rem 1rem;border-radius:var(--r-sm);margin-bottom:1rem;font-size:.85rem;background:{{ $notif['status'] == -1 ? '#fef2f2' : '#f0fdf4' }};color:{{ $notif['status'] == -1 ? '#991b1b' : '#166534' }};border:1px solid {{ $notif['status'] == -1 ? '#fca5a5' : '#bbf7d0' }};">
                <i class="fa-solid {{ $notif['status'] != -1 ? 'fa-circle-check' : 'fa-circle-exclamation' }}" style="margin-right:.4rem;"></i> {{ $flash_message }}
            </div>
        @endif

        <form action="{{ site_url('/add_comment/' . $single_artikel['id']) }}" method="POST" style="display:flex;flex-direction:column;gap:1rem;">
            <div>
                <label for="komentar" style="display:block;font-size:.8rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Komentar <span style="color:#ef4444;">*</span></label>
                <textarea name="komentar" id="komentar" rows="4" required placeholder="Tulis komentar Anda di sini..." style="width:100%;padding:.65rem .85rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.88rem;color:var(--c-text-head);background:var(--c-white);"></textarea>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;">
                <div>
                    <label for="owner" style="display:block;font-size:.8rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Nama <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="owner" name="owner" required placeholder="Nama Anda" value="{{ $notif['data']['nama'] ?? '' }}" style="width:100%;padding:.55rem .75rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.85rem;color:var(--c-text-head);">
                </div>
                <div>
                    <label for="email" style="display:block;font-size:.8rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="email@contoh.com" value="{{ $notif['data']['email'] ?? '' }}" style="width:100%;padding:.55rem .75rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.85rem;color:var(--c-text-head);">
                </div>
                <div>
                    <label for="no_hp" style="display:block;font-size:.8rem;font-weight:600;color:var(--c-text-head);margin-bottom:.35rem;">No. HP <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" required placeholder="08xxxxxxxxxx" value="{{ $notif['data']['no_hp'] ?? '' }}" style="width:100%;padding:.55rem .75rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.85rem;color:var(--c-text-head);">
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;background:#f8fafc;padding:.85rem 1rem;border-radius:var(--r-sm);border:1px solid var(--c-border);">
                <div style="display:flex;align-items:center;gap:.65rem;">
                    <img id="captcha" src="{{ site_url('captcha') }}" alt="CAPTCHA Image" style="height:38px;border-radius:var(--r-sm);border:1px solid var(--c-border);">
                    <button type="button" onclick="document.getElementById('captcha').src = '{{ ci_route('captcha') }}?' + Math.random();" style="background:none;border:none;color:var(--c-primary);font-size:.78rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:.25rem;">
                        <i class="fa-solid fa-rotate"></i> Ganti Code
                    </button>
                </div>
                <div style="flex:1;min-width:160px;">
                    <input type="text" name="captcha_code" required placeholder="Ketik kode di sebelah" style="width:100%;padding:.55rem .75rem;border:1px solid var(--c-border);border-radius:var(--r-sm);font-family:var(--ff-base);font-size:.85rem;color:var(--c-text-head);">
                </div>
            </div>

            <div>
                <button type="submit" style="padding:.6rem 1.4rem;background:var(--c-primary);color:white;border:none;border-radius:var(--r-sm);font-size:.88rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:.4rem;">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Komentar
                </button>
            </div>
        </form>
    </div>
@endif
