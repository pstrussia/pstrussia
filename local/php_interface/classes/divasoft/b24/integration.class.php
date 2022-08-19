<?php

class integrationB24 {
	
	private static  $IN_DOMAIN = 'pstrussia.bitrix24.ru';
	private static  $IN_TOKEN = 'wgrs93os4d8odfy7';
	private static  $IN_USER = '1';
	
	
	//провтановка roistat_id в свойство заказа
	function OnSaleOrderBeforeSavedHandler(\Bitrix\Main\Event $event) {
		
		$roistat_id = self::getRoistatVisit();
		
		if ($roistat_id) {
			
			$order = $event->getParameter("ENTITY");
			$propertyCollection = $order->getPropertyCollection();
			
			foreach ($propertyCollection as $propertyItem) {
				if (!empty($propertyItem->getField("CODE")) && $propertyItem->getField("CODE") == 'ROISTAT_ID') {
					$propertyItem->setField("VALUE", $roistat_id);
					break;
				}
			}
			
		}

	}
		
	
	//отправка форм в bitrix24
	function OnBeforeEventSendHandler($arFields) {
		
		//Задать вопрос
		if ($arFields['HEADER'] == 'Задать вопрос') {
			self::zadatvopros($arFields);
		}
		
		//В наличии
		if ($arFields['HEADER'] == 'Детальная страница товара, кнопка "Под заказ"') {
			self::nalishie($arFields);
		}
		
		
		//выкуп реек
		if (strpos($_SERVER['HTTP_REFERER'], 'redemption') !== false) {
			self::vikup($arFields);
		}

    }
	
	
	public static function vikup ($arFields = []) {
		
		//ВЫКУП РЕЕК
		$contactField['NAME'] = $arFields['NAME'];
		$contactField['PHONE_WORK'] = $arFields['TELEPHONE'];
		$contactField['EMAIL_WORK'] = $arFields['MAIL'];
		
		$fieldsDeal['TITLE'] = 'Форма Выкуп Реек';
		$fieldsDeal['UF_CRM_1617027948152'] = $arFields['CODE'];//марка модель год
		$fieldsDeal['UF_CRM_1643100939292'] = $arFields['CITY'];//Город
		$fieldsDeal['UF_CRM_1658906618090'] = 622;//вид формым 620 - уточнить наличие или 622 - выкуп рейки или 628 - задать вопрос
		
		if ($arFields['DOC']) {
			$fieldsDeal['UF_CRM_1658994589300'] = $_SERVER['HTTP_ORIGIN'] . $arFields['DOC'];
		}
		
		$fieldsDeal['COMMENTS'] = $arFields['DESCRIPTION'];
		
		self::send($contactField, $fieldsDeal);
		
	}
	
	public static function zadatvopros ($arFields = []) {
		
		//ЗАДАТЬ ВОПРОС
		$contactField['NAME'] = $arFields['NAME'];
		$contactField['PHONE_WORK'] = $arFields['PHONE'];
		$contactField['EMAIL_WORK'] = $arFields['EMAIL'];
		
		$fieldsDeal['TITLE'] = $arFields['HEADER'];
		$fieldsDeal['COMMENTS'] = $arFields['TEXT'];
		$fieldsDeal['UF_CRM_1658906618090'] = 628;//вид формым 620 - уточнить наличие или 622 - выкуп рейки или 628 - задать вопрос
		
		self::send($contactField, $fieldsDeal);
		
	}
	
	public static function nalishie ($arFields = []) {
		
		//НАЛИЧИЕ
		$contactField['NAME'] = $arFields['NAME'];
		$contactField['PHONE_WORK'] = $arFields['PHONE'];
		$contactField['EMAIL_WORK'] = $arFields['EMAIL'];
		
		$fieldsDeal['TITLE'] = $arFields['HEADER'];
		$fieldsDeal['COMMENTS'] = $arFields['TEXT'];
		$fieldsDeal['UF_CRM_1658990736'] = $arFields['URL'];//Товар из уточнения
		$fieldsDeal['UF_CRM_1658906618090'] = 620;//вид формым 620 - уточнить наличие или 622 - выкуп рейки или 628 - задать вопрос

		self::send($contactField, $fieldsDeal);
		
	}
	
	public static function send ($fieldsContact, $fieldsDeal) {
		
		$bx24 = new Bitrix24(self::$IN_DOMAIN, self::$IN_USER, self::$IN_TOKEN);

		if(!empty($fieldsContact['PHONE_WORK'])){
			$arResultDuplicate = $bx24->getDuplicate('CONTACT', 'PHONE', [$fieldsContact['PHONE_WORK']]);
			if(!empty($arResultDuplicate['result']['CONTACT'])){
				$arContactDuplicate = $arResultDuplicate['result']['CONTACT'][0];
			}
		}
		
		if(!empty($fieldsContact['EMAIL']) && !$arContactDuplicate) {
			$arResultDuplicate = $bx24->getDuplicate('CONTACT', 'EMAIL', [$fieldsContact['EMAIL_WORK']]);
			if(!empty($arResultDuplicate['result']['CONTACT'])){
				$arContactDuplicate = $arResultDuplicate['result']['CONTACT'][0];
			}
		}
		
		if ($arContactDuplicate) {
			$fieldsDeal['CONTACT_ID'] = $arContactDuplicate;
		} else {
			
			$Contact = $bx24->createContact($fieldsContact);
			if ($Contact['result']) {
				$fieldsDeal['CONTACT_ID'] = $Contact['result'];
			}
		}
		
		$fieldsDeal['UF_CRM_1648205555995'] = self::getRoistatVisit();//roistat_id
		
		$deal = $bx24->createDeal($fieldsDeal);
		
		
	}
	
	public static function getRoistatVisit() {
		
		if (!empty($_COOKIE['roistat_visit'])) {
			return $_COOKIE['roistat_visit'];
		} else {
			return false;
		}

	}
		
}