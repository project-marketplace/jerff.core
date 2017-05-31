<?

namespace Project\Core\Trains;

use Exception;

trait Event {

    static private $isStart = array();

    static protected function evetType() {
        throw new Exception('Установите тип события');
    }

    static protected function start() {
        if (empty(self::$isStart[static::evetType()])) {
            self::$isStart[static::evetType()] = true;
            return true;
        } else {
            return false;
        }
    }

    static protected function stop() {
        unset(self::$isStart[static::evetType()]);
        return false;
    }

}
