<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$return = '';

if (!empty($arResult)) {
    $items = '';

    $itemSize = count($arResult);
    for ($index = 0; $index < $itemSize; $index++) {
        $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

        if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1) {
            $items .= <<<HTML
<li class="breadcrumb-item">
    <a class="breadcrumb-link" href="{$arResult[$index]["LINK"]}" title="$title">$title</a>
</li>
HTML;
        } else {
            $items .= <<<HTML
<li class="breadcrumb-item active" aria-current="page">
    $title
</li>
HTML;
        }
    }

    $return = <<<HTML
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        $items
    </ol>
</nav>
HTML;
}

return $return;