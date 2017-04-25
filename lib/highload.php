<?php

namespace Project\Core;

use Bitrix\Main\Loader,
    Bitrix\Highloadblock\HighloadBlockTable;

class Highload {

    static public function get($name) {
        static $cache = array();
        if (empty($cache[$name]) and Loader::includeModule('highloadblock')) {
            $arData = HighloadBlockTable::getList(array('filter' => array('NAME' => $name)))->fetch();
            $cache[$name] = HighloadBlockTable::compileEntity($arData)->getDataClass();
        }
        return $cache[$name];
    }

}
