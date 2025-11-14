<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

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
                [
                    'query' => 'name',
                    'index' => 'NAME',
                    'required' => true,
                    'title' => 'Имя',
                ],
                [
                    'query' => 'phone',
                    'index' => 'PHONE',
                    'required' => true,
                    'title' => 'Телефон'
                ],
                [
                    'query' => 'message',
                    'index' => 'COMMENTS',
                ]
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
            [
                'query' => 'name',
                'index' => 'NAME',
                'required' => true,
                'title' => 'Имя',
            ],
            [
                'query' => 'phone',
                'index' => 'PHONE',
                'required' => true,
                'title' => 'Телефон'
            ],
            [
                'query' => 'message',
                'index' => 'COMMENTS',
            ]
        ];

        if(isset($_REQUEST['time_from']) && isset($_REQUEST['time_to'])) {
            $comment = 'Удобное время для звонка с ' . $_REQUEST['time_from'] . ' до ' . $_REQUEST['time_to'];
        }
        break;
    }
    case 'consult': {
        $title = 'Получить консультацию';

        $fields = [
            [
                'query' => 'name',
                'index' => 'NAME',
                'required' => true,
                'title' => 'Имя',
            ],
            [
                'query' => 'phone',
                'index' => 'PHONE',
                'required' => true,
                'title' => 'Телефон'
            ],
            [
                'query' => 'message',
                'index' => 'COMMENTS',
            ]
        ];
        break;
    }
}

$error = '';

if($title) {
    $required = [];

    $data = [
        'TITLE' => $title,
        'SOURCE_ID' => 'WEB'
    ];

    foreach($fields as $field) {
        $value = isset($_REQUEST[$field['query']]) ? trim($_REQUEST[$field['query']]) : '';
        $index = $field['index'];

        if(isset($field['required']) && !$value) {
            $required[] = $field['title'];
        }

        if($index == 'PHONE' || $index == 'EMAIL') {
            $value = [
                [
                    'VALUE' => $value
                ]
            ];
        } elseif($index == 'COMMENTS') {
            $value = trim($value . PHP_EOL . $comment);
        }

        $data[$index] = $value;
    }

    if(!count($required)) {
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
