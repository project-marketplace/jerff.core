<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule('Sale')) {
    return false;
}

use \Bitrix\Sale\Location;

// Select favorite locations
$res = Location\DefaultSiteTable::getList(array(
    'filter' => array(
        'SITE_ID' => SITE_ID,
        'LOCATION.NAME.LANGUAGE_ID' => LANGUAGE_ID
    ),
    'order' => array(
        'SORT' => 'asc'
    ),
    'select' => array(
        'ID' => 'LOCATION.ID',
        'NAME' => 'LOCATION.NAME.NAME'
    )
));

while($def_city = $res->Fetch())
    $arResult['DEFAULT_CITIES'][] = $def_city;


$this->IncludeComponentTemplate();
?>