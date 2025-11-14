<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 */

foreach($arResult['ITEMS'] as $i => $arItem) {
    if(isset($arItem['PROPERTIES']) && isset($arItem['PROPERTIES']['ICON']) && $arItem['PROPERTIES']['ICON']['VALUE']) {
        $resFile = CFile::GetByID($arItem['PROPERTIES']['ICON']['VALUE']);
        $arFile = $resFile->Fetch();
        if($arFile) {
            $arResult['ITEMS'][$i]['ICON'] = $arFile['SRC'];
        }
    }
}