<?

$arAvailableSort = array();

$arSorts = Array("PROPERTY_EXPENSE", "PRICE", "NAME");

if (in_array("PROPERTY_EXPENSE", $arSorts)) { 
    $arAvailableSort["PROPERTY_EXPENSE"] = array("PROPERTY_EXPENSE", "desc");
}

if (in_array("SORT", $arSorts)) {
    $arAvailableSort["SORT"] = array("SORT", "desc");
}
if (in_array("PRICE", $arSorts)) {
    $arAvailableSort["PRICE"] = array("CATALOG_PRICE_SCALE_" . $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]["TYPE_PRICE_SORT"]["VALUE"], "desc");
}
if (in_array("NAME", $arSorts)) {
    $arAvailableSort["NAME"] = array("NAME", "desc");
}
if (in_array("QUANTITY", $arSorts)) {
    $arAvailableSort["CATALOG_QUANTITY"] = array("QUANTITY", "desc");
}


$arSortVal = explode("__", $PHOENIX_TEMPLATE_ARRAY["ITEMS"]["CATALOG"]["ITEMS"]["SECTION_SORT_LIST"]["VALUE"]);

$sort2 = $arSortVal[0];
$sort_order2 = $arSortVal[1];

if ($_REQUEST["sort"]) {
    $sort2 = ToUpper($_REQUEST["sort"]);
    $_SESSION["sort"] = ToUpper($_REQUEST["sort"]);
} elseif ($_SESSION["sort"]) {
    $sort2 = ToUpper($_SESSION["sort"]);
}

if ($_REQUEST["order"]) {

    $sort_order2 = $_REQUEST["order"];
    $_SESSION["order"] = $_REQUEST["order"];
} elseif ($_SESSION["order"]) {
    $sort_order2 = $_SESSION["order"];
}
?>
<div class="element-sort">

<? foreach ($arAvailableSort as $key => $val): ?>
    <?
    $newSort = $sort_order2 == 'desc' ? 'asc' : 'desc';

    ?>

        <div class="wrap-sort">
            <a <? /* href="<?=$url;?>#actionbox" */ ?> class="sort_btn sort_btn_js <?= ($sort2 == $key ? 'active' : '') ?> <?= htmlspecialcharsbx($sort_order2) ?> <?= $key ?>" rel="nofollow" data-sort="<?= $key ?>" data-order="<?= $newSort ?>">
        <?= $PHOENIX_TEMPLATE_ARRAY["MESS"]['SORT_CATALOG_' . $key] ?>

            </a>
        </div>

            <? endforeach; ?>


</div>




<?
$tmpsort = $sort2;

if ($sort2 == "PRICE") {
    $sort2 = $arAvailableSort["PRICE"][0];
}

if ($sort2 == "CATALOG_AVAILABLE") {
    $sort2 = "CATALOG_QUANTITY";
}

$sort1 = "PROPERTY_MODE_ARCHIVE";
$sort_order1 = "asc";
?>