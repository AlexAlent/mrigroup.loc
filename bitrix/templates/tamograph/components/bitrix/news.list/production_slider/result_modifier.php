<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$slider = [];

if(is_array($arResult) && isset($arResult['ITEMS'])) {
    $documentRoot = \Bitrix\Main\Application::getDocumentRoot();

    foreach($arResult['ITEMS'] as $item) {
        if(!isset($item['PREVIEW_PICTURE']) || !is_array($item['PREVIEW_PICTURE']) || !isset($item['PREVIEW_PICTURE']['SRC'])) {
            continue;
        }
        
        $src = $item['PREVIEW_PICTURE']['SRC'];
        if(!file_exists($documentRoot . $src)) {
            continue;
        }

        $preview = CFile::ResizeImageGet($item['PREVIEW_PICTURE']['ID'], ['width' => 'auto', 'height' => 324]);
        if(!$preview) {
            continue;
        }

        $slider[] = [
            'PREVIEW' => $preview['src'],
            'SRC' => $src,
            'CAPTION' => $item['NAME']
        ];
    }
}

$arResult['SLIDER'] = $slider;