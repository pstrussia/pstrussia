<?
$site_id = trim($_POST["site_id"]);

if(strlen($site_id) > 0)
    define("SITE_ID", htmlspecialchars($site_id));
else
    die();

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

$arResult = array();

if($_POST["send"] == "Y")
{
    CModule::IncludeModule("concept.phoenix");
    global $PHOENIX_TEMPLATE_ARRAY;
    CPhoenix::setMainMess();

    $login = trim($_POST["login"]);
    $password = trim($_POST["password"]);

    if(trim(SITE_CHARSET) == "windows-1251")
    {
        $login = utf8win1251($login);
        $password = utf8win1251($password);
    }
    
    $no_user = false;
    $rsUser = CUser::GetByLogin($login);
    
    if(!$arUser = $rsUser->Fetch())
    {
        $email_partner = Partner::getEmailByCode($login);
        $rsUser = CUser::GetByLogin($email_partner);
        
        if ($arUser = $rsUser->Fetch()) 
        {
            $login = $arUser["LOGIN"];
        }
        else
        {
            $phone = preg_replace('![^0-9+]!', '', $login);
            $phone1 = preg_replace('![^0-9]+!', '', $login);

            $rsUser = CUser::GetList( 
                ($by="id"),
                ($order="desc"),
                array("PERSONAL_MOBILE" => $phone." | ".$phone1)
            );

            if($arUser = $rsUser->Fetch())
            {
                if($arUser["PERSONAL_MOBILE"] == $phone || $arUser["PERSONAL_MOBILE"] == $phone1)
                    $login = $arUser["LOGIN"]; 
                else
                    $no_user = true;
            }
            else
                $no_user = true;
        }
    }

    if($no_user)
    {
        $er = $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_ERROR_EMPTY"];
        
        if(trim(SITE_CHARSET) == "windows-1251")
            $er = iconv('windows-1251', 'UTF-8', $er);

        $arResult["OK"] = "N";
        $arResult["ERROR"] = $er;
    }
    else
    {   

        $id = $arUser["ID"];
        global $USER;
        if (!is_object($USER)) $USER = new CUser;
        $arAuthResult = $USER->Login($login, $password, "Y");
        
        if($arAuthResult["TYPE"] == "ERROR")
        {
            $er = $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_ERROR_PASSWORD"];

            if(trim(SITE_CHARSET) == "windows-1251")
                $er = iconv('windows-1251', 'UTF-8', $er);

            $arResult["OK"] = "N";
            $arResult["ERROR"] = $er;
        }
        else
        {
            $arResult["OK"] = "Y";
            $USER->Authorize($id, true);
        }
        
    }
}

$arResult = json_encode($arResult);
echo $arResult;
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>