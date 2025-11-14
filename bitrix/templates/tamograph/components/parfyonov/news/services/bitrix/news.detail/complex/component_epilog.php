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

$APPLICATION->SetPageProperty(MrigroupHelper::page_property_template, 'plain_with_breadcrumbs');
$APPLICATION->SetPageProperty(MrigroupHelper::page_property_show_breadcrumbs, true);