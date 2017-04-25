<?php

namespace Project\Core\Model;

use Bitrix\Main\Entity\DataManager,
    Bitrix\Main;

class FavoritesTable extends DataManager {

    public static function getTableName() {
        return 'project_favorits';
    }

    public static function getMap() {
        $fieldsMap = array(
            new Main\Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
                    )),
            new Main\Entity\IntegerField('ELEMENT_ID'),
            new Main\Entity\IntegerField('USER_ID'),
            new Main\Entity\StringField('TYPE'),
        );
        return $fieldsMap;
    }

}
