<?

namespace Project\Core\Event;

use CDBResult,
    CIBlockElement,
    CIBlockSection,
    Project\Core\Iblock\Config,
    Project\Core\Model\RedirectTable;

class Redirect {

    public static function toUrl($url) {
        LocalRedirect($url, false, '301 Moved permanently');
    }

    public static function OnPageStart() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $rsData = RedirectTable::getList(array(
                        'select' => array('TYPE', 'NEW_URL', 'ELEMENT', 'PARAM1'),
                        'filter' => array('URL' => $_SERVER['REQUEST_URI'])
            ));
            $rsData = new CDBResult($rsData);
            if ($arItem = $rsData->Fetch()) {
                if(!empty($arItem['NEW_URL'])) {
                    self::toUrl($arItem['NEW_URL']);
                }
                switch ($arItem['TYPE']) {
                    case 'SECTION':
                        $arFilter = Array(
                            'IBLOCK_ID' => Config::CATALOG_ID,
                            'ID' => $arItem['ELEMENT']
                        );
                        $res = CIBlockSection::GetList(array(), $arFilter, false, array('SECTION_PAGE_URL '));
                        if ($arItem = $res->GetNext()) {
                            self::toUrl($arItem['SECTION_PAGE_URL']);
                        }
                        break;

                    case 'PRODUCT':
                        $arSelect = Array(
                            'DETAIL_PAGE_URL',
                        );
                        $arFilter = Array(
                            'IBLOCK_ID' => Config::CATALOG_ID,
                            'ID' => $arItem['ELEMENT']
                        );
                        $res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
                        if ($arItem = $res->GetNext()) {
                            self::toUrl($arItem['DETAIL_PAGE_URL']);
                        }
                        break;

                    default:
                        break;
                }
            }
//            str
//            preExit($_SERVER['REQUEST_URI']);
        }
    }

}
