@extends('layanan_mandiri.auth.index')

@section('content')
    <form id="validasi" autocomplete="off" action="{{ $form_action }}" method="post">

        <div class="field">
            <label for="nik">NIK (Nomor Induk Kependudukan)</label>
            <div class="field-inner">
                <i class="fa-solid fa-id-card fi-icon"></i>
                <input
                    type="text"
                    id="nik"
                    name="nik"
                    autocomplete="off"
                    maxlength="16"
                    placeholder="Masukkan 16 digit NIK"
                    class="angka required {!! jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber') !!}"
                >
            </div>
        </div>

        <input type="hidden" id="anjungan_uuid" disabled>

        <div class="field">
            <label for="pin">PIN</label>
            <div class="field-inner">
                <i class="fa-solid fa-lock fi-icon"></i>
                <input
                    type="password"
                    id="pin"
                    name="password"
                    autocomplete="off"
                    maxlength="6"
                    placeholder="Masukkan 6 digit PIN"
                    class="angka required {!! jecho($cek_anjungan['keyboard'] == 1, true, 'kbvnumber') !!}"
                >
            </div>
        </div>

        <label class="show-pin-label">
            <input type="checkbox" id="checkbox">
            <span>Tampilkan PIN</span>
        </label>

        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-right-to-bracket"></i> Masuk
        </button>

        <div class="form-divider">atau</div>

        <a href="{{ site_url('layanan-mandiri/masuk-ektp') }}" class="btn btn-outline">
            <i class="fa-solid fa-address-card"></i> Masuk dengan E-KTP
        </a>

        @if (setting('tampilkan_pendaftaran'))
            <a href="{{ site_url('layanan-mandiri/daftar') }}" class="btn btn-ghost">
                <i class="fa-solid fa-user-plus"></i> Daftar Akun
            </a>
        @endif

        <a href="{{ site_url('layanan-mandiri/lupa-pin') }}" class="btn btn-ghost">
            <i class="fa-solid fa-key"></i> Lupa PIN
        </a>

        @if (in_array(\Modules\Anjungan\Models\Anjungan::ANJUNGAN, $cek_anjungan['tipe'] ?? []))
            <a href="<?= route('anjungan.index') ?>" class="btn btn-ghost">
                <i class="fa-solid fa-desktop"></i> Anjungan Mandiri
            </a>
        @endif

    </form>
@endsection

@push('script')
    <script>
        $(function() {
            var pin = $('#pin');
            $('#checkbox').on('change', function() {
                pin.attr('type', this.checked ? 'text' : 'password');
            });

            var uuid = localStorage.getItem('anjungan_uuid');
            if (uuid) {
                $('#anjungan_uuid').attr('name', 'anjungan_uuid').removeAttr('disabled').val(uuid);
            }
        });
    </script>
@endpush
