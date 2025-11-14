<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$items = [];

if(isset($arResult['ITEMS']) && is_array($arResult['ITEMS'])) {
    foreach($arResult['ITEMS'] as $item) {
        if(!isset($item['PROPERTIES']['YEAR']) || !$item['PROPERTIES']['YEAR']['VALUE']) {
            continue;
        }

        $items[] = $item;
    }
}

$arResult['ITEMS'] = $items;