@if (cek_koneksi_internet())
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.2/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
@endif

@include('core::admin.layouts.components.token')
<script src="{{ asset('js/peta.js') }}"></script>

<script>
var BASE_URL = '{{ base_url() }}';

// ---- DataTable Defaults ----
if (typeof $ !== 'undefined' && $.fn.dataTable) {
    $.extend($.fn.dataTable.defaults, {
        lengthMenu: [[10, 25, 50, -1],[10, 25, 50, "Semua"]],
        pageLength: 10,
        language: { url: "{{ asset('bootstrap/js/dataTables.indonesian.lang') }}" }
    });
}

// ---- Loading Screen ----
function hideFsLoader() {
    var loader = document.getElementById('fs-loader');
    if (loader && loader.style.display !== 'none') {
        loader.style.opacity = '0';
        setTimeout(function() { loader.style.display = 'none'; }, 350);
    }
}
window.addEventListener('load', hideFsLoader);
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(hideFsLoader, 600);
});

// ---- Back to Top ----
(function() {
    var btt = document.getElementById('fs-btt');
    if (!btt) return;
    window.addEventListener('scroll', function() {
        btt.classList.toggle('visible', window.scrollY > 300);
    }, { passive: true });
})();

// ---- Navbar Scroll Shadow ----
(function() {
    var nav = document.querySelector('.fs-navbar');
    if (!nav) return;
    window.addEventListener('scroll', function() {
        nav.classList.toggle('scrolled', window.scrollY > 50);
    }, { passive: true });
})();

// ---- Mobile Hamburger ----
(function() {
    var btn = document.getElementById('fs-ham');
    var menu = document.getElementById('fs-mobile-menu');
    if (!btn || !menu) return;
    btn.addEventListener('click', function() {
        menu.classList.toggle('open');
    });
})();

// ---- Anime.js: Intersection Observer Animations ----
(function() {
    if (typeof anime === 'undefined') return;

    // Fade-up for section titles & misc elements
    var fadeEls = document.querySelectorAll('.anime-hidden');
    if (fadeEls.length === 0) return;

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                anime({
                    targets: entry.target,
                    opacity: [0, 1],
                    translateY: [24, 0],
                    duration: 600,
                    easing: 'easeOutCubic'
                });
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });

    fadeEls.forEach(function(el) { observer.observe(el); });
})();

// ---- Anime.js: Stagger Cards ----
(function() {
    if (typeof anime === 'undefined') return;
    var grids = document.querySelectorAll('.anime-stagger');
    if (!grids.length) return;

    var gridObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var items = entry.target.querySelectorAll('.anime-stagger-item');
                anime({
                    targets: items,
                    opacity: [0, 1],
                    translateY: [32, 0],
                    delay: anime.stagger(90),
                    duration: 550,
                    easing: 'easeOutQuart'
                });
                gridObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    grids.forEach(function(g) { gridObserver.observe(g); });
})();

// ---- Anime.js: Stat Counter ----
(function() {
    if (typeof anime === 'undefined') return;
    var counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    var cntObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var target = parseInt(el.getAttribute('data-counter'), 10);
                var obj = { val: 0 };
                anime({
                    targets: obj,
                    val: target,
                    duration: 1800,
                    easing: 'easeOutExpo',
                    update: function() { el.textContent = Math.floor(obj.val).toLocaleString('id-ID'); }
                });
                cntObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(function(c) { cntObserver.observe(c); });
})();

// ---- Anime.js: APBDes Progress Bar ----
(function() {
    if (typeof anime === 'undefined') return;
    var bars = document.querySelectorAll('.fs-bar-fill[data-pct]');
    if (!bars.length) return;

    var barObserver = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var bar = entry.target;
                var pct = parseFloat(bar.getAttribute('data-pct')) || 0;
                anime({
                    targets: bar,
                    width: pct + '%',
                    duration: 1400,
                    easing: 'easeOutQuart'
                });
                barObserver.unobserve(bar);
            }
        });
    }, { threshold: 0.3 });

    bars.forEach(function(b) { barObserver.observe(b); });
})();

// ---- Anime.js: Hero entrance ----
(function() {
    if (typeof anime === 'undefined') return;
    var hero = document.querySelector('.fs-hero');
    if (!hero) return;
    anime({
        targets: hero.querySelector('.fs-hero-content'),
        opacity: [0, 1],
        translateX: [-40, 0],
        duration: 800,
        easing: 'easeOutCubic',
        delay: 300
    });
    anime({
        targets: hero.querySelector('.fs-hero-visual'),
        opacity: [0, 1],
        translateX: [40, 0],
        duration: 800,
        easing: 'easeOutCubic',
        delay: 450
    });
})();

// ---- Quick pills active on scroll ----
(function() {
    var pills = document.querySelectorAll('.fs-pill[data-target]');
    if (!pills.length) return;
    pills.forEach(function(pill) {
        pill.addEventListener('click', function(e) {
            pills.forEach(function(p) { p.classList.remove('active'); });
            pill.classList.add('active');
        });
    });
})();

// ---- Init Owl Carousel ----
$(document).ready(function() {
    if ($.fn.owlCarousel) {
        $('.owl-carousel').owlCarousel({
            items: 1,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3500,
            autoplayHoverPause: true,
            nav: false,
            dots: true
        });
    }
});
</script>

@if (!setting('inspect_element'))
    <script src="{{ asset('js/disabled.min.js') }}"></script>
@endif
