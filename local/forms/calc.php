<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

use Bitrix\Main\Context;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');

$period = '';
$profit = '';
$error = '';

if(isset($_REQUEST['product_id']) && isset($_REQUEST['researches']) && isset($_REQUEST['workdays']) && isset($_REQUEST['research_price'])) {
    $resProduct = CIBlockElement::GetByID($_REQUEST['product_id']);
    $arProduct = $resProduct->Fetch();
    if(!is_array($arProduct) || $arProduct['IBLOCK_ID'] != 9) {
        $error = 'Не найден товар ' . $_REQUEST['product_id'];
    } else {
        $arPrice = \Bitrix\Catalog\PriceTable::getList([
            "select" => ["*"],
            "filter" => [
                "=PRODUCT_ID" => $arProduct['ID'],
            ],
            "order" => ["CATALOG_GROUP_ID" => "ASC"]
        ])->fetchAll();

        $price = is_array($arPrice) && isset($arPrice[0]) ? intval($arPrice[0]['PRICE']) : false;
        if($price) {
            $researches = intval($_REQUEST['researches']);
            $days = intval($_REQUEST['workdays']);
            $researchPrice = floatval($_REQUEST['research_price']);

            $payBackMonths = ceil($price / ($researches * $days * $researchPrice));
            $profit = $researches * $days * $researchPrice;

            if($payBackMonths > 12) {
                $years = intdiv($payBackMonths, 12);
                $months = $payBackMonths % 12;

                $period = $years . ' ' . getNumEnding($years, 'год', 'года', 'лет');
                if($months) {
                    $period .= ' ' . $months . ' ' . getNumEnding($months, 'месяц', 'месяца', 'месяцев');
                }
            } else {
                $period = $payBackMonths . ' ' . getNumEnding($payBackMonths, 'месяц', 'месяца', 'месяцев');
            }
        } else {
            $error = 'Для товара недоступен калькулятор';
        }
    }
} else {
    $error = 'Не переданы все обязательные параметры';
}?>
<div class="modal-outer">
    <?php if(!$error):?>
        <div class="modal-head">
            <div class="modal-overline">
                Расчет окупаемости
            </div>
            <div class="modal-name">
                <?php echo $arProduct['NAME'];?>
            </div>
        </div>
        <div class="modal-body">
            <div class="modal-text">
                Срок окупаемости при этих данных составит:
            </div>
            <div class="modal-title">
                <?php echo $period;?> <span>*</span>
            </div>
            <?php if($profit):?>
                <div class="modal-text">
                    После - прибыль <?php echo number_format($profit, 0, '', ' ');?> рублей в мес.
                </div>
            <?php endif;?>
            <div class="modal-button">
                <a href="<?php echo MrigroupHelper::getModalOfferLink($arProduct['ID'], [
                    'researches' => $researches,
                    'days' => $days,
                    'researchPrice' => $researchPrice,
                    'period' => $period
                ]);?>" class="btn btn-outline-primary link-modal">
                    <span>Запросить точный расчет</span>
                </a>
            </div>
        </div>
        <div class="modal-foot">
            <div class="modal-note">
                Расчеты произведены, исходя из среднестатистической стоимости данного оборудования с учетом введенных данных
            </div>
        </div>
    <?php else:?>
        <div class="modal-head">
            <div class="modal-overline">Произошла ошибка</div>
        </div>
        <div class="modal-body">
            <div class="modal-text"><?php echo $error;?></div>
        </div>
    <?php endif;?>
</div>