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

$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'TILE' => array(
		'TITLE' => 'catalog-section-list-item-title',
		'LIST' =>  'catalog-section-list-tile-list row mb-4',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

switch ($arParams['LIST_COLUMNS_COUNT'])
{
	case "1":
		$listColumsClass = "col-12";
		break;
	case "2":
		$listColumsClass = "col-6";
		break;
	case "3":
		$listColumsClass = "col-sm-4 col-6";
		break;
	case "4":
		$listColumsClass = "col-md-3 col-sm-4 col-6";
		break;
	case "6":
		$listColumsClass = "col-lg-2 col-md-3 col-sm-4 col-6";
		break;
	case "12":
		$listColumsClass = "col-lg-1 col-md-3 col-sm-4 col-6";
		break;
}

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>


        <div class="main-categories-list categories-list cards-list row">
            <? if ('Y' == $arParams['SHOW_PARENT_NAME'] && 0 < $arResult['SECTION']['ID'])
		{
			$this->AddEditAction($arResult['SECTION']['ID'], $arResult['SECTION']['EDIT_LINK'], $strSectionEdit);
			$this->AddDeleteAction($arResult['SECTION']['ID'], $arResult['SECTION']['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

			?>
            <h2 class="mb-3" id="<? echo $this->GetEditAreaId($arResult['SECTION']['ID']); ?>">
                <?
			echo (
			isset($arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]) && $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"] != ""
				? $arResult['SECTION']["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]
				: $arResult['SECTION']['NAME']
			);
			?>
            </h2>
            <?
		}

		if (0 < $arResult["SECTIONS_COUNT"])
		{
		?>
            <ul class="<? echo $arCurView['LIST']; ?>">
                <?

			switch ($arParams['VIEW_MODE'])
			{
				
				case 'TILE':
					foreach ($arResult['SECTIONS'] as &$arSection)
					{
						$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
						$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

						if (false === $arSection['PICTURE'])
							$arSection['PICTURE'] = array(
								'SRC' => $arCurView['EMPTY_IMG'],
								'ALT' => (
									'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
									? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
									: $arSection["NAME"]
								),
								'TITLE' => (
									'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
									? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
									: $arSection["NAME"]
								)
							);
							?>
                <div class="main-categories-item categories-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3"
                    id="<? echo $this->GetEditAreaId($arSection['ID']); ?>"
                    class="<?=$listColumsClass?> catalog-section-list-item">
                    <div class="categories-item__outer cards-item-outer">
                        <div class="categories-item__head cards-item-head">
                            <div class="categories-item__image cards-item-image">
                                <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                        data-src="<? echo $arSection['PICTURE']['SRC']; ?>"
                                        alt="<? echo $arSection['PICTURE']['TITLE']; ?>" class="lazyload" />
                                </a>
                            </div>
                        </div>
                        <? if ('Y' != $arParams['HIDE_SECTION_NAME'])
								{
									?>


                        <div class="categories-item__body cards-item-body">
                            <div class="categories-item__title cards-item-title">
                                <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>"
                                    class="categories-item__link cards-item-link">
                                    <? echo $arSection['NAME']; ?>
                                </a>
                            </div>
                        </div>

                        <?
								}
								?>
                    </div>
                </div>
                <?
					}
					unset($arSection);
					break;

				
			}
	
		}
		?>
        </div>
