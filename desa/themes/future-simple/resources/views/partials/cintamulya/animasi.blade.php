{{--
|--------------------------------------------------------------------------
| Animasi halaman depan — Anime.js
|--------------------------------------------------------------------------
| FILOSOFI: animasi di sini bertugas MENGARAHKAN MATA, bukan menghibur.
| Situs ini dibuka warga desa berkali-kali untuk mengurus surat; animasi yang
| pamer akan cepat menjemukan dan justru memperlambat.
|
| Aturan yang dipegang:
| - Hanya SEKALI saat elemen pertama terlihat. Tidak ada yang berulang,
|   tidak ada yang berdenyut terus-menerus.
| - Durasi pendek (350-700ms) dengan jeda antar elemen 60-70ms.
| - Pergerakan kecil (maksimal 16px). Yang halus terasa mahal; yang besar
|   terasa murah dan bikin pusing.
| - Angka statistik dihitung naik — ini satu-satunya animasi yang benar-benar
|   MENYAMPAIKAN sesuatu: bahwa angkanya nyata dan besar.
|
| KETAHANAN — tiga lapis pengaman:
| 1. Elemen TIDAK disembunyikan lewat CSS. Keadaan awal dipasang oleh JS.
|    Jadi bila Anime.js gagal dimuat (CDN mati, internet desa lambat),
|    halaman tetap tampil utuh — hanya tanpa animasi.
| 2. Menghormati prefers-reduced-motion: pengguna yang sensitif gerakan
|    langsung mendapat halaman diam.
| 3. Dimuat dengan defer dan hanya bila ada koneksi internet, memakai
|    pemeriksa bawaan OpenSID.
--}}

