<?php

/**
 * Created by Evgenii Ioffe
 * @author Evgenii Ioffe <ioffe@umispec.ru>
 * @copyright Copyright (c) 2023, Evgenii Ioffe
 */

global $APPLICATION;

$h1 = trim($APPLICATION->GetPageProperty('arfoto_h1'));

$data = MrigroupHelper::getCityData();
$address = $data['PROPERTY_REGION_ADDRESS_VALUE'] ?? '';
$phone = MrigroupHelper::getCityPhone();
$phoneHelpdesk = $data['PROPERTY_REGION_PHONE_HELPDESK_VALUE'] ?? '';
$email = MrigroupHelper::getCityEmail();
?>
<div class="section contacts">
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

        <div class="section-header">
            <a href="<?php echo MrigroupHelper::getModalLocationLink();?>" class="link-location link-modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M10.77 17l-2.103-5.667L3 9.23V8.5L17 3l-5.5 14h-.73zm.397-3.25l3.166-8.083L6.25 8.833l3.563 1.354 1.354 3.563z"/></svg>
                <span><?php echo MrigroupHelper::getCityName();?></span>
            </a>
        </div>

        <div class="contacts-list row">
            <?php if($address):?>
                <div class="contacts-item col-12 col-md-6">
                    <div class="contacts-item__title">Адрес</div>
                    <div class="contacts-item__value"><?php echo $address;?></div>
                </div>
            <?php endif;?>
            <?php if($phone):?>
                <div class="contacts-item col-12 col-md-6">
                    <div class="contacts-item__title">Телефон</div>
                    <div class="contacts-item__value">
                        <a href="<?php echo MrigroupHelper::preparePhoneLink($phone);?>"><?php echo $phone;?></a>
                    </div>
                </div>
            <?php endif;?>
            <?php if($email):?>
                <div class="contacts-item col-12 col-md-6">
                    <div class="contacts-item__title">E-mail</div>
                    <div class="contacts-item__value">
                        <a href="mailto:<?php echo $email;?>"><?php echo $email;?></a>
                    </div>
                </div>
            <?php endif;?>
            <?php if($phoneHelpdesk):?>
                <div class="contacts-item col-12 col-md-6">
                    <div class="contacts-item__title">Справочная служба</div>
                    <div class="contacts-item__value">
                        <a href="<?php echo MrigroupHelper::preparePhoneLink($phoneHelpdesk);?>"><?php echo $phoneHelpdesk;?></a>
                    </div>
                </div>
            <?php endif;?>
        </div>
