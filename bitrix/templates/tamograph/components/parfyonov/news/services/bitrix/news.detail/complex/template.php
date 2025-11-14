<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

$displayProperties = isset($arResult['DISPLAY_PROPERTIES']) && is_array($arResult['DISPLAY_PROPERTIES']) ? $arResult['DISPLAY_PROPERTIES'] : [];
?>
<div class="section">
    <div class="container">
        <?php echo MrigroupHelper::index_breadcrumbs;?>

        <h1><?php echo $arResult['NAME'];?></h1>

        <?php if(isset($arResult['DETAIL_PICTURE'])):?>
            <figure class="section-image">
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?php echo htmlspecialchars($arResult['DETAIL_PICTURE']['ALT']);?>" class="lazyload" />
            </figure>
        <?php endif;?>

        <div class="solution-content">
            <div class="row">
                <?php if($arResult['DETAIL_TEXT']):?>
                    <div class="col-12 col-lg-9">
                        <div class="section-content"><?php echo $arResult['DETAIL_TEXT'];?></div>
                    </div>
                <?php endif;?>

                <?php if(isset($displayProperties['COMPLEX_CHECK_LIST']) && $displayProperties['COMPLEX_CHECK_LIST']['VALUE']):?>
                    <div class="col-12 col-lg-9">
                        <ul class="list">
                            <?php foreach($displayProperties['COMPLEX_CHECK_LIST']['VALUE'] as $value):?>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M8.99 13.586l5.58-5.581-1.06-1.06-4.52 4.52-2.5-2.5-1.06 1.06 3.56 3.56z"/><path fill-rule="evenodd" clip-rule="evenodd" d="M18.203 10a8.203 8.203 0 11-16.406 0 8.203 8.203 0 0116.406 0zm-1.5 0a6.703 6.703 0 11-13.405 0 6.703 6.703 0 0113.405 0z"/></svg>
                                    <?php echo $value;?>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php if(isset($displayProperties['COMPLEX_DOCUMENTS'])):?>
    <div class="section main-docs">
        <div class="container">
            <h2 class="section-title">Документы</h2>

            <div class="main-docs-list docs-list row">
                <?php foreach($displayProperties['COMPLEX_DOCUMENTS']['FILE_VALUE'] as $file):
                    $icon = SITE_TEMPLATE_PATH . '/img/docs/' . pathinfo($file['SRC'], PATHINFO_EXTENSION) . '.png';?>
                    <div class="main-docs-item docs-item col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="docs-item__outer">
                            <div class="docs-item__body">
                                <?php if(file_exists($_SERVER['DOCUMENT_ROOT']) . $icon):?>
                                    <div class="docs-item__icon">
                                        <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                             data-src="<?php echo $icon;?>" alt="" class="lazyload" />
                                    </div>
                                <?php endif;?>
                                <div class="docs-item__name">
                                    <a href="<?php echo $file['SRC'];?>" class="docs-item__link" download>
                                        <?php echo $file['DESCRIPTION'] ?: $file['ORIGINAL_NAME'];?> <span><?php echo CFile::FormatSize($file['FILE_SIZE']);?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endif;?>

<?php if(count($arResult['SETS'])):?>
    <div class="section sets">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-9">
                    <?php if(isset($displayProperties['COMPLEX_SET_TITLE'])):?>
                        <h2><?php echo $displayProperties['COMPLEX_SET_TITLE']['VALUE'];?></h2>
                    <?php endif;?>

                    <div class="sets-list">
                        <?php foreach($arResult['SETS'] as $i => $set):?>
                            <div class="sets-item">
                                <div class="sets-item__outer">
                                    <div class="sets-item__head">
                                        <div class="sets-item__overline">Комплектация</div>
                                        <div class="sets-item__name"><?php echo $set['name'];?></div>
                                        <?php if(isset($set['price'])):?>
                                            <div class="sets-item__price"><?php echo $set['price'];?></div>
                                        <?php endif;?>
                                    </div>
                                    <div class="sets-item__button">
                                        <a href="<?php echo MrigroupHelper::getModalOfferLink($arResult['ID'], ['set' => $set['name']]);?>" class="btn btn-outline-primary link-modal">Запросить КП</a>
                                    </div>

                                    <?php if(isset($set['description'])):?>
                                        <div class="sets-item__description"><?php echo $set['description'];?></div>
                                    <?php endif;?>

                                    <?php if(isset($set['products'])):?>
                                        <div class="sets-item__products set-products">
                                            <button type="button" class="btn btn-collapse collapsed"
                                                    data-toggle="collapse" data-target="#set-<?php echo $i;?>" aria-expanded="false"
                                                    aria-controls="set-<?php echo $i;?>">
                                                <span class="btn-collapse__text-show">Смотреть состав</span>
                                                <span class="btn-collapse__text-hide">Скрыть состав</span>
                                                <span class="btn-collapse__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.97 10.28l1.06-1.06L13 15.19l5.97-5.97 1.06 1.06L13 17.31l-7.03-7.03z"/></svg>
                                                </span>
                                            </button>
                                            <div id="set-<?php echo $i;?>" class="collapse" aria-labelledby="headingOne">
                                                <div class="set-products-list">
                                                    <?php foreach($set['products'] as $product):?>
                                                        <div class="set-products-item">
                                                            <div class="set-products-item__outer">
                                                                <div class="set-products-item__body">
                                                                    <div class="set-products-item__title">
                                                                        <a href="<?php echo $product['link'];?>" class="set-products-item__link"><?php echo $product['name'];?></a>
                                                                    </div>
                                                                </div>
                                                                <div class="set-products-item__side">
                                                                    <?php if(isset($product['price'])):?>
                                                                        <div class="set-products-item__price"><?php echo number_format(floatval($product['price']), 0, '', ' ');?> ₽</div>
                                                                    <?php endif;?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach;?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>