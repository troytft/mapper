# Settings
Настройки задаются с помощью объекта Mapper\DTO\Settings

```php
$settings = new Mapper\DTO\Settings();
$settings
    ->setIsPropertiesNullableByDefault(false)
    ->setIsAllowedUndefinedKeysInData(false)
    ->setIsClearMissing(false);

$mapper = new Mapper\Mapper($settings);
$mapper->map($model, $data);
```

* `setIsPropertiesNullableByDefault` (default: `false`) – значение по-умолчанию для параметра `nullable`
* `setIsAllowedUndefinedKeysInData` (default: `false`) – разрешены ли в массиве с данными ключи, для которых нет свойств в модели
* `setIsClearMissing` (default: `false`) – установить `null` для тех полей, которые не были представленны в данных
