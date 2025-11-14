<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var array $arResult
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;
$APPLICATION->SetPageProperty(MrigroupHelper::page_property_template, 'plain_with_breadcrumbs');
$APPLICATION->SetPageProperty(MrigroupHelper::page_property_show_breadcrumbs, true);

if(isset($arResult['ALSO']) || isset($arResult['SIMILAR'])) {
    global $arMainProductsFilter;

    ob_start();

    if(isset($arResult['ALSO'])) {
        $arMainProductsFilter = [
            'ID' => $arResult['ALSO']
        ];

        $APPLICATION->IncludeComponent(
            "bitrix:catalog.top",
            "main_products",
            array(
                "BLOCK_TITLE" => "С этим товаром покупают",
                "PRODUCTS_ORDER" => $arResult['ALSO'],
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "MORE_PHOTO",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "BASKET_URL" => "/personal/basket.php",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                "COMPATIBLE_MODE" => "N",
                "CONVERT_CURRENCY" => "N",
                "CUSTOM_FILTER" => "",
                "DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
                "DISPLAY_COMPARE" => "N",
                "ELEMENT_COUNT" => "12",
                "ELEMENT_SORT_FIELD" => "",
                "ELEMENT_SORT_FIELD2" => "",
                "ELEMENT_SORT_ORDER" => "asc",
                "ELEMENT_SORT_ORDER2" => "desc",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "arMainProductsFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => "9",
                "IBLOCK_TYPE" => "catalog",
                "LABEL_PROP" => array(),
                "LINE_ELEMENT_COUNT" => "3",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_COMPARE" => "Сравнить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                "OFFERS_LIMIT" => "5",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array("BASE"),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE_MOBILE" => array(),
                "ROTATE_TIMER" => "30",
                "SECTION_URL" => "/catalog/#SECTION_CODE#/",
                "SEF_MODE" => "N",
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PAGINATION" => "Y",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "N",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N",
                "VIEW_MODE" => "SECTION"
            )
        );
    }

    if(isset($arResult['SIMILAR'])) {
        $arMainProductsFilter = [
            'ID' => $arResult['SIMILAR']
        ];

        $APPLICATION->IncludeComponent(
            "bitrix:catalog.top",
            "main_products",
            array(
                "BLOCK_TITLE" => "Вам также может понравиться",
                "PRODUCTS_ORDER" => $arResult['SIMILAR'],
                "ACTION_VARIABLE" => "action",
                "ADD_PICT_PROP" => "MORE_PHOTO",
                "ADD_PROPERTIES_TO_BASKET" => "Y",
                "ADD_TO_BASKET_ACTION" => "ADD",
                "BASKET_URL" => "/personal/basket.php",
                "CACHE_FILTER" => "N",
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                "COMPATIBLE_MODE" => "N",
                "CONVERT_CURRENCY" => "N",
                "CUSTOM_FILTER" => "",
                "DETAIL_URL" => "/catalog/#SECTION_CODE#/#ELEMENT_CODE#/",
                "DISPLAY_COMPARE" => "N",
                "ELEMENT_COUNT" => "12",
                "ELEMENT_SORT_FIELD" => "",
                "ELEMENT_SORT_FIELD2" => "",
                "ELEMENT_SORT_ORDER" => "asc",
                "ELEMENT_SORT_ORDER2" => "desc",
                "ENLARGE_PRODUCT" => "STRICT",
                "FILTER_NAME" => "arMainProductsFilter",
                "HIDE_NOT_AVAILABLE" => "N",
                "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                "IBLOCK_ID" => "9",
                "IBLOCK_TYPE" => "catalog",
                "LABEL_PROP" => array(),
                "LINE_ELEMENT_COUNT" => "3",
                "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                "MESS_BTN_BUY" => "Купить",
                "MESS_BTN_COMPARE" => "Сравнить",
                "MESS_BTN_DETAIL" => "Подробнее",
                "MESS_NOT_AVAILABLE" => "Нет в наличии",
                "MESS_NOT_AVAILABLE_SERVICE" => "Недоступно",
                "OFFERS_LIMIT" => "5",
                "PARTIAL_PRODUCT_PROPERTIES" => "N",
                "PRICE_CODE" => array("BASE"),
                "PRICE_VAT_INCLUDE" => "Y",
                "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                "PRODUCT_ID_VARIABLE" => "id",
                "PRODUCT_PROPS_VARIABLE" => "prop",
                "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
                "PRODUCT_SUBSCRIPTION" => "Y",
                "PROPERTY_CODE_MOBILE" => array(),
                "ROTATE_TIMER" => "30",
                "SECTION_URL" => "/catalog/#SECTION_CODE#/",
                "SEF_MODE" => "N",
                "SHOW_CLOSE_POPUP" => "N",
                "SHOW_DISCOUNT_PERCENT" => "N",
                "SHOW_MAX_QUANTITY" => "N",
                "SHOW_OLD_PRICE" => "N",
                "SHOW_PAGINATION" => "Y",
                "SHOW_PRICE_COUNT" => "1",
                "SHOW_SLIDER" => "N",
                "SLIDER_INTERVAL" => "3000",
                "SLIDER_PROGRESS" => "N",
                "TEMPLATE_THEME" => "blue",
                "USE_ENHANCED_ECOMMERCE" => "N",
                "USE_PRICE_COUNT" => "N",
                "USE_PRODUCT_QUANTITY" => "N",
                "VIEW_MODE" => "SECTION"
            )
        );
    }

    $APPLICATION->AddViewContent('arfoto_page_footer_custom', ob_get_clean());
}