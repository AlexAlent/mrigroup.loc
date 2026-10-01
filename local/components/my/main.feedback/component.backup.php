<?php
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
 
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
 
$arResult["PARAMS_HASH"] = md5(serialize($arParams).$this->GetTemplateName());
 
$arParams["USE_CAPTCHA"] = (($arParams["USE_CAPTCHA"] != "N" && !$USER->IsAuthorized()) ? "Y" : "N");
$arParams["EVENT_NAME"] = trim($arParams["EVENT_NAME"]);
if($arParams["EVENT_NAME"] == '')
    $arParams["EVENT_NAME"] = "FEEDBACK_FORM";
$arParams["EMAIL_TO"] = trim($arParams["EMAIL_TO"]);
if($arParams["EMAIL_TO"] == '')
    $arParams["EMAIL_TO"] = COption::GetOptionString("main", "email_from");
$arParams["OK_TEXT"] = trim($arParams["OK_TEXT"]);
if($arParams["OK_TEXT"] == '')
    $arParams["OK_TEXT"] = GetMessage("MF_OK_MESSAGE");
 
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] <> '' && (!isset($_POST["PARAMS_HASH"]) || $arResult["PARAMS_HASH"] === $_POST["PARAMS_HASH"]))
{
    $arResult["ERROR_MESSAGE"] = array();
    if(check_bitrix_sessid())
    {
        if(empty($arParams["REQUIRED_FIELDS"]) || !in_array("NONE", $arParams["REQUIRED_FIELDS"]))
        {
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_name"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_NAME");       
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("EMAIL", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_EMAIL");
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["MESSAGE"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_REQ_MESSAGE");
                 
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("user_phone", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_phone"]) <= 3)
                $arResult["ERROR_MESSAGE"][] = 'Вы не заполнили телефон';

            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("privacy", $arParams["REQUIRED_FIELDS"])) && !($_POST["privacy"]))
                $arResult["ERROR_MESSAGE"][] = 'Вы не дали свое согласие на обработку персональных данных';

            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("personal-data", $arParams["REQUIRED_FIELDS"])) && !($_POST["personal-data"]))
                $arResult["ERROR_MESSAGE"][] = 'Вы не подтвердили, что ознакомлены с политикой обработки персональных данных';

            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("user_street", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_street"]) <= 10)
                $arResult["ERROR_MESSAGE"][] = 'Вы не заполнили улицу';
 
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("user_house", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = 'Вы не заполнили дом';
                 
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("user_porch", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = 'Вы не заполнили подъезд';
                 
            if((empty($arParams["REQUIRED_FIELDS"]) || in_array("user_apartment", $arParams["REQUIRED_FIELDS"])) && strlen($_POST["user_email"]) <= 1)
                $arResult["ERROR_MESSAGE"][] = 'Вы не заполнили квартиру';
 
        }
        if(strlen($_POST["user_email"]) > 1 && !check_email($_POST["user_email"]))
            $arResult["ERROR_MESSAGE"][] = GetMessage("MF_EMAIL_NOT_VALID");
        if($arParams["USE_CAPTCHA"] == "Y")
        {
            include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");
            $captcha_code = $_POST["captcha_sid"];
            $captcha_word = $_POST["captcha_word"];
            $cpt = new CCaptcha();
            $captchaPass = COption::GetOptionString("main", "captcha_password", "");
            if (strlen($captcha_word) > 0 && strlen($captcha_code) > 0)
            {
                if (!$cpt->CheckCodeCrypt($captcha_word, $captcha_code, $captchaPass))
                    $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTCHA_WRONG");
            }
            else
                $arResult["ERROR_MESSAGE"][] = GetMessage("MF_CAPTHCA_EMPTY");
 
        }           
        if(empty($arResult["ERROR_MESSAGE"]))
        {
            $arFields = Array(
                "AUTHOR" => $_POST["user_name"],
                "AUTHOR_EMAIL" => $_POST["user_email"],
                "user_phone" => $_POST["user_phone"],
                "user_street" => $_POST["user_street"],
                "user_house" => $_POST["user_house"],
                "user_porch" => $_POST["user_porch"],
                "user_apartment" => $_POST["user_apartment"],
                "EMAIL_TO" => $arParams["EMAIL_TO"],
                "TEXT" => $_POST["MESSAGE"],
            );
            if(!empty($arParams["EVENT_MESSAGE_ID"]))
            {
                foreach($arParams["EVENT_MESSAGE_ID"] as $v)
                    if(IntVal($v) > 0)
                        CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields, "N", IntVal($v));
            }
            else
                CEvent::Send($arParams["EVENT_NAME"], SITE_ID, $arFields);
 
            $_SESSION["MF_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
            $_SESSION["MF_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
            $_SESSION["MF_user_phone"] = htmlspecialcharsbx($_POST["user_phone"]);
            $_SESSION["MF_user_street"] = htmlspecialcharsbx($_POST["user_street"]);
            $_SESSION["MF_user_house"] = htmlspecialcharsbx($_POST["user_house"]);
            $_SESSION["MF_user_porch"] = htmlspecialcharsbx($_POST["user_porch"]);
            $_SESSION["MF_user_apartment"] = htmlspecialcharsbx($_POST["user_apartment"]);
 
            LocalRedirect($APPLICATION->GetCurPageParam("success=".$arResult["PARAMS_HASH"], Array("success")));
        }
         
        $arResult["MESSAGE"] = htmlspecialcharsbx($_POST["MESSAGE"]);
        $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_POST["user_name"]);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_POST["user_email"]);
        $arResult["user_phone"] = htmlspecialcharsbx($_POST["user_phone"]);
        $arResult["user_street"] = htmlspecialcharsbx($_POST["user_street"]);
        $arResult["user_house"] = htmlspecialcharsbx($_POST["user_house"]);
        $arResult["user_porch"] = htmlspecialcharsbx($_POST["user_porch"]);
        $arResult["user_apartment"] = htmlspecialcharsbx($_POST["user_apartment"]);
    }
    else
        $arResult["ERROR_MESSAGE"][] = GetMessage("MF_SESS_EXP");
}
elseif($_REQUEST["success"] == $arResult["PARAMS_HASH"])
{
    $arResult["OK_MESSAGE"] = $arParams["OK_TEXT"];
}
 
