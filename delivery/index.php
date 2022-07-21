<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>

<?$APPLICATION->IncludeComponent("concept:phoenix.pages", "", Array(
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "N",
		"FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
		"IBLOCK_ID" => "16",	// Инфоблок
		"IBLOCK_TYPE" => "concept_phoenix_s1",	// Тип инфоблока
		"MESSAGE_404" => "",
		"SEF_FOLDER" => "/",	// Каталог ЧПУ (относительно корня сайта)
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"SET_STATUS_404" => "Y",	// Устанавливать статус 404
		"SHOW_404" => "Y",	// Показ специальной страницы
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"SEF_URL_TEMPLATES" => array(
			"main" => "",
			"page" => "#SECTION_CODE_PATH#/",
		)
	),
	false
);?>

<div class="container">
    
    <div class="terms">
    
        <div class="terms__banner">
            <img src="/images/terms-bg.jpg" alt="alt">
        </div>
    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include/delivery/content.php", array(), array("MODE" => "html", "NAME" => "content", "TEMPLATE" => "content.php"));?>
       
    
    </div>
</div>

<?$GLOBALS["PHOENIX_CURRENT_PAGE"] = "/delivery/";?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>