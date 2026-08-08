@extends('layanan_mandiri.auth.index')

@section('content')
    @include('admin.layouts.components.notifikasi')
    
    <form id="validasi" autocomplete="off" action="{{ $form_action }}" method="post">
        <div class="mandiri-input-group">
            <i class="fa-solid fa-id-card input-icon"></i>
            <input type="text" autocomplete="off" class="mandiri-input angka required {!! jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber') !!}" name="nik" maxlength="16" placeholder="Masukkan NIK (16 digit)">
        </div>

        <input type="hidden" name="anjungan_uuid" id="anjungan_uuid">

        <div class="mandiri-input-group">
            <i class="fa-solid fa-lock input-icon"></i>
            <input
                type="password"
                autocomplete="off"
                class="mandiri-input angka required {!! jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber') !!}"
                name="password"
                placeholder="Masukkan PIN (6 digit)"
                id="pin"
                maxlength="6"
            >
        </div>

        <label class="mandiri-checkbox">
            <input type="checkbox" id="checkbox">
            <span>Tampilkan PIN</span>
        </label>

        <button type="submit" class="mandiri-btn mandiri-btn-primary">
            <i class="fa-solid fa-right-to-bracket"></i> MASUK
        </button>

        <a href="{{ site_url('layanan-mandiri/masuk-ektp') }}" class="mandiri-btn mandiri-btn-outline">
            <i class="fa-solid fa-address-card"></i> MASUK DENGAN E-KTP
        </a>

        @if (setting('tampilkan_pendaftaran'))
            <a href="{{ site_url('layanan-mandiri/daftar') }}" class="mandiri-btn mandiri-btn-subtle">
                <i class="fa-solid fa-user-plus"></i> DAFTAR AKUN
            </a>
        @endif

        <a href="{{ site_url('layanan-mandiri/lupa-pin') }}" class="mandiri-btn mandiri-btn-subtle" style="margin-bottom:0;">
            <i class="fa-solid fa-key"></i> LUPA PIN
        </a>

        @if (in_array(\Modules\Anjungan\Models\Anjungan::ANJUNGAN, $cek_anjungan['tipe'] ?? []))
            <a href="<?= route('anjungan.index') ?>" class="mandiri-btn mandiri-btn-subtle" style="margin-top:.75rem;">
                <i class="fa-solid fa-desktop"></i> ANJUNGAN MANDIRI
            </a>
        @endif
    </form>
@endsection

@push('script')
    <script type="text/javascript">
        $('document').ready(function() {
            var pass = $("#pin");
            $('#checkbox').click(function() {
                if (pass.attr('type') === "password") {
                    pass.attr('type', 'text');
                } else {
                    pass.attr('type', 'password')
                }
            });
            
            // Get UUID from local storage and set it to the hidden input
            const anjungan_uuid = localStorage.getItem('anjungan_uuid');
            if (anjungan_uuid) {
                $('#anjungan_uuid').val(anjungan_uuid);
            }
        });
    </script>
@endpush
