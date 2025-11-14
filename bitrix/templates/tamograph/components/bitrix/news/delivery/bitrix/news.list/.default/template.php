<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php

/** @var array $arParams */
/** @var array $arResult */

if(!is_array($arResult) || !isset($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}
?>
<div class="cards-list row">
    <?php foreach($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
        <a href="<?php echo $arItem['DETAIL_PAGE_URL'];?>" class="cards-item col-12 col-sm-6 col-md-3" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
            <div class="cards-item-outer">
                <div class="cards-item-head">
                    <div class="cards-item-icon">
                        <?php if(isset($arItem['ICON'])):?>
                            <img src="<?php echo $arItem['ICON'];?>" />
                        <?php endif;?>
                    </div>
                </div>
                <div class="cards-item-body">
                    <div class="cards-item-title"><?php echo $arItem['NAME'];?></div>
                </div>
            </div>
        </a>
    <?php endforeach;?>
</div>