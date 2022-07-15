<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>


<div class="container">
    <div class="terms">
    
        <div class="terms__banner">
            <img src="/images/terms-bg.jpg" alt="alt">
        </div>
    <?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include/delivery/content.php", array(), array("MODE" => "html", "NAME" => "content", "TEMPLATE" => "content.php"));?>
       
    
    </div>
</div>


<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>