if(empty($arResult["ERROR_MESSAGE"]))
{
    if($USER->IsAuthorized())
    {
        $arResult["AUTHOR_NAME"] = $USER->GetFormattedName(false);
        $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($USER->GetEmail());
    }
    else
    {
        if(strlen($_SESSION["MF_NAME"]) > 0)
            $arResult["AUTHOR_NAME"] = htmlspecialcharsbx($_SESSION["MF_NAME"]);
        if(strlen($_SESSION["MF_EMAIL"]) > 0)
            $arResult["AUTHOR_EMAIL"] = htmlspecialcharsbx($_SESSION["MF_EMAIL"]);
             
        if(strlen($_SESSION["MF_user_phone"]) > 0)
            $arResult["user_phone"] = htmlspecialcharsbx($_SESSION["MF_user_phone"]);
 
        if(strlen($_SESSION["MF_user_street"]) > 0)
            $arResult["user_street"] = htmlspecialcharsbx($_SESSION["MF_user_street"]);
 
        if(strlen($_SESSION["MF_user_house"]) > 0)
            $arResult["user_house"] = htmlspecialcharsbx($_SESSION["MF_user_house"]);
 
        if(strlen($_SESSION["MF_user_porch"]) > 0)
            $arResult["user_porch"] = htmlspecialcharsbx($_SESSION["MF_user_porch"]);
 
        if(strlen($_SESSION["MF_user_apartment"]) > 0)
            $arResult["user_apartment"] = htmlspecialcharsbx($_SESSION["MF_user_apartment"]);
  
    }
}
 
if($arParams["USE_CAPTCHA"] == "Y")
    $arResult["capCode"] =  htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
 
$this->IncludeComponentTemplate();