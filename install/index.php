<?php

use Bitrix\Main\ModuleManager,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader;

IncludeModuleLangFile(__FILE__);

class project_core extends CModule {

    public $MODULE_ID = 'project.core';

    function __construct() {
        $arModuleVersion = array();

        include(__DIR__ . '/version.php');
        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('PROJECT_CORE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('PROJECT_CORE_DESCRIPTION');
        $this->PARTNER_NAME = Loc::getMessage('PROJECT_CORE_PARTNER_NAME');
        $this->PARTNER_URI = '';
    }

    public function DoInstall() {
        ModuleManager::registerModule($this->MODULE_ID);
        Loader::includeModule($this->MODULE_ID);
        $this->InstallEvent();
    }

    public function DoUninstall() {
        Loader::includeModule($this->MODULE_ID);
        $this->UnInstallEvent();
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    /*
     * InstallEvent
     */

    public function InstallEvent() {
        $eventManager = Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler('main', 'OnPageStart', $this->MODULE_ID, '\Project\Core\Event\Page', 'OnPageStart');
    }

    public function UnInstallEvent() {
        $eventManager = Bitrix\Main\EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main', 'OnPageStart', $this->MODULE_ID, '\Project\Core\Event\Page', 'OnPageStart');
    }

}