@if (cek_koneksi_internet())
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js" defer></script>
        <script defer>
            document.addEventListener('DOMContentLoaded', function () {
                // --- Lapis 2: hormati preferensi pengguna ---------------------
                var diamSaja = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

                // --- Lapis 1: tanpa Anime.js, hentikan diam-diam -------------
                if (diamSaja || typeof window.anime !== 'function') {
                    return;
                }

                var mudah = 'cubicBezier(.22,.8,.28,1)'; // cepat di awal, mendarat lembut

                /* --- Lapis 4: JARING PENGAMAN. JANGAN DIHAPUS ---------------
                   Animasi ini memasang keadaan awal opacity:0 lalu menaikkannya
                   kembali. Kalau prosesnya berhenti di tengah, konten akan
                   TIDAK TERLIHAT sama sekali — kegagalan yang jauh lebih buruk
                   daripada sekadar tidak ada animasi.

                   Ini bukan kekhawatiran teoretis: Anime.js bergantung pada
                   requestAnimationFrame, dan rAF TIDAK BERJALAN saat halaman
                   dalam keadaan hidden (tab latar belakang, jendela minimal,
                   prarender). Sudah terbukti saat pengujian.

                   Karena itu: apa pun yang terjadi, setelah 1,8 detik semua
                   elemen dipaksa terlihat. Bila animasinya berhasil, baris ini
                   tidak mengubah apa-apa karena nilainya memang sudah 1. */
                var SEMUA_TERANIMASI = '.cm-hero__eyebrow, .cm-hero__title, .cm-hero__lead,' +
                    '.cm-actions > *, .cm-hero__grid, .cm-quick__item, .cm-grid--3 > li, .cm-stat__card';

                setTimeout(function () {
                    document.querySelectorAll(SEMUA_TERANIMASI).forEach(function (el) {
                        if (parseFloat(getComputedStyle(el).opacity) < 1) {
                            el.style.opacity = el.classList.contains('cm-hero__grid') ? '0.35' : '1';
                            el.style.transform = 'none';
                        }
                    });
                    // Batang persentase juga dipastikan mencapai lebar akhirnya
                    document.querySelectorAll('.cm-bars__fill').forEach(function (el) {
                        if (el.dataset.cmLebar && el.style.width !== el.dataset.cmLebar) {
                            el.style.width = el.dataset.cmLebar;
                        }
                    });
                }, 1800);

                // Bila halaman sedang tersembunyi saat dimuat, rAF tidak jalan.
                // Jangan menyembunyikan apa pun dalam kondisi itu.
                if (document.visibilityState === 'hidden') {
                    return;
                }

                /**
                 * Menganimasikan sekumpulan elemen sekali saja, saat pertama
                 * masuk layar. Keadaan awal dipasang di sini (bukan di CSS),
                 * supaya kegagalan skrip tidak pernah menyembunyikan konten.
                 */
                function munculSaatTerlihat(pemilih, opsi) {
                    var elemen = document.querySelectorAll(pemilih);
                    if (!elemen.length) return;

                    opsi = opsi || {};
                    var geser = opsi.geser === undefined ? 14 : opsi.geser;

                    anime.set(elemen, { opacity: 0, translateY: geser });

                    var pengamat = new IntersectionObserver(function (masuk) {
                        masuk.forEach(function (entri) {
                            if (!entri.isIntersecting) return;
                            pengamat.unobserve(entri.target);
                            anime({
                                targets: entri.target,
                                opacity: [0, 1],
                                translateY: [geser, 0],
                                duration: opsi.durasi || 520,
                                delay: entri.target.dataset.cmJeda || 0,
                                easing: mudah
                            });
                        });
                    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

                    elemen.forEach(function (el, i) {
                        el.dataset.cmJeda = (opsi.tunda || 0) + i * (opsi.selang || 65);
                        pengamat.observe(el);
                    });
                }

                // ============ 1. HERO — langsung jalan, tidak menunggu scroll ============
                // Ini bagian above-the-fold, jadi tidak perlu IntersectionObserver.
                var isiHero = document.querySelectorAll(
                    '.cm-hero__eyebrow, .cm-hero__title, .cm-hero__lead, .cm-actions > *'
                );
                if (isiHero.length) {
                    anime.set(isiHero, { opacity: 0, translateY: 16 });
                    anime({
                        targets: isiHero,
                        opacity: [0, 1],
                        translateY: [16, 0],
                        duration: 620,
                        delay: anime.stagger(70, { start: 90 }),
                        easing: mudah
                    });
                }

                // Kisi titik sian menyala perlahan — isyarat "sistem menyala".
                // Sekali saja, lalu diam selamanya.
                var kisi = document.querySelector('.cm-hero__grid');
                if (kisi) {
                    anime.set(kisi, { opacity: 0 });
                    anime({
                        targets: kisi,
                        opacity: [0, 0.35],
                        duration: 1400,
                        delay: 260,
                        easing: 'easeOutQuad'
                    });
                }

                // ============ 2. STRIP AKSI CEPAT ============
                munculSaatTerlihat('.cm-quick__item', { geser: 12, selang: 55, durasi: 460 });

                // ============ 3. KARTU POTENSI ============
                munculSaatTerlihat('.cm-grid--3 > li', { geser: 16, selang: 90 });

                // ============ 4. ANGKA STATISTIK — dihitung naik ============
                // Satu-satunya animasi yang membawa makna: memperlihatkan bahwa
                // angkanya nyata dan besar, bukan sekadar hiasan.
                var kartuAngka = document.querySelectorAll('.cm-stat__card');
                if (kartuAngka.length) {
                    anime.set(kartuAngka, { opacity: 0, translateY: 14 });

                    var pengamatAngka = new IntersectionObserver(function (masuk) {
                        masuk.forEach(function (entri, i) {
                            if (!entri.isIntersecting) return;
                            pengamatAngka.unobserve(entri.target);

                            anime({
                                targets: entri.target,
                                opacity: [0, 1],
                                translateY: [14, 0],
                                duration: 480,
                                delay: i * 80,
                                easing: mudah
                            });

                            var nilai = entri.target.querySelector('.cm-stat__value');
                            if (!nilai) return;

                            // Angka ditulis format Indonesia (5.054). Ambil angkanya,
                            // hitung naik, lalu kembalikan ke format semula.
                            var teksAsli = nilai.textContent.trim();
                            var akhir = parseInt(teksAsli.replace(/\D/g, ''), 10);
                            if (isNaN(akhir) || akhir === 0) return;

                            var wadah = { n: 0 };
                            anime({
                                targets: wadah,
                                n: akhir,
                                duration: Math.min(1100, 400 + akhir / 8),
                                delay: 180 + i * 80,
                                easing: 'easeOutExpo',
                                round: 1,
                                update: function () {
                                    nilai.textContent = wadah.n.toLocaleString('id-ID');
                                },
                                complete: function () {
                                    nilai.textContent = teksAsli; // jamin sama persis
                                }
                            });
                        });
                    }, { threshold: 0.3 });

                    kartuAngka.forEach(function (el) { pengamatAngka.observe(el); });
                }

                // ============ 5. BATANG PERSENTASE ============
                // Tumbuh dari nol ke lebar sebenarnya, sekali saja.
                var batang = document.querySelectorAll('.cm-bars__fill');
                if (batang.length) {
                    var pengamatBatang = new IntersectionObserver(function (masuk) {
                        masuk.forEach(function (entri, i) {
                            if (!entri.isIntersecting) return;
                            pengamatBatang.unobserve(entri.target);
                            var lebar = entri.target.style.width;
                            entri.target.dataset.cmLebar = lebar; // dipakai jaring pengaman
                            anime({
                                targets: entri.target,
                                width: ['0%', lebar],
                                duration: 780,
                                delay: i * 70,
                                easing: mudah
                            });
                        });
                    }, { threshold: 0.5 });

                    batang.forEach(function (el) { pengamatBatang.observe(el); });
                }
            });
        </script>
    @endpush
@endif
