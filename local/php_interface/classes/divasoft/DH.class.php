<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DH {

    static function clearImagesCatalog() {
        if (CModule::IncludeModule("iblock")):
            $arLoadProductArray = Array(
                "PREVIEW_PICTURE" => array('del' => 'Y'),
                "DETAIL_PICTURE" => array('del' => 'Y'),
            );
            $res = CIBlockElement::GetList(
                            Array("ID" => "ASC"),
                            Array("IBLOCK_ID" => CATALOG_IBLOCK, ['LOGIC' => 'OR', '!PREVIEW_PICTURE' => false, '!DETAIL_PICTURE' => false, '!PROPERTY_MORE_PHOTO' => false]),
                            false,
                            false,
                            Array('ID', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO')
            );
            $el = new CIBlockElement;
            $result = [];
            while ($arItem = $res->GetNext()) {
//                print_r($arItem);
                $result[$arItem['ID']][] = $arItem;
                $PRODUCT_ID = $arItem['ID'];
                $el->SetPropertyValuesEx(
                        $arItem['ID'],
                        $IBLOCK_ID,
                        array('MORE_PHOTO' => array('VALUE' => array("del" => "Y")))
                );
                $resU = $el->Update($PRODUCT_ID, $arLoadProductArray);
//                break;
            }
        endif;
//        return $result;
        return "DH::clearImagesCatalog();";
    }

}
