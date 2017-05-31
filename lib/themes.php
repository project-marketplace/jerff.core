<?php

namespace Project\Core;

use Bitrix\Main\Page\Asset;

class Themes {

    static public function addJs($path) {
        Asset::getInstance()->addJs('/local/themes/.default/project.core/' . $path);
    }

}
