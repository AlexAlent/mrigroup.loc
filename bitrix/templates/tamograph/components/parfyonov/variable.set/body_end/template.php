<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>

<script>
(function () {
    'use strict';

    var servicesStarted = false;

    function analyticsAllowed() {
        return Boolean(
            window.MriCookieConsent &&
            window.MriCookieConsent.hasAnalytics()
        );
    }

    function loadMango() {
        if (document.getElementById('mango-js')) {
            return;
        }

        window.MangoObject = 'mgo';

        window.mgo = window.mgo || function () {
            (window.mgo.q = window.mgo.q || []).push(arguments);
        };

        window.mgo.u = 'https://widgets.mango-office.ru/widgets/mango.js';
        window.mgo.t = Date.now();

        window.mgo({
            calltracking: {
                id: 28701,
                elements: [
                    {
                        selector: 'a[href^="tel"]'
                    }
                ],
                domain: 'mrigroup.ru'
            }
        });

        var script = document.createElement('script');
        script.async = true;
        script.id = 'mango-js';
        script.src = window.mgo.u;

        document.head.appendChild(script);
    }

    function loadBitrixWidget() {
        if (document.getElementById('mri-bitrix-widget')) {
            return;
        }

        var script = document.createElement('script');
        script.async = true;
        script.id = 'mri-bitrix-widget';
        script.src =
            'https://corp.mrigroup.ru/upload/crm/site_button/' +
            'loader_2_28qbq8.js?' +
            Math.floor(Date.now() / 60000);

        document.head.appendChild(script);
    }

    function startOptionalServices() {
        if (!analyticsAllowed() || servicesStarted) {
            return;
        }

        servicesStarted = true;

        loadMango();
        loadBitrixWidget();
    }

    window.addEventListener(
        'mriCookieConsentReady',
        function (event) {
            if (event.detail && event.detail.analytics) {
                startOptionalServices();
            }
        }
    );

    window.addEventListener(
        'mriCookieConsentChanged',
        function (event) {
            if (event.detail && event.detail.analytics) {
                startOptionalServices();
                return;
            }

            if (servicesStarted) {
                window.location.reload();
            }
        }
    );

    startOptionalServices();
})();
</script>