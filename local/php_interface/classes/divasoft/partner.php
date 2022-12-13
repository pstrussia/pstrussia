<?

class Partner
{
	static function getTypeVal()
	{
		return ["UL" => 236, "FL" => 237];
	}
	
	static function getStoreXmlId($filter = ["CODE" => "PST"])
	{
		$arStore = \Bitrix\Catalog\StoreTable::getRow([
		  'select' => ['XML_ID'],
		  'filter' => $filter
		]);
		if ($arStore)
		{
			return $arStore['XML_ID'];
		}
		else
		{
			return false;	
		}
	}
	
	static function addSaleProfile($arValues, $PERSON_TYPE_ID = 2)
	{
		$order_prop_id = self::getOrderProps($PERSON_TYPE_ID);
		
		$arFields = array(
           "NAME" => $arValues["NAME"],
           "USER_ID" => $arValues["USER_ID"],
           "PERSON_TYPE_ID" => $PERSON_TYPE_ID
        );
        $userPropsID = CSaleOrderUserProps::Add($arFields);
		
		foreach ($arValues as $key => $value)
		{
			if(!empty($order_prop_id[$key]))
			{
				$arFieldsPr = array(
                   "USER_PROPS_ID" => $userPropsID,
                   "ORDER_PROPS_ID" => $order_prop_id[$key]["ID"],
                   "NAME" => $order_prop_id[$key]["NAME"],
                   "VALUE" => $value
                );
				$resUPA = CSaleOrderUserPropsValue::Add($arFieldsPr);
			}
		}
	}
	
	static function getOrderProps($person_type_id)
	{
		$propsCode = [
			1 => [
				"NAME", "PHONE", "EMAIL", "SERVICE_ORDER", "STORE", "SOGLASHENIE", "DELIV_PAY_LATER", "DELIVERY_PRICE"
			],
			2 => [
				"UF_KPP", "UF_INN", "UF_ADDRESS", "UF_U_ADDRESS", "NAME", 
				"PHONE", "EMAIL", "UF_BIK", "UF_RS", "UF_BANK", "SERVICE_ORDER", "STORE", "SOGLASHENIE", "DELIV_PAY_LATER", "DELIVERY_PRICE"
			],
		];
		
		$db_props = \CSaleOrderProps::GetList(
	        array("SORT" => "ASC"),
	        array(
	                "PERSON_TYPE_ID" => $person_type_id,
	                "CODE" => $propsCode[$person_type_id],
	            ),
	        false,
	        false,
	        array("CODE", "ID", "NAME")
	    );
		
		$result = [];
		
		while ($props = $db_props->Fetch())
		{
			$result[$props["CODE"]] = ["ID" => $props["ID"], "NAME" => $props["NAME"]];
			
		}
		
		//echo "<pre>"; print_r($result); echo "</pre>";
		
		return $result;
	}
	
	static function makeZeroOrder($props, $user_id, $person_type_id)
	{
		if(empty($props) || empty($user_id))
			return false;
		//переделать под получение из админки
		
		$order_prop_id = self::getOrderProps($person_type_id);
		
		$basket = \Bitrix\Sale\Basket::create('s1');
		
		
		$basket->refresh();
		
		$order = \Bitrix\Sale\Order::create('s1', $user_id, 'RUB');
		$order->setPersonTypeId($person_type_id);
		$order->setBasket($basket);
		
		$propertyCollection = $order->getPropertyCollection();
		
		foreach ($order_prop_id as $key => $item) {
			if(!empty($props[$key]))
			{
				$property = $propertyCollection->getItemByOrderPropertyId($item["ID"]);
				$property->setValue($props[$key]);
			}
		}
		
		$property = $propertyCollection->getItemByOrderPropertyId($order_prop_id["SERVICE_ORDER"]["ID"]);
		$property->setValue("Y");
		
		$r = $order->save();
		
		if (!$r->isSuccess())
		{ 
		    return false;
		}
		else
		{
			return true;
		}
	}
	//оставить на крон
	static function deleteZeroOrder()
	{
		if (CModule::IncludeModule("sale")) {
	        $arFilter = Array(
	            "STATUS_ID" => "N",
	            "PROPERTY_VAL_BY_CODE_SERVICE_ORDER" => "Y",
	            "PRICE" => 0
	        );
	
	        $db_sales = \CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter, false, false, Array("ID"));
	        while ($ar_sales = $db_sales->Fetch()) {
	            //\CSaleOrder::Delete($ar_sales["ID"]);
	            echo "<pre>"; print_r($ar_sales); echo "</pre>";
	        }
	    }
		
