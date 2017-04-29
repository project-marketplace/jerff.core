<?php

use Bitrix\Main\Application,
    Bitrix\Main\ModuleManager,
    Bitrix\Main\EventManager,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Loader,
    Project\Core\Model\FavoritesTable,
    Project\Core\Model\RedirectTable;

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
        $eventManager = EventManager::getInstance();
        Loader::includeModule($this->MODULE_ID);

        $eventManager = Bitrix\Main\EventManager::getInstance();
        $eventManager->registerEventHandler('main', 'OnPageStart', $this->MODULE_ID, '\Project\Core\Event\Redirect', 'OnPageStart');

        $this->GetConnection()->query("CREATE TABLE IF NOT EXISTS " . FavoritesTable::getTableName() . " (
            ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            TYPE VARCHAR(255),
            ELEMENT_ID INT,
            USER_ID INT
        );");
        $this->GetConnection()->query("CREATE TABLE IF NOT EXISTS " . RedirectTable::getTableName() . " (
            ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
            URL VARCHAR(1000),
            TYPE VARCHAR(255),
            NEW_URL VARCHAR(255),
            ELEMENT INT,
            PARAM1 INT
        );");
    }

    public function DoUninstall() {
        Loader::includeModule($this->MODULE_ID);

        $eventManager = EventManager::getInstance();
        $eventManager->unRegisterEventHandler('main', 'OnPageStart', $this->MODULE_ID, '\Project\Core\Event\Redirect', 'OnPageStart');

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function dropTable() {
        $this->GetConnection()->query("DROP TABLE IF EXISTS " . FavoritesTable::getTableName() . ";");
    }

    protected function GetConnection() {
        return Application::getInstance()->getConnection(FavoritesTable::getConnectionName());
    }

}
