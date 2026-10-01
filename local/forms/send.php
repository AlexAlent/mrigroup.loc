<?php

require_once(
    $_SERVER['DOCUMENT_ROOT']
    . '/bitrix/modules/main/include/prolog_before.php'
);

function mriFormResponse($title, $message)
{
    ?>
    <div class="modal-outer">
        <div class="modal-title">
            <?=htmlspecialcharsbx((string)$title)?>
        </div>

        <div class="modal-text">
            <?=htmlspecialcharsbx((string)$message)?>
        </div>
    </div>
    <?php

    exit;
}

function mriPostText($name, $maxLength = 4000)
{
    $value = $_POST[$name] ?? '';

    if (is_array($value)) {
        return '';
    }

    $value = trim(strip_tags((string)$value));

    if (function_exists('mb_substr')) {
        return mb_substr($value, 0, $maxLength, 'UTF-8');
    }

    return substr($value, 0, $maxLength);
}

function mriPostCheckbox(array $names)
{
    foreach ($names as $name) {
        if (!array_key_exists($name, $_POST)) {
            continue;
        }

        $value = $_POST[$name];

        if (is_array($value)) {
            return false;
        }

        $value = strtolower(trim((string)$value));

        return in_array(
            $value,
            ['1', 'y', 'yes', 'on', 'true'],
            true
        );
    }

    return false;
}

