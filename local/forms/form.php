<?
// подключение служебной части пролога
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");?>

<div class="modal_background">
	<div class="modal_form">
		<a href="#" class="close_form">Закрыть форму</a>
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
/*это затемнение экрана при вызове формы*/
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
/*это контейнер самой формы*/
.modal_form{
    background: #ffffff;
    border-radius: 2px;
    width: 500px;
    padding: 40px 30px;
    position: relative;
    display: none;
    max-width: 100%;
}
/*это кнопка для закрытия формы*/
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
// подключение визуальной части пролога
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php");?>