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
        <span>11/02/2023</span>
    </div>
    <div class="article-time">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M14 7.25H6v-1.5h8v1.5zm-8 3.5h5v-1.5H6v1.5z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M4.5 2a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2V4a2 2 0 00-2-2h-11zm11 1.5h-11A.5.5 0 004 4v12a.5.5 0 00.5.5h11a.5.5 0 00.5-.5V4a.5.5 0 00-.5-.5z"/></svg>
        <span><?php echo calculateReadingTime($arResult['DETAIL_TEXT']);?></span>
    </div>
</div>

<figure class="section-image">
    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
         data-src="/data/img/promos/image-01.jpg" alt="" class="lazyload" />
</figure>

<div class="row">
    <div class="col-12 col-lg-9">
        <div class="section-content">
            <p>Аппарат магнитно-резонансной томографии (МРТ) - это высокотехнологичное медицинское
                оборудование стоимостью в миллионы рублей. МР-томографы бывают нескольких видов.
                Во-первых, их различают по мощностной характеристике - по напряженности магнитного
                поля, которое измеряется в Теслах. Во-вторых, их принято классифицировать по
                конструкции: открытые, закрытые, вертикальные. В независимости от типа МРТ аппарата
                принцип сканирующего процесса остается неизменным, однако функциональные возможности
                томографов отличаются.</p>

            <h2>Принцип работы аппарата МРТ</h2>

            <p>Высокая информативность выгодно отличает МРТ исследование от других методов
                диагностики, таких как простая рентгенография или УЗИ. Рентген обычно делают для
                получения снимков твердых тканей, таких как кости. Процедура основана на
                использовании рентгеновских лучей, которые проходят сквозь человеческое тело и
                оставляют следы на фотопленке, которую потом можно транслировать через мониторы. МРТ
                работает по другому принципу. При магнитно-резонансном сканировании используется
                специальным образом сконфигурированное магнитное поле. Оно основано на использовании
                атомов водорода. Как известно, человек на 80% состоит из воды, а молекула воды
                формируется из двух атомов водорода. Водород в виде протонов - это элемент, процент
                которого в человеческом теле максимален. Радиоволна томографа возбуждает протоны,
                они резонируют и порождают сигналы. Эти импульсы улавливает и оцифровывает компьютер
                томографа, после чего они преобразуются в изображение. Различные ткани производят
                различные сигналы, которые дифференцируются МРТ аппаратом. Если ткань имеет
                повреждение, ее излучение визуально отличается от нормального. Соответственно на
                снимках ткани с патологией будут отличаться от окружающей ее здоровой.</p>
        </div>
    </div>
</div>

<div class="section-footer">
    <div class="share">
        <div class="share-title">
            Поделиться
        </div>
        <div class="ya-share2" data-services="telegram,vkontakte,odnoklassniki"></div>
    </div>
</div>

<div class="section-footer">
    {% include "section-nav.html" %}
</div>

<div class="section-header">
    <div class="article-date">
        <span><?=strtolower(FormatDate("d/m/Y", MakeTimeStamp($arResult["DATE_CREATE"])));?></span>
    </div>
    <div class="article-time">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
            <path d="M14 7.25H6v-1.5h8v1.5zm-8 3.5h5v-1.5H6v1.5z" />
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M4.5 2a2 2 0 00-2 2v12a2 2 0 002 2h11a2 2 0 002-2V4a2 2 0 00-2-2h-11zm11 1.5h-11A.5.5 0 004 4v12a.5.5 0 00.5.5h11a.5.5 0 00.5-.5V4a.5.5 0 00-.5-.5z" />
        </svg>
        <span><?php echo calculateReadingTime($arResult['DETAIL_TEXT']);?></span>
    </div>
</div>
<?if ($arResult["DETAIL_PICTURE"]["SRC"]) {
?>
<figure class="section-image">
    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
        data-src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" alt="" class="lazyload" />
</figure>
<?}?>
<div class="row">
    <div class="col-12 col-lg-9">
        <div class="section-content">
            <?if($arResult["NAV_RESULT"]):?>
            <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br />
            <?endif;?>
            <?echo $arResult["NAV_TEXT"];?>
            <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?>
            <?endif;?>
            <?elseif($arResult["DETAIL_TEXT"] <> ''):?>
            <?echo $arResult["DETAIL_TEXT"];?>
            <?else:?>
            <?echo $arResult["PREVIEW_TEXT"];?>
            <?endif?>
        </div>
    </div>
</div>

<div class="section-footer">
    <div class="share">
        <div class="share-title">
            Поделиться
        </div>
        <div class="ya-share2" data-services="telegram,vkontakte,odnoklassniki"></div>
    </div>
</div>

<div class="section-footer">
    <ul class="section-nav nav">
        
            <?if (empty($arResult['PREV_POST']['DETAIL_PAGE_URL'])){?>
				<li class="nav-item nav-prev disabled">
			<a class="nav-link" tabindex="-1" aria-disabled="true" aria-label="Предыдущая статья">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M15.985 20.03l1.06-1.06-5.97-5.97 5.97-5.97-1.06-1.06L8.955 13l7.03 7.03z" />
                </svg>
                <span>Предыдущая новость</span>
            </a>
			</li>
				<?} else {?>
					<li class="nav-item nav-prev">
			<a href="<?=$arResult['PREV_POST']['DETAIL_PAGE_URL']?>" class="nav-link" aria-label="Предыдущая статья">
                <span>Предыдущая статья</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path fill-rule="evenodd" clip-rule="evenodd"
					d="M15.985 20.03l1.06-1.06-5.97-5.97 5.97-5.97-1.06-1.06L8.955 13l7.03 7.03z" />
                </svg>
            </a>
				</li>
			<?}?>

        <?php if(isset($arResult['LIST_PAGE_URL'])):?>
            <li class="nav-item">
                <a href="<?php echo $arResult['LIST_PAGE_URL'];?>" class="nav-link">
                    <span>Все статьи</span>
                </a>
            </li>
        <?php endif;?>

            <?if ($arResult['NEXT_POST']['DETAIL_PAGE_URL']){?>
				<li class="nav-item nav-next">
			<a href="<?=$arResult['NEXT_POST']['DETAIL_PAGE_URL']?>" class="nav-link" aria-label="Следующая статья">
                <span>Следующая статья</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10.015 20.03l-1.06-1.06 5.97-5.97-5.97-5.97 1.06-1.06 7.03 7.03-7.03 7.03z" />
                </svg>
            </a></li>
			<?} else {?>
				<li class="nav-item nav-next disabled">
			<a class="nav-link" tabindex="-1" aria-disabled="true" aria-label="Следующая статья">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                    <path fill-rule="evenodd" clip-rule="evenodd"
					d="M10.015 20.03l-1.06-1.06 5.97-5.97-5.97-5.97 1.06-1.06 7.03 7.03-7.03 7.03z" />
                </svg>
                <span>Следующая статья</span>
            </a></li>
			<?}?>
        
    </ul>
</div>