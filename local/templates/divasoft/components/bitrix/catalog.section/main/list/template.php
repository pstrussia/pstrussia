<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="row">

    <div class="col-lg-2 col-3 left-body wrapper-img">
        <a href="<?=$arItem['FIRST_ITEM']['DETAIL_PAGE_URL']?>" class="d-block" id="<?=$itemIds["DETAIL_URL_IMG"]?>">

            <img class="img-fluid d-block mx-auto lazyload" id="<?=$itemIds["PICT"]?>" data-src="<?=$arItem["FIRST_ITEM"]["PHOTO"]?>" alt="<?=$arItem["FIRST_ITEM"]["ALT"]?>"/>

            <?CPhoenix::admin_setting($arItem, false)?>
        </a>


        <?if(!empty($arItem["LABELS"]["XML_ID"])):?>
            <div class="wrapper-board-label clearfix">
                <?foreach($arItem["LABELS"]["XML_ID"] as $k=>$xml_id):?>
                    <div class="mini-board <?=$xml_id?>" title="<?=$arItem["LABELS"]["VALUE"][$k]?>"><?=$arItem["LABELS"]["VALUE"][$k]?></div>
                <?endforeach;?>
            </div>
        <?endif;?>

    <? if($arItem['IBLOCK_SECTION_ID'] == 206){?>
            <div class="wrapper-image__sale">
                <span id="<?=$itemIds['DISCOUNT_PERCENT']?>" class="sale <?=( ($arItem['CONFIG']["SHOW_DISCOUNT_PERCENT"] === 'Y' && $arItem["FIRST_ITEM"]['PRICE']['PERCENT']>0) ? '' : 'd-none')?>"><?=-$arItem["FIRST_ITEM"]['PRICE']["PERCENT"]?>%</span>
                <a class="buy-sale" href="/redemption/">Купить со скидкой до 20%</a>
            </div>
            <? }?>
        <?/*if( $arItem['CONFIG']['SHOW_DELAY'] == "Y" 
          || $arItem['CONFIG']['SHOW_COMPARE'] == "Y" ):?>

            <div class="wrapper-delay-compare-icons <?=($arItem['HAVEOFFERS'])?"hidden-md hidden-sm hidden-xs":"";?>">

                <?if($arItem['CONFIG']['SHOW_DELAY'] == "Y"):?>
                    <div title="<?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["CATALOG_DELAY_TITLE"]?>" class="icon delay add2delay" id = "<?=$itemIds["DELAY"]?>" data-item="<?=$arItem["ID"]?>"></div>
                <?endif;?>

                <?if($arItem['CONFIG']['SHOW_COMPARE'] == "Y"):?>
                    <div title="<?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["CATALOG_COMPARE_TITLE"]?>" class="icon compare add2compare" id = "<?=$itemIds["COMPARE"]?>" data-item="<?=$arItem["ID"]?>"></div>
                <?endif;?>
            </div>
        <?endif;*/?>

        <div class="d-none"><span id="<?=$itemIds['DISCOUNT_PERCENT']?>" class="sale"><?=-$arItem["FIRST_ITEM"]['PRICE']["PERCENT"]?>%</span></div>

        
    </div>
    
    <div class="col-md-6 col-9 center-body">
        <a href="<?=$arItem['FIRST_ITEM']['DETAIL_PAGE_URL']?>" class="name-element" id="<?=$itemIds['NAME']?>">
            <?=$arItem["NAME_HTML"]?>
        </a>
		
		<?if($sost = $arResult["SOSTOYANIE_TOVARA"][$arItem["ID"]]):?>
        	<div class="element-state">Состояние: <?=$sost?></div>
        <?endif;?>
		
        <div class="wrapper-article-available row-line d-none d-lg-block" id="<?=$itemIds['ARTICLE_AVAILABLE']?>">

            
                <div class="detail-article italic <?if(strlen($arItem["FIRST_ITEM"]["ARTICLE"])<=0):?>d-none<?endif;?>" title="<?=(strlen($arItem["FIRST_ITEM"]["ARTICLE"])>0)?$PHOENIX_TEMPLATE_ARRAY["MESS"]["ARTICLE_SHORT"].$arItem["FIRST_ITEM"]["ARTICLE"]:""?>"><?=(strlen($arItem["FIRST_ITEM"]["ARTICLE"])>0)?$PHOENIX_TEMPLATE_ARRAY["MESS"]["ARTICLE_SHORT"].$arItem["FIRST_ITEM"]["ARTICLE"]:""?></div>
            

            <div class="product-available-js hidden-js"><?=$arItem["FIRST_ITEM"]["QUANTITY"]["HTML"]?></div>
            
        </div>

        


        <?if( $arItem['HAVEOFFERS']
                || strlen($arItem["FIRST_ITEM"]["SHORT_DESCRIPTION"])
                || strlen($arItem["FIRST_ITEM"]["PREVIEW_TEXT"])
                || !empty($arItem["CHARS_SORT"])
                || $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["RATING"]["ITEMS"]["USE_VOTE"]["VALUE"]["ACTIVE"] == "Y"
            ):?>

            <div class="wrapper-list-info">

                <?if($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG_ITEM_FIELDS"]["ITEMS"]["PROPS_IN_LIST_FOR_".$arResult["VIEW"]]["VALUE"]["DESCRIPTION"] == "Y"):?>

                    <div class="short-description" id="<?=$itemIds["SHORT_DESCRIPTION"]?>"><?=$arItem["FIRST_ITEM"]["SHORT_DESCRIPTION_HTML"]?></div>

                <?endif;?>

                <?if( $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG_ITEM_FIELDS"]["ITEMS"]["PROPS_IN_LIST_FOR_".$arResult["VIEW"]]["VALUE"]["PREVIEW_TEXT"] == "Y" ):?>

                    <div class="preview-text" id="<?=$itemIds["PREVIEW_TEXT"]?>"><?=$arItem["FIRST_ITEM"]["PREVIEW_TEXT_HTML"]?></div>

                <?endif;?>


                <?
                    if($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["RATING"]["ITEMS"]["USE_VOTE"]["VALUE"]["ACTIVE"] == "Y")
                            {?>
                                
                        <?if($arResult["RATING_VIEW"] == "simple"):?>
                                            
                            <?=CPhoenix::GetRatingVoteHTML(array("ID"=>$arItem['ID'], "CLASS"=>"simple-rating hover"));?>

                        <?elseif($arResult["RATING_VIEW"] == "full"):?>

                            <?=CPhoenix::GetRatingVoteHTML(array("ID"=>$arItem['ID'], "VIEW"=>"rating-reviewsCount", "HREF"=>$arItem['FIRST_ITEM']['DETAIL_PAGE_URL']."#rating-block"));?>

                        <?endif;?>

                    <?}
                ?>

                <?if( !empty($arItem["CHARS_SORT"])):?>


                    <div class="wrapper-characteristics toogle-animate-parent d-none d-lg-block <?=($arItem['HAVEOFFERS'] && !$arItem['CONFIG']["SHOW_OFFERS"])?"hidden":"";?>">

                        <div class="characteristics-show">
                            <a class="btn-style-light toogle-animate-click"><span class="bord-bot"><?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["SHOW_CHARACTERISTICS"]?></span><i data-role="prop_angle" class="fa fa-angle-down"></i><i data-role="prop_angle" class="fa fa-angle-up"></i></a>
                        </div>

                        <div class="inner-characteristics toogle-animate-content" style="display: none;">

                            <?foreach ($arItem["CHARS_SORT"] as $keyChar => $valueChar):?>

                                <?if($keyChar == "sku_chars"):?>

                                    <div class="sku-chars" id = "<?=$itemIds["SKU_CHARS"]?>"></div>

                                <?elseif($keyChar == "props_chars"):?>


                                    <?if(!empty($arItem["PROPS_CHARS"])):?>

                                        <?foreach($arItem["PROPS_CHARS"] as $key=>$value):?>

                                            <div class="characteristics-item">
                                                
                                                <span class="characteristics-item-name"><?=$value["NAME"]?>&nbsp;&mdash;&nbsp;</span><span class="characteristics-item-value"><?=$value["VALUE"]?></span>

                                            </div>

                                        <?endforeach;?>

                                    <?endif;?>


                                <?elseif($keyChar == "prop_chars"):?>

                                    <?if(!empty($arItem["PROP_CHARS"])):?>

                                        <?foreach($arItem["PROP_CHARS"] as $key=>$value):?>

                                            <div class="characteristics-item">
                                                
                                                <span class="characteristics-item-name"><?=$value["NAME"]?>&nbsp;&mdash;&nbsp;</span><span class="characteristics-item-value"><?=$value["VALUE"]?></span>

                                            </div>

                                        <?endforeach;?>

                                    <?endif;?>

                                <?endif;?>

                            <?endforeach;?>

                        </div>

                    </div>

                <?endif;?>



            </div>
            

        <?endif;?>

        
        
    </div>

    <div class="col-lg-4 col-md-3 col-12 right-body">
        

        <div class="block-price 
            <?=($arItem["FIRST_ITEM"]['MODE_ARCHIVE']=="Y" || $arItem["FIRST_ITEM"]['PRICE']["PRICE"] == '-1') ? 'd-none' : ''?>
            <?if( $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['USE_PRICE_COUNT']['VALUE']["ACTIVE"] == 'Y' ):?>wrapper-board-price<?endif;?>">

            <div class="<?=($arItem['HAVEOFFERS'])?"d-none d-lg-block":""?>">

                <div class="name-type-price d-none">
                    <?=$arItem['FIRST_ITEM']['PRICE']['NAME']?>
                </div>

                <div class="board-price row no-gutters">
                    <div class="actual-price">

                        <span class="price-value" id="<?=$itemIds['PRICE']?>"><?=$arItem["FIRST_ITEM"]['PRICE']['PRINT_PRICE']?></span><span class="unit <?=(strlen($arItem["FIRST_ITEM"]['MEASURE'])>0 ? '' : 'd-none')?>" id="<?=$itemIds['QUANTITY_MEASURE']?>"><?=$arItem["FIRST_ITEM"]['MEASURE_HTML']?></span>

                    </div>

                    
                    <div class="old-price align-self-end <?=($arItem["FIRST_ITEM"]["SHOW_DISCOUNT"] ? '' : 'd-none')?>" id="<?=$itemIds['OLD_PRICE']?>">
                        <?=$arItem["FIRST_ITEM"]['PRICE']['PRINT_BASE_PRICE']?>
                    </div>

                </div>

                <?//if($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['USE_PRICE_COUNT']['VALUE']["ACTIVE"] == 'Y'):?>
                    <div class="wrapper-matrix-block d-none" id= "<?=$itemIds["PRICE_MATRIX"]?>"><?=$arItem["FIRST_ITEM"]["PRICE_MATRIX_RESULT"]["HTML"]?></div>
                <?//endif;?>
            </div>

            <?if($arItem['HAVEOFFERS']):?>
                <div class="d-lg-none board-price">

                    <div class="d-lg-none count-offers">
                        <?=count($arItem["OFFERS"])." ".CPhoenix::getTermination(count($arItem["OFFERS"]), $PHOENIX_TEMPLATE_ARRAY["TERMINATIONS_OFFERS"])?>
                    </div>

                    <div class="actual-price d-lg-none">
                        <span class="price-value"><?=$arItem['OFFER_DIFF']['VALUE']['HTML']?></span>
                    </div>
                </div>
            <?endif;?>



        </div>


        <?if($arItem['CONFIG']["SHOW_OFFERS"]):?>

            <div id="<?=$itemIds['TREE']?>" class="wrapper-skudiv <?=($arItem['SKU_HIDE_IN_LIST']==='Y')?'d-none':'d-none d-lg-block'?>">

                <?if(!empty($arItem["SKU_PROPS"])):?>

                    <?foreach ($arItem['SKU_PROPS'] as $skuProperty):?>

                        <?
                            $propertyId = $skuProperty['ID'];

                            if(!isset($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['OFFER_FIELDS']['VALUE_'][$propertyId]))
                                continue;

                            $skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
                

                        ?>

                        <div class="wrapper-sku-props clearfix">
                            <div class="product-item-scu-container clearfix">

                                <div class="wrapper-title row no-gutters">
                                    <div class="desc-title"><?=htmlspecialcharsEx($skuProperty['NAME'])?><span class="prop-name"></span> </div>
                                    
                                </div>

                                <?if ($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['OFFER_FIELDS']["VALUES"][$skuProperty["ID"]]["VALUE_2"] == 'pic' || $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['OFFER_FIELDS']["VALUES"][$skuProperty["ID"]]["VALUE_2"] == 'pic_with_info'):?>

                                    <ul class="sku-props">

                                        <?if(!empty($skuProperty['VALUES'])):?>

                                            <?foreach ($skuProperty['VALUES'] as $value):?>

                                                <?

                                                    $styleTab = "";
                                                    $styleHoverBoard = "";

                                                    if(isset($value["PICT"]) || isset($value["PICT_SEC"]) )
                                                    {
                                                        if(isset($value["PICT_SEC"]))
                                                        {
                                                            $styleHoverBoard .= "background-image: url('".$value['PICT_SEC']['BIG']."'); ";

                                                            if(isset($value["PICT"]))
                                                                $styleTab .= "background-image: url('".$value['PICT']['SMALL']."'); ";
                                                            else
                                                                $styleTab .= "background-image: url('".$value['PICT_SEC']['SMALL']."'); ";

                                                        }

                                                        else if(isset($value["PICT"]))
                                                        {
                                                            $styleTab .= "background-image: url('".$value['PICT']['SMALL']."'); ";
                                                            $styleHoverBoard .= "background-image: url('".$value['PICT']['BIG']."'); ";
                                                        }
                                                    }

                                                    if($value["COLOR"])
                                                    {
                                                        $styleTab .= "background-color:".$value["COLOR"]."; ";
                                                        $styleHoverBoard .= "background-color:".$value["COLOR"]."; ";
                                                    }
                                                ?>


                                                <li title='<?=CPhoenix::prepareText($value['NAME'])?>' class="detail-color"

                                                        data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                        data-onevalue="<?=$value['ID']?>"
                                                        

                                                    >

                                                    <div class="color" style="<?=$styleTab?>"></div>


                                                    <?if($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['OFFER_FIELDS']["VALUES"][$skuProperty["ID"]]["VALUE_2"] == 'pic_with_info'):?>

                                                        <div class="wrapper-hover-board">
                                                            <div class="img" style="<?=$styleHoverBoard?>"></div>
                                                            <div class="desc"><?=$value['NAME']?></div>
                                                            <div class="arrow"></div>
                                                        </div>

                                                    <?endif;?>

                                                    <span class="active-flag"></span>

                                                </li>

                                            <?endforeach;?>

                                        <?endif;?>
                                    </ul>

                                <?elseif($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]['OFFER_FIELDS']["VALUES"][$skuProperty["ID"]]["VALUE_2"] == 'select'):?>

                                    <div class="wrapper-select-input">

                                        <ul class="sku-props select-input">

                                            <li class="area-for-current-value"><?=$PHOENIX_TEMPLATE_ARRAY["MESS"]["SKU_SELECT_TITLE"]?></li>

                                            <?if(!empty($skuProperty['VALUES'])):?>

                                                <?foreach ($skuProperty['VALUES'] as $value):?>
                                                    <li title='<?=CPhoenix::prepareText($value['NAME'])?>'

                                                            data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                            data-onevalue="<?=$value['ID']?>"

                                                        ><?=$value['NAME']?></li>
                                                <?endforeach;?>

                                            <?endif;?>
                                           
                                        </ul>

                                        <div class="ar-down"></div>

                                    </div>


                                <?else:?>

                                    <ul class="sku-props">

                                        <?if(!empty($skuProperty['VALUES'])):?>
                                        
                                            <?foreach ($skuProperty['VALUES'] as &$value):?>
                                                <li title='<?=CPhoenix::prepareText($value['NAME'])?>' class="detail-text"

                                                    data-treevalue="<?=$propertyId?>_<?=$value['ID']?>"
                                                    data-onevalue="<?=$value['ID']?>"

                                                ><?=$value['NAME']?></li>
                                            <?endforeach;?>

                                        <?endif;?>
                                    </ul>


                                <?endif;?>


                            </div>

                        </div>

                    <?endforeach;?> 

                <?endif;?>

            </div>
        
        <?endif;?>



        <? if($arItem['QUANTITY']['QUANTITY_VALUE'] > 0 && $arItem['PRICE']['PRICE'] != '-1'){?>
        <div class="wrapper-inner-bot row no-gutters <? if($arItem['QUANTITY']['QUANTITY_VALUE'] > '0'){?> hidden-js.active<?}else{?> hidden-js <?}?>" id="<?=$itemIds['WR_ADD2BASKET']?>">

            <div class="quantity-container col-lg-6 col-12 quantity-block">

                <div class="inner-quantity-container row no-gutters align-items-center d-none d-lg-flex" 
                     data-item="<?=$arItem['ID']?>" >

                    <table>
                        <tr>
                            <td class="btn-quantity"><span class="product-item-amount-field-btn-minus no-select" id="<?=$itemIds['QUANTITY_DOWN']?>">&minus;</span></td>
                            <td><input class="product-item-amount-field" id="<?=$itemIds['QUANTITY']?>" type="number" name="<?=$arParams['PRODUCT_QUANTITY_VARIABLE']?>" value="<?=$arItem["FIRST_ITEM"]["PRICE"]["MIN_QUANTITY"]?>"></td>
                            <td class="btn-quantity"><span class="product-item-amount-field-btn-plus no-select" id="<?=$itemIds['QUANTITY_UP']?>">&plus;</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="btn-container align-items-center col-xl-6 col-12" id="<?=$itemIds['BASKET_ACTIONS']?>">

                <div class="<?=($arItem['HAVEOFFERS'])?" d-lg-block":""?>">
                    <a
                        id = "<?=$itemIds['ADD2BASKET']?>"
                        href="javascript:void(0);"
                        data-item = "<?=$arItem["ID"]?>"

                    class="main-color add2basket bold"><?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["SHOP"]["ITEMS"]["CART_BTN_ADD_NAME"]["~VALUE"]?></a>

                    <a
                        id = "<?=$itemIds['MOVE2BASKET']?>"
                        href="<?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["SHOP"]["ITEMS"]["BASKET_URL"]["VALUE"]?>"
                        data-item = "<?=$arItem["ID"]?>"

                    class="move2basket"><?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["SHOP"]["ITEMS"]["CART_BTN_ADDED_NAME"]["~VALUE"]?></a>
                </div>


                <?if($arItem['HAVEOFFERS']):?>
                    <a href="<?=$arItem['FIRST_ITEM']['DETAIL_PAGE_URL']?>" class="main-color bold d-lg-none">
                        <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]["LINK_2_DETAIL_PAGE_NAME_OFFER_MOB"]["VALUE"]?>
                    </a>
                <?endif;?>
            </div>

        </div>
        <?}?>
        <? if($arItem['QUANTITY']['QUANTITY_VALUE'] < 1 || $arItem['PRICE']['PRICE'] == '-1'){?>
        <div class="wrapper-inner-bot row no-gutters" id="<?=$itemIds['BTN2DETAIL_PAGE_PRODUCT']?>">

            <div class="btn-container align-items-center col-12">
                <a href="<?=$arItem['FIRST_ITEM']['DETAIL_PAGE_URL']?>" class="main-color bold">
                    <?if($arItem['HAVEOFFERS']):?>

                        <span class=" d-lg-block"><?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]["LINK_2_DETAIL_PAGE_NAME_OFFER"]["VALUE"]?></span>
                        
                        <span class="d-lg-none"><?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]["LINK_2_DETAIL_PAGE_NAME_OFFER_MOB"]["VALUE"]?></span>

                    <?else:?>
                        <?=$PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]["LINK_2_DETAIL_PAGE_NAME"]["VALUE"]?>
                    <?endif;?>
                </a>
            </div>

        </div>
        <?}?>
    </div>
</div>