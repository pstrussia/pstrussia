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
	
	function OnSaleComponentOrderCreatedHandler($order, &$arUserResult, $request, &$arParams, &$arResult, &$arDeliveryServiceAll, &$arPaySystemServiceAll){
		$flag = false;
		if($post_params = $request->getPost("order"))
		{
			if($post_params["DELIV_PAY_LATER"])
				$flag = true;
		}
		elseif($request->getPost("DELIV_PAY_LATER"))
		{
			$flag = true;
		}
		
		if($request->getPost("action") == "saveOrderAjax")
		{
			$order_props = Partner::getOrderProps($order->getPersonTypeId());
			$propertyCollection = $order->getPropertyCollection();
			
			if($flag)
			{
				$property = $propertyCollection->getItemByOrderPropertyId($order_props["DELIV_PAY_LATER"]["ID"]);
				$property->setValue("Y");
				
				//$property = $propertyCollection->getItemByOrderPropertyId($order_props["DELIVERY_PRICE"]["ID"]);
				//$property->setValue("0.0000");
			}
			else
			{
				$property = $propertyCollection->getItemByOrderPropertyId($order_props["DELIV_PAY_LATER"]["ID"]);
				$property->setValue("N");
				
				$property = $propertyCollection->getItemByOrderPropertyId($order_props["DELIVERY_PRICE"]["ID"]);
				$property->setValue($order->getDeliveryPrice());
			}
			
		}
		
		if($flag)
		{
			$shipmentCollection = $order->getShipmentCollection();
			foreach ($shipmentCollection as $item){
				if(!$item->isSystem())
				{
					$item->setBasePriceDelivery(0);
				}
			}
		}
	}

	public static function OnBeforeUserAddHandler(&$arFields) {
	  if($arFields['EXTERNAL_AUTH_ID'] == "sale")
	  {
	   	  if($arFields['LOGIN'] != $arFields['EMAIL'])
		  	$arFields['LOGIN'] = $arFields['EMAIL'];
		  
		  $arFields['EXTERNAL_AUTH_ID'] = "";
		   
		  $arFields['GROUP_ID'] = Partner::getGroup(["UF_PFPOCHTA" => $arFields["EMAIL"], "REG" => "Y"]);
		  
		  $item['LOGIN'] = $arFields['EMAIL'];
          $item['PASSWORD'] = $arFields['PASSWORD'];
		  $item['EMAIL'] = $arFields['EMAIL'];
		  $item['EMAIL_TO'] = $arFields['EMAIL'];
		  $item['SITE_URL'] = "https://pstrussia.ru";
		  $item['SITENAME'] = "PST Service Russia";

		  $mess = \Bitrix\Main\Mail\Event::send([    
		    "EVENT_NAME" => "PHOENIX_SEND_REG_SUCCESS_s1",
		    "C_FIELDS" => $item,
		    "LID" => "s1",
		  ]);
	  }
   }
} 
