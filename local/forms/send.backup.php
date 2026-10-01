<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// Разрешаем только POST запросы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit;
}

// Отсекаем прямые запросы не с сайта
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$host = $_SERVER['HTTP_HOST'] ?? '';

if (!$referer || parse_url($referer, PHP_URL_HOST) !== $host) {
    exit;
}

// === ЗАЩИТА ОТ БОТОВ ===

// 1. HONEYPOT
if (!empty($_REQUEST['website_url']) || !empty($_REQUEST['phone_field']) || !empty($_REQUEST['email_field'])) {
    exit;
}
// CAPTCHA
include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");

$captchaSid = $_REQUEST["captcha_sid"] ?? '';
$captchaWord = $_REQUEST["captcha_word"] ?? '';

$cpt = new CCaptcha();
$captchaPass = COption::GetOptionString("main", "captcha_password", "");

if (!$captchaSid || !$captchaWord || !$cpt->CheckCodeCrypt($captchaWord, $captchaSid, $captchaPass)) {
    ?>
    <div class="modal-outer">
        <div class="modal-title">Ошибка!</div>
        <div class="modal-text">Неверно введён код с картинки. Попробуйте ещё раз.</div>
    </div>
    <?php
    exit;
}

// 2. ПРОВЕРКА ВРЕМЕНИ (минимум 3 секунды)
$submitTime = $_REQUEST['submit_time'] ?? 0;
if ($submitTime && (time() - intval($submitTime) < 1)) {
    exit;
}

// 3. RATE LIMITING (не более 5 заявок с одного IP за час)
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$logFile = __DIR__ . '/rate_limit.log';
$now = time();
$attempts = [];

if (file_exists($logFile)) {
    $lines = @file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines) {
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) === 2) {
                $time = intval($parts[0]);
                $ipLine = $parts[1];
                if ($now - $time < 3600) {
                    if (!isset($attempts[$ipLine])) $attempts[$ipLine] = 0;
                    $attempts[$ipLine]++;
                }
            }
        }
    }
}

@file_put_contents($logFile, $now . '|' . $ip . PHP_EOL, FILE_APPEND | LOCK_EX);

if (($attempts[$ip] ?? 0) >= 5) {
    exit;
}

// === КОНЕЦ ЗАЩИТЫ ===

$title = '';
$fields = [];
$comment = '';

$type = $_REQUEST['type'] ?? null;
switch($type) {
    case 'offer': {
        $arElement = MrigroupHelper::getModalOfferElementById(isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
        if($arElement) {
            $title = 'Коммерческое предложение ' . $arElement['NAME'];
            if($arElement['IBLOCK_ID'] == 22 && isset($_REQUEST['set']) && trim($_REQUEST['set'])) {
                $title .= ' (Комплектация ' . trim($_REQUEST['set']) . ')';
            }
            $fields = [
                ['query' => 'name', 'index' => 'NAME', 'required' => true, 'title' => 'Имя'],
                ['query' => 'phone', 'index' => 'PHONE', 'required' => true, 'title' => 'Телефон'],
                ['query' => 'message', 'index' => 'COMMENTS']
            ];
            if(isset($_REQUEST['time_from']) && isset($_REQUEST['time_to'])) {
                $comment = 'Удобное время для звонка с ' . $_REQUEST['time_from'] . ' до ' . $_REQUEST['time_to'];
            }
            break;
        }
    }
    case 'feedback': {
        $title = 'Узнать о скидке';
        $fields = [
            ['query' => 'name', 'index' => 'NAME', 'required' => true, 'title' => 'Имя'],
            ['query' => 'phone', 'index' => 'PHONE', 'required' => true, 'title' => 'Телефон'],
            ['query' => 'message', 'index' => 'COMMENTS']
        ];
        if(isset($_REQUEST['time_from']) && isset($_REQUEST['time_to'])) {
            $comment = 'Удобное время для звонка с ' . $_REQUEST['time_from'] . ' до ' . $_REQUEST['time_to'];
        }
        break;
    }
    case 'consult': {
        $title = 'Получить консультацию';
        $fields = [
            ['query' => 'name', 'index' => 'NAME', 'required' => true, 'title' => 'Имя'],
            ['query' => 'phone', 'index' => 'PHONE', 'required' => true, 'title' => 'Телефон'],
            ['query' => 'message', 'index' => 'COMMENTS']
        ];
        break;
    }
}

$error = '';

if($title) {
    $required = [];
    $data = [
        'TITLE' => $title,
        'SOURCE_ID' => 'WEB',
        'ASSIGNED_BY_ID' => 87
    ];

    foreach($fields as $field) {
        $value = isset($_REQUEST[$field['query']]) ? trim($_REQUEST[$field['query']]) : '';
        $index = $field['index'];

        if(isset($field['required']) && !$value) {
            $required[] = $field['title'];
        }

        if($index == 'PHONE' || $index == 'EMAIL') {
            $value = [['VALUE' => $value]];
        } elseif($index == 'COMMENTS') {
            $value = trim($value . PHP_EOL . $comment);
        }

        $data[$index] = $value;
    }

    if(!count($required)) {
    $phoneRaw = $_REQUEST['phone'] ?? '';
    $digits = preg_replace('/\D+/', '', $phoneRaw);

    if (strlen($digits) < 10 || strlen($digits) > 15) {
        exit;
    }

    require_once __DIR__ . '/crest/crest.php';
        define('C_REST_WEB_HOOK_URL','https://corp.mrigroup.ru/rest/1/5l8p2vdbgh9w8p5r/');

        if(isset($_REQUEST['trace'])) {
            $data['TRACE'] = $_REQUEST['trace'];
        }

        $result = CRest::call('crm.lead.add', ['fields' => $data]);
        if(!is_array($result) || !isset($result['result'])) {
            $error = 'Произошла ошибка';
        }
    } else {
        $title = 'Незаполнены обязательные поля: ' . implode(',', $required);
    }
} else {
    $error = 'Неизвестная форма';
}
?>
<div class="modal-outer">
    <?php if(!$error):?>
        <div class="modal-title">Спасибо за запрос!</div>
        <div class="modal-text">Ваша заявка принята. Наш менеджер свяжется с Вами в ближайшее время.</div>
    <?php else:?>
        <div class="modal-title">Ошибка!</div>
        <div class="modal-text"><?php echo $error;?></div>
    <?php endif;?>
</div>