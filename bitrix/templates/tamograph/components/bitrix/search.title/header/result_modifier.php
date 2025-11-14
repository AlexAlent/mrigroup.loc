<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arElementId = [];

foreach($arResult["CATEGORIES"] as $category_id => $arCategory)
{
	foreach($arCategory["ITEMS"] as $i => $arItem)
	{
		if(isset($arItem["ITEM_ID"]))
		{
            $arElementId[] = $arItem['ITEM_ID'];
		}
	}
}

$arElements = [];

if (!empty($arElementId) && CModule::IncludeModule("iblock"))
{
	$arSelect = array(
		"ID",
		"IBLOCK_ID",
        "IBLOCK_SECTION_ID",
		"PREVIEW_PICTURE",
        "PROPERTY_MORE_PHOTO",
        'PROPERTY_PRODUCTTYPE',
	);
	$arFilter = array(
		"IBLOCK_LID" => SITE_ID,
        "=ID" => $arElementId
	);
	$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
	while($arElement = $rsElements->Fetch())
	{
        if($arElement['PROPERTY_MORE_PHOTO_VALUE']) {
            $fileId = is_array($arElement['PROPERTY_MORE_PHOTO_VALUE']) ? $arElement['PROPERTY_MORE_PHOTO_VALUE'][0] : $arElement['PROPERTY_MORE_PHOTO_VALUE'];
        } elseif($arElement['PREVIEW_PICTURE']) {
            $fileId = $arElement['PREVIEW_PICTURE'];
        } else {
            $fileId = false;
        }

        if($fileId) {
            $resFile = CFile::GetByID($fileId);
            if($arFile = $resFile->Fetch()) {
                $thumb = CFile::ResizeImageGet($arFile, ['width' => 52, 'height' => 'auto'], BX_RESIZE_IMAGE_PROPORTIONAL);
                if($thumb) {
                    $arElement['IMAGE'] = $thumb['src'];
                }
            }
        }

        $arElements[$arElement['ID']] = $arElement;
	}
}

$arResult['ELEMENTS'] = $arElements;