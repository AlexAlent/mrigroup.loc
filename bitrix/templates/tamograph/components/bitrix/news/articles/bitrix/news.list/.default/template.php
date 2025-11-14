<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php

/** @var array $arParams */
/** @var array $arResult */

if(!is_array($arResult) || !isset($arResult['ITEMS']) || !count($arResult['ITEMS'])) {
    return;
}
?>
<div class="articles-list cards-list row">
    <?php foreach($arResult["ITEMS"] as $arItem):
        $url = $arItem['DETAIL_PAGE_URL'];
        $name = $arItem['NAME'];
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
        <div class="articles-item cards-item col-12 col-sm-6 col-lg-4" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
            <div class="articles-item__outer cards-item-outer">
                <div class="articles-item__head cards-item-head">
                    <div class="articles-item__image cards-item-image">
                        <a href="<?php echo $url;?>">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?php echo htmlspecialchars($name);?>" class="lazyload" />
                        </a>
                    </div>
                </div>
                <div class="articles-item__body cards-item-body">
                    <div class="articles-item__title cards-item-title">
                        <a href="<?php echo $url;?>" class="articles-item__link cards-item-link"><?php echo $name;?></a>
                    </div>
                </div>
                <div class="articles-item__foot cards-item-foot">
                    <div class="articles-item__date">
                        <?php if(isset($arItem['ACTIVE_FROM'])):?>
                            <span><?php echo date('d/m/Y', strtotime($arItem['ACTIVE_FROM']));?></span>
                        <?php endif;?>
                    </div>

                    <div class="articles-item__time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path d="M14 7.25H6v-1.5h8v1.5zm-8 3.5h5v-1.5H6v1.5z" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M4.5 2a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2V4a2 2 0 00-2-2h-11zm11 1.5h-11A.5.5 0 004 4v12a.5.5 0 00.5.5h11a.5.5 0 00.5-.5V4a.5.5 0 00-.5-.5z" />
                        </svg>
                        <span><?php echo calculateReadingTime($arItem['DETAIL_TEXT'])?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>

<?php echo $arResult["NAV_STRING"]?>