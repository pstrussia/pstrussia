<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//данные исходящего веб хука
define('OUT_DOMAIN', 'pstrussia.bitrix24.ru');
define('OUT_TOKEN', 'n9keuy6zxzqe2mk405yhp79adlpxfyi1');

//данные входящего веб хука
define('IN_DOMAIN', 'pstrussia.bitrix24.ru');
define('IN_TOKEN', 'wgrs93os4d8odfy7');
define('IN_USER', 1);
	
\Bitrix\Main\Loader::includeModule('sale');

$data = $_POST;

//проверяем, что пришел запрос из bitri24 (из вебхука)
if ($data['auth']['domain'] == OUT_DOMAIN && $data['auth']['application_token'] == OUT_TOKEN) {
	

	//получение ID сделки
	$dealId = $data['data']['FIELDS']['ID'];
	
	//проверка на существование сделки
	if ($dealId) {
		
		
		/*
		Класс для работы с bitrix24 /local/php_interface/classes/divasoft/b24/b24classes.php
		Класс подключается тут /local/php_interface/classes/divasoft/divasoft.loader.php
		*/
		$bx24 = new Bitrix24(IN_DOMAIN, IN_USER, IN_TOKEN);//объект заказа 
		
		
		$deal = $bx24->getDeal($dealId);//получаем сделку по id
		
		//проверка что сделка создалась из штатной интеграции Битрикс с Битрикс24
		if (
			$deal['result'] &&
			$deal['result']['TYPE_ID'] == 'SALE' &&
			$deal['result']['ORIGIN_ID'] &&
			$deal['result']['ADDITIONAL_INFO'] &&
			strpos($deal['result']['TITLE'], 'EShop') !== false
		) {
			
			\Bitrix\Main\Loader::includeModule('sale');//подкллбчаем модуль sale
			
			$order = \Bitrix\Sale\Order::load($deal['result']['ORIGIN_ID']);//получаем заказ

			$propertyCollection = $order->getPropertyCollection();//получаем коллекцию объектов свойтсв заказа
			$properties = $propertyCollection->getArray();//получаем свойства в виде массива

			$roistat_id = 0;
			
			//получаем roistat_id из свойства заказа с кодом ROISTAT_ID
			foreach ($properties['properties'] as $prop) {
				
				if ($prop['CODE'] == 'ROISTAT_ID' && $prop['VALUE'][0]) {
					$roistat_id = $prop['VALUE'][0];
					break;
				}

			}
			
			//если roistat_id задан
			if ($roistat_id) {

				//пишем roistat_id сделку в bitrix24 
				$fieldsDeal['UF_CRM_1648205555995'] = $roistat_id;//
				$bx24->updateDeal($dealId, $fieldsDeal);
			}
			
		}
		
	}

}
