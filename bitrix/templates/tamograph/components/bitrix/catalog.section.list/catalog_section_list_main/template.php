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

if(!isset($arResult['SECTIONS_COUNT']) || $arResult['SECTIONS_COUNT'] <= 0) {
    return;
}

$sections = array_filter($arResult['SECTIONS'], function($section) {
    return isset($section['UF_MAIN']) && $section['UF_MAIN'];
});

if(!count($sections)) {
    return;
}

$arViewStyles = array(
	'TILE' => array(
		'TITLE' => 'catalog-section-list-item-title',
		'LIST' =>  'catalog-section-list-tile-list row mb-4',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
?>
<div class="container">
<h2 class="section-title">Каталог</h2>
    <div class="main-categories-list categories-list cards-list row">
        <?php foreach($sections as $arSection):
            $this->AddEditAction( $arSection[ 'ID' ], $arSection[ 'EDIT_LINK' ], $strSectionEdit );
            $this->AddDeleteAction( $arSection[ 'ID' ], $arSection[ 'DELETE_LINK' ], $strSectionDelete, $arSectionDeleteParams );

            if ( false === $arSection[ 'PICTURE' ]) {
                $arSection[ 'PICTURE' ] = array(
                    'SRC' => $arCurView[ 'EMPTY_IMG' ],
                    'ALT' => (
                    '' != $arSection[ "IPROPERTY_VALUES" ][ "SECTION_PICTURE_FILE_ALT" ] ?
                        $arSection[ "IPROPERTY_VALUES" ][ "SECTION_PICTURE_FILE_ALT" ] :
                        $arSection[ "NAME" ]
                    ),
                    'TITLE' => (
                    '' != $arSection[ "IPROPERTY_VALUES" ][ "SECTION_PICTURE_FILE_TITLE" ] ?
                        $arSection[ "IPROPERTY_VALUES" ][ "SECTION_PICTURE_FILE_TITLE" ] :
                        $arSection[ "NAME" ]
                    )
                );
            } ?>
            <div class="main-categories-item categories-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3"
                 id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
                <div class="categories-item__outer cards-item-outer">
                    <div class="categories-item__head cards-item-head">
                        <div class="categories-item__image cards-item-image">
                            <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?=$arSection['PICTURE']['SRC'];?>" alt="" class="lazyload" />
                            </a>
                        </div>
                    </div>
                    <div class="categories-item__body cards-item-body">
                        <div class="categories-item__title cards-item-title">
                            <a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" class="categories-item__link cards-item-link">
                                <? echo $arSection['NAME']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="section-footer">
        <a href="/catalog/" class="btn btn-outline-primary">
            <span>Все товары</span>
        </a>
    </div>
</div>
