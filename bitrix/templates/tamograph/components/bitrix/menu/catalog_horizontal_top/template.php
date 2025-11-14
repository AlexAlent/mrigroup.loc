<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

if (empty($arResult["ALL_ITEMS"]))
	return;

\Bitrix\Main\UI\Extension::load(['ui.design-tokens']);

$menuBlockId = "catalog_menu_".$this->randString();
?>
<?foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns):?>
<!-- first level-->
<li class="nav-item dropdown <?if($arResult["ALL_ITEMS"][$itemID]["SELECTED"]):?> active<?endif?>">
    <a class="nav-link dropdown-toggle" href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
        <span><?=$arResult["ALL_ITEMS"][$itemID]["TEXT"]?></span>
    </a>
    <?if (is_array($arColumns) && !empty($arColumns)):?>
    <?foreach($arColumns as $key=>$arRow):?>
    <ul class="dropdown-menu">
        <?foreach($arRow as $itemIdLevel_2=>$arLevel_3):?>
        <!-- second level-->
        <li class="dropdown-item <?if($arResult["ALL_ITEMS"][$itemIdLevel_2]["SELECTED"]):?>active<?endif?>">
            <a class="dropdown-link" href="<?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["LINK"]?>">
                <span><?=$arResult["ALL_ITEMS"][$itemIdLevel_2]["TEXT"]?></span>
            </a>
        </li>
        <?endforeach;?>
    </ul>
    <?endforeach;?>
    <?endif?>
</li>
<?endforeach;?>
