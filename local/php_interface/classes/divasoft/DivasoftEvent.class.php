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
//        $date = new DateTime();
//        $date->modify("+5 seconds");
//        CAgent::AddAgent("DH::test('s1','ru');", "", "N", 1200, $date->format("d.m.Y H:i:s"), 'Y', $date->format("d.m.Y H:i:s"));
        return true;
    }

    function OnBeforeEventSendHandler(&$arFields, &$arTemplate, $context) {
//        a2l($arFields);
    }

}
