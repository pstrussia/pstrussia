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
                   
<div class="estimate">
        <div class="container">
            <h2 class="estimate__title title">Оценка состояния</h2>
            <div class="estimate__subtitle">Мы <span>не</span> принимаем агрегаты с такими повреждениями или принимаем по цене до 500 руб/шт</div>
        </div>
        <div class="estimate__slider">
            <div class="swiper">
                <div class="swiper-wrapper">
                     <?foreach($arResult['ITEMS'] as $arItem):?>
                    <div class="swiper-slide">
                        <div class="estimate__img">
                            <img src="<?=$arItem['PREVIEW_PICTURE']['SRC'] ?>" alt="<?=$arItem['NAME']?>">
                        </div>
                        <div class="estimate__info"><?=$arItem['NAME']?></div>
                    </div>
                    <?endforeach;?>
                   
                    
                </div>
                <div class="swiper-group-btn">
                    <div class="swiper-btn-prev">
                        <svg width="27" height="14" viewBox="0 0 27 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6.70313 0.804686L0.902345 6.60547C0.609376 6.83984 0.609376 7.30859 0.902345 7.60156L6.70313 13.4023C7.17188 13.8125 7.875 13.5195 7.875 12.875L7.875 8.71484L25.9219 8.71484C26.332 8.71484 26.625 8.42187 26.625 8.01172L26.625 6.13672C26.625 5.72656 26.332 5.43359 25.9219 5.43359L7.875 5.43359L7.875 1.27344C7.875 0.628905 7.17188 0.335936 6.70313 0.804686Z" fill="#181818" />
                        </svg>
                    </div>
                    <div class="swiper-btn-next">
                        <svg width="27" height="14" viewBox="0 0 27 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.2969 13.1953L26.0977 7.39453C26.3906 7.16016 26.3906 6.69141 26.0977 6.39844L20.2969 0.597656C19.8281 0.1875 19.125 0.480469 19.125 1.125V5.28516H1.07812C0.667969 5.28516 0.375 5.57812 0.375 5.98828V7.86328C0.375 8.27344 0.667969 8.56641 1.07812 8.56641H19.125V12.7266C19.125 13.3711 19.8281 13.6641 20.2969 13.1953Z" fill="#181818" />
                        </svg>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>