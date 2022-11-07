<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Выкуп реек");
?>

<?$APPLICATION->IncludeComponent("concept:phoenix.pages", "", Array(
	"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"COMPONENT_TEMPLATE" => ".default",
		"COMPOSITE_FRAME_MODE" => "N",
		"FILE_404" => "",	// Страница для показа (по умолчанию /404.php)
		"IBLOCK_ID" => "16",	// Инфоблок
		"IBLOCK_TYPE" => "concept_phoenix_s1",	// Тип инфоблока
		"MESSAGE_404" => "",
		"SEF_FOLDER" => "/",	// Каталог ЧПУ (относительно корня сайта)
		"SEF_MODE" => "Y",	// Включить поддержку ЧПУ
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SHOW_404" => "N",	// Показ специальной страницы
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"SEF_URL_TEMPLATES" => array(
			"main" => "",
			"page" => "#SECTION_CODE_PATH#/",
		)
	),
	false
);?>
<div class="redemption">

    <div class="redemption-head">
        <div class="container">
            <?
            $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include/redemption/h1.php", array(), array("MODE" => "html", "NAME" => "h1", "TEMPLATE" => "h1.php"));
            ?>

            <a class="redemption-head__btn button-def main-color elips anchor" href="#redemption-form">Узнать стоимость</a>
        </div>
    </div>
    <?
    $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"redemption-price-calc", 
	array(
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "concept_phoenix_s1",
		"IBLOCK_ID" => "19",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "ID",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "DESCRIPTION",
			2 => "",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "Y",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Рейки",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_TEMPLATE" => "",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"PAGER_BASE_LINK_ENABLE" => "Y",
		"SET_STATUS_404" => "Y",
		"SHOW_404" => "Y",
		"MESSAGE_404" => "",
		"PAGER_BASE_LINK" => "",
		"PAGER_PARAMS_NAME" => "arrPager",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"COMPONENT_TEMPLATE" => "redemption-price-calc",
		"STRICT_SECTION_CHECK" => "N",
		"FILE_404" => ""
	),
	false
);
    ?>

    <?
    $APPLICATION->IncludeComponent(
        "bitrix:news.list",
        "redemption-rating",
        array(
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "AJAX_MODE" => "Y",
            "IBLOCK_TYPE" => "concept_phoenix_s1",
            "IBLOCK_ID" => "19",
            "NEWS_COUNT" => "20",
            "SORT_BY1" => "ACTIVE_FROM",
            "SORT_ORDER1" => "DESC",
            "SORT_BY2" => "SORT",
            "SORT_ORDER2" => "ASC",
            "FILTER_NAME" => "",
            "FIELD_CODE" => array(
                0 => "ID",
                1 => "",
            ),
            "PROPERTY_CODE" => array(
                0 => "",
                1 => "DESCRIPTION",
                2 => "",
            ),
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "PREVIEW_TRUNCATE_LEN" => "",
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "SET_TITLE" => "N",
            "SET_BROWSER_TITLE" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_LAST_MODIFIED" => "N",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "HIDE_LINK_WHEN_NO_DETAIL" => "Y",
            "PARENT_SECTION" => "",
            "PARENT_SECTION_CODE" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_FILTER" => "Y",
            "CACHE_GROUPS" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "PAGER_TITLE" => "Рейки",
            "PAGER_SHOW_ALWAYS" => "Y",
            "PAGER_TEMPLATE" => "",
            "PAGER_DESC_NUMBERING" => "N",
            "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
            "PAGER_SHOW_ALL" => "Y",
            "PAGER_BASE_LINK_ENABLE" => "Y",
            "SET_STATUS_404" => "Y",
            "SHOW_404" => "Y",
            "MESSAGE_404" => "",
            "PAGER_BASE_LINK" => "",
            "PAGER_PARAMS_NAME" => "arrPager",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "N",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "COMPONENT_TEMPLATE" => "redemption-rating",
            "STRICT_SECTION_CHECK" => "N",
            "FILE_404" => ""
        ),
        false
    );
    ?>


    <div class="redemption-sell">
        <div class="container">
            <h2 class="redemption-sell__title title">Как продать рейку</h2>
            <div class="redemption-steps">
                <div class="redemption-steps__item">
                    <div class="redemption-steps__icon">
                        <svg width="40" height="36" viewBox="0 0 40 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.75025 0.5L36.2502 0.500003C38.3596 0.500003 40.0002 2.21875 40.0002 4.25L40.0002 31.75C40.0002 33.8594 38.3596 35.5 36.2502 35.5L3.75024 35.5C1.71899 35.5 0.000243956 33.8594 0.000244141 31.75L0.000246545 4.25C0.000246722 2.21875 1.719 0.5 3.75025 0.5ZM37.5002 4.25C37.5002 3.625 36.9534 3 36.2502 3L32.5002 3V8L37.5002 8V4.25ZM2.50024 31.75C2.50024 32.4531 3.12524 33 3.75024 33L36.2502 33C36.9534 33 37.5002 32.4531 37.5002 31.75V10.5L2.50025 10.5L2.50024 31.75ZM2.50025 8L30.0002 8V3L3.75025 3C3.12525 3 2.50025 3.625 2.50025 4.25L2.50025 8Z" fill="#EC6E00" />
                        </svg>
                    </div>
                    <div class="redemption-steps__text">Заявка на сайте</div>
                </div>
                <div class="redemption-steps__item">
                    <div class="redemption-steps__icon">
                        <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M32.1252 11.5L23.3752 11.5C23.0627 11.5 22.7502 11.2656 22.7502 10.875V9.625C22.7502 9.3125 23.0627 9 23.3752 9L32.1252 9C32.5159 9 32.7502 9.3125 32.7502 9.625V10.875C32.7502 11.2656 32.5159 11.5 32.1252 11.5ZM31.7346 30.875L30.8752 31.7344C30.6409 32.0469 30.2502 32.0469 30.0159 31.7344L27.7502 29.5469L25.5627 31.7344C25.3284 32.0469 24.9377 32.0469 24.7034 31.7344L23.844 30.875C23.5315 30.6406 23.5315 30.25 23.844 30.0156L26.0315 27.75L23.844 25.5625C23.5315 25.3281 23.5315 24.9375 23.844 24.7031L24.7034 23.8438C24.9377 23.5313 25.3284 23.5313 25.5627 23.8438L27.7502 26.0313L30.0159 23.8438C30.2502 23.5313 30.6409 23.5313 30.8752 23.8438L31.7346 24.7031C32.0471 24.9375 32.0471 25.3281 31.7346 25.5625L29.5471 27.75L31.7346 30.0156C31.8909 30.0938 31.969 30.3281 31.969 30.4063C31.969 30.5625 31.8909 30.7969 31.7346 30.875ZM2.75025 0.25L35.2502 0.250003C36.6565 0.250003 37.7502 1.42188 37.7502 2.75L37.7502 35.25C37.7502 36.6563 36.6565 37.75 35.2502 37.75L2.75024 37.75C1.42212 37.75 0.250244 36.6562 0.250244 35.25L0.250247 2.75C0.250247 1.42187 1.42212 0.25 2.75025 0.25ZM20.2502 35.25L35.2502 35.25V20.25H20.2502L20.2502 35.25ZM20.2502 17.75H35.2502L35.2502 2.75L20.2502 2.75V17.75ZM2.75024 35.25H17.7502L17.7502 20.25L2.75025 20.25L2.75024 35.25ZM2.75025 17.75L17.7502 17.75V2.75L2.75025 2.75L2.75025 17.75ZM14.6252 11.5H11.5002V14.625C11.5002 15.0156 11.2659 15.25 10.8752 15.25H9.62525C9.31275 15.25 9.00025 15.0156 9.00025 14.625V11.5L5.87525 11.5C5.56275 11.5 5.25025 11.2656 5.25025 10.875L5.25025 9.625C5.25025 9.3125 5.56275 9 5.87525 9L9.00025 9L9.00025 5.875C9.00025 5.5625 9.31275 5.25 9.62525 5.25H10.8752C11.2659 5.25 11.5002 5.5625 11.5002 5.875L11.5002 9H14.6252C15.0159 9 15.2502 9.3125 15.2502 9.625V10.875C15.2502 11.2656 15.0159 11.5 14.6252 11.5ZM14.6252 31.5L5.87524 31.5C5.56274 31.5 5.25024 31.2656 5.25024 30.875V29.625C5.25024 29.3125 5.56274 29 5.87524 29L14.6252 29C15.0159 29 15.2502 29.3125 15.2502 29.625L15.2502 30.875C15.2502 31.2656 15.0159 31.5 14.6252 31.5ZM14.6252 26.5L5.87525 26.5C5.56275 26.5 5.25025 26.2656 5.25025 25.875V24.625C5.25025 24.3125 5.56275 24 5.87525 24L14.6252 24C15.0159 24 15.2502 24.3125 15.2502 24.625V25.875C15.2502 26.2656 15.0159 26.5 14.6252 26.5Z" fill="#EC6E00" />
                        </svg>
                    </div>
                    <div class="redemption-steps__text">Расчет стоимости</div>
                </div>
                <div class="redemption-steps__item">
                    <div class="redemption-steps__icon">
                        <svg width="54" height="50" viewBox="0 0 54 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M53.3752 35H51.5002V26.5625C51.5002 25.3125 50.9534 23.9844 50.0159 23.0469L43.4534 16.4844C42.5159 15.5469 41.2659 15 39.9377 15L36.5002 15L36.5002 11.1719C36.5002 9.14063 34.7034 7.5 32.594 7.5L7.82837 7.5C5.719 7.5 4.00025 9.14062 4.00025 11.1719L4.00024 33.9062C4.00024 35.9375 5.71899 37.5 7.82837 37.5H9.07837C9.00024 37.9688 9.00024 38.3594 9.00024 38.75C9.00024 42.2656 11.7346 45 15.2502 45C18.6877 45 21.5002 42.2656 21.5002 38.75C21.5002 38.3594 21.4221 37.9688 21.344 37.5H36.5784C36.5002 37.9688 36.5002 38.3594 36.5002 38.75C36.5002 42.2656 39.2346 45 42.7502 45C46.1877 45 49.0002 42.2656 49.0002 38.75C49.0002 38.3594 48.9221 37.9688 48.844 37.5H53.3752C53.6877 37.5 54.0002 37.2656 54.0002 36.875V35.625C54.0002 35.3125 53.6877 35 53.3752 35ZM39.9377 17.5C40.5627 17.5 41.1877 17.8125 41.6565 18.2813L48.219 24.8438C48.2971 24.9219 48.2971 25 48.3752 25.0781L36.5002 25.0781V17.5781H39.9377V17.5ZM15.2502 42.5C13.1409 42.5 11.5002 40.8594 11.5002 38.75C11.5002 36.7188 13.1409 35 15.2502 35C17.2815 35 19.0002 36.7188 19.0002 38.75C19.0002 40.8594 17.2815 42.5 15.2502 42.5ZM20.1721 35C19.0784 33.5156 17.2815 32.5 15.2502 32.5C13.219 32.5 11.4221 33.5156 10.2502 35H7.82837C7.04712 35 6.50024 34.5312 6.50024 33.9062L6.50025 11.1719C6.50025 10.5469 7.04712 10 7.82837 10L32.594 10C33.3752 10 34.0002 10.5469 34.0002 11.1719L34.0002 35H20.1721ZM42.7502 42.5C40.6409 42.5 39.0002 40.8594 39.0002 38.75C39.0002 36.7188 40.6409 35 42.7502 35C44.7815 35 46.5002 36.7188 46.5002 38.75C46.5002 40.8594 44.7815 42.5 42.7502 42.5ZM42.7502 32.5C40.6409 32.5 38.9221 33.5156 37.7502 35H36.5002V27.5L49.0002 27.5V35H47.6721C46.5784 33.5156 44.7815 32.5 42.7502 32.5Z" fill="#EC6E00" />
                        </svg>
                    </div>
                    <div class="redemption-steps__text">Доставка рейки к нам</div>
                </div>
                <div class="redemption-steps__item">
                    <div class="redemption-steps__icon">
                        <svg width="48" height="34" viewBox="0 0 48 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.75 8.3125C19.7422 8.3125 16.625 12.0977 16.625 16.625C16.625 21.2266 19.7422 24.9375 23.75 24.9375C27.6836 24.9375 30.875 21.2266 30.875 16.625C30.875 12.0977 27.6836 8.3125 23.75 8.3125ZM23.75 22.5625C21.0781 22.5625 19 19.9648 19 16.625C19 13.3594 21.0781 10.6875 23.75 10.6875C26.3477 10.6875 28.5 13.3594 28.5 16.625C28.5 19.9648 26.3477 22.5625 23.75 22.5625ZM46.0898 1.70703C43.1953 0.519532 40.3008 2.53048e-07 37.4063 0C28.2773 -7.98074e-07 19.1484 4.67578 10.0195 4.67578C5.19531 4.67578 3.41406 3.48828 2.375 3.48828C1.11328 3.48828 2.18011e-06 4.52734 2.06331e-06 5.86328L0 29.4648C-7.78609e-08 30.3555 0.519531 31.2461 1.33594 31.6172C4.23047 32.8047 7.125 33.25 10.0195 33.25C19.1484 33.25 28.2773 28.6484 37.4062 28.6484C42.2305 28.6484 44.0117 29.7617 45.0508 29.7617C46.3125 29.7617 47.5 28.7969 47.5 27.4609L47.5 3.85938C47.5 2.96875 46.9063 2.07813 46.0898 1.70703ZM2.375 5.9375C3.9336 6.38281 5.41797 6.67968 7.05078 6.90234C6.90235 9.35156 4.89844 11.3555 2.375 11.3555L2.375 5.9375ZM2.375 29.4648L2.375 26.2734C4.82422 26.2734 6.90234 28.2031 7.05078 30.6523C5.41797 30.4297 3.78516 30.0586 2.375 29.4648ZM45.0508 27.3867C43.4922 26.9414 42.0078 26.6445 40.375 26.4219C40.5977 24.0469 42.6016 22.1172 45.0508 22.1172V27.3867ZM45.0508 19.7422C41.3398 19.7422 38.2969 22.6367 38 26.2734C32.8047 26.1992 27.832 27.4609 23.1562 28.6484C17.5898 30.0586 13.7305 30.9492 9.42578 30.875C9.35156 27.0156 6.23438 23.8984 2.375 23.8984L2.375 13.7305C6.16016 13.7305 9.20313 10.7617 9.42578 7.05078C14.6211 7.125 19.5938 5.86328 24.2695 4.67578C29.8359 3.26562 33.6953 2.375 38 2.44922C38 6.38281 41.1914 9.57422 45.0508 9.57422V19.7422ZM45.0508 7.19922C42.5273 7.19922 40.4492 5.19531 40.375 2.67188C42.0078 2.89453 43.6406 3.26563 45.125 3.85938L45.0508 7.19922Z" fill="#EC6E00" />
                        </svg>
                    </div>
                    <div class="redemption-steps__text">Оплата за рейку вам на карту</div>
                </div>
            </div>
            <div id="redemption-form">
                <!--форма-->
                <?
                $APPLICATION->IncludeComponent(
                    "diva:fb",
                    "redemption_feedback",
                    array(
                        "IBLOCK_TYPE" => "standart",
                        "IBLOCK_ID" => "21",
                        "UID" => "5c6f422028ad83aba5faa97bb72888ba",
                        "FIELDS" => array(
                            0 => "NAME",
                            1 => "CODE",
                            2 => "MAIL",
                            3 => "TELEPHONE",
                            4 => "MORE_PICTURE",
                            5 => "CITY",
                            6 => "DESCRIPTION"
                        ),
                        "EVENT_MESSAGE_ID" => "FEEDBACK_FORM",
                        "EMAIL_TO" => "info@pstrussia.ru",
                        "COMPONENT_TEMPLATE" => "redemption_feedback"
                    ),
                    false
                );
                ?>
            </div>
        </div>
    </div>

    <div class="redemption-info">
        <div class="container">
            <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include/redemption/down-text.php", array(), array("MODE" => "html", "NAME" => "текст нижний", "TEMPLATE" => "down-text.php")); ?>
            <div class="redemption-info__wrap">
                <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include/redemption/down-left-text.php", array(), array("MODE" => "html", "NAME" => "текст нижний левый", "TEMPLATE" => "down-left-text.php")); ?>

                <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include/redemption/down-right-text.php", array(), array("MODE" => "html", "NAME" => "текст нижний правый", "TEMPLATE" => "down-right-text.php")); ?>

            </div>
        </div>
    </div>