		//return "Partner::deleteZeroOrder();";
	}
	
    static function getEmailByCode($code)
	{
		\CModule::IncludeModule('highloadblock');
		
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById(8)->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array("UF_PFPOCHTA"),
			'order'  => array(),
			'filter' => array('!UF_KOD' => false, 'UF_KOD' => $code)
		));
		
		$email = false;
		
		while ($row = $resData->Fetch())
		{
                    $email = $row["UF_PFPOCHTA"];
		}
		
		return $email;
	}
        
	static function setSoglashenieByUserId($UserId)
	{
		$arUser = \Bitrix\Main\UserTable::getRow([
		  'select' => ['EMAIL'],
		  'filter' => [
		    'ID' => $UserId,
		  ]
		]);
		if ($arUser)
		{
			return self::setSoglashenieByEmail($arUser['EMAIL']);
		}
		else
		{
			return false;	
		}
	}
	
	static function setSoglashenieByEmail($email)
	{
		\CModule::IncludeModule('highloadblock');
		
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById(8)->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array("UF_PFVIDTSENYSOGLASH"),
			'order'  => array(),
			'filter' => array('!UF_PFVIDTSENYSOGLASH' => false, 'UF_PFPOCHTA' => $email)
		));
		
		$sogl = false;
		
		while ($row = $resData->Fetch())
		{
			$sogl = $row["UF_PFVIDTSENYSOGLASH"];
		}
		
		return $sogl;
	}
	
	static function setVidTsenyBySoglashenie($arFields)
	{
		if(empty($arFields["UF_PFVIDTSENYSOGLASH"]) && !empty($arFields["UF_PFPOCHTA"]) && $arFields["REG"] == "Y")
		{
			$arFields["UF_PFVIDTSENYSOGLASH"] = self::setSoglashenieByEmail($arFields["UF_PFPOCHTA"]);
		}
		
		if (empty($arFields["UF_PFVIDTSENYSOGLASH"]) || empty($arFields["UF_PFPOCHTA"]))
		{
			return "";
		}

		$def_group = 2;
		$admin = 1;
		
		\CModule::IncludeModule('highloadblock');
		
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById(11)->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array("UF_SOGLASHENIE"),
			'order'  => array(),
			'filter' => array('UF_VIDTSENY' => $arFields["UF_PFVIDTSENYSOGLASH"])
		));
		
		$vid = '';
		
		if ($row = $resData->Fetch())
		{
			$vid = $row["UF_SOGLASHENIE"];
		}
		
		
		
		$dbPriceType = \CCatalogGroup::GetList(
		        array("SORT" => "ASC"),
		        array("XML_ID" => $vid)
		    );
		while ($arPriceType = $dbPriceType->Fetch())
		{
			$type_id = $arPriceType["ID"];
		    
		}

		$result_group = [];
		
		$db_res = \CCatalogGroup::GetGroupsList(array("CATALOG_GROUP_ID"=>$type_id, "BUY" => "Y", "!GROUP_ID" => 1));
		while ($ar_res = $db_res->Fetch())
		{
			$result_group[] = $ar_res["GROUP_ID"];
		}
		
		if(empty($result_group))
		{
			$result_group = $def_group;
		}

		$rsUser = \CUser::GetByLogin($arFields["UF_PFPOCHTA"]);
		if($arUser = $rsUser->Fetch())
		{
			$arGroups = CUser::GetUserGroup($arUser["ID"]);
			
			if(in_array($admin, $arGroups))
			{
				$result_group[] = $admin;
			}
			
			$user = new \CUser;
			$fields = Array(
			  	"GROUP_ID"	=>	$result_group
			);
			
			$user->Update($arUser["ID"], $fields);
		}
		
	}
}


















