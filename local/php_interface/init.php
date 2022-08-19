<?php
require_once __DIR__ . '/classes/divasoft/divasoft.loader.php'; // 


function cl_print_r($var, $label = '') {
    $str = json_encode(print_r($var, true));
    echo "<script>console.group('" . $label . "');console.log('" . $str . "');console.groupEnd();</script>";
}

function a2l($sText, $title = '', $file = "all.log", $prepostfix = true) {
	//if ($_REQUEST['mode']=='import') {
	$date = date("d/m/Y H:i:s");
	if (!is_string($sText)) {
		$sText = print_r($sText, true);
	}
	if ($prepostfix) {
		$sText = "********    " . $title . " " . $date . " BEGIN LOG    ********\n" . $sText;
		$sText .= "\n********    " . $date . " END LOG    ********\n";
	}

	file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/local/logs/" . $file, $sText, FILE_APPEND);
	return true;
}


//событие для отправки форм в bitrix24
\Bitrix\Main\EventManager::getInstance()->addEventHandler( 
    'main', 
    'OnBeforeEventSend', 
	[
		'integrationB24',
		'OnBeforeEventSendHandler',
	]
); 

//событие для вставки roistat_id в заказ
\Bitrix\Main\EventManager::getInstance()->addEventHandler( 
    'sale', 
    'OnSaleOrderBeforeSaved', 
	[
		'integrationB24',
		'OnSaleOrderBeforeSavedHandler',
	]
); 