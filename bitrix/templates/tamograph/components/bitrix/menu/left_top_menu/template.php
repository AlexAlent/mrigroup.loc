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

CUtil::InitJSCore();

$menuBlockId = "catalog_menu_".$this->randString();
?>

		<ul class="topbar-nav nav" id="ul_<?=$menuBlockId?>">
		<?
		foreach($arResult["MENU_STRUCTURE"] as $itemID => $arColumns)
		{
		    //--first level--
		
		?>
			<li class="nav-item <?if ($arResult["ALL_ITEMS"][$itemID]["SELECTED"]){?> active<?};?>">
				<a class="nav-link"
					href="<?=$arResult["ALL_ITEMS"][$itemID]["LINK"]?>">
					<span>
						<?=htmlspecialcharsbx($arResult["ALL_ITEMS"][$itemID]["TEXT"], ENT_COMPAT, false)?>
					</span>
				</a>
			</li>
		<?
		}
		?>
		</ul>
