<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$link = isset($arParams['LINK']) ? trim($arParams['LINK']) : '';
$image = isset($arParams['IMAGE']) ? trim($arParams['IMAGE']) : '';

if(!$link || !$image) {
    return;
}
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">
                <a href="<?php echo $link;?>" class="link-video" data-fancybox="video">
                    <span class="link-video__poster">
                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                             data-src="<?php echo $image;?>" alt="" class="lazyload" />
                    </span>
                    <span class="link-video__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path d="M8.286 22.286V3.715l13 9.286-13 9.285z"/></svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>