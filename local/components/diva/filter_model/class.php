<?php
use Bitrix\Main\SystemException;
use Bitrix\Main\Loader;
use Bitrix\Main\Error;
use Bitrix\Main\Errorable;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use CBitrixComponent;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

class FilterModel extends CBitrixComponent implements Controllerable
{
    protected $errors = array();

    public function onPrepareComponentParams($arParams)
    {
    	$params = FilterModel::prepareFilterParams();
		
		$arParams = array_merge($arParams, $params);
		
		return $arParams;
    }

	static function prepareFilterParams()
	{
		$props = [
    		"MARKA_AVTO" => ["NAME" => "Марка авто"],
    		"MODEL_AVTO" => ["NAME" => "Модель авто"],
    		"GOD_VYPUSKA" => ["NAME" => "Год выпуска"],
    		"KUZOV" => ["NAME" => "Кузов"],
    	];
		
		foreach ($props as $key => &$value)
		{
			$value["LOW"] = strtolower($key);
			$arParams["CATALOG_FILTER"][] = $key;
			$arParams["SM_PROPS"][$value["LOW"]] = "PROPERTY_{$key}";
		}
		
		$arParams["PROPS"] = $props;
		
		return $arParams;
	}
	
	public function configureActions()
    {
        return [
            'makeSmartUrl' => [ 
                'prefilters' => [],
            ],
        ];
    }

    public function makeSmartUrlAction($data = [], $section_code)
    {
    	$result = [];
		$link = "/catalog/{$section_code}/filter/#FILTER_PATH#/apply/";
		$link_clear = "/catalog/{$section_code}/";
		
		if(!empty($data))
		{
			foreach ($data as $key => $value)
			{
				//$value = rawurlencode($value);
				$result[] = "{$key}-is-{$value}";	
			}
			
			$link = str_replace("#FILTER_PATH#", implode("/", $result), $link);
		}
		else
		{
			$link = $link_clear;
		}
		
        return $link;
    }
	
	public function getFilterParams($SF_PATH = '', $stat = false)
	{
		if(empty($SF_PATH) && !$stat)
			$SF_PATH = $this->arParams["SMART_FILTER_PATH"];
		
		if (empty($SF_PATH))
			return [];
		
		$arParams = FilterModel::prepareFilterParams();
		
		if(!empty($SF_PATH))
		{
			$select_filter = [];
			$path = explode("/", $SF_PATH);
			
			foreach ($path as $key => $value)
			{
				$buf = explode("-is-", $value);
				
				if(!empty($arParams["SM_PROPS"][$buf[0]]))
				{
					$select_filter_catalog[$arParams["SM_PROPS"][$buf[0]]] = $buf[1];
					$select_filter_sm[$buf[0]] = $buf[1];
					if(!$stat)
					{
						$this->arParams["PROPS"][strtoupper($buf[0])]["SELECT"] = $buf[1];
						$this->arParams["SELECTED"][$buf[0]] = $buf[1];
					}
				} 
			}
		}
		
		if(!empty($select_filter_sm))
		{
			foreach ($select_filter_sm as $key => $value)
			{
				$result[] = "{$key}-is-{$value}";	
			}
			$select_filter_sm = "/".implode("/", $result);
		}
		else
		{
			$select_filter_sm = '';
		}
		//echo '<pre>'; print_r($select_filter); echo '</pre>';		
		return ["CATALOG" => $select_filter_catalog, "SM" => $select_filter_sm];
	}
	
