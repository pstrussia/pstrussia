<?php

class DivasoftEvent {

    function OnBeforeEventAddHandler(&$event, &$lid, &$arFields, &$messageId, &$files, &$languageId) {
//        a2l($event); 
//        a2l($lid);
//        a2l($arFields);
//        a2l($messageId);
//        a2l($files); 
//        a2l($languageId);
//        a2l($arFields);
        // Временно
//        $arFieldsBuy = Array(
//            "EMAIL_TO" => $arFields['EMAIL_TO']
//        );
//        CEvent::Send("HOW_TO_BUY", $lid, $arFieldsBuy, "N", 0, false, $languageId);
//        if($event == 'SALE_SUBSCRIBE_PRODUCT'){
//        $date = new DateTime();
//        $date->modify("+5 seconds");
//        CAgent::AddAgent("DH::clearImagesCatalog();", "iblock", "N", 86400, $date->format("d.m.Y H:i:s"), 'Y', $date->format("d.m.Y H:i:s"));
//        }
        return true;
    }

    function OnBeforeEventSendHandler(&$arFields, &$arTemplate, $context) {
//        a2l($arFields);
    }
	
	
	function PartneryHandler(\Bitrix\Main\Entity\Event $event) {
	    $arFields = $event->getParameter("fields");
		
		Partner::setVidTsenyBySoglashenie($arFields);
	}
	
	function OnSaleOrderSavedHandler(\Bitrix\Main\Event $event) {
	    if(!$event->getParameter("IS_NEW"))
            return;
		
        $order = $event->getParameter("ENTITY");
		
		$order_props = Partner::getOrderProps($order->getPersonTypeId());
		$sogl = Partner::setSoglashenieByUserId($order->getUserId());
		$store = Partner::getStoreXmlId();
		
		$propertyCollection = $order->getPropertyCollection();
		
		$property = $propertyCollection->getItemByOrderPropertyId($order_props["SOGLASHENIE"]["ID"]);
		$property->setValue($sogl);
		
		$property = $propertyCollection->getItemByOrderPropertyId($order_props["STORE"]["ID"]);
		$property->setValue($store);
		
		$order->save();
	}
}
