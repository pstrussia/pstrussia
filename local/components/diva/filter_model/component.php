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
		if($buf[0] == "model_id")
			$select_filter = $buf[1];	 
	}
}

//$arResult["SELECTED"] = $select_filter;

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
	'order'  => array('UF_NAME' => 'ASC'),
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
	'order'  => array('UF_MODEL' => 'ASC'),
	'filter' => array('UF_XML_ID' => $modelId)
));

$arModel = [];

while ($row = $resData->Fetch())
{
	$marka = ''; $model = ''; $god = ''; $kuzov = '';
	
	$model = ucfirst($row["UF_MODEL"]);
	$marka = ucfirst($arMarka[$row["UF_VLADELETS"]]);
	$code = $marka."-".$model;
	
	if(empty($arResult["MODEL_AVTO"][$code]) && !empty($row["UF_MODEL"]))
	{
		$arResult["MODEL_AVTO"][$code] = ["VALUE" => $model, "PARRENT" => $marka, "CODE" => $code];
		
		if(!in_array($marka, $arResult["MARKA_AVTO"]))
			$arResult["MARKA_AVTO"][] = $marka;
	}

	$god = $row["UF_GODS"];
	if(!empty($row["UF_GODDO"]))
		$god .= '-'.$row["UF_GODDO"];
	
	if(!empty($god))
	{
		//$marka = $arMarka[$row["UF_VLADELETS"]];
		//$model = $row["UF_MODEL"];
		//$link = "/catalog/{$section_code}/filter/marka_avto-is-{$marka}/model_avto-is-{$model}/god_vypuska-is-{$god}/apply/";
		$link = "/catalog/{$section_code}/filter/model_id-is-{$row["UF_XML_ID"]}/apply/";
		$arResult["GOD_VYPUSKA"][] = ["VALUE" => $god, "PARRENT" => $code, "LINK" => $link];
	}
	
	if(!empty($row["UF_KUZOV"]))
	{
		//$marka = $arMarka[$row["UF_VLADELETS"]];
		//$model = $row["UF_MODEL"];
		$kuzov = $row["UF_KUZOV"];
		/*if(!empty($god))
			$kuzov = $row["UF_KUZOV"]." ({$god})";*/
		//$link = "/catalog/{$section_code}/filter/marka_avto-is-{$marka}/model_avto-is-{$model}/kuzov-is-{$kuzov}/apply/";
		$link = "/catalog/{$section_code}/filter/model_id-is-{$row["UF_XML_ID"]}/apply/";
		$arResult["KUZOV"][] = ["VALUE" => $kuzov, "PARRENT" => $code, "LINK" => $link];
	}
	
	if($select_filter == $row["UF_XML_ID"])
	{
		$arResult["SELECTED"] = ["marka_avto" => $marka, "model_avto" => $code, "god_vypuska" => $god, "kuzov" => $kuzov];
	}
}

sort($arResult["MARKA_AVTO"]);

//echo '<pre>'; print_r($arResult["SELECTED"]); '</pre>';

$this->IncludeComponentTemplate();












