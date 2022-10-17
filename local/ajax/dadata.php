<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include.php");

//$_POST["inn"] = 5836634739;
$inn = $_POST["inn"];

if(!empty($inn))
{
	$token = "3fd8fb6479c32bd611b18932c16956335efd2208";
	$secret = "fe26712650c7c22cf3ff9d6cb731211610fd9454";
	
	$dadata = new Dadata($token, $secret);
	$dadata->init();
	
	$result = $dadata->suggest("party", ["query" => $inn]);
	
	$arResult = [];
	
	foreach ($result["suggestions"] as $key => $item)
	{
		if($_POST["id"] == "dadata-inn")
		{
			$arResult["data"][$key] =[
				"value" => [
					"bxu-uf_inn" => $item["data"]["inn"],
					"bx-name" => $item["value"],
					"bxu-uf_kpp" => $item["data"]["kpp"],
					"bxu-uf_u_address" => $item["data"]["address"]["value"],
				],
				"name" => $item["value"],
				"text" => $item["data"]["inn"].' '.$item["data"]["address"]["value"]
			];
		}
		else
		{
			$arResult["data"][$key] = [
				"value" =>	[
					"ORDER_PROP_10" => $item["data"]["inn"],
					"ORDER_PROP_7" => $item["value"],
					"ORDER_PROP_27" => $item["data"]["kpp"],
					"ORDER_PROP_8" => $item["data"]["address"]["value"],
				],
				"name" => $item["value"],
				"text" => $item["data"]["inn"].' '.$item["data"]["address"]["value"]
			];	
		}
	}
	
	if(empty($arResult["data"]))
	{
		$arResult["status"] = ["value" => false, "text" => "Ничего не найдено"];
	}
	else
	{
		$arResult["status"] = ["value" => true];
	}
	
	echo json_encode($arResult);
	//echo "<pre>"; print_r($arResult); echo "</pre>";
}