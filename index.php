<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Рулевые рейки, ремкомплекты, оборудование для ремонта рулевых реек PST Service Russia");
?>

<?
$APPLICATION->IncludeComponent(
	"concept:phoenix.pages", 
	".default", 
	array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "N",
		"FILE_404" => "",
		"IBLOCK_ID" => "16",
		"IBLOCK_TYPE" => "concept_phoenix_s1",
		"MESSAGE_404" => "",
		"SEF_FOLDER" => "/",
		"SEF_MODE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"CACHE_GROUPS" => "Y",
		"SEF_URL_TEMPLATES" => array(
			"main" => "",
			"page" => "#SECTION_CODE_PATH#/",
		)
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>