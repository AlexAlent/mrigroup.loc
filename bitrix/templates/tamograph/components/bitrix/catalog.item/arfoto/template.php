<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

$this->setFrameMode(true);

if (!isset($arResult['ITEM'])) {
    return;
}

$item = $arResult['ITEM'];
$url = $item['DETAIL_PAGE_URL'];
$name = $item['NAME'];

$badge = isset($item['PROPERTIES']['BADGE']) && $item['PROPERTIES']['BADGE']['~VALUE'] ? $item['PROPERTIES']['BADGE']['~VALUE'] : null;

$price = 0;
$oldPrice = 0;
if (isset($item['ITEM_PRICES']) && is_array($item['ITEM_PRICES'])) {
    $price = intval($item['ITEM_PRICES'][0]['PRICE']);
    if(isset($item['PROPERTIES']['OLD_PRICE']) && $item['PROPERTIES']['OLD_PRICE']['VALUE'] > $price) {
        $oldPrice = $item['PROPERTIES']['OLD_PRICE']['VALUE'];
    }
}

$priceFrom = isset($item['PROPERTIES']['OT']) && $item['PROPERTIES']['OT']['VALUE'];
?>
<div class="products-item__outer cards-item-outer"<?php if (isset($arResult['AREA_ID'])): ?> id="<?php echo $arResult['AREA_ID']; ?>"<?php endif; ?>>
    <div class="products-item__head cards-item-head">
        <div class="products-item__image cards-item-image">
            <a href="<?php echo $url; ?>">
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                     data-src="<?php echo $item['GALLERY'][0]; ?>" alt="" class="lazyload"/>
                <ul class="cards-item-image-list">
                    <?php foreach ($item['GALLERY'] as $i => $image): ?>
                        <li data-src="<?php echo $image; ?>"<?php if ($i == 0): ?> class="active"<?php endif; ?>></li>
                    <?php endforeach; ?>
                </ul>
            </a>
        </div>
        <?php if ($badge): ?>
            <div class="products-item__badge" style="background-color: <?php echo $badge["UF_COLOR"] ?>">
                <?php echo $badge["UF_NAME"] ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="products-item__body cards-item-body">
        <div class="products-item__title cards-item-title">
            <a class="products-item__link cards-item-link" href="<?php echo $url; ?>" title="<?php echo htmlspecialchars($name); ?>">
                <?php if($arResult['PRODUCT_TYPE']):?>
                    <span><?php echo $arResult['PRODUCT_TYPE'];?></span>
                <?php endif;?>
                <?php echo $name; ?>
            </a>
        </div>
        <?php if ($price > 0): ?>
            <div class="products-item__prices catalog-prices">
                <div class="catalog-prices-item">
                    <span class="catalog-prices-item__value"><?php echo ($priceFrom ? 'от ' : '') . $item['ITEM_PRICES'][0]['PRINT_PRICE']; ?></span>
                    <?php if($oldPrice > 0 && isset($item['PROPERTIES']['DISCOUNT_PERCENT']) && $item['PROPERTIES']['DISCOUNT_PERCENT']['VALUE']):?>
                        <span class="catalog-prices-item__discount">- <?php echo $item['PROPERTIES']['DISCOUNT_PERCENT']['VALUE'];?>%</span>
                    <?php endif;?>
                </div>
                <?php if($oldPrice > 0):?>
                    <div class="catalog-prices-item catalog-prices-item_type_old">
                        <span class="catalog-prices-item__value"><?php echo number_format($item['PROPERTIES']['OLD_PRICE']['VALUE'], 0, '', ' ');?> ₽</span>
                    </div>
                <?php endif;?>
            </div>
        <?php endif; ?>
        <div class="products-item__button">
            <a href="<?php echo MrigroupHelper::getModalOfferLink($arResult['ITEM']['ID']);?>" class="btn btn-outline-primary link-modal">Запросить КП</a>
        </div>
        <?php if(count($arResult['ICONS'])):?>
            <div class="products-item__props catalog-props">
                <?php foreach($arResult['ICONS'] as $arIcon):?>
                    <div class="catalog-props-item">
                        <div class="catalog-props-item__icon">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo SITE_TEMPLATE_PATH; ?>/icons/<?php echo $arIcon['ICON'];?>" alt="" class="lazyload"/>
                        </div>
                        <div class="catalog-props-item__title"><?php echo $arIcon['TITLE'];?>:</div>
                        <div class="catalog-props-item__value"><?php echo $arIcon['VALUE'];?></div>
                    </div>
                <?php endforeach;?>
            </div>
        <?php endif;?>
    </div>
</div>