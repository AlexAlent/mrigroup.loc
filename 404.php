<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена");
$APPLICATION->SetPageProperty('arfoto_page_template', 'plain');?>
<div class="section notfound">
        <div class="container">
            <div class="notfound-code">
                404
            </div>
            <div class="notfound-title">
                Страница не найдена
            </div>
            <div class="notfound-button">
                <a href="/" class="btn btn-outline-primary">
                    <span>Перейти на главную</span>
                </a>
            </div>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>