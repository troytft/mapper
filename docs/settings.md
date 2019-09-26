# Settings

Settings you can set by class `Mapper\DTO\Settings`

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
Sets value by default for option `nullable`. If parameter enabled, then value for property should be presented in data and not be null.

default: `false`

### setIsAllowedUndefinedKeysInData
If parameter disabled and undefined key exists in data, then Mapper throws `Mapper\Exception\MappingValidation\UndefinedKeyException`

default: `false`

### setIsClearMissing
If parameter enabled, then Mapper force `null` value for properties not presented in data

default: `false`
