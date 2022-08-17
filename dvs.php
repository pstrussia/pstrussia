<?

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

//if (CModule::IncludeModule("iblock")):
//    $IBLOCK_ID = 14;
//    $arLoadProductArray = Array(
//        "PREVIEW_PICTURE" => array('del' => 'Y'),
//        "DETAIL_PICTURE" => array('del' => 'Y'),
//    );
//    $res = CIBlockElement::GetList(
//                    Array("ID" => "ASC"),
//                    Array("IBLOCK_ID" => $IBLOCK_ID, ['LOGIC' => 'OR', '!PREVEIW_PICTURE' => false, '!DETAIL_PICTURE' => false, '!PROPERTY_MORE_PHOTO' => false]),
//                    false,
//                    false,
//                    Array('ID', 'NAME', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_MORE_PHOTO')
//    );
//    $el = new CIBlockElement;
//    while ($arItem = $res->GetNext()) {
//print_r($arItem);
//        $PRODUCT_ID = $arItem['ID'];

//        $el->SetPropertyValuesEx(
//                $arItem['ID'],
//                $IBLOCK_ID,
//                array('MORE_PHOTO' => array('VALUE' => array("del" => "Y")))
//        );

//        $resU = $el->Update($PRODUCT_ID, $arLoadProductArray);
//    }

//endif;

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>

