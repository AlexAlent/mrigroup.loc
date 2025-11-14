<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="projects-list cards-list row"> 
    

            <?foreach($arResult["ITEMS"] as $arItem):?>
         
<? if($USER->IsAdmin()) {echo '<pre>'; print_r($arItem); echo '</pre>';}; ?>
    <div class="projects-item cards-item col-12 col-sm-6 col-lg-4">
        <div class="projects-item__outer cards-item-outer">
            <div class="projects-item__image cards-item-image"> <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
            data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["NAME"]?>" class="lazyload" /> </div>
            <div class="projects-item__inner">
                <div class="projects-item__body cards-item-body">
                    <div class="projects-item__name cards-item-title"> 
                        <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="projects-item__link cards-item-link"><?=$arItem["NAME"]?></a> 
                    </div>
                </div>
                <div class="projects-item__foot cards-item-foot">
                    <div class="projects-item__info"> <?=$arItem["PREVIEW_TEXT"]?> </div>
                </div>
            </div>
        </div>
    </div>
       <?endforeach;?>
</div>
<?endif?>

