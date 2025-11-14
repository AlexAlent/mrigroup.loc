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
?>
<div class="section main-docs">
    <div class="container">
        <h2 class="section-title">Документы</h2>

        <div class="main-docs-list docs-list row">





            <?foreach($arResult["ITEMS"] as $arItem):?>
            <?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>

            <?php $path = $arItem['DISPLAY_PROPERTIES']['DOCUDOC']['FILE_VALUE']["SRC"];
	$info = pathinfo($path);
	$size = filesize($_SERVER['DOCUMENT_ROOT'].$path);

	switch ($info['extension']) {
		case 'xlsx':
			$ind = '/data/img/docs/xls.png';
			break;
		case 'xls':
			$ind = '/data/img/docs/xls.png';
			break;
		case 'docx':
			$ind = '/data/img/docs/doc.png';
			break;
		case 'doc':
			$ind = '/data/img/docs/doc.png';
			break;
		case 'pdf':
			$ind = '/data/img/docs/pdf.png';
			break;
		default:
			$ind = '/data/img/docs/pdf.png';
	}
	?>



            <div class="main-docs-item docs-item col-12 col-md-6 col-lg-4 col-xl-3" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <div class="docs-item__outer">
                    <div class="docs-item__body">
                        <div class="docs-item__icon">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                data-src="<?php echo $ind; ?>" alt="" class="lazyload" />
                        </div>
                        <div class="docs-item__name">
                            <a target="_blank" href="<?php echo $path; ?>" class="docs-item__link">
                                <?echo $arItem["NAME"]?>
                                <span><?php echo round($size / 1024 / 1024, 2); ?>
                                    mb</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <?endforeach;?>

        </div>
    </div>
</div>