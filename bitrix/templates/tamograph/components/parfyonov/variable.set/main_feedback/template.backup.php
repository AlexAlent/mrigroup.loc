<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

$bannerImage = tplvar('main_feedback_banner_image');
$bannerLink = tplvar('main_feedback_banner_link');
?>
<div class="section main-feedback">
    <div class="container">
        <div class="row">
            <div class="col-12<?php if($bannerImage):?> col-xl-9<?php endif;?>">
                <div class="main-feedback__outer">
                    <h2 class="section-title">
                        Получить консультацию
                    </h2>

                    <form data-xhr-action="/local/forms/send.php" data-add-b24trace="true" method="POST" action="javascript:void(0);" class="main-feedback__form form" novalidate="novalidate" autocomplete="off">
                        <input type="hidden" name="type" value="consult" />
                        <input type="hidden" name="submit_time" value="<?php echo time(); ?>" />
                        <?php
global $APPLICATION;
$captchaCode = htmlspecialcharsbx($APPLICATION->CaptchaGetCode());
?>

<div class="form-group">
    <input type="hidden" name="captcha_sid" value="<?php echo $captchaCode; ?>">
    <img
        id="consult-captcha-img"
        src="/bitrix/tools/captcha.php?captcha_sid=<?php echo $captchaCode; ?>"
        width="180"
        height="40"
        alt="CAPTCHA"
    >

    <button
    type="button"
    id="consult-captcha-refresh"
    class="btn btn-outline-secondary btn-sm"
     style="position: relative; top: -15px; margin-left: -50px;">
    ↻ Обновить
    </button>

    <input type="text" name="captcha_word" class="form-control" placeholder="Введите код с картинки" required>
</div>

<input type="text" name="website_url" value="" style="display:none!important;" tabindex="-1" autocomplete="off" />
<input type="text" name="phone_field" value="" style="display:none!important;" tabindex="-1" autocomplete="off" />
<input type="text" name="email_field" value="" style="display:none!important;" tabindex="-1" autocomplete="off" />

                        <div class="row">
                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Имя" required />
                                </div>
                            </div>
                            <div class="col-12 col-xl-6">
                                <div class="form-group">
                                    <input type="tel" name="phone" class="form-control" placeholder="Телефон"
                                           required />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" placeholder="Ваш вопрос"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
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
                                            <input type="checkbox" name="personal-data" required>
                                            <span class="form-check-icon"></span>
                                            <span class="form-check-text"> Я даю свое <a href="/soglasie-na-obrabotku-personalnykh-dannykh/" target="_blank" rel="nofollow" class="consent-link">согласие на обработку персональных данных</a>.</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="privacy" required>
                                            <span class="form-check-icon"></span>

                                            <span class="form-check-text">Я подтверждаю, что ознакомлен с <a href="/politika-obrabotki-personalnykh-dannykh/" target="_blank" rel="nofollow" class="consent-link">политикой обработки персональных данных</a>.</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-auto">
                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </div>
                            <?php if($policyLink = tplvar(MrigroupHelper::tplvar_policy_link) && false):?>
                                <div class="col-12 col-md">
                                    <div class="form-text">
                                        Нажимая на кнопку, я соглашаюсь на обработку <a href="<?php echo $policyLink;?>" target="_blank">персональных данных</a>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                    </form>
<script>
document.getElementById('consult-captcha-refresh').addEventListener('click', function () {
    fetch('/local/forms/captcha.php')
        .then(function (response) {
            return response.json();
        })
        .then(function (data) {
            if (!data.sid) {
                return;
            }

            var img = document.getElementById('consult-captcha-img');
            var sidInput = document.querySelector('input[name="captcha_sid"]');
            var wordInput = document.querySelector('input[name="captcha_word"]');

            sidInput.value = data.sid;
            img.src = '/bitrix/tools/captcha.php?captcha_sid=' + data.sid + '&rand=' + Math.random();
            wordInput.value = '';
        });
});
</script>
                </div>
            </div>

            <?php if($bannerImage):?>
                <div class="col-12 col-xl-3 d-none d-xl-block">
                    <a<?php if($bannerLink):?> href="<?php echo $bannerLink;?>"<?php endif;?> class="main-feedback__banner">
                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $bannerImage;?>" alt="" class="lazyload" />
                    </a>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>