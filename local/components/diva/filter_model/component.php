<?php
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class FilterModel extends CBitrixComponent
{
    protected $errors = array();

    public function onPrepareComponentParams($arParams)
    {
    	//$this->arParams = $arParams;
		
    }

    public function executeComponent()
    {echo '<pre>'; print_r($this->arParams); '</pre>';
        try
        {
            $this->checkModules();
            $this->getResult();
            $this->includeComponentTemplate();
        }
        catch (SystemException $e)
        {
            ShowError($e->getMessage());
        }
    }

    protected function checkModules()
    {
        if (!Loader::includeModule('iblock'))
            throw new SystemException(Loc::getMessage('CPS_MODULE_NOT_INSTALLED', array('#NAME#' => 'iblock')));
    }

    protected function prepareDate(&$arItem) {


    }

    protected function getResult()
    {

    }
}