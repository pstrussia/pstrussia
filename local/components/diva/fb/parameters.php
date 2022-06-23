<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if (!\Bitrix\Main\Loader::includeModule("iblock"))
    return;
// Типы инфоблоков
$arTypesEx = CIBlockParameters::GetIBlockTypes(Array("all" => " "));

// Инфоблоки определённого типа, или все.
$arIBlocks = Array();
$db_iblock = CIBlock::GetList(Array("SORT" => "ASC"), Array("SITE_ID" => $_REQUEST["site"], "TYPE" => ($arCurrentValues["IBLOCK_TYPE"] != "all" ? $arCurrentValues["IBLOCK_TYPE"] : "")));
while ($arRes = $db_iblock->Fetch())
    $arIBlocks[$arRes["ID"]] = $arRes["NAME"];

// Список типов EMAIL шаблонов
$arEvent = Array(''=>'Не отправлять');
$dbType = CEventMessage::GetList($by = "ID", $order = "DESC", $arFilter);
while ($arType = $dbType->GetNext()) { //print_r($arType);
    $arEvent[$arType["EVENT_NAME"]] = "[" . $arType["ID"] . "] [{$arType["EVENT_NAME"]}] " . $arType["SUBJECT"];
}

$arComponentParameters = array(
    "GROUPS" => array(
    ),
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => Array(
            "PARENT" => "BASE",
            "NAME" => "Тип инфоблока",
            "TYPE" => "LIST",
            "VALUES" => $arTypesEx,
            "DEFAULT" => "catalog",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => Array(
            "PARENT" => "BASE",
            "NAME" => "Инфоблок",
            "TYPE" => "LIST",
            "VALUES" => $arIBlocks,
            "DEFAULT" => '1',
            "MULTIPLE" => "N",
            "ADDITIONAL_VALUES" => "N",
            "REFRESH" => "Y",
        ),
        "UID" => Array(
            "PARENT" => "BASE",
            "NAME" => "Уникальный идентификатор",
            "TYPE" => "STRING",
            "DEFAULT" => md5(rand()),
            "MULTIPLE" => "N",
        ),
        "FIELDS" => Array(
            "PARENT" => "BASE",
            "NAME" => "Список обрабатываемых полей",
            "TYPE" => "STRING",
            "DEFAULT" => ['NAME','CODE','DETAIL_TEXT'],
            "MULTIPLE" => "Y",
        ),
        "EVENT_MESSAGE_ID" => Array(
            "NAME" => "Тип почтового сообщения",
            "TYPE" => "LIST",
            "VALUES" => $arEvent,
            "DEFAULT" => "CALLBACK",
            "MULTIPLE" => "N",
            "COLS" => 25,
            "PARENT" => "BASE",
            "REFRESH" => "Y",
        )
    ),
);

if ($arCurrentValues["EVENT_MESSAGE_ID"] != "") {
    $arComponentParameters["PARAMETERS"]["EMAIL_TO"] = [
        "NAME" => "Отправлять уведомления на email",
        "TYPE" => "STRING",
        "DEFAULT" => "",
        "PARENT" => "BASE"
    ];
}
