<?php

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

if (isset($arResult['ITEM']) && isset($arResult['ITEM']['PROPERTIES']) && isset($arResult['ITEM']['PROPERTIES']['BADGE']) && $arResult['ITEM']['PROPERTIES']['BADGE']['VALUE']) {
    CModule::IncludeModule('highloadblock');

    $entityClass = HL\HighloadBlockTable::compileEntity(HL\HighloadBlockTable::getById(8)->fetch())->getDataClass();

    $res = $entityClass::getList(array(
        'select' => array('*'),
        'filter' => array('UF_XML_ID' => $arResult['ITEM']['PROPERTIES']['BADGE']['VALUE'])
    ));

    $arResult['ITEM']['PROPERTIES']['BADGE']['~VALUE'] = $res->fetch();
}

$gallery = [];

$listPhotoValue = isset($arResult['ITEM']['PROPERTIES']['LIST_PHOTO']) ? $arResult['ITEM']['PROPERTIES']['LIST_PHOTO']['VALUE'] : [];

if(is_array($listPhotoValue) && count($listPhotoValue)) {
    foreach($listPhotoValue as $fileId) {
        $resFile = CFile::GetByID($fileId);
        if(!$resFile instanceof CDBResult) {
            continue;
        }

        $arFile = $resFile->Fetch();
        if(!$arFile) {
            continue;
        }

        $gallery[] = $arFile['SRC'];
    }
}

if(!count($gallery)) {
    $morePhotoValue = isset($arResult['ITEM']['PROPERTIES']['MORE_PHOTO']) ? $arResult['ITEM']['PROPERTIES']['MORE_PHOTO']['VALUE'] : [];

    if(is_array($morePhotoValue) && count($morePhotoValue)) {
        foreach($morePhotoValue as $fileId) {
            $resFile = CFile::GetByID($fileId);
            if(!$resFile instanceof CDBResult) {
                continue;
            }

            $arFile = $resFile->Fetch();
            if(!$arFile) {
                continue;
            }

            $gallery[] = $arFile;
        }
    }
    
    if(!count($gallery) && isset($arResult['ITEM']['PREVIEW_PICTURE']['SRC'])) {
        $gallery[] = $arResult['ITEM']['PREVIEW_PICTURE'];

        if(isset($arResult['ITEM']['DETAIL_PICTURE']['SRC'])) {
            $gallery[] = $arResult['ITEM']['DETAIL_PICTURE'];
        }
    }

    if(count($gallery)) {
        $gallery = array_map(function($photo) {
            $thumb = CFile::ResizeImageGet($photo, ['width' => 'auto', 'height' => 245], BX_RESIZE_IMAGE_PROPORTIONAL);
            return $thumb['src'];
        }, $gallery);
    }   
}

$arResult['ITEM']['GALLERY'] = $gallery;

if(!isset($arParams['HIDE_ICONS'])) {
    switch($arResult['ITEM']['IBLOCK_SECTION_ID']) {
        case MrigroupHelper::mrt_section_id: {
            $iconsParams['CONDITION'] = [
                'ICON' => 'icon-condition.svg',
                'TITLE' => 'Состояние'
            ];
            $iconsParams['MAG_FIELD_STRENGHT'] = [
                'ICON' => 'icon-intensity.svg',
                'TITLE' => 'Напряженность'
            ];
            $iconsParams['DIAMETR'] = [
                'ICON' => 'icon-diameter.svg',
                'TITLE' => 'Диаметр туннеля'
            ];
            break;
        }
        case MrigroupHelper::kt_section_id: {
            $iconsParams['CONDITION'] = [
                'ICON' => 'icon-condition.svg',
                'TITLE' => 'Состояние'
            ];
            $iconsParams['NUMBER_SLICES'] = [
                'ICON' => 'icon-number-of-slices.svg',
                'TITLE' => 'Количество срезов'
            ];
            $iconsParams['DIAMETR'] = [
                'ICON' => 'icon-diameter.svg',
                'TITLE' => 'Диаметр туннеля'
            ];
            break;
        }
        case MrigroupHelper::uzi_section_id: {
            $iconsParams['CONDITION'] = [
                'ICON' => 'icon-condition.svg',
                'TITLE' => 'Состояние'
            ];
            $iconsParams['TYPE_APP'] = [
                'ICON' => 'icon-type.svg',
                'TITLE' => 'Тип системы'
            ];
            $iconsParams['CLASS_APP'] = [
                'ICON' => 'icon-class.svg',
                'TITLE' => 'Класс системы'
            ];
            break;
        }
        default: {
            $iconsParams = [];
        }
    }
}

$icons = [];

foreach($iconsParams as $property => $icon) {
    if(!isset($arResult['ITEM']['PROPERTIES'][$property]['VALUE']) || !$arResult['ITEM']['PROPERTIES'][$property]['VALUE']) {
        continue;
    }

    $icon['VALUE'] = $arResult['ITEM']['PROPERTIES'][$property]['VALUE'];
    $icons[] = $icon;
}

if(isset($arResult['ITEM']['PROPERTIES']['PRODUCTTYPE']) && $arResult['ITEM']['PROPERTIES']['PRODUCTTYPE']['VALUE']) {
    $productType = $arResult['ITEM']['PROPERTIES']['PRODUCTTYPE']['VALUE'];
} elseif(isset($arResult['ITEM']['PROPERTIES']['XRAY_TYPE']) && $arResult['ITEM']['PROPERTIES']['XRAY_TYPE']['VALUE']) {
    $productType = $arResult['ITEM']['PROPERTIES']['XRAY_TYPE']['VALUE'][0];
} elseif(isset($arResult['ITEM']['PROPERTIES']['ULTRASOUND_TYPE']) && $arResult['ITEM']['PROPERTIES']['ULTRASOUND_TYPE']['VALUE']) {
    $productType = $arResult['ITEM']['PROPERTIES']['ULTRASOUND_TYPE']['VALUE'];
} elseif(isset($arResult['ITEM']['PROPERTIES']['MOBILE_TYPE']) && $arResult['ITEM']['PROPERTIES']['MOBILE_TYPE']['VALUE']) {
    $productType = $arResult['ITEM']['PROPERTIES']['MOBILE_TYPE']['VALUE'];
} elseif(isset($arResult['ITEM']['PROPERTIES']['ACCESSORIES_TYPE']) && $arResult['ITEM']['PROPERTIES']['ACCESSORIES_TYPE']['VALUE']) {
    $productType = $arResult['ITEM']['PROPERTIES']['ACCESSORIES_TYPE']['VALUE'];
} elseif(isset($arResult['ITEM']['PROPERTIES']['PARTS_TYPE']) && $arResult['ITEM']['PROPERTIES']['PARTS_TYPE']['VALUE']) {
    $productType = $arResult['ITEM']['PROPERTIES']['PARTS_TYPE']['VALUE'];
} else {
    $productType = null;
}

$arResult['PRODUCT_TYPE'] = $productType;
$arResult['ICONS'] = $icons;