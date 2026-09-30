<div
    id="mriCookieConsent"
    class="mri-cookie-consent"
    role="dialog"
    aria-modal="true"
    aria-label="Настройки файлов cookie"
    hidden
>
    <div class="mri-cookie-consent__text">
        Мы используем cookie и дополнительные сервисы, чтобы сайт работал лучше.
        <a
            href="/usloviya-ispolzovaniya-cookies/"
            target="_blank"
            rel="noopener nofollow"
        >
            Подробнее
        </a>
    </div>

    <div class="mri-cookie-consent__buttons">
        <button
            type="button"
            class="mri-cookie-consent__button mri-cookie-consent__button--secondary"
            id="mriCookieNecessary"
        >
            Только необходимые
        </button>

        <button
            type="button"
            class="mri-cookie-consent__button mri-cookie-consent__button--primary"
            id="mriCookieAnalytics"
        >
            Разрешить
        </button>
    </div>
</div>

<button
    type="button"
    id="mriCookieSettings"
    class="mri-cookie-settings"
    hidden
>
    Настройки cookie
</button>

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

    var STORAGE_KEY = 'mrigroup_cookie_consent_v2';
    var COOKIE_NAME = 'mrigroup_cookie_consent_v2';

    var OLD_STORAGE_KEYS = [
        'mrigroup_cookie_consent_v1',
        'cookieConsent'
    ];

    var OLD_COOKIE_NAMES = [
        'mrigroup_cookie_consent_v1'
    ];

    var CONSENT_ANALYTICS = 'analytics';
    var CONSENT_NECESSARY = 'necessary';

    var banner = null;
    var settingsButton = null;
    var necessaryButton = null;
    var analyticsButton = null;

    function readCookie(name) {
        var cookies = document.cookie
            ? document.cookie.split(';')
            : [];

        for (var i = 0; i < cookies.length; i++) {
            var cookie = cookies[i].trim();
            var prefix = name + '=';

            if (cookie.indexOf(prefix) === 0) {
                return decodeURIComponent(
                    cookie.substring(prefix.length)
                );
            }
        }

        return null;
    }

    function getConsent() {
        var value = null;

        try {
            value = localStorage.getItem(STORAGE_KEY);
        } catch (error) {
            value = null;
        }

        if (!value) {
            value = readCookie(COOKIE_NAME);
        }

        if (
            value !== CONSENT_ANALYTICS &&
            value !== CONSENT_NECESSARY
        ) {
            return null;
        }

        return value;
    }

    function deleteCookie(name, domain) {
        var cookie = name + '=; Max-Age=0; Path=/; SameSite=Lax';

        if (domain) {
            cookie += '; Domain=' + domain;
        }

        if (window.location.protocol === 'https:') {
            cookie += '; Secure';
        }

        document.cookie = cookie;
    }

    function removeOldConsentValues() {
        try {
            OLD_STORAGE_KEYS.forEach(function (key) {
                localStorage.removeItem(key);
            });
        } catch (error) {
        }

        OLD_COOKIE_NAMES.forEach(function (name) {
            deleteCookie(name);
        });
    }

    function saveConsent(value) {
        try {
            localStorage.setItem(STORAGE_KEY, value);
        } catch (error) {
        }

        var cookie = COOKIE_NAME + '=' + encodeURIComponent(value);
        cookie += '; Max-Age=15552000';
        cookie += '; Path=/';
        cookie += '; SameSite=Lax';

        if (window.location.protocol === 'https:') {
            cookie += '; Secure';
        }

        document.cookie = cookie;

        removeOldConsentValues();
    }

    function clearKnownAnalyticsCookies() {
        var prefixes = [
            '_ym_',
            '_ga',
            '_gid',
            '_gat',
            '_gcl_',
            '_fbp',
            '_fbc',
            'roistat'
        ];

        var host = window.location.hostname;
        var hostParts = host.split('.');

        var rootDomain = hostParts.length >= 2
            ? '.' + hostParts.slice(-2).join('.')
            : null;

        var cookies = document.cookie
            ? document.cookie.split(';')
            : [];

        cookies.forEach(function (cookiePart) {
            var cookieName = cookiePart
                .split('=')[0]
                .trim();

            var shouldDelete = prefixes.some(function (prefix) {
                return cookieName.indexOf(prefix) === 0;
            });

            if (!shouldDelete) {
                return;
            }

            deleteCookie(cookieName);
            deleteCookie(cookieName, host);
            deleteCookie(cookieName, '.' + host);

            if (rootDomain) {
                deleteCookie(cookieName, rootDomain);
            }
        });
    }

    function showBanner() {
        if (!banner) {
            return;
        }

        banner.hidden = false;

        if (settingsButton) {
            settingsButton.hidden = true;
        }

        window.setTimeout(function () {
            if (necessaryButton) {
                necessaryButton.focus();
            }
        }, 0);
    }

    function hideBanner() {
        if (banner) {
            banner.hidden = true;
        }

        if (settingsButton) {
            settingsButton.hidden = false;
        }
    }

    function dispatchConsentEvent(eventName, value) {
        var detail = {
            value: value,
            analytics: value === CONSENT_ANALYTICS
        };

        var event;

        try {
            event = new CustomEvent(eventName, {
                detail: detail
            });
        } catch (error) {
            event = document.createEvent('CustomEvent');
            event.initCustomEvent(
                eventName,
                false,
                false,
                detail
            );
        }

        window.dispatchEvent(event);
    }

    function setConsent(value) {
        saveConsent(value);

        if (value === CONSENT_NECESSARY) {
            clearKnownAnalyticsCookies();
        }

        hideBanner();

        dispatchConsentEvent(
            'mriCookieConsentChanged',
            value
        );
    }

    window.MriCookieConsent = {
        get: getConsent,

        hasAnalytics: function () {
            return getConsent() === CONSENT_ANALYTICS;
        },

        setNecessary: function () {
            setConsent(CONSENT_NECESSARY);
        },

        setAnalytics: function () {
            setConsent(CONSENT_ANALYTICS);
        },

        open: showBanner
    };

    function initCookieConsent() {
        banner = document.getElementById(
            'mriCookieConsent'
        );

        settingsButton = document.getElementById(
            'mriCookieSettings'
        );

        necessaryButton = document.getElementById(
            'mriCookieNecessary'
        );

        analyticsButton = document.getElementById(
            'mriCookieAnalytics'
        );

        if (
            !banner ||
            !settingsButton ||
            !necessaryButton ||
            !analyticsButton
        ) {
            return;
        }

        necessaryButton.addEventListener(
            'click',
            function () {
                setConsent(CONSENT_NECESSARY);
            }
        );

        analyticsButton.addEventListener(
            'click',
            function () {
                setConsent(CONSENT_ANALYTICS);
            }
        );

        settingsButton.addEventListener(
            'click',
            function () {
                showBanner();
            }
        );

        var currentConsent = getConsent();

        if (currentConsent === CONSENT_ANALYTICS) {
            hideBanner();
        } else if (currentConsent === CONSENT_NECESSARY) {
            clearKnownAnalyticsCookies();
            hideBanner();
        } else {
            showBanner();
        }

        dispatchConsentEvent(
            'mriCookieConsentReady',
            currentConsent
        );
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initCookieConsent
        );
    } else {
        initCookieConsent();
    }
})();
</script>