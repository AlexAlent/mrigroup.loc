<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogTopComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

if(!isset($arResult['ITEMS']) || !is_array($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}

$items = $arResult['ITEMS'];

if(isset($arParams['PRODUCTS_ORDER']) && is_array($arParams['PRODUCTS_ORDER']) && count($arParams['PRODUCTS_ORDER'])) {
    $sorted = [];
    $unsorted = [];

    foreach($items as $item) {
        $order = array_search($item['ID'], $arParams['PRODUCTS_ORDER']);

        if($order !== false) {
            $sorted[$order] = $item;
        } else {
            $unsorted[] = $item;
        }
    }

    ksort($sorted);

    $items = array_merge($sorted, $unsorted);
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>
<div class="section main-products">
    <div class="container">
        <?php if(isset($arParams['BLOCK_TITLE']) && $arParams['BLOCK_TITLE']):?>
            <h2 class="section-title"><?php echo $arParams['BLOCK_TITLE'];?></h2>
        <?php endif;?>

        <div class="main-products-slider-wrap">
            <div class="main-products-slider swiper">
                <?php foreach($items as $item):
                    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $elementEdit);
                    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $elementDelete, $elementDeleteParams); ?>
                    <div class="main-products-slider-item products-item cards-item swiper-slide" id="<?php echo $this->GetEditAreaId($item['ID']);?>">
                        <?php
                        $APPLICATION->IncludeComponent(
                            'bitrix:catalog.item',
                            'arfoto',
                            array(
                                'RESULT' => array(
                                    'ITEM' => $item,
                                ),
                                'HIDE_ICONS' => 'Y'
                            ),
                            $component,
                            array('HIDE_ICONS' => 'Y')
                        );
                        ?>
                    </div>
                <?php endforeach;?>
            </div>

            <div class="swiper-navigation">
                <button class="swiper-button-prev">
                    <img src="<?php echo SITE_TEMPLATE_PATH;?>/icons/arrow-left.svg" />
                </button>
                <button class="swiper-button-next">
                    <img src="<?php echo SITE_TEMPLATE_PATH;?>/icons/arrow-right.svg" />
                </button>
            </div>
        </div>
    </div>
</div>
