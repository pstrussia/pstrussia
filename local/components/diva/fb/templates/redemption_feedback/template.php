<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<script>
    function onSubmitFormRequestHandler_<?= $arParams['UID'] ?>(event) {
        $(this).find('[type="submit"]').text("Проверка...");
        grecaptcha.execute(window.rc[<?= $arParams['UID_RC'] ?>]);
        event.preventDefault();
        return false;


    }

    function <?= $arParams['UID_CB'] ?>(token) {
        return new Promise(function (resolve, reject) {
            var formData = new FormData($('#<?= $arParams['UID_FORM'] ?>')[0]);
            formData.append('uid', '<?= $arParams['UID'] ?>');
            formData.append('sessid', BX.message('bitrix_sessid'));
            formData.append('SITE_ID', '<?= SITE_ID ?>');

            $.ajax({
                type: "POST",
                url: '/bitrix/services/main/ajax.php?' + $.param({
                    c: 'diva:fb',
                    action: 'send',
                    mode: 'ajax'
                }, true),
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function (data) {
//                console.log(data);
                    try {
                        var obj = (typeof data === "object" ? data : JSON.parse(data));

                        if (obj.status == "success") {
                            $('#<?= $arParams['UID_FORM'] ?>').html(obj.data.message);
                            return true;
                        } else {
                            alert(obj.errors[0].message);
                        }
                    } catch (e) {
                        alert("Ошибка в запросе, попробуйте позже");
                    }
                    $("#<?= $arParams['UID_FORM'] ?>").find('[type="submit"]').text("Отправить повторно");
                    return false;
                }
            });
            grecaptcha.reset(window.rc[<?= $arParams['UID_RC'] ?>]);
        });
    }

    $(function () {
        $("#<?= $arParams['UID_FORM'] ?>").on('submit', onSubmitFormRequestHandler_<?= $arParams['UID'] ?>);
    });
</script>



<form class="redemption-form" id="<?= $arParams['UID_FORM'] ?>" enctype="multipart/form-data" method="post">
    <div class="redemption-form__item">
        <input class="redemption-form__input" name="f[CODE]" type="text" placeholder="Марка, модель, год">
    </div>
    <div class="redemption-form__item">
        <textarea class="redemption-form__input" name="f[DESCRIPTION]" placeholder="Описание неисправности (какие проблемы с рейкой)"></textarea>
    </div>
    <div class="redemption-form__item">
        <input class="redemption-form__input" name="f[NAME]" type="text" placeholder="Имя">
            <input class="redemption-form__input" name="f[CITY]" type="text" placeholder="Город">
                </div>
                <div class="redemption-form__item">
                    <input class="redemption-form__input" name="f[TELEPHONE]" type="text" placeholder="Телефон">
                        <input class="redemption-form__input" name="f[MAIL]" type="text" placeholder="Электронная почта">
                            </div>
                            <div class="redemption-form__footer">
                                <div class="file">
                                    <div class="file__btn">
                                        <input class="file__input" name="f[MORE_PICTURE][]" name="file" type="file" id="input-file">
                                            <label class="file__label" for="input-file">
                                                <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M0.937256 0.75C0.390381 0.75 -0.000244141 1.17969 -0.000244141 1.6875V2.625C-0.000244141 3.17188 0.390381 3.5625 0.937256 3.5625H14.0623C14.5701 3.5625 14.9998 3.17188 14.9998 2.625V1.6875C14.9998 1.17969 14.5701 0.75 14.0623 0.75H0.937256ZM9.99976 17.3125V12H13.3982C14.1013 12 14.4529 11.1797 13.9451 10.6719L8.00757 4.73438C7.73413 4.46094 7.22632 4.46094 6.95288 4.73438L1.01538 10.6719C0.507568 11.1797 0.859131 12 1.56226 12H4.99976V17.3125C4.99976 17.8594 5.39038 18.25 5.93726 18.25H9.06226C9.57007 18.25 9.99976 17.8594 9.99976 17.3125Z" fill="#181818" />
                                                </svg>
                                            </label>
                                            <div class="file__wrap">
                                                <div class="file__text">Загрузить фото</div>
                                                <div class="file__info">макс. 5 Mb</div>
                                            </div>
                                    </div>
                                </div>
                                <div  class="h-captcha-response" id="<?= $arParams['UID_RC'] ?>" data-callback="<?= $arParams['UID_CB'] ?>"></div>
                                <button class="redemption-form__btn button-def main-color elips" type="submit">Узнать стоимость</button>
                            </div>
                            </form>