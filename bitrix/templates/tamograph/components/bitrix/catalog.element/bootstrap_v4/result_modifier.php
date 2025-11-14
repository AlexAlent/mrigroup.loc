<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock as HL;

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if(isset($arResult['PROPERTIES']['ALSO']) && $arResult['PROPERTIES']['ALSO']['VALUE']) {
    $arResult['ALSO'] = $arResult['PROPERTIES']['ALSO']['VALUE'];
}

if(isset($arResult['PROPERTIES']['SIMILAR']) && $arResult['PROPERTIES']['SIMILAR']['VALUE']) {
    $arResult['SIMILAR'] = $arResult['PROPERTIES']['SIMILAR']['VALUE'];
}

$component->SetResultCacheKeys([
    'ALSO',
    'SIMILAR'
]);

if (isset($arResult['PROPERTIES']['BADGE']) && $arResult['PROPERTIES']['BADGE']['VALUE']) {
    CModule::IncludeModule('highloadblock');

    $entityClass = HL\HighloadBlockTable::compileEntity(HL\HighloadBlockTable::getById(8)->fetch())->getDataClass();

    $res = $entityClass::getList(array(
        'select' => array('*'),
        'filter' => array('UF_XML_ID' => $arResult['PROPERTIES']['BADGE']['VALUE'])
    ));

    $arResult['PROPERTIES']['BADGE']['~VALUE'] = $res->fetch();
}

$anonsPropertiesParams = [
    'CML2_ARTICLE' => 'Артикул',
    'GODVYPUSK' => 'Год выпуска',
    'WARRANTY' => 'Гарантия',
    'SROKPOST' => 'Срок поставки'
];

$anonsProperties = [];

foreach($anonsPropertiesParams as $property => $title) {
    if(!isset($arResult['DISPLAY_PROPERTIES'][$property]) || !$arResult['DISPLAY_PROPERTIES'][$property]['VALUE']) {
        continue;
    }

    $anonsProperties[] = [
        'TITLE' => $title,
        'VALUE' => $arResult['DISPLAY_PROPERTIES'][$property]['VALUE']
    ];
}

$arResult['ANONS_PROPERTIES'] = $anonsProperties;

$posterTemplate = '';

if(isset($arResult['SECTION']) && is_array($arResult['SECTION']) && isset($arResult['SECTION']['ID'])) {
    $arPosterTemplatesBySectionId = [
        MrigroupHelper::mrt_section_id => 'mrt',
        MrigroupHelper::kt_section_id => 'kt',
    ];

    if(isset($arPosterTemplatesBySectionId[$arResult['SECTION']['ID']])) {
        $posterTemplate = $arPosterTemplatesBySectionId[$arResult['SECTION']['ID']];
    }
}

$arResult['POSTER_TEMPLATE'] = $posterTemplate;