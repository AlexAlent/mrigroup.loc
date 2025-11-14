<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

use Bitrix\Main\Context;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

CModule::IncludeModule('iblock');

$result = CIBlockElement::GetList(
    [
        'SORT' => 'ASC',
    ],
    [
        'IBLOCK_ID' => 29,
        'ACTIVE' => 'Y',
    ],
    false,
    false,
    [
        'IBLOCK_ID',
        'ID',
        'NAME',
        'PROPERTY_REGION_DOMAIN'
    ]
);

$items = [];
while($row = $result->Fetch()) {
    if(!is_array($row) || !isset($row['PROPERTY_REGION_DOMAIN_VALUE']) || !$row['PROPERTY_REGION_DOMAIN_VALUE']) {
        continue;
    }

    $row['LINK'] = '//' . $row['PROPERTY_REGION_DOMAIN_VALUE'];

    $items[] = $row;
}
?>
<div class="modal-outer">
    <div class="modal-title">Выберите город</div>
    <?php if(count($items)):?>
        <ul class="location-list">
            <?php foreach($items as $item):?>
                <li class="location-item">
                    <a href="<?php echo $item['LINK'];?>" class="location-link">
                        <span><?php echo $item['NAME'];?></span>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    <?php else:?>
        <p>Произошла ошибка</p>
    <?php endif;?>
</div>
