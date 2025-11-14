<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $this
 */

if (!$this->InitComponentTemplate())
	return;

$template = &$this->GetTemplate();
$templatePath = $template->GetFile();
$templateFolder = $template->GetFolder();

//Params
$arParams["START_FROM"] = (isset($arParams["START_FROM"]) && intval($arParams["START_FROM"]) > 0 ? intval($arParams["START_FROM"]) : 0);
$arParams["PATH"] = (isset($arParams["PATH"]) && $arParams["PATH"] <> '' ? htmlspecialcharsbx($arParams["PATH"]) : false);
$arParams["SITE_ID"] = (isset($arParams["SITE_ID"]) && mb_strlen($arParams["SITE_ID"]) == 2 ? htmlspecialcharsbx($arParams["SITE_ID"]) : false);

$path = $arParams['SITE_ID'] === false ? $arParams['PATH'] : [$arParams['SITE_ID'], $arParams['PATH']];

echo $APPLICATION->GetNavChain($path, $arParams['START_FROM'], $templatePath, $bIncludeOnce = true, $bShowIcons = false);