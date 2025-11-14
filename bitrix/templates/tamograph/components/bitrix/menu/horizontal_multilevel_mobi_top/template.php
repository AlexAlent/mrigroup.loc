<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?if (!empty($arResult)): //id="horizontal-multilevel-menu"?>

	<ul class="offcanvas-nav nav">
<?

$previousLevel = 0;
    
   

foreach($arResult as $arItem):?>


	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>

		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>

	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>

			<?$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($url,'catalog') !== false) {
    $catclass = 'open';
} else {
   
}
?>

                <?if ($arItem["TEXT"] == 'Каталог'){?>
    <li class="nav-item dropdown <?if ($arItem["SELECTED"]):?>active<?endif?> <?echo $catclass?>">
                    <a href="javascript:;" class="nav-link dropdown-toggle">
                        <span><?=$arItem["TEXT"]?></span>
						<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.97 10.28l1.06-1.06L13 15.19l5.97-5.97 1.06 1.06L13 17.31l-7.03-7.03z"/></svg>
                    </a>
                
                <?}else{?>
        <li class="nav-item <?if ($arItem["SELECTED"]):?>active<?endif?>">
                <a href="<?=$arItem["LINK"]?>" class="nav-link">
                <span><?=$arItem["TEXT"]?></span></a>
                <?}?>
                

				<ul class="dropdown-menu">

		<?//elseif  ($arItem["DEPTH_LEVEL"] == 2):?>
		<?else:?>

			<li class="dropdown-item <?if ($arItem["SELECTED"]):?>active<?endif?>"><a class="dropdown-link" href="<?=$arItem["LINK"]?>"> <?=$arItem["TEXT"]?></a>

				<ul>
              
		<?endif?>



	<?else:?>



		<?if ($arItem["PERMISSION"] > "D"):?>



			<?if ($arItem["DEPTH_LEVEL"] == 1):?>

				<li class="nav-item <?if ($arItem["SELECTED"]):?>active<?endif?>"><a class="nav-link" href="<?=$arItem["LINK"]?>"> <?=$arItem["TEXT"]?></a>
                    </li>

			<?elseif (($arItem["DEPTH_LEVEL"] == 2)):?>

				<li class="dropdown-item <?if ($arItem["SELECTED"]):?>active<?endif?>"><a class="dropdown-link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>

			<?endif?>

		<?endif?>

	<?endif?>


	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
                   
        
<?endforeach?>



<?if ($previousLevel > 1)://close last item tags?>

	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>

<?endif?>



</ul>


<?endif?>