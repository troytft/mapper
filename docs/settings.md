# Settings
Настройки задаются с помощью объекта Settings

```php
$settings = new Mapper\DTO\Settings();
$settings
    ->setIsPropertiesNullableByDefault(false)
    ->setIsAllowedUndefinedKeysInData(false)
    ->setIsClearMissing(false);

$mapper = new Mapper\Mapper($settings);
$mapper->map($model, $data);
```

### setIsPropertiesNullableByDefault
Значение по-умолчанию для параметра `nullable`

default: `false`

### setIsAllowedUndefinedKeysInData
Разрешены ли в массиве с данными ключи, для которых нет свойств в модели

default: `false`

### setIsClearMissing
Рстановить `null` для тех полей, которые не были представленны в данных

default: `false`
