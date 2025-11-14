<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

if(!isset($arParams['TEXT']) || !trim($arParams['TEXT'])) {
    return;
}
?>
<div class="main-brands-text">
    <div class="row">
        <div class="col-12 col-md-10 col-lg-6">
            <div class="section-content">
                <p><?php echo $arParams['TEXT'];?></p>
            </div>
        </div>
    </div>
</div>