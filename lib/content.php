<?php

namespace Project\Core;

class Content {

    static public function ShowTitle() {
        global $APPLICATION;
        $APPLICATION->AddBufferContent(function() {
            global $APPLICATION;
            $res = $APPLICATION->sDocTitle;
            if (strip_tags($res) == $res) {
                $res = explode(' ', $res);
                $first = array_shift($res);
                $res = '<span>' . $first . '</span> ' . implode(' ', $res);
            }
            return $res;
        });
    }

}
