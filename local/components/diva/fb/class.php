<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

class DivasoftFeedback extends CBitrixComponent {

    public function onPrepareComponentParams($arParams) {
        $uid = (($arParams["UID"]) ? $arParams["UID"] : md5(rand()));
        $result = array(
            "EVENT_MESSAGE_ID" => $arParams["EVENT_MESSAGE_ID"],
            "EMAIL_TO" => $arParams["EMAIL_TO"],
            "PRODUCT_ID" => $arParams["PRODUCT_ID"],
            "FIELDS" => $arParams["FIELDS"],
            "IBLOCK_ID" => intval($arParams["IBLOCK_ID"]),
            "UID" => $uid,
            "UID_FORM" => "f_" . $uid,
            "UID_RC" => "rc_" . $uid,
            "UID_CB" => "cb_" . $uid
        );
        return $result;
    }

    public function executeComponent() {
        $_SESSION["rc_" . $this->arParams['UID']] = json_encode($this->arParams);
        $this->includeComponentTemplate();
    }

}
