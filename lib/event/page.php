<?

namespace Project\Core\Event;

use Project\Core\Config,
    Project\Core\Location;

class Page {

    public static function OnPageStart() {
        /*
         * <?=$_SESSION['LOCATION']['CURRENT_CITY'];?>
         */
        if (Config::IS_LOCATION) {
            if ($_SESSION['LOCATION']['CURRENT_CITY']) {
                setcookie('LOCATION[CURRENT_CITY]', $_SESSION['LOCATION']['CURRENT_CITY'], time() + (86400 * 7));
                setcookie('LOCATION[ID]', $_SESSION['LOCATION']['ID'], time() + (86400 * 7));
            } else if ($_COOKIE['LOCATION']['CURRENT_CITY']) {
                Location::setCity($_COOKIE['LOCATION']['CURRENT_CITY']);
            } else {
                Location::setCity(Location::getCityByIp());
            }
        }
    }

}
