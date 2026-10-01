<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

$formId = 'get-call-' . preg_replace(
    '/[^a-zA-Z0-9_-]/',
    '',
    (string)$arResult['PARAMS_HASH']
);
?>

<div class="mfeedback">
    <?php if (!empty($arResult['ERROR_MESSAGE'])): ?>
        <?php foreach ($arResult['ERROR_MESSAGE'] as $error): ?>
            <?php ShowError($error); ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($arResult['OK_MESSAGE'])): ?>
        <div class="mf-ok-text">
            <?= htmlspecialcharsbx($arResult['OK_MESSAGE']) ?>
        </div>
    <?php else: ?>
        <form
            id="<?= htmlspecialcharsbx($formId) ?>"
            action="<?= POST_FORM_ACTION_URI ?>"
            method="POST"
            novalidate
            autocomplete="off"
        >
            <?= bitrix_sessid_post() ?>

            <input
                type="hidden"
                name="PARAMS_HASH"
                value="<?= htmlspecialcharsbx($arResult['PARAMS_HASH']) ?>"
            >

            <input
                type="hidden"
                name="consent_version"
                value="2026-07-06"
            >

            <div class="mri-form-honeypot" aria-hidden="true">
                <input
                    type="text"
                    name="website_url"
                    value=""
                    tabindex="-1"
                    autocomplete="off"
                >
                <input
                    type="text"
                    name="phone_field"
                    value=""
                    tabindex="-1"
                    autocomplete="off"
                >
                <input
                    type="text"
                    name="email_field"
                    value=""
                    tabindex="-1"
                    autocomplete="off"
                >
            </div>

            <div class="mf-name">
                <div class="mf-text">
                    <?= GetMessage('MFT_NAME') ?>
                    <span class="mf-req">*</span>
                </div>

                <input
                    type="text"
                    name="user_name"
                    value="<?= htmlspecialcharsbx($arResult['AUTHOR_NAME'] ?? '') ?>"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="so_mf mf-phone">
                <div class="mf-text">
                    Ваш телефон
                    <span class="mf-req">*</span>
                </div>

                <input
                    type="tel"
                    name="user_phone"
                    value="<?= htmlspecialcharsbx($arResult['user_phone'] ?? '') ?>"
                    placeholder="+7 (___) ___-__-__"
                    inputmode="tel"
                    autocomplete="tel"
                    maxlength="18"
                    required
                >
            </div>

            <div class="mf-message">
                <div class="mf-text">
                    <?= GetMessage('MFT_MESSAGE') ?>
                </div>

                <textarea
                    name="MESSAGE"
                    rows="5"
                    cols="40"
                ><?= htmlspecialcharsbx($arResult['MESSAGE'] ?? '') ?></textarea>
            </div>

            <?php if ($arParams['USE_CAPTCHA'] === 'Y'): ?>
                <div class="mf-captcha">
                    <div class="mf-text">
                        <?= GetMessage('MFT_CAPTCHA') ?>
                    </div>

                    <input
                        type="hidden"
                        name="captcha_sid"
                        value="<?= htmlspecialcharsbx($arResult['capCode']) ?>"
                    >

                    <div class="mf-captcha-row">
                        <img
                            class="mf-captcha-image"
                            src="/bitrix/tools/captcha.php?captcha_sid=<?= urlencode($arResult['capCode']) ?>"
                            width="180"
                            height="40"
                            alt="CAPTCHA"
                        >

                        <button
                            type="button"
                            class="mf-captcha-refresh"
                        >
                            Обновить код
                        </button>
                    </div>

                    <div class="mf-text">
                        <?= GetMessage('MFT_CAPTCHA_CODE') ?>
                        <span class="mf-req">*</span>
                    </div>

                    <input
                        type="text"
                        name="captcha_word"
                        maxlength="50"
                        value=""
                        autocomplete="off"
                        required
                    >
                </div>
            <?php endif; ?>

            <div class="consent-form">
                <div class="form-check">
                    <label class="form-check-label">
                        <input
                            type="checkbox"
                            name="personal-data"
                            value="yes"
                            required
                            <?= !empty($arResult['personal-data']) ? 'checked' : '' ?>
                        >
                        <span class="form-check-icon"></span>
                        <span class="form-check-text">
                            Я даю своё
                            <a
                                href="/soglasie-na-obrabotku-personalnykh-dannykh/"
                                target="_blank"
                                rel="noopener nofollow"
                                class="consent-link"
                            >
                                согласие на обработку персональных данных
                            </a>.
                            <span class="mf-req" aria-hidden="true">*</span>
                        </span>
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input
                            type="checkbox"
                            name="privacy"
                            value="yes"
                            required
                            <?= !empty($arResult['privacy']) ? 'checked' : '' ?>
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
                            </a>.
                            <span class="mf-req" aria-hidden="true">*</span>
                        </span>
                    </label>
                </div>

                <div class="form-check">
                    <label class="form-check-label">
                        <input
                            type="checkbox"
                            name="advertising"
                            value="yes"
                            <?= !empty($arResult['advertising']) ? 'checked' : '' ?>
                        >
                        <span class="form-check-icon"></span>
                        <span class="form-check-text">
                            Я даю своё
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

            <input
                type="submit"
                name="submit"
                value="<?= GetMessage('MFT_SUBMIT') ?>"
                disabled
                aria-disabled="true"
            >
        </form>
    <?php endif; ?>
