<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
<div class="section">
    <div class="container">
        <h2 class="section-title">Наша команда</h2>
        <div class="persons-list cards-list row">
            <?php foreach ($arResult["ITEMS"] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

                $email = isset($arItem['PROPERTIES']['EMAIL']) ? trim($arItem['PROPERTIES']['EMAIL']['VALUE']) : '';
                ?>
                <div class="persons-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3" id="<?php echo $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="persons-item__outer cards-item-outer">
                        <div class="persons-item__head cards-item-head">
                            <?php if(isset($arItem['PREVIEW_PICTURE'])):?>
                                <div class="persons-item__image cards-item-image"><img
                                            src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                            data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?php echo htmlspecialchars($arItem['NAME']);?>" class="lazyload"/>
                                </div>
                            <?php endif;?>
                        </div>
                        <div class="persons-item__body cards-item-body">
                            <div class="persons-item__name cards-item-title">
                                <?php echo $arItem["NAME"] ?>
                            </div>
                            <div class="persons-item__role">
                                <?php echo $arItem["PREVIEW_TEXT"]; ?>
                            </div>
                        </div>
                        <?php if ($email):?>
                            <div class="persons-item__foot cards-item-foot">
                                <div class="persons-item__info">
                                    <a href="mailto:<?php echo $email;?>"><?php echo $email;?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="section-footer">
            <a href="<?php echo $arResult['ITEMS'][0]['LIST_PAGE_URL'];?>" class="btn btn-outline-primary">
                <span>Вся команда</span>
            </a>
        </div>
    </div>
</div>