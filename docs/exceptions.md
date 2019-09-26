# Exceptions

Все исключения наследуют интерфейс `Mapper\ExceptionInterface`

### Mapper\Exception\SetterDoesNotExistException 
В случае если не найден сеттер

### Mapper\Exception\UndefinedTransformerException
В случае если не найден трансформер

### Mapper\Exception\MappingValidation\CollectionRequiredException
Значение должно быть коллекцией, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`

### Mapper\Exception\MappingValidation\ScalarRequiredException
Значение должно быть скаляром, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`

### Mapper\Exception\MappingValidation\ObjectRequiredException
Значение должно быть объектом, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`

### Mapper\Exception\MappingValidation\UndefinedKeyException
Данные содержать ключ, для которого не найдено свойство в модели, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`

### Mapper\Exception\Transformer\WrappedTransformerException
В случае если трансформер выбросил исключение, из исключения можно получить путь к свойству через `getPath()` или `getPathAsString()`, а так же оригинальный эксепшен доступный через `getPrevious()`

Оригинальный эксепшен имплементирует интерфейс `Mapper\Exception\Transformer\TransformerExceptionInterface`

Возможные варианты:

##### Mapper\Exception\Transformer\StringRequiredException
Значение должно быть строкой

##### Mapper\Exception\Transformer\IntegerRequiredException
Значение должно быть целым числом

##### Mapper\Exception\Transformer\BooleanRequiredException
Значение должно быть булем

##### Mapper\Exception\Transformer\FloatRequiredException
Значение должно быть десятичной дробью

##### Mapper\Exception\Transformer\InvalidDateFormatException
Значение не соответствует формату и не является датой

##### Mapper\Exception\Transformer\InvalidDateTimeFormatException
Значение не соответствует формату и не является датой
