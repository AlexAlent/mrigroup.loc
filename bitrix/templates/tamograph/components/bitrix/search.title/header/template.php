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
if($arParams["SHOW_INPUT"] !== "N"):?>
    <div class="searchbar">
        <div class="container">
            <div class="searchbar-outer">
                <form action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="searchbar-form" novalidate="novalidate" autocomplete="off">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M15.981 17.042a7.5 7.5 0 111.06-1.06l5.224 5.223-1.06 1.06-5.224-5.223zm1.254-5.807a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                        </div>
                        <input type="search" name="q" class="form-control" placeholder="Поиск" value="<?=htmlspecialcharsbx($_REQUEST["q"])?>"
                               required="required" />
                    </div>
                </form>
                <button type="button" class="searchbar-toggler btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 26 26">
                        <path
                                d="M13 14.06l7.47 7.47 1.06-1.06L14.06 13l7.47-7.47-1.06-1.06L13 11.94 5.53 4.47 4.47 5.53 11.94 13l-7.47 7.47 1.06 1.06L13 14.06z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
<?php endif;?>
