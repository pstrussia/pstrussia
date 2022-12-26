<?php

\Bitrix\Main\EventManager::getInstance()->addEventHandler('main', 'OnBeforeEventAdd', ['DivasoftEvent', 'OnBeforeEventAddHandler']);
\Bitrix\Main\EventManager::getInstance()->addEventHandler('main', 'OnBeforeEventSend', ['DivasoftEvent', 'OnBeforeEventSendHandler']);

require_once __DIR__ . '/DivasoftRecaptcha.class.php'; // Рекапча
require_once __DIR__ . '/DivasoftEvent.class.php'; // Рекапча
require_once __DIR__ . '/b24/integration.class.php'; // интеграция с b24
require_once __DIR__ . '/b24/b24classes.php'; // интеграция c b24
require_once __DIR__ . '/models.php'; // Работа с марками и моделями
require_once __DIR__ . '/DH.class.php'; // Рекапча
require_once __DIR__ . '/dadata.php'; 
require_once __DIR__ . '/partner.php';
require_once __DIR__ . '/orm/propertyElement.php';
require_once __DIR__ . '/OEM.php';

\Bitrix\Main\EventManager::getInstance()->addEventHandler("sale", "OnSaleComponentOrderCreated", ['DivasoftEvent', 'OnSaleComponentOrderCreatedHandler']);
\Bitrix\Main\EventManager::getInstance()->addEventHandler('', 'PartneryOnBeforeAdd', ['DivasoftEvent', 'PartneryHandler']);
\Bitrix\Main\EventManager::getInstance()->addEventHandler('', 'PartneryOnBeforeUpdate', ['DivasoftEvent', 'PartneryHandler']);
//\Bitrix\Main\EventManager::getInstance()->addEventHandler('sale', 'OnSaleOrderSaved', ['DivasoftEvent', 'OnSaleOrderSavedHandler']);
\Bitrix\Main\EventManager::getInstance()->addEventHandler('main', 'OnBeforeUserAdd', ['DivasoftEvent', 'OnBeforeUserAddHandler']);


\Bitrix\Main\EventManager::getInstance()->addEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("TestClass", "OnBeforeIBlockElementAddHandler"));
\Bitrix\Main\EventManager::getInstance()->addEventHandler("iblock", "OnAfterIBlockElementAdd", Array("TestClass", "OnBeforeIBlockElementAddHandler"));

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'catalog', 
	'OnProductUpdate', 
	 '["ProductonAfterUpdate"]'
);

\Bitrix\Main\EventManager::getInstance()->addEventHandler(
	'catalog', 
	'OnProductAdd', 
	 '["ProductonAfterUpdate"]'
);

function ProductonAfterUpdate($arg1, $arg2 = false)
    {
    	    //	a2l($arg1);
		//a2l($arg2);
		
		
		//$new = $arg1;
        //OEM::make($new);
    }

class TestClass
{
    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
    	//$new = $arFields;
        //OEM::make($new);
    }
}



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
