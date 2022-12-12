<?

$api_ship = [];
$res = CIBlockElement::GetList([], ["IBLOCK_CODE" => "delivery"], false, false, ["CODE", "NAME", "PREVIEW_PICTURE"]);
while($ob = $res->Fetch())
{
	$api_ship[$ob["CODE"]] = [
		"NAME" => $ob["NAME"],
		"PICTURE" => \CFile::GetPath($ob["PREVIEW_PICTURE"]),
	];
    
}

foreach ($arResult['ORDERS'] as $key => &$order)
{
	$db_vals = CSaleOrderPropsValue::GetList(
		array(),
		array(
	        "ORDER_ID" => $order['ORDER']["ID"],
	        "CODE" => ["IPOLAPISHIP_PROVIDER_KEY", "IPOLAPISHIP_PROVIDER"]
		)
	);
	while ($arVals = $db_vals->Fetch())
	{
		$order_props_val[$arVals["CODE"]] = $arVals["VALUE"];
	}
	
	foreach ($order["SHIPMENT"] as $key => &$shipment)
	{
		$PROVIDER_KEY = false;
		
		if($order_props_val["IPOLAPISHIP_PROVIDER_KEY"])
			$PROVIDER_KEY = $order_props_val["IPOLAPISHIP_PROVIDER_KEY"];
		else
		{
			foreach ($api_ship as $key => $item)
			{
				if(stripos($order_props_val["IPOLAPISHIP_PROVIDER"], $key) !== false)
				{
					$PROVIDER_KEY = $key;
					break;
				}
			}
		}
		
		$deliv_code = explode(":", $arResult['INFO']['DELIVERY'][$shipment['DELIVERY_ID']]["CODE"]);
		if($deliv_code[0] == "apiship" && !$PROVIDER_KEY == false)
		{
			$shipment["DELIVERY_NAME"] = str_replace($PROVIDER_KEY, $api_ship[$PROVIDER_KEY]["NAME"], $order_props_val["IPOLAPISHIP_PROVIDER"]);
		}
		
		//echo "<pre>"; print_r($order['ORDER']["ID"]); echo "</pre>";
		//echo "<pre>"; print_r($shipment["DELIVERY_NAME"]); echo "</pre>";
	}
}


//echo "<pre>"; print_r($arResult['ORDERS']); echo "</pre>";