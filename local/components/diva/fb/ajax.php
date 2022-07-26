<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

class DivasoftFeedbackAjax extends Bitrix\Main\Engine\Controller {

    const IS_IBLOCK_FIELDS = ['NAME', 'CODE', 'PREVIEW_TEXT', 'DETAIL_TEXT', "MORE_PICTURE"];

    private $mapProperties = [];

    /*
     * Проверка post запроса + сессии, рекапча
     */

    protected function getDefaultPreFilters() {
        return [
            new Bitrix\Main\Engine\ActionFilter\HttpMethod(
                    array(Bitrix\Main\Engine\ActionFilter\HttpMethod::METHOD_POST)
            ),
            new Bitrix\Main\Engine\ActionFilter\Csrf(),
                new DivasoftRecaptcha(), // /local/php_interface/classes/divasoft/DivasoftRecaptcha.class.php
        ];
    }

    private function create_map_props() {
        \Bitrix\Main\Loader::includeModule('iblock');
        $this->mapProperties = [];
        $res = CIBlock::GetProperties($this->arParams['IBLOCK_ID'], Array(), []);
        while ($res_arr = $res->Fetch()) {
            $this->mapProperties[$res_arr['CODE']]['TYPE'] = $res_arr['PROPERTY_TYPE'];
            if ($res_arr['PROPERTY_TYPE'] == "L") {
                $db_enum_list = CIBlockProperty::GetPropertyEnum($res_arr['ID'], Array(), Array("IBLOCK_ID" => $res_arr['IBLOCK_ID']));
                while ($ar_enum_list = $db_enum_list->GetNext()) {
                    $this->mapProperties[$res_arr['CODE']]['VAL_ID'][$ar_enum_list['VALUE']] = $ar_enum_list['ID'];
                }
            }
        }
    }

    /**
     * Обрабатываем запрос
     * @param string $f - Набор полей из формы
     * @param string $uid - идентификатор формы
     * @return array
     */
    public function sendAction($f = [], $uid = false) {
        // TODO: b24
        if ($uid && isset($_SESSION["rc_" . $uid])) {
            $this->arParams = json_decode($_SESSION["rc_" . $uid], true);
            // Проверка и формирование полей
            $arEventFields = [];
            foreach ($this->arParams['FIELDS'] as $formFieldName) {
                $fieldReq = (stristr($formFieldName, "*") !== false);
                $formFieldName = str_replace("*", "", $formFieldName);

                // Проверка на заполнение полей
                if ($f[$formFieldName] == "" && $fieldReq) {
                    $this->error("Заполните все поля");
                }

                $arEventFields[$formFieldName] = $f[$formFieldName];
            }
            // Добавление в инфоблок
            if ($this->arParams['IBLOCK_ID']) {
                global $USER;
                \Bitrix\Main\Loader::includeModule('iblock');
                $this->create_map_props();

                $el = new CIBlockElement;

                $arLoadProductArray = Array(
                    "CREATED_BY" => $USER->GetID(),
                    "IBLOCK_ID" => $this->arParams['IBLOCK_ID'],
                    "ACTIVE" => "N"
                );

                // NAME Обязательно должен быть.
                if ($arEventFields[self::IS_IBLOCK_FIELDS[0]] == "") {
                    $arEventFields[self::IS_IBLOCK_FIELDS[0]] = "Элемент";
                }
                foreach ($arEventFields as $code => $value) {
                    if (in_array($code, self::IS_IBLOCK_FIELDS)) {
                        if ($code == "MORE_PICTURE") {
                            if (!empty($_FILES["f"])) {
                                foreach ($_FILES["f"]['size']["MORE_PICTURE"] as $key => $size) {
                                    move_uploaded_file($_FILES["f"]['tmp_name']["MORE_PICTURE"][$key], $_SERVER["DOCUMENT_ROOT"] . '/upload/' . $_FILES["f"]['name']["MORE_PICTURE"][$key]);

                                    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/" . $_FILES["f"]['name']["MORE_PICTURE"][$key]);
                                    $fileSave = CFile::SaveFile(
                                                    $arFile,
                                                    '/',
                                                    false,
                                                    false
                                    );
                                    $arLoadProductArray["PROPERTY_VALUES"]["MORE_PICTURE"][] = $arFile;
                                }
                            } else {
                                foreach ($value as $key => $val) {
                                    $data = json_decode($val, true);

                                    $data = $data["output"]["image"];

                                    $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));

                                    $imgId = file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/upload/imgbs64' . $key . '.jpeg', $data);

                                    $arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"] . "/upload/imgbs64" . $key . ".jpeg");
                                    $fileSave = CFile::SaveFile(
                                                    $arFile,
                                                    '/',
                                                    false,
                                                    false
                                    );
                                    $arLoadProductArray["PROPERTY_VALUES"]["MORE_PICTURE"][] = $arFile;
                                }
                            }
                        } else {
                            $arLoadProductArray[$code] = $value;
                        }
                    } else {
                        if ($this->mapProperties[$code]['TYPE'] == 'L') { // Тип список
                            $arLoadProductArray['PROPERTY_VALUES'][$code]['VALUE'] = $this->mapProperties[$code]['VAL_ID'][$value];
                        } else {
                            $arLoadProductArray['PROPERTY_VALUES'][$code] = $value;
                        }
                    }
                }
                if ($ELEMENT_ID = $el->Add($arLoadProductArray)) {
                    $arEventFields["HREF"] = "<br/>Ссылка на управление: <a href=\"http://{$_SERVER['SERVER_NAME']}/bitrix/admin/iblock_element_edit.php?IBLOCK_ID={$this->arParams['IBLOCK_ID']}&type={$this->arParams['IBLOCK_TYPE']}&ID=$ELEMENT_ID&lang=ru&find_section_section=-1&WF=Y\" target=\"_blank\">Открыть</a>";
                } else {
                    $this->error(getMessage('MESSAGE_NOT_ADDED') . $el->LAST_ERROR);
                    //return $this->msg("Ошибка: " . $el->LAST_ERROR, false);
                }
            }

            // Уведомление администратору
            if ($this->arParams['EMAIL_TO'] && $this->arParams['EVENT_MESSAGE_ID']) {
                $arEventFields["EMAIL_TO"] = $this->arParams['EMAIL_TO'];
                $arEventFields['DOC'] = CFile::GetPath($fileSave);
                if (CEvent::Send($this->arParams['EVENT_MESSAGE_ID'], SITE_ID, $arEventFields)) {
                    return $this->msg(getMessage('SUCCESS_SEND'));
                } else {
                    $this->error(getMessage('ERROR_SEND'));
                }
            }

            return $this->msg(getMessage('SUCCESS_SAVE'));
        } else {
            $this->error(getMessage('ERROR'));
        }
    }

    private function error($msg) {
        throw new Exception($msg);
    }

    public function msg($msg, $redirect = false) {
        return ["message" => $msg, 'redirect' => $redirect];
    }

}
