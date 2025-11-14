<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);

$arFilter = array(
    "IBLOCK_ID" => $arParams["IBLOCK_ID"],
    "ACTIVE" => "Y",
    "GLOBAL_ACTIVE" => "Y",
);
if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
    $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
    $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
{
    $arCurSection = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
    $arCurSection = array();
    if (Loader::includeModule("iblock"))
    {
        $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

        if(defined("BX_COMP_MANAGED_CACHE"))
        {
            global $CACHE_MANAGER;
            $CACHE_MANAGER->StartTagCache("/iblock/catalog");

            if ($arCurSection = $dbRes->Fetch())
                $CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);

            $CACHE_MANAGER->EndTagCache();
        }
        else
        {
            if(!$arCurSection = $dbRes->Fetch())
                $arCurSection = array();
        }
    }
    $obCache->EndDataCache($arCurSection);
}

if (!isset($arCurSection)) {
    $arCurSection = array();
}


$sortParams = [
    'popular' => [
        'text' => 'по популярности',
        'field' => 'sort',
        'order' => 'asc',
    ],
    'price_asc' => [
        'text' => 'по возрастанию цены',
        'field' => 'SCALED_PRICE_1',
        'order' => 'asc',
    ],
    'price_desc' => [
        'text' => 'по убыванию цены',
        'field' => 'SCALED_PRICE_1',
        'order' => 'desc',
    ],
];

$sort = $_REQUEST['sort'];
if(!isset($sortParams[$sort])) {
    $sort = array_key_first($sortParams);
}
?>
<div class="products-layout">
    <div class="products-layout-head">
        <button type="button" class="catalog-filter-toggler btn btn-primary">
            <span class="catalog-filter-toggler__text">Фильтр</span>
            <span class="catalog-filter-toggler__icon-show">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path
                        d="M9.855 7.25H22v1.5H9.855a2 2 0 01-3.71 0H4v-1.5h2.145a2 2 0 013.71 0zM4 13.75h12.145a2 2 0 003.71 0H22v-1.5h-2.145a2 2 0 00-3.71 0H4v1.5zm2.145 5H4v-1.5h2.145a2 2 0 013.71 0H22v1.5H9.855a2 2 0 01-3.71 0z">
                    </path>
                </svg>
            </span>
            <span class="catalog-filter-toggler__icon-hide">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path
                        d="M13 14.06l7.47 7.47 1.06-1.06L14.06 13l7.47-7.47-1.06-1.06L13 11.94 5.53 4.47 4.47 5.53 11.94 13l-7.47 7.47 1.06 1.06L13 14.06z">
                    </path>
                </svg>
            </span>
        </button>

        <div class="catalog-counter">
            <?php $APPLICATION->ShowViewContent('section_products_count_text');?>
        </div>
    </div>

    <div class="products-layout-side">
        <?
        $APPLICATION->IncludeComponent(
            "bitrix:catalog.smart.filter",
            "arfoto",
            array(
                "CACHE_GROUPS" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "CONVERT_CURRENCY" => "Y",
                "CURRENCY_ID" => "RUB",
                "DISPLAY_ELEMENT_COUNT" => "Y",
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "FILTER_VIEW_MODE" => "vertical",
                "HIDE_NOT_AVAILABLE" => $arParams['HIDE_NOT_AVAILABLE'],
                "IBLOCK_ID" => "9",
                "IBLOCK_TYPE" => "catalog",
                "PAGER_PARAMS_NAME" => "arrPager",
                "POPUP_POSITION" => "right",
                "PREFILTER_NAME" => "smartPreFilter",
                "PRICE_CODE" => array(
                    0 => "BASE",
                ),
                "SAVE_IN_SESSION" => "N",
                "AJAX_MODE" => "N",
                "INSTANT_RELOAD" => "N",
                "SECTION_CODE" => "",
                "SECTION_CODE_PATH" => "#SECTION_CODE_PATH#/",
                "SECTION_DESCRIPTION" => "-",
                "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
                "SECTION_TITLE" => "-",
                "SEF_MODE" => "Y",
                "SEF_RULE" => "",
                "SMART_FILTER_PATH" => "#SECTION_CODE_PATH#/filter/#SMART_FILTER_PATH#/apply/",
                "TEMPLATE_THEME" => "blue",
                "XML_EXPORT" => "N",
                "COMPONENT_TEMPLATE" => "visual_vertical",
                "SORT" => $sort,
                "SORT_PARAMS" => $sortParams,
            ),
            false
        );
        ?>
    </div>

    <div class="products-layout-body">
        <? $APPLICATION->IncludeComponent(
            "bitrix:catalog.section",
            "bootstrap_v4", array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "ELEMENT_SORT_FIELD" => $sortParams[$sort]['field'],
            "ELEMENT_SORT_ORDER" => $sortParams[$sort]['order'],
            "ELEMENT_SORT_FIELD2" => '',
            "ELEMENT_SORT_ORDER2" => '',
            "PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
            "PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
            "META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
            "META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
            "BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
            "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
            "INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
            "BASKET_URL" => $arParams["BASKET_URL"],
            "ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
            "PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
            "SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
            "PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
            "PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "SET_TITLE" => $arParams["SET_TITLE"],
            "MESSAGE_404" => $arParams["~MESSAGE_404"],
            "SET_STATUS_404" => $arParams["SET_STATUS_404"],
            "SHOW_404" => $arParams["SHOW_404"],
            "FILE_404" => $arParams["FILE_404"],
            "DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
            "PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
            "LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
            "PRICE_CODE" => $arParams["~PRICE_CODE"],
            "USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
            "SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

            "PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
            "USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
            "ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
            "PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
            "PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

            "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
            "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
            "PAGER_TITLE" => $arParams["PAGER_TITLE"],
            "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
            "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
            "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
            "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
            "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
            "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
            "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
            "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
            "LAZY_LOAD" => $arParams["LAZY_LOAD"],
            "MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
            "LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

            "OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
            "OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
            "OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
            "OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
            "OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
            "OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
            "OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
            "OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

            "SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
            "SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
            "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
            "USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
            'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
            'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

            'LABEL_PROP' => $arParams['LABEL_PROP'],
            'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
            'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
            'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'] ?? '',
            'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
            'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
            'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
            'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
            'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
            'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
            'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
            'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

            'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
            'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
            'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
            'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
            'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
            'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
            'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
            'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
            'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
            'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
            'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
            'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
            'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
            'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
            'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
            'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE'] ?? '',
            'MESS_NOT_AVAILABLE_SERVICE' => $arParams['~MESS_NOT_AVAILABLE_SERVICE'] ?? '',
            'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

            'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
            'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
            'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

            'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
            "ADD_SECTIONS_CHAIN" => "Y",
            'ADD_TO_BASKET_ACTION' => '',
            'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
            'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
            'COMPARE_NAME' => $arParams['COMPARE_NAME'],
            'USE_COMPARE_LIST' => 'Y',
            'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
            'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
            'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
        ),
            $component
        );
        ?>
    </div>
</div>
