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
?>
<div class="brands-list cards-list row">
    <?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction( $arItem[ 'ID' ], $arItem[ 'EDIT_LINK' ], CIBlock::GetArrayByID( $arItem[ "IBLOCK_ID" ], "ELEMENT_EDIT" ) );
    $this->AddDeleteAction( $arItem[ 'ID' ], $arItem[ 'DELETE_LINK' ], CIBlock::GetArrayByID( $arItem[ "IBLOCK_ID" ], "ELEMENT_DELETE" ), array( "CONFIRM" => GetMessage( 'CT_BNL_ELEMENT_DELETE_CONFIRM' ) ) );
    ?>
    <div class="brands-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="brands-item__outer cards-item-outer">
            <div class="brands-item__head cards-item-head">
                <div class="brands-item__image cards-item-image"> <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"> 
                    <?if ($arItem["PREVIEW_PICTURE"]["SRC"]){?>
                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                    data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="lazyload" /> 
                    <?} else {?>NO LOGO<?}?>
                    </a> </div>
            </div>
        </div>
    </div>
    <?endforeach;?>
    <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>

    <?=$arResult["NAV_STRING"]?>
    <?endif;?>
</div>
