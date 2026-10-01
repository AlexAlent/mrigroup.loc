<?php

require_once(
    $_SERVER['DOCUMENT_ROOT']
    . '/bitrix/modules/main/include/prolog_before.php'
);

if (
    !empty($_POST['website_url'])
    || !empty($_POST['phone_field'])
    || !empty($_POST['email_field'])
) {
    die();
}
?>

<div class="modal_background">
    <div class="modal_form">
        <button
            type="button"
            class="close_form"
            aria-label="Закрыть форму"
            title="Закрыть форму"
        >
            &times;
        </button>

        <?php
        $APPLICATION->IncludeComponent(
            'my:main.feedback',
            '',
            [
                'EMAIL_TO' => 'info@mrigroup.ru',
                'EVENT_MESSAGE_ID' => ['7'],
                'OK_TEXT' => 'Спасибо, ваше сообщение принято.',

                'REQUIRED_FIELDS' => [
                    'NAME',
                    'user_phone',
                    'personal-data',
                    'privacy',
                ],

                'USE_CAPTCHA' => 'Y',

                'AJAX_MODE' => 'Y',
                'AJAX_OPTION_SHADOW' => 'N',
                'AJAX_OPTION_JUMP' => 'N',
                'AJAX_OPTION_STYLE' => 'Y',
                'AJAX_OPTION_HISTORY' => 'N',
            ]
        );
        ?>
    </div>
</div>

<style>
.modal_background {
    position: fixed;
    z-index: 9999;
    top: 0;
    left: 0;
    display: none;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-y: auto;
    background: rgba(0, 0, 0, 0.6);
}

.modal_form {
    position: relative;
    display: none;
    width: 500px;
    max-width: 100%;
    max-height: calc(100vh - 40px);
    padding: 48px 30px 40px;
    overflow-y: auto;
    background: #fff;
    border-radius: 8px;
}

button.close_form {
    position: absolute;
    z-index: 20;
    top: 8px;
    right: 10px;
    display: flex;
    width: 42px;
    height: 42px;
    align-items: center;
    justify-content: center;
    padding: 0;
    color: #555;
    background: transparent;
    border: 0;
    border-radius: 50%;
    cursor: pointer;
    font-family: Arial, sans-serif;
    font-size: 36px;
    font-weight: 300;
    line-height: 1;
}

button.close_form:hover {
    color: #111;
    background: rgba(0, 0, 0, 0.07);
}

.mfeedback input[type="text"],
.mfeedback input[type="tel"],
.mfeedback input[type="email"],
.mfeedback textarea {
    display: block;
    width: 100%;
    min-height: 50px;
    margin-bottom: 10px;
    padding: 11px 15px;
    color: #111;
    background-color: #fff;
    border: 1px solid #ececf0;
    border-radius: 12px;
    box-shadow: none;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.625;
    appearance: none;
}

.mfeedback textarea {
    min-height: 80px;
    resize: vertical;
}

.mfeedback input[type="submit"],
.mfeedback button[type="submit"] {
    margin-top: 10px;
    padding: 12px 32px;
    color: #111;
    background-color: #ffcb70;
    border-radius: 12px;
    font-weight: 600;
}

@media (max-width: 600px) {
    .modal_background {
        align-items: flex-start;
        padding: 10px;
    }

    .modal_form {
        max-height: calc(100vh - 20px);
        padding: 48px 20px 25px;
    }
}
</style>

<script>
if (
    window.jQuery
    && window.jQuery.fn
    && window.jQuery.fn.mask
) {
    window.jQuery('.mask-phone').mask(
        '9 (999) 999-99-99'
    );
}
</script>

<?php

require(
    $_SERVER['DOCUMENT_ROOT']
    . '/bitrix/modules/main/include/epilog_after.php'
);