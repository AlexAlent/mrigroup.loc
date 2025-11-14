<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) {
    die();
}

/**
 * @global CMain $APPLICATION
 */

$arFotoPageTemplateBaseDir = __DIR__ . '/pages';

$arfotoPageTemplate = $APPLICATION->GetProperty(MrigroupHelper::page_property_template);
if($arfotoPageTemplate && is_dir($arFotoPageTemplateBaseDir) . '/' . $arfotoPageTemplate) {
    $arFotoPageTemplateDir = $arFotoPageTemplateBaseDir . '/' . $arfotoPageTemplate;
} else {
    $arFotoPageTemplateDir = $arFotoPageTemplateBaseDir . '/default';
}

if(file_exists($arFotoPageTemplateDir) . '/header.php') {
    ob_start();

    include $arFotoPageTemplateDir . '/header.php';

    $APPLICATION->AddViewContent('arfoto_page_header', ob_get_clean());
}

if(file_exists($arFotoPageTemplateDir) . '/footer.php') {
    ob_start();

    include $arFotoPageTemplateDir . '/footer.php';

    $APPLICATION->AddViewContent('arfoto_page_footer', ob_get_clean());
}

$phone = MrigroupHelper::getCityPhone();

MrigroupHelper::setTitle($APPLICATION->GetProperty('title'));
MrigroupHelper::setDescription($APPLICATION->GetProperty('description'));
?>
<?php $APPLICATION->ShowViewContent('arfoto_page_footer');?>
<?php $APPLICATION->ShowViewContent('arfoto_page_footer_custom');?>

</div>

<?php
if($APPLICATION->GetProperty('arfoto_show_footer_advantages') == 'Y') {
    $APPLICATION->IncludeComponent(
        "parfyonov:variable.set",
        "main_advantages",
        array(
        ),
        false,
        array(
            'HIDE_ICONS' => 'Y'
        )
    );
}

if($APPLICATION->GetProperty('arfoto_show_footer_feedback') == 'Y') {
    $APPLICATION->IncludeComponent(
        "parfyonov:variable.set",
        "main_feedback",
        array(
        ),
        false,
        array(
            'HIDE_ICONS' => 'Y'
        )
    );
} ?>

