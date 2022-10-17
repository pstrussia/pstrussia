<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if ($USER->isAuthorized())
    LocalRedirect(SITE_DIR . "personal/");

use Bitrix\Main\Localization\Loc;

global $PHOENIX_TEMPLATE_ARRAY;

/*
  if (strlen($arParams["MAIN_CHAIN_NAME"]) > 0)
  {
  $APPLICATION->AddChainItem(htmlspecialcharsbx($arParams["MAIN_CHAIN_NAME"]), $arResult['SEF_FOLDER']);
  }
 */

$theme = Bitrix\Main\Config\Option::get("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);

$APPLICATION->SetTitle($PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_PAGE_TITLE"]);
require("include/_head.php");
?> 
<div class="cabinet-wrap reg-page">
    <div class="container">

        <div class="block-move-to-up"> 
            <div class="pad_top_container">
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-12">

                        <form class="form reg-form" method="post" name="fl" value="1">

                            <div class="col-12">

                                <div class="inputs-block">

                                    <div class="col-12 title-form main1 clearfix">
                                        <? /* $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_FORM_TITLE"]  */ ?>
                                        Физическое лицо
                                    </div>



                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc"><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_INPUT_NAME"] ?></span>
                                        <input class="focus-anim require" name="bx-name" type="text" value="" />
                                    </div>

                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Телефон</span>
                                        <input class="focus-anim phone require" type="tel" name="bx-phone" value="" autocomplete="off"/>
                                    </div>

                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc"><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_INPUT_EMAIL"] ?></span>
                                        <input class="focus-anim email require" name="bx-email" type="email" value="" autocomplete="off" />
                                    </div>

                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Промокод</span>
                                        <input class="focus-anim" type="text" name="promo" value="" autocomplete="off" />

                                    </div>

                                    <div class="errors">
                                    </div>
                                    <? if (!empty($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]['AGREEMENT_FORM'])) : ?>

                                        <div class="wrap-agree">

                                            <label class="input-checkbox-css">
                                                <input type="checkbox" class="agreecheck" name="checkboxAgree" value="agree" <? if ($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]["POLITIC_CHECKED"]['VALUE']["ACTIVE"] == 'Y') : ?> checked<? endif; ?>>
                                                <span></span>
                                            </label>

                                            <div class="wrap-desc">
                                                <span class="text"><? if (strlen($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]["POLITIC_DESC"]['VALUE']) > 0) : ?><?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]["POLITIC_DESC"]['~VALUE'] ?><? else : ?><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["FORM_TEMPL_AGREEMENT"] ?><? endif; ?></span>


                                                <? $agrCount = count($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]['AGREEMENT_FORM']); ?>
                                                <? foreach ($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]['AGREEMENT_FORM'] as $k => $arAgr) : ?>

                                                    <a class="call-modal callagreement" data-call-modal="agreement<?= $arAgr['ID'] ?>"><? if (strlen($arAgr['PROPERTIES']['CASE_TEXT']['VALUE']) > 0) : ?><?= $arAgr['PROPERTIES']['CASE_TEXT']['VALUE'] ?><? else : ?><?= $arAgr['NAME'] ?><? endif; ?></a><? if ($k + 1 != $agrCount) : ?><span>, </span><? endif; ?>


                                                <? endforeach; ?>

                                            </div>

                                        </div>
                                    <? endif; ?>

                                </div>

                                <div class="input-btn">

                                    <div class="load">
                                        <div class="xLoader form-preload">
                                            <div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div>
                                        </div>
                                    </div>
                                    <button type="button" class="button-def main-color active <?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]['BTN_VIEW']['VALUE'] ?> register-submit" id="reg-submit" name="form-submit" value="FL"><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_BTN_NAME"] ?></button>

                                </div>

                                <? if (isset($PHOENIX_TEMPLATE_ARRAY["GROUP_POLICY_2"]["PASSWORD_REQUIREMENTS"])) : ?>
                                    <? if (strlen($PHOENIX_TEMPLATE_ARRAY["GROUP_POLICY_2"]["PASSWORD_REQUIREMENTS"])) : ?>

                                        <div class="alert-group-policy">
                                            <?= $PHOENIX_TEMPLATE_ARRAY["GROUP_POLICY_2"]["PASSWORD_REQUIREMENTS"] ?>
                                        </div>

                                    <? endif; ?>
                                <? endif; ?>

                            </div>
                        </form>

                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <form class="form reg-form reg-ur-form" method="post" name="ul" value="2">
                            <div class="col-12">
                                <div class="inputs-block">
                                    <div class="col-12 title-form main1 clearfix">
                                        <? /* $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_FORM_TITLE"]  */ ?>
                                        Юридическое лицо
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Начните вводить ИНН</span>
                                        <input id="dadata-inn" class="focus-anim require" type="text" value="" name="bxu-uf_inn" />
                                        <div class="suggestion-dropdown">
                                            <div class="suggestion-dropdown__title">Выберите вариант или продолжите ввод</div>
                                            <div class="suggestion-dropdown__list">
                                            	
                                                <div class="suggestion-dropdown__item suggestion-zero" style="display: none;">
                                                    <div class="suggestion-dropdown__address"></div>
                                                    <div class="suggestion-dropdown__other"></div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Название организации</span>
                                        <input class="focus-anim require" name="bx-name" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <?/*<div class="input">
                                            <div class="bg"></div>
                                            <span class="desc">ИНН</span>
                                            <input class="focus-anim require" name="bxu-uf_inn" type="text" value="" />
                                        </div>*/?>
                                        <div class="input">
                                            <div class="bg"></div>
                                            <span class="desc">КПП</span>
                                            <input class="focus-anim require" name="bxu-uf_kpp" type="text" value="" />
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Расчетный счет</span>
                                        <input class="focus-anim require" name="bxu-uf_rs" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">БИК</span>
                                        <input class="focus-anim require" name="bxu-uf_bik" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Банк</span>
                                        <input class="focus-anim require" name="bxu-uf_bank" type="text" value="" />
                                    </div>
                                    <div class="form__flex">
                                        <div class="input">
                                            <div class="bg"></div>
                                            <span class="desc">Адрес доставки</span>
                                            <input class="focus-anim require" name="bxu-uf_address" type="text" value="" />
                                        </div>
                                        <div class="input">
                                            <div class="bg"></div>
                                            <span class="desc">Юр. адрес</span>
                                            <input class="focus-anim require" name="bxu-uf_u_address" type="text" value="" />
                                        </div>
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Телефон</span>
                                        <input class="focus-anim phone require" name="bxu-phone" type="tel" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">E-mail</span>
                                        <input class="focus-anim require" name="bx-email" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Придумайте пароль</span>
                                        <input class="focus-anim require" name="bx-password" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Промокод</span>
                                        <input class="focus-anim" name="promo" type="text" value="" />
                                    </div>

                                    <div class="errors"></div>

                                    <? if (!empty($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]['AGREEMENT_FORM'])) : ?>

                                        <div class="wrap-agree">

                                            <label class="input-checkbox-css">
                                                <input type="checkbox" class="agreecheck" name="checkboxAgree" value="agree" <? if ($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]["POLITIC_CHECKED"]['VALUE']["ACTIVE"] == 'Y') : ?> checked<? endif; ?>>
                                                <span></span>
                                            </label>

                                            <div class="wrap-desc">
                                                <span class="text"><? if (strlen($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]["POLITIC_DESC"]['VALUE']) > 0) : ?><?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]["POLITIC_DESC"]['~VALUE'] ?><? else : ?><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["FORM_TEMPL_AGREEMENT"] ?><? endif; ?></span>


                                                <? $agrCount = count($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]['AGREEMENT_FORM']); ?>
                                                <? foreach ($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["POLITIC"]["ITEMS"]['AGREEMENT_FORM'] as $k => $arAgr) : ?>

                                                    <a class="call-modal callagreement" data-call-modal="agreement<?= $arAgr['ID'] ?>"><? if (strlen($arAgr['PROPERTIES']['CASE_TEXT']['VALUE']) > 0) : ?><?= $arAgr['PROPERTIES']['CASE_TEXT']['VALUE'] ?><? else : ?><?= $arAgr['NAME'] ?><? endif; ?></a><? if ($k + 1 != $agrCount) : ?><span>, </span><? endif; ?>


                                                <? endforeach; ?>

                                            </div>

                                        </div>
                                    <? endif; ?>

                                    <div class="input-btn">

                                        <div class="load">
                                            <div class="xLoader form-preload">
                                                <div class="audio-wave"><span></span><span></span><span></span><span></span><span></span></div>
                                            </div>
                                        </div>
                                        <button type="button" class="button-def main-color active <?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["DESIGN"]["ITEMS"]['BTN_VIEW']['VALUE'] ?> register-submit" id="reg-submit" name="form-submit" value="UL"><?= $PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_REGISTER_BTN_NAME"] ?></button>

                                    </div>

                                    <? if (isset($PHOENIX_TEMPLATE_ARRAY["GROUP_POLICY_2"]["PASSWORD_REQUIREMENTS"])) : ?>
                                        <? if (strlen($PHOENIX_TEMPLATE_ARRAY["GROUP_POLICY_2"]["PASSWORD_REQUIREMENTS"])) : ?>

                                            <div class="alert-group-policy">
                                                <?= $PHOENIX_TEMPLATE_ARRAY["GROUP_POLICY_2"]["PASSWORD_REQUIREMENTS"] ?>
                                            </div>

                                        <? endif; ?>
                                    <? endif; ?>

                                </div>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>

    </div>
</div>
