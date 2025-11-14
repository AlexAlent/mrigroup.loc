<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */
?>


<div class="products-item__head cards-item-head" id="<?=$areaId?>" data-entity="item">

    <div class="products-item__image cards-item-image">


        <? if ($itemHasDetailUrl): ?>
      
            <? else: ?>
            <span class="product-item-image-wrapper" data-entity="image-wrapper">
                <? endif; ?>



                <a href="<?=$item['DETAIL_PAGE_URL']?>">
                    <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                        data-src="<?=$item['PREVIEW_PICTURE']['SRC']?>" alt="" class="lazyload" />
                    <ul class="cards-item-image-list" id="<?=$itemIds['PICT']?>">
                        <li data-src="<?=$item['PREVIEW_PICTURE']['SRC']?>" class="active"></li>
                        <?
		if ($item['SECOND_PICT'])
		{
			$bgImage = !empty($item['PREVIEW_PICTURE_SECOND']) ? $item['PREVIEW_PICTURE_SECOND']['SRC'] : $item['PREVIEW_PICTURE']['SRC'];
			?>

                        <li data-src="<?=$bgImage?>"></li>

                        <?
		}?>
                    </ul>
                </a>

                <span class="product-item-image-slider-control-container" id="<?=$itemIds['PICT_SLIDER']?>_indicator"
                    <?=($showSlider ? '' : 'style="display: none;"')?>>
                    <?
			if ($showSlider)
			{
				foreach ($morePhoto as $key => $photo)
				{
					?>
                    <span class="product-item-image-slider-control<?=($key == 0 ? ' active' : '')?>"
                        data-go-to="<?=$key?>"></span>
                    <?
				}
			}
			?>
                </span>
                <?
		if ($arParams['SLIDER_PROGRESS'] === 'Y')
		{
			?>
                <span class="product-item-image-slider-progress-bar-container">
                    <span class="product-item-image-slider-progress-bar" id="<?=$itemIds['PICT_SLIDER']?>_progress_bar"
                        style="width: 0;"></span>
                </span>
                <?
		}
		?>
                <? if ($itemHasDetailUrl): ?>
   
        <? else: ?>
        </span>
        <? endif; ?>


    </div>

    <?
     $arFilter = Array("IBLOCK_ID"=>20, "ID"=>$item['PROPERTIES']["METKA"]["VALUE"]);
$res = CIBlockElement::GetList(Array(), $arFilter);
if ($ob = $res->GetNextElement()){;
    $arFields = $ob->GetFields(); 
                                 }
    ?>
    <?if ($item['PROPERTIES']["METKA"]["VALUE"]){?>
    <div class="products-item__badge" style="background-color: <?=$arFields["PREVIEW_TEXT"]?>">
        <?echo $arFields["NAME"]?>
    </div>
    <?}?>

</div>

