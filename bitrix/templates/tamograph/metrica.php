<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$metricIds = [
    'ekb'  => 90772206,
    'kzn'  => 90772237,
    'krd'  => 90772220,
    'msk'  => 90772172,
    'nn'   => 90772248,
    'rnd'  => 90772267,
    'spb'  => 90772292,
    'chlb' => 90772190,
    'nsk'  => 90772260,
    'smr'  => 90772278,
];

$host = strtolower((string)($_SERVER['HTTP_HOST'] ?? ''));
$host = preg_replace('/:\d+$/', '', $host);
$hostParts = explode('.', $host);
$subdomain = $hostParts[0] ?? '';

if ($subdomain === 'www' || count($hostParts) < 3) {
    $subdomain = '';
}

$metricId = $metricIds[$subdomain] ?? 88017604;
?>

<script>
(function () {
    'use strict';

    var counterId = <?= (int)$metricId ?>;
    var initializedFlag = '__mriYandexMetrikaInitialized_' + counterId;
    var loadingFlag = '__mriYandexMetrikaLoading';

    var metrikaSources = [
        'https://mc.yandex.ru/metrika/tag.js',
        'https://mc.yandex.com/metrika/tag.js'
    ];

    function analyticsAllowed() {
        return Boolean(
            window.MriCookieConsent &&
            window.MriCookieConsent.hasAnalytics()
        );
    }

    function prepareMetrikaQueue() {
        window.ym = window.ym || function () {
            (window.ym.a = window.ym.a || []).push(arguments);
        };

        window.ym.l = window.ym.l || Date.now();
    }

    function loadMetrikaScript(sourceIndex) {
        if (sourceIndex >= metrikaSources.length) {
            window[loadingFlag] = false;
            window[initializedFlag] = false;

            console.error(
                'Не удалось загрузить Яндекс Метрику ни с одного домена.'
            );

            return;
        }

        var script = document.createElement('script');

        script.async = true;
        script.src = metrikaSources[sourceIndex];
        script.setAttribute(
            'data-mri-metrika-source',
            String(sourceIndex)
        );

        script.onload = function () {
            window[loadingFlag] = false;
        };

        script.onerror = function () {
            script.remove();

            loadMetrikaScript(sourceIndex + 1);
        };

        document.head.appendChild(script);
    }

    function addMetrikaScript() {
        if (window[loadingFlag]) {
            return;
        }

        if (
            document.querySelector(
                'script[data-mri-metrika-loaded="true"]'
            )
        ) {
            return;
        }

        window[loadingFlag] = true;

        prepareMetrikaQueue();
        loadMetrikaScript(0);
    }

    function startMetrika() {
        if (!analyticsAllowed() || window[initializedFlag]) {
            return;
        }

        addMetrikaScript();

        window.ym(counterId, 'init', {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });

        window[initializedFlag] = true;
    }

    function stopMetrika() {
        if (!window[initializedFlag]) {
            return;
        }

        if (typeof window.ym === 'function') {
            try {
                window.ym(counterId, 'destruct');
            } catch (error) {
            }
        }

        window[initializedFlag] = false;
    }

    window.addEventListener(
        'mriCookieConsentReady',
        function (event) {
            if (event.detail && event.detail.analytics) {
                startMetrika();
            } else {
                stopMetrika();
            }
        }
    );

    window.addEventListener(
        'mriCookieConsentChanged',
        function (event) {
            if (event.detail && event.detail.analytics) {
                startMetrika();
            } else {
                stopMetrika();
            }
        }
    );

    startMetrika();
})();
</script>