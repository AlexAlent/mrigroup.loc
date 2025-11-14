<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?if (!empty($arResult)): //id="horizontal-multilevel-menu"?>

<ul class="navbar-nav nav"> 



<?

$previousLevel = 0;
    
   

foreach($arResult as $arItem):?>



	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>

		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>

	<?endif?>



	<?if ($arItem["IS_PARENT"]):?>



		<?if ($arItem["DEPTH_LEVEL"] == 1):?>

			
               
                <?if ($arItem["TEXT"] == 'Каталог'){?>
    <li class="nav-item dropdown <?if ($arItem["SELECTED"]):?>active<?endif?>">
                    <a href="javascript:;" class="nav-link dropdown-toggle" data-toggle="dropdown"
                                aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path d="M5 8.75h2.5v-1.5H5v1.5zm4 0h12v-1.5H9v1.5zm12 5H9v-1.5h12v1.5zm-16 0h2.5v-1.5H5v1.5zm16 5H9v-1.5h12v1.5zm-16 0h2.5v-1.5H5v1.5z"/></svg>
                        <span><?=$arItem["TEXT"]?></span>
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