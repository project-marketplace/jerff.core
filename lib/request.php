<?php

namespace Project\Core;

use Bitrix\Main\Application;

class Request {

    static public function restart() {
        Application::getInstance()->initializeExtendedKernel(array(
            "get" => $_GET,
            "post" => $_POST,
            "files" => $_FILES,
            "cookie" => $_COOKIE,
            "server" => $_SERVER,
            "env" => $_ENV
        ));
    }

}
