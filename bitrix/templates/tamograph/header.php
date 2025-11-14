<?php
use Bitrix\Main\Application;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CJSCore::Init(array("fx"));

$context = Application::getInstance()->getContext();

$city = MrigroupHelper::getCityName();
$phone = MrigroupHelper::getCityPhone();
CJSCore::Init(array("jquery"));
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>
        <?php $APPLICATION->ShowTitle()?>
    </title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="description" content="<?php echo MrigroupHelper::index_description;?>" />
    <meta property="og:title" content="<?php echo MrigroupHelper::index_title;?>" />
    <meta property="og:description" content="<?php echo MrigroupHelper::index_description;?>" />
    <meta property="og:image" content="https://<?php echo $context->getServer()->getHttpHost() . SITE_TEMPLATE_PATH;?>/img/ogimage.jpg" />
    <meta property="og:url" content="https://<?php echo $context->getServer()->getHttpHost() . $context->getRequest()->getRequestUri();?>" />
    <meta property="page_class" content="<?$APPLICATION->ShowProperty('page_class');?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/safari-pinned-tab.svg" color="#fbac4c" />
    <link rel="shortcut icon" href="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/favicon.ico" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-config" content="<?php echo SITE_TEMPLATE_PATH?>/data/img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <link rel="stylesheet" href="<?php echo getFilePathQueryParamHash(SITE_TEMPLATE_PATH . '/css/fancybox.css');?>" media="print"
        onload="this.onload=null;this.media='all'" />
    <link rel="stylesheet" href="<?php echo getFilePathQueryParamHash(SITE_TEMPLATE_PATH . '/css/main.css');?>" />
    <link rel="stylesheet" href="<?php echo getFilePathQueryParamHash(SITE_TEMPLATE_PATH . '/css/new-styles.css');?>" />

    <meta name="yandex-verification" content="36489983b4dd8437"/>
    <meta name="copyright" lang="ru" content="ТОМОГРАФ"/>
    <?php $APPLICATION->ShowHead(); ?>
    <?php $APPLICATION->IncludeComponent(
        "parfyonov:variable.set",
        "head_end",
        [],
        false,
        [
            'HIDE_ICONS' => 'Y'
        ]
    );?>
	<script src="//code.jivo.ru/widget/SyHGGWKLNH" async></script>
