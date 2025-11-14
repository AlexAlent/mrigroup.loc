<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
?>
<div class="modal-outer">
    <div class="modal-overline">
        Обратный звонок
    </div>
    <div class="modal-title">
        Контакты для связи
    </div>
    <form data-xhr-action="/local/forms/send.php" data-add-b24trace="true" method="POST" class="modal-form feedback-form form" novalidate="novalidate" autocomplete="off">
        <input type="hidden" name="type" value="feedback" />
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Имя" required />
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <input type="tel" name="phone" class="form-control" placeholder="Телефон" required />
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
                        <input type="text" name="from" value="10:00" class="form-range-input input-from form-control" />
                        <input type="text" name="to" value="20:00" class="form-range-input input-to form-control" />
                        <div class="form-range-slider input-slider" data-min="08:00" data-max="22:00" data-start="10:00"
                             data-end="20:00" data-step="30"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Отправить запрос</button>
            </div>
            <?php if($policyLink = tplvar(MrigroupHelper::tplvar_policy_link)):?>
                <div class="col-12">
                    <div class="form-text">
                        Нажимая на кнопку, я соглашаюсь на обработку <a href="<?php echo $policyLink;?>" target="_blank">персональных данных</a>
                    </div>
                </div>
            <?php endif;?>
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
        </div>
    </form>
</div>