</div>


<script>
    $(function() {

        var swiper = new Swiper(".estimate__slider .swiper", {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 100,
            loop: true,
            navigation: {
                nextEl: ".swiper-btn-next",
                prevEl: ".swiper-btn-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });

        var filesExt = ['jpg', 'jpeg', 'pdf', 'png']
        $(document).on('change', '#input-file', function() {
            var parts = $(this).val().split('.')
            var uploadText = $(this).parents('.file').find('.file__info')
            if (filesExt.join().search(parts[parts.length - 1]) != -1) {
                var fileSize = $(this)[0].files[0].size
                if (fileSize > 5097152) {
                    uploadText.html('Размер файла не более 5Mb')
                    uploadText.css('color', '#FF6767')
                } else {
                    uploadText.html($(this).val().replace(/.*\\/, ""))
                    uploadText.css('color', '#a3a3a3')
                }
            } else {
                uploadText.html('Недопустимый формат. Только jpg, jpeg, pdf, png')
                uploadText.css('color', '#FF6767')
            }
        })

        $(".anchor").on('click', function() {
            var offsetHeight = 150
            var elementClick = $(this).attr("href")
            var destination = $(elementClick).offset().top - offsetHeight + 1
            $('html,body').animate({
                scrollTop: destination
            }, 1100)
            return false
        })

    })
</script>


<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");
?>