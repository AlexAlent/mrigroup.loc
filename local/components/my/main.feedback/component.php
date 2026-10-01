<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

require_once(
    $_SERVER['DOCUMENT_ROOT']
    . '/local/include/consent-evidence.php'
);

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

$arResult['PARAMS_HASH'] = md5(
    serialize($arParams) . $this->GetTemplateName()
);

/*
 * CAPTCHA показываем всем посетителям, включая авторизованных
 * администраторов, если параметр USE_CAPTCHA включён.
 */
$arParams['USE_CAPTCHA'] =
    (($arParams['USE_CAPTCHA'] ?? 'N') === 'Y') ? 'Y' : 'N';

$arParams['EVENT_NAME'] = trim((string)($arParams['EVENT_NAME'] ?? ''));

if ($arParams['EVENT_NAME'] === '') {
    $arParams['EVENT_NAME'] = 'FEEDBACK_FORM';
}

$arParams['EMAIL_TO'] = trim((string)($arParams['EMAIL_TO'] ?? ''));

if ($arParams['EMAIL_TO'] === '') {
    $arParams['EMAIL_TO'] = COption::GetOptionString(
        'main',
        'email_from'
    );
}

$arParams['OK_TEXT'] = trim((string)($arParams['OK_TEXT'] ?? ''));

if ($arParams['OK_TEXT'] === '') {
    $arParams['OK_TEXT'] = GetMessage('MF_OK_MESSAGE');
}

function mriNormalizePhone($value)
{
    $digits = preg_replace('/\D+/', '', (string)$value);

    if ($digits === '') {
        return '';
    }

    if (strlen($digits) === 11 && $digits[0] === '8') {
        $digits = '7' . substr($digits, 1);
    } elseif (strlen($digits) === 10) {
        $digits = '7' . $digits;
    }

    return substr($digits, 0, 11);
}

function mriFormatPhone($digits)
{
    $digits = mriNormalizePhone($digits);

    if (strlen($digits) !== 11 || $digits[0] !== '7') {
        return (string)$digits;
    }

    return sprintf(
        '+7 (%s) %s-%s-%s',
        substr($digits, 1, 3),
        substr($digits, 4, 3),
        substr($digits, 7, 2),
        substr($digits, 9, 2)
    );
}

$isPost =
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && (string)($_POST['submit'] ?? '') !== '';

$hashIsValid =
    !isset($_POST['PARAMS_HASH'])
    || hash_equals(
        (string)$arResult['PARAMS_HASH'],
        (string)$_POST['PARAMS_HASH']
    );