</head>
<?
$url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
if (strpos($url,'catalog') !== false) {
    $filter_open = true;
} 
?>
<body <?if (($filter_open == true) && ($_COOKIE['catalog-filter-opened'] == '1')) {?>class="catalog-filter-opened"<?} else {}?>>
<?php $APPLICATION->IncludeComponent(
    "parfyonov:variable.set",
    "body_start",
    [],
    false,
    [
        'HIDE_ICONS' => 'Y'
    ]
);?>
    <div id="panel">
        <?php $APPLICATION->ShowPanel(); ?>
    </div>
    <div class="root">
        <header class="header">
            <div class="topbar">
                <div class="container">
                    <div class="topbar-outer">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu", 
                            "left_top_menu", 
                            array(
                                "ROOT_MENU_TYPE" => "top",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_THEME" => "site",
                                "CACHE_SELECTED_ITEMS" => "N",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "2",
                                "CHILD_MENU_TYPE" => "left",
                                "USE_EXT" => "Y",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "left_top_menu"
                            ),
                            false
                        );?>
                        <div class="topbar-inner">
                            <a href="<?php echo MrigroupHelper::getModalLocationLink();?>" class="link-location link-modal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path
                                        d="M10.77 17l-2.103-5.667L3 9.23V8.5L17 3l-5.5 14h-.73zm.397-3.25l3.166-8.083L6.25 8.833l3.563 1.354 1.354 3.563z" />
                                </svg>
                                <span><?php echo $city;?></span>
                            </a>
                            <?php if($phone):?>
                                <ul class="topbar-contacts nav">
                                    <li class="nav-item">
                                        <a href="<?php echo MrigroupHelper::preparePhoneLink($phone);?>" class="nav-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                 viewBox="0 0 20 20">
                                                <path d="M15.898 17a13.846 13.846 0 01-4.833-1.281 14.018 14.018 0 01-3.99-2.802 14.45 14.45 0 01-2.802-4 13.395 13.395 0 01-1.27-4.834.944.944 0 01.255-.76A.97.97 0 014.002 3h2.834c.236 0 .44.07.614.208a.984.984 0 01.344.563L8.294 6c.028.167.02.333-.021.5a.927.927 0 01-.25.438l-2.02 2.041a12.708 12.708 0 005 5l2.062-2a.906.906 0 01.454-.26 1.26 1.26 0 01.483-.01l2.23.479a.968.968 0 01.562.352.993.993 0 01.208.627V16c0 .375-.132.639-.396.792-.264.152-.5.222-.708.208zM5.315 7.52l1.458-1.457L6.416 4.5H4.544c.07.528.167 1.042.292 1.542.125.5.284.993.479 1.479zm7.166 7.168a9.87 9.87 0 001.491.47c.506.117 1.016.21 1.53.28v-1.876l-1.562-.333-1.459 1.459z" />
                                            </svg>
                                            <span><?php echo $phone;?></span>
                                        </a>
                                    </li>
                                </ul>
                            <?php endif;?>
							<a class="call_form" style="cursor:pointer;background-color: #ffcb70;border-radius: 10px;color: #111;font-weight: 600;padding: 5px 10px; transition: background-color .3s;">Перезвонить</a>
                            <?php $APPLICATION->IncludeComponent(
                                "parfyonov:variable.set",
                                "header_social",
                                array(
                                ),
                                false,
                                array(
                                    'HIDE_ICONS' => 'Y'
                                )
                            );?>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="navbar">
                <div class="container">
                    <div class="navbar-outer">
                        <a href="/" class="navbar-logo">
                            <img src="<?php echo SITE_TEMPLATE_PATH?>/img/logo.svg" alt="" />
                        </a>
                        <div class="navbar-inner">

                            <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"horizontal_multilevel_top", 
	array(
		"ROOT_MENU_TYPE" => "topcat",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "36000000",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"CACHE_SELECTED_ITEMS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "2",
		"CHILD_MENU_TYPE" => "topcatdropdown",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"COMPONENT_TEMPLATE" => "horizontal_multilevel_top"
	),
	false
);?>
                            <?php if($phone):?>
                                <ul class="navbar-contacts nav">
                                    <li class="nav-item">
                                        <a href="<?php echo MrigroupHelper::preparePhoneLink($phone);?>" class="nav-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.317 4.168a.63.63 0 01.236.417l.65 3.505c.03.208.024.388-.01.544a.773.773 0 01-.22.39l-2.56 2.586.096.166a16.64 16.64 0 002.677 3.427 18.893 18.893 0 003.534 2.76l.168.102 2.489-2.488a1.15 1.15 0 01.485-.276c.206-.064.404-.08.596-.055l3.44.698c.182.04.324.125.437.256.11.13.165.276.165.45v4.05a.768.768 0 01-.227.573.768.768 0 01-.573.227c-2.111 0-4.171-.47-6.181-1.414a18.816 18.816 0 01-5.355-3.75 18.816 18.816 0 01-3.75-5.355C4.47 8.971 4 6.911 4 4.8c0-.238.077-.423.227-.573A.768.768 0 014.8 4h4.05a.71.71 0 01.467.168zM6.546 9.85l.146.336 2.002-2.002L8.21 5.5H5.493l.034.28c.084.692.202 1.375.354 2.05.154.683.375 1.356.665 2.02zm10.772 6.903l-2.03 2.03.337.146c.663.289 1.339.519 2.028.689.688.17 1.381.28 2.079.331l.268.02v-2.674l-2.682-.542z" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            <?php endif;?>
                            <button type="button" class="offcanvas-toggler btn btn-toggler" data-target="offcanvas">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M23 7.75H3v-1.5h20v1.5zm0 6H3v-1.5h20v1.5zm0 6H3v-1.5h20v1.5z" />
                                </svg>
                            </button>
                            <button type="button" class="searchbar-toggler btn btn-outline-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.981 17.042a7.5 7.5 0 111.06-1.06l5.224 5.223-1.06 1.06-5.224-5.223zm1.254-5.807a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            <?$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"header", 
	array(
		"SHOW_INPUT" => "Y",
		"INPUT_ID" => "title-search-input",
		"CONTAINER_ID" => "title-search",
		"PRICE_CODE" => array(
			0 => "BASE",
			1 => "RETAIL",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "150",
		"SHOW_PREVIEW" => "Y",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CONVERT_CURRENCY" => "Y",
		"CURRENCY_ID" => "RUB",
		"PAGE" => "#SITE_DIR#search/",
		"NUM_CATEGORIES" => "1",
		"TOP_COUNT" => "10",
		"ORDER" => "rank",
		"USE_LANGUAGE_GUESS" => "N",
		"CHECK_DATES" => "Y",
		"SHOW_OTHERS" => "N",
		"CATEGORY_0_TITLE" => "Каталог",
		"CATEGORY_0" => array(
			0 => "iblock_catalog",
		),
		"CATEGORY_0_iblock_news" => array(
			0 => "all",
		),
		"COMPONENT_TEMPLATE" => "header",
		"CATEGORY_0_iblock_catalog" => array(
			0 => "9",
		)
	),
	false
);?>
        </header>
        <div id="offcanvas" class="offcanvas">
            <div class="offcanvas-outer">
                <div class="offcanvas-head">
                    <?php if($phone):?>
                        <ul class="offcanvas-contacts nav">
                            <li class="nav-item">
                                <a href="<?php echo MrigroupHelper::preparePhoneLink($phone);?>" class="nav-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.317 4.168a.63.63 0 01.236.417l.65 3.505c.03.208.024.388-.01.544a.773.773 0 01-.22.39l-2.56 2.586.096.166a16.64 16.64 0 002.677 3.427 18.893 18.893 0 003.534 2.76l.168.102 2.489-2.488a1.15 1.15 0 01.485-.276c.206-.064.404-.08.596-.055l3.44.698c.182.04.324.125.437.256.11.13.165.276.165.45v4.05a.768.768 0 01-.227.573.768.768 0 01-.573.227c-2.111 0-4.171-.47-6.181-1.414a18.816 18.816 0 01-5.355-3.75 18.816 18.816 0 01-3.75-5.355C4.47 8.971 4 6.911 4 4.8c0-.238.077-.423.227-.573A.768.768 0 014.8 4h4.05a.71.71 0 01.467.168zM6.546 9.85l.146.336 2.002-2.002L8.21 5.5H5.493l.034.28c.084.692.202 1.375.354 2.05.154.683.375 1.356.665 2.02zm10.772 6.903l-2.03 2.03.337.146c.663.289 1.339.519 2.028.689.688.17 1.381.28 2.079.331l.268.02v-2.674l-2.682-.542z" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    <?php endif;?>
                    <button type="button" class="offcanvas-toggler btn btn-toggler" data-target="offcanvas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                            <path
                                d="M13 14.06l7.47 7.47 1.06-1.06L14.06 13l7.47-7.47-1.06-1.06L13 11.94 5.53 4.47 4.47 5.53 11.94 13l-7.47 7.47 1.06 1.06L13 14.06z" />
                        </svg>
                    </button>
                </div>
                <div class="offcanvas-body">
                    <form action="/search/" method="get" class="offcanvas-search" novalidate="novalidate" autocomplete="off">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M15.981 17.042a7.5 7.5 0 111.06-1.06l5.224 5.223-1.06 1.06-5.224-5.223zm1.254-5.807a6 6 0 11-12 0 6 6 0 0112 0z" />
                                </svg>
                            </div>
                            <input type="search" name="q" class="form-control" placeholder="Поиск"
                                required="required" />
                        </div>
                    </form>
                    <a href="<?php echo MrigroupHelper::getModalLocationLink();?>" class="link-location link-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                            <path
                                d="M10.77 17l-2.103-5.667L3 9.23V8.5L17 3l-5.5 14h-.73zm.397-3.25l3.166-8.083L6.25 8.833l3.563 1.354 1.354 3.563z" />
                        </svg>
                        <span><?php echo $city;?></span>
                    </a>
                    <?
                        $APPLICATION->IncludeComponent(
                            "bitrix:menu", 
                            "horizontal_multilevel_mobi_top", 
                            array(
                                "ROOT_MENU_TYPE" => "topcat",
                                "MENU_CACHE_TYPE" => "A",
                                "MENU_CACHE_TIME" => "36000000",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "MENU_THEME" => "site",
                                "CACHE_SELECTED_ITEMS" => "N",
                                "MENU_CACHE_GET_VARS" => array(
                                ),
                                "MAX_LEVEL" => "2",
                                "CHILD_MENU_TYPE" => "topcatdropdown",
                                "USE_EXT" => "N",
                                "DELAY" => "N",
                                "ALLOW_MULTI_SELECT" => "N",
                                "COMPONENT_TEMPLATE" => "horizontal_multilevel_mobi_top"
                            ),
                            false
                        );
                        ?>
                </div>
                <div class="offcanvas-foot">
                    <?php if($phone):?>
                        <ul class="offcanvas-contacts nav">
                            <li class="nav-item">
                                <a href="<?php echo MrigroupHelper::preparePhoneLink($phone);?>" class="nav-link"><span><?php echo $phone;?></span></a>
                            </li>
                        </ul>
                    <?php endif;?>
                    <?php $APPLICATION->IncludeComponent(
                        "parfyonov:variable.set",
                        "offcanvas_social",
                        array(
                        ),
                        false,
                        array(
                            'HIDE_ICONS' => 'Y'
                        )
                    );?>
                </div>
            </div>
        </div>
        <div class="content">
            <?php $APPLICATION->ShowViewContent('arfoto_page_header');?>