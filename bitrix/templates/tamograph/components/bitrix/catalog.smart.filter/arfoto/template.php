<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if(!isset($arResult['SECTION_FIELDS']) || !is_array($arResult['SECTION_FIELDS']) || !count($arResult['SECTION_FIELDS'])) {
    return;
}
?>
<div class="catalog-filter">
    <form action="<?php echo $arResult["FORM_ACTION"]?>" method="get" name="<?php echo $arResult["FILTER_NAME"]."_form"?>" class="catalog-filter-form" autocomplete="off">
        <?php foreach($arResult["HIDDEN"] as $field):
            if($field['CONTROL_NAME'] == 'sort') {
                continue;
            }?>
            <input type="hidden" name="<?php echo $field["CONTROL_NAME"]?>" id="<?php echo $field["CONTROL_ID"]?>" value="<?php echo $field["HTML_VALUE"]?>" />
        <?php endforeach;?>

        <div class="catalog-filter-head">
            <button type="button" class="catalog-filter-toggler btn btn-toggler">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path d="M13 14.06l7.47 7.47 1.06-1.06L14.06 13l7.47-7.47-1.06-1.06L13 11.94 5.53 4.47 4.47 5.53 11.94 13l-7.47 7.47 1.06 1.06L13 14.06z"/></svg>
            </button>
        </div>

        <div class="catalog-filter-body">
            <div class="catalog-filter-list">
                <?php if(isset($arParams['SORT']) && isset($arParams['SORT_PARAMS'])):?>
                    <div class="catalog-filter-item">
                        <a href="#collapse-sort" role="button" class="catalog-filter-toggle" data-toggle="collapse"
                           aria-expanded="true">
                            <span>Сортировка</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.97 10.28l1.06-1.06L13 15.19l5.97-5.97 1.06 1.06L13 17.31l-7.03-7.03z"/></svg>
                        </a>
                        <div id="collapse-sort" class="catalog-filter-collapse collapse show">
                            <div class="list-group">
                                <?php foreach($arParams['SORT_PARAMS'] as $name => $row):?>
                                    <div class="list-group-item">
                                        <div class="form-radio">
                                            <label class="form-radio-label">
                                                <input type="radio" name="sort" value="<?php echo $name;?>" onchange="smartFilter.submit(this);"<?php if($arParams['SORT'] == $name):?> checked<?php endif;?> />
                                                <span class="form-radio-icon"></span>
                                                <span class="form-radio-text"><?php echo $row['text'];?></span>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>

                <?php foreach($arResult['SECTION_FIELDS'] as $field):
                    if(!isset($field['PROPERTY_TYPE'])) {
                        continue;
                    }

                    if($field['PROPERTY_TYPE'] == 'L' || $field['PROPERTY_TYPE'] == 'E' || $field['PROPERTY_TYPE'] == 'S'):
                        if(!isset($field['VALUES']) || !is_array($field['VALUES']) || !count($field['VALUES'])) {
                            continue;
                        }

                        $values = $field['VALUES'];
                        usort($values, function($a, $b) {
                            return is_numeric($a['VALUE']) && is_numeric($b['VALUE']) ? $b <=> $a : strcmp($a['VALUE'], $b['VALUE']);
                        });
                        ?>
                        <div class="catalog-filter-item">
                            <a href="#collapse-<?php echo $field['ID'];?>" role="button" class="catalog-filter-toggle" data-toggle="collapse"
                               aria-expanded="true">
                                <span><?php echo $field['NAME'];?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.97 10.28l1.06-1.06L13 15.19l5.97-5.97 1.06 1.06L13 17.31l-7.03-7.03z"/></svg>
                            </a>
                            <div id="collapse-<?php echo $field['ID'];?>" class="catalog-filter-collapse collapse show">
                                <div class="list-group">
                                    <?php foreach($values as $value):?>
                                        <div class="list-group-item">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox"
                                                           name="<?php echo $value['CONTROL_NAME'];?>"
                                                           id="<?php echo $value['CONTROL_ID'];?>"
                                                           value="<?php echo $value['HTML_VALUE'];?>"
                                                           onclick="smartFilter.click(this)"
                                                            <?php if($value['DISABLED']):?> disabled<?php endif;?>
                                                            <?php if($value['CHECKED']):?> checked<?php endif;?>
                                                    />
                                                    <span class="form-check-icon"></span>
                                                    <span class="form-check-text"><?php echo $value['VALUE'];?></span>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach;?>
                                </div>
                            </div>
                        </div>
                    <?php elseif(($field['PROPERTY_TYPE'] == 'N' || $field['CODE'] == 'BASE') && ($field['VALUES']['MAX']['VALUE'] - $field['VALUES']['MIN']['VALUE'] > 0)):
                        $min = $field['VALUES']['MIN']['VALUE'];
                        $max = $field['VALUES']['MAX']['VALUE'];
                        $from = $field['VALUES']['MIN']['HTML_VALUE'] ?: $min;
                        $to = $field['VALUES']['MAX']['HTML_VALUE'] ?: $max;
                        ?>
                        <div class="catalog-filter-item">
                            <a href="#collapse-<?php echo $field['ID'];?>" role="button" class="catalog-filter-toggle" data-toggle="collapse"
                               aria-expanded="true">
                                <span><?php echo $field['NAME'];?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.97 10.28l1.06-1.06L13 15.19l5.97-5.97 1.06 1.06L13 17.31l-7.03-7.03z"/></svg>
                            </a>
                            <div id="collapse-<?php echo $field['ID'];?>" class="catalog-filter-collapse collapse show">
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <div class="form-range double-range">
                                            <input type="text"
                                                   name="<?php echo $field['VALUES']['MIN']['CONTROL_NAME'];?>"
                                                   id="<?php echo $field['VALUES']['MIN']['CONTROL_ID'];?>"
                                                   value="<?php echo $from != $min ? $from : '';?>"
                                                   data-extremum="<?php echo $min;?>"
                                                   onchange="smartFilter.change(this)"
                                                   class="form-range-input input-from form-control" />
                                            <input type="text"
                                                   name="<?php echo $field['VALUES']['MAX']['CONTROL_NAME'];?>"
                                                   id="<?php echo $field['VALUES']['MAX']['CONTROL_ID'];?>"
                                                   value="<?php echo $to != $max ? $to : '';?>"
                                                   data-extremum="<?php echo $max;?>"
                                                   onchange="smartFilter.change(this)"
                                                   class="form-range-input input-to form-control" />
                                            <div class="form-range-slider input-slider"
                                                 data-min="<?php echo $min;?>" data-max="<?php echo $max;?>"
                                                 data-start="<?php echo $from;?>" data-end="<?php echo $to;?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>

        <div class="catalog-filter-foot">
            <button type="submit" class="btn btn-primary" id="set_filter" name="set_filter"><?php $APPLICATION->ShowViewContent('filter_submit_text');?></button>
            <button type="submit" class="btn btn-secondary" id="del_filter" name="del_filter">Очистить</button>
        </div>
    </form>
</div>
<script>
    var smartFilter = new arfotoSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>');
</script>