<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$items = [];

if(count($arResult['CATEGORIES'])) {
    foreach($arResult['CATEGORIES'][0]['ITEMS'] as $arItem) {
        $id = $arItem['ITEM_ID'];
        $title = $arItem['NAME'];

        $item = [
            'id' => $id,
            'link' => $arItem['URL'],
        ];

        if($id) {
            if($arResult['ELEMENTS'][$id]['PROPERTY_PRODUCTTYPE_VALUE']) {
                $title = '<span>' . $arResult['ELEMENTS'][$id]['PROPERTY_PRODUCTTYPE_VALUE'] . '</span> ' . $title;
            }

            if(isset($arResult['ELEMENTS'][$id]['IMAGE'])) {
                $item['image'] = $arResult['ELEMENTS'][$id]['IMAGE'];
            }
        }

        $item['title'] = $title;

        $items[] = $item;
    }
}

echo json_encode($items);