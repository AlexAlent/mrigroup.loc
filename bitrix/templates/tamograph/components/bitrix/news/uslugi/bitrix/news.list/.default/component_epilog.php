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

if(isset($arParams['SET_TITLE']) && $arParams['SET_TITLE'] && isset($arResult['SECTION'])) {
    $APPLICATION->SetPageProperty('arfoto_h1', $arResult['SECTION']['PATH'][0]['NAME']);
}