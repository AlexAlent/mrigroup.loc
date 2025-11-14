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
?>
<div class="section-header">
    <div class="article-date">
        <?php if(isset($arResult['ACTIVE_FROM'])):?>
            <span><?php echo date('d/m/Y', strtotime($arResult['ACTIVE_FROM']));?></span>
        <?php endif;?>
    </div>
    <div class="article-time">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M14 7.25H6v-1.5h8v1.5zm-8 3.5h5v-1.5H6v1.5z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 2a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2V4a2 2 0 00-2-2h-11zm11 1.5h-11A.5.5 0 004 4v12a.5.5 0 00.5.5h11a.5.5 0 00.5-.5V4a.5.5 0 00-.5-.5z"/></svg>
        <span><?php echo calculateReadingTime($arResult['DETAIL_TEXT']);?></span>
    </div>
</div>

<?php if(isset($arResult['DETAIL_PICTURE']) && $arResult['DETAIL_PICTURE']['SRC']):?>
    <figure class="section-image">
        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="" class="lazyload" />
    </figure>
<?php endif;?>

<div class="row">
    <div class="col-12 col-lg-9">
        <div class="section-content">
            <?php echo $arResult['DETAIL_TEXT'];?>
        </div>
    </div>
</div>

<div class="section-footer">
    <div class="share">
        <div class="share-title">Поделиться</div>
        <div class="ya-share2" data-services="telegram,vkontakte,odnoklassniki"></div>
    </div>
</div>

<div class="section-footer">
    <ul class="section-nav nav">
        <li class="nav-item nav-prev<?php if(!isset($arResult['PREV_LINK'])):?> disabled<?php endif;?>">
            <a<?php if(isset($arResult['PREV_LINK'])):?> href="<?php echo $arResult['PREV_LINK'];?>"<?php else:?> tabindex="-1" aria-disabled="true"<?php endif;?> class="nav-link" aria-label="Предыдущая статья">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.985 20.03l1.06-1.06-5.97-5.97 5.97-5.97-1.06-1.06L8.955 13l7.03 7.03z" />
                </svg>
                <span><?php echo $arParams['PREV_LINK_TITLE'] ?? 'Предыдущая новость';?></span>
            </a>
        </li>
        <?php if(isset($arResult['LIST_PAGE_URL'])):?>
            <li class="nav-item">
                <a href="<?php echo $arResult['LIST_PAGE_URL'];?>" class="nav-link">
                    <span><?php echo $arParams['ALL_LINK_TITLE'] ?? 'Все новости';?></span>
                </a>
            </li>
        <?php endif;?>
        <li class="nav-item nav-next<?php if(!isset($arResult['NEXT_LINK'])):?> disabled<?php endif;?>">
            <a<?php if(isset($arResult['NEXT_LINK'])):?> href="<?php echo $arResult['NEXT_LINK'];?>"<?php else:?> tabindex="-1" aria-disabled="true"<?php endif;?> class="nav-link" aria-label="Следующая статья">
                <span><?php echo $arParams['NEXT_LINK_TITLE'] ?? 'Следующая новость';?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.015 20.03l-1.06-1.06 5.97-5.97-5.97-5.97 1.06-1.06 7.03 7.03-7.03 7.03z" />
                </svg>
            </a>
        </li>
    </ul>
</div>