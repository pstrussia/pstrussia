<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
global $PHOENIX_TEMPLATE_ARRAY;
$arProductsID = array();
$arOffersID = array();
$arMainProductsID = array();


//---------------------------
$api_ship = [];
$res = CIBlockElement::GetList([], ["IBLOCK_CODE" => "delivery"], false, false, ["CODE", "NAME", "PREVIEW_PICTURE"]);
while($ob = $res->Fetch())
{
	$api_ship[$ob["CODE"]] = [
		"NAME" => $ob["NAME"],
		"PICTURE" => \CFile::GetPath($ob["PREVIEW_PICTURE"]),
	];
    
}

$db_vals = CSaleOrderPropsValue::GetList(
	array(),
	array(
        "ORDER_ID" => $arResult["ID"],
        "CODE" => ["IPOLAPISHIP_PROVIDER_KEY", "IPOLAPISHIP_PROVIDER"]
	)
);
while ($arVals = $db_vals->Fetch())
{
	$order_props_val[$arVals["CODE"]] = $arVals["VALUE"];
}

foreach ($arResult["SHIPMENT"] as $key => &$shipment)
{
	$PROVIDER_KEY = false;
	
	if($order_props_val["IPOLAPISHIP_PROVIDER_KEY"])
		$PROVIDER_KEY = $order_props_val["IPOLAPISHIP_PROVIDER_KEY"];
	else
	{
		$str = $order_props_val["IPOLAPISHIP_PROVIDER"];
		
		foreach ($api_ship as $key => $value)
		{
			if(strpos($str, $key) !== false)
			{
				$PROVIDER_KEY =  $key;
				break;
			}	
		}
		
	}
	
	$deliv_code = explode(":", $shipment["DELIVERY"]["CODE"]);
	if($deliv_code[0] == "apiship" && !$PROVIDER_KEY == false)
	{
		$shipment["DELIVERY_NAME"] = str_replace($PROVIDER_KEY, $api_ship[$PROVIDER_KEY]["NAME"], $order_props_val["IPOLAPISHIP_PROVIDER"]);
		$shipment["DELIVERY"]["SRC_LOGOTIP"] = $api_ship[$PROVIDER_KEY]["PICTURE"];
	}
	
	
}





//-----------------------------

if(!empty($arResult['BASKET']))
{
	foreach ($arResult['BASKET'] as $key => $arItem){
		
		if(isset($arItem["PARENT"])){
			$arMainProductsID[$arItem["PARENT"]["ID"]] = $arItem["PARENT"]["ID"];
			$arResult['BASKET'][$key]["DETAIL_PAGE_URL"] = $arItem["DETAIL_PAGE_URL"]."?oID=".$arItem["PRODUCT_ID"];
			$arOffersID[] = $arItem["PRODUCT_ID"];
		}
		else
		{
			$arMainProductsID[$arItem["ID"]] = $arItem["PRODUCT_ID"];
		}
	}
}



if(!empty($arOffersID))
{
	$arOffersName = CPhoenix::GetOffersName($arOffersID);
}

if(!empty($arMainProductsID))
{
	$newArProduct = array();
	$arItem = array();
	
	$arSelect = array("ID", "NAME", "PROPERTY_AFTER_PAY_TEXT");
	$arFilter = Array("IBLOCK_ID"=> $PHOENIX_TEMPLATE_ARRAY["ITEMS"]['CATALOG']["IBLOCK_ID"], "ID" => $arMainProductsID);
    $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);

    while($ob = $res->GetNextElement())
    {
        $arItem = $ob->GetFields();
        $arItem["NAME"] = strip_tags($arItem["~NAME"]);
        $newArProduct[$arItem["ID"]] = $arItem;

    }



    foreach($arResult['BASKET'] as $key => $arItem){
	
		if(isset($arItem["PARENT"]))
		{
			$arResult['BASKET'][$key]["NAME"] = $newArProduct[$arItem["PARENT"]["ID"]]["NAME"];
			$arResult['BASKET'][$key]["NAME_OFFERS"] = $arOffersName[$arItem["PRODUCT_ID"]];
			$arResult['BASKET'][$key]["AFTER_PAY_TEXT"] = $newArProduct[$arItem["PARENT"]["ID"]]["~PROPERTY_AFTER_PAY_TEXT_VALUE"];
		}
		else
		{
			$arResult['BASKET'][$key]["AFTER_PAY_TEXT"] = $newArProduct[$arItem["PRODUCT_ID"]]["~PROPERTY_AFTER_PAY_TEXT_VALUE"];;
		}
	}
}