# Модуль заготовка для битрикс маркетплейс

- модуль можно использовать:
    - как основу для других модулей
    - как заготовку для битрикс маркетплейс

## Сборка для маркетплейса
- установить сборщик модуля на NodeJs `npm install && npm install gulp-build-bitrix-modul --save`
- используется модуль на galp 4 [gulp-build-bitrix-modul](https://www.npmjs.com/package/gulp-build-bitrix-modul)
- `npm run build` - собирает всю сборку для маркетплейса
- `npm run release` - собирает utf-8 и cp1251 архивы
- `npm run last_version` - собирает текущею версии модуля для маркетплейса
- `npm run release` - собирает обновления модуля

## Обновления
- для установки обновлений, в папке /dist/version/1.1.0 должны быть:
    - /description.* (обязательный) - содержит описание обновления, где * - идентификатор языка в системе
    - /updater.php – файл запускается при установке обновления
    - /version_control.php - служит для организации связи между версиями модулей.

## Подмодули проекта
- если у вашего модуля есть git подмодули, то код будет перекодирован, в итоге ваши модули не будут конфликтовать друг с другом

было:
```php
namespace Project\Tools\Sale;

use CCatalogDiscount,
    Bitrix\Main\Loader,
    Project\Tools\Utility\Cache;
```
стало
```php
namespace Project\Ver7348d5c7870f19b39d83f080ca9e708bbba1c3d2\Tools\Sale;

use CCatalogDiscount,
    Bitrix\Main\Loader,
    Project\Ver7348d5c7870f19b39d83f080ca9e708bbba1c3d2\Tools\Utility\Cache;
```
