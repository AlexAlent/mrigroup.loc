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

if(!isset($arResult['ITEMS']) || !is_array($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}
?>
<div class="section main-promos">
    <div class="container">
        <h2 class="section-title">Акции</h2>

        <div class="main-promos-list promos-list cards-list row">
            <?php foreach($arResult['ITEMS'] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
                <div class="main-promos-item promos-item cards-item col-12 col-md-6" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                    <div class="promos-item__outer cards-item-outer">
                        <div class="promos-item__head cards-item-head">
                            <div class="promos-item__image cards-item-image">
                                <a href="<?php echo $arItem["DETAIL_PAGE_URL"]?>">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="lazyload" />
                                </a>
                            </div>
                        </div>
                        <div class="promos-item__body cards-item-body">
                            <div class="promos-item__title cards-item-title">
                                <a href="<?php echo $arItem["DETAIL_PAGE_URL"]?>" class="promos-item__link cards-item-link"><?php echo $arItem['NAME'];?></a>
                            </div>
                        </div>
                        <?php if(isset($arItem['DATE_ACTIVE_TO'])):?>
                            <div class="promos-item__foot cards-item-foot">
                                <div class="promos-item__info"> Акция до <?php echo date('d.m.Y', strtotime($arItem["DATE_ACTIVE_TO"]));?> </div>
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>

        <div class="section-footer">
            <a href="<?php echo $arResult['ITEMS'][0]['LIST_PAGE_URL'];?>" class="btn btn-outline-primary">
                <span>Все акции</span>
            </a>
        </div>
    </div>
</div>