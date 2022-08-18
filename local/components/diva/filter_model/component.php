<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include.php");
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('highloadblock');

$section_code = $arParams["SECTION_CODE"];
$iblock_id = 14;

$arResult = [];

if($section_code == "rulevye-reyki")
	$arResult['PAGE_NAME'] = "рулевой рейки";
elseif($section_code == "nasosy-gur")
	$arResult['PAGE_NAME'] = "насоса ГУР";

$arResult['DEF_PAGE'] = "/catalog/{$section_code}/";

if(!empty($arParams["SMART_FILTER_PATH"]))
{
	$select_filter = [];
	$path = explode("/", $arParams["SMART_FILTER_PATH"]);
	
	foreach ($path as $key => $value)
	{
		$buf = explode("-is-", $value);
		$select_filter[$buf[0]] = $buf[1];	 
	}
}

$arResult["SELECTED"] = $select_filter;

$res = \CIBlockElement::GetList(
    ['ID' => 'ASC'],
    ['IBLOCK_ID' => $iblock_id, "SECTION_CODE" => $section_code],
    false,
    false,
    ['ID', 'IBLOCK_ID']
);

$modelId = [];

while ($row = $res->Fetch())
{
	$db_props = CIBlockElement::GetProperty($iblock_id, $row["ID"], array("sort" => "asc"), Array("CODE"=>"CML2_TRAITS"));

	while ($row1 = $db_props->Fetch())
	{
		if($row1["DESCRIPTION"] == "ID_MODEL_1C")
			$modelId[$row1["VALUE"]] = $row1["VALUE"];
	}
}

$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(7)->fetch();
$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
$strEntityDataClass = $obEntity->getDataClass();
$resData = $strEntityDataClass::getList(array(
	'select' => array('ID', 'UF_NAME', 'UF_XML_ID'),
	'order'  => array('ID' => 'ASC'),
));

$arMarka = [];

while ($row = $resData->Fetch())
{
	$arMarka[$row["UF_XML_ID"]] = $row["UF_NAME"];
	//$arResult["MARKA_AVTO"][] = $row["UF_NAME"];
}

//echo '<pre>'; print_r($arMarka); '</pre>';

$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
$strEntityDataClass = $obEntity->getDataClass();
$resData = $strEntityDataClass::getList(array(
	'select' => array('ID', 'UF_MODEL', 'UF_XML_ID', 'UF_KUZOV', 'UF_GODS', 'UF_GODDO', 'UF_VLADELETS'),
	'order'  => array('ID' => 'ASC'),
	'filter' => array('UF_XML_ID' => $modelId)
));

$arModel = [];

while ($row = $resData->Fetch())
{
	if(empty($arResult["MODEL_AVTO"][$row["UF_MODEL"]]))
	{
		$arResult["MODEL_AVTO"][$row["UF_MODEL"]] = ["VALUE" => $row["UF_MODEL"], "PARRENT" => $arMarka[$row["UF_VLADELETS"]]];
		
		if(!in_array($arMarka[$row["UF_VLADELETS"]], $arResult["MARKA_AVTO"]))
			$arResult["MARKA_AVTO"][] = $arMarka[$row["UF_VLADELETS"]];
	}
	
	$god = $row["UF_GODS"];
	if(!empty($row["UF_GODDO"]))
		$god .= '-'.$row["UF_GODDO"];
	
	if(!empty($god))
	{
		$marka = strtolower($arMarka[$row["UF_VLADELETS"]]);
		$model = strtolower($row["UF_MODEL"]);
		$link = "/catalog/{$section_code}/filter/marka_avto-is-{$marka}/model_avto-is-{$model}/god_vypuska-is-{$god}/apply/";
		$arResult["GOD_VYPUSKA"][] = ["VALUE" => $god, "PARRENT" => $row["UF_MODEL"], "LINK" => $link];
	}
	
	if(!empty($row["UF_KUZOV"]))
	{
		$marka = strtolower($arMarka[$row["UF_VLADELETS"]]);
		$model = strtolower($row["UF_MODEL"]);
		$kuzov = str_replace('/', '-', strtolower($row["UF_KUZOV"]));
		$link = "/catalog/{$section_code}/filter/marka_avto-is-{$marka}/model_avto-is-{$model}/kuzov-is-{$kuzov}/apply/";
		$arResult["KUZOV"][] = ["VALUE" => $kuzov, "PARRENT" => $row["UF_MODEL"], "LINK" => $link];
	}
}

//echo '<pre>'; print_r($arResult); '</pre>';

$this->IncludeComponentTemplate();












