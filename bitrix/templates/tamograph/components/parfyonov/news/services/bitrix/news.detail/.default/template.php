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

$arButtons = CIBlock::GetPanelButtons(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    0,
    array("SECTION_BUTTONS"=>false, "SESSID"=>false)
);

$this->AddEditAction($arResult['ID'], $arButtons['edit']['edit_element']['ACTION_URL'], CIBlock::GetArrayByID($arResult["IBLOCK_ID"], "ELEMENT_EDIT"));
?>
<div class="row" id="<?php echo $this->GetEditAreaId($arResult['ID']);?>">
    <div class="col-12 col-lg-8">
        <div class="section-content">
            <h1><?php echo $arResult['NAME'];?></h1>

            <?php echo $arResult['DETAIL_TEXT'];?>
        </div>
    </div>
</div>