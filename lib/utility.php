<?php

namespace Project\Core;

use Bitrix\Main\Data\Cache;

class Utility {

    const CACHE_DAY = 86400;
    const CACHE_TIME = 3600;
    const CACHE_MINUTE = 60;
    const CACHE_DIR = '/project.core/';

    static public function startComposer() {
        require $_SERVER["DOCUMENT_ROOT"] . '/local/vendor/autoload.php';
    }

    static public function useCache($cacheId, $func, $time = self::CACHE_TIME) {
        if (!Config::IS_CACHE) {
            return $func();
        }
        $cacheId = 'project.core:' . $time . ':' . (is_array($cacheId) ? implode(':', $cacheId) : $cacheId);
        $cache = Cache::createInstance();
        if ($cache->initCache($time, $cacheId, self::CACHE_DIR)) {
//            pre('get');
            $arResult = $cache->getVars();
        } elseif ($cache->startDataCache()) {
            $arResult = $func();
            if (empty($arResult)) {
//                pre('abortDataCache');
                $cache->abortDataCache();
            } else {
//                pre('set');
            }
            $cache->endDataCache($arResult);
        }
//        pre($cacheId, $arResult);
        return $arResult;
    }

}
