# Installation

```bash
composer require troytft/mapper
```

# Usage
Создайте модель, наследующую интерфейс `Mapper\ModelInterface`.

```php
<?php

namespace Model;

use Mapper\Annotation as Mapper;
use Mapper\ModelInterface;

class Movie implements ModelInterface
{
    /**
     * @var string|null
     *
     * @Mapper\StringType()
     */
    private $name;

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }
}

```

В док блоке у свойств класса можно указать аннатоцию с одним из типов.

Далее наобходимо использовать маппер и передать в него модель и массив с данными:

```php
<?php

$mapperSettings = new Mapper\DTO\Settings();
$mapperSettings
    ->setIsPropertiesNullableByDefault(false)
    ->setIsAllowedUndefinedKeysInData(false);

$transformers = [
    new Mapper\Transformer\StringTransformer(),
    new Mapper\Transformer\FloatTransformer(),
    new Mapper\Transformer\IntegerTransformer(),
    new Mapper\Transformer\BooleanTransformer(),
];

$mapper = new Mapper\Mapper($mapperSettings, $transformers);

$model = new Model\Movie();
$data = [
    'name' => 'Taxi 2',
	'rating' => 6.5
];

$mapper->map($model, $data);

```

После выполнения – данные будут применены на модель, в случае ошибки будет выбрашено одно из исключений.

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

Для скалярных типов можно указывать свои трансформеры, либо создавать свои типы с заранее указаным трансформером.

Внутри трансформера можно выбрасывать исключения, наследующие интерфейс `Mapper\Exception\TransformerExceptionInterface`, такое исключение будет отловленно и вместо него будет выброшено `Mapper\Exception\Transformer\WrappedTransformerException` с установленным путем до свойства.

# Exceptions
Все исключения наследуют интерфейс `Mapper\ExceptionInterface`, возможные варианты:

* `Mapper\Exception\SetterDoesNotExistException` – в случае если не найден сеттер
* `Mapper\Exception\UndefinedTransformerException` – в случае если не найден трансформер
* `Mapper\Exception\Mapping\MappingValidationExceptionInterface` – в случае если в качестве значения свойства передан неверный тип данных, из исключения можно получить путь к свойству
* `Mapper\Exception\Transformer\WrappedTransformerException` – в случае если трансформер выбросил исключение, из исключения можно получить путь к свойству, а так же оригинальный эксепшен доступный через `getPrevious()`:
    * `Mapper\Exception\Transformer\StringRequiredException`
    * `Mapper\Exception\Transformer\IntegerRequiredException`
    * `Mapper\Exception\Transformer\BooleanRequiredException`
    * `Mapper\Exception\Transformer\FloatRequiredException`

# Settings
* `setIsPropertiesNullableByDefault` – значение по-умолчанию для параметра `nullable`
* `setIsAllowedUndefinedKeysInData` – разрешены ли в массиве с данными ключи, для которых нет свойств в модели
