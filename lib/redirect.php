<?php

namespace Project\Core;

use CDBResult,
    Project\Core\Model\RedirectTable;

class Redirect {

    static public function add($url, $type, $id, $param1=0) {
        $rsData = RedirectTable::getList(array(
                    "select" => array('ID'),
                    'filter' => array('URL' => $url)
        ));
        $rsData = new CDBResult($rsData);
        if ($arItem = $rsData->Fetch()) {
            $arBxData = array(
                'ELEMENT' => $id,
                'PARAM1' => $param1
            );
            RedirectTable::update($arItem['ID'], $arBxData);
        } else {
            $arBxData = array(
                'URL' => $url,
                'TYPE' => $type,
                'ELEMENT' => $id,
                'PARAM1' => $param1
            );
            RedirectTable::add($arBxData);
        }
    }

}
