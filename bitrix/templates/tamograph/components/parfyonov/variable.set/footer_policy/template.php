<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$link = isset($arParams['LINK']) ? trim($arParams['LINK']) : '';
$text = isset($arParams['TEXT']) ? trim($arParams['TEXT']) : '';

if(!$link || !$text) {
    return;
}
?>
<ul class="nav">
    <li class="nav-item">
        <a href="<?php echo $arParams['LINK'];?>" class="nav-link" target="_blank">
            <span><?php echo $arParams['TEXT'];?></span>
        </a>
    </li>
</ul>