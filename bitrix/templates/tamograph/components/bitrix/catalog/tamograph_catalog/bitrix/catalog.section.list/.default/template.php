<?php
/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if(count($arResult['SECTIONS'])):
    $strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
    $strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
    $arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')); ?>
    <div class="categories-list cards-list row">
        <?php foreach($arResult['SECTIONS'] as $arSection):
            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

            $link = $arSection['SECTION_PAGE_URL'];
            $name = $arSection['NAME'];
            ?>
            <div class="categories-item cards-item col-12 col-sm-6 col-lg-4 col-xl-3" id="<?php echo $this->GetEditAreaId($arSection['ID']); ?>">
                <div class="categories-item__outer cards-item-outer">
                    <div class="categories-item__head cards-item-head">
                        <div class="categories-item__image cards-item-image">
                            <a href="<?php echo $link;?>">
                                <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="<?php if(isset($arSection['PICTURE']) && $arSection['PICTURE']['SRC']):?> data-src="<?php echo $arSection['PICTURE']['SRC'];?>"<?php endif;?> alt="<?php echo htmlspecialchars($name);?>" class="lazyload" />
                            </a>
                        </div>
                    </div>
                    <div class="categories-item__body cards-item-body">
                        <div class="categories-item__title cards-item-title">
                            <a href="<?php echo $link;?>" class="categories-item__link cards-item-link"><?php echo $name;?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php endif;?>