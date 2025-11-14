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
<div class="section products">
    <div class="container">
        <h2 class="section-title">
            Список товаров бренда
        </h2>

        <div class="products-list cards-list row">
            <div class="products-item cards-item col-12 col-sm-6 col-lg">
                {% include "cards/products-item.html" %}
            </div>
            <div class="products-item cards-item col-12 col-sm-6 col-lg">
                {% include "cards/products-item.html" %}
            </div>
            <div class="products-item cards-item col-12 col-sm-6 col-lg">
                {% include "cards/products-item.html" %}
            </div>
            <div class="products-item cards-item col-12 col-sm-6 col-lg">
                {% include "cards/products-item.html" %}
            </div>
            <div class="products-item cards-item col-12 col-sm-6 col-lg">
                {% include "cards/products-item.html" %}
            </div>
            <div class="products-item cards-item col-12 col-sm-6 col-lg">
                {% include "cards/products-item.html" %}
            </div>
        </div>
    </div>
</div>