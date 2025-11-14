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

if(!is_array($arResult) || !isset($arResult['ITEMS']) || !is_array($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}
?>
<div class="cards-list row">
    <?php foreach($arResult['ITEMS'] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
        <div class="cards-item col-12 col-sm-6 col-lg-4 col-xl-3" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
            <div class="cards-item-outer">
                <div class="cards-item-head">
                    <div class="cards-item-image">
                        <a href="<?php echo $arItem["DETAIL_PAGE_URL"]?>">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                 data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="lazyload" />
                        </a>
                    </div>
                </div>
                <div class="cards-item-body">
                    <div class="cards-item-title">
                        <a href="<?php echo $arItem["DETAIL_PAGE_URL"]?>" class="cards-item-link">
                            <?php echo $arItem["NAME"]?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>