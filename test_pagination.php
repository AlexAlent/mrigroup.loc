<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$limit = intval(isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 0);

$arLimit = [
    26 => 12,
    34 => 10,
    35 => 9,
    40 => 8,
    50 => 7,
    60 => 6,
    70 => 5,
    100 => 4,
    120 => 3,
    170 => 2,
    320 => 1
];

if($limit <= 0) {
    $limit = array_keys($arLimit)[0];
}

$rsElements = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => 9
    ],
    false,
    [
        'nPageSize' => $limit
    ]
);
?>
<div class="content">
    <form method="GET" action="test_pagination.php">
        <select name="limit">
            <?php foreach($arLimit as $option => $text):?>
                <option value="<?php echo $option;?>"<?php if($option == $limit):?> selected<?php endif;?>><?php echo $text;?></option>
            <?php endforeach;?>
            <input type="submit" />
        </select>
    </form>
	 <?php echo $rsElements->GetPageNavString(
    'Навигация',
    'tamopager',
    'Y'
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>