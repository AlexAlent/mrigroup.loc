<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */

$this->setFrameMode(true);

if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
}

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-'.$navParams['NavNum'];
?>
<div class="products-list cards-list row" data-entity="<?=$containerName?>">
    <?php if (!empty($arResult['ITEMS'])):
        $areaIds = [];?>
        <?php foreach ($arResult['ITEMS'] as $item):
        $uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
        $areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
        $this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
        $this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);?>
        <div class="products-item cards-item col-12 col-sm-6 col-lg">
            <?php
            $APPLICATION->IncludeComponent(
                'bitrix:catalog.item',
                'arfoto',
                array(
                    'RESULT' => array(
                        'ITEM' => $item,
                        'AREA_ID' => $areaIds[$item['ID']],
                    ),
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            ?>
        </div>
    <?php endforeach;?>
    <?php endif;?>
</div>
<?
//region Pagination
if ($showBottomPager)
{
    echo $arResult['NAV_STRING'];
}
//endregion
?>
<div class="section">
    <div class="container">
        <div class="section-content">
                     
<?	//region Description
	if (($arParams['HIDE_SECTION_DESCRIPTION'] !== 'Y') && !empty($arResult['DESCRIPTION']))
	{
		?>
		<div class="row mb-4">
			<div class="col catalog-section-description">
				<p><?=$arResult['DESCRIPTION']?></p>
			</div>
		</div>
		<?//endregion
	}?>
        </div>
    </div>
</div>