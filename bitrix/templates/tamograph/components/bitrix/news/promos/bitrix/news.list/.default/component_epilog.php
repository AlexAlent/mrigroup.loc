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

$APPLICATION->SetPageProperty('arfoto_page_template', 'default');
$APPLICATION->SetPageProperty(MrigroupHelper::page_property_show_breadcrumbs, true);