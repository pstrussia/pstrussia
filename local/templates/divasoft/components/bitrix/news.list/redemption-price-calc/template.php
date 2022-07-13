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
<div class="redemption-price">
    <div class="container">
        <h2 class="redemption-price__title title">Расчет цены</h2>
        <div class="redemption-tabs">
            <div class="redemption-tabs__label">Выберите год выпуска:</div>
            <div class="tabs">
                <ul class="tabs__btns">
                    <?foreach ($arResult["ITEMS"] as $key => $item) :?>
                    <li class="<?if($key == 0){?>active<?}?>"><?= $item['NAME'] ?></li>
                    <?endforeach;?>
                </ul>

                <ul class="tabs__content">
                    <?foreach($arResult['ITEMS'] as $arItem):?>
                    <?foreach($arItem['ELEMENTS'] as $key => $item):?>
                    <?if($key == 0){?>
                    <li class="<?if($item['ID'] == $arResult['ITEMS'][0]['ELEMENTS'][0]['ID']){?>active<?}?>">
                        <div class="rails">
                    <?}?>
                            <div class="rails__item">
                                <div class="rails__img">
                                    <img src="<?= $item['PREVIEW_PICTURE']['SRC'] ?>" alt="<?= $item['NAME'] ?>">
                                </div>
                                <div class="rails__title"><?= $item['NAME'] ?></div>
                                <div class="rails__price"><?= $item['CODE'] ?></div>
                            </div>
                            <?if(empty($key+1)){?>
                        </div>
                    </li> 
                            <?}?>
                    <?endforeach;?>
                    <?endforeach;?>
                </ul>

            </div>
            <div class="redemption-tabs__info">Окончательная стоимость вашей рейки зависит от состояния агрегата.</div>
        </div>
    </div>
</div>