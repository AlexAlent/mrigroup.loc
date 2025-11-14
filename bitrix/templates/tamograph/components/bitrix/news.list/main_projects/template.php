<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?php /*ToDo Refactor this */?>
<? if (count($arResult["ITEMS"]) > 0): ?>
    <div class="section main-projects">
        <div class="container">
            <h2 class="section-title">Реализованные проекты</h2>

            <div class="projects-list cards-list row">
                <?php foreach ($arResult["ITEMS"] as $arItem): ?>
                    <div class="projects-item cards-item col-12 col-sm-6 col-lg-4">
                        <div class="projects-item__outer cards-item-outer">
                            <div class="projects-item__image cards-item-image"><img
                                        src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                        data-src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arResult["NAME"] ?>"
                                        class="lazyload"/></div>
                            <div class="projects-item__inner">
                                <div class="projects-item__body cards-item-body">
                                    <div class="projects-item__name cards-item-title">
                                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"
                                           class="projects-item__link cards-item-link"><?= $arItem["NAME"] ?></a>
                                    </div>
                                </div>
                                <div class="projects-item__foot cards-item-foot">
                                    <div class="projects-item__info"> <?= $arItem["PREVIEW_TEXT"] ?> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>

            <div class="section-footer">
                <a href="<?php echo $arResult['ITEMS'][0]['LIST_PAGE_URL'];?>" class="btn btn-outline-primary">
                    <span>Все проекты</span>
                </a>
            </div>
        </div>
    </div>
<? endif ?>
