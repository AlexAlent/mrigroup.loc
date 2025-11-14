<div id="cookieConsent" class="cookie-consent">
    <button class="close-button" onclick="handleCookieClose()">✕</button>
    <p class="cookie-text">
        Мы используем файлы cookie, чтобы улучшить работу сайта и предоставить вам больше возможностей.
    </p>
    <p class="cookie-text">
        Продолжая использовать сайт, вы соглашаетесь с <a href="/usloviya-ispolzovaniya-cookies/" target="_blank"
                                                          rel="nofollow">условиями использования cookie</a>.
    </p>
    <button class="btn btn-outline-primary" onclick="handleCookieAccept()">
        Принять
    </button>
</div>
<script>
    function checkCookieConsent() {
        const hasConsent = localStorage.getItem('cookieConsent');
        const consentElement = document.getElementById('cookieConsent');

        if (!hasConsent) {
            consentElement.classList.add('show');
        }
    }

    function handleCookieAccept() {
        localStorage.setItem('cookieConsent', 'accepted');
        document.getElementById('cookieConsent').classList.remove('show');
    }

    function handleCookieClose() {
        localStorage.setItem('cookieConsent', 'closed');
        document.getElementById('cookieConsent').classList.remove('show');
    }

    // Проверяем при загрузке страницы
    document.addEventListener('DOMContentLoaded', checkCookieConsent);
</script>
