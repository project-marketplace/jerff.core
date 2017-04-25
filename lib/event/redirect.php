<?

namespace Project\Core\Event;

use CDBResult,
    CIBlockElement,
    Project\Core\Iblock\Config,
    Project\Core\Model\RedirectTable;

class Redirect {

    public static function OnPageStart() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $rsData = RedirectTable::getList(array(
                        "select" => array('TYPE', 'ELEMENT'),
                        'filter' => array('URL' => $_SERVER['REQUEST_URI'])
            ));
            $rsData = new CDBResult($rsData);
            if ($arItem = $rsData->Fetch()) {
                $arSelect = Array(
                    'DETAIL_PAGE_URL',
                );
                $arFilter = Array(
                    "IBLOCK_ID" => Config::IBLOCK_ID,
                    'ID' => $arItem['ELEMENT']
                );
                $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
                if ($arItem = $res->GetNext()) {
                    LocalRedirect($arItem['DETAIL_PAGE_URL'], false, "301 Moved permanently");
                }
            }
        }
    }

}
