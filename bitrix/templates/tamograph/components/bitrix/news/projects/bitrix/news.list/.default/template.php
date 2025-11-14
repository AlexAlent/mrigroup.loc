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
$this->setFrameMode(true);?>
<?php if(count($arResult['ITEMS'])):?>
    <div class="projects-list cards-list row">
        <?php foreach($arResult["ITEMS"] as $arItem):
            $name = $arItem['NAME'];
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
            <div class="projects-item cards-item col-12 col-sm-6 col-lg-4" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                <div class="projects-item__outer cards-item-outer">
                    <div class="projects-item__image cards-item-image">
                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="<?php if(isset($arItem['PREVIEW_PICTURE'])):?> data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?>"<?php endif;?> alt="<?php echo htmlspecialchars($name);?>" class="lazyload" />
                    </div>
                    <div class="projects-item__inner">
                        <div class="projects-item__body cards-item-body">
                            <div class="projects-item__name cards-item-title">
                                <a href="<?php echo $arItem["DETAIL_PAGE_URL"]?>" class="projects-item__link cards-item-link"><?php echo $name?></a>
                            </div>
                        </div>
                        <div class="projects-item__foot cards-item-foot">
                            <div class="projects-item__info"><?php echo $arItem["PREVIEW_TEXT"] ?? '';?> </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>

    <?php echo isset($arResult["NAV_STRING"]) ? $arResult['NAV_STRING'] : '';?>
<?php endif;?>