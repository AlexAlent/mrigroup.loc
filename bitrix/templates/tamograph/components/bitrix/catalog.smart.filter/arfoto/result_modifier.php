<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$component->SetResultCacheKeys([
    'SORT',
    'SORT_PARAMS'
]);

switch ($arParams['SECTION_ID']) {
    case 28:
    {
        /* МРТ */
        $properties = [
//            'BASE' => [],
            'BRAND' => [
                'NAME' => 'Производитель'
            ],
//            'COUNTRY' => [],
//            'CONDITION' => [],
//            'MAXPATWEIGHT' => [],
            'MAG_FIELD_STRENGHT' => [],
//            'DIAMETR' => [],
//            'CHANNELQUNTYTY' => [],
//            'TEHNNULVG' => [],
//            'SROKPOST' => []
        ];
        break;
    }
    case 34:
    {
        /* КТ */
        $properties = [
//            'BASE' => [],
            'BRAND' => [
                'NAME' => 'Производитель'
            ],
//            'COUNTRY' => [],
//            'DIAMETR' => [],
//            'MAXPATWEIGHT' => [],
//            'RAY_TUBE_MODEL' => [],
//            'HEAT_CAPACITY' => [],
//            'CONDITION' => [],
//            'TUBE_MILEAGE' => [],
            'NUMBER_SLICES' => [],
//            'SROKPOST' => []
        ];
        break;
    }
    case 70:
    {
        /* Рентген-оборудование */

        $properties = [
            'XRAY_TYPE' => [
                'NAME' => 'Тип'
            ]
        ];
        break;
    }
    case 42:
    {
        /* Узи */
        $properties = [
            'BRAND' => [
                'NAME' => 'Производитель'
            ],
//            'COUNTRY' => [],
//            'CONDITION' => [],
//            'TYPE_APP' => [
//                'NAME' => 'Тип системы'
//            ],
//            'CLASS_APP' => [
//                'NAME' => 'Класс системы'
//            ],
//            'AREAS_OF_USE' => [],
//            'SROKPOST' => []
            'ULTRASOUND_TYPE' => [
                'NAME' => 'Тип'
            ]
        ];
        break;
    }
    case 85:
    {
        /* Мобильные комплексы */
        $properties = [
            'MOBILE_TYPE' => [
                'NAME' => 'Тип'
            ]
        ];
    }
    case 53:
    {
        /* Сопутствующие товары */
        $properties = [
            'ACCESSORIES_TYPE' => [
                'NAME' => 'Тип'
            ]
        ];
        break;
    }
    case 54:
    {
        /* Запасные части */
        $properties = [
            'PARTS_TYPE' => [
                'NAME' => 'Тип'
            ]
        ];
        break;
    }
    default:
    {
        $properties = [
            'BASE' => [],
            'BRAND' => [
                'NAME' => 'Производитель'
            ],
            'COUNTRY' => [],
            'SROKPOST' => []
        ];
        break;
    }
}

$sectionFields = [];

$items = $arResult['ITEMS'];
if (is_array($items) && count($arResult['ITEMS'])) {
    if (count($properties)) {
        $propertiesIndex = array_keys($properties);
        $sectionFields = array_filter($items, function ($item) use ($propertiesIndex) {
            return in_array($item['CODE'], $propertiesIndex);
        });

        foreach ($sectionFields as $i => $field) {
            $code = $field['CODE'];

            $field['ORDER'] = array_search($code, $propertiesIndex);
            if (isset($properties[$field['CODE']]['NAME'])) {
                $field['NAME'] = $properties[$code]['NAME'];
            }

            $sectionFields[$i] = $field;
        }

        usort($sectionFields, function ($a, $b) {
            return $a['ORDER'] <=> $b['ORDER'];
        });
    } else {
        $sectionFields = array_values($items);
    }
}

$arResult['SECTION_FIELDS'] = $sectionFields;
