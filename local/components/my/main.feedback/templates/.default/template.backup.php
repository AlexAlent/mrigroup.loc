<?
if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();
/**
 * Bitrix vars
 *
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 * @global CMain $APPLICATION
 * @global CUser $USER
 */
$this->addExternalJS("/bitrix/templates/tamograph/js/mask.js");

?>
<script src="/bitrix/templates/tamograph/js/mask.js" type="text/javascript"></script>
<div class="mfeedback">
<?if(!empty($arResult["ERROR_MESSAGE"]))
{
	foreach($arResult["ERROR_MESSAGE"] as $v)
		ShowError($v);
}
if($arResult["OK_MESSAGE"] <> '')
{
	?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?








}
?>

<form id="get-call" action="<?=POST_FORM_ACTION_URI?>" method="POST">
<?=bitrix_sessid_post()?>
	<div class="mf-name">
		<div class="mf-text">
			<?=GetMessage("MFT_NAME")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("NAME", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<input type="text" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>">
	</div>
	
	<div class="so_mf mf-phone">
        <div class="mf-text">
            Ваш телефон<?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("user_phone", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
        </div>
        <input class="mask-phone" type="tel" name="user_phone" value="<?=$arResult["user_phone"]?>">
    </div>

	<div class="mf-message">
		<div class="mf-text">
			<?=GetMessage("MFT_MESSAGE")?><?if(empty($arParams["REQUIRED_FIELDS"]) || in_array("MESSAGE", $arParams["REQUIRED_FIELDS"])):?><span class="mf-req">*</span><?endif?>
		</div>
		<textarea name="MESSAGE" rows="5" cols="40"><?=$arResult["MESSAGE"]?></textarea>
	</div>

	<?if($arParams["USE_CAPTCHA"] == "Y"):?>
	<div class="mf-captcha">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA")?></div>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
		<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
		<div class="mf-text"><?=GetMessage("MFT_CAPTCHA_CODE")?><span class="mf-req">*</span></div>
		<input type="text" name="captcha_word" size="30" maxlength="50" value="">
	</div>
	<?endif;?>
	<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">

    <div class="consent-form">
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="advertising">
                <span class="form-check-icon"></span>
                <span class="form-check-text">Я даю свое <a href="/soglasie-na-poluchenie-reklamnoy-informatsii/" target="_blank" rel="nofollow" class="consent-link">согласие на получение рекламной информации</a>.</span>
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="personal-data">
                <span class="form-check-icon"></span>
                <span class="form-check-text"> Я даю свое <a href="/soglasie-na-obrabotku-personalnykh-dannykh/" target="_blank" rel="nofollow" class="consent-link">согласие на обработку персональных данных</a>.</span>
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label">
                <input type="checkbox" name="privacy">
                <span class="form-check-icon"></span>

                <span class="form-check-text">Я подтверждаю, что ознакомлен с <a href="/politika-obrabotki-personalnykh-dannykh/" target="_blank" rel="nofollow" class="consent-link">политикой обработки персональных данных</a>.</span>
            </label>
        </div>
    </div>

	<input type="submit" name="submit" value="<?=GetMessage("MFT_SUBMIT")?>">
</form>
</div>