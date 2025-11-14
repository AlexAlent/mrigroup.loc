<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $templateData
 * @var string $templateFolder
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

$productsCount = 0;

if(isset($arResult['NAV_RESULT']) && $arResult['NAV_RESULT'] instanceof CIBlockResult) {
    $productsCount = $arResult['NAV_RESULT']->NavRecordCount;
} elseif(isset($arResult['PRODUCTS_COUNT'])) {
    $productsCount = $arResult['PRODUCTS_COUNT'];
}

$APPLICATION->AddViewContent('section_products_count_text', $productsCount ? $productsCount . ' ' . getNumEnding($productsCount, 'товар', 'товара', 'товаров') : 'Нет товаров');
$APPLICATION->AddViewContent('filter_submit_text', getFilterSubmitText($productsCount));
$APPLICATION->SetPageProperty('arfoto_h1', $arResult['NAME']);