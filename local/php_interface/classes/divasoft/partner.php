<?

class Partner
{
	static function makeZeroOrder($props, $user_id, $person_type_id)
	{
		if(empty($props) || empty($user_id))
			return false;
		//переделать под получение из админки
		
		if($person_type_id == 2)
		{
			$order_prop_id = [
				"UF_KPP" => ["ID" => 27, "NAME" => "КПП"],
				"UF_INN" => ["ID" => 10, "NAME" => "ИНН"],
				"UF_ADDRESS" => ["ID" => 13, "NAME" => "Адрес доставки"],
				"UF_U_ADDRESS" => ["ID" => 8, "NAME" => "Юридический адрес"],
				"NAME" => ["ID" => 7, "NAME" => "Название компании"],
				"PHONE" => ["ID" => 14, "NAME" => "Телефон"],
				"EMAIL" => ["ID" => 6, "NAME" => "E-Mail"],
				"UF_BIK" => ["ID" => 29, "NAME" => "БИК"],
				"UF_RS" => ["ID" => 28, "NAME" => "Расчетный счет"],
				"UF_BANK" => ["ID" => 30, "NAME" => "Банк"],
			];
			
			$SERVICE_ORDER = 31;
		}
		else
		{
			$order_prop_id = [
				"NAME" => ["ID" => 1, "NAME" => "ФИО"],
				"PHONE" => ["ID" => 3, "NAME" => "Телефон"],
				"EMAIL" => ["ID" => 2, "NAME" => "E-Mail"],
			];
			
			$SERVICE_ORDER = 32;
		}
		
		$basket = \Bitrix\Sale\Basket::create('s1');
		
		
		$basket->refresh();
		
		$order = \Bitrix\Sale\Order::create('s1', $user_id, 'RUB');
		$order->setPersonTypeId($person_type_id);
		$order->setBasket($basket);
		
		$propertyCollection = $order->getPropertyCollection();
		
		foreach ($order_prop_id as $key => $item) {
			$property = $propertyCollection->getItemByOrderPropertyId($item["ID"]);
			$property->setValue($props[$key]);
		}
		
		$property = $propertyCollection->getItemByOrderPropertyId($SERVICE_ORDER);
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
	        $date = new DateTime('-20 minutes');
	        $date_1 = $date->format('d.m.Y H:i');
	
	        $date = new DateTime('-60 minutes');
	        $date_2 = $date->format('d.m.Y H:i');
	
	        $arFilter = Array(
	            "<=DATE_INSERT" => $date_1,
	            ">=DATE_INSERT" => $date_2,
	            "STATUS_ID" => "N",
	            "PROPERTY_SERVICE_ORDER" => "Y"
	        );
	
	        $db_sales = \CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter, false, false, Array("ID"));
	        while ($ar_sales = $db_sales->Fetch()) {
	            \CSaleOrder::Delete($ar_sales["ID"]);
	        }
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
		
		$sogl = '';
		
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
		
		//echo "<pre>"; print_r($vid); echo "</pre>";
		
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
			//echo "<pre>"; print_r($arGroups); echo "</pre>";
		}
		
	}
}


















