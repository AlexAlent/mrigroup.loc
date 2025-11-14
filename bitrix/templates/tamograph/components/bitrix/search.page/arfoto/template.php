<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
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
/** @var CSearch $arResult['NAV_RESULT'] */
/** @var CBitrixComponent $component */

$navResult = isset($arResult['NAV_RESULT']) && $arResult['NAV_RESULT'] instanceof CSearch ? $arResult['NAV_RESULT'] : null;

$total = $navResult instanceof CSearch ? $navResult->SelectedRowsCount() : 0;

if($total > 0):
    $offset = $navResult->NavPageSize * ($navResult->NavPageNomer - 1)?>
    <div class="section-header">
        <div class="search-total">
            Найдено страниц: <?php echo $total;?>
        </div>
    </div>

    <div class="search-list row">
        <?php foreach($arResult['SEARCH'] as $i => $arItem):?>
            <div class="search-item col-12 col-lg-9">
                <div class="search-item__outer">
                    <div class="search-item__number"><?php echo $offset + $i + 1;?></div>
                    <div class="search-item__title">
                        <a href="<?php echo $arItem['URL'];?>" class="search-item__link"><?php echo $arItem['TITLE'];?></a>
                    </div>
                    <div class="search-item__text">
                        <p><?php echo $arItem['BODY_FORMATED'];?></p>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php else:?>
    <div class="section-header">
        <div class="search-total">
            По вашему запросу ничего не найдено
        </div>
    </div>
<?php endif;?>

<?php echo $arResult['NAV_STRING'];?>