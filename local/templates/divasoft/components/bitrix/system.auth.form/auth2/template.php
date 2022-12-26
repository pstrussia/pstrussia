<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?
    if($USER->isAuthorized())
        LocalRedirect(SITE_DIR.'personal/');
?>


    
<?if($arResult["FORM_TYPE"] == "login"):?>
    <?global $PHOENIX_TEMPLATE_ARRAY;?>

    <div class=
            "
                page-header
                cover
                parent-scroll-down
                <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]["HEAD_TONE"]["VALUE"]?>
                phoenix-firsttype-<?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["MENU"]["ITEMS"]["MENU_TYPE"]["VALUE"]?>
                padding-bottom-section
            " 

    >

        <div class="shadow-tone <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]["HEAD_TONE"]["VALUE"]?>"></div>

        <div class="top-shadow"></div>

        <div class="container">

            <div class="row">
                <div class="col-12 part part-left">
                        
                    <div class="head margin-bottom">
                        <div class="title main1"><h1 style="color: #181818 !important; text-align:center;"><?$APPLICATION->ShowTitle(false);?></h1></div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <div class="cabinet-wrap auth-page">
        <div class="container">
            <div class="block-move-to-up">
            	<div class="auth-block pad_top_container">
                    <div class="row">

                        <?if(strlen($_GET["confirm_user_id"])>0):?>

                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:system.auth.confirmation",
                                    "main",
                                    Array(
                                        "COMPOSITE_FRAME_MODE" => "N",
                                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                                        "CONFIRM_CODE" => "confirm_code",
                                        "LOGIN" => "login",
                                        "USER_ID" => "confirm_user_id"
                                    )
                                );?>
                            </div>

                        <?else:?>
                        
                            <div class="col-lg-4 col-md-6 col-12">
                                <form class="form auth" action="#">
                                    <div class="title-form main1">Личный кабинет</div>
                                    <? if (strlen($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["FORM_AUTH_SUBTITLE"]["VALUE"])) : ?>
                                        <div class="subtitle-form"><?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["FORM_AUTH_SUBTITLE"]["~VALUE"] ?></div>
                                    <? endif; ?>
                                    <div class="inputs-block">
                                        <div class="tabsInput">
                                            <div class="tabsInput__title">Выберите способ входа</div>
                                            <div class="tabsInput__btns">
                                                <div class="tabsInput__btn active">Email</div>
                                                <div class="tabsInput__btn">Телефон</div>
                                                <div class="tabsInput__btn">ID</div>
                                            </div>
                                            <div class="input active">
                                                <div class="bg"></div>
                                                <span class="desc">Email</span>
                                                <input id="login-email" class='focus-anim auth-login require email' name="auth-login" type="email" value="" />
                                            </div>
                                            <div class="input">
                                                <div class="bg"></div>
                                                <span class="desc">Телефон</span>
                                                <input id="login-phone" class='focus-anim auth-login require phone' name="auth-login" type="tel" value="" />
                                            </div>
                                            <div class="input">
                                                <div class="bg"></div>
                                                <span class="desc">ID</span>
                                                <input id="login-id" class='focus-anim auth-login require' name="auth-login" type="text" value="" />
                                            </div>
                                        </div>
                                        <input class="jq-btn-clear" style="display: none;" type="button" value="X">
                                        <div class="input">
                                            <div class="bg"></div>
                                            <span class="desc">Пароль</span>
                                            <input class='focus-anim require' name="auth-password" type="password" />
                                        </div>
                                        <div class="errors"></div>
                                        <div class="input-btn">
                                            <div class="load">
                                                <div class="xLoader form-preload">
                                                    <div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div>
                                                </div>
                                            </div>
                                            <button class="button-def main-color big active <?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]['BTN_VIEW']['VALUE'] ?> auth-submit" name="form-submit" type="button"><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_BTN_ENTER"] ?></button>
                                        </div>
                                    </div>
                                    <div class="input txt-center">
                                        <a class="forgot" href="<?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["FORGOT_PASSWORD_URL"]["VALUE"] ?>"><span class="bord-bot">Восстановить доступ</span></a>
                                    </div>
                                    <div class="input txt-center">
                                        <a href="<?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["REGISTER_URL"]["VALUE"] ?>"><span class="bord-bot"><?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["REGISTER_URL"]["DESCRIPTION"] ?></span></a>
                                    </div>
                                </form>
                            </div>

                            <!-- <div class="col-lg-8 col-md-6 hidden-xs">
                                    
                                <div class="reg">
                                    <div class="reg-comment">
                                        <?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_INDEX_PAGE_COMMENT"]?>
                                    </div>
                                    
                                </div>
                            </div> -->

                        <?endif;?>

                    </div>    
                </div>
            </div>
        </div>
    </div>

<?endif;?>

    <script>
    	//setHandler("#auth_login_2");
    </script> 