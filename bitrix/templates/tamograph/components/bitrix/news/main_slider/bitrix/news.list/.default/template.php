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

<div class="section main-hero">
    <div class="container">
        <div class="main-hero-slider-wrap">
            <div class="main-hero-slider swiper">
                <?php foreach($arResult["ITEMS"] as $arItem):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
                    <div class="main-hero-slider-item swiper-slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="main-hero-slider-item__row row">
                            <div class="main-hero-slider-item__col col-12 col-lg-7">
                                <div class="main-hero-slider-item__content">
                                    <div class="main-hero-slider-item__content-back">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             data-src="/data/img/hero/circle.svg" alt="" class="lazyload" />
                                    </div>
                                    <div class="main-hero-slider-item__content-front">
                                        <div class="main-hero-slider-item__content-wrap">
                                            <div class="main-hero-slider-item__title">
                                                <?=$arItem["NAME"]?>
                                            </div>
                                            <div class="main-hero-slider-item__text">
                                                <?=$arItem["PREVIEW_TEXT"]?>
                                            </div>
                                            <?/*if (isset($arItem["PROPERTIES"]["LINK"]["VALUE"]) && is_array($arItem["PROPERTIES"]["LINK"]["VALUE"])){?>
                                                <div class="main-hero-slider-item__button">
                                                    <a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]["TEXT"]?>" class="btn btn-link">
                                                        <span><?=$arItem["PROPERTIES"]["LINKTEXT"]["VALUE"]["TEXT"]?></span>
                                                    </a>
                                                </div>
                                            <?}*/?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-hero-slider-item__col col-12 col-lg-7">
                                <div class="main-hero-slider-item__image">
                                    <div class="main-hero-slider-item__image-back"></div>
                                    <div class="main-hero-slider-item__image-front">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="lazyload" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
            <div class="swiper-navigation">
                <div class="container">
                    <button class="swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.03L3.97 13 12 4.97l1.06 1.06-6.22 6.22h15.19v1.5H6.84l6.22 6.22L12 21.03z"/></svg>
                    </button>
                    <button class="swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M14 21.03L22.03 13 14 4.97l-1.06 1.06 6.22 6.22H3.97v1.5h15.19l-6.22 6.22L14 21.03z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>