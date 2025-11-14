<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 */

$arFilter = [
    'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    'ACTIVE' => 'Y'
];

$arSelect = [
    'ID',
    'DETAIL_PAGE_URL'
];

$elementId = $arResult['ID'];

$resPrev = CIBlockElement::GetList(
    [
        $arParams['SORT_BY1'] => $arParams['SORT_ORDER1'] != 'ASC' ? 'ASC' : 'DESC',
        $arParams['SORT_BY2'] => $arParams['SORT_ORDER2'] != 'ASC' ? 'ASC' : 'DESC',
    ],
    $arFilter,
    false,
    Array('nPageSize' => 1, 'nElementID' => $elementId),
    $arSelect
)->GetNext();

if(is_array($resPrev) && isset($resPrev['DETAIL_PAGE_URL']) && $resPrev['ID'] != $elementId) {
    $arResult['PREV_LINK'] = $resPrev['DETAIL_PAGE_URL'];
}

$resNext = CIBlockElement::GetList(
    [
        $arParams['SORT_BY1'] => $arParams['SORT_ORDER1'] != 'ASC' ? 'DESC' : 'ASC',
        $arParams['SORT_BY2'] => $arParams['SORT_ORDER2'] != 'ASC' ? 'DESC' : 'ASC',
    ],
    $arFilter,
    false,
    Array('nPageSize' => 1, 'nElementID' => $arResult['ID']),
    $arSelect
)->GetNext();

if(is_array($resNext) && isset($resNext['DETAIL_PAGE_URL']) && $resNext['ID'] != $elementId) {
    $arResult['NEXT_LINK'] = $resNext['DETAIL_PAGE_URL'];
}