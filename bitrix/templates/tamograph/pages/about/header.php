<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

global $APPLICATION;

$h1 = trim($APPLICATION->GetPageProperty('arfoto_h1'));
?>
<div class="section">
    <div class="container">
        <?php $APPLICATION->IncludeComponent(
            "parfyonov:breadcrumb",
            ".default",
            Array(
                "PATH" => "",
                "SITE_ID" => "s1",
                "START_FROM" => "0",
            ),
            false,
            array(
                "HIDE_ICONS" => "Y"
            )
        );?>

        <?php if($h1):?>
            <h1><?php echo $h1;?></h1>
        <?php endif;?>

        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="section-content">