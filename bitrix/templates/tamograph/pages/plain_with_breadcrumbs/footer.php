<?php
/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

/**
 * @global CMain $APPLICATION
 */

if($APPLICATION->GetProperty(MrigroupHelper::page_property_show_breadcrumbs)) {
    ob_start();
    $APPLICATION->IncludeComponent(
        "parfyonov:breadcrumb",
        ".default",
        array(
            "PATH" => "",
            "SITE_ID" => "s1",
            "START_FROM" => "0",
        ),
        false,
        array(
            "HIDE_ICONS" => "Y"
        )
    );
    $html = ob_get_clean();
    MrigroupHelper::setBreadcrumbsHtml($html);
}