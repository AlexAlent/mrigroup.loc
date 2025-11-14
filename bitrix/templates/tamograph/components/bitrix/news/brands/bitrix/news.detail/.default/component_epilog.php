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

$APPLICATION->SetPageProperty('arfoto_h1', $arResult['NAME']);
$APPLICATION->SetPageProperty('arfoto_brand_id', $arResult['ID']);