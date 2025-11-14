<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogTopComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);

if(!isset($arResult['ITEMS']) || !is_array($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));
?>
<div class="section products">
    <div class="container">
        <h2 class="section-title">
            Список товаров бренда
        </h2>

        <div class="products-list cards-list row">
            <?php foreach($arResult['ITEMS'] as $item):
                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], $elementEdit);
                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], $elementDelete, $elementDeleteParams); ?>
                <div class="products-item cards-item col-12 col-sm-6 col-lg" id="<?php echo $this->GetEditAreaId($item['ID']);?>">
                    <?php
                    $APPLICATION->IncludeComponent(
                        'bitrix:catalog.item',
                        'arfoto',
                        array(
                            'RESULT' => array(
                                'ITEM' => $item,
                            ),
                        ),
                        $component,
                        array('HIDE_ICONS' => 'Y')
                    );
                    ?>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
