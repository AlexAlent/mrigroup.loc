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
<div class="row">
    <div class="col-12 col-lg-9">
        <h2 class="section-title">Общие вопросы</h2>
        <div class="accordion">
            <?php foreach($arResult["ITEMS"] as $arItem):
                $id = $arItem['ID'];
                $this->AddEditAction($id, $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($id, $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
            <div class="accordion-item" id="<?php echo $this->GetEditAreaId($id);?>">
                <div class="accordion-header" id="question-<?php echo $id;?>">
                    <button type="button" class="accordion-button collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $id;?>" aria-expanded="false" aria-controls="collapse-<?php echo $id;?>">
                        <span><?php echo $arItem["NAME"]?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.97 10.28l1.06-1.06L13 15.19l5.97-5.97 1.06 1.06L13 17.31l-7.03-7.03z"/>
                        </svg>
                    </button>
                </div>
                <div id="collapse-<?php echo $id;?>" class="accordion-collapse collapse" aria-labelledby="question-<?php echo $id;?>">
                    <div class="accordion-body">
                        <div class="section-content">
                            <p><?php echo $arItem["PREVIEW_TEXT"];?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>


