// Menu mobile
(function () {
    var toggle = document.querySelector('[data-nav-toggle]');
    var nav = document.querySelector('[data-nav]');
    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    // Apparition des éléments au défilement
    var items = document.querySelectorAll('.reveal');
    if (!('IntersectionObserver' in window)) {
        items.forEach(function (el) { el.classList.add('is-visible'); });
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                io.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    items.forEach(function (el, i) {
        el.style.transitionDelay = (i % 4) * 80 + 'ms';
        io.observe(el);
    });

    // Compteurs animés
    document.querySelectorAll('[data-count]').forEach(function (el) {
        var target = parseInt(el.getAttribute('data-count'), 10) || 0;
        var suffix = el.getAttribute('data-suffix') || '';
        var started = false;
        var obs = new IntersectionObserver(function (e) {
            if (!e[0].isIntersecting || started) return;
            started = true;
            var start = performance.now();
            (function tick(now) {
                var p = Math.min((now - start) / 1400, 1);
                el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))) + suffix;
                if (p < 1) requestAnimationFrame(tick);
            })(start);
        });
        obs.observe(el);
    });
})();
