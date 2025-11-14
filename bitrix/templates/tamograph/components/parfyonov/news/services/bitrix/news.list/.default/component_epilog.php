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

if ($arParams['PARENT_SECTION'] > 0)
{
    $iterator = CIBlockSection::GetList(
        [],
        [
            'IBLOCK_ID' => $arResult['ID'],
            'ID' => $arParams['PARENT_SECTION']
        ],
        false,
        [
            'ID',
            'IBLOCK_ID',
            'DESCRIPTION',
        ]
    );
    $row = $iterator->GetNext();
    if ($row && $row['DESCRIPTION'])
    {
        $APPLICATION->SetPageProperty('arfoto_services_content', $row['DESCRIPTION']);
    }
}