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
<div class="section main-reviews">
    <div class="container">
    <h2 class="section-title">Отзывы</h2>
<div class="reviews-list cards-list row">


<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

<div class="reviews-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="reviews-item__outer cards-item-outer">
            <div class="reviews-item__head cards-item-head">
                <div class="reviews-item__image cards-item-image">
                    <a href="<?=CFile::GetPath($arItem["PROPERTIES"]["FILE"]['VALUE'][0])?>" data-fancybox="reviews">
                        <div class="cards-item-image-wrap">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                data-src="<?=CFile::GetPath($arItem["PROPERTIES"]["FILE"]['VALUE'][0])?>" alt="" class="lazyload" />
                        </div>
                    </a>
                </div>
            </div>
            <div class="reviews-item__body cards-item-body">
                <div class="reviews-item__title">
                    <?echo $arItem["NAME"]?>
                </div>
            </div>
        </div>   </div>
<?endforeach;?>

</div>
</div>
</div>