    public function executeComponent()
    {
        try
        {
            $this->checkModules();
			$this->getFilterParams();
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
		if (!Loader::includeModule('highloadblock'))
            throw new SystemException(Loc::getMessage('CPS_MODULE_NOT_INSTALLED', array('#NAME#' => 'highloadblock')));
    }

    protected function getResult()
    {
		$modelId = [];
		
    	$elements = \Bitrix\Iblock\Elements\ElementCatalogTable::getList([
		    'select' => ["MODEL_ID"],
		    'filter' => ["IBLOCK_SECTION_ID" => $this->arParams["SECTION_ID"]/*, "ID" => 15490*/],
		])->fetchCollection();
		
		foreach ($elements as $element) {
			foreach ($element->getModelId()->getAll() as $value) {
				$val = $value->getValue();
				if(!in_array($val, $modelId))
					$modelId[] = $val;
		    }
	    }

		
		
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->arParams["HL"]["MARKA"])->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array('ID', 'UF_NAME', 'UF_XML_ID'),
			'order'  => array('UF_NAME' => 'ASC'),
		));
		
		$arMarka = [];
		
		while ($row = $resData->Fetch())
		{
			$arMarka[$row["UF_XML_ID"]] = $row["UF_NAME"];
		}
		
		$arHLBlock = \Bitrix\Highloadblock\HighloadBlockTable::getById($this->arParams["HL"]["MODEL"])->fetch();
		$obEntity = \Bitrix\Highloadblock\HighloadBlockTable::compileEntity($arHLBlock);
		$strEntityDataClass = $obEntity->getDataClass();
		$resData = $strEntityDataClass::getList(array(
			'select' => array('ID', 'UF_MODEL', 'UF_XML_ID', 'UF_KUZOV', 'UF_GODS', 'UF_GODDO', 'UF_VLADELETS'),
			'order'  => array('UF_MODEL' => 'ASC'),
			'filter' => array('UF_XML_ID' => $modelId)
		));
		
		$arModel = [];
		
		while ($row = $resData->Fetch())
		{
			
			$marka = ''; $model = ''; $god = ''; $kuzov = ''; $code = '';
			
			$model = strtolower(ucfirst(str_replace("/", "-", $row["UF_MODEL"])));
			$marka = strtolower(ucfirst(str_replace("/", "-", $arMarka[$row["UF_VLADELETS"]])));
			//$code = $marka."-".$model;
			$god = $row["UF_GODS"];
			if(!empty($row["UF_GODDO"]))
				$god .= '-'.$row["UF_GODDO"];
			$god = strtolower(str_replace("/", "-", $god));
			$kuzov = strtolower(str_replace("/", "-", $row["UF_KUZOV"]));
			
			if(empty($arResult["ITEMS"]["MARKA_AVTO"][$marka]))
			{
				$text = $arMarka[$row["UF_VLADELETS"]];
				$arResult["ITEMS"]["MARKA_AVTO"][$marka]["THIS"] = [
					"TEXT" => $text,
					"VALUE" => $marka, 
					"CODE" => $marka,
					"PROP_CODE" => $this->arParams["PROPS"]["MARKA_AVTO"]["LOW"]
				];
			}
			
			if(empty($arResult["ITEMS"]["MARKA_AVTO"][$marka]["CHILD"][$model]) && !empty($row["UF_MODEL"]))
			{
				$text = $row["UF_MODEL"];
				$arResult["ITEMS"]["MARKA_AVTO"][$marka]["CHILD"][$model]["THIS"] = [
					"TEXT" => $text,
					"VALUE" => $model, 
					"PARRENT" => $marka, 
					"CODE" => $model, 
					"PROP_CODE" => $this->arParams["PROPS"]["MODEL_AVTO"]["LOW"]
				];
			}

			if(!empty($god))
			{
				$text = $god;
				$arResult["ITEMS"]["MARKA_AVTO"][$marka]["CHILD"][$model]["CHILD"]["GOD_VYPUSKA"][] = [
					"THIS" => [
						"TEXT" => $text,
						"VALUE" => $god, 
						"PARRENT" => $model,
						"PROP_CODE" => $this->arParams["PROPS"]["GOD_VYPUSKA"]["LOW"]
					]
				];
			}
			
			if(!empty($kuzov))
			{
				$text = $row["UF_KUZOV"];
				$arResult["ITEMS"]["MARKA_AVTO"][$marka]["CHILD"][$model]["CHILD"]["KUZOV"][] = [
					"THIS" => [
						"TEXT" => $text,
						"VALUE" => $kuzov, 
						"PARRENT" => $model,
						"PROP_CODE" => $this->arParams["PROPS"]["KUZOV"]["LOW"]
					]
				];
			}
		}
		
		ksort($arResult["ITEMS"]["MARKA_AVTO"]);
		
		$arResult["SELECTED"] = $this->arParams["SELECTED"];
		
		$arResult['DEF_PAGE'] = "/catalog/{$this->arParams["SECTION_CODE"]}/";
		//echo '<pre>'; print_r($arResult["ITEMS"]); echo '</pre>';		
		$this->arResult = $arResult;
		
    }
}