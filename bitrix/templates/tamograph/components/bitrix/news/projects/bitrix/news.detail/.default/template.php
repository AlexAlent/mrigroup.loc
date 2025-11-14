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
$this->setFrameMode(true);

$products = [];
if(isset($arResult['PROPERTIES']['TOVARYPR']) && $arResult['PROPERTIES']['TOVARYPR']['VALUE']) {
    $products = is_array($arResult['PROPERTIES']['TOVARYPR']['VALUE']) ? $arResult['PROPERTIES']['TOVARYPR']['VALUE'] : [$arResult['PROPERTIES']['TOVARYPR']['VALUE']];
}
?>
<div class="section">
    <div class="container">
        <?php MrigroupHelper::index_breadcrumbs;?>

        <h1><?php echo $arResult["NAME"]?></h1>

        <?php if(isset($arResult['PREVIEW_TEXT']) && trim($arResult['PREVIEW_TEXT'])):?>
            <div class="section-header">
                <?php echo $arResult["PREVIEW_TEXT"]?>
            </div>
        <?php endif;?>

        <?php if(isset($arResult['DETAIL_TEXT']) && trim($arResult['DETAIL_TEXT'])):?>
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="section-content">
                        <?php echo $arResult["DETAIL_TEXT"]?>
                    </div>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>

<?php if(isset($arResult['SLIDER'])):?>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <div class="single-slider swiper">
                        <?php foreach ($arResult['SLIDER'] as $slide):?>
                            <a href="<?php echo $slide['src'];?>" class="single-slider-item swiper-slide" data-fancybox="gallery">
                                <div class="single-slider-item__image">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $slide['src'];?>" alt="" class="lazyload" />
                                </div>
                                <div class="single-slider-item__caption">
                                    <?php echo $slide['description'];?>
                                </div>
                            </a>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

<div class="section products">
    <div class="container">
        <?php if(count($products)) {
            global $arrFilterProducts;
            $arrFilterProducts = [
                'ID' => $products
            ];

            $APPLICATION->IncludeComponent(
                "bitrix:catalog.top",
                "products_list",
                array(
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
                    "ELEMENT_COUNT" => "1000",
                    "ELEMENT_SORT_FIELD" => "sort",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "STRICT",
                    "FILTER_NAME" => "arrFilterProducts",
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
                    "SHOW_PAGINATION" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "N",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N",
                    "VIEW_MODE" => "SECTION"
                ),
                $component,
                ['HIDE_ICONS' => 'Y']
            );
        } ?>

        <div class="section-footer">
            <ul class="section-nav nav">
                <li class="nav-item nav-prev<?php if(!isset($arResult['PREV_LINK'])):?> disabled<?php endif;?>">
                    <a<?php if(isset($arResult['PREV_LINK'])):?> href="<?php echo $arResult['PREV_LINK'];?>"<?php else:?> tabindex="-1" aria-disabled="true"<?php endif;?> class="nav-link" aria-label="Предыдущая статья">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.985 20.03l1.06-1.06-5.97-5.97 5.97-5.97-1.06-1.06L8.955 13l7.03 7.03z" />
                        </svg>
                        <span>Предыдущий проект</span>
                    </a>
                </li>
                <?php if(isset($arResult['LIST_PAGE_URL'])):?>
                    <li class="nav-item">
                        <a href="<?php echo $arResult['LIST_PAGE_URL'];?>" class="nav-link">
                            <span>Все проекты</span>
                        </a>
                    </li>
                <?php endif;?>
                <li class="nav-item nav-next<?php if(!isset($arResult['NEXT_LINK'])):?> disabled<?php endif;?>">
                    <a<?php if(isset($arResult['NEXT_LINK'])):?> href="<?php echo $arResult['NEXT_LINK'];?>"<?php else:?> tabindex="-1" aria-disabled="true"<?php endif;?> class="nav-link" aria-label="Следующая статья">
                        <span>Следующий проект</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.015 20.03l-1.06-1.06 5.97-5.97-5.97-5.97 1.06-1.06 7.03 7.03-7.03 7.03z" />
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>