<div id="mriCookieConsent" class="mri-cookie-consent" role="region" aria-label="Информация о cookie" hidden>
    <div class="mri-cookie-consent__text">
        Мы используем cookie, Яндекс Метрику и дополнительные сервисы для анализа посещаемости и работы сайта.
        <a href="/usloviya-ispolzovaniya-cookies/" target="_blank" rel="noopener nofollow">Подробнее</a>
    </div>
    <div class="mri-cookie-consent__buttons">
        <button type="button" class="mri-cookie-consent__button mri-cookie-consent__button--primary" id="mriCookieNoticeClose">Понятно</button>
    </div>
</div>
<style>
.mri-cookie-consent[hidden],
.mri-cookie-settings[hidden] {
    display: none !important;
}

.mri-cookie-consent {
    position: fixed;
    z-index: 2147483000;
    right: 16px;
    bottom: 16px;
    left: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    max-width: 760px;
    margin: 0 auto;
    padding: 12px 14px;
    color: #111;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.14);
    border-radius: 10px;
    box-shadow: 0 8px 28px rgba(0, 0, 0, 0.18);
    font-family: Arial, sans-serif;
    font-size: 13px;
    line-height: 1.4;
}

.mri-cookie-consent__text {
    flex: 1 1 auto;
    min-width: 0;
}

.mri-cookie-consent a {
    color: inherit;
    font-weight: 600;
    text-decoration: underline;
}

.mri-cookie-consent__buttons {
    display: flex;
    flex: 0 0 auto;
    gap: 7px;
}

.mri-cookie-consent__button {
    min-height: 34px;
    padding: 6px 11px;
    border: 1px solid #111;
    border-radius: 7px;
    cursor: pointer;
    font: inherit;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.mri-cookie-consent__button--primary {
    color: #111;
    background: #ffcb70;
    border-color: #ffcb70;
}

.mri-cookie-consent__button--secondary {
    color: #111;
    background: #fff;
}

.mri-cookie-consent__button:hover {
    opacity: 0.82;
}

.mri-cookie-consent__button:focus-visible,
.mri-cookie-settings:focus-visible {
    outline: 2px solid #111;
    outline-offset: 2px;
}

.mri-cookie-settings {
    position: fixed;
    z-index: 2147482999;
    left: 10px;
    bottom: 10px;
    padding: 4px 7px;
    color: #444;
    background: rgba(255, 255, 255, 0.94);
    border: 1px solid rgba(0, 0, 0, 0.18);
    border-radius: 6px;
    cursor: pointer;
    font-family: Arial, sans-serif;
    font-size: 11px;
    line-height: 1.3;
    text-decoration: underline;
}

@media (max-width: 650px) {
    .mri-cookie-consent {
        right: 8px;
        bottom: 8px;
        left: 8px;
        display: block;
        padding: 11px;
    }

    .mri-cookie-consent__buttons {
        margin-top: 9px;
    }

    .mri-cookie-consent__button {
        flex: 1 1 auto;
    }
}
</style>
<script>
(function () {
    'use strict';
    var key = 'mrigroup_cookie_notice_v3';
    var banner;

    function showBanner() {
        if (banner) banner.hidden = false;
    }

    function isDismissed() {
        try {
            if (localStorage.getItem(key) === '1') return true;
        } catch (error) {}
        return document.cookie.split(';').some(function (part) {
            return part.trim() === key + '=1';
        });
    }

    function dismiss() {
        try { localStorage.setItem(key, '1'); } catch (error) {}
        document.cookie = key + '=1; Max-Age=15552000; Path=/; SameSite=Lax' +
            (location.protocol === 'https:' ? '; Secure' : '');
        if (banner) banner.hidden = true;
    }

    // Legacy service-loader compatibility: true means services are enabled
    // by site configuration. It does NOT record visitor consent.
    // Existing consent records are not modified or fabricated.
    window.MriCookieConsent = {
        get: function () { return null; },
        hasAnalytics: function () { return true; },
        open: showBanner
    };

    function init() {
        banner = document.getElementById('mriCookieConsent');
        var button = document.getElementById('mriCookieNoticeClose');
        if (banner && button) {
            banner.hidden = isDismissed();
            button.addEventListener('click', dismiss);
        }
        var detail = {value: null, analytics: true, mode: 'notice'};
        var event;
        if (typeof CustomEvent === 'function') {
            event = new CustomEvent('mriCookieConsentReady', {detail: detail});
        } else {
            event = document.createEvent('CustomEvent');
            event.initCustomEvent('mriCookieConsentReady', false, false, detail);
        }
        window.dispatchEvent(event);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
