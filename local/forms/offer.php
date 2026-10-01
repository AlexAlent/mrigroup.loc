<?php

require_once(
    $_SERVER['DOCUMENT_ROOT']
    . '/bitrix/modules/main/include/prolog_before.php'
);

$id = 0;
$name = '';
$set = '';

$element = MrigroupHelper::getModalOfferElementById(
    isset($_REQUEST['id'])
        ? (int)$_REQUEST['id']
        : 0
);

if ($element) {
    $id = (int)$element['ID'];
    $name = trim((string)$element['NAME']);

    if (
        (int)$element['IBLOCK_ID'] === 22
        && isset($_REQUEST['set'])
        && trim((string)$_REQUEST['set']) !== ''
    ) {
        $set = trim(strip_tags((string)$_REQUEST['set']));
        $name .= ' (Комплектация ' . $set . ')';
    }
}

?>

<div class="modal-outer">

    <?php if ($name !== ''): ?>

        <div class="modal-overline">
            Коммерческое предложение
        </div>

        <div class="modal-title">
            <?=htmlspecialcharsbx($name)?>
        </div>

        <form
            data-xhr-action="/local/forms/send.php"
            data-add-b24trace="true"
            method="POST"
            class="modal-form offer-form form"
            novalidate="novalidate"
            autocomplete="off"
        >
            <input
                type="hidden"
                name="id"
                value="<?php echo $id; ?>"
            >

            <input
                type="hidden"
                name="type"
                value="offer"
            >

            <input
                type="hidden"
                name="submit_time"
                value="<?php echo time(); ?>"
            >

            <input
                type="hidden"
                name="consent_version"
                value="2026-07-06"
            >

            <input
                type="text"
                name="website_url"
                value=""
                style="display:none!important"
                tabindex="-1"
                autocomplete="off"
            >

            <input
                type="text"
                name="phone_field"
                value=""
                style="display:none!important"
                tabindex="-1"
                autocomplete="off"
            >

            <input
                type="text"
                name="email_field"
                value=""
                style="display:none!important"
                tabindex="-1"
                autocomplete="off"
            >

            <?php if ($set !== ''): ?>
                <input
                    type="hidden"
                    name="set"
                    value="<?=htmlspecialcharsbx($set)?>"
                >
            <?php endif; ?>

            
<?php
global $APPLICATION;

$captchaCode = htmlspecialcharsbx(
    $APPLICATION->CaptchaGetCode()
);
?>

<div class="form-group">
    <input
        type="hidden"
        name="captcha_sid"
        value="<?php echo $captchaCode; ?>"
    >

    <img
        id="offer-captcha-img"
        src="/bitrix/tools/captcha.php?captcha_sid=<?php echo $captchaCode; ?>"
        width="180"
        height="40"
        alt="Защитный код"
    >

    <button
        type="button"
        id="offer-captcha-refresh"
        class="btn btn-outline-secondary btn-sm"
        aria-label="Обновить защитный код"
    >
        ↻ Обновить
    </button>

    <input
        type="text"
        name="captcha_word"
        class="form-control"
        placeholder="Введите код с картинки"
        required
        autocomplete="off"
    >
</div>


            <div class="row">

                <div class="col-12">
                    <div class="form-group">
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Имя"
                            required
                        >
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <input
                            type="tel"
                            name="phone"
                            class="form-control mask-phone"
                            placeholder="Телефон"
                            required
                        >
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <textarea
                            name="message"
                            class="form-control"
                            placeholder="Ваш вопрос"
                        ></textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">
                            Удобное время для звонка
                        </label>

                        <div
                            class="form-range double-range time-range"
                        >
                            <input
                                type="text"
                                name="time_from"
                                value="10:00"
                                class="form-range-input input-from form-control"
                            >

                            <input
                                type="text"
                                name="time_to"
                                value="20:00"
                                class="form-range-input input-to form-control"
                            >

                            <div
                                class="form-range-slider input-slider"
                                data-min="08:00"
                                data-max="22:00"
                                data-start="10:00"
                                data-end="20:00"
                                data-step="30"
                            ></div>
                        </div>
                    </div>
                </div>

            </div>

            
<div class="row">
    <div class="col-12">
        <div class="consent-form">

            <div class="form-check">
                <label class="form-check-label">
                    <input
                        type="checkbox"
                        name="personal-data"
                        required
                    >

                    <span class="form-check-icon"></span>

                    <span class="form-check-text">
                        Я даю
                        <a
                            href="/soglasie-na-obrabotku-personalnykh-dannykh/"
                            target="_blank"
                            rel="noopener nofollow"
                            class="consent-link"
                        >
                            согласие на обработку персональных данных
                        </a><span aria-hidden="true">*</span>.
                    </span>
                </label>
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input
                        type="checkbox"
                        name="privacy"
                        required
                    >

                    <span class="form-check-icon"></span>

                    <span class="form-check-text">
                        Я подтверждаю, что ознакомлен с
                        <a
                            href="/politika-obrabotki-personalnykh-dannykh/"
                            target="_blank"
                            rel="noopener nofollow"
                            class="consent-link"
                        >
                            политикой обработки персональных данных
                        </a><span aria-hidden="true">*</span>.
                    </span>
                </label>
            </div>

            <div class="form-check">
                <label class="form-check-label">
                    <input
                        type="checkbox"
                        name="advertising"
                    >

                    <span class="form-check-icon"></span>

                    <span class="form-check-text">
                        Я даю
                        <a
                            href="/soglasie-na-poluchenie-reklamnoy-informatsii/"
                            target="_blank"
                            rel="noopener nofollow"
                            class="consent-link"
                        >
                            согласие на получение рекламной информации
                        </a>.
                    </span>
                </label>
            </div>

        </div>
    </div>
</div>


            <div class="row">
                <div class="col-12">
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Отправить запрос
                    </button>
                </div>
            </div>

        </form>

        
<script>
(function () {
    'use strict';

    var button = document.getElementById(
        'offer-captcha-refresh'
    );

    if (!button) {
        return;
    }

    button.addEventListener('click', function () {
        fetch('/local/forms/captcha.php', {
            credentials: 'same-origin'
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                if (!data.sid) {
                    return;
                }

                var image = document.getElementById(
                    'offer-captcha-img'
                );

                var form = button.closest('form');

                if (!form) {
                    return;
                }

                var sidInput = form.querySelector(
                    'input[name="captcha_sid"]'
                );

                var wordInput = form.querySelector(
                    'input[name="captcha_word"]'
                );

                if (sidInput) {
                    sidInput.value = data.sid;
                }

                if (image) {
                    image.src =
                        '/bitrix/tools/captcha.php?captcha_sid='
                        + encodeURIComponent(data.sid)
                        + '&rand='
                        + Math.random();
                }

                if (wordInput) {
                    wordInput.value = '';
                    wordInput.focus();
                }
            });
    });
})();
</script>


    <?php else: ?>

        <div class="modal-title">
            Произошла ошибка
        </div>

    <?php endif; ?>

</div>