if ($isPost && $hashIsValid) {
    $arResult['ERROR_MESSAGE'] = [];

    if (
        !empty($_POST['website_url'])
        || !empty($_POST['phone_field'])
        || !empty($_POST['email_field'])
    ) {
        die();
    }

    if (!check_bitrix_sessid()) {
        $arResult['ERROR_MESSAGE'][] = GetMessage('MF_SESS_EXP');
    } else {
        $name = trim((string)($_POST['user_name'] ?? ''));
        $email = trim((string)($_POST['user_email'] ?? ''));
        $message = trim((string)($_POST['MESSAGE'] ?? ''));
        $phoneDigits = mriNormalizePhone(
            $_POST['user_phone'] ?? ''
        );
        $phone = mriFormatPhone($phoneDigits);

        $personalDataConsent =
            !empty($_POST['personal-data']);
        $privacyConsent =
            !empty($_POST['privacy']);
        $advertisingConsent =
            !empty($_POST['advertising']);

        $requiredFields = is_array(
            $arParams['REQUIRED_FIELDS'] ?? null
        )
            ? $arParams['REQUIRED_FIELDS']
            : [];

        $allRequired =
            empty($requiredFields)
            || !in_array('NONE', $requiredFields, true);

        if (
            $allRequired
            && (
                empty($requiredFields)
                || in_array('NAME', $requiredFields, true)
            )
            && strlen($name) < 2
        ) {
            $arResult['ERROR_MESSAGE'][] =
                GetMessage('MF_REQ_NAME');
        }

        if (
            $allRequired
            && in_array('user_phone', $requiredFields, true)
            && (
                strlen($phoneDigits) !== 11
                || $phoneDigits[0] !== '7'
            )
        ) {
            $arResult['ERROR_MESSAGE'][] =
                'Введите корректный номер телефона.';
        }

        if (
            $allRequired
            && in_array('personal-data', $requiredFields, true)
            && !$personalDataConsent
        ) {
            $arResult['ERROR_MESSAGE'][] =
                'Необходимо дать согласие на обработку персональных данных.';
        }

        if (
            $allRequired
            && in_array('privacy', $requiredFields, true)
            && !$privacyConsent
        ) {
            $arResult['ERROR_MESSAGE'][] =
                'Необходимо подтвердить ознакомление с политикой обработки персональных данных.';
        }

        if (
            $email !== ''
            && !check_email($email)
        ) {
            $arResult['ERROR_MESSAGE'][] =
                GetMessage('MF_EMAIL_NOT_VALID');
        }

        if ($arParams['USE_CAPTCHA'] === 'Y') {
            include_once(
                $_SERVER['DOCUMENT_ROOT']
                . '/bitrix/modules/main/classes/general/captcha.php'
            );

            $captchaCode = (string)(
                $_POST['captcha_sid'] ?? ''
            );
            $captchaWord = (string)(
                $_POST['captcha_word'] ?? ''
            );

            if ($captchaCode === '' || $captchaWord === '') {
                $arResult['ERROR_MESSAGE'][] =
                    GetMessage('MF_CAPTHCA_EMPTY');
            } else {
                $captcha = new CCaptcha();
                $captchaPassword = COption::GetOptionString(
                    'main',
                    'captcha_password',
                    ''
                );

                if (
                    !$captcha->CheckCodeCrypt(
                        $captchaWord,
                        $captchaCode,
                        $captchaPassword
                    )
                ) {
                    $arResult['ERROR_MESSAGE'][] =
                        GetMessage('MF_CAPTCHA_WRONG');
                }
            }
        }

        if (empty($arResult['ERROR_MESSAGE'])) {
            $consentVersion = trim((string)(
                $_POST['consent_version']
                ?? '2026-07-06'
            ));

            if ($consentVersion === '') {
                $consentVersion = '2026-07-06';
            }

            $formUrl = (string)(
                $_SERVER['HTTP_REFERER'] ?? ''
            );

            $consentEvidence = mriBuildConsentEvidence(
                'Обратный звонок — форма «Перезвонить»',
                [
                    'personal_data' =>
                        $personalDataConsent,
                    'privacy' =>
                        $privacyConsent,
                    'advertising' =>
                        $advertisingConsent,
                ],
                $consentVersion,
                $formUrl,
                [
                    'phone' => $phoneDigits,
                    'email' => $email,
                ]
            );

            $consentEvidenceText =
                mriFormatConsentEvidence(
                    $consentEvidence
                );

            $messageWithEvidence = trim($message);

            if ($messageWithEvidence !== '') {
                $messageWithEvidence .=
                    PHP_EOL . PHP_EOL;
            }

            $messageWithEvidence .=
                $consentEvidenceText;

            $arFields = [
                'AUTHOR' => $name,
                'AUTHOR_EMAIL' => $email,
                'user_phone' => $phone,
                'EMAIL_TO' => $arParams['EMAIL_TO'],
                'TEXT' => $messageWithEvidence,
                'PERSONAL_DATA_CONSENT' =>
                    $personalDataConsent ? 'Да' : 'Нет',
                'PRIVACY_ACKNOWLEDGED' =>
                    $privacyConsent ? 'Да' : 'Нет',
                'ADVERTISING_CONSENT' =>
                    $advertisingConsent ? 'Да' : 'Нет',
                'CONSENT_VERSION' =>
                    $consentVersion,
                'CONSENT_EVIDENCE_ID' =>
                    $consentEvidence['evidence_id'],
                'CONSENT_SUBMITTED_AT' =>
                    $consentEvidence['submitted_at'],
                'FORM_URL' => $formUrl,
                'CLIENT_IP' =>
                    $consentEvidence['ip_address'],
                'CLIENT_USER_AGENT' =>
                    $consentEvidence['user_agent'],
            ];

            $mailEventIds = [];

            if (!empty($arParams['EVENT_MESSAGE_ID'])) {
                foreach ($arParams['EVENT_MESSAGE_ID'] as $messageId) {
                    if ((int)$messageId > 0) {
                        $eventId = CEvent::Send(
                            $arParams['EVENT_NAME'],
                            SITE_ID,
                            $arFields,
                            'N',
                            (int)$messageId
                        );

                        if ($eventId) {
                            $mailEventIds[] = (int)$eventId;
                        }
                    }
                }
            } else {
                $eventId = CEvent::Send(
                    $arParams['EVENT_NAME'],
                    SITE_ID,
                    $arFields
                );

                if ($eventId) {
                    $mailEventIds[] = (int)$eventId;
                }
            }

            $consentEvidence['delivery'] = [
                'channel' => 'bitrix_mail_event',
                'event_name' => $arParams['EVENT_NAME'],
                'mail_event_ids' => $mailEventIds,
            ];

            mriWriteConsentEvidence(
                $consentEvidence
            );

            $_SESSION['MF_NAME'] =
                htmlspecialcharsbx($name);
            $_SESSION['MF_EMAIL'] =
                htmlspecialcharsbx($email);
            $_SESSION['MF_user_phone'] =
                htmlspecialcharsbx($phone);

            LocalRedirect(
                $APPLICATION->GetCurPageParam(
                    'success=' . $arResult['PARAMS_HASH'],
                    ['success']
                )
            );
        }

        $arResult['MESSAGE'] =
            htmlspecialcharsbx($message);
        $arResult['AUTHOR_NAME'] =
            htmlspecialcharsbx($name);
        $arResult['AUTHOR_EMAIL'] =
            htmlspecialcharsbx($email);
        $arResult['user_phone'] =
            htmlspecialcharsbx($phone);
        $arResult['advertising'] =
            $advertisingConsent;
        $arResult['personal-data'] =
            $personalDataConsent;
        $arResult['privacy'] =
            $privacyConsent;
    }
} elseif (
    (string)($_REQUEST['success'] ?? '')
    === (string)$arResult['PARAMS_HASH']
) {
    $arResult['OK_MESSAGE'] = $arParams['OK_TEXT'];
}

if (empty($arResult['ERROR_MESSAGE'])) {
    if ($USER->IsAuthorized()) {
        $arResult['AUTHOR_NAME'] =
            $USER->GetFormattedName(false);
        $arResult['AUTHOR_EMAIL'] =
            htmlspecialcharsbx($USER->GetEmail());
    } else {
        if (!empty($_SESSION['MF_NAME'])) {
            $arResult['AUTHOR_NAME'] =
                htmlspecialcharsbx($_SESSION['MF_NAME']);
        }

        if (!empty($_SESSION['MF_EMAIL'])) {
            $arResult['AUTHOR_EMAIL'] =
                htmlspecialcharsbx($_SESSION['MF_EMAIL']);
        }

        if (!empty($_SESSION['MF_user_phone'])) {
            $arResult['user_phone'] =
                htmlspecialcharsbx($_SESSION['MF_user_phone']);
        }
    }
}

if ($arParams['USE_CAPTCHA'] === 'Y') {
    $arResult['capCode'] = htmlspecialcharsbx(
        $APPLICATION->CaptchaGetCode()
    );
}

$this->IncludeComponentTemplate();
