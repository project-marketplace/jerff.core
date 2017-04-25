<?php

namespace Project\Core;

use Bitrix\Main\Application;

class Sort {

    static public function init($name, $map) {
        global $APPLICATION;
        $request = Application::getInstance()->getContext()->getRequest();
        $item = $request->get($name);
        $default = key($map);
        if (!isset($map[$item])) {
            $item = $default;
        }
        $map[$item]['select'] = true;
        foreach ($map as $key => &$value) {
            $value['url'] = $APPLICATION->GetCurPageParam($default == $key ? '' : $name . '=' . $key, array($name, 'clear_cache', 'bitrix_include_areas'));
        }
        $map[$item]['key'] = strtoupper($item);
        return array($map[$item], $map);
    }

}