</div>

<style>
.mri-form-honeypot {
    position: absolute !important;
    left: -9999px !important;
    top: -9999px !important;
    width: 1px !important;
    height: 1px !important;
    overflow: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

.mfeedback .mf-captcha {
    margin: 14px 0;
}

.mfeedback .mf-captcha-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 7px 0 10px;
}

.mfeedback .mf-captcha-image {
    display: block;
    width: 180px;
    height: 40px;
    background: #fff;
    border: 1px solid #d7d7d7;
}

.mfeedback .mf-captcha-refresh {
    padding: 6px 0;
    color: #555;
    background: transparent;
    border: 0;
    cursor: pointer;
    font: inherit;
    text-decoration: underline;
}

.mfeedback .consent-form {
    display: grid;
    gap: 10px;
    margin-top: 16px;
}

.mfeedback input[type="submit"]:disabled {
    cursor: not-allowed !important;
    opacity: 0.42;
    filter: grayscale(0.35);
}

@media (max-width: 520px) {
    .mfeedback .mf-captcha-row {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>

<style>
/* Компактное оформление формы обратного звонка */
.modal_form {
    width: 520px;
    padding: 38px 30px 30px;
    border-radius: 14px;
}

.mfeedback,
.mfeedback form,
.mfeedback input,
.mfeedback textarea,
.mfeedback button,
.mfeedback label {
    font-family: inherit;
}

.mfeedback form {
    display: block;
}

.mfeedback .mf-name,
.mfeedback .mf-phone,
.mfeedback .mf-message,
.mfeedback .mf-captcha {
    width: 100% !important;
    margin: 0 0 12px !important;
    box-sizing: border-box;
}

.mfeedback .mf-text {
    margin: 0 0 5px;
    color: #111;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.3;
}

.mfeedback .mf-req {
    color: #e53935;
}

.mfeedback input[type="text"],
.mfeedback input[type="tel"],
.mfeedback input[type="email"],
.mfeedback textarea {
    width: 100% !important;
    min-width: 0;
    min-height: 46px;
    margin: 0 !important;
    padding: 10px 14px;
    box-sizing: border-box;
    color: #111;
    background: #fff;
    border: 1px solid #e1e5eb;
    border-radius: 10px;
    font-size: 15px;
    line-height: 1.35;
    box-shadow: none;
}

.mfeedback input[type="text"]:focus,
.mfeedback input[type="tel"]:focus,
.mfeedback input[type="email"]:focus,
.mfeedback textarea:focus {
    border-color: #f4a11a;
    outline: 2px solid rgba(244, 161, 26, 0.14);
}

.mfeedback textarea {
    display: block;
    width: 100% !important;
    height: 46px;
    min-height: 46px;
    max-height: 180px;
    resize: vertical;
    overflow: auto;
}

.mfeedback .mf-captcha {
    padding-top: 2px;
}

.mfeedback .mf-captcha-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 5px 0 8px;
}

.mfeedback .mf-captcha-image {
    width: 150px;
    height: 38px;
    object-fit: contain;
    border-radius: 4px;
}

.mfeedback .mf-captcha-refresh {
    padding: 4px 0;
    color: #555;
    font-size: 13px;
    line-height: 1.3;
}

.mfeedback .consent-form {
    display: grid;
    gap: 7px;
    margin: 5px 0 14px;
}

.mfeedback .form-check {
    margin: 0 !important;
    padding: 0 !important;
}

.mfeedback .form-check-label {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    width: 100%;
    margin: 0;
    cursor: pointer;
}

.mfeedback .form-check-text {
    display: block;
    margin: 0;
    color: #252525;
    font-size: 12.5px;
    font-weight: 400;
    line-height: 1.35;
}

.mfeedback .form-check-text a {
    color: #59636f;
    text-decoration: underline;
    text-underline-offset: 2px;
}

.mfeedback .form-check-icon {
    flex: 0 0 auto;
    margin-top: 1px;
}

.mfeedback input[type="submit"] {
    min-width: 150px;
    min-height: 44px;
    margin: 0 !important;
    padding: 10px 24px;
    border: 1px solid #c99434;
    border-radius: 10px;
    font-size: 15px;
    line-height: 1.2;
}

.mfeedback .mf-ok-text,
.mfeedback .errortext {
    font-size: 14px;
    line-height: 1.4;
}

@media (max-width: 600px) {
    .modal_form {
        width: 100%;
        padding: 42px 18px 22px;
        border-radius: 12px;
    }

    .mfeedback .mf-captcha-row {
        align-items: flex-start;
        flex-direction: row;
        flex-wrap: wrap;
    }

    .mfeedback input[type="submit"] {
        width: 100%;
    }
}
</style>

<script>
(function () {
    'use strict';

    var form = document.getElementById(
        <?= json_encode($formId, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>
    );

    if (!form) {
        return;
    }

    var nameField = form.querySelector(
        'input[name="user_name"]'
    );
    var phoneField = form.querySelector(
        'input[name="user_phone"]'
    );
    var captchaField = form.querySelector(
        'input[name="captcha_word"]'
    );
    var captchaSidField = form.querySelector(
        'input[name="captcha_sid"]'
    );
    var captchaImage = form.querySelector(
        '.mf-captcha-image'
    );
    var captchaRefresh = form.querySelector(
        '.mf-captcha-refresh'
    );
    var personalDataField = form.querySelector(
        'input[name="personal-data"]'
    );
    var privacyField = form.querySelector(
        'input[name="privacy"]'
    );
    var submitButton = form.querySelector(
        'input[type="submit"]'
    );

    function getPhoneDigits(value) {
        var digits = String(value || '').replace(/\D/g, '');

        if (!digits) {
            return '';
        }

        if (digits.charAt(0) === '8') {
            digits = '7' + digits.substring(1);
        } else if (digits.charAt(0) !== '7') {
            digits = '7' + digits;
        }

        return digits.substring(0, 11);
    }

    function formatPhone(value) {
        var digits = getPhoneDigits(value);

        if (!digits) {
            return '';
        }

        var local = digits.substring(1);
        var result = '+7';

        if (local.length > 0) {
            result += ' (' + local.substring(0, 3);
        }

        if (local.length >= 3) {
            result += ')';
        }

        if (local.length > 3) {
            result += ' ' + local.substring(3, 6);
        }

        if (local.length > 6) {
            result += '-' + local.substring(6, 8);
        }

        if (local.length > 8) {
            result += '-' + local.substring(8, 10);
        }

        return result;
    }

    function phoneIsValid() {
        var digits = getPhoneDigits(
            phoneField ? phoneField.value : ''
        );

        return (
            digits.length === 11
            && digits.charAt(0) === '7'
        );
    }

    function updateSubmitButton() {
        if (!submitButton) {
            return;
        }

        var valid = Boolean(
            nameField
            && nameField.value.trim().length >= 2
            && phoneIsValid()
            && personalDataField
            && personalDataField.checked
            && privacyField
            && privacyField.checked
            && (
                !captchaField
                || captchaField.value.trim().length > 0
            )
        );

        submitButton.disabled = !valid;
        submitButton.setAttribute(
            'aria-disabled',
            valid ? 'false' : 'true'
        );
    }

    function movePhoneCursorToEnd() {
        window.setTimeout(function () {
            if (!phoneField) {
                return;
            }

            try {
                var length = phoneField.value.length;
                phoneField.setSelectionRange(length, length);
            } catch (error) {
            }
        }, 0);
    }

    if (phoneField) {
        phoneField.addEventListener('input', function () {
            phoneField.value = formatPhone(phoneField.value);
            movePhoneCursorToEnd();
            updateSubmitButton();
        });

        phoneField.addEventListener('focus', function () {
            if (!phoneField.value) {
                return;
            }

            window.setTimeout(function () {
                try {
                    phoneField.select();
                } catch (error) {
                }
            }, 0);
        });

        phoneField.addEventListener('paste', function () {
            window.setTimeout(function () {
                phoneField.value = formatPhone(
                    phoneField.value
                );
                movePhoneCursorToEnd();
                updateSubmitButton();
            }, 0);
        });

        if (phoneField.value) {
            phoneField.value = formatPhone(
                phoneField.value
            );
        }
    }

    form.addEventListener('input', updateSubmitButton);
    form.addEventListener('change', updateSubmitButton);

    if (
        captchaRefresh
        && captchaSidField
        && captchaImage
        && captchaField
    ) {
        captchaRefresh.addEventListener(
            'click',
            function () {
                captchaRefresh.disabled = true;

                fetch('/local/forms/captcha.php', {
                    credentials: 'same-origin',
                    cache: 'no-store'
                })
                    .then(function (response) {
                        if (!response.ok) {
                            throw new Error(
                                'Captcha request failed'
                            );
                        }

                        return response.json();
                    })
                    .then(function (data) {
                        if (!data.sid) {
                            throw new Error(
                                'Captcha SID is missing'
                            );
                        }

                        captchaSidField.value = data.sid;
                        captchaField.value = '';

                        captchaImage.src =
                            '/bitrix/tools/captcha.php?captcha_sid='
                            + encodeURIComponent(data.sid)
                            + '&rand='
                            + Date.now();

                        updateSubmitButton();
                    })
                    .catch(function () {
                        window.alert(
                            'Не удалось обновить код. Попробуйте ещё раз.'
                        );
                    })
                    .finally(function () {
                        captchaRefresh.disabled = false;
                    });
            }
        );
    }

    updateSubmitButton();
})();
</script>
