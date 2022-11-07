<?php
$arUrlRewrite=array (
  12 => 
  array (
    'CONDITION' => '#^={$arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"]."#actionbox"}\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/local/templates/divasoft/components/bitrix/catalog/catalog/section.php',
    'SORT' => 100,
  ),
  14 => 
  array (
    'CONDITION' => '#^/online/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  16 => 
  array (
    'CONDITION' => '#^/video/([\\.\\-0-9a-zA-Z]+)(/?)([^/]*)#',
    'RULE' => 'alias=$1&videoconf',
    'ID' => 'bitrix:im.router',
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  15 => 
  array (
    'CONDITION' => '#^/online/(/?)([^/]*)#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/desktop_app/router.php',
    'SORT' => 100,
  ),
  0 => 
  array (
    'CONDITION' => '#^/personal/order/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.order',
    'PATH' => '/personal/order/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/basket/order/#',
    'RULE' => '',
    'ID' => 'concept:phoenix.basket',
    'PATH' => '/basket/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/personal/#',
    'RULE' => '',
    'ID' => 'bitrix:sale.personal.section',
    'PATH' => '/personal/index.php',
    'SORT' => 100,
  ),
  13 => 
  array (
    'CONDITION' => '#^/catalog/#',
    'RULE' => '',
    'ID' => 'bitrix:catalog',
    'PATH' => '/catalog/index.php',
    'SORT' => 100,
  ),
  3 => 
  array (
    'CONDITION' => '#^/search/#',
    'RULE' => '',
    'ID' => 'concept:phoenix.search',
    'PATH' => '/search/index.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/brands/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/brands/index.php',
    'SORT' => 100,
  ),
  6 => 
  array (
    'CONDITION' => '#^/offers/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/offers/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/news/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/news/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/#',
    'RULE' => '',
    'ID' => 'concept:phoenix.pages',
    'PATH' => '/index.php',
    'SORT' => 100,
  ),
);
