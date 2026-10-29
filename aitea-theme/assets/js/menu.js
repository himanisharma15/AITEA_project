(function () {
    'use strict';

    var toggle = document.querySelector('[data-menu-toggle]');
    var panel = document.querySelector('[data-menu-panel]');
    if (!toggle || !panel) {
        return;
    }

    var focusable = function () {
        return panel.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])');
    };

    var close = function () {
        toggle.setAttribute('aria-expanded', 'false');
        panel.classList.remove('is-open');
    };

    var open = function () {
        toggle.setAttribute('aria-expanded', 'true');
        panel.classList.add('is-open');
        var links = focusable();
        if (links.length) {
            links[0].focus();
        }
    };

    toggle.addEventListener('click', function () {
        if (panel.classList.contains('is-open')) {
            close();
        } else {
            open();
        }
    });

    panel.addEventListener('click', function (event) {
        if (event.target.closest('a')) {
            close();
        }
    });

    document.addEventListener('click', function (event) {
        if (panel.classList.contains('is-open') && !panel.contains(event.target) && !toggle.contains(event.target)) {
            close();
        }
    });

    window.addEventListener('resize', function () {
        if (window.matchMedia('(min-width: 48rem)').matches) {
            close();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (!panel.classList.contains('is-open')) {
            return;
        }
        if (event.key === 'Escape') {
            close();
            toggle.focus();
        }
        if (event.key === 'Tab') {
            var links = focusable();
            if (!links.length) {
                return;
            }
            var first = links[0];
            var last = links[links.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first.focus();
            }
        }
    });
}());
