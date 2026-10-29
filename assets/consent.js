(function () {
    'use strict';
    var config = window.aiteaConsent || {};
    var key = config.cookieName || 'aitea_analytics_consent';
    var banner = document.querySelector('[data-cookie-banner]');
    var stored = window.localStorage.getItem(key);

    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () { window.dataLayer.push(arguments); };
    window.gtag('consent', 'default', { analytics_storage: 'denied', ad_storage: 'denied', ad_user_data: 'denied', ad_personalization: 'denied' });

    window.trackEvent = function (name, parameters) {
        if (window.gtag && stored === 'accepted') {
            window.gtag('event', name, parameters || {});
        }
    };

    var loadAnalytics = function () {
        if (!config.measurementId || document.querySelector('[data-aitea-ga4]')) { return; }
        window.gtag('consent', 'update', { analytics_storage: 'granted' });
        window.gtag('js', new Date());
        window.gtag('config', config.measurementId, { anonymize_ip: true });
        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(config.measurementId);
        script.setAttribute('data-aitea-ga4', 'true');
        document.head.appendChild(script);
    };

    var choose = function (choice) {
        stored = choice;
        window.localStorage.setItem(key, choice);
        if (choice === 'accepted') { loadAnalytics(); }
        if (banner) { banner.hidden = true; }
    };
    if (!stored && banner) { banner.hidden = false; }
    document.addEventListener('click', function (event) {
        var button = event.target.closest('[data-cookie-choice]');
        if (button) { choose(button.getAttribute('data-cookie-choice')); }
        if (event.target.closest('[data-cookie-settings]') && banner) {
            banner.hidden = false;
        }
    });
}());