<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$APPLICATION->RestartBuffer();
if(isset($arResult['COMBO'])) {
    unset($arResult['COMBO']);
}
$arResult['FILTER_SUBMIT_TEXT'] = getFilterSubmitText($arResult['ELEMENT_COUNT'] ?? null);
echo CUtil::PHPToJSObject($arResult, true);
?>