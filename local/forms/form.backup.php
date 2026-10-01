<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

// === ЗАЩИТА ОТ БОТОВ: ПРОВЕРКА ПРЯМО ЗДЕСЬ ===
if (!empty($_POST['website_url']) || !empty($_POST['phone_field']) || !empty($_POST['email_field'])) {
    // Бот — показываем пустую страницу, ничего не отправляем
    die();
}
// === КОНЕЦ ЗАЩИТЫ ===
?>

<div class="modal_background">
	<div class="modal_form">
		<a href="#" class="close_form">Закрыть форму</a>
		
		<!-- HONEYPOT ЗАЩИТА -->
		<div style="position:absolute!important; left:-9999px!important; top:-9999px!important; opacity:0!important; visibility:hidden!important; height:0!important; overflow:hidden!important; pointer-events:none!important;">
			<label>Website: <input type="text" name="website_url" value="" tabindex="-1" autocomplete="off"></label>
			<label>Phone: <input type="text" name="phone_field" value="" tabindex="-1" autocomplete="off"></label>
			<label>Email: <input type="text" name="email_field" value="" tabindex="-1" autocomplete="off"></label>
		</div>
		<!-- КОНЕЦ HONEYPOT -->
		
		<?$APPLICATION->IncludeComponent(
			"my:main.feedback",
			"",
			Array(
				"EMAIL_TO" => "info@mrigroup.ru",
				"EVENT_MESSAGE_ID" => array("7"),
				"OK_TEXT" => "Спасибо, ваше сообщение принято.",
				"REQUIRED_FIELDS" => array("NAME", "user_phone", "personal-data", "privacy"),
				"USE_CAPTCHA" => "N",
				"AJAX_MODE" => "Y",
				"AJAX_OPTION_SHADOW" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
			)
		);?>
	</div>
</div>
<style>
.modal_background{
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(0,0,0,0.6);
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.modal_form{
    background: #ffffff;
    border-radius: 2px;
    width: 500px;
    padding: 40px 30px;
    position: relative;
    display: none;
    max-width: 100%;
}
a.close_form{
    position: absolute;
    right: 30px;
    top: 30px;
    z-index: 5;
	color: #676767;
}
.mfeedback input[type=text], .mfeedback input[type=tel], .mfeedback textarea{
	appearance: none;
    background-clip: padding-box;
    background-color: #fff;
    border: 1px solid #ececf0;
    border-radius: 12px;
    box-shadow: none;
    color: #111;
    display: block;
    font-size: 1rem;
    font-weight: 400;
    height: 50px;
    line-height: 1.625;
    padding: 11px 15px;
    width: 100%;
	margin-bottom:10px;
}
.mfeedback input[type=submit]{
    background-color: #ffcb70;
    border-radius: 12px;
    color: #111;
    font-weight: 600;
    padding: 12px 32px;
    transition: background-color .3s;
	margin-top:10px;
}
</style>
<script>
$('.mask-phone').mask('9 (999) 999-99-99');
</script>
<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");?>