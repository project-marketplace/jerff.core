<?php

if (!defined('\Project\Tools\Modules\IS_START')) {
    include_once(dirname(__DIR__) . '/project.tools/include.php');
}

use Bitrix\Main\Localization\Loc,
    Project\Tools\Modules;

IncludeModuleLangFile(__FILE__);

class project_core extends CModule {

    public $MODULE_ID = 'project.core';
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;

    use Modules\Install;

    function __construct() {
        $this->setParam(__DIR__, 'PROJECT_CORE');
        $this->MODULE_NAME = Loc::getMessage('PROJECT_CORE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('PROJECT_CORE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('PROJECT_CORE_PARTNER_NAME');
        $this->PARTNER_URI = Loc::getMessage('PROJECT_CORE_PARTNER_URI');
    }

    public function DoInstall() {
        $this->Install();
    }

    public function DoUninstall() {
        $this->Uninstall();
    }

    /*
     * InstallEvent
     */

    public function InstallEvent() {
        $this->registerEventHandler('main', 'OnPageStart', '\Project\Core\Event\Page', 'OnPageStart');
    }

    public function UnInstallEvent() {
        $this->unRegisterEventHandler('main', 'OnPageStart', '\Project\Core\Event\Page', 'OnPageStart');
    }

}
