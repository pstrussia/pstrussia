<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

use Bitrix\Main,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Page\Asset;

Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
//$this->addExternalCss("/bitrix/css/main/bootstrap.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

if (!empty($arResult['ERRORS']['FATAL'])) {
    foreach ($arResult['ERRORS']['FATAL'] as $error) {
        ShowError($error);
    }
    $component = $this->__component;
    if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED])) {
        $APPLICATION->AuthForm('', false, false, 'N', false);
    }
} else {
    global $PHOENIX_TEMPLATE_ARRAY;

    if ($PHOENIX_TEMPLATE_ARRAY["ITEMS"]["PERSONAL"]["ITEMS"]["SHOW_DISCSAVE"]["VALUE"]["ACTIVE"] == "Y") {
        if (!CPhoenix::isLowLicense()) {
            $APPLICATION->IncludeComponent(
                    "bitrix:catalog.discsave.info",
                    "main",
                    Array(
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "SHOW_NEXT_LEVEL" => "Y",
                        "SITE_ID" => SITE_ID,
                        "USER_ID" => $PHOENIX_TEMPLATE_ARRAY["USER_ID"]
                    )
            );
        }
    }

    if (!empty($arResult['ERRORS']['NONFATAL'])) {
        foreach ($arResult['ERRORS']['NONFATAL'] as $error) {
            ShowError($error);
        }
    }



    if (!count($arResult['ORDERS'])) {
        if ($_REQUEST["filter_history"] == 'Y') {
            if ($_REQUEST["show_canceled"] == 'Y') {
                ?>
                <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_CANCELED_ORDER') ?></h3>
                <?
            } else {
                ?>
                <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_HISTORY_ORDER_LIST') ?></h3>
                <?
            }
        } else {
            ?>
            <h3><?= Loc::getMessage('SPOL_TPL_EMPTY_ORDER_LIST') ?></h3>
            <?
        }
    }
    ?>

    <?
    $nothing = !isset($_REQUEST["filter_history"]) && !isset($_REQUEST["show_all"]);
    $clearFromLink = array("filter_history", "filter_status", "show_all", "show_canceled");

    if ($nothing || $_REQUEST["filter_history"] == 'N') {
        ?>
        <a class="sale-order-history-link" href="<?= $APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false) ?>">
            <span class="bord-bot"><? echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY") ?></span>
        </a>
        <?
    }
    if ($_REQUEST["filter_history"] == 'Y') {
        ?>
        <a class="sale-order-history-link" href="<?= $APPLICATION->GetCurPageParam("", $clearFromLink, false) ?>">
            <span class="bord-bot"><? echo Loc::getMessage("SPOL_TPL_CUR_ORDERS") ?></span>
        </a>
        <?
        if ($_REQUEST["show_canceled"] == 'Y') {
            ?>
            <a class="sale-order-history-link" href="<?= $APPLICATION->GetCurPageParam("filter_history=Y", $clearFromLink, false) ?>">
                <span class="bord-bot"><? echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_HISTORY") ?></span>
            </a>
            <?
        } else {
            ?>
            <a class="sale-order-history-link" href="<?= $APPLICATION->GetCurPageParam("filter_history=Y&show_canceled=Y", $clearFromLink, false) ?>">
                <span class="bord-bot"><? echo Loc::getMessage("SPOL_TPL_VIEW_ORDERS_CANCELED") ?></span>
            </a>
            <?
        }
    }
    ?>
    <?
    if (!count($arResult['ORDERS'])) {
        ?>
        <div class="row">
            <div class="col-12">
                <a href="<?= htmlspecialcharsbx($arParams['PATH_TO_CATALOG']) ?>" class="sale-order-history-link">
                    <span class="bord-bot"><?= Loc::getMessage('SPOL_TPL_LINK_TO_CATALOG') ?></span>
                </a>
            </div>
        </div>
        <?
    }

    if ($_REQUEST["filter_history"] !== 'Y') {
        $paymentChangeData = array();
        $orderHeaderStatus = null;

        if (!empty($arResult['ORDERS'])) {
            foreach ($arResult['ORDERS'] as $key => $order) {
                if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $arResult['SORT_TYPE'] == 'STATUS') {
                    $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
                    ?>
                    <div class="sale-order-title">
                        <?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>&raquo;
                    </div>
                    <?
                }
                ?>
            
                <div class="col-12 sale-order-list-container">
                    <div class="row">
                        <div class="col-12 sale-order-list-title-container">
                            <div class="sale-order-list-title bold">
                                <span class="sale-order-list-flex">
                                    <span class="sale-order-list-warning" data-title="Детали заказа были изменены">
                                        <svg width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.7656 8.50781C10.7396 8.3776 10.7786 8.26042 10.8828 8.15625C10.987 8.05208 11.1042 8 11.2344 8H13.3438C13.4479 8 13.526 8.02604 13.5781 8.07812C13.6562 8.10417 13.7083 8.15625 13.7344 8.23438C13.7865 8.3125 13.8125 8.40365 13.8125 8.50781L13.5781 12.8828C13.5521 13.1693 13.3958 13.3125 13.1094 13.3125H11.4688C11.1823 13.3125 11.026 13.1693 11 12.8828L10.7656 8.50781ZM13.4219 14.3672C13.7604 14.6797 13.9297 15.0573 13.9297 15.5C13.9297 15.9427 13.7604 16.3333 13.4219 16.6719C13.1094 16.9844 12.7318 17.1406 12.2891 17.1406C11.8464 17.1406 11.4557 16.9844 11.1172 16.6719C10.8047 16.3333 10.6484 15.9427 10.6484 15.5C10.6484 15.0573 10.8047 14.6797 11.1172 14.3672C11.4557 14.0286 11.8464 13.8594 12.2891 13.8594C12.7318 13.8594 13.1094 14.0286 13.4219 14.3672ZM13.9297 1.4375L23.3047 17.6875C23.6432 18.3125 23.6302 18.9375 23.2656 19.5625C22.9271 20.1875 22.3932 20.5 21.6641 20.5H2.91406C2.1849 20.5 1.63802 20.1875 1.27344 19.5625C0.934896 18.9375 0.934896 18.3125 1.27344 17.6875L10.6484 1.4375C11.013 0.8125 11.5599 0.5 12.2891 0.5C13.0182 0.5 13.5651 0.8125 13.9297 1.4375ZM3.10938 18.2734C2.97917 18.5078 3.04427 18.625 3.30469 18.625H21.2734C21.3516 18.625 21.4167 18.5859 21.4688 18.5078C21.5208 18.4297 21.5208 18.3516 21.4688 18.2734L12.4844 2.72656C12.4323 2.64844 12.3672 2.60938 12.2891 2.60938C12.2109 2.60938 12.1458 2.64844 12.0938 2.72656L3.10938 18.2734Z" fill="#FF3232"/>
                                        </svg>
                                    </span>
                                    <span>
                                        <?= Loc::getMessage('SPOL_TPL_ORDER') ?>
                                        <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . $order['ORDER']['ACCOUNT_NUMBER'] ?>
                                        <?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
                                        <?= $order['ORDER']['DATE_INSERT']->format($arParams['ACTIVE_DATE_FORMAT']) ?>
                                    </span>
                                </span>
                                <span>
                                    <?= count($order['BASKET_ITEMS']); ?>
                                    <?
                                    $count = count($order['BASKET_ITEMS']) % 10;
                                    if ($count == '1') {
                                        echo Loc::getMessage('SPOL_TPL_GOOD');
                                    } elseif ($count >= '2' && $count <= '4') {
                                        echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
                                    } else {
                                        echo Loc::getMessage('SPOL_TPL_GOODS');
                                    }
                                    ?>
                                    <?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
                                    <?= $order['ORDER']['FORMATED_PRICE'] ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <??>
                    <div class="row">
                        <div class="col-12 sale-order-list-inner-container">

                            <? if (!empty($order['PAYMENT'])): ?>

                                <span class="sale-order-list-inner-title-line">
                                    <span class="sale-order-list-inner-title-line-item"><?= Loc::getMessage('SPOL_TPL_PAYMENT') ?></span>
                                </span>

                            <? endif; ?>
                            <?
                            $showDelimeter = false;
                            foreach ($order['PAYMENT'] as $payment) {
                                if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                    $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                        "order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                                        "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                        "allow_inner" => $arParams['ALLOW_INNER'],
                                        "refresh_prices" => $arParams['REFRESH_PRICES'],
                                        "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                        "only_inner_full" => $arParams['ONLY_INNER_FULL']
                                    );
                                }
                                ?>
                                <div class="row sale-order-list-inner-row">
                                    <?
                                    if ($showDelimeter) {
                                        ?>

                                        <?
                                    } else {
                                        $showDelimeter = true;
                                    }

                                    $colsPaymentLeft = "col-xl-10 col-lg-9 col-12";
                                    $colsPaymentRight = "col-xl-2 col-lg-3 col-12";
                                    ?>

                                    <div class="sale-order-list-inner-row-body col-12">

                                        <div class="row">
                                            <div class="<?= $colsPaymentLeft ?> sale-order-list-payment">
                                                <div class="sale-order-list-payment-title">
                                                    <?
                                                    $paymentSubTitle = Loc::getMessage('SPOL_TPL_BILL') . " " . Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . htmlspecialcharsbx($payment['ACCOUNT_NUMBER']);
                                                    if (isset($payment['DATE_BILL'])) {
                                                        $paymentSubTitle .= " " . Loc::getMessage('SPOL_TPL_FROM_DATE') . " " . $payment['DATE_BILL']->format($arParams['ACTIVE_DATE_FORMAT']);
                                                    }
                                                    $paymentSubTitle .= ",";
                                                    echo "<span class='bold'>" . $paymentSubTitle . "</span>";
                                                    ?>
                                                    <span class="sale-order-list-payment-title-element bold"><?= $payment['PAY_SYSTEM_NAME'] ?></span>
                                                    <?
                                                    if ($payment['PAID'] === 'Y') {
                                                        ?>
                                                        <span class="sale-order-list-status-success"><?= Loc::getMessage('SPOL_TPL_PAID') ?></span>
                                                        <?
                                                    } elseif ($order['ORDER']['IS_ALLOW_PAY'] == 'N') {
                                                        ?>
                                                        <span class="sale-order-list-status-restricted"><?= Loc::getMessage('SPOL_TPL_RESTRICTED_PAID') ?></span>
                                                        <?
                                                    } else {
                                                        ?>
                                                        <span class="sale-order-list-status-alert"><?= Loc::getMessage('SPOL_TPL_NOTPAID') ?></span>
                                                        <?
                                                    }
                                                    ?>
                                                </div>
                                                <div class="sale-order-list-payment-price">
                                                    <span class="sale-order-list-payment-element"><?= Loc::getMessage('SPOL_TPL_SUM_TO_PAID') ?>:</span>

                                                    <span class="sale-order-list-payment-number"><?= $payment['FORMATED_SUM'] ?></span>
                                                </div>
                                                <?
                                                if (!empty($payment['CHECK_DATA'])) {
                                                    $listCheckLinks = "";
                                                    foreach ($payment['CHECK_DATA'] as $checkInfo) {
                                                        $title = Loc::getMessage('SPOL_CHECK_NUM', array('#CHECK_NUMBER#' => $checkInfo['ID'])) . " - " . htmlspecialcharsbx($checkInfo['TYPE_NAME']);
                                                        if (strlen($checkInfo['LINK'])) {
                                                            $link = $checkInfo['LINK'];
                                                            $listCheckLinks .= "<div><a href='$link' target='_blank'>$title</a></div>";
                                                        }
                                                    }
                                                    if (strlen($listCheckLinks) > 0) {
                                                        ?>
                                                        <div class="sale-order-list-payment-check">
                                                            <div class="sale-order-list-payment-check-left"><?= Loc::getMessage('SPOL_CHECK_TITLE') ?>:</div>
                                                            <div class="sale-order-list-payment-check-left">
                                                                <?= $listCheckLinks ?>
                                                            </div>
                                                        </div>
                                                        <?
                                                    }
                                                }
                                                if ($payment['PAID'] !== 'Y' && $order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y') {
                                                    ?>
                                                    <a class="sale-order-list-change-payment">
                                                        <span id="<?= htmlspecialcharsbx($payment['ACCOUNT_NUMBER']) ?>" class="click-change-payment bord-bot"><?= Loc::getMessage('SPOL_TPL_CHANGE_PAY_TYPE') ?></span>
                                                    </a>
                                                    <?
                                                }
                                                if ($order['ORDER']['IS_ALLOW_PAY'] == 'N' && $payment['PAID'] !== 'Y') {
                                                    ?>
                                                    <div class="sale-order-list-status-restricted-message-block">
                                                        <span class="sale-order-list-status-restricted-message"><?= Loc::getMessage('SOPL_TPL_RESTRICTED_PAID_MESSAGE') ?></span>
                                                    </div>
                                                    <?
                                                }
                                                ?>

                                            </div>
                                            <?
                                            if ($payment['PAID'] === 'N' && $payment['IS_CASH'] !== 'Y' && $payment['ACTION_FILE'] !== 'cash') {
                                                if ($order['ORDER']['IS_ALLOW_PAY'] == 'N') {
                                                    ?>
                                                    <div class="<?= $colsPaymentRight ?> sale-order-list-button-container">
                                                        <a class="button-def main-color little round-sq sale-order-list-button inactive-button">
                                                            <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                        </a>
                                                    </div>
                                                    <?
                                                } elseif ($payment['NEW_WINDOW'] === 'Y') {
                                                    ?>
                                                    <div class="<?= $colsPaymentRight ?> sale-order-list-button-container">
                                                        <a class="button-def main-color little round-sq sale-order-list-button" target="_blank" href="<?= htmlspecialcharsbx($payment['PSA_ACTION_FILE']) ?>">
                                                            <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                        </a>
                                                    </div>
                                                    <?
                                                } else {
                                                    ?>
                                                    <div class="<?= $colsPaymentRight ?> sale-order-list-button-container">
                                                        <a class="button-def main-color little round-sq sale-order-list-button ajax_reload" href="<?= htmlspecialcharsbx($payment['PSA_ACTION_FILE']) ?>">
                                                            <?= Loc::getMessage('SPOL_TPL_PAY') ?>
                                                        </a>
                                                    </div>
                                                    <?
                                                }
                                            }
                                            ?>

                                        </div>

                                    </div>
                                    <div class="col-12 sale-order-list-inner-row-template">
                                        <a class="sale-order-list-cancel-payment">
                                            <i class="fa fa-long-arrow-left"></i> <?= Loc::getMessage('SPOL_CANCEL_PAYMENT') ?>
                                        </a>
                                    </div>
                                </div>
                                <?
                            }
                            if (!empty($order['SHIPMENT'])) {
                                ?>
                                <div class="sale-order-list-inner-title-line">
                                    <span class="sale-order-list-inner-title-line-item"><?= Loc::getMessage('SPOL_TPL_DELIVERY') ?></span>
                                </div>
                                <?
                            }
                            $showDelimeter = false;
                            foreach ($order['SHIPMENT'] as $shipment) {
                                if (empty($shipment)) {
                                    continue;
                                }
                                ?>
                                <div class="row sale-order-list-inner-row">
                                    <?
                                    if ($showDelimeter) {
                                        
                                    } else {
                                        $showDelimeter = true;
                                    }
                                    ?>
                                    <div class="col-md-10 col-12 sale-order-list-shipment">
                                        <div class="sale-order-list-shipment-title">
                                            
                                            <span class="sale-order-list-shipment-element">
                                                <span class='bold'><?= Loc::getMessage('SPOL_TPL_LOAD') ?> </span>
                                                <?
                                                $shipmentSubTitle = Loc::getMessage('SPOL_TPL_NUMBER_SIGN') . htmlspecialcharsbx($shipment['ACCOUNT_NUMBER']);
                                                if ($shipment['DATE_DEDUCTED']) {
                                                    $shipmentSubTitle .= " " . Loc::getMessage('SPOL_TPL_FROM_DATE') . " " . $shipment['DATE_DEDUCTED']->format($arParams['ACTIVE_DATE_FORMAT']);
                                                }
												
												if($shipment['PRICE_DELIVERY'] > 0)
												{
	                                                if ($shipment['FORMATED_DELIVERY_PRICE']) {
	                                                    $shipmentSubTitle .= ", " . Loc::getMessage('SPOL_TPL_DELIVERY_COST') . " " . $shipment['FORMATED_DELIVERY_PRICE'];
	                                                }
												}
												else
												{
													$shipmentSubTitle .= ", " . Loc::getMessage('DELIV_PAY_LATER');
												}
                                                echo "<span class='bold'>" . $shipmentSubTitle . "</span>";
												//echo "<pre>"; print_r($shipment); echo "</pre>";
                                                ?>
                                            </span>
                                             
                                             
                                            <?
                                            if ($shipment['DEDUCTED'] == 'Y') {
                                                ?>
                                                <span class="sale-order-list-status-success"><?= Loc::getMessage('SPOL_TPL_LOADED'); ?></span>
                                                <?
                                            } else {
                                                ?>
                                                <span class="sale-order-list-status-alert"><?= Loc::getMessage('SPOL_TPL_NOTLOADED'); ?></span>
                                                <?
                                            }
                                            ?>
                                        </div>

                                        <div class="sale-order-list-shipment-status">
                                            <span class="sale-order-list-shipment-status-item"><?= Loc::getMessage('SPOL_ORDER_SHIPMENT_STATUS'); ?>:</span>
                                            <span class="sale-order-list-shipment-status-block"><?= htmlspecialcharsbx($shipment['DELIVERY_STATUS_NAME']) ?></span>
                                        </div>

                                        <?
                                        if (!empty($shipment['DELIVERY_ID'])) {
                                            ?>
                                            <div class="sale-order-list-shipment-item">
                                                <?= Loc::getMessage('SPOL_TPL_DELIVERY_SERVICE') ?>:
                                                <?= $shipment["DELIVERY_NAME"] ?>
                                            </div>
                                            <?
                                        }

                                        if (!empty($shipment['TRACKING_NUMBER'])) {
                                            ?>
                                            <div class="sale-order-list-shipment-item">
                                                <span class="sale-order-list-shipment-id-name"><?= Loc::getMessage('SPOL_TPL_POSTID') ?>:</span>
                                                <span class="sale-order-list-shipment-id"><?= htmlspecialcharsbx($shipment['TRACKING_NUMBER']) ?></span>
                                                <span class="sale-order-list-shipment-id-icon"></span>
                                            </div>
                                            <?
                                        }
                                        ?>
                                    </div>
                                    <?
                                    if (strlen($shipment['TRACKING_URL']) > 0) {
                                        ?>
                                        <div class="col-md-2 col-12 sale-order-list-shipment-button-container">
                                            <a class="sale-order-list-shipment-button" target="_blank" href="<?= $shipment['TRACKING_URL'] ?>">
                                                <?= Loc::getMessage('SPOL_TPL_CHECK_POSTID') ?>
                                            </a>
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                                <?
                            }
                           ?>

                            <div class="sale-order-list-top-border outside"></div>



                            <div class="row sale-order-list-inner-row">
                                <div class="col-md-auto col-12 sale-order-list-about-container">
                                    <a class="button-def main-color little round-sq sale-order-list-about-link" href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>"><?= Loc::getMessage('SPOL_TPL_MORE_ON_ORDER') ?></a>
                                </div>
                                <div class="col-md-auto col-12 sale-order-list-repeat-container">
                                    <a class="button-def main-color little round-sq  sale-order-list-repeat-link" href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>"><?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?></a>
                                </div>
                                <?
                                if ($order['ORDER']['CAN_CANCEL'] !== 'N') {
                                    ?>
                                    <div class="col-md col-12 sale-order-list-cancel-container">
                                        <a class="button-def secondary little round-sq  sale-order-list-cancel-link" href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_CANCEL"]) ?>"><?= Loc::getMessage('SPOL_TPL_CANCEL_ORDER') ?></a>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>


                        </div>
                    </div>
                    <??>
                </div>
                <?
            }
        }
    } else {
        $orderHeaderStatus = null;

        if ($_REQUEST["show_canceled"] === 'Y' && count($arResult['ORDERS'])) {
            ?>
            <div class="sale-order-title bold">
                <?= Loc::getMessage('SPOL_TPL_ORDERS_CANCELED_HEADER') ?>
            </div>
            <?
        }

        if (!empty($arResult['ORDERS'])) {
            foreach ($arResult['ORDERS'] as $key => $order) {
                if ($orderHeaderStatus !== $order['ORDER']['STATUS_ID'] && $_REQUEST["show_canceled"] !== 'Y') {
                    $orderHeaderStatus = $order['ORDER']['STATUS_ID'];
                    ?>
                    <div class="sale-order-title bold">
                        <?= Loc::getMessage('SPOL_TPL_ORDER_IN_STATUSES') ?> &laquo;<?= htmlspecialcharsbx($arResult['INFO']['STATUS'][$orderHeaderStatus]['NAME']) ?>&raquo;
                    </div>
                    <?
                }
                ?>
                <div class="col-12 sale-order-list-container">
                    <div class="row">
                        <div class="col-12 sale-order-list-accomplished-title-container">
                            <div class="row">
                                <div class="col-12 sale-order-list-accomplished-title-container">
                                    <div class="sale-order-list-accomplished-title bold">
                                        <?= Loc::getMessage('SPOL_TPL_ORDER') ?>
                                        <?= Loc::getMessage('SPOL_TPL_NUMBER_SIGN') ?>
                                        <?= htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']) ?>
                                        <?= Loc::getMessage('SPOL_TPL_FROM_DATE') ?>
                                        <?= $order['ORDER']['DATE_INSERT'] ?>,
                                        <?= count($order['BASKET_ITEMS']); ?>
                                        <?
                                        $count = substr(count($order['BASKET_ITEMS']), -1);
                                        if ($count == '1') {
                                            echo Loc::getMessage('SPOL_TPL_GOOD');
                                        } elseif ($count >= '2' || $count <= '4') {
                                            echo Loc::getMessage('SPOL_TPL_TWO_GOODS');
                                        } else {
                                            echo Loc::getMessage('SPOL_TPL_GOODS');
                                        }
                                        ?>
                                        <?= Loc::getMessage('SPOL_TPL_SUMOF') ?>
                                        <?= $order['ORDER']['FORMATED_PRICE'] ?>
                                    </div>
                                </div>
                                <div class="col-12 sale-order-list-accomplished-date-container">
                                    <?
                                    if ($_REQUEST["show_canceled"] !== 'Y') {
                                        ?>
                                        <span class="sale-order-list-accomplished-date">
                                            <?= Loc::getMessage('SPOL_TPL_ORDER_FINISHED') ?>
                                        </span>
                                        <?
                                    } else {
                                        ?>
                                        <span class="sale-order-list-accomplished-date canceled-order">
                                            <?= Loc::getMessage('SPOL_TPL_ORDER_CANCELED') ?>
                                        </span>
                                        <?
                                    }
                                    ?>
                                    <span class="sale-order-list-accomplished-date-number"><?= $order['ORDER']['DATE_STATUS_FORMATED'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 sale-order-list-inner-accomplished">
                            <div class="row sale-order-list-inner-row">
                                <div class="col-md-6 col-12 sale-order-list-about-accomplished">
                                    <a class="button-def main-color little round-sq sale-order-list-about-link" href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_DETAIL"]) ?>">
                                        <?= Loc::getMessage('SPOL_TPL_MORE_ON_ORDER') ?>
                                    </a>
                                </div>
                                <div class="col-md-6 col-12 sale-order-list-repeat-accomplished">
                                    <a class="button-def main-color little round-sq sale-order-list-repeat-link sale-order-link-accomplished" href="<?= htmlspecialcharsbx($order["ORDER"]["URL_TO_COPY"]) ?>">
                                        <?= Loc::getMessage('SPOL_TPL_REPEAT_ORDER') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?
            }
        }
    }
    ?>
    <div class="clearfix"></div>
    <?
    echo $arResult["NAV_STRING"];

    if ($_REQUEST["filter_history"] !== 'Y') {
        $javascriptParams = array(
            "url" => CUtil::JSEscape($this->__component->GetPath() . '/ajax.php'),
            "templateFolder" => CUtil::JSEscape($templateFolder),
            "templateName" => $this->__component->GetTemplateName(),
            "paymentList" => $paymentChangeData
        );
        $javascriptParams = CUtil::PhpToJSObject($javascriptParams);
        ?>
        <script>
            BX.Sale.PersonalOrderComponent.PersonalOrderList.init(<?= $javascriptParams ?>);
        </script>
        <?
    }
}
?>