function mriNormalizeLeadPhone($value)
{
    $digits = preg_replace('/\D+/', '', (string)$value);

    if (strlen($digits) === 10) {
        $digits = '7' . $digits;
    } elseif (
        strlen($digits) === 11
        && substr($digits, 0, 1) === '8'
    ) {
        $digits = '7' . substr($digits, 1);
    }

    if (
        strlen($digits) < 10
        || strlen($digits) > 15
    ) {
        return '';
    }

    return '+' . $digits;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

$referer = (string)($_SERVER['HTTP_REFERER'] ?? '');
$refererHost = strtolower(
    (string)parse_url($referer, PHP_URL_HOST)
);
$currentHost = strtolower(
    preg_replace(
        '/:\d+$/',
        '',
        (string)($_SERVER['HTTP_HOST'] ?? '')
    )
);

if (
    $refererHost === ''
    || $currentHost === ''
    || !hash_equals($currentHost, $refererHost)
) {
    http_response_code(403);
    exit;
}

if (
    !empty($_POST['website_url'])
    || !empty($_POST['phone_field'])
    || !empty($_POST['email_field'])
) {
    exit;
}

$personalDataConsent = mriPostCheckbox([
    'personal-data',
    'personal_data',
]);

$privacyAcknowledged = mriPostCheckbox([
    'privacy',
    'privacy-policy',
]);

$advertisingConsent = mriPostCheckbox([
    'advertising',
    'subscribe',
]);

if (!$personalDataConsent || !$privacyAcknowledged) {
    mriFormResponse(
        'Ошибка!',
        'Для отправки заявки необходимо дать согласие '
        . 'на обработку персональных данных и подтвердить '
        . 'ознакомление с политикой.'
    );
}

include_once(
    $_SERVER['DOCUMENT_ROOT']
    . '/bitrix/modules/main/classes/general/captcha.php'
);

$captchaSid = mriPostText('captcha_sid', 100);
$captchaWord = mriPostText('captcha_word', 100);
$captchaPassword = COption::GetOptionString(
    'main',
    'captcha_password',
    ''
);

$captcha = new CCaptcha();

if (
    $captchaSid === ''
    || $captchaWord === ''
    || !$captcha->CheckCodeCrypt(
        $captchaWord,
        $captchaSid,
        $captchaPassword
    )
) {
    mriFormResponse(
        'Ошибка!',
        'Неверно введён код с картинки. Попробуйте ещё раз.'
    );
}

$submitTime = (int)($_POST['submit_time'] ?? 0);

if (
    $submitTime > 0
    && (time() - $submitTime) < 1
) {
    exit;
}

$ip = (string)($_SERVER['REMOTE_ADDR'] ?? '');
$rateLog = __DIR__ . '/rate_limit.log';
$now = time();
$attempts = [];

if (is_file($rateLog)) {
    $lines = @file(
        $rateLog,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

    if (is_array($lines)) {
        foreach ($lines as $line) {
            $parts = explode('|', $line, 2);

            if (count($parts) !== 2) {
                continue;
            }

            $attemptTime = (int)$parts[0];
            $attemptIp = (string)$parts[1];

            if (($now - $attemptTime) >= 3600) {
                continue;
            }

            if (!isset($attempts[$attemptIp])) {
                $attempts[$attemptIp] = 0;
            }

            $attempts[$attemptIp]++;
        }
    }
}

if (($attempts[$ip] ?? 0) >= 5) {
    mriFormResponse(
        'Ошибка!',
        'Слишком много заявок. Попробуйте отправить форму позже.'
    );
}

@file_put_contents(
    $rateLog,
    $now . '|' . $ip . PHP_EOL,
    FILE_APPEND | LOCK_EX
);

$type = mriPostText('type', 30);
$name = mriPostText('name', 200);
$phone = mriNormalizeLeadPhone(
    mriPostText('phone', 100)
);
$message = mriPostText('message', 5000);
$title = '';
$timeComment = '';

if ($name === '') {
    mriFormResponse(
        'Ошибка!',
        'Укажите имя.'
    );
}

if ($phone === '') {
    mriFormResponse(
        'Ошибка!',
        'Укажите корректный номер телефона.'
    );
}

switch ($type) {
    case 'offer':
        $elementId = (int)($_POST['id'] ?? 0);
        $element = MrigroupHelper::getModalOfferElementById(
            $elementId
        );

        if (!$element) {
            mriFormResponse(
                'Ошибка!',
                'Не удалось определить выбранное оборудование.'
            );
        }

        $title = 'Коммерческое предложение '
            . trim((string)$element['NAME']);

        $set = mriPostText('set', 300);

        if (
            (int)$element['IBLOCK_ID'] === 22
            && $set !== ''
        ) {
            $title .= ' (Комплектация ' . $set . ')';
        }
        break;

    case 'feedback':
        $title = 'Узнать о скидке';
        break;

    case 'consult':
        $title = 'Получить консультацию';
        break;

    default:
        mriFormResponse(
            'Ошибка!',
            'Неизвестная форма.'
        );
}

$timeFrom = mriPostText('time_from', 20);

if ($timeFrom === '') {
    $timeFrom = mriPostText('from', 20);
}

$timeTo = mriPostText('time_to', 20);

if ($timeTo === '') {
    $timeTo = mriPostText('to', 20);
}

if ($timeFrom !== '' && $timeTo !== '') {
    $timeComment = 'Удобное время для звонка с '
        . $timeFrom
        . ' до '
        . $timeTo;
}

$consentVersion = mriPostText(
    'consent_version',
    50
);

if ($consentVersion === '') {
    $consentVersion = '2026-07-06';
}

$evidenceFile =
    $_SERVER['DOCUMENT_ROOT']
    . '/local/include/consent-evidence.php';

if (!is_file($evidenceFile)) {
    mriFormResponse(
        'Ошибка!',
        'Не удалось сохранить подтверждение согласия. '
        . 'Попробуйте ещё раз позже.'
    );
}

require_once($evidenceFile);

$evidence = mriBuildConsentEvidence(
    $title,
    [
        'personal_data' => $personalDataConsent,
        'privacy' => $privacyAcknowledged,
        'advertising' => $advertisingConsent,
    ],
    $consentVersion,
    $referer,
    [
        'phone' => $phone,
        'email' => '',
    ]
);

$evidence['event_type'] = 'consent';
$evidence['delivery'] = [
    'channel' => 'bitrix24_webhook',
    'entity' => 'crm.lead',
];

$evidenceText = mriFormatConsentEvidence($evidence);

if (!mriWriteConsentEvidence($evidence)) {
    mriFormResponse(
        'Ошибка!',
        'Не удалось сохранить подтверждение согласия. '
        . 'Заявка не отправлена. Попробуйте ещё раз позже.'
    );
}

$commentParts = [];

if ($message !== '') {
    $commentParts[] = $message;
}

if ($timeComment !== '') {
    $commentParts[] = $timeComment;
}

$commentParts[] = $evidenceText;

$data = [
    'TITLE' => $title,
    'SOURCE_ID' => 'WEB',
    'ASSIGNED_BY_ID' => 87,
    'NAME' => $name,
    'PHONE' => [
        [
            'VALUE' => $phone,
            'VALUE_TYPE' => 'WORK',
        ],
    ],
    'COMMENTS' => implode(
        PHP_EOL . PHP_EOL,
        $commentParts
    ),
];

if (!empty($_POST['trace']) && !is_array($_POST['trace'])) {
    $data['TRACE'] = mriPostText('trace', 2000);
}

require_once(__DIR__ . '/crest/crest.php');

if (!defined('C_REST_WEB_HOOK_URL')) {
    define(
        'C_REST_WEB_HOOK_URL',
        'https://corp.mrigroup.ru/rest/1/5l8p2vdbgh9w8p5r/'
    );
}

$result = CRest::call(
    'crm.lead.add',
    ['fields' => $data]
);

if (
    !is_array($result)
    || !isset($result['result'])
) {
    mriFormResponse(
        'Ошибка!',
        'Не удалось передать заявку. '
        . 'Попробуйте ещё раз или свяжитесь с нами по телефону.'
    );
}

mriFormResponse(
    'Спасибо за запрос!',
    'Ваша заявка принята. Наш менеджер свяжется '
    . 'с Вами в ближайшее время.'
);
