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

if (isset($arResult['ITEMS']) && is_array($arResult['ITEMS']) && count($arResult['ITEMS'])):?>
    <div class="section main-brands">
        <div class="container">
            <h2 class="section-title">Наши клиенты</h2>

            <?php $APPLICATION->IncludeComponent(
                "parfyonov:variable.set",
                "main_brands_text",
                array(
                    'TEXT' => 'За годы работы наша компания разработала собственную стратегию ведения бизнеса, обрела множество лояльных клиентов и партнеров, наработала проверенную и надежную базу.'
                ),
                false
            );?>

            <div class="main-brands-slider-wrap">
                <div class="main-brands-slider swiper">
                    <?php foreach($arResult['ITEMS'] as $arItem):
                        $this->AddEditAction( $arItem[ 'ID' ], $arItem[ 'EDIT_LINK' ], CIBlock::GetArrayByID( $arItem[ "IBLOCK_ID" ], "ELEMENT_EDIT" ) );
                        $this->AddDeleteAction( $arItem[ 'ID' ], $arItem[ 'DELETE_LINK' ], CIBlock::GetArrayByID( $arItem[ "IBLOCK_ID" ], "ELEMENT_DELETE" ), array( "CONFIRM" => GetMessage( 'CT_BNL_ELEMENT_DELETE_CONFIRM' ) ) ); ?>
                        <div class="main-brands-slider-item brands-item cards-item swiper-slide" id="<?php echo $this->GetEditAreaId($arItem['ID']);?>">
                            <div class="brands-item__outer cards-item-outer">
                                <div class="brands-item__head cards-item-head">
                                    <div class="brands-item__image cards-item-image">
                                        <?php if(isset($arItem['URL'])):?>
                                            <a href="<?php echo $arItem['URL'];?>" target="_blank">
                                        <?php endif;?>
                                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="<?php echo $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?php echo htmlspecialchars($arItem['NAME']);?>" class="lazyload" />
                                        <?php if(isset($arItem['URL'])):?>
                                            </a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>

                <div class="swiper-navigation">
                    <button class="swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 21.03L3.97 13 12 4.97l1.06 1.06-6.22 6.22h15.19v1.5H6.84l6.22 6.22L12 21.03z"/></svg>
                    </button>
                    <button class="swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26"><path fill-rule="evenodd" clip-rule="evenodd" d="M14 21.03L22.03 13 14 4.97l-1.06 1.06 6.22 6.22H3.97v1.5h15.19l-6.22 6.22L14 21.03z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>