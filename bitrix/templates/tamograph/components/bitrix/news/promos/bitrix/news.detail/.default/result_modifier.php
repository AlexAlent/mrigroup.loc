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

$prevUrl = getPrevElementUrl($arResult['IBLOCK_ID'], $arResult['ID'], $arParams, true);
if($prevUrl) {
    $arResult['PREV_LINK'] = $prevUrl;
}

$nextUrl = getNextElementUrl($arResult['IBLOCK_ID'], $arResult['ID'], $arParams, true);
if($nextUrl) {
    $arResult['NEXT_LINK'] = $nextUrl;
}