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
<div class="section">
    <div class="container">
        <div class="main-advantages__outer">
            <h2 class="section-title">
                Наши преимущества
            </h2>

            <div class="main-advantages__list row">
                <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
                <div class="main-advantages__item main-advantages-item col-12 col-sm-4"
                    id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="main-advantages-item__outer">
                        <div class="main-advantages-item__image">
                            <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" />
                        </div>
                        <div class="main-advantages-item__text">
                            <?echo $arItem["NAME"]?>
                        </div>
                    </div>
                </div>
                <? endforeach;?>
            </div>
        </div>
    </div>
</div>