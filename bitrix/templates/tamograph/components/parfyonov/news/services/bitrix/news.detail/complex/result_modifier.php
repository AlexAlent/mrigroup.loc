<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var array $arResult
 */

$sets = [];

if(isset($arResult['DISPLAY_PROPERTIES'])) {
    for($i = 1; $i <= 10; $i++) {
        if(!isset($arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_NAME'])) {
            continue;
        }

        $set = [
            'name' => $arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_NAME']['VALUE']
        ];

        if(isset($arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_PRICE'])) {
            $set['price'] = $arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_PRICE']['VALUE'];
        }

        if(isset($arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_DESCRIPTION'])) {
            $set['description'] = $arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_DESCRIPTION']['~VALUE']['TEXT'];
        }

        if(isset($arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_PRODUCTS'])) {
            $products = [];

            foreach($arResult['DISPLAY_PROPERTIES']['COMPLEX_SET_' . $i . '_PRODUCTS']['LINK_ELEMENT_VALUE'] as $arProduct) {
                $product = [
                    'id' => $arProduct['ID'],
                    'name' => $arProduct['NAME'],
                    'link' => $arProduct['DETAIL_PAGE_URL']
                ];

                $resPrice = \Bitrix\Catalog\Model\Price::getList([
                    'filter' => [
                        'PRODUCT_ID' => $arProduct['ID']
                    ]
                ]);

                if($arPrice = $resPrice->fetch()) {
                    $price = floatval($arPrice['PRICE']);
                } else {
                    $price = 0;
                }

                if($price > 0) {
                    $product['price'] = $price;
                }

                $products[] = $product;
            }

            if(count($products)) {
                $set['products'] = $products;
            }
        }

        $sets[] = $set;
    }
}

$arResult['SETS'] = $sets;