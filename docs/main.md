# Documentation
* [`Usage`](usage.md)
# Installation

```bash
composer require troytft/mapper
```


# Types
У каждого типа есть булевый параметр `nullable`,  он отвечает за то, можно ли в свойство передать `null`. 
Если параметр для конкретного свойства не задан – будет использовано значение по-умолчанию из настроек маппера.

* **StringType** – свойство принимает строку или `null`, можно указать параметр `transformer` с классом трансформера
* **BooleanType** – свойство принимает бул или `null`, можно указать параметр `transformer` с классом трансформера
* **IntegerType** – свойство принимает целое число или `null`, можно указать параметр `transformer` с классом трансформера
* **FloatType** – свойство принимает дробное число или `null`, можно указать параметр `transformer` с классом трансформера
* **ObjectType** – свойство принимает объект или `null`, в параметре `class` необходимо указать класс, который будет использован в качестве модели. Этот класс должен наследовать интерфейс `Mapper\ModelInterface`.
* **CollectionType** – свойство принимает коллекцию элементов или null, в параметре `type` необходимо указать аннотацию с типом элементов коллекции.

# Transformers
Трансформеры – специальные классы, которые получают сырые данные и конвертируют их в необходимый результат.

* Трансформеры можно использовать только для скалярных типов
* В трансформер не доходят `null` значения
* Внутри трансформера можно выбрасывать исключения, наследующие интерфейс `Mapper\Exception\TransformerExceptionInterface`, такое исключение будет отловленно и вместо него будет выброшено `Mapper\Exception\Transformer\WrappedTransformerException` с установленным путем до свойства.

# Exceptions
Все исключения наследуют интерфейс `Mapper\ExceptionInterface`, возможные варианты:

* `Mapper\Exception\SetterDoesNotExistException` – в случае если не найден сеттер
* `Mapper\Exception\UndefinedTransformerException` – в случае если не найден трансформер
* `Mapper\Exception\MappingValidation\CollectionRequiredException` – значение должно быть коллекцией, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`
* `Mapper\Exception\MappingValidation\ScalarRequiredException` – значение должно быть скаляром, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`
* `Mapper\Exception\MappingValidation\ObjectRequiredException` – значение должно быть объектом, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`
* `Mapper\Exception\MappingValidation\UndefinedKeyException` – данные содержать ключ, для которого не найдено свойство в модели, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`
* `Mapper\Exception\Transformer\WrappedTransformerException` – в случае если трансформер выбросил исключение, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`, а так же оригинальный эксепшен доступный через `getPrevious()`:
    * `Mapper\Exception\Transformer\StringRequiredException` – значение должно быть строкой
    * `Mapper\Exception\Transformer\IntegerRequiredException` – значение должно быть целым числом
    * `Mapper\Exception\Transformer\BooleanRequiredException` – значение должно быть булем
    * `Mapper\Exception\Transformer\FloatRequiredException` – значение должно быть десятичной дробью

# Settings
* `setIsPropertiesNullableByDefault` – значение по-умолчанию для параметра `nullable`
* `setIsAllowedUndefinedKeysInData` – разрешены ли в массиве с данными ключи, для которых нет свойств в модели
