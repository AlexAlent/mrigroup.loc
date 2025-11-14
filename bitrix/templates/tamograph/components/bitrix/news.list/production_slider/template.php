<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if(!is_array($arResult) || !isset($arResult['SLIDER']) || !is_array($arResult['SLIDER'])) {
    return;
}
?>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="single-slider swiper">
                    <?php foreach($arResult['SLIDER'] as $slide):?>
                        <a href="<?php echo $slide['SRC'];?>" class="single-slider-item swiper-slide" data-fancybox="gallery">
                            <div class="single-slider-item__image">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                     data-src="<?php echo $slide['PREVIEW'];?>" alt="" class="lazyload" />
                            </div>
                            <div class="single-slider-item__caption"><?php echo $slide['CAPTION'];?></div>
                        </a>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>