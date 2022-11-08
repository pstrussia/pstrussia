<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?
    if($arParams["H_POSITION_IMAGE_BLOCK"] == "")
        $arParams["H_POSITION_IMAGE_BLOCK"] = "left";


    if($arParams["H_POSITION_IMAGE_BLOCK"] == "left")
    {
        $title_pos = "offset-sm-4";
        $position_hor = "order-sm-1";
    }

    if($arParams["H_POSITION_IMAGE_BLOCK"] == "right")
    {
        $title_pos = "";
        $position_hor = "order-sm-3";
    }
?>

<?if(!empty($arResult["ITEMS"])):?>
<?foreach($arResult["ITEMS"] as $arItem):?>
    <div class="empl-full">

    	<?CPhoenix::admin_setting($arItem, false)?>

    	<?if(strlen($arItem["PROPERTIES"]["EMPL_DESC"]["~VALUE"])>0):?>

            <div class="empl-desc col-lg-8 col-12 <?=$title_pos?>" title='<?=$arItem["PROPERTIES"]["EMPL_DESC"]["~VALUE"]?>'><?=$arItem["PROPERTIES"]["EMPL_DESC"]["~VALUE"]?></div>

        <?endif;?>

        <div class="empl-table row <?=($arParams["SIDEMENU"])? "no-margin":""?>">


            <div class="empl-cell col-sm-8 col-12 center order-2">

                <div class="empl-name bold"><?=$arItem["~NAME"]?></div>

                <?if(strlen($arItem["~PREVIEW_TEXT"])>0):?>
                    <div class="line main-color"></div>
                    <div class="empl-text"><?=$arItem["~PREVIEW_TEXT"]?></div>
                <?endif;?>

                <?if((strlen($arItem["PROPERTIES"]["EMPL_BTN_NAME"]["~VALUE"])>0 && strlen($arItem["PROPERTIES"]["EMPL_FORMS"]["~VALUE"])>0) || strlen($arItem["PROPERTIES"]["EMPL_PHONE"]["~VALUE"])>0 || strlen($arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"])>0):?>

                    
                    <?if(!$arParams["SIDEMENU"]):?>
                        <div class="wrap-info">

                            <div class="row align-items-center">
                                    
                                <?if(strlen($arItem["PROPERTIES"]["EMPL_BTN_NAME"]["~VALUE"])>0 && strlen($arItem["PROPERTIES"]["EMPL_FORMS"]["VALUE"])>0):?>

                                    <div class="col-xl-4 col-sm-6 col-12 order-sm-1 order-2">
                                        <a class="button-def main-color <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]["BTN_VIEW"]['VALUE']?> call-modal callform" data-call-modal="form<?=$arItem["PROPERTIES"]["EMPL_FORMS"]["VALUE"]?>" data-header='<?=$arParams["BLOCK_TITLE_FORMATED"]?>' title='<?=$arItem["PROPERTIES"]["EMPL_BTN_NAME"]["VALUE"]?>'><?=$arItem["PROPERTIES"]["EMPL_BTN_NAME"]["~VALUE"]?></a>
                                    </div>

                                <?endif;?>

                                <?if(strlen($arItem["PROPERTIES"]["EMPL_PHONE"]["~VALUE"])>0 || (strlen($arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"])>0)):?>
                                    <div class="col-xl-8 col-sm-6 col-12 order-sm-2 order-1 contacts-board">
                                        <div class="row align-items-center">
                                       
                                            <?if(strlen($arItem["PROPERTIES"]["EMPL_PHONE"]["~VALUE"])>0):?>

                                                <div class="col-sm-6 col-12">

                                                    <div class="empl-phone bold"><span title='<?=$arItem["PROPERTIES"]["EMPL_PHONE"]["VALUE"]?>'>

                                                        <a href="tel:<?=$arItem["PHONE_TRIM"]?>"><?=$arItem['PROPERTIES']['EMPL_PHONE']['~VALUE']?></a>
                                                    </span></div>

                                                </div>

                                            <?endif;?>
                                                      <?foreach ($arItem["PROPERTIES"]['SOC']['VALUE'] as $item): ?>
                                            <?if(!empty($item)){?>
                                                 <div class="col-sm-6 col-12">

                                                    <div class="">
                                                        
                                                       <?=$item["TEXT"]?>
                                                   </div>

                                                </div>
                                            <?}
                                            endforeach;?>
                                            <?if(strlen($arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"]) > 0):?>
                                                <div class="col-sm-6 col-12">
                                                    <div class="empl-email"><a href="mailto:<?=$arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"]?>"><span class="bord-bot" title='<?=$arItem["PROPERTIES"]["EMPL_EMAIL"]["VALUE"]?>'><?=$arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"]?></span></a></div>
                                                </div>
                                            <?endif;?>

                                        </div>
                                    </div>
                                <?endif;?>

                            </div>
                          
                        
                        </div>

                    <?else:?>

                        <div class="wrap-info">

                                <?if(strlen($arItem["PROPERTIES"]["EMPL_PHONE"]["~VALUE"])>0 || (strlen($arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"])>0)):?>
                                    <div class="contacts-board">
                                        <div class="row">
                                       
                                            
                                            <div class="col-12">
                                                <?if(strlen($arItem["PROPERTIES"]["EMPL_PHONE"]["~VALUE"])>0):?>
                                                    <div class="empl-phone bold">
                                                        <a href="tel:<?=$arItem["PHONE_TRIM"]?>"><?=$arItem['PROPERTIES']['EMPL_PHONE']['~VALUE']?></a>
                                                    </div>
                                                    <?endif;?>
                                                    <?if(strlen($arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"]) > 0):?>
                                                    <div class="empl-email bold">
                                                        <a href="mailto:<?=$arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"]?>"><?=$arItem["PROPERTIES"]["EMPL_EMAIL"]["~VALUE"]?></a>
                                                    </div>
                                                <?endif;?>
                                                <?foreach ($arItem["PROPERTIES"]['SOC']['VALUE'] as $item): ?>
                                                <?if(!empty($item)){?>
                                                    <a class="empl-btn empl-whatsapp" target="_blank" title="Написать в WhatsApp" href="https://api.whatsapp.com/send?phone=<?=$arItem["PHONE_TRIM"]?>">
                                                        <div class="empl-whatsapp__ico">
                                                            <svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M1.70747 22.2959C1.70617 25.9321 2.65628 29.4821 4.46288 32.6118L1.53441 43.3042L12.4764 40.4351C15.4912 42.0779 18.8854 42.9452 22.3399 42.9463H22.3488C33.7247 42.9463 42.9842 33.6893 42.9891 22.3122C42.9912 16.7986 40.8462 11.6148 36.9489 7.71418C33.0523 3.8141 27.87 1.66508 22.3479 1.66249C10.9714 1.66249 1.7124 10.9182 1.70747 22.2959ZM22.3488 42.9463C22.3484 42.9463 22.3486 42.9463 22.3488 42.9463Z" fill="url(#paint0_linear_1961_2789)"/>
                                                                <path d="M0.970365 22.2898C0.969071 26.0566 1.95332 29.7342 3.82426 32.9754L0.790771 44.0505L12.1254 41.0786C15.2484 42.7817 18.7643 43.6792 22.3426 43.6807H22.3517C34.135 43.6807 43.7279 34.0909 43.7328 22.3064C43.7348 16.5947 41.5125 11.2245 37.476 7.18453C33.4389 3.1446 28.0711 0.918481 22.3517 0.916016C10.566 0.916016 0.975296 10.5047 0.970365 22.2898ZM7.71986 32.417L7.29675 31.7449C5.51758 28.9163 4.57857 25.6472 4.57986 22.2907C4.58375 12.4957 12.5556 4.52613 22.358 4.52613C27.105 4.52798 31.5663 6.37858 34.9221 9.73619C38.2776 13.094 40.1239 17.5578 40.1227 22.3046C40.1183 32.1003 32.1463 40.0704 22.3513 40.0704H22.3443C19.155 40.0686 16.0271 39.2125 13.2993 37.5938L12.6501 37.209L5.92368 38.9725L7.71986 32.417ZM22.3517 43.6807C22.3513 43.6807 22.3515 43.6807 22.3517 43.6807Z" fill="white"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.008 13.3532C16.6078 12.4635 16.1866 12.4457 15.8059 12.4301C15.4944 12.4168 15.138 12.4177 14.7821 12.4177C14.4258 12.4177 13.847 12.5514 13.3576 13.086C12.8677 13.6207 11.4875 14.913 11.4875 17.5414C11.4875 20.17 13.4022 22.7099 13.6689 23.0667C13.9361 23.4228 17.3649 28.9893 22.7947 31.1305C27.3077 32.9101 28.226 32.5562 29.2055 32.467C30.185 32.3781 32.3664 31.1751 32.8115 29.9275C33.2567 28.6802 33.2567 27.611 33.1232 27.3877C32.9897 27.165 32.6334 27.0313 32.0992 26.7643C31.5647 26.4971 28.9383 25.2046 28.4487 25.0263C27.9588 24.8482 27.6027 24.7593 27.2463 25.2941C26.8902 25.8283 25.867 27.0313 25.5552 27.3877C25.2437 27.7447 24.9319 27.7893 24.3977 27.522C23.8632 27.254 22.1426 26.6904 20.1014 24.8706C18.5132 23.4546 17.441 21.7058 17.1293 21.1709C16.8177 20.6367 17.096 20.3474 17.3639 20.081C17.6039 19.8416 17.8983 19.4572 18.1655 19.1454C18.432 18.8334 18.521 18.6108 18.699 18.2544C18.8773 17.8979 18.7882 17.5859 18.6547 17.3186C18.521 17.0514 17.4831 14.4097 17.008 13.3532Z" fill="white"/>
                                                                <defs>
                                                                <linearGradient id="paint0_linear_1961_2789" x1="22.262" y1="44.0461" x2="22.262" y2="0.911483" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#20B038"/>
                                                                <stop offset="1" stop-color="#60D66A"/>
                                                                </linearGradient>
                                                                </defs>
                                                            </svg>
                                                        </div>
                                                        <div class="empl-whatsapp__text">
                                                            <span>Написать в WhatsApp</span>
                                                            <span><?=$arItem["PHONE_TRIM"]?></span>
                                                        </div>
                                                    </a>
                                                <?}
                                                endforeach;?>
                                            </div>

                                        </div>
                                    </div>
                                <?endif;?>

                            <?if(is_array($arItem["PROPERTIES"]["TEXT"]["VALUE"])):?>
                                <div class="wr-btn">
                                    <a class="button-def main-color <?=$btn_size?> <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]["BTN_VIEW"]['VALUE']?> call-modal callemployee " data-call-modal="<?=$arItem["ID"]?>"><?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["MORE_EMPLOYEE"]?></a>
                                </div>
                            <?else:?>

                                <?if(strlen($arItem["PROPERTIES"]["EMPL_BTN_NAME"]["~VALUE"])>0 && strlen($arItem["PROPERTIES"]["EMPL_FORMS"]["VALUE"])>0):?>

                                    <div class="wr-btn">
                                        <a class="button-def main-color <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]["BTN_VIEW"]['VALUE']?> call-modal callform" data-call-modal="form<?=$arItem["PROPERTIES"]["EMPL_FORMS"]["VALUE"]?>" data-header='<?=$arParams["BLOCK_TITLE_FORMATED"]?>' title='<?=$arItem["PROPERTIES"]["EMPL_BTN_NAME"]["VALUE"]?>'><?=$arItem["PROPERTIES"]["EMPL_BTN_NAME"]["~VALUE"]?></a>
                                    </div>

                                <?endif;?>
                             <?endif;?>

                          
                        
                        </div>

                    <?endif;?>

                <?endif;?>
            </div>


            <div class="empl-cell col-sm-4 col-12 <?=$position_hor?> order-1">
                <div class="bg-fone"></div>

                <div class="container-photo">

                    <div class="row">

                        <div class="col-12">

                            <div class="wrap-photo">

                                <img class="mx-auto d-block<?if($arItem["PROPERTIES"]["ANIMATE"]["VALUE"] == "Y"):?> wow zoomIn<?endif;?> lazyload" data-src="<?=$arItem["PREVIEW_PICTURE_SRC"]?>" alt='<?=$arItem["PREVIEW_PICTURE_DESCRIPTION"]?>'>
                                <?if(strlen($arItem["~DETAIL_TEXT"])>0):?>
                                    <div class="icon-center main-color"><span></span></div>
                                <?endif;?>
                            </div>

                        </div>

                        <div class="col-12">

                            <?if(strlen($arItem["~DETAIL_TEXT"])>0):?>
                                <div class="empl-under-desc italic"><?=$arItem["~DETAIL_TEXT"]?></div>
                            <?endif;?>

                            <?if(strlen($arItem["DETAIL_PICTURE_SRC"])):?>

                                <img data-src="<?=$arItem["DETAIL_PICTURE_SRC"]?>" class="mx-auto d-block under img-fluid lazyload" alt='<?=$arItem["DETAIL_PICTURE_DESCRIPTION"]?>'>

                            <?endif;?>

                        </div>

                    </div>

                </div>
                
            </div>

        </div>

    </div>
<?endforeach;?>
<?endif;?>