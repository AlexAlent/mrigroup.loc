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
<div class="brands-list cards-list row">
    <?php foreach($arResult["ITEMS"] as $arItem):
        $this->AddEditAction( $arItem[ 'ID' ], $arItem[ 'EDIT_LINK' ], CIBlock::GetArrayByID( $arItem[ "IBLOCK_ID" ], "ELEMENT_EDIT" ) );
        $this->AddDeleteAction( $arItem[ 'ID' ], $arItem[ 'DELETE_LINK' ], CIBlock::GetArrayByID( $arItem[ "IBLOCK_ID" ], "ELEMENT_DELETE" ), array( "CONFIRM" => GetMessage( 'CT_BNL_ELEMENT_DELETE_CONFIRM' ) ) ); ?>
        <div class="brands-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
            <div class="brands-item__outer cards-item-outer">
                <div class="brands-item__head cards-item-head">
                    <div class="brands-item__image cards-item-image">
                        <a href="<?php echo $arItem["DETAIL_PAGE_URL"]?>">
                            <?php if(isset($arItem['PREVIEW_PICTURE']) && $arItem['PREVIEW_PICTURE']['SRC']):?>
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?php echo htmlspecialchars($arItem['NAME']);?>" class="lazyload" />
                            <?php else:?>
                                <?php echo $arItem['NAME'];?>
                            <?php endif;?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>