<footer class="footer">
    <div class="container">
        <div class="footer-main">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-9">
                    						<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"bottom_menu", 
	array(
		"ROOT_MENU_TYPE" => "bottom",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"CACHE_SELECTED_ITEMS" => "N",
		"MAX_LEVEL" => "1",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "bottom_menu",
		"CHILD_MENU_TYPE" => "left"
	),
	false
);?>
                </div>

                <div class="col-12 col-sm-6 col-md-3">
                    <?php $APPLICATION->IncludeComponent(
                        "parfyonov:variable.set",
                        "footer_social",
                        array(
                        ),
                        false,
                        array(
                            'HIDE_ICONS' => 'Y'
                        )
                    );?>
					<ul class="footer-social social nav" style="margin-top:10px;">
						<li>
							<a class="call_form" style="cursor:pointer;background-color: #ffcb70;border-radius: 10px;color: #111;font-weight: 600;padding: 5px 10px; transition: background-color .3s;">Перезвонить</a>
						</li>
					</ul>
			   </div>
				
				

                <div class="col-12">
                    <ul class="footer-contacts nav">
                        <?php if($phone):?>
                            <li class="nav-item">
                                <a href="<?php echo MrigroupHelper::preparePhoneLink($phone);?>" class="nav-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M15.898 17a13.846 13.846 0 01-4.833-1.281 14.018 14.018 0 01-3.99-2.802 14.45 14.45 0 01-2.802-4 13.395 13.395 0 01-1.27-4.834.944.944 0 01.255-.76A.97.97 0 014.002 3h2.834c.236 0 .44.07.614.208a.984.984 0 01.344.563L8.294 6c.028.167.02.333-.021.5a.927.927 0 01-.25.438l-2.02 2.041a12.708 12.708 0 005 5l2.062-2a.906.906 0 01.454-.26 1.26 1.26 0 01.483-.01l2.23.479a.968.968 0 01.562.352.993.993 0 01.208.627V16c0 .375-.132.639-.396.792-.264.152-.5.222-.708.208zM5.315 7.52l1.458-1.457L6.416 4.5H4.544c.07.528.167 1.042.292 1.542.125.5.284.993.479 1.479zm7.166 7.168a9.87 9.87 0 001.491.47c.506.117 1.016.21 1.53.28v-1.876l-1.562-.333-1.459 1.459z"/></svg>
                                    <span><?php echo $phone;?></span>
                                </a>
                            </li>
                        <?php endif;?>
                        <?php if($email = MrigroupHelper::getCityEmail()):?>
                            <li class="nav-item">
                                <a href="mailto:<?php echo $email;?>" class="nav-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M3 7a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7zm2.56-.5L13 13.94l7.44-7.44H5.56zM9.94 13L4.5 7.56v10.88L9.94 13zm10.5 6.5L15 14.06l-2 2-2-2-5.44 5.44h14.88zM16.06 13l5.44-5.44v10.88L16.06 13z"/></svg>
                                    <span><?php echo $email;?></span>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-side">
            <div class="row">
                <div class="col">
                    <div class="copyright">
                        Copyright © 2025. Все права защищены.
                    </div>

                    <?php $APPLICATION->IncludeComponent(
	"parfyonov:variable.set", 
	"footer_policy", 
	array(
		"COMPONENT_TEMPLATE" => "footer_policy",
		"LINK" => "/politika-obrabotki-personalnykh-dannykh/",
		"TEXT" => "Политика обработки персональных данных"
	),
	false
);?>
                </div>

                <div class="col-12 col-lg-auto">
                    <div class="developer">
                        <span class="developer-text">
                            Создание сайта — Студия Парфенова
                        </span>
                        <a href="https://parfyonov.ru/" class="developer-link" target="_blank">
                            <span>a</span>.parfyonov
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?$APPLICATION->IncludeComponent(
        "bitrix:main.include",
        "",
        Array(
            "AREA_FILE_SHOW" => "file",
            "PATH" => SITE_DIR."include/cookie.php",
            "AREA_FILE_RECURSIVE" => "N",
            "EDIT_MODE" => "html",
        ),
        false,
        Array('HIDE_ICONS' => 'N')
    );?>
</footer>

    </div>

    <script src="<?php echo getFilePathQueryParamHash(SITE_TEMPLATE_PATH . '/js/vendors.js');?>"></script>
    <script src="<?php echo getFilePathQueryParamHash(SITE_TEMPLATE_PATH . '/js/main.js');?>"></script>
	
	
<script>
	$(function() {
		// вызываем форму
		$(document).on("click", ".call_form", function(e) {
			e.preventDefault();// отменяем переход по ссылке

			var this_ = $(this);
			if(this_.hasClass("disabled"))
				return false;
			this_.addClass("disabled");
			
			$.ajax({
				url: "/local/forms/form.php",
				type: "POST",
				data: {},
				success: function(data) {
					$("body").append(data);
					$(".modal_background").css({"display":"flex"});
					$(".modal_form").fadeIn();
				this_.removeClass("disabled");
				}
			});
		});

		// а это для закрытия формы
		$(document).on("click", ".close_form", function(e) {
			e.preventDefault();
			$(".modal_background").hide().remove();
		});
	});
</script>

<?php $APPLICATION->IncludeComponent(
    "parfyonov:variable.set",
    "body_end",
    [],
    false,
    [
        'HIDE_ICONS' => 'Y'
    ]
);?>

	<?
  if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates/tamograph/metrica.php')) {
	   include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/templates/tamograph/metrica.php');
  }
?>
</body>
</html>