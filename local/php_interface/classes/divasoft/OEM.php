<?
class OEM
{
	
	static function make($arFields)
	{
		$prop_articul = 731;
		$prop_alt_articul = 779;
		$prop_descr = "Производитель OEM";
		
		$product_main_id = $arFields["ID"];
		
		foreach ($arFields["PROPERTY_VALUES"][$prop_alt_articul] as $prop) {
			if($prop["DESCRIPTION"] != $prop_descr)
				continue;

			if(empty($arFields["PREVIEW_PICTURE"]["name"]) && empty($arFields["DETAIL_PICTURE"]["name"]))
			{
				$res = \Bitrix\Iblock\ElementTable::getList(array(
				    "select" => array("PREVIEW_PICTURE", "DETAIL_PICTURE"),
				    "filter" => array("ID" => $product_main_id)
				));
				while($r = $res->fetch())
				{
					$arFields["PREVIEW_PICTURE"]  = \CFile::MakeFileArray(\CFile::GetPath($r["PREVIEW_PICTURE"]));
					$arFields["DETAIL_PICTURE"]  = \CFile::MakeFileArray(\CFile::GetPath($r["DETAIL_PICTURE"]));
				}
			}
			
			$new = $arFields;
			$old_article = '';
			
			foreach ($new["PROPERTY_VALUES"][$prop_articul] as &$article)
			{
				$old_article = $article;
				$article = $prop["VALUE"];
			}
			
	        $new["NAME"] = str_replace($old_article, $prop["VALUE"], $arFields["NAME"]);
			
			$arParams = array("replace_space"=>"_","replace_other"=>"_");
			$new["CODE"] = Cutil::translit($new["NAME"],"ru",$arParams);
			
			$new["IBLOCK_SECTION"] = [0 => 232];
			
	        $el = new \CIBlockElement;
	        
	        if($PRODUCT_ID = $el->Add($new))
			{
				$product_main = CCatalogProduct::GetByID($product_main_id);
				unset($product_main["ID"]);
				\Bitrix\Catalog\Model\Product::add(["ID" => $PRODUCT_ID]);
				CCatalogProduct::Update($PRODUCT_ID, $product_main);
				
				$allProductPrices = \Bitrix\Catalog\PriceTable::getList([
				  "select" => ["*"],
				  "filter" => [
				       "=PRODUCT_ID" => $product_main_id,
				  ],
				   "order" => ["CATALOG_GROUP_ID" => "ASC"]
				])->fetchAll();
				
				foreach ($allProductPrices as $key => $item)
				{
					$arFieldsPrice = [
					    "PRODUCT_ID" => $PRODUCT_ID,
					    "CATALOG_GROUP_ID" => $item["CATALOG_GROUP_ID"],
					    "PRICE" => $item["PRICE"],
					    "CURRENCY" => !$item["CURRENCY"] ? "RUB" : $item["CURRENCY"],
					];
					
					\Bitrix\Catalog\Model\Price::add($arFieldsPrice);
				}
			}
			else
			  a2l($el->LAST_ERROR);
		}
	}
}