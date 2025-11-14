<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @var array $arParams
 * @var array $arResult
 * @global CMain $APPLICATION
 */

$prevUrl = getPrevElementUrl($arResult['IBLOCK_ID'], $arResult['ID'], $arParams);
if($prevUrl) {
    $arResult['PREV_LINK'] = $prevUrl;
}

$nextUrl = getNextElementUrl($arResult['IBLOCK_ID'], $arResult['ID'], $arParams);
if($nextUrl) {
    $arResult['NEXT_LINK'] = $nextUrl;
}

if(isset($arResult['PROPERTIES']) && is_array($arResult['PROPERTIES'])) {
    if(isset($arResult['PROPERTIES']['MORE_PICTURE']) && $arResult['PROPERTIES']['MORE_PICTURE']['VALUE']) {
        $morePictureValue = is_array($arResult['PROPERTIES']['MORE_PICTURE']['VALUE']) ? $arResult['PROPERTIES']['MORE_PICTURE']['VALUE'] : [$arResult['PROPERTIES']['MORE_PICTURE']['VALUE']];

        $slider = [];

        foreach($morePictureValue as $i => $fileId) {
            $resFile = CFile::GetByID($fileId);
            $arFile = $resFile->Fetch();
            if(!$arFile) {
                continue;
            }

            $slider[] = [
                'src' => $arFile['SRC'],
                'description' => $arResult["PROPERTIES"]["MORE_PICTURE"]["DESCRIPTION"][$i] ?? ''
            ];
        }

        if(count($slider)) {
            $arResult['SLIDER'] = $slider;
        }
    }
}