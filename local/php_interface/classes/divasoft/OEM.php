<?
class OEM
{
        static $is_oem = 801; 
        static $is_oem_yes = 990;
		static $prop_articul = 731;
		static $prop_alt_articul = 779;
		static $prop_descr = "Производитель OEM";
		static $section_id = 232;
        
        static function isOEM($arFields)
        {
        	if(in_array(self::$section_id, $arFields["IBLOCK_SECTION"]))
			{
				return false;
			}
			
            foreach ($arFields["PROPERTY_VALUES"][self::$is_oem] as $prop) {
                if($prop["VALUE"] != self::$is_oem_yes)
                {
                    return false;
                }
            }
            
            return true;
        }
        
        static function getChild($id)
        {
            $res = \Bitrix\Iblock\ElementTable::getList(array(
                "select" => array("ID", "CODE", 'PROPERTY_CODE' => 'PROPERTY_PROP.CODE', 'PROPERTY_VALUE' => 'PROPERTY.VALUE', 'PROPERTY_TYPE' => 'PROPERTY_PROP.PROPERTY_TYPE'),
                "filter" => array("=PROPERTY_CODE" => "PARRENT_OEM", "=PROPERTY_VALUE" => $id),
                'runtime' => array(
                    new Bitrix\Main\Entity\ReferenceField(
                       'PROPERTY',
                       'Dvs\Iblock\ElementProperyTable',
                       array(
                          '=this.ID' => 'ref.IBLOCK_ELEMENT_ID'
                          ),
                       array('join_type' => 'LEFT')
                    ),
                    new Bitrix\Main\Entity\ReferenceField(
                       'PROPERTY_PROP',
                       '\Bitrix\Iblock\PropertyTable',
                       array(
                          '=this.PROPERTY.IBLOCK_PROPERTY_ID' => 'ref.ID'
                          ),
                       array('join_type' => 'LEFT')
                    ),
                 ),
            ));
            
            $result = [];
            
            while($r = $res->fetch())
            {
                $result[$r["CODE"]] = $r["ID"];
            }
            
            return $result;
        }
        
		static function makeNewNameCode(&$new, $new_article)
		{
            $old_article = '';

            foreach ($new["PROPERTY_VALUES"][self::$prop_articul] as &$article)
            {
            	if(is_array($article))
				{
					$old_article = $article["VALUE"];
                	$article["VALUE"] = $new_article;
				}
				else
				{
					$old_article = $article;
                	$article = $new_article;
				}
            }
			
	        $new["NAME"] = str_replace($old_article, $new_article, $new["NAME"]);
			
			$arParams = array("replace_space"=>"_","replace_other"=>"_");
			$new["CODE"] = Cutil::translit($new["NAME"],"ru",$arParams);
		}
		
		static function makePicture(&$arFields)
		{
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
		}
		
		static function make($arFields)
		{
            if(!self::isOEM($arFields))
            {
                return $arFields; 
            }
      
			$product_main_id = $arFields["ID"];
		
            $arChild = self::getChild($product_main_id);              
  
			foreach ($arFields["PROPERTY_VALUES"][self::$prop_alt_articul] as $prop) {
	            if($prop["DESCRIPTION"] != self::$prop_descr)
	                continue;

	            self::makePicture($arFields);
	
	            $new = $arFields;
	            self::makeNewNameCode($new, $prop["VALUE"]);
				$new["IBLOCK_SECTION"] = self::$section_id;
				
		        $el = new \CIBlockElement;
				
				if(empty($arChild[$new["CODE"]]))
				{
					self::addProduct($new, $product_main_id);
				}
				else
				{ 
					self::upProduct($new, $arChild[$new["CODE"]], $product_main_id);
				}
		        
			}
		}
		
		static function setProductData($product_child_id, $product_main_id, $up = false)
		{
			$product_main = \CCatalogProduct::GetByID($product_main_id);
            unset($product_main["ID"]);
            \CCatalogProduct::Update($product_child_id, $product_main);
			
			if($up)
			{
				CPrice::DeleteByProduct($product_child_id);
			}
			
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
                    "PRODUCT_ID" => $product_child_id,
                    "CATALOG_GROUP_ID" => $item["CATALOG_GROUP_ID"],
                    "PRICE" => $item["PRICE"],
                    "CURRENCY" => !$item["CURRENCY"] ? "RUB" : $item["CURRENCY"],
                ];

                \Bitrix\Catalog\Model\Price::add($arFieldsPrice);
            }
		}
		
		static function addProduct($arFields, $product_main_id)
		{
			$el = new \CIBlockElement;
			
			if($PRODUCT_ID = $el->Add($arFields))
			{
				a2l($product_main_id);
                \CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, array("PARRENT_OEM" => $product_main_id));
				\Bitrix\Catalog\Model\Product::add(["ID" => $PRODUCT_ID]);
				self::setProductData($PRODUCT_ID, $product_main_id);
			}
			else
			  a2l($el->LAST_ERROR);
		}
		
		static function upProduct($arFields, $product_child_id, $product_main_id)
		{
			$el = new \CIBlockElement;
			
			if($el->Update($product_child_id, $arFields))
			{
                \CIBlockElement::SetPropertyValuesEx($product_child_id, false, array("PARRENT_OEM" => $product_main_id));
				self::setProductData($product_child_id, $product_main_id, true);
			}
			else
			{
				a2l($el->LAST_ERROR);  
			}
		}
}