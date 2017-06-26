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
        $this->InstallFiles();
    }

    public function DoUninstall() {
        Loader::includeModule($this->MODULE_ID);
        $this->UnInstallEvent();
        $this->UnInstallFiles();
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

    /*
     * InstallFiles
     */

    public function InstallFiles($arParams = array()) {
        CopyDirFiles($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/themes/.default/', $_SERVER['DOCUMENT_ROOT'] . '/local/themes/.default/' . $this->MODULE_ID . '/', true, true);
    }

    public function UnInstallFiles() {
        DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/themes/.default/', $_SERVER['DOCUMENT_ROOT'] . '/local/themes/.default/' . $this->MODULE_ID . '/'); //css
    }

}
