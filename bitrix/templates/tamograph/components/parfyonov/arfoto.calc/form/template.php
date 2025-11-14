<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die(); ?>
<?php
/*
 * @global CMain $APPLICATION
 * @var array $arParams
 */

if(!isset($arParams) || !is_array($arParams) || !isset($arParams['PRODUCT_ID'])) {
    return;
}
?>
<div class="product-section">
    <div class="calc" id="calc">
        <div class="calc__outer">
            <h2>Калькулятор окупаемости</h2>

            <form data-xhr-action="/local/forms/calc.php" method="GET" class="calc__form form" novalidate="novalidate" autocomplete="off">
                <input type="hidden" name="product_id" value="<?php echo $arParams['PRODUCT_ID'];?>" />
                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label>Среднее количество исследований в день</label>
                            <div class="form-range single-range">
                                <input type="hidden" name="researches" value="40"
                                       class="form-range-input" />
                                <div class="form-range-slider" data-min="1" data-max="80"
                                     data-start="40"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label>Количество рабочих дней в месяц</label>
                            <div class="form-range single-range">
                                <input type="hidden" name="workdays" value="15"
                                       class="form-range-input" />
                                <div class="form-range-slider" data-min="1" data-max="30"
                                     data-start="15"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="form-group">
                            <label>Средняя цена одного исследования</label>
                            <input type="text" name="research_price" class="form-control" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Рассчитать</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>