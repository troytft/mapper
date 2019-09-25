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
