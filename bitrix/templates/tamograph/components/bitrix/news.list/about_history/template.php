<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

if (!isset($arResult['ITEMS']) || !is_array($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}
?>
<div class="section main-history">
    <div class="container">
        <h2 class="section-title">История</h2>

        <div class="main-history-timeline-wrap">
            <div class="swiper-navigation">
                <button class="swiper-button-first">
                    <span><?php echo $arResult['ITEMS'][0]['PROPERTIES']['YEAR']['VALUE']; ?></span></button>
                <button class="swiper-button-last">
                    <span><?php echo $arResult['ITEMS'][array_key_last($arResult['ITEMS'])]["PROPERTIES"]["YEAR"]["VALUE"]; ?></span>
                </button>
            </div>
            <div class="main-history-timeline timeline swiper">
                <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                    <a class="main-history-timeline-item timeline-item swiper-slide"><span><?php echo $arItem["PROPERTIES"]["YEAR"]["VALUE"]; ?></span></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="main-history-slider-wrap">
            <div class="swiper-navigation">
                <button class="swiper-button-prev">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M12 21.03L3.97 13 12 4.97l1.06 1.06-6.22 6.22h15.19v1.5H6.84l6.22 6.22L12 21.03z"/>
                    </svg>
                </button>
                <button class="swiper-button-next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M14 21.03L22.03 13 14 4.97l-1.06 1.06 6.22 6.22H3.97v1.5h15.19l-6.22 6.22L14 21.03z"/>
                    </svg>
                </button>
            </div>
            <div class="main-history-slider swiper">
                <?php foreach ($arResult["ITEMS"] as $arItem):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
                    <div class="main-history-slider-item history-item swiper-slide"
                         id="<?php echo $this->GetEditAreaId($arItem['ID']); ?>">
                        <div class="history-item__outer">
                            <h3>
                                <?php echo $arItem["NAME"] ?>
                            </h3>

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <div class="section-content">
                                        <?php echo $arItem["PREVIEW_TEXT"]; ?>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <?php if (isset($arItem['PREVIEW_PICTURE']) && isset($arItem['PREVIEW_PICTURE']['SRC'])): ?>
                                        <div class="history-item__image">
                                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                 data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt=""
                                                 class="lazyload"/>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>