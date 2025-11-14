<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(count($arResult["ITEMS"])>0):?>
<div class="main-brands-slider-wrap">
    <div class="main-brands-slider swiper">
        <?foreach($arResult["ITEMS"] as $arItem):?>
        <div class="main-brands-slider-item brands-item cards-item swiper-slide">
            <div class="brands-item__outer cards-item-outer">
                <div class="brands-item__head cards-item-head">
                    <div class="brands-item__image cards-item-image">  <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                    data-src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="" class="lazyload" />  </div>
                </div>
            </div>
        </div>
        <?endforeach;?>

    </div>
            <div class="swiper-navigation">
            <button class="swiper-button-prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.03L3.97 13 12 4.97l1.06 1.06-6.22 6.22h15.19v1.5H6.84l6.22 6.22L12 21.03z"/>
            </svg>
            </button>
            <button class="swiper-button-next">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 21.03L22.03 13 14 4.97l-1.06 1.06 6.22 6.22H3.97v1.5h15.19l-6.22 6.22L14 21.03z"/>
            </svg>
            </button>
        </div>
</div>
<?endif?>
