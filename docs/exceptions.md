# Exceptions

All exceptions implement  `Mapper\ExceptionInterface`

### Mapper\Exception\SetterDoesNotExistException 
In case setter doesn't exist

### Mapper\Exception\UndefinedTransformerException
In case transformer is undefined

### Mapper\Exception\MappingValidation\CollectionRequiredException
In case value for property isn't collection

Getters:
* **getPath()** – path to property as array
* **getPathAsString()** – path to property as string

### Mapper\Exception\MappingValidation\ScalarRequiredException
In case value for property isn't scalar

Getters:
* **getPath()** – path to property as array
* **getPathAsString()** – path to property as string

### Mapper\Exception\MappingValidation\ObjectRequiredException
In case value for property isn't object

Getters:
* **getPath()** – path to property as array
* **getPathAsString()** – path to property as string

### Mapper\Exception\MappingValidation\UndefinedKeyException
In case data contains key not defined in model

Getters:
* **getPath()** – path to property as array
* **getPathAsString()** – path to property as string

### Mapper\Exception\Transformer\WrappedTransformerException
Mapper wraps transformer exceptions with  `Mapper\Exception\Transformer\WrappedTransformerException`

Getters:
* **getPath()** – path to property as array
* **getPathAsString()** – path to property as string
* **getPrevious()** – original exception, exceptions implements `Mapper\Exception\Transformer\TransformerExceptionInterface`

Transformer Exceptions:

##### Mapper\Exception\Transformer\StringRequiredException
Value should be string

##### Mapper\Exception\Transformer\IntegerRequiredException
Value should be integer

##### Mapper\Exception\Transformer\BooleanRequiredException
Value should be boolean

##### Mapper\Exception\Transformer\FloatRequiredException
Value should be float

##### Mapper\Exception\Transformer\InvalidDateFormatException
Value should be date with format

##### Mapper\Exception\Transformer\InvalidDateTimeFormatException
Value should be datetime with format
