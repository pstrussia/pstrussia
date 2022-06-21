<?php

namespace Dvs\Exchange1c\Catalog;

class Controller {

    protected static $traitsPropID;

    public static function run() {
        $eventManager = \Bitrix\Main\EventManager::getInstance();
        $eventManager->addEventHandler(
                'iblock', 'OnBeforeIBlockElementUpdate',
                [__CLASS__, 'onBeforeIBlockElementUpdateHandler']
        );
    }

    public static function onBeforeIBlockElementUpdateHandler(&$arFields) {
        if (!static::isUpdateFrom1c())
            return;
        $file = $_REQUEST['filename'];
        if ($file && explode('__', $file)[0] == 'import') {
            $arArticles = Articles::getFromTraits($arFields);
            foreach ($arArticles as $prop_id => $arArticle)
                $arFields['PROPERTY_VALUES'][$prop_id] = $arArticle;
        }
    }

    protected static function isUpdateFrom1c() {
        global $APPLICATION;
        if ($_REQUEST['mode'] == 'import' && $_REQUEST['type'] == 'catalog')
            return $APPLICATION->GetCurPage() == '/bitrix/admin/1c_exchange.php';
        return false;
    }

}
