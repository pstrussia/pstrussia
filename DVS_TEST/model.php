<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include.php");
\Bitrix\Main\Loader::includeModule('iblock');
\Bitrix\Main\Loader::includeModule('highloadblock');

$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(7)->fetch();
$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
$strEntityDataClass = $obEntity->getDataClass();
$resData = $strEntityDataClass::getList(array(
	'select' => array('ID', 'UF_NAME', 'UF_XML_ID'),
	//'filter' => array('ID' => 1),
	'order'  => array('ID' => 'ASC'),
));

$arMarka = [];

while ($row = $resData->Fetch())
{
	$arMarka[$row["UF_XML_ID"]] = $row["UF_NAME"];
}

//echo '<pre>'; print_r($arMarka); '</pre>';

$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
$strEntityDataClass = $obEntity->getDataClass();
$resData = $strEntityDataClass::getList(array(
	'select' => array('ID', 'UF_MODEL', 'UF_XML_ID', 'UF_KUZOV', 'UF_GODS', 'UF_GODDO', 'UF_VLADELETS'),
	//'filter' => array('ID' => 1594),
	'order'  => array('ID' => 'ASC'),
));

$arModel = [];

while ($row = $resData->Fetch())
{
	$arModel[$row["UF_XML_ID"]]["MARKA_AVTO"] = $arMarka[$row["UF_VLADELETS"]];
	$arModel[$row["UF_XML_ID"]]["MODEL_AVTO"] = $row["UF_MODEL"];
	$arModel[$row["UF_XML_ID"]]["GOD_VYPUSKA"] = $row["UF_GODS"];
	if(!empty($row["UF_GODDO"]))
		$arModel[$row["UF_XML_ID"]]["GOD_VYPUSKA"] .= '-'.$row["UF_GODDO"];
	$arModel[$row["UF_XML_ID"]]["KUZOV"] = $row["UF_KUZOV"];
}


//echo '<pre>'; print_r($arModel); '</pre>';

//KUZOV MARKA_AVTO MODEL_AVTO GOD_VYPUSKA

$val_key = ["KUZOV", "MARKA_AVTO", "MODEL_AVTO", "GOD_VYPUSKA"];

$res = \CIBlockElement::GetList(
    ['ID' => 'ASC'],
    ['IBLOCK_ID' => 14, "IBLOCK_SECTION_ID" => 197],
    false,
    false,
    ['ID', 'IBLOCK_ID']
);

while ($row = $res->Fetch())
{
	$db_props = CIBlockElement::GetProperty(14, $row["ID"], array("sort" => "asc"), Array("CODE"=>"CML2_TRAITS"));
	
	$values = [];
	$modelId = [];
	
	while ($row1 = $db_props->Fetch())
	{
		if($row1["DESCRIPTION"] == "ID_MODEL_1C")
			$modelId[] = $row1["VALUE"];
	}
	
	if(!empty($modelId))
	{
		foreach ($modelId as $value)
		{
			foreach ($val_key as $key)
			{
				if(!empty($arModel[$value][$key]))
					$values[$key][] = $arModel[$value][$key];
			}
			//$values["FILTER_PARAM"] = implode('-', $arModel[$value]);
		}
	}
	
	if(!empty($values))
		\CIBlockElement::SetPropertyValuesEx($row["ID"], false, $values);
	
    //echo '<pre>'; print_r($values); '</pre>';
}













