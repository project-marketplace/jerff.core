# Api для сайта #

* отладка 
* создание форм
* редиректы
* избранные

Отправка формы
отправляет формы, и генерирует все события (почт, скь)

```
#!php
if (Bitrix\Main\Loader::includeModule('project.core')) {
    Project\Core\Form::add($FORM_ID, array(
        'NAME' => 'Имя',
        'EMAIL' => 'E-mail',
        'COMMENT' => 'Комментарий'
    ));
}
```

Ресайтинг фото

```
#!php
if (Bitrix\Main\Loader::includeModule('project.core')) {
    $item['SRC'] = Project\Core\Image::resize($item['ID'], 200, 200);
}; 
```

Кеширование данных

```
#!php
if (Bitrix\Main\Loader::includeModule('project.core')) {
    Project\Core\Utility::useCache(array('game', $gameId), function() use($gameId) {
        $arSelect = Array("ID", "NAME", 'PROPERTY_SELLER');
        $arFilter = Array("IBLOCK_ID" => Game\Config::DZHO_IBLOCK, "ID" => $gameId);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($arItem = $res->GetNext()) {
            return array(
                'ID' => $arItem['ID'],
                'SELLER_ID' => $arItem['PROPERTY_SELLER_VALUE'],
                'THEME' => [
                    'USER' => 'Покупка игры',
                    'SELLER' => 'Продажа игры',
                    'FORUM' => 'Продажа игры: «' . $arItem['NAME'] . '»'
                ]
            );
        }
        return false;
    });
}
```