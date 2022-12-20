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
                            Array("IBLOCK_ID" => CATALOG_IBLOCK, ['LOGIC' => 'OR', '!PREVEIW_PICTURE' => false, '!DETAIL_PICTURE' => false, '!PROPERTY_MORE_PHOTO' => false]),
                            false,
                            false,
                            Array('ID', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO')
            );
            $el = new CIBlockElement;
            while ($arItem = $res->GetNext()) {
//                print_r($arItem);
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
        return "";//DH::clearImagesCatalog();
    }

   static function makeFileArticleUrl($id)
   {
       if(!$id)
            return false;
       
       $section_id = [$id];
       
       $sections = \Bitrix\Iblock\SectionTable::getList(
            [
                'select' => array('NAME'),
                'filter' => array('IBLOCK_ID' => 14, 'ID' => $section_id),
            ]
        );

        while ($row = $sections->fetch()) {
                $sec_name = $row["NAME"];
        }
       
       $sections = \Bitrix\Iblock\SectionTable::getList(
            [
                'select' => array('ID'),
                'filter' => array('IBLOCK_ID' => 14, 'IBLOCK_SECTION_ID' => $section_id),
            ]
        );

        while ($row = $sections->fetch()) {
            $subsecid[] = $row["ID"];
        }
       
       if($subsecid)
       {
           $section_id = array_merge($section_id, $subsecid);
           
       }
        
       $elements = \Bitrix\Iblock\Elements\ElementCatalogTable::getList([
            'select' => ['ID', 'NAME', 'IBLOCK_ID', 'IBLOCK_SECTION_ID', 'CODE', 'IBLOCK_SECTION', 'ARTICLES_1C'],
            'filter' => [
                'IBLOCK_SECTION_ID' => $section_id,
            ],
        ])->fetchCollection();

        $arResult = [];

        foreach ($elements as $element) {
            $id = $element->Get('ID');
            $ib_id = $element->Get('IBLOCK_ID');
            $sec_id = $element->Get('IBLOCK_SECTION_ID');
            $code = $element->Get('CODE');

            $arItem = [
                "ID" => $id,
                "IBLOCK_ID" => $ib_id,
                "IBLOCK_SECTION_ID" => $sec_id,
                "CODE" => $code,
            ];

            $url = CIBlock::ReplaceDetailUrl("#SITE_DIR#/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/", $arItem, false, 'E');
            $url = "https://pstrussia.ru{$url}";

            $arResult[$id]["URL"] = $url;


            foreach ($element->Get('ARTICLES_1C')->getAll() as $value) {
                if(true)//$value->getDescription() == "CROSS_All"
                {
                    $arResult[$id]["ARTICLE"][] = $value->getValue();
                }
            }
        }
        
        if(!$sec_name)
            $sec_name = $id;
        
        $filename = $_SERVER["DOCUMENT_ROOT"]."/DVS_TEST/{$sec_name}.csv";
        
        $fp = fopen($filename, 'w');

        foreach ($arResult as $items) {
            foreach ($items["ARTICLE"] as $item) {
                $val  = [$item, $items["URL"]];
                fputcsv($fp, $val, "-");
            }
        }

        fclose($fp);
   }
}
