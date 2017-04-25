<?php

namespace Project\Core;

class Utility {

    const CACHE_TIME = 3600;
    const CACHE_DIR = '/project.core/';

    static public function useCache($cacheId, $func, $time = self::CACHE_TIME) {
        $obCache = new \CPHPCache;
        $cacheId = 'project.core:' . $time . ':' . (is_array($cacheId) ? implode(':', $cacheId) : $cacheId);
        if (Config::IS_CACHE and $obCache->InitCache($time, $cacheId, self::CACHE_DIR)) {
            $arResult = $obCache->GetVars();
        } elseif ($obCache->StartDataCache()) {
            $arResult = $func();
            $obCache->EndDataCache($arResult);
        }
        return $arResult;
    }

}
