<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->SetFrameMode(true); ?>

<? //if($arResult["FORM_TYPE"] == "login"):
?>

<? global $PHOENIX_TEMPLATE_ARRAY; ?>

<?
$picture = (strlen($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["FORM_PIC"]["VALUE"])) ? true : false;
?>

<div class="phx-modal-dialog" data-target="auth-modal-dialog">
    <div class="dialog-content">
        <a class="close-phx-modal-dialog" data-target="auth-modal-dialog"></a>

        <div class="auth-dialog-form <?= ($picture) ? "with-pic" : ""; ?>">

            <div class="row no-gutters">

                <? if ($picture) : ?>

                    <div class="col-md-7 hidden-sm hidden-xs picture" style="background-image: url(<?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["FORM_PIC"]["SETTINGS"]["SRC"] ?>);"></div>

                <? endif; ?>

                <div class="<?= ($picture) ? "col-md-5" : ""; ?> col-12">
                    <div class="auth-form">
                        <form id="auth_form_1" class="form auth" action="#">
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
                                        <input class='focus-anim auth-login require' name="auth-login" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">Телефон</span>
                                        <input class='focus-anim auth-login require' name="auth-login" type="text" value="" />
                                    </div>
                                    <div class="input">
                                        <div class="bg"></div>
                                        <span class="desc">ID</span>
                                        <input class='focus-anim auth-login require' name="auth-login" type="text" value="" />
                                    </div>
                                </div>
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
                            <?/*<div class="soc-enter">
                                        <div class="soc-enter-title">
                                            <div class="soc-enter-line"></div>
                                            <div class="soc-enter-text"><?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["PERSONAL_AUTH_FORM_SOC"]?></div>
                                        </div>
                                        <div class="soc-enter-items">
                                            <a href="#" class="soc-enter-item"></a>
                                            <a href="#" class="soc-enter-item"></a>
                                        </div>
                                    </div>*/ ?>
                        </form>
                    </div>



                    <div class="register row no-margin">
                        <div class="col-12">

                            <a href="<?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["REGISTER_URL"]["VALUE"] ?>"><span class="bord-bot"><?= $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["REGISTER_URL"]["DESCRIPTION"] ?></span></a>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<script>
	setHandler("#auth_login_1");
</script> 

<script>
    $(function() {
        $(document).on("click", ".auth-btn-js", function() {
            const dataFace = $(this).attr('data-face')
            console.log(dataFace);
            if (dataFace == 'fiz') {
                $('.auth-choice').fadeOut(100, function() {
                    $('.auth-ur').fadeOut(100, function() {
                        $('.auth-fiz').fadeIn(100)
                    })
                })
            } else {
                $('.auth-choice').fadeOut(100, function() {
                    $('.auth-fiz').fadeOut(100, function() {
                        $('.auth-ur').fadeIn(100)
                    })
                })
            }
        })
    })
</script>

<? //endif;
?>