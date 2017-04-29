<?php

namespace Project\Core\Model;

use Bitrix\Main\Entity\DataManager,
    Bitrix\Main;

class RedirectTable extends DataManager {

    public static function getTableName() {
        return 'project_redirect';
    }

    public static function getMap() {
        $fieldsMap = array(
            new Main\Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
                    )),
            new Main\Entity\StringField('URL'),
            new Main\Entity\StringField('TYPE'),
            new Main\Entity\StringField('NEW_URL'),
            new Main\Entity\IntegerField('ELEMENT'),
            new Main\Entity\IntegerField('PARAM1')
        );
        return $fieldsMap;
    }

}
