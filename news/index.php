<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Новости");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"news", 
	array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "N",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "NAME",
			3 => "SORT",
			4 => "PREVIEW_TEXT",
			5 => "PREVIEW_PICTURE",
			6 => "DETAIL_TEXT",
			7 => "DETAIL_PICTURE",
			8 => "DATE_ACTIVE_FROM",
			9 => "ACTIVE_FROM",
			10 => "SHOW_COUNTER",
			11 => "IBLOCK_TYPE_ID",
			12 => "IBLOCK_ID",
			13 => "IBLOCK_CODE",
			14 => "DATE_CREATE",
			15 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "BANNERS_RIGHT",
			1 => "NEWS_ELEMENTS_ACTION",
			2 => "NEWS_ELEMENTS_BLOG",
			3 => "BUTTON_MODAL",
			4 => "NEWS_ELEMENTS_NEWS",
			5 => "BUTTON_FORM",
			6 => "BUTTON_TYPE",
			7 => "NEWS_TITLE_NBA",
			8 => "NEWS_TITLE_CATALOG",
			9 => "NEWS_GALLERY_TITLE",
			10 => "BUTTON_ONCLICK",
			11 => "BUTTON_NAME",
			12 => "NEWS_GALLERY_BORDER",
			13 => "BUTTON_BLANK",
			14 => "BANNERS_RIGHT_TYPE",
			15 => "CATALOG",
			16 => "BUTTON_QUIZ",
			17 => "BUTTON_LINK",
			18 => "ITEM_TEMPLATE",
			19 => "NEWS_DETAIL_TEXT",
			20 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FILE_404" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "11",
		"IBLOCK_TYPE" => "concept_phoenix_s1",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"LIST_ACTIVE_DATE_FORMAT" => "j F Y",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "CODE",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_TEXT",
			5 => "DETAIL_PICTURE",
			6 => "DATE_ACTIVE_FROM",
			7 => "ACTIVE_FROM",
			8 => "DATE_ACTIVE_TO",
			9 => "ACTIVE_TO",
			10 => "SHOW_COUNTER",
			11 => "IBLOCK_TYPE_ID",
			12 => "IBLOCK_ID",
			13 => "IBLOCK_CODE",
			14 => "DATE_CREATE",
			15 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "BANNERS_RIGHT",
			1 => "NEWS_ELEMENTS_ACTION",
			2 => "NEWS_ELEMENTS_BLOG",
			3 => "NEWS_ELEMENTS_NEWS",
			4 => "NEWS_TITLE_NBA",
			5 => "NEWS_TITLE_CATALOG",
			6 => "NEWS_GALLERY_TITLE",
			7 => "NEWS_GALLERY_BORDER",
			8 => "BANNERS_RIGHT_TYPE",
			9 => "ITEM_TEMPLATE",
			10 => "NEWS_DETAIL_TEXT",
			11 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "100000",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "phoenix_round",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SEF_FOLDER" => "/news/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "N",
		"TYPE" => "NW",
		"ARRAY_NAME" => "NEWS",
		"COMPONENT_TEMPLATE" => "news",
		"USE_REVIEW" => "N",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE#/",
			"detail" => "detail/#ELEMENT_CODE#/",
		)
	),
	false
);?>


<!-- dlya nastroek saita -->
<?$GLOBALS["PHOENIX_CURRENT_PAGE"] = "news";?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>