<?

class Models
{
	static function getModel($model_id)
	{
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById(5)->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array("*"),
			'order'  => array('UF_MODEL' => 'ASC'),
			'filter' => array('UF_XML_ID' => $model_id)
		));
		
		$arModel = [];
		
		while ($row = $resData->Fetch())
		{
			$arModel[$row["UF_XML_ID"]] = $row;
		}
		
		return $arModel;
	}
	
	static function getMarks($marks_id)
	{
		$arHLBlock = Bitrix\Highloadblock\HighloadBlockTable::getById(7)->fetch();
		$obEntity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array('ID', 'UF_NAME', 'UF_XML_ID'),
			'order'  => array('UF_NAME' => 'ASC'),
			'filter' => array('UF_XML_ID' => $marks_id)
		));
		
		$arMarka = [];
		
		while ($row = $resData->Fetch())
		{
			$arMarka[$row["UF_XML_ID"]] = $row["UF_NAME"];
		}
		
		return $arMarka;
	}
	
	static function getInfo($model_id) 
	{
		\Bitrix\Main\Loader::includeModule('highloadblock');
		
		$models = self::getModel($model_id);
		
		$marks_id = [];
		foreach ($models as $item)
		{
			if(!empty($item["UF_VLADELETS"]))
				$marks_id[] = $item["UF_VLADELETS"];
		}
		
		$marks = [];
		if(!empty($marks_id))
			$marks = self::getMarks($marks_id);
		
		$result = [];
		foreach ($models as $item)
		{
			$god = $item["UF_GODS"];
			if(!empty($item["UF_GODDO"]))
				$god .= '-'.$item["UF_GODDO"];
			
			$result[] = [
				"MARKA" => $marks[$item["UF_VLADELETS"]],
				"MODEL" => $item["UF_MODEL"],
				"GOD" => $god,
				"KUZOV" => $item["UF_KUZOV"],
			];
		}
		
		usort($result, function($a, $b) {
		    return $a['MARKA'] > $b['MARKA'];
		});
		
		return $result;
	}
}
