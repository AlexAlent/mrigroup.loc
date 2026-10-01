<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $APPLICATION;

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'sid' => htmlspecialcharsbx($APPLICATION->CaptchaGetCode())
]);