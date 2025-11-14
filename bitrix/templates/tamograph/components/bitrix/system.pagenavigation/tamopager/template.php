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

$current = intval($arResult['NavPageNomer']);
$last = intval($arResult['NavPageCount']);
$number = intval($arResult['NavNum']);
$size = intval($arResult['NavPageSize']);
$urlPathParams = $arResult['sUrlPathParams'];

$nav2Page = false;
$nav2Dot = false;

if($last >= 2) {
    if($last > 7 && $current > 4) {
        $nav2Page = $current - 2;
        $nav2Dot = true;
    } else {
        $nav2Page = 2;
    }
}

$nav4Page = false;
if($last >= 4) {
    if($last < 7 || $current < 5) {
        $nav4Page = 4;
    } elseif($current <= $last - 4) {
        $nav4Page = $current;
    } else {
        $nav4Page = $last - 3;
    }
}

$nav3Page = false;
if($last >= 3) {
    if($last > 3 && $current > 4) {
        $nav3Page = $nav4Page - 1;
    } else {
        $nav3Page = 3;
    }
}

$nav5Page = false;
if($last >= 5) {
    $nav5Page = $nav4Page + 1;
}

$nav6Page = false;
$nav6Dot = false;
if($last >= 6) {
    if($last > 7) {
        if($last - $current > 3) {
            $nav6Page = $current + 1;
            $nav6Dot = true;
        } else {
            $nav6Page = $last - 1;
        }
    } else {
        $nav6Page = 6;
    }
}

$nav7Page = false;
if($last >= 7) {
    $nav7Page = $last;
}
?>
<nav aria-label="pagination">
    <ul class="pagination">
        <li class="pagination-item<?php if($current == 1):?> disabled<?php endif;?>">
            <a class="pagination-link" tabindex="-1" aria-disabled="true" aria-label="Предыдущая"<?php if($current > 1):?> href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . ($current - 1) . '&SIZEN_' . $number . '=' . $size; ?>"<?php endif;?>>
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M15.985 20.03l1.06-1.06-5.97-5.97 5.97-5.97-1.06-1.06L8.955 13l7.03 7.03z"/></svg>
            </a>
        </li>
        <li class="pagination-item<?php if($current == 1):?> active<?php endif;?>">
            <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=1' . '&SIZEN_' . $number . '=' . $size; ?>" class="pagination-link">1</a>
        </li>
        <?php if($nav2Page):?>
            <li class="pagination-item<?php if($current == $nav2Page):?> active<?php endif;?>">
                <?php if($nav2Dot):?>
                    <a class="pagination-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path d="M15.5 13a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    </a>
                <?php else:?>
                    <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . $nav2Page . '&SIZEN_' . $number . '=' . $size; ?>" class="pagination-link"><?php echo $nav2Page;?></a>
                <?php endif;?>
            </li>
        <?php endif;?>
        <?php if($nav3Page):?>
            <li class="pagination-item<?php if($current == $nav3Page):?> active<?php endif;?>">
                <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . $nav3Page . '&SIZEN_' . $number . '=' . $size; ?>" class="pagination-link"><?php echo $nav3Page;?></a>
            </li>
        <?php endif;?>
        <?php if($nav4Page):?>
            <li class="pagination-item<?php if($current == $nav4Page):?> active<?php endif;?>">
                <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . $nav4Page . '&SIZEN_' . $number . '=' . $size; ?>" class="pagination-link"><?php echo $nav4Page;?></a>
            </li>
        <?php endif;?>
        <?php if($nav5Page):?>
            <li class="pagination-item<?php if($current == $nav5Page):?> active<?php endif;?>">
                <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . $nav5Page . '&SIZEN_' . $number . '=' . $size;?>" class="pagination-link"><?php echo $nav5Page?></a>
            </li>
        <?php endif;?>
        <?php if($nav6Page):?>
            <li class="pagination-item<?php if($current == $nav6Page):?> active<?php endif;?>">
                <?php if($nav6Dot):?>
                    <a class="pagination-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path d="M15.5 13a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                    </a>
                <?php else:?>
                    <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . $nav6Page . '&SIZEN_' . $number . '=' . $size; ?>" class="pagination-link"><?php echo $nav6Page;?></a>
                <?php endif;?>
            </li>
        <?php endif;?>
        <?php if($nav7Page):?>
            <li class="pagination-item<?php if($current == $nav7Page):?> active<?php endif;?>">
                <a href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . $nav7Page . '&SIZEN_' . $number . '=' . $size;?>" class="pagination-link"><?php echo $nav7Page?></a>
            </li>
        <?php endif;?>
        <li class="pagination-item<?php if($current == $last):?> disabled<?php endif;?>">
            <a<?php if($current < $last):?> href="<?php echo $urlPathParams . 'PAGEN_' . $number . '=' . ($current + 1) . '&SIZEN_' . $number . '=' . $size;?>"<?php endif;?> class="pagination-link" aria-label="Следующая">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.015 20.03l-1.06-1.06 5.97-5.97-5.97-5.97 1.06-1.06 7.03 7.03-7.03 7.03z"/></svg>
            </a>
        </li>
    </ul>
</nav>