<?php

namespace Dvs\Exchange1c\Catalog;

class Articles {

    protected static $arPropsIDs = [];

    public static function getFromTraits($arFields) {
        if (empty($arFields['IBLOCK_ID']))
            return [];
        $traitsID = static::getPropIdByCode($arFields['IBLOCK_ID'], 'CML2_TRAITS');
        $articlesID = static::getPropIdByCode($arFields['IBLOCK_ID'], 'ARTICLES_1C');
        $altArtilesID = static::getPropIdByCode($arFields['IBLOCK_ID'], 'ALT_ARTICLES_1C');
        if ($traitsID && isset($arFields['PROPERTY_VALUES'][$traitsID]) &&
                ($articlesID || $altArtilesID)) {
            $arTriats = $arFields['PROPERTY_VALUES'][$traitsID];
            $strArticles = static::getFromTraitsByDescription($arTriats, 'АртикулыДляСайта');
            $strAltArticles = static::getFromTraitsByDescription($arTriats, 'АльтАртикулыДляСайта');
            if ($strArticles)
                $result[$articlesID] = self::strArticlesToArray($strArticles);
            if ($strAltArticles)
                $result[$altArtilesID] = self::strArticlesToArray($strAltArticles);
        }
        return $result ?? [];
    }

    protected static function getPropIdByCode($iblockID, $code) {
        if (!isset(static::$arPropsIDs[$iblockID][$code])) {
            \Bitrix\Main\Loader::includeModule('iblock');
            $arFilter = ['ACTIVE' => "Y", 'IBLOCK_ID' => $iblockID, 'CODE' => $code];
            $properties = \CIBlockProperty::GetList([], $arFilter);
            if (($prop_fields = $properties->GetNext()))
                static::$arPropsIDs[$iblockID][$code] = $prop_fields["ID"];
        }
        return static::$arPropsIDs[$iblockID][$code];
    }

    protected static function getFromTraitsByDescription($arTraits, $desc) {
        foreach ($arTraits as $arItem) {
            if ($arItem['DESCRIPTION'] == $desc)
                return $arItem['VALUE'];
        }
        return false;
    }

    protected static function strArticlesToArray($string) {
        $result = $arArticles = [];
        foreach (explode(';', trim($string, '; ')) as $valDesc) {
            [$value, $description] = explode(':', $valDesc);
            $arArticles[] = [
                'VALUE' => trim($value),
                'DESCRIPTION' => trim($description),
            ];
        }
        foreach ($arArticles as $key => $arProp)
            $result["n$key"] = $arProp;
        return $result;
    }

}
