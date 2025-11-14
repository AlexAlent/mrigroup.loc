<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die(); ?>
<?php
$title = isset($arParams['TITLE']) ? trim($arParams['~TITLE']) : '';
$linkHref = isset($arParams['LINK_HREF']) ? trim($arParams['LINK_HREF']) : '';

$list = [];
if(isset($arParams['LIST']) && is_array($arParams['LIST']) && count($arParams['LIST'])) {
    $list = array_filter($arParams['LIST'], function($row) {
        return (bool)trim($row);
    });
}
?>
<div class="product-section d-none d-lg-block">
    <div class="product-poster">
        <div class="product-poster__outer">
            <div class="product-poster__body">
                <?php if($title):?>
                    <div class="product-poster__title"><?php echo $title;?></div>
                <?php endif;?>
                <?php if(count($list)):?>
                    <div class="product-poster__text">
                        <ul class="list">
                            <?php foreach($list as $row):?>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                        <path
                                                d="M8.99 13.586l5.58-5.581-1.06-1.06-4.52 4.52-2.5-2.5-1.06 1.06 3.56 3.56z" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M18.203 10a8.203 8.203 0 11-16.406 0 8.203 8.203 0 0116.406 0zm-1.5 0a6.703 6.703 0 11-13.405 0 6.703 6.703 0 0113.405 0z" />
                                    </svg>
                                    <?php echo $row;?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php endif;?>
            </div>
            <?php if($linkHref):?>
                <div class="product-poster__side">
                    <a href="<?php echo $linkHref;?>" class="product-poster__link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.015 20.03l-1.06-1.06 5.97-5.97-5.97-5.97 1.06-1.06 7.03 7.03-7.03 7.03z"/></svg>
                    </a>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>