<div class="products-item__body cards-item-body">
    <div class="products-item__overline">
        <?=$item['PROPERTIES']['PRODUCTTYPE']['VALUE']?>
    </div>
    <div class="products-item__title cards-item-title">
        <? if ($itemHasDetailUrl): ?>
        <a class="products-item__link cards-item-link" href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$productTitle?>">
            <? endif; ?>
            <?=$productTitle?>
            <? if ($itemHasDetailUrl): ?>
        </a>
        <? endif; ?>

    </div>

    <?
	if (!empty($arParams['PRODUCT_BLOCKS_ORDER']))
	{
		foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName)
		{
			switch ($blockName)
			{
				case 'price': ?>
    <div class="product-item-info-container product-item-price-container" data-entity="price-block">

        <?
						if ($arParams['SHOW_OLD_PRICE'] === 'Y')
						{
							?>
        <div class="catalog-prices-item catalog-prices-item_type_old">

            <? //if($USER->IsAdmin()) {echo '<pre>'; print_r($price); echo '</pre>';}; ?>
            <?if ($price['PRICE_OLD'] < $price['PRINT_BASE_PRICE']){?>
            <span class="catalog-prices-item__value" id="<?=$itemIds['PRICE_OLD']?>">

                <?=$price['PRINT_BASE_PRICE']?>

            </span>
            <?}?>
        </div>

        <?
						}
						?>
        <span class="product-item-price-current" id="<?=$itemIds['PRICE']?>">
            <?
							if (!empty($price))
							{
								if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers)
								{
									echo Loc::getMessage(
										'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
										array(
											'#PRICE#' => $price['PRINT_RATIO_PRICE'],
											'#VALUE#' => $measureRatio,
											'#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
										)
									);
								}
								else
								{?>
            <div class="products-item__prices catalog-prices">
                <div class="catalog-prices-item">
                    <? //if($USER->IsAdmin()) {echo '<pre>'; print_r($arResult); echo '</pre>';}; ?>

                    <span class="catalog-prices-item__value">
                        <?if ($item["PROPERTIES"]["OT"]["VALUE"]){?>От
                        <?}?>
                        <? echo $price['PRINT_RATIO_PRICE'];?>
                    </span>
                    <?if ($price['BASE_PRICE'] > $price['PRICE']){?>
                    <span class="catalog-prices-item__discount">
                        <?if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y')
		{
			?>
                        <div class="product-item-label-ring <?=$discountPositionClass?>" id="<?=$itemIds['DSC_PERC']?>">
                            <span><?=-$price['PERCENT']?>%</span>
                        </div>
                        <?
		}?>
                    </span>
                    <?}?>
                </div>

            </div>

            <?}
							}
							?>
        </span>
    </div>


    <div class="products-item__button">
        <a href="#modal-offer" class="btn btn-outline-primary link-modal">
            Запросить КП
        </a>
    </div>
    <?
					break;



				case 'props':
					if (!$haveOffers)
					{
						if (!empty($item['DISPLAY_PROPERTIES']))
						{
							?>


    <div class="products-item__props catalog-props" data-entity="props-block" id="<?=$itemIds['PROP_DIV']?>">


        <?
//									foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty)
//									{
										?>
        <? //if($USER->IsAdmin()) {echo '<pre>'; print_r($item['DISPLAY_PROPERTIES']); echo '</pre>';}; ?>
        <?if ($item['DISPLAY_PROPERTIES']['CONDITION']['VALUE']){?>
        <div class="catalog-props-item">
            <div class="catalog-props-item__icon">
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                    data-src="/data/img/catalog/icon-01.svg" alt="" class="lazyload" />
            </div>
            <div class="catalog-props-item__title">Состояние:</div>
            <div class="catalog-props-item__value"><?=$item['DISPLAY_PROPERTIES']['CONDITION']['VALUE']?></div>

        </div>
        <?}; if ($item['DISPLAY_PROPERTIES']['MAG_FIELD_STRENGHT']['VALUE']){ ?>
        <div class="catalog-props-item">
            <div class="catalog-props-item__icon">
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                    data-src="/data/img/catalog/icon-02.svg" alt="" class="lazyload" />
            </div>
            <div class="catalog-props-item__title">Напряженность:</div>
            <div class="catalog-props-item__value"><?=$item['DISPLAY_PROPERTIES']['MAG_FIELD_STRENGHT']['VALUE']?></div>
        </div>
        <?}; if ($item['DISPLAY_PROPERTIES']['DIAMETR']['VALUE']){ ?>
        <div class="catalog-props-item">
            <div class="catalog-props-item__icon">
                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                    data-src="/data/img/catalog/icon-03.svg" alt="" class="lazyload" />
            </div>
            <div class="catalog-props-item__title">Диаметр туннеля:</div>
            <div class="catalog-props-item__value"><?=$item['DISPLAY_PROPERTIES']['DIAMETR']['VALUE']?></div>
        </div>
        <?};?>
        <!--
										<dt class="text-muted< ?=(!isset($item['PROPERTY_CODE_MOBILE'][$code]) ? ' d-none d-sm-block' : '')?>">
											< ?=$displayProperty['NAME']?>
										</dt>
										<dd class="text-dark< ?=(!isset($item['PROPERTY_CODE_MOBILE'][$code]) ? ' d-none d-sm-block' : '')?>">
											< ?=(is_array($displayProperty['DISPLAY_VALUE'])
												? implode(' / ', $displayProperty['DISPLAY_VALUE'])
												: $displayProperty['DISPLAY_VALUE'])?>
										</dd>
-->
    </div>
    <?
//									}
									?>


    <?
						}

						if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !empty($item['PRODUCT_PROPERTIES']))
						{
							?>
    <div id="<?=$itemIds['BASKET_PROP_DIV']?>" style="display: none;">
        <?
								if (!empty($item['PRODUCT_PROPERTIES_FILL']))
								{
									foreach ($item['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo)
									{
										?>
        <input type="hidden" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]"
            value="<?=htmlspecialcharsbx($propInfo['ID'])?>">
        <?
										unset($item['PRODUCT_PROPERTIES'][$propID]);
									}
								}

								if (!empty($item['PRODUCT_PROPERTIES']))
								{
									?>
        <table>
            <?
										foreach ($item['PRODUCT_PROPERTIES'] as $propID => $propInfo)
										{
											?>
            <tr>
                <td><?=$item['PROPERTIES'][$propID]['NAME']?></td>
                <td>
                    <?
													if (
														$item['PROPERTIES'][$propID]['PROPERTY_TYPE'] === 'L'
														&& $item['PROPERTIES'][$propID]['LIST_TYPE'] === 'C'
													)
													{
														foreach ($propInfo['VALUES'] as $valueID => $value)
														{
															?>
                    <label>
                        <? $checked = $valueID === $propInfo['SELECTED'] ? 'checked' : ''; ?>
                        <input type="radio" name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]"
                            value="<?=$valueID?>" <?=$checked?>>
                        <?=$value?>
                    </label>
                    <br />
                    <?
														}
													}
													else
													{
														?>
                    <select name="<?=$arParams['PRODUCT_PROPS_VARIABLE']?>[<?=$propID?>]">
                        <?
															foreach ($propInfo['VALUES'] as $valueID => $value)
															{
																$selected = $valueID === $propInfo['SELECTED'] ? 'selected' : '';
																?>
                        <option value="<?=$valueID?>" <?=$selected?>>
                            <?=$value?>
                        </option>
                        <?
															}
															?>
                    </select>
                    <?
													}
													?>
                </td>
            </tr>
            <?
										}
										?>
        </table>
        <?
								}
                            
                            ?>
    </div>
    <?
						}
                        								?>

    <?
					}
					else
					{
						$showProductProps = !empty($item['DISPLAY_PROPERTIES']);
						$showOfferProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];

						if ($showProductProps || $showOfferProps)
						{
							?>
    <div class="product-item-info-container product-item-hidden" data-entity="props-block">
        <dl class="product-item-properties">
            <?
									if ($showProductProps)
									{
										foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty)
										{
											?>
            <dt class="text-muted<?=(!isset($item['PROPERTY_CODE_MOBILE'][$code]) ? ' d-none d-sm-block' : '')?>">
                <?=$displayProperty['NAME']?>
            </dt>
            <dd class="text-dark<?=(!isset($item['PROPERTY_CODE_MOBILE'][$code]) ? ' d-none d-sm-block' : '')?>">
                <?=(is_array($displayProperty['DISPLAY_VALUE'])
													? implode(' / ', $displayProperty['DISPLAY_VALUE'])
													: $displayProperty['DISPLAY_VALUE'])?>
            </dd>
            <?
										}
									}

									if ($showOfferProps)
									{
										?>
            <span id="<?=$itemIds['DISPLAY_PROP_DIV']?>" style="display: none;"></span>
            <?
									}
									?>
        </dl>
    </div>
    <?
						}
					}

					break;

				case 'sku':
					if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP']))
					{
						?>
    <div class="product-item-info-container product-item-hidden">
        <?
							foreach ($arParams['SKU_PROPS'] as $skuProperty)
							{
								$propertyId = $skuProperty['ID'];
								$skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
								if (!isset($item['SKU_TREE_VALUES'][$propertyId]))
									continue;
								?>
        <div data-entity="sku-block">
            <div class="product-item-scu-container" data-entity="sku-line-block">
                <div class="product-item-scu-block-title text-muted"><?=$skuProperty['NAME']?></div>
                <div class="product-item-scu-block">
                    <div class="product-item-scu-list">
                        <ul class="product-item-scu-item-list">
                            <?
													foreach ($skuProperty['VALUES'] as $value)
													{
														if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))
															continue;

														$value['NAME'] = htmlspecialcharsbx($value['NAME']);

														if ($skuProperty['SHOW_MODE'] === 'PICT')
														{
															?>
                            <li class="product-item-scu-item-color-container" title="<?=$value['NAME']?>"
                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                <div class="product-item-scu-item-color-block">
                                    <div class="product-item-scu-item-color" title="<?=$value['NAME']?>"
                                        style="background-image: url('<?=$value['PICT']['SRC']?>');"></div>
                                </div>
                            </li>
                            <?
														}
														else
														{
															?>
                            <li class="product-item-scu-item-text-container" title="<?=$value['NAME']?>"
                                data-treevalue="<?=$propertyId?>_<?=$value['ID']?>" data-onevalue="<?=$value['ID']?>">
                                <div class="product-item-scu-item-text-block">
                                    <div class="product-item-scu-item-text"><?=$value['NAME']?></div>
                                </div>
                            </li>
                            <?
														}
													}
													?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?
							}
							?>
    </div>
    <?
						foreach ($arParams['SKU_PROPS'] as $skuProperty)
						{
							if (!isset($item['OFFERS_PROP'][$skuProperty['CODE']]))
								continue;

							$skuProps[] = array(
								'ID' => $skuProperty['ID'],
								'SHOW_MODE' => $skuProperty['SHOW_MODE'],
								'VALUES' => $skuProperty['VALUES'],
								'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
							);
						}

						unset($skuProperty, $value);

						if ($item['OFFERS_PROPS_DISPLAY'])
						{
							foreach ($item['JS_OFFERS'] as $keyOffer => $jsOffer)
							{
								$strProps = '';

								if (!empty($jsOffer['DISPLAY_PROPERTIES']))
								{
									foreach ($jsOffer['DISPLAY_PROPERTIES'] as $displayProperty)
									{
										$strProps .= '<dt>'.$displayProperty['NAME'].'</dt><dd>'
											.(is_array($displayProperty['VALUE'])
												? implode(' / ', $displayProperty['VALUE'])
												: $displayProperty['VALUE'])
											.'</dd>';
									}
								}

								$item['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
							}
							unset($jsOffer, $strProps);
						}
					}

					break;
			}
		}
	}

	if (
		$arParams['DISPLAY_COMPARE']
		&& (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')
	)
	{
		?>
    <div class="product-item-compare-container">
        <div class="product-item-compare">
            <div class="checkbox">
                <label id="<?=$itemIds['COMPARE_LINK']?>">
                    <input type="checkbox" data-entity="compare-checkbox">
                    <span data-entity="compare-title"><?=$arParams['MESS_BTN_COMPARE']?></span>
                </label>
            </div>
        </div>
    </div>
    <?
	}
	?>


</div>