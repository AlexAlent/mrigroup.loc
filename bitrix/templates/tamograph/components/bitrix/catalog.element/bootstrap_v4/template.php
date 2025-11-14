<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    exit;
}

use Bitrix\Catalog\ProductTable;
use Bitrix\Main\Localization\Loc;

/*
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

$templateLibrary = ['popup', 'fx', 'ui.fonts.opensans'];
$currencyList = '';

if (!empty($arResult['CURRENCIES'])) {
    $templateLibrary[] = 'currency';
    $currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$haveOffers = !empty($arResult['OFFERS']);

$templateData = [
    'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
    'TEMPLATE_LIBRARY' => $templateLibrary,
    'CURRENCIES' => $currencyList,
    'ITEM' => [
        'ID' => $arResult['ID'],
        'IBLOCK_ID' => $arResult['IBLOCK_ID'],
    ],
];
if ($haveOffers) {
    $templateData['ITEM']['OFFERS_SELECTED'] = $arResult['OFFERS_SELECTED'];
    $templateData['ITEM']['JS_OFFERS'] = $arResult['JS_OFFERS'];
}
unset($currencyList, $templateLibrary);

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = [
    'ID' => $mainId,
    'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
    'STICKER_ID' => $mainId.'_sticker',
    'BIG_SLIDER_ID' => $mainId.'_big_slider',
    'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
    'SLIDER_CONT_ID' => $mainId.'_slider_cont',
    'OLD_PRICE_ID' => $mainId.'_old_price',
    'PRICE_ID' => $mainId.'_price',
    'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
    'PRICE_TOTAL' => $mainId.'_price_total',
    'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
    'QUANTITY_ID' => $mainId.'_quantity',
    'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
    'QUANTITY_UP_ID' => $mainId.'_quant_up',
    'QUANTITY_MEASURE' => $mainId.'_quant_measure',
    'QUANTITY_LIMIT' => $mainId.'_quant_limit',
    'BUY_LINK' => $mainId.'_buy_link',
    'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
    'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
    'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
    'COMPARE_LINK' => $mainId.'_compare_link',
    'TREE_ID' => $haveOffers && !empty($arResult['OFFERS_PROP']) ? $mainId.'_skudiv' : null,
    'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
    'DESCRIPTION_ID' => $mainId.'_description',
    'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
    'OFFER_GROUP' => $mainId.'_set_group_',
    'BASKET_PROP_DIV' => $mainId.'_basket_prop',
    'SUBSCRIBE_LINK' => $mainId.'_subscribe',
    'TABS_ID' => $mainId.'_tabs',
    'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
    'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
    'TABS_PANEL_ID' => $mainId.'_tabs_panel',
];
$obName = $templateData['JS_OBJ'] = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $mainId);
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
    : $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
    : $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
    ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
    : $arResult['NAME'];

if ($haveOffers) {
    $actualItem = $arResult['OFFERS'][$arResult['OFFERS_SELECTED']] ?? reset($arResult['OFFERS']);
    $showSliderControls = false;

    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['MORE_PHOTO_COUNT'] > 1) {
            $showSliderControls = true;
            break;
        }
    }
} else {
    $actualItem = $arResult;
    $showSliderControls = $arResult['MORE_PHOTO_COUNT'] > 1;
}

$skuProps = [];
$price = $actualItem['ITEM_PRICES'][$actualItem['ITEM_PRICE_SELECTED']];
$measureRatio = $actualItem['ITEM_MEASURE_RATIOS'][$actualItem['ITEM_MEASURE_RATIO_SELECTED']]['RATIO'];
$showDiscount = $price['PERCENT'] > 0;

if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y') {
    $skuDescription = false;
    foreach ($arResult['OFFERS'] as $offer) {
        if ($offer['DETAIL_TEXT'] != '' || $offer['PREVIEW_TEXT'] != '') {
            $skuDescription = true;
            break;
        }
    }
    $showDescription = $skuDescription || !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
} else {
    $showDescription = !empty($arResult['PREVIEW_TEXT']) || !empty($arResult['DETAIL_TEXT']);
}
$showBuyBtn = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION']);
$buyButtonClassName = in_array('BUY', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showAddBtn = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION']);
$showButtonClassName = in_array('ADD', $arParams['ADD_TO_BASKET_ACTION_PRIMARY']) ? 'btn-primary' : 'btn-link';
$showSubscribe = $arParams['PRODUCT_SUBSCRIPTION'] === 'Y' && ($arResult['PRODUCT']['SUBSCRIBE'] === 'Y' || $haveOffers);

$productType = isset($arResult['PROPERTIES']['PRODUCTTYPE']) && $arResult['PROPERTIES']['PRODUCTTYPE']['VALUE'] ? $arResult['PROPERTIES']['PRODUCTTYPE']['VALUE'] : null;

$mainBlockProperties = !empty($arResult['DISPLAY_PROPERTIES']) ? array_intersect_key($arResult['DISPLAY_PROPERTIES'], $arParams['MAIN_BLOCK_PROPERTY_CODE']) : [];

$badge = isset($arResult['PROPERTIES']['BADGE']) && $arResult['PROPERTIES']['BADGE']['~VALUE'] ? $arResult['PROPERTIES']['BADGE']['~VALUE'] : null;

$basePrice = $arResult["ITEM_PRICES"][0]["BASE_PRICE"] ?: false;
$bShowCalculator = isset($arResult['PROPERTIES']['SHOW_CALCULATOR']) && isset($arResult['PROPERTIES']['SHOW_CALCULATOR']['VALUE']) && $arResult['PROPERTIES']['SHOW_CALCULATOR']['VALUE'] == 'Y' && $basePrice;
?>
<div class="section">
    <div class="container">
        <?php echo MrigroupHelper::index_breadcrumbs;?>

        <div class="product-layout">
            <div class="product-layout-head" data-entity="images-container">
                <div class="product-slider-wrap">
                    <div class="product-slider swiper">
                        <?php
                        if (!empty($actualItem['MORE_PHOTO'])) {
                            foreach ($actualItem['MORE_PHOTO'] as $key => $photo) {
                                ?>
                                <a href="<?php echo $photo['SRC']; ?>" class="product-slider-item swiper-slide"
                                   data-fancybox="gallery">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                         data-src="<?php echo $photo['SRC']; ?>" alt="<?php echo $alt; ?>"
                                         title="<?php echo $title; ?>" <?php echo $key == 0 ? ' itemprop="image"' : ''; ?>
                                         class="lazyload" />
                                </a>

                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="swiper-navigation">
                        <button class="swiper-button-prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M12 21.03L3.97 13 12 4.97l1.06 1.06-6.22 6.22h15.19v1.5H6.84l6.22 6.22L12 21.03z" />
                            </svg>
                        </button>
                        <button class="swiper-button-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M14 21.03L22.03 13 14 4.97l-1.06 1.06 6.22 6.22H3.97v1.5h15.19l-6.22 6.22L14 21.03z" />
                            </svg>
                        </button>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>

                <?php if ($badge): ?>
                    <div class="product-badge" style="background-color: <?php echo $badge["UF_COLOR"] ?>">
                        <?php echo $badge["UF_NAME"] ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="product-layout-side" data-sticky-parent id="<?php echo $itemIds['ID']; ?>" itemscope itemtype="http://schema.org/Product">
                <div class="product-layout-stick" data-sticky-column>
                    <div class="product-section">
                        <h1 class="product-title">
                            <?php if($productType):?>
                                <span><?php echo $productType;?></span>
                            <?php endif;?>
                            <?php echo $name; ?>
                        </h1>

                        <?php if(count($arResult['ANONS_PROPERTIES'])):?>
                            <div class="product-props catalog-props">
                                <?php foreach($arResult['ANONS_PROPERTIES'] as $anonsProperty):?>
                                    <div class="catalog-props-item">
                                        <div class="catalog-props-item__title"><?php echo $anonsProperty['TITLE'];?></div>
                                        <div class="catalog-props-item__value"><?php echo $anonsProperty['VALUE'];?></div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        <?php endif;?>
                    </div>

                    <?php if($arResult['ITEM_PRICES'][0]['BASE_PRICE']):?>
                        <div class="product-section">
                            <div class="product-prices catalog-prices">
                                <div class="catalog-prices-item">
                                <span class="catalog-prices-item__value">
                                    <?if ($arResult["PROPERTIES"]["OT"]["VALUE"]){?>От<?}?>
                                    <?= $arResult["ITEM_PRICES"][0]["PRINT_PRICE"] ?? $arResult["ITEM_PRICES"][0]["BASE_PRICE"] ?>
                                </span>
                                    <?if ($arResult["ITEM_PRICES"][0]["PERCENT"]){?>
                                        <span class="catalog-prices-item__discount">
                                    - <?=$arResult["ITEM_PRICES"][0]["PERCENT"]?>%
                                </span>
                                    <?}?>
                                </div>
                                <?if ($arResult["ITEM_PRICES"][0]["PERCENT"]){?>
                                    <div class="catalog-prices-item catalog-prices-item_type_old">
                                <span class="catalog-prices-item__value">
                                    <?=$arResult["ITEM_PRICES"][0]["PRINT_RATIO_BASE_PRICE"]?>
                                </span>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    <?php endif;?>

                    <div class="product-section">
                        <div class="product-button">
                            <a href="<?php echo MrigroupHelper::getModalOfferLink($arResult['ID']);?>" class="btn btn-primary link-modal">Запросить КП</a>
                            <a href="https://api.whatsapp.com/send?phone=79601147777&roistat_visit=156797" class="btn btn-outline-primary" target="_blank">
                                <span>Задать вопрос</span>
                                <img src="<?php echo SITE_TEMPLATE_PATH;?>/icons/icon-social-wa.svg" />
                            </a>
                        </div>
                    </div>

                    <?php if(isset($arResult['POSTER_TEMPLATE']) && $arResult['POSTER_TEMPLATE']) {
                        $APPLICATION->IncludeFile(
                            str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__) . '/poster/' . $arResult['POSTER_TEMPLATE'] . '.php',
                            [],
                            [
                                'SHOW_BORDER' => false,
                                'NAME' => ''
                            ]
                        );
                    }?>

                    <?php if($bShowCalculator):?>
                        <div class="product-section">
                            <div class="product-button">
                                <a href="#calc" class="btn btn-outline-primary">Калькулятор окупаемости</a>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>

            <div class="product-layout-body">
                <div class="product-section">
                    <?php if(count($mainBlockProperties)):?>
                        <div class="product-description">
                            <h2>Характеристики</h2>

                            <div class="section-content">
                                <div class="table-responsive">
                                    <table>
                                        <tbody>
                                        <?php foreach ($mainBlockProperties as $property):?>
                                            <tr>
                                                <th><?php echo $property['NAME']; ?></th>
                                                <td>
                                                    <?php if($property['CODE'] == 'MAG_FIELD_STRENGHT'):?>
                                                        <a href="<?php echo $arResult['SECTION']['SECTION_PAGE_URL'];?>?arrFilter_59_<?php echo abs(crc32($property['VALUE_ENUM_ID']));?>=Y&set_filter=" target="_blank"><?php echo $property['DISPLAY_VALUE'];?></a>
                                                    <?php else:?>
                                                        <?php echo is_array($property['DISPLAY_VALUE'])
                                                            ? implode(' / ', $property['DISPLAY_VALUE'])
                                                            : $property['DISPLAY_VALUE']; ?>
                                                    <?php endif;?>
                                                </td>
                                            </tr>
                                        <?php endforeach;?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>

                <?if (($arResult['PREVIEW_TEXT']) || $arResult['DETAIL_TEXT']){?>
                    <div class="product-section">
                        <div class="product-description">
                            <h2>Описание</h2>

                            <div class="section-content">
                                <?php
                                if (
                                    $arResult['PREVIEW_TEXT'] != ''
                                    && ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'S'
                                        || ($arParams['DISPLAY_PREVIEW_TEXT_MODE'] === 'E' && $arResult['DETAIL_TEXT'] == '')
                                    )
                                ) {
                                    echo $arResult['PREVIEW_TEXT_TYPE'] === 'html' ? $arResult['PREVIEW_TEXT'] : $arResult['PREVIEW_TEXT'];
                                }

                                if ($arResult['DETAIL_TEXT'] != '') {
                                    echo $arResult['DETAIL_TEXT_TYPE'] === 'html' ? $arResult['DETAIL_TEXT'] : $arResult['DETAIL_TEXT'];
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?}?>
                <? if ($arResult['PROPERTIES']['POPUP_VIDEO']['VALUE']) {?>

                    <div class="product-section">
                        <h2>Видео</h2>

                        <a href="<?php echo $arResult['PROPERTIES']['POPUP_VIDEO']['VALUE']; ?>" class="link-video"
                           data-fancybox="video">
                        <span class="link-video__poster">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 data-src="<?php echo CFile::GetPath($arResult['PROPERTIES']['ZAGLVID']['VALUE']); ?>"
                                 alt="" class="lazyload" />
                        </span>
                            <span class="link-video__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                <path d="M8.286 22.286V3.715l13 9.286-13 9.285z" />
                            </svg>
                        </span>
                        </a>

                    </div>
                <?}?>
                <? if (!empty($arResult['PROPERTIES']['CLINIC_PIC']['VALUE'])) {?>
                    <div class="product-section">
                        <h2>Клинические изображения</h2>
                        <div class="single-slider swiper">
                            <?php foreach ($arResult['PROPERTIES']['CLINIC_PIC']['VALUE'] as $arIDPIC => $PICvalue) {
                                $filePath = CFile::GetPath($PICvalue);?>
                                <a href="<?php echo $filePath;?>" class="single-slider-item swiper-slide" data-fancybox="clinic">
                                    <div class="single-slider-item__image">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             data-src="<?php echo $filePath; ?>" alt="" class="lazyload" />
                                    </div>
                                    <div class="single-slider-item__caption">
                                        <?php echo $arResult['PROPERTIES']['CLINIC_PIC']['DESCRIPTION'][$arIDPIC]; ?>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>

                    </div>
                <?}?>
                <? if ($arResult['PROPERTIES']['DOCS']['VALUE']) {?>

                    <div class="product-section">
                        <div class="main-docs">
                            <h2>Документы</h2>

                            <div class="main-docs-list docs-list row">

                                <?php foreach ($arResult['PROPERTIES']['DOCS']['VALUE'] as $arIDDOC => $DOCvalue) { ?>

                                    <?php $path = CFile::GetPath($DOCvalue);
                                    $info = pathinfo($path);
                                    $size = filesize($_SERVER['DOCUMENT_ROOT'].$path);

                                    switch ($info['extension']) {
                                        case 'xlsx':
                                            $ind = '/data/img/docs/xls.png';
                                            break;
                                        case 'xls':
                                            $ind = '/data/img/docs/xls.png';
                                            break;
                                        case 'docx':
                                            $ind = '/data/img/docs/doc.png';
                                            break;
                                        case 'doc':
                                            $ind = '/data/img/docs/doc.png';
                                            break;
                                        case 'pdf':
                                            $ind = '/data/img/docs/pdf.png';
                                            break;
                                        default:
                                            $ind = '/data/img/docs/pdf.png';
                                    }
                                    ?>
                                    <div class="main-docs-item docs-item col-12 col-md-6">
                                        <div class="docs-item__outer">
                                            <div class="docs-item__body">
                                                <div class="docs-item__icon">
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                         data-src="<?php echo $ind; ?>" alt="" class="lazyload" />
                                                </div>
                                                <div class="docs-item__name">

                                                    <a target="_blank" href="<?php echo $path; ?>" class="docs-item__link">
                                                        <?php echo $arResult['PROPERTIES']['DOCS']['DESCRIPTION'][$arIDDOC]; ?>
                                                        <span><?php echo round($size / 1024 / 1024, 2); ?>
                                                    mb</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                <?php } ?>

                            </div>
                        </div>
                    </div>
                <?}?>
                <?php if($bShowCalculator) {
                    $APPLICATION->IncludeComponent(
                        "parfyonov:arfoto.calc",
                        "form",
                        array(
                            'PRODUCT_ID' => $arResult['ID']
                        ),
                        false
                    );
                }?>
            </div>
        </div>
    </div>
</div>