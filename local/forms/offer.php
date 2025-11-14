<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$id = 0;
$name = '';
$set = '';

$arElement = MrigroupHelper::getModalOfferElementById(isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
if($arElement) {
    $id = $arElement['ID'];
    $name = $arElement['NAME'];

    if($arElement['IBLOCK_ID'] == 22 && isset($_REQUEST['set']) && trim($_REQUEST['set'])) {
        $set = trim($_REQUEST['set']);
        $name .= ' (Комплектация ' . $set . ')';
    }
}
?>
<div class="modal-outer">
    <?php if($name):?>
        <div class="modal-overline">Коммерческое предложение</div>
        <div class="modal-title"><?php echo $name;?></div>
        <form data-xhr-action="/local/forms/send.php" data-add-b24trace="true" method="POST" class="modal-form offer-form form" novalidate="novalidate" autocomplete="off">
            <input type="hidden" name="id" value="<?php echo $id;?>" />
            <input type="hidden" name="type" value="offer" />
            <?php if($set):?>
                <input type="hidden" name="set" value="<?php echo $set;?>" />
            <?php endif;?>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Имя" required />
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <input type="tel" name="phone" class="form-control mask-phone" placeholder="Телефон" required />
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <textarea name="message" class="form-control" placeholder="Ваш вопрос"></textarea>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Удобное время для звонка</label>
                        <div class="form-range double-range time-range">
                            <input type="text" name="time_from" value="10:00" class="form-range-input input-from form-control" />
                            <input type="text" name="time_to" value="20:00" class="form-range-input input-to form-control" />
                            <div class="form-range-slider input-slider" data-min="08:00" data-max="22:00" data-start="10:00"
                                 data-end="20:00" data-step="30"></div>
                        </div>
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
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Отправить запрос</button>
                </div>
                <?php if($policyLink = tplvar(MrigroupHelper::tplvar_policy_link) && false):?>
                    <div class="col-12">
                        <div class="form-text">
                            Нажимая на кнопку, я соглашаюсь на обработку <a href="<?php echo $policyLink;?>" target="_blank">персональных данных</a>
                        </div>
                    </div>
                <?php endif;?>
                <?php if(false):?>
                <div class="col-12">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="subscribe" checked />
                            <span class="form-check-icon"></span>
                            <span class="form-check-text">
                            Согласен получать информационную и рекламную рассылку
                        </span>
                        </label>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </form>
    <?php else:?>
        <div class="modal-title">Произошла ошибка</div>
    <?php endif;?>
</div>
